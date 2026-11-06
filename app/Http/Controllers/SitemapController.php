<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
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
        $baseUrl = rtrim(url('/'), '/');
        $makeUrl = static function (string $path) use ($baseUrl): string {
            $path = trim($path, '/');

            return $path === '' ? $baseUrl . '/' : $baseUrl . '/' . $path . '/';
        };
        $lastModified = static function ($date): ?string {
            return $date ? Carbon::parse($date)->toDateString() : null;
        };

        // The FAQ page lives at the slug set in Admin → FAQ Page Settings, resolved
        // the same way as the catch-all route and the header link.
        $faqSlug = DB::table('homepage_contents')
            ->where('section', 'faq_page')
            ->where('field_key', 'faq_page_slug')
            ->value('value') ?: 'frequentlyAskedQuestions';

        $entries = collect([
            ['loc' => $makeUrl(''), 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => $makeUrl('about-us'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => $makeUrl('contact-us'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => $makeUrl('popular-products'), 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => $makeUrl('blog'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => $makeUrl(strtolower($faqSlug)), 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => $makeUrl('why-choose-us'), 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => $makeUrl('request-quote'), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ]);

        // Pages set to noindex in the admin must not be submitted to search engines.
        $homeRobots = DB::table('homepage_contents')->where('field_key', 'robots')->value('value');
        if (stripos((string) $homeRobots, 'noindex') === 0) {
            $entries->shift();
        }
        $indexable = static function ($query) {
            $query->where('robots', 'not like', 'noindex%');
        };

        $appendRecords = function ($records, string $prefix = '', string $priority = '0.7') use ($entries, $makeUrl, $lastModified) {
            foreach ($records as $record) {
                $entries->push([
                    'loc' => $makeUrl($prefix . $record->slug),
                    'lastmod' => $lastModified($record->updated_at ?? null),
                    'changefreq' => 'weekly',
                    'priority' => $priority,
                ]);
            }
        };

        $published = static function (string $table, ?\Closure $scope = null) {
            $query = DB::table($table)
                ->where('status', 'published')
                ->whereNotNull('slug')
                ->where('slug', '!=', '');
            if ($scope) {
                $scope($query);
            }

            return $query->get(['slug', 'updated_at']);
        };

        // Navigation-group categories (Industries, Box By Material, Box by Style)
        // only organise the menu and return 404, so keep them out of the sitemap.
        $appendRecords($published('admin_categories', static function ($query) use ($indexable) {
            $indexable($query);
            $query->where(function ($q) {
                $q->whereNull('is_nav_group')->orWhere('is_nav_group', 0);
            });
        }), '', '0.8');
        // A product sharing its slug with a category never gets a page: that URL serves the category.
        $appendRecords($published('admin_products', static function ($query) use ($indexable) {
            $indexable($query);
            $query->whereNotIn('slug', DB::table('admin_categories')->pluck('slug'));
        }), '', '0.9');
        $appendRecords($published('admin_pages', $indexable), '', '0.7');
        $appendRecords($published('admin_blogs', $indexable), 'blog/', '0.7');
        $appendRecords($published('admin_authors'), 'author/', '0.5');

        return response()
            ->view('sitemap-xml', ['entries' => $entries->unique('loc')->values()])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
