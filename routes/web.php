<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\WhyChooseUsController;
use App\Http\Controllers\FrequentlyAskedQuestionController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AdminContentController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\SitemapController;
Route::get('/', function () {
    $settings = (new \App\Http\Controllers\AdminHomepageController())->loadSettings();
    $categories = DB::table('admin_categories')->get()->map(fn($r)=>(array)$r)->all();
    $products = DB::table('admin_products')->get()->map(fn($r)=>(array)$r)->all();
    $recentBlogs = DB::table('admin_blogs')
        ->leftJoin('admin_authors', 'admin_blogs.author_id', '=', 'admin_authors.id')
        ->select('admin_blogs.*', DB::raw('COALESCE(NULLIF(admin_authors.title, ""), NULLIF(admin_blogs.author_name, "")) as author_name'), 'admin_authors.slug as author_slug')
        ->where('admin_blogs.status', 'published')
        ->whereNotNull('admin_blogs.image')
        ->where('admin_blogs.image', '!=', '')
        ->where(function ($query) {
            $query->where('admin_blogs.show_home', 1)
                  ->orWhere('admin_blogs.set_home', 1);
        })
        ->orderByDesc('admin_blogs.set_home')
        ->orderByDesc('admin_blogs.publish_date')
        ->orderByDesc('admin_blogs.created_at')
        ->limit(4)->get();
    return view('homepage', compact('settings', 'categories', 'products', 'recentBlogs'));
});

Route::get('/search', function (\Illuminate\Http\Request $request) {
    $q = $request->input('q');
    $products = [];
    $categories = [];
    $blogs = [];
    $totalCount = 0;

    if ($q) {
        $products = DB::table('admin_products')
            ->where('title', 'like', "%{$q}%")
            ->orWhere('description', 'like', "%{$q}%")
            ->get()->map(fn($r)=>(array)$r)->all();

        if (count($products) === 0) {
            return redirect('/request-quote?from_search=1&box_style=' . urlencode(ucfirst(strtolower(trim($q)))));
        }
            
        $categories = DB::table('admin_categories')
            ->where('title', 'like', "%{$q}%")
            ->orWhere('description', 'like', "%{$q}%")
            ->get()->map(fn($r)=>(array)$r)->all();
            
        $blogs = DB::table('admin_blogs')
            ->where(function($bQuery) use ($q) {
                $bQuery->where('title', 'like', "%{$q}%")
                       ->orWhere('content', 'like', "%{$q}%");
            })
            ->where('status', 'published')
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->get()->map(fn($r)=>(array)$r)->all();
            
        $totalCount = count($products) + count($categories) + count($blogs);
    }
    
    return view('search', compact('q', 'products', 'categories', 'blogs', 'totalCount'));
});

// 410 Gone rules for permanently removed spam / prize URLs
Route::any('/prize/{any?}', function () {
    abort(410, 'Gone');
})->where('any', '.*');

Route::any('/delivery-information.php', function () {
    abort(410, 'Gone');
});

Route::any('/delivery-information', function () {
    abort(410, 'Gone');
});

Route::get('/product', function () {
    return redirect('/', 301);
});
Route::get('/product/{slug}', function ($slug) {
    return redirect('/' . $slug, 301);
});

// A category-style listing for products selected as Popular Product in the admin panel.
Route::get('/popular-products/', function () {
    $popularSettings = (new \App\Http\Controllers\AdminHomepageController())->loadSettings();
    $popularProducts = DB::table('admin_products')
        ->where('status', 'published')
        ->where('show_as_custom_box', 1)
        ->orderBy('id')
        ->get()
        ->map(fn ($product) => (array) $product)
        ->all();

    $category = [
        'title' => 'Popular Products',
        'slug' => 'popular-products',
        'meta_title' => $popularSettings['popular_meta_title'] ?: 'Popular Custom Packaging Products | Go Custom Boxes',
        'meta_description' => $popularSettings['popular_meta_description'] ?: 'Explore our popular custom packaging products and find the right box for your brand.',
        'meta_keywords' => $popularSettings['popular_meta_keywords'] ?? '',
        'hero_title' => $popularSettings['popular_hero_title'] ?: 'Popular Custom Packaging Products',
        'hero_badge' => 'Popular Products',
        'hero_description' => $popularSettings['popular_hero_description'] ?? '',
        'hero_image' => $popularSettings['popular_hero_image'] ?: ($popularProducts[0]['image'] ?? 'uploads/Home-Banner.webp'),
        'hero_primary_button_text' => $popularSettings['popular_hero_primary_button_text'] ?: 'Get Instant Quote',
        'hero_primary_button_url' => $popularSettings['popular_hero_primary_button_url'] ?: '/request-quote/',
        'products_heading' => 'Popular Products',
        'products_description' => 'Explore our most popular custom packaging solutions for every product and brand.',
        'feature_sections' => '[]',
        'content_section' => $popularSettings['popular_content_section'] ?? '',
    ];

    return view('category', [
        'slug' => 'popular-products',
        'category' => $category,
        'categories' => [],
        'products' => $popularProducts,
        'faqs' => $popularSettings['popular_faqs'] ?? [],
    ]);
});

Route::get('/contact-us/', function () {
    return view('contact');
});

Route::get('/blog', function () {
    $blogs = DB::table('admin_blogs')
        ->leftJoin('admin_authors', 'admin_blogs.author_id', '=', 'admin_authors.id')
        ->select('admin_blogs.*', DB::raw('COALESCE(NULLIF(admin_authors.title, ""), NULLIF(admin_blogs.author_name, "")) as author_name'), 'admin_authors.image as author_image', 'admin_authors.slug as author_slug')
        ->where('admin_blogs.status', 'published')
        ->whereNotNull('admin_blogs.image')
        ->where('admin_blogs.image', '!=', '')
        ->orderByDesc('admin_blogs.id')
        ->get()->map(fn($r) => (array) $r)->all();
    return view('blog', compact('blogs'));
});

Route::get('/blog-detail', function (Illuminate\Http\Request $request) {
    $slug = $request->query('slug');
    if (!$slug) {
        abort(404);
    }
    $blog = DB::table('admin_blogs')
        ->leftJoin('admin_authors', 'admin_blogs.author_id', '=', 'admin_authors.id')
        ->select(
            'admin_blogs.*',
            DB::raw('COALESCE(NULLIF(admin_authors.title, ""), NULLIF(admin_blogs.author_name, "")) as author_name'),
            'admin_authors.title as joined_author_name',
            'admin_authors.designation as author_designation',
            'admin_authors.designation as joined_author_designation',
            'admin_authors.bio as author_bio',
            'admin_authors.bio as joined_author_bio',
            'admin_authors.toc_title as author_toc_title',
            'admin_authors.toc_title as joined_author_toc_title',
            'admin_authors.image as author_image',
            'admin_authors.image as joined_author_image',
            'admin_authors.description as author_description',
            'admin_authors.description as joined_author_desc',
            'admin_authors.facebook as author_facebook',
            'admin_authors.facebook as joined_author_facebook',
            'admin_authors.twitter as author_twitter',
            'admin_authors.twitter as joined_author_twitter',
            'admin_authors.linkedin as author_linkedin',
            'admin_authors.linkedin as joined_author_linkedin',
            'admin_authors.slug as author_slug',
            'admin_authors.slug as joined_author_slug'
        )
        ->where('admin_blogs.slug', $slug)
        ->first();
    if (!$blog) {
        abort(404);
    }
    if (($blog->status ?? 'published') !== 'published' && !Illuminate\Support\Facades\Auth::check() && !session('admin_logged_in')) {
        abort(404);
    }
    $blog = (array) $blog;
    $currentId = $blog['id'] ?? null;
    $relatedIds = [];
    if (!empty($blog['related'])) {
        $decoded = is_string($blog['related']) ? json_decode($blog['related'], true) : $blog['related'];
        $relatedIds = array_values(array_filter(array_map('intval', (array) ($decoded ?? []))));
    }

    $recentBlogs = collect();
    if (!empty($relatedIds)) {
        $explicitQuery = DB::table('admin_blogs')
            ->leftJoin('admin_authors', 'admin_blogs.author_id', '=', 'admin_authors.id')
            ->select('admin_blogs.*', 'admin_authors.title as joined_author_name', DB::raw('COALESCE(NULLIF(admin_authors.title, ""), NULLIF(admin_blogs.author_name, "")) as author_name'), 'admin_authors.slug as joined_author_slug', 'admin_authors.slug as author_slug')
            ->whereIn('admin_blogs.id', $relatedIds)
            ->where('admin_blogs.status', 'published')
            ->whereNotNull('admin_blogs.image')
            ->where('admin_blogs.image', '!=', '');
        if ($currentId) {
            $explicitQuery->where('admin_blogs.id', '!=', $currentId);
        }
        $fetched = $explicitQuery->get()->keyBy('id');
        foreach ($relatedIds as $rid) {
            if (isset($fetched[$rid])) {
                $recentBlogs->push($fetched[$rid]);
            }
        }
    }

    $faqs = [];
    if (isset($blog['faqs']) && $blog['faqs'] !== null && $blog['faqs'] !== '') {
        $faqs = is_string($blog['faqs']) ? (json_decode($blog['faqs'], true) ?: []) : (array) $blog['faqs'];
    }
    $blogFaqs = $faqs;
    return view('blog-detail', compact('blog', 'recentBlogs', 'faqs', 'blogFaqs'));
});

Route::get('/blog/{slug}', function ($slug) {
    $blog = DB::table('admin_blogs')
        ->leftJoin('admin_authors', 'admin_blogs.author_id', '=', 'admin_authors.id')
        ->select(
            'admin_blogs.*',
            DB::raw('COALESCE(NULLIF(admin_authors.title, ""), NULLIF(admin_blogs.author_name, "")) as author_name'),
            'admin_authors.title as joined_author_name',
            'admin_authors.designation as author_designation',
            'admin_authors.designation as joined_author_designation',
            'admin_authors.bio as author_bio',
            'admin_authors.bio as joined_author_bio',
            'admin_authors.toc_title as author_toc_title',
            'admin_authors.toc_title as joined_author_toc_title',
            'admin_authors.image as author_image',
            'admin_authors.image as joined_author_image',
            'admin_authors.description as author_description',
            'admin_authors.description as joined_author_desc',
            'admin_authors.facebook as author_facebook',
            'admin_authors.facebook as joined_author_facebook',
            'admin_authors.twitter as author_twitter',
            'admin_authors.twitter as joined_author_twitter',
            'admin_authors.linkedin as author_linkedin',
            'admin_authors.linkedin as joined_author_linkedin',
            'admin_authors.slug as author_slug',
            'admin_authors.slug as joined_author_slug'
        )
        ->where('admin_blogs.slug', $slug)
        ->first();
    if (!$blog) {
        abort(404);
    }
    if (($blog->status ?? 'published') !== 'published' && !Illuminate\Support\Facades\Auth::check() && !session('admin_logged_in')) {
        abort(404);
    }
    $blog = (array) $blog;
    $currentId = $blog['id'] ?? null;
    $relatedIds = [];
    if (!empty($blog['related'])) {
        $decoded = is_string($blog['related']) ? json_decode($blog['related'], true) : $blog['related'];
        $relatedIds = array_values(array_filter(array_map('intval', (array) ($decoded ?? []))));
    }

    $recentBlogs = collect();
    if (!empty($relatedIds)) {
        $explicitQuery = DB::table('admin_blogs')
            ->leftJoin('admin_authors', 'admin_blogs.author_id', '=', 'admin_authors.id')
            ->select('admin_blogs.*', 'admin_authors.title as joined_author_name', DB::raw('COALESCE(NULLIF(admin_authors.title, ""), NULLIF(admin_blogs.author_name, "")) as author_name'), 'admin_authors.slug as joined_author_slug', 'admin_authors.slug as author_slug')
            ->whereIn('admin_blogs.id', $relatedIds)
            ->where('admin_blogs.status', 'published')
            ->whereNotNull('admin_blogs.image')
            ->where('admin_blogs.image', '!=', '');
        if ($currentId) {
            $explicitQuery->where('admin_blogs.id', '!=', $currentId);
        }
        $fetched = $explicitQuery->get()->keyBy('id');
        foreach ($relatedIds as $rid) {
            if (isset($fetched[$rid])) {
                $recentBlogs->push($fetched[$rid]);
            }
        }
    }

    $faqs = [];
    if (isset($blog['faqs']) && $blog['faqs'] !== null && $blog['faqs'] !== '') {
        $faqs = is_string($blog['faqs']) ? (json_decode($blog['faqs'], true) ?: []) : (array) $blog['faqs'];
    }
    $blogFaqs = $faqs;
    return view('blog-detail', compact('blog', 'recentBlogs', 'faqs', 'blogFaqs'));
});

Route::get('/author/{slug?}', function ($slug = null) {
    if ($slug) {
        $author = DB::table('admin_authors')->where('slug', $slug)->first();
    } else {
        $author = DB::table('admin_authors')->first();
    }

    // Keep author links working while the admin author list has not been populated yet.
    if (!$author) {
        $author = [
            'id' => null,
            'title' => $slug ? \Illuminate\Support\Str::headline($slug) : 'Our Packaging Expert',
            'description' => 'Packaging insights, ideas, and guidance from the Go Custom Boxes team.',
            'image' => null,
            'facebook' => null,
            'twitter' => null,
            'linkedin' => null,
        ];
        $blogs = [];
    } else {
        $author = (array) $author;
        $blogs = DB::table('admin_blogs')
            ->leftJoin('admin_authors', 'admin_blogs.author_id', '=', 'admin_authors.id')
            ->select('admin_blogs.*', 'admin_authors.title as author_name', 'admin_authors.image as author_image', 'admin_authors.slug as author_slug')
            ->where('admin_blogs.author_id', $author['id'])
            ->where('admin_blogs.status', 'published')
            ->whereNotNull('admin_blogs.image')
            ->where('admin_blogs.image', '!=', '')
            ->get()->map(fn($r) => (array) $r)->all();
    }

    return view('author', compact('author', 'blogs'));
});

Route::get('/request-quote', [QuotationController::class, 'index']);
Route::get('/sitemap', [SitemapController::class, 'index']);
Route::get('/sitemap.xml', [SitemapController::class, 'xml']);
Route::get('/image-sitemap.xml', [SitemapController::class, 'images']);

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminHomepageController;
use App\Http\Controllers\AdminFooterController;
use App\Http\Controllers\AdminFaqPageController;

Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Auth Routes
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [AdminContentController::class, 'dashboard'])->name('dashboard');
        Route::get('/homepage-settings', [AdminHomepageController::class, 'edit'])->name('homepage.edit');
        Route::post('/homepage-settings', [AdminHomepageController::class, 'update'])->name('homepage.update');
        Route::get('/popular-products-settings', [AdminHomepageController::class, 'popularProductsEdit'])->name('popularproducts.edit');
        Route::post('/popular-products-settings', [AdminHomepageController::class, 'popularProductsUpdate'])->name('popularproducts.update');
        // Alias URLs only — route names must stay unique or `php artisan route:cache` fails.
        Route::get('/popular-products', [AdminHomepageController::class, 'popularProductsEdit']);
        Route::post('/popular-products', [AdminHomepageController::class, 'popularProductsUpdate']);
        Route::get('/footer-settings', [AdminFooterController::class, 'edit'])->name('footer.edit');
        Route::post('/footer-settings', [AdminFooterController::class, 'update'])->name('footer.update');
        Route::get('/faq-page-settings', [AdminFaqPageController::class, 'edit'])->name('faqpage.edit');
        Route::post('/faq-page-settings', [AdminFaqPageController::class, 'update'])->name('faqpage.update');
        Route::post('/tinymce/upload', [AdminContentController::class, 'uploadTinyMceMedia'])->name('tinymce.upload');
        Route::get('/{module}', [AdminContentController::class, 'index'])->name('module.index');
        Route::get('/{module}/create', [AdminContentController::class, 'create'])->name('module.create');
        Route::post('/{module}', [AdminContentController::class, 'store'])->name('module.store');
        Route::get('/{module}/{id}/edit', [AdminContentController::class, 'edit'])->name('module.edit');
        Route::put('/{module}/{id}', [AdminContentController::class, 'update'])->name('module.update');
        Route::delete('/{module}/{id}', [AdminContentController::class, 'destroy'])->name('module.destroy');
    });
});

Route::get('/why-choose-us/',[WhyChooseUsController::class, 'index']);

Route::get('/about-us/',[AboutUsController::class,'index']);

use App\Http\Controllers\FormSubmitController;
Route::post('/submit-contact', [FormSubmitController::class, 'submitContact']);
// Quote forms go through spam.guard (honeypot, timing token, server-checked "a + b" captcha).
// See App\Support\SpamGuard. No per-IP throttle here: behind the Hostinger CDN every visitor
// can arrive from the same edge IP, so an IP limit would block real customers.
Route::post('/submit-quote', [FormSubmitController::class, 'submitQuote'])->middleware('spam.guard');
Route::post('/submit-newsletter', [FormSubmitController::class, 'submitNewsletter']);
// Fresh anti-bot token (+ captcha numbers) and CSRF token, so a form can be submitted again
// without a reload, and an expired session can recover instead of failing with "CSRF token mismatch".
Route::get('/spam-guard/token/', function (\Illuminate\Http\Request $request) {
    $data = $request->boolean('captcha') ? \App\Support\SpamGuard::captcha() : ['token' => \App\Support\SpamGuard::token()];
    $data['csrf'] = csrf_token();

    return response()->json($data)->header('Cache-Control', 'no-store');
})->middleware('throttle:120,1');

// Temporary route to preview email design
Route::get('/preview-email', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '1234567890',
        'company_name' => 'Acme Corp',
        'width' => '10',
        'length' => '15',
        'depth' => '5',
        'units' => 'cm',
        'box_style' => 'Mailer Box',
        'material' => 'Kraft',
        'color' => '4/0',
        'quantity' => '500',
        'message' => 'This is a test message to preview the email design.'
    ];
    return new \App\Mail\QuoteFormMail($data);
});

// Catch-all route for categories and products
Route::get('/{slug}', function ($slug) {
    // Resolve the FAQ slug at request time so admin changes are reflected
    // immediately, even when Laravel's route cache is enabled.
    $faqSlug = DB::table('homepage_contents')
        ->where('section', 'faq_page')
        ->where('field_key', 'faq_page_slug')
        ->value('value') ?: 'frequentlyAskedQuestions';
    $faqSlug = trim(strtolower($faqSlug), '/');
    if ($faqSlug !== '' && strtolower($slug) === $faqSlug) {
        return app(FrequentlyAskedQuestionController::class)->index();
    }

    // 1. Check if it's a category
    $category = DB::table('admin_categories')->where('slug', $slug)->first();
    // Navigation-group categories (e.g. Box by Industry / Material / Style) only
    // organise other categories in the menu — they have no public page of their own.
    if ($category && !empty($category->is_nav_group)) {
        abort(404);
    }
    if ($category) {
        $categoryArr = (array) $category;
        $categories = DB::table('admin_categories')->get()->map(fn($r)=>(array)$r)->all();
        
        $products = [];
        $faqs = [];
        if (!empty($categoryArr['id'])) {
            $productIds = DB::table('admin_category_product')
                ->where('category_id', $categoryArr['id'])
                ->pluck('product_id');
            $products = DB::table('admin_products')
                ->whereIn('id', $productIds)
                ->where('status', 'published')
                ->orderBy('id')
                ->get()
                ->map(fn($r)=>(array)$r)
                ->all();

            $faqs = DB::table('admin_category_faqs')->where('category_id', $categoryArr['id'])->get()->map(fn($r)=>(array)$r)->all();
        }

        return view('category', [
            'slug' => $slug,
            'category' => $categoryArr,
            'categories' => $categories,
            'products' => $products,
            'faqs' => $faqs
        ]);
    }

    // 2. Check if it's a product
    $product = DB::table('admin_products')->where('slug', $slug)->first();
    if ($product) {
        $productArr = (array) $product;
        $categories = DB::table('admin_categories')->get()->map(fn($r)=>(array)$r)->all();
        $faqs = [];
        $relatedProducts = [];

        if (!empty($productArr['id'])) {
            $faqs = DB::table('admin_product_faqs')->where('product_id', $productArr['id'])->get()->map(fn($r)=>(array)$r)->all();
            $relatedIds = is_string($productArr['related'] ?? null)
                ? (json_decode($productArr['related'], true) ?: [])
                : (array) ($productArr['related'] ?? []);
            $relatedIds = collect($relatedIds)
                ->map(fn ($id) => (int) $id)
                ->reject(fn ($id) => $id === (int) $productArr['id'])
                ->unique()
                ->values();

            if ($relatedIds->isNotEmpty()) {
                $relatedById = DB::table('admin_products')
                    ->whereIn('id', $relatedIds->all())
                    ->where('status', 'published')
                    ->get()
                    ->keyBy('id');
                $relatedProducts = $relatedIds
                    ->map(fn ($id) => $relatedById->get($id))
                    ->filter()
                    ->map(fn ($product) => (array) $product)
                    ->values()
                    ->all();
            }
        }

        return view('product', [
            'slug' => $slug,
            'product' => $productArr,
            'categories' => $categories,
            'faqs' => $faqs,
            'relatedProducts' => $relatedProducts
        ]);
    }

    // 3. Check if it's a dynamic page
    $page = DB::table('admin_pages')->where('slug', $slug)->where('status', 'published')->first();
    if ($page) {
        return view('dynamic-page', ['page' => (array) $page]);
    }

    // If neither category, product, nor page
    abort(404);
});
