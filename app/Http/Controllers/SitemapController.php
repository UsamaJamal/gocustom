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
        // The FAQ page lives at the slug set in Admin → FAQ Page Settings, resolved
        // the same way as the catch-all route and the header link.
        $faqSlug = DB::table('homepage_contents')
            ->where('section', 'faq_page')
            ->where('field_key', 'faq_page_slug')
            ->value('value') ?: 'frequentlyAskedQuestions';

        $entries = collect([
            ['loc' => $this->pageUrl(''), 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => $this->pageUrl('about-us'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => $this->pageUrl('contact-us'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => $this->pageUrl('popular-products'), 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => $this->pageUrl('blog'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => $this->pageUrl(strtolower($faqSlug)), 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => $this->pageUrl('why-choose-us'), 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => $this->pageUrl('request-quote'), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ]);

        if (!$this->homepageIsIndexable()) {
            $entries->shift();
        }

        $appendRecords = function ($records, string $prefix = '', string $priority = '0.7') use ($entries) {
            foreach ($records as $record) {
                $entries->push([
                    'loc' => $this->pageUrl($prefix . $record->slug),
                    'lastmod' => $this->lastModified($record->updated_at ?? null),
                    'changefreq' => 'weekly',
                    'priority' => $priority,
                ]);
            }
        };

        $columns = ['slug', 'updated_at'];
        $appendRecords($this->indexableRecords('admin_categories', $columns), '', '0.8');
        $appendRecords($this->indexableRecords('admin_products', $columns), '', '0.9');
        $appendRecords($this->indexableRecords('admin_pages', $columns), '', '0.7');
        $appendRecords($this->indexableRecords('admin_blogs', $columns), 'blog/', '0.7');
        $appendRecords($this->indexableRecords('admin_authors', $columns), 'author/', '0.5');

        return response()
            ->view('sitemap-xml', ['entries' => $entries->unique('loc')->values()])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
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

        if ($this->homepageIsIndexable()) {
            $homepageValue = static function (string $key) {
                return DB::table('homepage_contents')->where('field_key', $key)->value('value');
            };
            $featuredIds = (array) json_decode((string) $homepageValue('featured_categories'), true);

            $addPage('', array_merge(
                [$homepageValue('hero_image') ?: 'uploads/Home-Banner.webp'],
                self::HOMEPAGE_IMAGES,
                DB::table('admin_categories')->whereIn('id', $featuredIds)->pluck('image')->all()
            ));
        }

        foreach (self::FIXED_PAGE_IMAGES as $path => $images) {
            $addPage($path, $images);
        }

        foreach ($this->indexableRecords('admin_categories', ['slug', 'hero_image', 'description', 'feature_sections', 'updated_at']) as $category) {
            $features = (array) json_decode((string) $category->feature_sections, true);
            $addPage(
                $category->slug,
                array_merge([$category->hero_image], array_column($features, 'image'), $this->contentImages($category->description)),
                $this->lastModified($category->updated_at)
            );
        }

        foreach ($this->indexableRecords('admin_products', ['slug', 'image', 'images', 'description', 'long_description', 'updated_at']) as $product) {
            $gallery = (array) json_decode((string) $product->images, true);
            $addPage(
                $product->slug,
                array_merge([$product->image], $gallery, $this->contentImages($product->description, $product->long_description)),
                $this->lastModified($product->updated_at)
            );
        }

        foreach ($this->indexableRecords('admin_pages', ['slug', 'content', 'updated_at']) as $page) {
            $addPage($page->slug, $this->contentImages($page->content), $this->lastModified($page->updated_at));
        }

        foreach ($this->indexableRecords('admin_blogs', ['slug', 'image', 'content', 'updated_at']) as $blog) {
            $addPage(
                'blog/' . $blog->slug,
                array_merge([$blog->image], $this->contentImages($blog->content)),
                $this->lastModified($blog->updated_at)
            );
        }

        foreach ($this->indexableRecords('admin_authors', ['slug', 'image', 'updated_at']) as $author) {
            $addPage('author/' . $author->slug, [$author->image], $this->lastModified($author->updated_at));
        }

        return response()
            ->view('sitemap-images-xml', ['entries' => $entries->unique('loc')->values()])
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

    private function lastModified($date): ?string
    {
        return $date ? Carbon::parse($date)->toDateString() : null;
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
            $query->where('robots', 'not like', 'noindex%');
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
