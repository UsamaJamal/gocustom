<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0B2240">
    <link rel="icon" href="{{ asset('uploads/go-custom-boxes-favicon.png') }}" type="image/png">

    @php
        $pageMetaTitle = !empty(trim((string)($blog['meta_title'] ?? ''))) 
            ? $blog['meta_title'] 
            : (!empty(trim((string)($blog['title'] ?? ''))) ? $blog['title'] . ' | Go Custom Boxes' : 'Blog Detail - Go Custom Boxes');
        $pageMetaDescription = !empty(trim((string)($blog['meta_description'] ?? ''))) 
            ? $blog['meta_description'] 
            : (!empty(trim((string)($blog['excerpt'] ?? ''))) ? trim(strip_tags((string)$blog['excerpt'])) : '');
        $pageMetaKeywords = !empty(trim((string)($blog['meta_keywords'] ?? ''))) 
            ? $blog['meta_keywords'] 
            : (!empty(trim((string)($blog['tags'] ?? ''))) ? $blog['tags'] : '');
        $pageRobots = !empty(trim((string)($blog['robots'] ?? ''))) ? $blog['robots'] : 'index,follow';
        // Share image = the blog's featured image, with its admin Alt Text, else the blog title
        // (the alt the featured image has on the page).
        $pageShare = \App\Support\ShareImage::make(
            $blog['image'] ?? null,
            !empty(trim((string) ($blog['alt_text'] ?? ''))) ? $blog['alt_text'] : ($blog['title'] ?? null)
        );
        $pageImage = $pageShare['url'];
        $pageImageAlt = $pageShare['alt'];
        $blogAuthor = !empty(trim((string)($blog['joined_author_name'] ?? ''))) 
            ? trim((string)$blog['joined_author_name']) 
            : (!empty(trim((string)($blog['author_name'] ?? ''))) 
                ? trim((string)$blog['author_name']) 
                : 'Go Custom Boxes');
    @endphp

    <title>{{ $pageMetaTitle }}</title>
    @if(!empty($pageMetaDescription))
    <meta name="description" content="{{ $pageMetaDescription }}">
    @endif
    @if(!empty($pageMetaKeywords))
    <meta name="keywords" content="{{ $pageMetaKeywords }}">
    @endif
    <meta name="robots" content="{{ $pageRobots }}">
    <meta name="author" content="{{ $blogAuthor }}">
    <meta name="publisher" content="Go Custom Boxes">

    <!-- Open Graph / Facebook -->
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $pageMetaTitle }}">
    @if(!empty($pageMetaDescription))
    <meta property="og:description" content="{{ $pageMetaDescription }}">
    @endif
    <meta property="og:url" content="{{ rtrim(url()->current(), '/') }}/">
    <meta property="og:image" content="{{ $pageImage }}">
    <meta property="og:image:alt" content="{{ $pageImageAlt }}">
    <meta property="og:site_name" content="Go Custom Boxes">
    @if(!empty($blog['publish_date']))
    <meta property="article:published_time" content="{{ date('c', strtotime($blog['publish_date'])) }}">
    @elseif(!empty($blog['created_at']))
    <meta property="article:published_time" content="{{ date('c', strtotime($blog['created_at'])) }}">
    @endif
    @if(!empty($blog['updated_at']))
    <meta property="article:modified_time" content="{{ date('c', strtotime($blog['updated_at'])) }}">
    @endif
    @if(!empty($blog['blog_category']))
    <meta property="article:section" content="{{ $blog['blog_category'] }}">
    @endif
    <meta property="article:publisher" content="Go Custom Boxes">
    <meta property="article:author" content="{{ $blogAuthor }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageMetaTitle }}">
    @if(!empty($pageMetaDescription))
    <meta name="twitter:description" content="{{ $pageMetaDescription }}">
    @endif
    <meta name="twitter:image" content="{{ $pageImage }}">
    <meta name="twitter:image:alt" content="{{ $pageImageAlt }}">

    @include('components.canonical')
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Open+Sans:wght@300;400;600;700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #0A2240;
            --dark-blue: #0A2240;
            --yellow: #FFB400;
            --light-yellow: #FFF8E7;
            --text-dark: #111827;
            --text-light: #4B5563;
            --border-color: #EAEAEA;
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
            line-height: 1.6;
        }

        * { box-sizing: border-box; }
        
        a { text-decoration: none; color: inherit; }

        .container {
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 0 var(--margin-sides);
        }

        .blog-detail-section {
            padding: 1rem 0 3.75rem 0;
        }

        /* Breadcrumb */
        .breadcrumb {
            font-family: var(--font-heading);
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1.875rem;
            color: var(--text-dark);
        }
        .breadcrumb a {
            color: var(--text-dark);
            text-decoration: none;
        }
        .breadcrumb span { margin: 0 0.5rem; color: #999; }

        /* Hero Image */
        .hero-img-wrapper {
            width: 100%;
            height: auto;
            border-radius: 0.75rem;
            margin-bottom: 2.5rem;
            overflow: hidden;
            display: block;
            background: transparent;
        }
        .hero-img {
            width: 100%;
            height: auto;
            max-width: 100%;
            object-fit: contain;
            object-position: center;
            background: transparent;
            display: block;
            border-radius: inherit;
        }

        /* Title & Meta */
        .article-title {
            font-family: var(--font-heading); /* Or 'Plus Jakarta Sans' if added, but var(--font-heading) is fine */
            font-size: 2rem;
            font-weight: 700;
            line-height: 2.5rem;
            margin: 0 0 0.9375rem 0;
            color: #111;
            text-align: justify;
        }
        .article-subtitle {
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            font-weight: 400;
            color: #000;
            margin: 0 0 1.5625rem 0;
            line-height: 1.625rem;
            text-align: justify;
        }
        .article-meta {
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            color: #000;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2.5rem;
        }
        .article-meta span.divider { color: #888; }

        /* Layout Grid */
        .content-layout {
            display: grid;
            grid-template-columns: minmax(0, 3fr) minmax(0, 1fr);
            gap: 3.75rem;
            align-items: start;
        }

        /* Main Content */
        .main-content {
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            font-weight: 400;
            color: #000;
            line-height: 1.875rem;
            letter-spacing: 0;
            text-align: justify;
        }

        .main-content h1,
        .main-content h2,
        .main-content h3,
        .main-content h4,
        .main-content h5,
        .main-content h6 {
            text-align: left;
        }
        .main-content h2 {
            font-family: var(--font-heading);
            font-size: 1.75rem;
            margin: 2.5rem 0 1.25rem 0;
            color: var(--dark-blue);
        }
        .main-content h3 {
            font-family: var(--font-heading);
            font-size: 1.375rem;
            margin: 1.875rem 0 0.9375rem 0;
        }
        .main-content p {
            margin-bottom: 1.25rem;
        }
        .main-content ul, .main-content ol {
            margin-bottom: 1.25rem;
            padding-left: 1.25rem;
        }
        .main-content li {
            margin-bottom: 0.625rem;
        }

        /* Internal / Editorial Links in Article Content */
        .main-content a:not(.cta-btn) {
            color: var(--primary-color, var(--dark-blue, #0A2240)) !important;
            text-decoration: underline !important;
            text-decoration-color: var(--primary-color, var(--dark-blue, #0A2240)) !important;
            text-underline-offset: 0.1875rem;
            cursor: pointer;
            transition: color 0.2s ease, text-decoration-color 0.2s ease;
        }
        .main-content a:not(.cta-btn) * {
            color: var(--primary-color, var(--dark-blue, #0A2240)) !important;
            text-decoration-color: var(--primary-color, var(--dark-blue, #0A2240)) !important;
        }
        .main-content a:not(.cta-btn):hover,
        .main-content a:not(.cta-btn):hover * {
            color: #1a4f8b !important;
            text-decoration-color: #1a4f8b !important;
        }
        .main-content span:has(> a),
        .main-content span:has(> strong > a),
        .main-content strong:has(> a) {
            text-decoration-color: var(--primary-color, var(--dark-blue, #0A2240)) !important;
        }

        /* Key Takeaways Box (Mapping from .callout-box) */
        .callout-box {
            background-color: #FFF8E7;
            border-radius: 0.75rem;
            padding: 1.875rem;
            margin-bottom: 2.5rem;
        }
        .callout-box li {
            margin-bottom: 0.9375rem;
        }
        .callout-label {
            font-family: var(--font-heading);
            font-size: 0.9375rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 0.9375rem;
            color: var(--dark-blue);
            letter-spacing: 0.0312rem;
        }
        .callout-content {
            font-size: 1rem;
        }

        /* CTA Banner */
        .cta-banner {
            background-color: var(--dark-blue);
            border-radius: 0.75rem;
            padding: 1.25rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 3.125rem;
            color: #fff;
        }
        .cta-banner-text {
            font-family: var(--font-heading);
            font-size: 1.375rem;
            font-weight: 700;
            color: var(--yellow);
        }
        .cta-banner-sub {
            font-size: 0.875rem;
            color: #ccc;
            margin-top: 0.3125rem;
        }
        .cta-btn {
            background-color: var(--yellow);
            color: #000;
            width: 10.5625rem;
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            font-weight: 700;
            font-size: 1rem;
            white-space: nowrap;
            text-decoration: none;
            transition: background 0.3s;
        }
        .cta-btn:hover { background-color: #e5a300; }

        /* Sidebar */
        .sidebar {
            position: sticky;
            top: 2.5rem;
            border-left: 1px solid #eaeaea;
            padding-left: 1.875rem;
        }

        .widget {
            margin-bottom: 2.5rem;
        }
        .widget-title {
            font-family: var(--font-heading);
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
            color: #000;
        }

        .author-share-card {
            border: none;
            border-radius: 0;
            padding: 0;
            margin-bottom: 1.875rem;
            background: transparent;
        }
        .author-share-card .widget { margin-bottom: 0; }
        .card-divider {
            border: none;
            border-top: 1px dotted #ccc;
            margin: 1.5rem 0;
        }

        /* Author Widget */
        .author-box {
            margin-bottom: 0;
            display: block;
            text-decoration: none !important;
            color: inherit;
            cursor: pointer;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }
        .author-box:hover .author-name {
            color: #1a4f8b;
            text-decoration: underline;
        }
        .author-box:hover .author-img {
            transform: scale(1.05);
        }
        .author-profile {
            display: flex;
            align-items: flex-start;
            gap: 0.9375rem;
            margin-bottom: 0.9375rem;
        }
        .author-img {
            width: 3.75rem;
            height: 3.75rem;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            margin-top: 0.125rem;
            transition: transform 0.2s ease;
        }
        .author-name {
            font-family: var(--font-heading);
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--dark-blue);
            transition: color 0.2s ease;
        }
        .author-role {
            font-size: 0.8125rem;
            color: #000;
            margin-top: 0.3125rem;
        }
        .author-expertise {
            font-size: 0.875rem;
            color: #000;
            line-height: 1.5;
            text-align: left;
            margin-bottom: 0.5rem;
        }
        .author-description {
            font-size: 0.875rem;
            color: #000;
            line-height: 1.5;
            text-align: left;
        }
        .author-description p {
            margin: 0 0 0.5rem 0;
            font-size: inherit;
            color: inherit;
            line-height: inherit;
        }
        .author-description p:last-child {
            margin-bottom: 0;
        }
        .author-description strong, .author-description b {
            font-weight: 700;
            color: inherit;
        }
        .author-bio {
            font-size: 0.875rem;
            color: #000;
            line-height: 1.5;
            text-align: left;
        }

        /* Social Share */
        .share-icons {
            display: flex;
            gap: 0.625rem;
        }
        .share-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.5rem;
            background: #EAEAEA;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-size: 1.125rem;
            transition: all 0.3s;
            text-decoration: none;
        }
        .share-icon:hover {
            background: var(--dark-blue);
            color: #fff;
        }

        /* Related Blogs */
        .related-section {
            padding: 0;
            margin-top: 2.5rem;
        }
        .related-title {
            font-family: var(--font-heading);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1.75rem;
            text-align: left;
        }
        
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 23.875rem));
            justify-content: start;
            gap: 1.875rem;
            align-items: stretch;
        }

        .blog-card {
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            width: 100%;
            max-width: 23.875rem;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            background: #fff;
            box-shadow: 0 0.25rem 0.9375rem rgba(0,0,0,0.03);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
            cursor: pointer;
            height: 100%;
        }
        .blog-card-hit-area {
            position: absolute;
            inset: 0;
            z-index: 1;
        }
        .blog-card .card-meta a,
        .blog-card .card-link {
            position: relative;
            z-index: 2;
        }
        .blog-card:hover {
            transform: translateY(-0.3125rem);
            box-shadow: 0 0.625rem 1.5625rem rgba(0,0,0,0.05);
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
            line-height: 1.4;
            color: var(--text-dark);
            flex-grow: 1;
            min-height: 5.25rem;
        }
        .card-link {
            margin-top: auto;
            color: var(--dark-blue);
            font-weight: 700;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.3125rem;
        }
        .card-link i { color: var(--dark-blue); }

        .mobile-share-divider { display: none; }

        @media (max-width: 61.9375rem) {
            .content-layout { grid-template-columns: 1fr; gap: 0; }
            .sidebar { position: static; margin-top: 0; }
            .blog-grid { grid-template-columns: repeat(2, 1fr); }
            .hero-img-wrapper { height: auto; }
        }
        @media (max-width: 48rem) {
            .container { padding: 0 1rem; }
            .blog-detail-section { padding-top: 0; }
            .breadcrumb { display: none !important; }
            .hero-img-wrapper { 
                width: 100vw; 
                margin-left: calc(-50vw + 50%); 
                border-radius: 0; 
                height: auto;
                margin-bottom: 1.5625rem;
            }
            .article-title {
                font-size: 1.625rem !important;
                line-height: 2.125rem;
                text-align: left;
                width: 100%;
                display: block;
            }
            .article-meta {
                flex-wrap: wrap;
                gap: 0.625rem 1rem;
                line-height: 1.6;
            }
            .sidebar {
                border: 1px solid #EAEAEA;
                border-left: 1px solid #EAEAEA;
                border-radius: 0.75rem;
                padding: 1.5rem;
                margin-top: 1.875rem;
            }
            .mobile-share-divider {
                display: block;
                border: none;
                border-top: 1px dotted #ccc;
                margin: 1.5rem 0;
            }
            .author-share-card { margin-bottom: 1.5rem; }
            .blog-grid { grid-template-columns: 1fr; }
            .cta-banner { flex-direction: column; text-align: center; gap: 1.25rem; }
            
            .related-section {
                padding-top: 0;
                margin-top: 1.5rem;
            }
            .related-title {
                margin-top: 0;
                margin-bottom: 1.25rem;
                font-size: 1.5rem;
            }
            .blog-card h3 {
                word-spacing: 0.25rem;
                line-height: 1.6;
            }
        /* Blog Detail FAQ Styling */
        .blog-detail-section .product-faq-section {
            background-color: transparent !important;
            padding: 3rem 0 1.5rem 0;
            width: 100%;
        }
        .blog-detail-section .product-faq-heading {
            font-family: var(--font-heading);
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-blue);
            text-align: center;
            margin-bottom: 2rem;
        }
        @media (max-width: 48rem) {
            .blog-detail-section .product-faq-section {
                padding: 2rem 0 1rem 0;
            }
            .blog-detail-section .product-faq-heading {
                font-size: 1.5rem;
                margin-bottom: 1.25rem;
            }
        }
    </style>
</head>
<body>

@include('components.header')

@php 
    $authorName = !empty($blog['joined_author_name']) ? $blog['joined_author_name'] : (!empty($blog['author_name']) ? $blog['author_name'] : null);
    $authorSlug = !empty($blog['joined_author_slug']) ? $blog['joined_author_slug'] : (!empty($blog['author_slug']) ? $blog['author_slug'] : ($authorName ? \Illuminate\Support\Str::slug($authorName) : null));
    $authorUrl = $authorSlug ? (url('/author/' . $authorSlug) . '/') : null;
    $authorImgPath = !empty($blog['joined_author_image']) ? $blog['joined_author_image'] : (!empty($blog['author_image']) ? $blog['author_image'] : null);
    $authorDesc = !empty($blog['joined_author_desc']) ? $blog['joined_author_desc'] : (!empty($blog['author_description']) ? $blog['author_description'] : null);
    $authorDesignation = !empty($blog['joined_author_designation']) ? $blog['joined_author_designation'] : (!empty($blog['author_designation']) ? $blog['author_designation'] : null);
    $authorExpertise = !empty($blog['joined_author_bio']) ? $blog['joined_author_bio'] : (!empty($blog['author_bio']) ? $blog['author_bio'] : null);
    $authorDescription = $authorDesc;

    $authorImg = $authorImgPath ? (\Illuminate\Support\Str::startsWith($authorImgPath, ['http', 'storage/', 'uploads/', 'images/']) ? asset($authorImgPath) : asset('storage/'.$authorImgPath)) : asset('images/ahmed-khan.png'); 
    
    $publishDate = !empty($blog['publish_date']) ? date('M j, Y', strtotime($blog['publish_date'])) : (!empty($blog['created_at']) ? date('M j, Y', strtotime($blog['created_at'])) : null);
    $updateDate = !empty($blog['updated_at']) ? date('M j, Y', strtotime($blog['updated_at'])) : null;
    
    $fTitle = $blog['title'] ?? '';
    $fImg = !empty($blog['image']) ? (\Illuminate\Support\Str::startsWith($blog['image'], ['http://', 'https://']) ? $blog['image'] : asset($blog['image'])) : null;
    $fImgWidth = 1600;
    $fImgHeight = 800;
    if (!empty($blog['image'])) {
        $relPath = preg_replace('#^https?://[^/]+/#', '', (string)$blog['image']);
        $relPath = ltrim($relPath, '/');
        $imgPath = public_path($relPath);
        if (file_exists($imgPath) && !is_dir($imgPath)) {
            $sz = @getimagesize($imgPath);
            if (!empty($sz[0]) && !empty($sz[1])) {
                $fImgWidth = (int)$sz[0];
                $fImgHeight = (int)$sz[1];
            }
        }
    }
    $articleSubtitle = trim(strip_tags(html_entity_decode(html_entity_decode((string) ($blog['excerpt'] ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8'), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
    $shareUrl = rtrim(url()->current(), '/') . '/';
    $blogFaqs = !empty($blogFaqs) ? $blogFaqs : (!empty($faqs) ? $faqs : (!empty($blog['faqs']) ? (is_string($blog['faqs']) ? (json_decode($blog['faqs'], true) ?: []) : (array)$blog['faqs']) : []));
@endphp

<main class="blog-detail-section">
    <div class="container">
        
        <!-- Breadcrumbs -->
        <div class="breadcrumb" style="display: flex; align-items: center; gap: 0.5rem;">
            <a href="{{ url('/') }}" style="display: flex; align-items: center; gap: 0.3125rem;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg> Home
            </a> 
            <span style="color: #666; font-size: 0.75rem;">&gt;</span>
            <a href="{{ url('/blog') }}/">Blog</a>
            <span style="color: #666; font-size: 0.75rem;">&gt;</span>
            {{ Str::limit($fTitle, 18) }}
        </div>

        <!-- Hero Image -->
        @if(!empty($fImg))
        <div class="hero-img-wrapper" style="aspect-ratio: {{ $fImgWidth }} / {{ $fImgHeight }};">
            <img src="{{ $fImg }}" alt="{{ $fTitle }}" width="{{ $fImgWidth }}" height="{{ $fImgHeight }}" class="hero-img" loading="eager" fetchpriority="high" style="aspect-ratio: {{ $fImgWidth }} / {{ $fImgHeight }};" onerror="this.parentElement.style.display='none';">        
        </div>
        @endif
        <!-- 2 Column Layout -->
        <div class="content-layout">
            
            <!-- Left: Main Content -->
            <div class="main-content">
                
                <!-- Title & Meta -->
                <h1 class="article-title">{{ $fTitle }}</h1>
                @if(!empty($articleSubtitle))
                <p class="article-subtitle">{{ $articleSubtitle }}</p>
                @endif
                
                <div class="article-meta">
                    @if(!empty($publishDate))
                    <span>Published: {{ $publishDate }}</span>
                    @endif
                    @if(!empty($updateDate) && $updateDate !== $publishDate)
                    @if(!empty($publishDate))<span class="divider">•</span>@endif
                    <span>Last Updated: {{ $updateDate }}</span>
                    @endif
                    @if(!empty($publishDate) || !empty($updateDate))
                    <span class="divider">•</span>
                    @endif
                    <span>8 min read</span>
                </div>
                
                @php $keyTakeaways = trim($blog['key_takeaways'] ?? ''); @endphp

                @if(!empty($keyTakeaways))
                    <div class="callout-box">
                        <div class="callout-label">KEY TAKEAWAYS</div>
                        <div class="callout-content">
                            {!! $keyTakeaways !!}
                        </div>
                    </div>
                @endif

                @if(!empty($blog['content']))
                    {!! $blog['content'] !!}
                @endif

                <!-- CTA Banner -->
                <div class="cta-banner">
                    <div>
                        <div class="cta-banner-text">Need custom packaging for your product?</div>
                        <div class="cta-banner-sub">Get pricing, samples, and expert advice — no commitment required.</div>
                    </div>
                    <a href="{{ url('/contact-us') }}/" class="cta-btn">Get a Free Quote</a>
                </div>

            </div>

            <!-- Right: Sidebar -->
            <div class="sidebar">
                
                @if(!empty($authorName))
                <div class="author-share-card">
                    <!-- Author Widget -->
                    <div class="widget">
                        <div class="widget-title">Written by</div>
                        <a href="{{ $authorUrl ?: '#' }}" class="author-box" aria-label="View {{ $authorName }}'s author profile">
                            <div class="author-profile">
                                <img src="{{ $authorImg }}" alt="{{ $authorName }}" class="author-img" onerror="this.src='{{ asset('images/ahmed-khan.png') }}'">
                                <div>
                                    <div class="author-name">{{ $authorName }}</div>
                                    @if(!empty($authorDesignation))
                                    <div class="author-role">{{ $authorDesignation }}</div>
                                    @endif
                                </div>
                            </div>
                            @if(!empty($authorExpertise))
                            <div class="author-expertise">
                                {{ $authorExpertise }}
                            </div>
                            @endif
                        </a>

                        @if(!empty($authorDescription) && $authorDescription !== $authorExpertise)
                        <hr style="border: none; border-top: 1px dotted #ccc; margin: 1.875rem 0;">
                        <div class="author-description">
                            {!! $authorDescription !!}
                        </div>
                        <hr style="border: none; border-top: 1px dotted #ccc; margin: 1.875rem 0;">
                        @else
                        <hr style="border: none; border-top: 1px dotted #ccc; margin: 1.875rem 0;">
                        @endif
                    </div>
                </div>
                @endif

                <hr class="mobile-share-divider">

                <!-- Share Widget -->
                <div class="widget">
                    <div class="widget-title">Share Article</div>
                    <div class="share-icons">
                        <a href="{{ $shareUrl }}" class="share-icon" aria-label="Copy article link"><span class="visually-hidden">Copy article link</span><i class="fa-solid fa-link"></i></a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($shareUrl) }}" class="share-icon" aria-label="Share article on LinkedIn" target="_blank" rel="noopener"><span class="visually-hidden">Share article on LinkedIn</span><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($blog['title'] ?? 'Blog article') }}" class="share-icon" aria-label="Share article on X" target="_blank" rel="noopener"><span class="visually-hidden">Share article on X</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z"/>
                            </svg>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" class="share-icon" aria-label="Share article on Facebook" target="_blank" rel="noopener"><span class="visually-hidden">Share article on Facebook</span><i class="fa-brands fa-facebook-f"></i></a>
                    </div>
                </div>



            </div>

        </div>

    </div>

    <!-- Blog FAQs Section -->
    @include('components.product-faq', ['displayFaqs' => $blogFaqs])

    <!-- Related Blogs -->
    @php
        $currentBlogId = $blog['id'] ?? null;
        $currentBlogSlug = $blog['slug'] ?? '';
        $filteredRecentBlogs = collect($recentBlogs ?? [])
            ->filter(function($rb) use ($currentBlogId, $currentBlogSlug) {
                $rb = (object) $rb;
                if (empty($rb->image)) {
                    return false;
                }
                if (!empty($currentBlogId) && isset($rb->id) && (string)$rb->id === (string)$currentBlogId) {
                    return false;
                }
                if (!empty($currentBlogSlug) && isset($rb->slug) && $rb->slug === $currentBlogSlug) {
                    return false;
                }
                return true;
            })
            ->values();
    @endphp

    @if($filteredRecentBlogs->count() > 0)
    <div class="container">
        <div class="related-section">
            <h2 class="related-title">Related Blogs</h2>
            <div class="blog-grid">
                @foreach($filteredRecentBlogs as $rb)
                    @php
                        $bTitle = $rb->title ?? '';
                        $bAuthor = $rb->joined_author_name ?? ($rb->author_name ?? '');
                        $bAuthorSlug = $rb->joined_author_slug ?? ($rb->author_slug ?? ($bAuthor ? \Illuminate\Support\Str::slug($bAuthor) : ''));
                        $bSlug = $rb->slug ?? 'blog-detail';
                        $bImg = !empty($rb->image) ? (\Illuminate\Support\Str::startsWith($rb->image, ['http://', 'https://']) ? $rb->image : asset($rb->image)) : null;
                        $bUrl = url('/blog/' . $bSlug) . '/';
                    @endphp
                    <article class="blog-card">
                        <a href="{{ $bUrl }}" class="blog-card-hit-area" aria-label="Read {{ $bTitle }}"><span class="visually-hidden">Read {{ $bTitle }}</span></a>
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
                                <span>8 min read</span>
                            </div>
                            <h3>{{ $bTitle }}</h3>
                            <a href="{{ $bUrl }}" class="card-link">Read Blog <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</main>

@include('components.footer')

</body>
</html>




