@php
    $title = $page['meta_title'] ?? $page['title'];
    $metaDescription = $page['meta_description'] ?? null;
    $metaKeywords = $page['meta_keywords'] ?? null;
    $robots = $page['robots'] ?? 'index,follow';
    $pageImage = !empty($page['image']) ? $page['image'] : null;
    $pageFaqs = !empty($page['faqs']) ? (json_decode($page['faqs'], true) ?: []) : [];
@endphp
@include('components.htmlboilerplate', ['title' => $title, 'metaDescription' => $metaDescription, 'metaKeywords' => $metaKeywords, 'robots' => $robots, 'image' => $pageImage, 'schema' => $page['schema'] ?? ''])
<style>
    .dynamic-hero {
        background-color: #ffffff;
        padding: 2.5rem 1.5rem 1.875rem;
        text-align: center;
        border-bottom: 1px solid #eaeaea;
        font-family: 'DM Sans', sans-serif;
    }
    .dynamic-hero h1 {
        font-family: 'Open Sans', sans-serif;
        font-size: 2.625rem;
        font-weight: 700;
        margin-bottom: 0;
        color: var(--section-text-color, #111);
    }
    .dynamic-breadcrumb {
        font-size: 0.8125rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 1.25rem;
        color: var(--section-text-color, #111);
        text-align: left;
        max-width: var(--site-container-width, 80rem);
        margin: 0 auto 1.25rem auto;
        padding: 0 var(--site-container-gutter, 3.4375rem);
        font-family: 'Open Sans', sans-serif;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .dynamic-breadcrumb span {
        font-weight: 700;
        color: var(--section-text-color, #111);
    }
    .dynamic-container {
        max-width: var(--site-container-width, 62.5rem);
        margin: 1.875rem auto 3.75rem auto;
        padding: 0 var(--site-container-gutter, 3.4375rem);
        font-family: 'DM Sans', sans-serif;
        color: #333;
        line-height: 1.8;
        font-size: 1rem;
    }
    .dynamic-container h2, .dynamic-container h3, .dynamic-container h4, .dynamic-container h5, .dynamic-container h6 {
        font-family: 'Open Sans', sans-serif;
        color: #111;
        margin-top: 1.875rem;
        margin-bottom: 0.9375rem;
        font-weight: 700;
    }
    .dynamic-container p {
        margin-bottom: 1.25rem;
        color: #444;
    }
    .dynamic-container ul, .dynamic-container ol {
        margin-bottom: 1.25rem;
        padding-left: 1.875rem;
    }
    .dynamic-container li {
        margin-bottom: 0.625rem;
    }
    .dynamic-container a {
        color: var(--primary-color, #0B2240);
        text-decoration: underline;
        text-underline-offset: 0.1875rem;
    }
    .dynamic-container a:hover {
        color: #1a4f8b;
        text-decoration: underline;
    }
    .dynamic-container img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
        margin: 1.25rem 0;
    }

    @media (max-width: 47.9375rem) {
        .dynamic-hero h1 {
            font-size: 1.75rem;
        }
        .dynamic-breadcrumb {
            display: none;
        }
        .dynamic-container {
            margin: 1.875rem auto;
            padding: 0 1.25rem;
        }
    }
</style>

<main class="dynamic-page">
    @include('components.header')
    
    <div class="dynamic-hero">
        <div class="dynamic-breadcrumb">
            HOME / <span>{{ strtoupper($page['title']) }}</span>
        </div>
        <h1>{{ $page['heading'] ?? $page['title'] }}</h1>
    </div>

    <div class="dynamic-container">
        {!! $page['content'] !!}
    </div>

    @include('components.product-faq', ['displayFaqs' => $pageFaqs])
    @include('components.cta')
    @include('components.footer')
</main>
