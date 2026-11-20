<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0B2240">
    <link rel="icon" href="{{ asset('uploads/go-custom-boxes-favicon.png') }}" type="image/png">
    @php
        // Hero banner at the top of the page, also the share image (og/twitter); both use the alt made from its file name.
        $blogHeroImage = 'uploads/blog-banner.webp';
        $blogShare = \App\Support\ShareImage::make($blogHeroImage);
    @endphp
    <title>Packaging Insights & Industry Trends | Go Custom Boxes</title>
    <meta name="description" content="Explore custom packaging insights, trends, design tips, and structural advice for luxury rigid boxes, corrugated cartons, and branded packaging.">
    <meta name="keywords" content="custom boxes blog, packaging insights, rigid boxes guide, luxury packaging trends">
    <meta name="robots" content="index,follow">
    <meta name="author" content="Go Custom Boxes">
    <meta name="publisher" content="Go Custom Boxes">

    <!-- Open Graph / Facebook -->
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Packaging Insights & Industry Trends | Go Custom Boxes">
    <meta property="og:description" content="Explore custom packaging insights, trends, design tips, and structural advice for luxury rigid boxes, corrugated cartons, and branded packaging.">
    <meta property="og:url" content="{{ rtrim(url('/blog'), '/') }}/">
    <meta property="og:image" content="{{ $blogShare['url'] }}">
    <meta property="og:image:alt" content="{{ $blogShare['alt'] }}">
    <meta property="og:site_name" content="Go Custom Boxes">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Packaging Insights & Industry Trends | Go Custom Boxes">
    <meta name="twitter:description" content="Explore custom packaging insights, trends, design tips, and structural advice for luxury rigid boxes, corrugated cartons, and branded packaging.">
    <meta name="twitter:image" content="{{ $blogShare['url'] }}">
    <meta name="twitter:image:alt" content="{{ $blogShare['alt'] }}">

    @include('components.canonical')
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Open+Sans:wght@300;400;600;700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    
    <style>
        :root {
            --dark-blue: #0A2240;
            --yellow: #FFB400;
            --text-dark: #333333;
            --text-light: #666666;
            --container-width: 80rem;
            --margin-sides: 3.4375rem;
            --font-heading: 'Open Sans', sans-serif;
            --font-body: 'DM Sans', sans-serif;
        }

        body {
            margin: 0;
            font-family: var(--font-body);
            background-color: #FFFFFF;
            color: var(--text-dark);
        }

        * {
            box-sizing: border-box;
        }

        .container {
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 0 var(--margin-sides);
        }



        /* Content Section */
        .blog-content {
            padding: 1.875rem 0;
        }

        /* Featured Post */
        .featured-post {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2.5rem;
            align-items: center;
            margin-bottom: 2.5rem;
            cursor: pointer;
            transition: transform 0.25s ease;
        }

        .featured-img-link {
            display: block;
            width: 100%;
            border-radius: 0.75rem;
            overflow: hidden;
            text-decoration: none;
        }

        .featured-img {
            width: 100%;
            height: auto;
            object-fit: cover;
            object-position: center;
            background-position: center;
            background-size: cover;
            border-radius: 0.75rem;
            background-color: transparent;
            display: block;
            transition: transform 0.35s ease;
        }

        .featured-post:hover .featured-img {
            transform: scale(1.02);
        }

        .featured-copy h2 {
            font-family: var(--font-heading);
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 1.25rem 0;
            line-height: 1.3;
        }

        .featured-title-link {
            color: inherit;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .featured-post:hover .featured-title-link {
            color: var(--dark-blue);
        }

        .featured-copy p.excerpt {
            font-size: 1rem;
            color: #000;
            line-height: 1.6;
            margin: 0 0 1.25rem 0;
        }

        .meta {
            font-size: 0.875rem;
            color: #888;
            margin-bottom: 1.5625rem;
            display: flex;
            align-items: center;
            gap: 0.3125rem;
        }

        .read-btn {
            background-color: var(--yellow);
            color: #000;
            width: 8.75rem;
            height: 2.75rem;
            border-radius: 0.375rem;
            font-weight: 700;
            font-size: 0.9375rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: background 0.3s;
        }

        .read-btn:hover {
            background-color: #e5a300;
        }

        /* Blog Grid */
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 23.875rem));
            justify-content: center;
            gap: 1.875rem;
            margin-bottom: 3.125rem;
            align-items: stretch;
        }

        .blog-card {
            border: 1px solid #EAEAEA;
            border-radius: 1rem;
            width: 100%;
            max-width: 23.875rem;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            background: #fff;
            box-shadow: 0 0.25rem 0.9375rem rgba(0,0,0,0.03);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            height: 100%;
        }

        .blog-card:hover {
            transform: translateY(-0.3125rem);
            box-shadow: 0 0.5rem 1.5625rem rgba(0,0,0,0.06);
        }

        .blog-card img {
            width: calc(100% - 1.75rem);
            height: auto;
            aspect-ratio: 2 / 1;
            object-fit: contain;
            object-position: center;
            background-position: center;
            background-size: contain;
            background: transparent;
            border-radius: 0.75rem;
            margin: 0.875rem auto 0;
            display: block;
        }

        .card-content {
            padding: 1.25rem 1.5rem 1.25rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .card-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.9375rem;
            color: #1a1a1a;
            margin-bottom: 0.75rem;
            font-weight: 500;
        }

        .blog-card h3 {
            font-family: var(--font-heading);
            font-size: 1.25rem !important;
            font-weight: 700;
            margin: 0 0 1.25rem 0;
            color: var(--text-dark);
            line-height: 1.4;
            flex-grow: 1;
            min-height: 5.25rem;
        }

        .card-description {
            color: #000;
            line-height: 1.6;
            margin: 0 0 1.25rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-link {
            margin-top: auto;
            color: var(--dark-blue);
            font-weight: 700;
            font-size: 0.875rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.3125rem;
        }
        
        .card-link i {
            color: var(--dark-blue);
        }

        /* Load More */
        .load-more-wrap {
            text-align: center;
            margin-top: 1.25rem;
        }

        /* Responsive */
        @media (max-width: 61.9375rem) {
            .container {
                padding: 0 1.5rem;
            }
            .featured-post {
                grid-template-columns: 1fr;
                gap: 1.875rem;
                margin-bottom: 2.5rem;
            }
            .featured-img-link {
                border-radius: 1rem;
            }
            .featured-img {
                height: 22.5rem;
                border-radius: 1rem;
            }
            .blog-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.25rem;
            }
        }

        @media (max-width: 48rem) {
            .container {
                padding: 0 1rem;
            }
            .blog-hero {
                padding: 0 1rem;
                height: 25rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .blog-hero h1 {
                font-size: 2rem;
                margin-top: 0.3125rem;
                margin-bottom: 0.625rem;
            }
            .blog-hero p {
                font-size: 0.875rem;
                line-height: 1.5;
            }
            .breadcrumb {
                display: none;
            }
            .blog-content {
                padding: 1.5rem 0 2.5rem;
            }
            .featured-post {
                grid-template-columns: 1fr;
                gap: 1.125rem;
                margin-bottom: 2.1875rem;
            }
            .featured-img-link {
                border-radius: 1rem;
            }
            .featured-img {
                width: 100%;
                height: auto;
                border-radius: 1rem;
            }
            .featured-copy {
                padding: 0;
            }
            .featured-copy h2 {
                font-size: 1.3125rem;
                font-weight: 700;
                line-height: 1.35;
                margin: 0 0 0.75rem 0;
                color: #000;
            }
            .featured-copy p.excerpt {
                text-align: justify;
                font-size: 0.875rem;
                line-height: 1.6;
                color: #555;
                margin: 0 0 0.9375rem 0;
            }
            .meta {
                font-size: 0.8125rem;
                color: #888;
                margin-bottom: 1.125rem;
            }
            .read-btn {
                height: 2.5rem;
                width: 7.8125rem;
                font-size: 0.8438rem;
            }
            .blog-grid {
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }
        }
    </style>
</head>
<body>
    @include('components.header')

    <main>
        <x-about-hero 
            title="Blog"
            description="Discover packaging ideas, industry trends, design inspiration, and practical tips to help your brand stand out."
            :bgImage="$blogHeroImage"
            mobileBgImage="uploads/blog-banner-mobile.webp"
          
            breadcrumb="Blog"
            overlay="rgba(10, 34, 64, 0.6)"
        />

        <section class="blog-content">
            <div class="container">

                @php
                    $featuredBlog = null;
                    $displayBlogs = [
                        ['title' => 'Sustainable Packaging Trends For 2026', 'blog_category' => 'packaging', 'image' => 'images/Frame 571 (1).png', 'author_name' => 'Joe Danley', 'publish_date' => '2024-11-15', 'excerpt' => 'Explore how eco-friendly rigid boxes are transforming luxury packaging with sustainable materials.', 'slug' => 'sustainable-packaging-trends'],
                        ['title' => 'The Ultimate Guide To Choosing The Right Custom Packaging For Your Brand', 'blog_category' => 'packaging', 'image' => 'images/Frame 571 (1).png', 'author_name' => 'Joe Stanley', 'publish_date' => '2024-11-15', 'excerpt' => 'Learn how to make the right packaging choices.', 'slug' => 'ultimate-guide-custom-packaging'],
                        ['title' => 'The Ultimate Guide To Choosing The Right Custom Packaging For Your Brand', 'blog_category' => 'packaging', 'image' => 'images/Frame 571 (1).png', 'author_name' => 'Joe Stanley', 'publish_date' => '2024-11-15', 'excerpt' => 'Learn how to make the right packaging choices.', 'slug' => 'ultimate-guide-custom-packaging'],
                        ['title' => 'The Ultimate Guide To Choosing The Right Custom Packaging For Your Brand', 'blog_category' => 'packaging', 'image' => 'images/Frame 571 (1).png', 'author_name' => 'Joe Stanley', 'publish_date' => '2024-11-15', 'excerpt' => 'Learn how to make the right packaging choices.', 'slug' => 'ultimate-guide-custom-packaging'],
                        ['title' => 'The Ultimate Guide To Choosing The Right Custom Packaging For Your Brand', 'blog_category' => 'packaging', 'image' => 'images/Frame 571 (1).png', 'author_name' => 'Joe Stanley', 'publish_date' => '2024-11-15', 'excerpt' => 'Learn how to make the right packaging choices.', 'slug' => 'ultimate-guide-custom-packaging'],
                        ['title' => 'The Ultimate Guide To Choosing The Right Custom Packaging For Your Brand', 'blog_category' => 'packaging', 'image' => 'images/Frame 571 (1).png', 'author_name' => 'Joe Stanley', 'publish_date' => '2024-11-15', 'excerpt' => 'Learn how to make the right packaging choices.', 'slug' => 'ultimate-guide-custom-packaging'],
                    ];
                    if (!empty($blogs) && count($blogs) > 0) {
                        $blogsArray = json_decode(json_encode($blogs), true);
                        $blogsArray = array_values(array_filter($blogsArray, fn($b) => !empty(trim((string)($b['image'] ?? '')))));
                        usort($blogsArray, function($a, $b) {
                            $idA = (int)($a['id'] ?? 0);
                            $idB = (int)($b['id'] ?? 0);
                            return $idB <=> $idA;
                        });
                        $featuredBlog = $blogsArray[0] ?? null;
                        $displayBlogs = array_slice($blogsArray, 1);
                    } else {
                        $featuredBlog = null;
                        $displayBlogs = [];
                    }
                @endphp

                <!-- Featured Post -->
                @if($featuredBlog)
                    @php
                        $fTitle = $featuredBlog['title'] ?? '';
                        $fExcerpt = $featuredBlog['excerpt'] ?? '';
                        $fSlug = $featuredBlog['slug'] ?? '';
                        $fImg = !empty($featuredBlog['image']) ? (\Illuminate\Support\Str::startsWith($featuredBlog['image'], ['http://', 'https://']) ? $featuredBlog['image'] : asset($featuredBlog['image'])) : null;
                        $fUrl = url('/blog/' . $fSlug) . '/';
                        $fAuthor = $featuredBlog['author_name'] ?? '';
                        $fAuthorSlug = $featuredBlog['author_slug'] ?? ($fAuthor ? \Illuminate\Support\Str::slug($fAuthor) : '');
                        $fDate = !empty($featuredBlog['publish_date']) ? date('M d, Y', strtotime($featuredBlog['publish_date'])) : 'Aug 12, 2026';
                        $fExcerptText = trim(strip_tags(html_entity_decode(html_entity_decode($fExcerpt, ENT_QUOTES | ENT_HTML5, 'UTF-8'), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
                    @endphp
                    <div class="featured-post" onclick="window.location.href='{{ $fUrl }}';">
                        @if(!empty($fImg))
                        <a href="{{ $fUrl }}" class="featured-img-link" onclick="event.stopPropagation();">
                            <img src="{{ $fImg }}" alt="{{ $fTitle }}" class="featured-img" onerror="this.parentElement.style.display='none';">
                        </a>
                        @endif
                        <div class="featured-copy">
                            <h2><a href="{{ $fUrl }}" class="featured-title-link" onclick="event.stopPropagation();">{{ $fTitle }}</a></h2>
                            @if(!empty($fExcerptText))
                            <p class="excerpt">{{ Str::limit($fExcerptText, 150) }}</p>
                            @endif
                            <div class="meta">
                                @if(!empty($fAuthor))
                                <a href="{{ url('/author/' . $fAuthorSlug) }}/" onclick="event.stopPropagation();" style="text-decoration: none; color: inherit;">{{ $fAuthor }}</a> &nbsp;|&nbsp;
                                @endif
                                {{ $fDate }}
                            </div>
                            <a href="{{ $fUrl }}" class="read-btn" onclick="event.stopPropagation();">Read Blog <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                @endif

                <!-- Grid -->
                <div class="blog-grid">
                    @foreach($displayBlogs as $index => $item)
                        @php
                            $item = (array) $item;
                            $bTitle = $item['title'] ?? '';
                            $bAuthor = $item['author_name'] ?? '';
                            $bAuthorSlug = $item['author_slug'] ?? ($bAuthor ? \Illuminate\Support\Str::slug($bAuthor) : '');
                            $bSlug = $item['slug'] ?? 'blog-detail';
                            $bImg = !empty($item['image']) ? (\Illuminate\Support\Str::startsWith($item['image'], ['http://', 'https://']) ? $item['image'] : asset($item['image'])) : null;
                            $bUrl = url('/blog/' . $bSlug) . '/';
                            $bExcerpt = !empty(trim((string) ($item['excerpt'] ?? '')))
                                ? $item['excerpt']
                                : ($item['content'] ?? '');
                            $bExcerptText = trim(strip_tags(html_entity_decode(html_entity_decode((string) $bExcerpt, ENT_QUOTES | ENT_HTML5, 'UTF-8'), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
                            $bDate = !empty($item['publish_date']) ? date('M d, Y', strtotime($item['publish_date'])) : null;
                            $bDateIso = !empty($item['publish_date']) ? date('Y-m-d', strtotime($item['publish_date'])) : null;
                        @endphp
                        <div class="blog-card {{ $index >= 9 ? 'blog-card-hidden' : '' }}" onclick="window.location.href='{{ $bUrl }}';" @if($index >= 9) style="display:none;" @endif>
                            @if(!empty($bImg))
                            <img src="{{ $bImg }}" alt="{{ $bTitle }}" onerror="this.style.display='none';">
                            @endif
                            <div class="card-content">
                                <div class="card-meta">
                                    @if(!empty($bAuthor))
                                    <a href="{{ url('/author/' . $bAuthorSlug) }}/" onclick="event.stopPropagation();" style="text-decoration: none; color: inherit;"><span>{{ $bAuthor }}</span></a>
                                    @else
                                    <span></span>
                                    @endif
                                    @if($bDate)
                                    <time datetime="{{ $bDateIso }}">{{ $bDate }}</time>
                                    @endif
                                    <span>8 min read</span>
                                </div>
                                <h3>{{ $bTitle }}</h3>

                                <a href="{{ $bUrl }}" class="card-link" onclick="event.stopPropagation();">Read Blog <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Load More -->
                @if(count($displayBlogs) > 9)
                <div class="load-more-wrap">
                    <button type="button" class="read-btn" id="blogLoadMore" style="border:none; cursor:pointer; width: 12.625rem; height: 3.375rem;">Load more</button>
                </div>
                <script>
                    document.getElementById('blogLoadMore').addEventListener('click', function () {
                        var hidden = document.querySelectorAll('.blog-card-hidden');
                        for (var i = 0; i < 9 && i < hidden.length; i++) {
                            hidden[i].style.display = '';
                            hidden[i].classList.remove('blog-card-hidden');
                        }
                        if (document.querySelectorAll('.blog-card-hidden').length === 0) {
                            this.parentElement.style.display = 'none';
                        }
                    });
                </script>
                @endif

            </div>
        </section>
        
        @include('components.cta')
    </main>

    @include('components.footer')
</body>
</html>

