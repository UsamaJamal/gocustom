<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class SitemapController extends Controller
{
    /**
     * Content photos hard-coded in the homepage and fixed page templates. Logos, icons and
     * decoration are left out on purpose: they have no value in image search.
     */
    private const HOMEPAGE_IMAGES = [
        'uploads/see-feel-image.webp',
        'uploads/gloss-home.webp',
        'uploads/embossing-home.png',
        'uploads/debossing-home-img.webp',
        'uploads/matte-lamination.webp',
        'uploads/holographic-homepage.webp',
        'uploads/silver-foiling-home.jpg',
        'uploads/spot-uv-home.png',
        'uploads/gold-foiling-home.png',
        'uploads/custom-maroon-heart-chocolate-box.webp',
        'uploads/custom-navy-blue-rigid-gift-box.webp',
        'uploads/custom-green-gable-packaging-box.webp',
        'uploads/custom-cream-square-luxury-box.webp',
        'uploads/explore.webp',
        'uploads/choose.webp',
        'uploads/design.webp',
        'uploads/order-home-step.webp',
    ];

    private const FIXED_PAGE_IMAGES = [
        'about-us' => [
            'uploads/who-img-1.jpg',
            'uploads/who-img-2.jpg',
            'uploads/who-img-3.jpg',
            'uploads/who-img-4.jpg',
            'uploads/making-simple-img.jpg',
        ],
        'why-choose-us' => [
            'uploads/craftmenship.png',
            'uploads/sustainable-packaging.png',
            'uploads/faq-frequently-asked-questions.png',
        ],
        'request-quote' => [
            'uploads/Apparel Box .png',
        ],
    ];

    public function index()
    {
        $blogs = DB::table('admin_blogs')->get();
        $pages = DB::table('admin_pages')->get();
        
        $parentCategories = DB::table('admin_categories')->whereNull('parent_id')->get();
        $allCategories = DB::table('admin_categories')->whereNotNull('parent_id')->get();
        $allProducts = DB::table('admin_products')
            ->join('admin_category_product', 'admin_products.id', '=', 'admin_category_product.product_id')
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
                    $this->latestUpdate(DB::table('admin_categories')->whereIn('id', $settingIds('featured_categories'))),
                    $this->latestUpdate(DB::table('admin_products')->whereIn('id', $settingIds('bestseller_products'))),
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
        $entries = collect();
        $addPage = function (string $path, array $images, ?string $lastmod = null) use ($entries) {
            $urls = array_map(function ($image) {
                return $this->imageUrl($image);
            }, $images);
            $urls = array_values(array_unique(array_filter($urls)));

            if ($urls) {
                $entries->push(['loc' => $this->pageUrl($path), 'lastmod' => $lastmod, 'images' => $urls]);
            }
        };

        // Same fixed pages, noindex rules and lastmod as sitemap.xml.
        $fixedPages = collect($this->fixedPages())->keyBy('path');

        if ($fixedPages->has('')) {
            $homepageValue = static function (string $key) {
                return DB::table('homepage_contents')->where('field_key', $key)->value('value');
            };
            $featuredIds = (array) json_decode((string) $homepageValue('featured_categories'), true);

            $addPage('', array_merge(
                [$homepageValue('hero_image') ?: 'uploads/Home-Banner.webp'],
                self::HOMEPAGE_IMAGES,
                DB::table('admin_categories')->whereIn('id', $featuredIds)->pluck('image')->all()
            ), $fixedPages['']['lastmod']);
        }

        foreach (self::FIXED_PAGE_IMAGES as $path => $images) {
            if ($fixedPages->has($path)) {
                $addPage($path, $images, $fixedPages[$path]['lastmod']);
            }
        }

        foreach ($this->indexableRecords('admin_categories', ['slug', 'hero_image', 'description', 'feature_sections', 'updated_at', 'created_at']) as $category) {
            $features = (array) json_decode((string) $category->feature_sections, true);
            $addPage(
                $category->slug,
                array_merge([$category->hero_image], array_column($features, 'image'), $this->contentImages($category->description)),
                $this->latestDate($category->updated_at, $category->created_at)
            );
        }

        foreach ($this->indexableRecords('admin_products', ['slug', 'image', 'images', 'description', 'long_description', 'updated_at', 'created_at']) as $product) {
            $gallery = (array) json_decode((string) $product->images, true);
            $addPage(
                $product->slug,
                array_merge([$product->image], $gallery, $this->contentImages($product->description, $product->long_description)),
                $this->latestDate($product->updated_at, $product->created_at)
            );
        }

        foreach ($this->indexableRecords('admin_pages', ['slug', 'content', 'updated_at', 'created_at']) as $page) {
            $addPage($page->slug, $this->contentImages($page->content), $this->latestDate($page->updated_at, $page->created_at));
        }

        foreach ($this->indexableRecords('admin_blogs', ['slug', 'image', 'content', 'updated_at', 'created_at']) as $blog) {
            $addPage(
                'blog/' . $blog->slug,
                array_merge([$blog->image], $this->contentImages($blog->content)),
                $this->latestDate($blog->updated_at, $blog->created_at)
            );
        }

        foreach ($this->indexableRecords('admin_authors', ['slug', 'image', 'updated_at', 'created_at']) as $author) {
            $addPage('author/' . $author->slug, [$author->image], $this->latestDate($author->updated_at, $author->created_at));
        }

        return response()
            ->view('sitemap-images-xml', ['entries' => $this->mergeDuplicates($entries)])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
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
