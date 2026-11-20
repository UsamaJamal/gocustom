<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0B2240">
    <link rel="icon" href="{{ asset('uploads/go-custom-boxes-favicon.png') }}" type="image/png">
    <title>{{ $title ?? 'Custom Packaging | Go Custom Boxes' }}</title>
    @php
        $bpTitle = $title ?? 'Custom Packaging | Go Custom Boxes';
        $bpDesc = !empty($metaDescription) 
            ? $metaDescription 
            : 'Custom printed rigid packaging boxes at wholesale rates. Premium luxury boxes for retail, cosmetic, and gift packaging.';
    @endphp
    <meta name="description" content="{{ $bpDesc }}">
    @if(!empty($metaKeywords))
        <meta name="keywords" content="{{ $metaKeywords }}">
    @endif
    @if(!empty($robots))
        <meta name="robots" content="{{ $robots }}">
    @endif
    <meta name="author" content="{{ $author ?? 'Go Custom Boxes' }}">
    <meta name="publisher" content="{{ $publisher ?? 'Go Custom Boxes' }}">

    @php
        $bpPath = trim(request()->path(), '/');
        $bpUrl = $bpPath === '' ? rtrim(url('/'), '/') : rtrim(url('/' . $bpPath), '/') . '/';
        // Share image = the page's own image ('image', with its 'imageAlt'), else the site default.
        $bpShare = \App\Support\ShareImage::make(!empty($image) ? $image : ($ogImage ?? null), $imageAlt ?? null);
        $bpImage = $bpShare['url'];
        $bpImageAlt = $bpShare['alt'];
    @endphp

    <!-- Open Graph / Facebook -->
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $bpTitle }}">
    <meta property="og:description" content="{{ $bpDesc }}">
    <meta property="og:url" content="{{ $bpUrl }}">
    <meta property="og:image" content="{{ $bpImage }}">
    <meta property="og:image:alt" content="{{ $bpImageAlt }}">
    <meta property="og:site_name" content="Go Custom Boxes">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $bpTitle }}">
    <meta name="twitter:description" content="{{ $bpDesc }}">
    <meta name="twitter:image" content="{{ $bpImage }}">
    <meta name="twitter:image:alt" content="{{ $bpImageAlt }}">

    @include('components.canonical')
    <!-- Import Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Open+Sans:wght@300;400;600;700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            overflow-x: clip;
            width: 100%;
        }

        body {
            font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--background-color);
            color: #000000;
            line-height: 1.6;
        }

        p {
            font-family: 'DM Sans', sans-serif;
            color: var(--section-text-color);
            /* Keep paragraph copy consistent throughout every public page. */
            font-size: 16px !important;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Open Sans', sans-serif;
            color: var(--section-text-color);
            font-size: 1.5rem;
        }

        /* Shared content boundary: keep every page section aligned to header. */
        main > section > [class*="container"],
        main > section > [class*="inner"] {
            width: 100% !important;
            max-width: 80rem !important;
            margin-left: auto !important;
            margin-right: auto !important;
            padding-left: 3.4375rem !important;
            padding-right: 3.4375rem !important;
            box-sizing: border-box !important;
            min-width: 0;
        }

        @media (max-width: 48rem) {
            main > section > [class*="container"],
            main > section > [class*="inner"] {
                padding-left: 1.25rem !important;
                padding-right: 1.25rem !important;
            }
        }

        @media (max-width: 30rem) {
            main > section > [class*="container"],
            main > section > [class*="inner"] {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
        }
    </style>
</head>
<body>
