<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ asset('uploads/go-custom-boxes-favicon.png') }}" type="image/png">
    @include('components.canonical')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0B2240">
    @php
        // This page has no image of its own: share the site default (admin homepage hero image).
        $sitemapShare = \App\Support\ShareImage::siteDefault();
    @endphp
    <title>Sitemap | Go Custom Boxes</title>
    <meta name="description" content="Explore the sitemap for Go Custom Boxes. Discover all custom packaging categories, products, industry solutions, and blogs.">
    <meta name="keywords" content="sitemap, packaging products, custom boxes categories, go custom boxes">
    <meta name="robots" content="index,follow">
    <meta name="author" content="Go Custom Boxes">
    <meta name="publisher" content="Go Custom Boxes">

    <!-- Open Graph / Facebook -->
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Sitemap | Go Custom Boxes">
    <meta property="og:description" content="Explore the sitemap for Go Custom Boxes. Discover all custom packaging categories, products, industry solutions, and blogs.">
    <meta property="og:url" content="{{ rtrim(url('/sitemap'), '/') }}/">
    <meta property="og:image" content="{{ $sitemapShare['url'] }}">
    <meta property="og:image:alt" content="{{ $sitemapShare['alt'] }}">
    <meta property="og:site_name" content="Go Custom Boxes">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Sitemap | Go Custom Boxes">
    <meta name="twitter:description" content="Explore the sitemap for Go Custom Boxes. Discover all custom packaging categories, products, industry solutions, and blogs.">
    <meta name="twitter:image" content="{{ $sitemapShare['url'] }}">
    <meta name="twitter:image:alt" content="{{ $sitemapShare['alt'] }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Open+Sans:wght@300;400;600;700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <style>
        body { margin:0; font-family:'DM Sans',sans-serif; background-color: #faf8f8; color: #000; }
        .sitemap-container { max-width: 75rem; width: 100%; margin: 0 auto; padding: 2.5rem 1.25rem; box-sizing: border-box; }
        
        .breadcrumb { font-size: 0.75rem; color: #000; margin-bottom: 1.25rem; text-transform: uppercase; letter-spacing: 1px; }
        .breadcrumb a { color: #000; text-decoration: none; }
        
        .page-title { text-align: center; font-family: 'Open Sans', sans-serif; font-size: 2.25rem; font-weight: 800; margin-bottom: 3.75rem; }
        
        .sitemap-section { margin-bottom: 3.125rem; }
        .section-title { 
            font-family: 'Open Sans', sans-serif; 
            font-size: 1.5rem; 
            font-weight: 700; 
            margin-bottom: 1.875rem; 
            display: flex;
            align-items: center;
            gap: 0.625rem;
        }
        .section-title::before {
            content: "";
            display: block;
            width: 0.3125rem;
            height: 1.5rem;
            background-color: #8D4445;
        }

        .grid-1 { display: grid; grid-template-columns: 1fr; gap: 1.875rem; }
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.875rem; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2.5rem; }

        .list-group { margin-bottom: 1.875rem; }
        .list-title { font-weight: 700; font-size: 1rem; margin-bottom: 0.9375rem; font-family: 'Open Sans', sans-serif; }
        .list-title a { color: #000; text-decoration: none; transition: color 0.2s; }
        .list-title a:hover { color: #8D4445; }
        
        ul.sitemap-list { list-style: none; padding: 0; margin: 0; }
        ul.sitemap-list li { margin-bottom: 0.625rem; font-size: 0.875rem; position: relative; padding-left: 0.75rem; }
        ul.sitemap-list li::before {
            content: "-";
            position: absolute;
            left: 0;
            color: #555;
        }
        ul.sitemap-list a { color: #333; text-decoration: none; transition: color 0.2s; }
        ul.sitemap-list a:hover { color: #8D4445; }

        @media (max-width: 61.9375rem) {
            .grid-3 { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 47.9375rem) {
            .grid-3, .grid-2 { grid-template-columns: 1fr; }
            .page-title { font-size: 1.75rem; }
        }
    </style>
</head>
<body class="sitemap-page">
    @include('components.header')
    
    <main>
        <div class="sitemap-container">
            <div class="breadcrumb">
                <a href="/">HOME</a> > SITEMAP
            </div>

            <h1 class="page-title">Sitemap</h1>

            <!-- Pages Section -->
            <div class="sitemap-section">
                <h2 class="section-title">Pages</h2>
                <div class="grid-1">
                    <div class="list-group">
                        <ul class="sitemap-list">
                            <li><a href="/">Home</a></li>
                            <li><a href="/contact-us/">Contact Us</a></li>
                            <li><a href="/request-quote/">Get Instant Quote</a></li>
                            <li><a href="/blog/">Blog</a></li>
                            @foreach($pages as $page)
                                <li><a href="/page/{{ $page->slug ?? '' }}">{{ $page->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Dynamic Category Sections -->
            @foreach($sitemapData as $data)
                @if(count($data['subcategories']) > 0 || count($data['direct_products']) > 0)
                <div class="sitemap-section">
                    <h2 class="section-title">{{ $data['parent']->title }}</h2>
                    <div class="grid-3">
                        @if(count($data['subcategories']) > 0)
                            @foreach($data['subcategories'] as $sub)
                                <div class="list-group">
                                    <div class="list-title"><a href="/{{ $sub['category']->slug }}/">{{ $sub['category']->title }}</a></div>
                                    <ul class="sitemap-list">
                                        @foreach($sub['products'] as $product)
                                            <li><a href="/{{ $product->slug }}/">{{ $product->title }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        @else
                            {{-- No subcategories, just display direct products across 3 columns --}}
                            @php
                                $products = $data['direct_products']->values();
                                $chunkSize = max(1, ceil($products->count() / 3));
                                $chunks = $products->chunk($chunkSize);
                            @endphp
                            
                            @foreach($chunks as $chunk)
                                <div class="list-group">
                                    <ul class="sitemap-list">
                                        @foreach($chunk as $product)
                                            <li><a href="/{{ $product->slug }}/">{{ $product->title }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                @endif
            @endforeach

            <!-- Blogs Section -->
            @if($blogs->count() > 0)
            <div class="sitemap-section">
                <h2 class="section-title">Blogs</h2>
                <div class="grid-2">
                    @php
                        $blogChunks = $blogs->chunk(max(1, ceil($blogs->count() / 2)));
                    @endphp
                    
                    @foreach($blogChunks as $chunk)
                        <div class="list-group">
                            <ul class="sitemap-list">
                                @foreach($chunk as $blog)
                                    <li><a href="/blog/{{ $blog->slug }}/">{{ $blog->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </main>

    @include('components.footer')
</body>
</html>
