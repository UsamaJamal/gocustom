@props([
    'title' => 'About Us',
    'subtitle' => null,
    'description' => null,
    'desc' => null,
    'bgImage' => 'uploads/about-go-custom-boxes.webp',
    'mobileBgImage' => null,
    'bg' => null,
    'breadcrumb' => 'About Us',
    'breadcrumbs' => [],
    'overlay' => 'rgba(0, 0, 0, 0.6)',
    'alt' => null,
])

@php
    $finalTitle = $title ?? 'About Us';
    $finalDesc = $description ?? $desc ?? $subtitle ?? '';
    $rawBg = $bg ?? $bgImage ?? 'uploads/about-go-custom-boxes.webp';
    $finalBg = \Illuminate\Support\Str::startsWith($rawBg, ['http://', 'https://']) ? $rawBg : asset($rawBg);
    $finalMobileBg = $mobileBgImage ? (\Illuminate\Support\Str::startsWith($mobileBgImage, ['http://', 'https://']) ? $mobileBgImage : asset($mobileBgImage)) : $finalBg;
    // Spaces would split a srcset value, so encode them in both URLs.
    $finalBg = str_replace(' ', '%20', $finalBg);
    $finalMobileBg = str_replace(' ', '%20', $finalMobileBg);
    // The banner is a real <img>, so it has alt text. Same rule as the page's share image
    // (og:image:alt): the given alt, else a name made from the file name.
    $finalAlt = trim((string) $alt) !== '' ? trim((string) $alt) : \App\Support\ShareImage::altFromFileName($rawBg);
@endphp

<style>
    .about-hero-component {
        background-color: #0a2240;
        color: #fff;
        padding: 2.5rem 0 6.25rem 0;
        position: relative;
        overflow: hidden;
        width: 100%;
        box-sizing: border-box;
    }
    /* Banner image and its colour overlay sit behind the breadcrumb and heading. The image
       is stretched to the box (object-fit: fill), as the old background-size: 100% 100% was. */
    .about-hero-bg,
    .about-hero-bg img,
    .about-hero-overlay {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .about-hero-bg {
        display: block;
        margin: 0;
    }
    .about-hero-bg img {
        display: block;
        max-width: none;
        object-fit: fill;
    }
    .about-hero-overlay {
        background: {{ $overlay }};
    }
    .about-hero-component .about-hero-container,
    .about-hero-component .about-hero-content {
        position: relative;
        z-index: 1;
    }
    .about-hero-component,
    .about-hero-component * {
        box-sizing: border-box;
    }
    .about-hero-container {
        width: 100% !important;
        max-width: 80rem !important;
        margin: 0 auto !important;
        padding: 0 3.4375rem !important;
        box-sizing: border-box !important;
        min-width: 0;
    }
    .about-hero-breadcrumb {
        font-family: 'DM Sans', 'Open Sans', sans-serif;
        font-size: 0.9375rem;
        font-weight: 500;
        line-height: 1.6;
        height: 1.5rem;
        margin: 0 0 1.25rem 0;
        padding: 0;
        color: #ffffff !important;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-align: left;
    }
    .about-hero-breadcrumb a {
        color: #ffffff;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        transition: opacity 0.2s ease;
    }
    .about-hero-breadcrumb a:hover {
        opacity: 0.85;
    }
    .about-hero-breadcrumb svg {
        flex-shrink: 0;
    }
    .about-hero-content {
        margin: 3.75rem 0 0 0;
        padding: 0;
        text-align: center;
    }
    .about-hero-content h1 {
        font-family: 'Open Sans', sans-serif;
        font-size: 3rem;
        font-weight: 700;
        margin: 0 0 1.25rem 0;
        padding: 0;
        color: #ffffff !important;
        line-height: 1.2;
    }
    .about-hero-content p {
        font-family: 'DM Sans', sans-serif;
        font-size: 1.0625rem;
        max-width: 42.5rem;
        margin: 0 auto;
        padding: 0;
        line-height: 1.6;
        color: #ffffff !important;
    }

    @media (max-width: 48rem) {
        .about-hero-component {
            padding: 5rem 1.25rem;
            min-height: 460px;
        }
        .about-hero-container {
            padding: 0 !important;
        }
        .about-hero-breadcrumb {
            display: none !important;
        }
        .about-hero-content {
            margin-top: 0;
        }
        .about-hero-content h1 {
            font-size: 2.25rem;
        }
    }
</style>

<section class="about-hero-component">
    <picture class="about-hero-bg">
        @if($finalMobileBg !== $finalBg)
            <source media="(max-width: 48rem)" srcset="{{ $finalMobileBg }}">
        @endif
        {{-- data-keep-alt: the header script that renames every image alt after its file leaves a given alt alone. --}}
        <img src="{{ $finalBg }}" alt="{{ $finalAlt }}" fetchpriority="high" @if(trim((string) $alt) !== '') data-keep-alt @endif>
    </picture>
    <span class="about-hero-overlay" aria-hidden="true"></span>
    <div class="about-hero-container" style="text-align: left;">
        <nav class="about-hero-breadcrumb" aria-label="Breadcrumb">
            <a href="/">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 1.125rem; height: 1.125rem;">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Home</span>
            </a>
            @if(!empty($breadcrumbs))
                @foreach($breadcrumbs as $b)
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 0.875rem; height: 0.875rem; opacity: 0.9;">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    @if(is_array($b) && isset($b['url']) && !$loop->last)
                        <a href="{{ $b['url'] }}">{{ $b['title'] ?? $b['name'] }}</a>
                    @else
                        <span aria-current="page">{{ is_array($b) ? ($b['title'] ?? $b['name'] ?? '') : $b }}</span>
                    @endif
                @endforeach
            @else
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 0.875rem; height: 0.875rem; opacity: 0.9;">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                <span aria-current="page">{{ $breadcrumb }}</span>
            @endif
        </nav>
    </div>
    <div class="about-hero-content">
        <h1>{!! $finalTitle !!}</h1>
        @if(!empty($finalDesc))
            <p>{!! $finalDesc !!}</p>
        @endif
    </div>
</section>
