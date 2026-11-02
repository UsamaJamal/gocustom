@include('components.htmlboilerplate', [
    'title' => $category['meta_title'] ?? ($category['title'] ? ($category['title'] . ' | Go Custom Boxes') : 'Custom Packaging | Go Custom Boxes'),
    'metaDescription' => !empty($category['meta_description']) 
        ? $category['meta_description'] 
        : (!empty($category['description']) 
            ? trim(strip_tags((string)$category['description'])) 
            : ('Order custom ' . ($category['title'] ?? 'packaging') . ' with premium finishes, vibrant printing, and wholesale rates at Go Custom Boxes.')),
    'metaKeywords' => $category['meta_keywords'] ?? '',
    'robots' => $category['robots'] ?? 'index,follow',
    'image' => !empty($category['hero_image']) ? $category['hero_image'] : (!empty($category['image']) ? $category['image'] : null),
    'schema' => $category['schema'] ?? '',
])

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    html,
    body {
        max-width: 100%;
    }

    /* Clothing Features Section */
    .clothing-features-section {
        background-color: #FDF7E5; 
        padding: 1rem 0;
        font-family: 'DM Sans', sans-serif;
    }

    .clothing-features-inner {
        max-width: 86rem;
        margin: 0 auto;
        padding: 0 2.5rem;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .clothing-features-title {
        text-align: center;
        font-family: 'Open Sans', sans-serif;
        font-size: 2.125rem;
        font-weight: 700;
        color: #111;
        margin-bottom: 0;
        line-height: 1.3;
    }

    .mobile-br { display: none; }
    .desktop-br { display: block; }

    .clothing-features-columns {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        align-items: start;
        gap: 5rem;
        max-width: 82rem;
        margin: 0 auto;
        width: 100%;
    }

    .clothing-feature-column {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 0;
        min-width: 0;
    }

    /* The two columns deliberately use different offsets so their items
       stagger against one another instead of forming compressed rows. */
    .clothing-feature-column--left > :nth-child(1) {
        margin-top: clamp(5rem, 9vw, 8rem);
        margin-bottom: clamp(4rem, 6vw, 5.5rem);
    }

    .clothing-feature-column--left > :nth-child(2) {
        margin-bottom: clamp(5rem, 8vw, 7rem);
    }

    .clothing-feature-column--left > :nth-child(3) {
        margin-bottom: clamp(4.5rem, 7vw, 6.5rem);
    }

    .clothing-feature-column--right > :nth-child(1) {
        align-self: flex-end;
        margin-bottom: clamp(5rem, 8vw, 7rem);
    }

    .clothing-feature-column--right > :nth-child(2) {
        margin-bottom: clamp(6rem, 9vw, 8rem);
    }

    .clothing-feature-column--right > :nth-child(3) {
        align-self: flex-end;
        margin-bottom: clamp(5rem, 8vw, 7rem);
    }

    .clothing-feature-mobile-stack { display: none; }

    .clothing-feature-text {
        flex: 1 1 0;
        min-width: 0;
        max-width: 36.25rem;
    }

    .clothing-feature-text h3 {
        font-family: 'Open Sans', sans-serif;
        font-size: 1.875rem;
        font-weight: 700;
        color: #111;
        margin-bottom: 1.125rem;
        line-height: 1.3;
    }

    .clothing-feature-text p {
        font-family: 'DM Sans', sans-serif;
        font-size: 1rem;
        line-height: 1.7;
        color: #000;
        margin: 0;
        text-align: justify;
    }

    .clothing-feature-text a,
    .clothing-feature-text p a {
        color: var(--primary-color, #5b2829);
        text-decoration: underline;
        text-decoration-color: var(--primary-color, #5b2829);
        font-weight: 600;
        transition: opacity 0.2s ease;
    }
    .clothing-feature-text a:hover,
    .clothing-feature-text p a:hover {
        opacity: 0.8;
    }

    .clothing-feature-image {
        flex: 1 1 0;
        min-width: 0;
        max-width: 27rem;
        width: 100%;
        aspect-ratio: 1.16 / 1;
        border-radius: 1rem;
        overflow: visible;
        box-shadow: none;
        background-color: transparent;
    }

    .clothing-feature-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        border-radius: 1rem;
    }

    @media (max-width: 62rem) {
        .clothing-features-section {
            padding: 1.5rem 0.9375rem 2.5rem;
        }
        .clothing-features-inner {
            padding: 0 0.625rem;
            gap: 1.5rem;
        }
        .clothing-features-columns {
            display: none;
        }

        .clothing-feature-mobile-stack {
            display: flex;
            flex-direction: column;
            gap: 1.875rem;
        }

        .clothing-feature-mobile-pair {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 1.25rem;
            width: 100%;
        }

        .clothing-feature-text, .clothing-feature-image {
            max-width: 100%;
            width: 100%;
            flex: none !important;
        }

        .clothing-feature-text { text-align: justify; }
        .clothing-feature-text p {
            text-align: justify;
        }
        .clothing-feature-image { max-width: 30rem; margin: 0; }
        .clothing-features-title {
            font-size: 1.4375rem;
            line-height: 1.4;
        }
        .mobile-br { display: block; }
        .desktop-br { display: none; }
    }

    /* Category Hero Section */
    .category-hero {
        background: linear-gradient(135deg, #FFF3DE 0%, #FDF7E5 50%, #FAF0CE 100%);
        padding: 3.75rem 0 4.375rem;
        position: relative;
        overflow: hidden;
    }

    .category-hero-inner {
        max-width: 80rem;
        margin: 0 auto;
        padding: 0 3.4375rem;
        box-sizing: border-box;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1.5rem;
    }

    .category-hero-content {
        flex: 1;
        max-width: 36.25rem;
        position: relative;
        z-index: 2;
    }

    .category-breadcrumb {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.8125rem;
        color: #555;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .category-breadcrumb a {
        color: inherit;
        text-decoration: none;
    }

    .category-hero-title {
        font-family: 'Open Sans', sans-serif;
        font-size: 2.625rem;
        font-weight: 800;
        line-height: 1.15;
        color: #111;
        margin-bottom: 1rem;
    }

    .category-hero-desc {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.9375rem;
        line-height: 1.6;
        color: #333;
        margin-bottom: 2rem;
    }

    .category-hero-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #FFB400;
        color: #111;
        font-family: 'DM Sans', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        padding: 0.875rem 1.75rem;
        border-radius: 0.25rem;
        text-decoration: none;
        gap: 0.5rem;
        transition: background 0.3s;
    }
    
    .category-hero-btn:hover {
        background: #e6a200;
    }

    .category-hero-image {
        flex: 1;
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: flex-end;
    }

    .category-hero-image img {
        max-width: 100%;
        height: auto;
        object-fit: contain;
    }

    /* Popular Boxes Section - Updated to Figma */
    .popular-boxes-section {
        background: #fff;
        padding-top: 1.25rem;
        padding-bottom: 3.75rem; /* Keep bottom padding */
    }

    .popular-boxes-inner {
        max-width: 80rem;
        margin: 0 auto;
        padding: 0 3.4375rem;
        box-sizing: border-box;
        text-align: center;
    }

    .section-title {
        font-family: 'Open Sans', sans-serif;
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: #111;
    }

    .section-subtitle {
        font-family: 'DM Sans', sans-serif;
        font-size: 15px;
        color: #000;
        margin-bottom: 40px;
    }

    .boxes-grid {
        width: 100%;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        justify-content: space-between;
    }

    .box-card {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        color: inherit;
    }

    .box-image-wrapper {
        width: 100%;
        aspect-ratio: 1;
        border-radius: 0.75rem;
        overflow: hidden;
        background-color: #E8E8E8;
        margin-bottom: 1rem;
        position: relative;
        transition: box-shadow 0.3s ease;
    }

    .box-image-wrapper img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        object-position: center;
        transition: transform 0.4s ease;
    }

    .box-card:hover .box-image-wrapper img {
        transform: scale(1.05);
    }

    .box-title {
        font-family: 'Open Sans', sans-serif;
        font-size: 1rem !important;
        font-weight: 700;
        color: #111;
        text-align: center;
        display: block;
    }

    /* Mobile Responsive View */
    @media (max-width: 62rem) {
        .category-hero-inner {
            flex-direction: column;
            text-align: center;
        }
        
        .category-hero-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .category-hero-image {
            justify-content: center;
        }
        
        .category-breadcrumb {
            justify-content: center;
        }

        .category-hero-desc {
            text-align: center;
        }
        
        .boxes-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
        }
    }

    @media (max-width: 48rem) {
        .boxes-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5vw !important;
        }
        .box-image-wrapper {
            margin-bottom: 1.5vw !important;
        }
    }

    @media (max-width: 36rem) {
        .category-hero {
            padding: 2.5rem 0 1.875rem;
        }

        .category-hero-title {
            font-size: 1.75rem;
        }
        
        .boxes-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 1.5vw !important;
        }
        .box-image-wrapper {
            margin-bottom: 1.5vw !important;
        }
        
        .popular-boxes-section {
            padding-top: 1.25rem;
            padding-bottom: 1.5rem;
        }
        
        .section-title {
            font-size: 1.75rem;
            font-weight: 700;
        }
    }

    /* Customize Section */
    .customize-section {
        
        padding: 0 0 3.375rem;
        font-family: 'Open Sans', sans-serif;
    }

    .customize-container {
        max-width: 80rem;
        margin: 0 auto;
        padding: 0 3.4375rem;
        box-sizing: border-box;
    }

    /* Unified Container Responsive Padding */
    @media (max-width: 68.75rem) {

        .popular-boxes-inner,
        .customize-container {
            padding-left: 2rem;
            padding-right: 2rem;
        }
    }

    @media (max-width: 48rem) {

        .popular-boxes-inner,
        .customize-container {
            padding-left: 1.25rem;
            padding-right: 1.25rem;
        }
    }

    @media (max-width: 36rem) {

        .popular-boxes-inner,
        .customize-container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }

    .customize-title {
        font-family: 'Open Sans', sans-serif;
        font-size: 2rem;
        font-weight: 800;
        color: var(--section-text-color);
        margin-bottom: 0.75rem;
    }

    .customize-subtitle {
        font-family: 'Open Sans', sans-serif;
        font-size: 1.125rem;
        color: var(--section-text-color);
        margin-bottom: 2.5rem;
        line-height: 1.5;
    }

    .customize-layout {
        display: flex;
        flex-direction: column;
        gap: 2.375rem;
    }

    .customize-sidebar {
        width: 100%;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        gap: 0;
        border-bottom: 1px solid #ccc; /* Bottom border for navbar */
        overflow-x: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
        padding-bottom: 0;
    }
    
    .customize-sidebar::-webkit-scrollbar {
        display: none;
    }

    .customize-tab {
        flex: 1;
        min-width: fit-content;
        padding: 0.75rem 0.625rem;
        text-align: center;
        background: transparent;
        border: none;
        border-bottom: 0.1875rem solid transparent;
        font-family: 'Open Sans', sans-serif;
        font-weight: 700;
        font-size: 0.8125rem;
        color: #111;
        cursor: pointer;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
        margin-bottom: -1px; /* Overlap the container's bottom border */
    }

    .customize-tab.active,
    .customize-tab:hover,
    .customize-tab:focus-visible {
        color: #fff;
        background: #112a46; /* Matching the active tab from the Figma image */
        border-bottom: 0.1875rem solid #112a46;
    }
    
    .customize-tab:not(.active):hover {
        background: #f0f0f0;
        color: #111;
        border-bottom: 0.1875rem solid #f0f0f0;
    }

    .customize-content {
        width: 100%;
        overflow: hidden;
    }

    .customize-grid {
        display: flex;
        flex-direction: row;
        gap: 1.25rem;
        width: max-content;
        animation: marqueeTrain 30s linear infinite;
        padding-bottom: 0.625rem;
    }
    
    .customize-grid:hover {
        animation-play-state: paused;
    }

    @keyframes marqueeTrain {
        0% { transform: translateX(0); }
        100% { transform: translateX(calc(-50% - 0.625rem)); }
    }

    .custom-card {
        flex: 0 0 auto;
        width: 13.75rem;
        background: #FFF;
        border-radius: 0.75rem;
        padding: 0.75rem;
        display: flex;
        flex-direction: column;
        transition: opacity 0.2s ease, transform 0.2s ease;
        text-align: center;
    }

    .custom-img-wrapper {
        width: 100%;
        aspect-ratio: 1;
        border-radius: 0.5rem;
        overflow: hidden;
        margin-bottom: 0.875rem;
        background: #f7f7f7;
    }

    .custom-img-wrapper img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .custom-card .h4-style {
        font-family: 'Open Sans', sans-serif;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--section-text-color);
        margin: 0;
        padding: 0 0 0.125rem;
        line-height: 1.3;
    }

    .custom-card .custom-card-title {
        font-family: 'Open Sans', sans-serif;
        font-size: 0.875rem !important;
        font-weight: 600;
        color: var(--section-text-color);
        margin: 0;
        padding: 0 0 0.125rem;
        line-height: 1.3;
        display: block;
    }

    @media (max-width: 36rem) {
        .customize-section {
            padding: 0 0 2.25rem;
        }

        .customize-title {
            font-size: 1.375rem;
            line-height: 1.25;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .customize-subtitle {
            font-size: 0.8125rem;
            line-height: 1.35;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .customize-sidebar {
            display: flex !important;
            flex-direction: row !important;
            gap: 0 !important;
            padding-bottom: 0 !important;
            overflow-x: auto !important;
            scrollbar-width: none;
            -ms-overflow-style: none;
            border-bottom: 1px solid #ccc !important;
        }

        .customize-sidebar::-webkit-scrollbar {
            display: none;
        }

        .customize-tab {
            width: auto !important;
            flex: 0 0 auto !important;
            height: 2.75rem !important;
            min-height: 0 !important;
            padding: 0.625rem 1rem !important;
            font-size: 0.875rem !important;
            font-weight: 700;
            text-align: center;
            white-space: nowrap !important;
            border-radius: 0.25rem 0.25rem 0 0 !important;
            margin-bottom: -1px;
        }

        .customize-grid {
            display: flex !important;
            flex-direction: row !important;
            gap: 0.75rem !important;
            overflow-x: auto !important;
            scrollbar-width: none;
            -ms-overflow-style: none;
            padding-bottom: 0.625rem !important;
        }
        
        .customize-grid::-webkit-scrollbar {
            display: none;
        }

        .custom-card {
            flex: 0 0 12.5006rem !important;
            width: 12.5006rem !important;
            padding: 0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            background: transparent !important;
            text-align: center !important;
        }

        .custom-img-wrapper {
            width: 100% !important;
            border-radius: 0.2944rem !important;
            margin-bottom: 0.625rem !important;
            background: transparent !important;
            overflow: hidden;
        }

        .custom-card .h4-style {
            font-size: 0.8125rem;
            font-weight: 600;
            color: #111;
            text-align: center !important;
            padding-left: 0;
            line-height: 1.3;
        }

        .custom-card .custom-card-title {
            font-size: 0.875rem !important;
            font-weight: 600;
            color: #111;
            text-align: center !important;
            line-height: 1.3;
            display: block;
        }
    }
</style>


    @include('components.header')

    <main>
        @include('components.herohome', ['settings' => $category ?? []])

        @include('components.logo')

        @php
            $catProducts = !empty($products) ? (is_object($products) ? $products->toArray() : $products) : [];
        @endphp

        <!-- Popular Boxes Section -->
        @if(count($catProducts) > 0)
        <section class="popular-boxes-section">
            <div class="popular-boxes-inner">
                <h2 class="section-title">{{ $category['products_heading'] ?: 'Packaging Made For Every Product' }}</h2>
                <p class="section-subtitle">{{ $category['products_description'] ?: 'Explore products available in this category, designed to fit your style and requirements.' }}</p>

                <div class="boxes-grid">
                    @foreach ($catProducts as $p)
                        @php
                            $pImg = '';
                            $pGalleryRaw = [];
                            if (!empty($p['images'])) {
                                $pGalleryRaw = is_string($p['images'])
                                    ? (json_decode($p['images'], true) ?:
                                    [])
                                    : (array) $p['images'];
                            }
                            
                            if (!empty($p['image'])) {
                                $pImg = $p['image'];
                            } elseif (!empty($pGalleryRaw)) {
                                $pImg = $pGalleryRaw[0];
                            } else {
                                $pImg = 'uploads/allcategory-cta.webp';
                            }
                            
                            $pImg = \Illuminate\Support\Str::startsWith($pImg, ['storage/', 'uploads/', 'images/'])
                                ? $pImg
                                : 'storage/' . $pImg;

                            $pSlug = $p['slug'] ?? \Illuminate\Support\Str::slug($p['title']);
                            
                            $imgName = pathinfo(parse_url(asset($pImg), PHP_URL_PATH), PATHINFO_FILENAME);
                            $imgCleanName = ucwords(str_replace(['-', '_'], ' ', preg_replace('/-[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}/i', '', $imgName)));
                        @endphp
                        <a href="{{ url('/' . $pSlug) }}/" class="box-card">
                            <div class="box-image-wrapper">
                                <img src="{{ asset($pImg) }}" alt="{{ $imgCleanName }}" title="{{ $imgCleanName }}" class="main-img"
                                    onerror="this.src='https://placehold.co/284x284/dddddd/555555?text={{ urlencode($imgCleanName) }}'" loading="lazy">
                            </div>
                            <span class="box-title">{{ $p['title'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div><!-- end .popular-boxes-inner -->
        </section>
        @endif

        @include('components.coating-finishing')
        
        @include('components.customquote', ['quoteSource' => 'Category Page - Get Custom Quote'])

        @php
            $featureSections = json_decode($category['feature_sections'] ?? '[]', true) ?: [];
        @endphp
        @if(count($featureSections))
            <section class="clothing-features-section">
                <div class="clothing-features-inner">
                    @if(!empty($category['feature_title']))
                        <h2 class="clothing-features-title">{{ $category['feature_title'] }}</h2>
                    @endif

                    <div class="clothing-features-columns">
                        <div class="clothing-feature-column clothing-feature-column--left">
                            @foreach($featureSections as $feature)
                                @php
                                    $featureImage = $feature['image'] ?? '';
                                    $featureImagePath = \Illuminate\Support\Str::startsWith($featureImage, ['storage/', 'uploads/', 'images/']) ? $featureImage : 'storage/' . $featureImage;
                                @endphp
                                @if($loop->odd)
                                    <div class="clothing-feature-text">
                                        @if(!empty($feature['title']))<h3>{{ $feature['title'] }}</h3>@endif
                                        @if(!empty($feature['description']))
                                            {!! \Illuminate\Support\Str::contains($feature['description'], ['<p>', '<a', '<div']) ? $feature['description'] : '<p>' . nl2br($feature['description']) . '</p>' !!}
                                        @endif
                                    </div>
                                @elseif(!empty($featureImage))
                                    @php
                                        $featureDisplayTitle = !empty($feature['title']) ? $feature['title'] : ($category['title'] ?? '');
                                        if (empty($featureDisplayTitle)) {
                                            $featureImgName = pathinfo(parse_url(asset($featureImagePath), PHP_URL_PATH), PATHINFO_FILENAME);
                                            $cleanName = preg_replace('/-[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}/i', '', $featureImgName);
                                            $cleanName = preg_replace('/-[0-9a-fA-F]{8,}/i', '', $cleanName);
                                            $cleanName = preg_replace('/[-_]\d+$/', '', $cleanName);
                                            $featureDisplayTitle = ucwords(trim(str_replace(['-', '_'], ' ', $cleanName)));
                                        }
                                    @endphp
                                    <div class="clothing-feature-image">
                                        <img src="{{ asset($featureImagePath) }}" alt="{{ $featureDisplayTitle }}" title="{{ $featureDisplayTitle }}" loading="lazy">
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="clothing-feature-column clothing-feature-column--right">
                            @foreach($featureSections as $feature)
                                @php
                                    $featureImage = $feature['image'] ?? '';
                                    $featureImagePath = \Illuminate\Support\Str::startsWith($featureImage, ['storage/', 'uploads/', 'images/']) ? $featureImage : 'storage/' . $featureImage;
                                @endphp
                                @if($loop->odd && !empty($featureImage))
                                    @php
                                        $featureDisplayTitle = !empty($feature['title']) ? $feature['title'] : ($category['title'] ?? '');
                                        if (empty($featureDisplayTitle)) {
                                            $featureImgName = pathinfo(parse_url(asset($featureImagePath), PHP_URL_PATH), PATHINFO_FILENAME);
                                            $cleanName = preg_replace('/-[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}/i', '', $featureImgName);
                                            $cleanName = preg_replace('/-[0-9a-fA-F]{8,}/i', '', $cleanName);
                                            $cleanName = preg_replace('/[-_]\d+$/', '', $cleanName);
                                            $featureDisplayTitle = ucwords(trim(str_replace(['-', '_'], ' ', $cleanName)));
                                        }
                                    @endphp
                                    <div class="clothing-feature-image">
                                        <img src="{{ asset($featureImagePath) }}" alt="{{ $featureDisplayTitle }}" title="{{ $featureDisplayTitle }}" loading="lazy">
                                    </div>
                                @elseif($loop->even)
                                    <div class="clothing-feature-text">
                                        @if(!empty($feature['title']))<h3>{{ $feature['title'] }}</h3>@endif
                                        @if(!empty($feature['description']))
                                            {!! \Illuminate\Support\Str::contains($feature['description'], ['<p>', '<a', '<div']) ? $feature['description'] : '<p>' . nl2br($feature['description']) . '</p>' !!}
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="clothing-feature-mobile-stack">
                        @foreach($featureSections as $feature)
                            @php
                                $featureImage = $feature['image'] ?? '';
                                $featureImagePath = \Illuminate\Support\Str::startsWith($featureImage, ['storage/', 'uploads/', 'images/']) ? $featureImage : 'storage/' . $featureImage;
                            @endphp
                            <div class="clothing-feature-mobile-pair">
                                @if(!empty($featureImage))
                                    @php
                                        $featureDisplayTitle = !empty($feature['title']) ? $feature['title'] : ($category['title'] ?? '');
                                        if (empty($featureDisplayTitle)) {
                                            $featureImgName = pathinfo(parse_url(asset($featureImagePath), PHP_URL_PATH), PATHINFO_FILENAME);
                                            $cleanName = preg_replace('/-[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}/i', '', $featureImgName);
                                            $cleanName = preg_replace('/-[0-9a-fA-F]{8,}/i', '', $cleanName);
                                            $cleanName = preg_replace('/[-_]\d+$/', '', $cleanName);
                                            $featureDisplayTitle = ucwords(trim(str_replace(['-', '_'], ' ', $cleanName)));
                                        }
                                    @endphp
                                    <div class="clothing-feature-image">
                                        <img src="{{ asset($featureImagePath) }}" alt="{{ $featureDisplayTitle }}" title="{{ $featureDisplayTitle }}" loading="lazy">
                                    </div>
                                @endif
                                <div class="clothing-feature-text">
                                    @if(!empty($feature['title']))<h3>{{ $feature['title'] }}</h3>@endif
                                    @if(!empty($feature['description']))
                                        {!! \Illuminate\Support\Str::contains($feature['description'], ['<p>', '<a', '<div']) ? $feature['description'] : '<p>' . nl2br($feature['description']) . '</p>' !!}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- ═══════════════════════════════════════
             CONTENT SECTION
        ═══════════════════════════════════════ --}}
        @if(!empty($category['content_section']))
            @include('components.content', ['settings' => $category])
        @endif

        {{-- ═══════════════════════════════════════
             TESTIMONIALS & FAQ SECTION
        ═══════════════════════════════════════ --}}
        @include('components.testimonials_faq')


        @include('components.cta')

    </main>

    @include('components.footer')

    <script>
        function toggleFaq(btn) {
            const item = btn.closest('.faq-item');
            const isOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item.open').forEach(function(el) {
                el.classList.remove('open');
                el.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
            });
            if (!isOpen) {
                item.classList.add('open');
                btn.setAttribute('aria-expanded', 'true');
            }
        }
    </script>

</body>

</html>
