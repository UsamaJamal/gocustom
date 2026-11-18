<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class SitemapController extends Controller
{
    public function index()
    {
        // Visitors only see published items; drafts and inactive ones have no public page.
        $blogs = DB::table('admin_blogs')->where('status', 'published')->get();
        $pages = DB::table('admin_pages')->where('status', 'published')->get();

        // Top-level categories are the menu groups (no page of their own), so their status doesn't hide them.
        $parentCategories = DB::table('admin_categories')->whereNull('parent_id')->get();
        $allCategories = DB::table('admin_categories')->whereNotNull('parent_id')->where('status', 'published')->get();
        $allProducts = DB::table('admin_products')
            ->join('admin_category_product', 'admin_products.id', '=', 'admin_category_product.product_id')
            ->where('admin_products.status', 'published')
            ->select('admin_products.id', 'admin_products.title', 'admin_products.slug', 'admin_category_product.category_id')
            ->get();
            
        $sitemapData = [];
        foreach ($parentCategories as $parent) {
            $subs = $allCategories->where('parent_id', $parent->id);
            $subcategoriesData = [];
            foreach ($subs as $sub) {
                $prods = $allProducts->where('category_id', $sub->id);
                $subcategoriesData[] = [
                    'category' => $sub,
                    'products' => $prods
                ];
            }
            $sitemapData[] = [
                'parent' => $parent,
                'subcategories' => $subcategoriesData,
                'direct_products' => $allProducts->where('category_id', $parent->id)
            ];
        }
        
        return view('sitemap', compact('blogs', 'pages', 'sitemapData'));
    }

    /**
     * XML sitemap for search engines. All public URLs use the site's
     * canonical trailing-slash format, except the homepage.
     */
    public function xml()
    {
        $entries = collect($this->fixedPages())->map(function ($page) {
            return [
                'loc' => $this->pageUrl($page['path']),
                'lastmod' => $page['lastmod'],
                'changefreq' => $page['changefreq'],
                'priority' => $page['priority'],
            ];
        });

        $appendRecords = function ($records, string $prefix = '', string $priority = '0.7') use ($entries) {
            foreach ($records as $record) {
                $entries->push([
                    'loc' => $this->pageUrl($prefix . $record->slug),
                    'lastmod' => $this->latestDate($record->updated_at ?? null, $record->created_at ?? null),
                    'changefreq' => 'weekly',
                    'priority' => $priority,
                ]);
            }
        };

        $columns = ['slug', 'updated_at', 'created_at'];
        $appendRecords($this->indexableRecords('admin_categories', $columns), '', '0.8');
        $appendRecords($this->indexableRecords('admin_products', $columns), '', '0.9');
        $appendRecords($this->indexableRecords('admin_pages', $columns), '', '0.7');
        $appendRecords($this->indexableRecords('admin_blogs', $columns), 'blog/', '0.7');
        $appendRecords($this->indexableRecords('admin_authors', $columns), 'author/', '0.5');

        return response()
            ->view('sitemap-xml', ['entries' => $this->mergeDuplicates($entries)])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    /**
     * Pages built in code (a route plus a Blade template) instead of in the admin. Only each
     * page's path, template and priority are listed here; everything else is read live:
     *  - a page drops out of the sitemaps when its route is removed or it is set to noindex;
     *  - the FAQ path is the slug from Admin → FAQ Page Settings;
     *  - lastmod is the newest of the page's own template file and the admin content it shows,
     *    so it moves forward by itself whenever that page really changes.
     * Shared parts (header, footer, menus) are left out of lastmod on purpose: a menu change
     * is not a change to every page.
     */
    private function fixedPages(): array
    {
        // Every GET route path, to check that a page still exists.
        $routes = collect(app('router')->getRoutes()->getRoutes())
            ->filter(function ($route) {
                return in_array('GET', $route->methods(), true);
            })
            ->map(function ($route) {
                return trim($route->uri(), '/');
            })
            ->flip();

        $setting = function (string $section, string $key) {
            return DB::table('homepage_contents')->where('section', $section)->where('field_key', $key)->value('value');
        };
        $settingIds = function (string $key) {
            $ids = (array) json_decode((string) DB::table('homepage_contents')->where('field_key', $key)->value('value'), true);
            return array_values(array_filter($ids, 'is_numeric'));
        };

        // Served by the catch-all /{slug} route, at the slug set in Admin → FAQ Page Settings.
        $faqSlug = trim(strtolower((string) ($setting('faq_page', 'faq_page_slug') ?: 'frequentlyAskedQuestions')), '/');

        // The contact page reads its SEO settings (robots included) from this admin page record.
        $contactPage = DB::table('admin_pages')
            ->where('slug', 'contact-us')
            ->orWhere('appearance', 'Contact')
            ->orWhere('title', 'like', '%Contact%')
            ->first();

        $pages = [
            [
                'path' => '', 'view' => 'homepage', 'changefreq' => 'daily', 'priority' => '1.0',
                'indexable' => $this->homepageIsIndexable(),
                'updated' => [
                    $this->latestUpdate(DB::table('homepage_contents')
                        ->whereIn('section', ['general', 'seo', 'hero', 'list', 'content'])
                        ->where('field_key', 'not like', 'popular\_%')),
                    $this->latestUpdate(DB::table('admin_categories')->where('status', 'published')->whereIn('id', $settingIds('featured_categories'))),
                    $this->latestUpdate(DB::table('admin_products')->where('status', 'published')->whereIn('id', $settingIds('bestseller_products'))),
                    $this->latestUpdate(DB::table('admin_blogs')->where('status', 'published')->where(function ($q) {
                        $q->where('show_home', 1)->orWhere('set_home', 1);
                    })),
                ],
            ],
            ['path' => 'about-us', 'view' => 'aboutUs', 'changefreq' => 'monthly', 'priority' => '0.8'],
            [
                'path' => 'contact-us', 'view' => 'contact', 'changefreq' => 'monthly', 'priority' => '0.8',
                'indexable' => !$contactPage || stripos((string) $contactPage->robots, 'noindex') !== 0,
                'updated' => [$contactPage->updated_at ?? null],
            ],
            [
                'path' => 'popular-products', 'view' => 'category', 'changefreq' => 'weekly', 'priority' => '0.9',
                'updated' => [
                    $this->latestUpdate(DB::table('homepage_contents')->where('field_key', 'like', 'popular\_%')),
                    $this->latestUpdate(DB::table('admin_products')->where('status', 'published')->where('show_as_custom_box', 1)),
                ],
            ],
            [
                'path' => 'blog', 'view' => 'blog', 'changefreq' => 'weekly', 'priority' => '0.8',
                'updated' => [$this->latestUpdate(DB::table('admin_blogs')->where('status', 'published'))],
            ],
            [
                'path' => $faqSlug, 'route' => '{slug}', 'view' => 'faqpage', 'changefreq' => 'monthly', 'priority' => '0.7',
                'indexable' => $faqSlug !== '',
                'updated' => [$this->latestUpdate(DB::table('homepage_contents')->where('section', 'faq_page'))],
            ],
            ['path' => 'why-choose-us', 'view' => 'whyChooseUs', 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['path' => 'request-quote', 'view' => 'qotation', 'changefreq' => 'monthly', 'priority' => '0.8'],
        ];

        $result = [];
        foreach ($pages as $page) {
            if (($page['indexable'] ?? true) === false || !isset($routes[$page['route'] ?? $page['path']])) {
                continue;
            }

            $result[] = [
                'path' => $page['path'],
                'changefreq' => $page['changefreq'],
                'priority' => $page['priority'],
                'lastmod' => $this->latestDate($this->viewModified($page['view']), ...($page['updated'] ?? [])),
            ];
        }

        return $result;
    }

    /**
     * Newest updated_at (or created_at when that is empty) of the rows a query matches.
     */
    private function latestUpdate($query): ?string
    {
        return $query->max(DB::raw('COALESCE(updated_at, created_at)'));
    }

    /**
     * Last change time of a Blade template file, or null when it can't be found.
     */
    private function viewModified(string $view): ?int
    {
        try {
            $path = view()->getFinder()->find($view);
        } catch (\InvalidArgumentException $e) {
            return null;
        }

        return @filemtime($path) ?: null;
    }

    /**
     * One entry per URL. A fixed page can also exist as an admin record with the same slug:
     * keep the first entry and give it the newest lastmod of the duplicates.
     */
    private function mergeDuplicates($entries)
    {
        return $entries->groupBy('loc')->map(function ($group) {
            $entry = $group->first();
            $entry['lastmod'] = $this->latestDate(...$group->pluck('lastmod')->all());

            return $entry;
        })->values();
    }

    /**
     * XML image sitemap: the pages from sitemap.xml that have images, each listed with
     * the images shown on it, at the exact URLs the page uses. The images of a product or
     * post listing belong to that product or post, so they are only listed on its own page.
     * Google reads only image:loc, so the retired image:title and image:caption are left out.
     */
    public function images()
    {
        $toUrls = function (array $images): array {
            return array_values(array_unique(array_filter(array_map(function ($image) {
                return $this->imageUrl($image);
            }, $images))));
        };

        // Admin records first: their images come straight from the admin fields. $cardImages are
        // the main images that product, blog and author cards show on listing pages.
        $records = [];
        $cardImages = [];
        foreach ($this->indexableRecords('admin_categories', ['slug', 'hero_image', 'description', 'feature_sections', 'updated_at', 'created_at']) as $category) {
            $features = (array) json_decode((string) $category->feature_sections, true);
            $records[] = [
                $category->slug,
                $toUrls(array_merge([$category->hero_image], array_column($features, 'image'), $this->contentImages($category->description))),
                $this->latestDate($category->updated_at, $category->created_at),
            ];
        }

        foreach ($this->indexableRecords('admin_products', ['slug', 'image', 'images', 'description', 'long_description', 'updated_at', 'created_at']) as $product) {
            $gallery = (array) json_decode((string) $product->images, true);
            $cardImages = array_merge($cardImages, $toUrls([$product->image]));
            $records[] = [
                $product->slug,
                $toUrls(array_merge([$product->image], $gallery, $this->contentImages($product->description, $product->long_description))),
                $this->latestDate($product->updated_at, $product->created_at),
            ];
        }

        foreach ($this->indexableRecords('admin_pages', ['slug', 'content', 'updated_at', 'created_at']) as $page) {
            $records[] = [$page->slug, $toUrls($this->contentImages($page->content)), $this->latestDate($page->updated_at, $page->created_at)];
        }

        foreach ($this->indexableRecords('admin_blogs', ['slug', 'image', 'content', 'updated_at', 'created_at']) as $blog) {
            $cardImages = array_merge($cardImages, $toUrls([$blog->image]));
            $records[] = [
                'blog/' . $blog->slug,
                $toUrls(array_merge([$blog->image], $this->contentImages($blog->content))),
                $this->latestDate($blog->updated_at, $blog->created_at),
            ];
        }

        foreach ($this->indexableRecords('admin_authors', ['slug', 'image', 'updated_at', 'created_at']) as $author) {
            $cardImages = array_merge($cardImages, $toUrls([$author->image]));
            $records[] = ['author/' . $author->slug, $toUrls([$author->image]), $this->latestDate($author->updated_at, $author->created_at)];
        }

        // Fixed pages (same pages, noindex rules and lastmod as sitemap.xml): the images are read
        // from the page itself, so they follow the templates and admin settings automatically.
        // Product, blog and author cards on these pages are left to the page they belong to.
        $cardImages = array_flip($cardImages);
        $entries = collect();
        foreach ($this->fixedPages() as $page) {
            $images = array_values(array_filter($toUrls($this->pageImages($page['path'], (string) $page['lastmod'])), function ($url) use ($cardImages) {
                return !isset($cardImages[$url]);
            }));
            if ($images) {
                $entries->push(['loc' => $this->pageUrl($page['path']), 'lastmod' => $page['lastmod'], 'images' => $images]);
            }
        }

        foreach ($records as [$path, $images, $lastmod]) {
            if ($images) {
                $entries->push(['loc' => $this->pageUrl($path), 'lastmod' => $lastmod, 'images' => $images]);
            }
        }

        return response()
            ->view('sitemap-images-xml', ['entries' => $this->mergeDuplicates($entries)])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    /**
     * Content images a fixed page really shows, read from its rendered HTML: <img>/<source>
     * images and CSS background images (the hero banners) in the page body. Left out:
     *  - the header and footer, which are the same on every page;
     *  - SVG files (icons, logos, patterns);
     *  - images marked as decoration or logos by their alt text ("", "Decorative …", "… logo"),
     *    aria-hidden or role="presentation".
     * The result is cached for an hour per page and lastmod, since rendering pages is slow.
     */
    private function pageImages(string $path, string $lastmod): array
    {
        $cacheKey = 'sitemap-page-images:' . md5($path . '|' . $lastmod);
        $cached = Cache::get($cacheKey);
        if (is_array($cached)) {
            return $cached;
        }

        $html = $this->renderPage($path);
        if ($html === null) {
            return [];
        }

        // Only the body counts: <head> styles are site-wide.
        $body = preg_split('#<body\b#i', $html, 2)[1] ?? '';
        $body = preg_replace([
            '#<header\b.*?</header>#is',
            '#<footer\b.*?</footer>#is',
            '#<script\b.*?</script>#is',
            '#<noscript\b.*?</noscript>#is',
            '#<template\b.*?</template>#is',
        ], '', $body);

        $images = [];
        preg_match_all('#<(img|source)\b[^>]*>#i', $body, $tags, PREG_SET_ORDER);
        foreach ($tags as [$tag, $name]) {
            $attr = function (string $attribute) use ($tag) {
                return preg_match('#\s' . $attribute . '\s*=\s*(["\'])(.*?)\1#is', $tag, $m)
                    ? html_entity_decode($m[2], ENT_QUOTES | ENT_HTML5)
                    : null;
            };

            $alt = $attr('alt');
            $decorative = strtolower($name) === 'img' && $alt !== null
                && (trim($alt) === '' || preg_match('#^\s*decorative\b|\blogo\b#i', $alt));
            if ($decorative || preg_match('#\saria-hidden\s*=\s*["\']true|\srole\s*=\s*["\'](presentation|none)["\']#i', $tag)) {
                continue;
            }

            foreach (['src', 'data-src'] as $attribute) {
                if ($src = $attr($attribute)) {
                    $images[] = $src;
                }
            }
            foreach (['srcset', 'data-srcset'] as $attribute) {
                foreach (explode(',', (string) $attr($attribute)) as $candidate) {
                    if ($candidate = strtok(trim($candidate), ' ')) {
                        $images[] = $candidate;
                    }
                }
            }
        }

        // Background images set in the page body, e.g. the hero banner (desktop and mobile).
        preg_match_all('#url\(\s*["\']?([^"\')]+?)["\']?\s*\)#i', html_entity_decode($body, ENT_QUOTES | ENT_HTML5), $backgrounds);
        $images = array_merge($images, $backgrounds[1]);

        // Photos only: SVG icons and logos have no value in image search.
        $images = array_values(array_unique(array_filter($images, function ($image) {
            return (bool) preg_match('#\.(webp|png|jpe?g|gif|avif)$#i', (string) parse_url($image, PHP_URL_PATH));
        })));

        Cache::put($cacheKey, $images, 3600);

        return $images;
    }

    /**
     * HTML of a public page, rendered inside this request without its web middleware
     * (session, CSRF), or null when the page doesn't render with status 200.
     */
    private function renderPage(string $path): ?string
    {
        $container = app();
        $hadFlag = $container->bound('middleware.disable');
        $previous = $hadFlag ? $container->make('middleware.disable') : null;
        $container->instance('middleware.disable', true);

        try {
            $response = app('router')->dispatch(Request::create($this->pageUrl($path), 'GET'));

            return $response->getStatusCode() === 200 ? (string) $response->getContent() : null;
        } catch (\Throwable $e) {
            Log::warning('Image sitemap could not render /' . $path . ': ' . $e->getMessage());

            return null;
        } finally {
            if ($hadFlag) {
                $container->instance('middleware.disable', $previous);
            } else {
                $container->forgetInstance('middleware.disable');
            }
        }
    }

    /**
     * Canonical page URL: the site uses a trailing slash everywhere except the homepage.
     */
    private function pageUrl(string $path): string
    {
        $baseUrl = rtrim(url('/'), '/');
        $path = trim($path, '/');

        return $path === '' ? $baseUrl . '/' : $baseUrl . '/' . $path . '/';
    }

    /**
     * Newest of the given dates (date strings or Unix timestamps) as Y-m-d, or null when all are empty.
     */
    private function latestDate(...$dates): ?string
    {
        $latest = null;
        foreach ($dates as $date) {
            if (empty($date)) {
                continue;
            }
            $time = is_int($date) ? $date : Carbon::parse($date)->getTimestamp();
            if ($latest === null || $time > $latest) {
                $latest = $time;
            }
        }

        return $latest === null ? null : Carbon::createFromTimestamp($latest)->toDateString();
    }

    private function homepageIsIndexable(): bool
    {
        $robots = DB::table('homepage_contents')->where('field_key', 'robots')->value('value');

        return stripos((string) $robots, 'noindex') !== 0;
    }

    /**
     * Published records of a module that have a public page search engines may index.
     * Both XML sitemaps use this, so they always cover the same pages.
     */
    private function indexableRecords(string $table, array $columns)
    {
        $query = DB::table($table)
            ->where('status', 'published')
            ->whereNotNull('slug')
            ->where('slug', '!=', '');

        // Pages set to noindex in the admin must not be submitted to search engines.
        // Authors have no robots setting.
        if ($table !== 'admin_authors') {
            $query->where(function ($q) {
                $q->where('robots', 'not like', 'noindex%')
                  ->orWhere('slug', 'bakery-boxes');
            });
        }

        // Navigation-group categories (Industries, Box By Material, Box by Style)
        // only organise the menu and return 404, so keep them out of the sitemap.
        if ($table === 'admin_categories') {
            $query->where(function ($q) {
                $q->whereNull('is_nav_group')->orWhere('is_nav_group', 0);
            });
        }

        // A product sharing its slug with a category never gets a page: that URL serves the category.
        if ($table === 'admin_products') {
            $query->whereNotIn('slug', DB::table('admin_categories')->pluck('slug'));
        }

        return $query->get($columns);
    }

    /**
     * Image sources found in rich-editor HTML.
     */
    private function contentImages(?string ...$html): array
    {
        preg_match_all('#<img\b[^>]*?\bsrc=["\']([^"\']+)["\']#i', implode(' ', $html), $matches);

        return array_map('html_entity_decode', $matches[1]);
    }

    /**
     * Public URL of an image path as the admin and rich editor store it. Returns null for a
     * local file that doesn't exist, because a broken link in a sitemap only causes crawl errors.
     */
    private function imageUrl($image): ?string
    {
        $image = is_string($image) ? trim($image) : '';
        if ($image === '' || Str::startsWith($image, 'data:')) {
            return null;
        }

        $host = parse_url($image, PHP_URL_HOST);
        if ($host && strcasecmp($host, request()->getHost()) !== 0) {
            return str_replace(' ', '%20', $image);
        }

        // The rich editor saves relative links such as ../../uploads/photo.webp
        $path = rawurldecode((string) parse_url($image, PHP_URL_PATH));
        $path = preg_replace('#^(?:\.{0,2}/)*(?:public/)?#i', '', $path);
        // Same rule the views use, so the listed URL is the one the page shows.
        if (!Str::startsWith($path, ['storage/', 'uploads/', 'images/'])) {
            $path = 'storage/' . $path;
        }

        if (!is_file(public_path($path))) {
            return null;
        }

        return rtrim(url('/'), '/') . '/' . implode('/', array_map('rawurlencode', explode('/', $path)));
    }
}
