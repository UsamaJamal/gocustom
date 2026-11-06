<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no">
    <meta name="theme-color" content="#0B2240">
    <link rel="icon" href="{{ asset('uploads/go-custom-boxes-favicon.png') }}" type="image/png">

    @php
        $prodMetaTitle = !empty(trim((string)($product['meta_title'] ?? ''))) 
            ? $product['meta_title'] 
            : (!empty(trim((string)($product['title'] ?? ''))) ? $product['title'] . ' | Go Custom Boxes' : 'Custom Packaging | Go Custom Boxes');
        $prodMetaDescription = !empty(trim((string)($product['meta_description'] ?? ''))) 
            ? $product['meta_description'] 
            : (!empty(trim((string)($product['description'] ?? ''))) ? trim(strip_tags((string)$product['description'])) : 'Custom printed rigid packaging boxes at wholesale rates. Premium luxury boxes for retail, cosmetic, and gift packaging.');
        $prodMetaKeywords = !empty(trim((string)($product['meta_keywords'] ?? ''))) ? $product['meta_keywords'] : '';
        $prodRobots = !empty(trim((string)($product['robots'] ?? ''))) ? $product['robots'] : 'index,follow';
        $prodImg = !empty($product['image']) 
            ? (\Illuminate\Support\Str::startsWith($product['image'], ['http://', 'https://']) ? $product['image'] : asset($product['image'])) 
            : asset('uploads/Home-Banner.webp');
    @endphp

    <title>{{ $prodMetaTitle }}</title>
    @if(!empty($prodMetaDescription))
    <meta name="description" content="{{ $prodMetaDescription }}">
    @endif
    @if(!empty($prodMetaKeywords))
    <meta name="keywords" content="{{ $prodMetaKeywords }}">
    @endif
    <meta name="robots" content="{{ $prodRobots }}">
    <meta name="author" content="Go Custom Boxes">
    <meta name="publisher" content="Go Custom Boxes">

    <!-- Open Graph / Facebook -->
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $prodMetaTitle }}">
    @if(!empty($prodMetaDescription))
    <meta property="og:description" content="{{ $prodMetaDescription }}">
    @endif
    <meta property="og:url" content="{{ rtrim(url()->current(), '/') }}/">
    <meta property="og:image" content="{{ $prodImg }}">
    <meta property="og:image:alt" content="{{ $prodMetaTitle }}">
    <meta property="og:site_name" content="Go Custom Boxes">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $prodMetaTitle }}">
    @if(!empty($prodMetaDescription))
    <meta name="twitter:description" content="{{ $prodMetaDescription }}">
    @endif
    <meta name="twitter:image" content="{{ $prodImg }}">
    <meta name="twitter:image:alt" content="{{ $prodMetaTitle }}">

    @include('components.canonical')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Open+Sans:wght@300;400;600;700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <style>
        /* Global paragraph justification requested by user */
        p { text-align: justify; }
        
        /* Remove number input spinners globally */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
        input[type=number] {
            -moz-appearance: textfield;
        }

        :root {
            --primary-color: #8D4445;
            --secondary-color: #F8EEEC;
            --background-color: #FAF8F8;
            --footer-color: #5F2D2F;
            --header-gradient: linear-gradient(278.74deg, #AB5A5B 0.2%, #8D4445 44.25%, #5B2829 88.3%);
            
            --color-text-primary: #2D2D2D;
            --color-text-secondary: #666666;
            --color-text-tertiary: #999999;
            --color-border: #E5E5E5;
            --color-card-bg: #FFFFFF;
            
            --container-width: 80rem;
            --margin-sides: 3.4375rem;
        }

        body, body * {
            text-shadow: none !important;
            -webkit-text-stroke: 0 !important;
            filter: none !important;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            max-width: 100vw;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #FAF8F8;
            color: var(--color-text-primary);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Open Sans', sans-serif;
            color: var(--color-text-primary);
            font-weight: 700;
        }

        .container {
            width: 100%;
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 0 var(--margin-sides);
            box-sizing: border-box;
        }

        /* Hero Section */
        .hero-section {
            padding: 2.5rem 0 2.5rem;
            background-color: #FAF8F8;
        }
        
        .hero-container {
            display: flex;
            gap: 1.5rem;
            align-items: stretch;
        }

        .hero-container .hero-quote-box {
            display: flex !important;
            flex-direction: column !important;
            align-self: stretch;
        }

        .hero-quote-box form {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .hero-quote-box form > div:last-child {
            margin-top: auto !important;
        }

        .hero-quote-box form > .input-group {
            display: flex;
            flex-direction: column;
        }

        .hero-quote-box form > .input-group textarea.quote-input {
            flex: 1;
            height: 100% !important;
            min-height: 5.5rem !important;
            max-height: none !important;
        }

        .hero-images {
            flex: 0 0 44%;
            min-width: 0;
            max-width: 44%;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-self: flex-start;
            gap: 0.5rem;
        }
        
        .hero-details {
            flex: 1 1 0;
            min-width: 0;
            max-width: 50%;
        }
        
        .main-image {
            width: 100%;
            max-height: 40rem;
            aspect-ratio: 396 / 371;
            margin: 0; /* Left align */
            background-color: transparent;
            border-radius: 0.75rem;
            border: 1px solid var(--primary-color);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .main-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: default;
            transition: transform 0.25s cubic-bezier(0.25, 1, 0.5, 1), transform-origin 0.05s ease-out;
            will-change: transform, transform-origin;
        }

        .in-stock-tag {
            position: absolute;
            top: 0.5rem;
            right: 0.625rem;
            background-color: #e6f7eb;
            color: #111;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            display: none;
            align-items: center;
            gap: 0.375rem;
            z-index: 10;
        }

        .stock-dot {
            width: 0.5rem;
            height: 0.5rem;
            background-color: #38c172;
            border-radius: 50%;
            display: inline-block;
        }
        
        .thumbnails {
            display: flex;
            gap: 0.75rem;
            justify-content: flex-start;
            width: 100%;
        }
        
        .thumb {
            width: calc((100% - 2.25rem) / 4);
            aspect-ratio: 1 / 1;
            background-color: #FFFFFF;
            border-radius: 0.5rem;
            cursor: pointer;
            border: 1px solid #0B2545;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            opacity: 0.85;
        }

        .thumb::after {
            
            position: absolute;
            top: 0;
            right: 0;
            width: 2.1875rem;
            height: 1rem;
            background-color: #F2F4F5;
            border-bottom-left-radius: 0.25rem;
        }
        
        .thumb.active {
            border: 2px solid var(--primary-color, #0B2545);
            opacity: 1;
        }

        .thumb:hover {
            opacity: 1;
        }
        
        .trust-badges-container {
            background: #F2F2F2;
            padding: 0.75rem 1.25rem;
            border-radius: 0.5rem;
            display: flex;
            gap: 1.875rem;
            margin-top: 1.25rem;
            align-items: center;
            justify-content: center;
            min-height: 3.75rem;
        }
        
        .trust-badge {
            display: flex;
            align-items: center;
            gap: 0.9375rem;
            font-size: 0.8125rem;
            color: #333;
        }

        /* Product Form */
        .hero-form {
            flex: 1 1 0;
            min-width: 0;
            max-width: 100%;
            padding: 0;
        }

        .hero-form h1 {
            font-size: 2rem;
            margin-top: -0.5rem;
            margin-bottom: 0.625rem;
            color: #000;
            line-height: 1.2;
        }
        .hero-form > p {
            color: #000;
            font-size: 0.875rem;
            line-height: 1.6;
            margin-bottom: 0.9375rem;
        }

        .hero-form > p {
            color: #000;
            font-size: 0.875rem;
            line-height: 1.6;
            margin-bottom: 0.9375rem;
        }

        .hero-form > p.desc-text {
            margin-bottom: 0.9375rem;
        }

        .read-more-btn {
            color: var(--primary-color);
            cursor: pointer;
            font-family: 'Open Sans', sans-serif;
            font-weight: 700;
            font-size: 0.875rem;
            text-decoration: none;
        }


        .section-label {
            display: block;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.375rem;
            font-size: 0.875rem;
        }

        .form-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .form-grid-pref {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }
        
        .form-grid-4 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 5rem;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .mobile-title-desc {
            display: none;
        }

        @media (max-width: 61.9375rem) {
            .desktop-title-desc {
                display: none !important;
            }
            .mobile-title-desc {
                display: block;
                margin-top: 0;
            }
            .hero-container {
                flex-direction: column;
                gap: 1.875rem;
            }
            .trust-badges-container,
            .features-badges-section {
                display: none !important;
            }
        }


        .form-grid-2-upload {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }
        
        .file-upload-wrap {
            display: flex;
        }
        
        .file-upload-wrap input[type="text"] {
            border-radius: 0.375rem 0 0 0.375rem;
            border-right: none;
            background: #fff;
            flex: 1;
        }
        
        .file-upload-wrap .upload-btn {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            padding: 0 1.25rem;
            border-radius: 0 0.375rem 0.375rem 0;
            cursor: pointer;
            font-weight: 600;
        }

        .input-wrap input, .input-wrap select, .form-control {
            width: 100%;
            height: 2.8125rem;
            padding: 0.75rem 0.9375rem;
            border: 1px solid var(--color-border);
            border-radius: 0.375rem;
            font-family: inherit;
            font-size: 0.9375rem;
            outline: none;
            transition: border-color 0.3s;
            background: #fff;
            box-sizing: border-box;
        }

        textarea.form-control {
            width: 100%;
            min-height: 6.25rem;
            height: auto;
            padding: 0.75rem 0.9375rem;
            border: 1px solid var(--color-border);
            border-radius: 0.375rem;
            font-family: inherit;
            font-size: 0.9375rem;
            outline: none;
            transition: border-color 0.3s;
            background: #fff;
            box-sizing: border-box;
            resize: vertical;
        }

        /* Custom Select Arrow Styling */
        .input-wrap select, select.form-control {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='black' stroke='black' stroke-width='1' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.9375rem center;
            background-size: 0.875rem;
            padding-right: 2.5rem;
        }

        /* Hide number input spin buttons */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }
        
        .input-wrap input:focus, .input-wrap select:focus, .form-control:focus, textarea.form-control:focus {
            border-color: var(--primary-color);
            outline: none;
        }
        
        /* Custom JS Select Styling */
        .custom-select-wrapper {
            position: relative;
            width: 100%;
        }
        
        .custom-select-trigger {
            width: 100%;
            height: 2.8125rem;
            padding: 0.75rem 2.5rem 0.75rem 0.9375rem;
            border: 1px solid var(--color-border);
            border-radius: 0.375rem;
            font-family: inherit;
            font-size: 0.9375rem;
            background: #fff;
            cursor: pointer;
            position: relative;
            user-select: none;
            text-align: left;
            color: var(--color-text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            box-sizing: border-box;
            display: flex;
            align-items: center;
        }

        .custom-select-trigger::after {
            content: '';
            position: absolute;
            right: 0.9375rem;
            top: 50%;
            transform: translateY(-50%);
            width: 0.875rem;
            height: 0.875rem;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='black' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            pointer-events: none;
        }

        .custom-select-trigger.open {
            border-color: var(--primary-color);
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        .custom-options {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid var(--primary-color);
            border-top: none;
            border-radius: 0 0 0.375rem 0.375rem;
            z-index: 99;
            display: none;
            max-height: 12.5rem;
            overflow-y: auto;
            box-shadow: 0 0.25rem 0.375rem rgba(0,0,0,0.1);
        }

        .custom-options.open {
            display: block;
        }

        .custom-option {
            padding: 0.625rem 0.9375rem;
            font-size: 0.9375rem;
            cursor: pointer;
            transition: background-color 0.2s, color 0.2s;
        }

        .custom-option:hover, .custom-option.selected {
            background-color: var(--primary-color);
            color: #fff;
        }

        .btn-primary {
            display: block;
            width: 100%;
            max-width: 18.75rem;
            margin: 0 auto;
            background-color: var(--primary-color);
            color: #fff;
            text-align: center;
            padding: 1rem;
            border-radius: 0.375rem;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 1.25rem;
        }
        
        .btn-primary:hover {
            background-color: var(--footer-color);
        }

        /* Features Badges Section */
        .features-badges-section {
            background-color: #EFEFEF;
            padding: 1.25rem 0;
            width: 100%;
            position: relative;
            z-index: 10;
        }

        .badges-horizontal {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.25rem;
            flex-wrap: wrap;
        }

        .trust-badges-wrapper,
        .features-badges-wrapper,
        .shipping-badge-wrapper,
        .fourth-badge-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 0.625rem;
        }

        .badge-label {
            display: inline-block;
            font-family: 'Inter', sans-serif;
            font-size: 0.8125rem;
            color: #333333;
            font-weight: 600;
            line-height: 1.3;
            text-align: center;
        }

        .badge-icon-svg {
            width: 3.5rem;
            height: 3.5rem;
            flex: 0 0 3.5rem;
            object-fit: contain;
            color: #666;
        }

        /* Tabs Section */
        .tabs-section {
            background: transparent;
            padding: 1.25rem 0;
            border-bottom: none;
            border-top: none;
            margin-bottom: 0;
        }
        
        .tabs-list {
            display: flex;
            gap: 0;
            list-style: none;
            justify-content: center;
            background: #FFFFFF;
            border: 0.125rem solid #8d4445;
            border-radius: 3.125rem;
            padding: 0.5rem;
            max-width: fit-content;
            margin: 0 auto;
        }
        
        .tab-item {
            padding: 0.75rem 2rem;
            border-radius: 3.125rem;
            font-family: 'Open Sans', sans-serif;
            font-weight: 600;
            font-size: 1.125rem;
            line-height: 1.5rem;
            letter-spacing: 0.01em;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
        }
        
        .tab-item.active {
            background: #8d4445;
            color: #fff;
        }
        
        .tab-item:not(.active) {
            color: var(--section-text-color);
            background: transparent;
        }
        
        .tab-item:not(.active):hover {
            color: var(--primary-color);
        }

        /* Content Section */
        .content-section {
            padding-bottom: 3.75rem;
            word-spacing: 0.08em;
        }
        
        .content-section h2 {
            font-family: 'Open Sans', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 2.5rem;
            letter-spacing: 0.02em;
            text-align: justify;
            margin-bottom: 0.625rem;
        }
        
        .content-section p {
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            font-size: 1rem;
            color: #000;
            margin-bottom: 1.125rem;
            line-height: 1.7;
            text-align: justify;
        }

        .content-section p:last-child {
            margin-bottom: 0;
        }

        .content-section h3,
        .content-section h4 {
            font-family: 'Open Sans', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            line-height: 1.4;
            margin: 1.75rem 0 0.875rem;
            color: #000;
        }

        .content-section h3:first-child,
        .content-section h4:first-child {
            margin-top: 0;
        }
        
        .content-section ul,
        .content-section ol {
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            font-size: 1rem;
            margin: 0 0 0.9375rem;
            padding-left: 2rem;
            color: #000;
            line-height: 2.5rem;
            text-align: justify;
        }

        .content-section ul {
            list-style-type: disc;
        }

        .content-section ol {
            list-style-type: decimal;
        }

        .content-section li {
            padding-left: 0.25rem;
        }

        .content-section li::marker {
            color: var(--color-text);
            font-weight: 600;
        }

        .content-section a,
        .content-section a * {
            color: #5b2829 !important;
            text-decoration: underline !important;
            text-decoration-color: #5b2829 !important;
        }

        .content-section a:hover,
        .content-section a:hover * {
            color: #5b2829 !important;
            text-decoration: underline !important;
            text-decoration-color: #5b2829 !important;
        }

        .content-section ul li a,
        .content-section ol li a,
        .content-section ul li a *,
        .content-section ol li a * {
            color: #5b2829 !important;
            text-decoration: underline !important;
            text-decoration-color: #5b2829 !important;
        }

        .content-section ul li a:hover,
        .content-section ol li a:hover,
        .content-section ul li a:hover *,
        .content-section ol li a:hover * {
            color: #5b2829 !important;
            text-decoration: underline !important;
            text-decoration-color: #5b2829 !important;
        }

        /* Specs Section */
        .specs-section {
            max-width: calc(var(--container-width) - (var(--margin-sides) * 2));
            width: calc(100% - (var(--margin-sides) * 2));
            margin: 1.0625rem auto;
            border-radius: 0.5rem;
            overflow: hidden;
            border: none;
        }

        .specs-table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
        }
        
        .specs-table tr:nth-child(odd) {
            background-color: #FFF8E7;
        }
        
        .specs-table tr:nth-child(even) {
            background-color: #FFFFFF;
        }
        
        .specs-table td {
            padding: 0.9375rem 1.875rem;
            color: #000;
            border: 1px solid #DDDDDD;
        }
        
        .specs-table td:first-child {
            font-weight: 700;
            color: #000;
            text-align: center;
            width: 30%;
        }

        /* FAQs Section */
        .faqs-section {
            max-width: calc(var(--container-width) - (var(--margin-sides) * 2));
            width: calc(100% - (var(--margin-sides) * 2));
            margin: 0 auto 3.75rem;
        }
        
        .faq-item {
            background: #FFFDFD;
            border: 1px solid #D6D6D6;
            border-radius: 0.25rem;
            margin-bottom: 0.75rem;
        }
        
        .faq-question {
            padding: 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-size: 1.125rem;
            font-weight: 500;
            /* background: #8d4445; */
            /* color: #fff; */
        }
        
        .faq-answer {
            padding: 1.25rem 1.25rem 1.25rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
            color: --color-text-primary;
            display: none;
            line-height: 1.6;
        }
        
        .faq-icon {
            font-size: 1.25rem;
            font-weight: 400;
        }

        /* Order Process Section */
        .order-process-section {
            max-width: calc(var(--container-width) - (var(--margin-sides) * 2));
            width: calc(100% - (var(--margin-sides) * 2));
            margin: 0 auto 3.75rem;
        }
        
        .process-cards {
            display: flex;
            justify-content: space-between;
            gap: 1.25rem;
            flex-wrap: wrap;
        }
        
        .process-card {
            flex: 1;
            min-width: 15.625rem;
            max-width: 20.3125rem;
            height: auto;
            min-height: 13.75rem;
            background-color: #F8EEEC;
            border-radius: 0.5rem;
            padding: 1.5625rem 1.125rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-sizing: border-box;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .process-card:hover {
            background-color: #8C3A3A;
            transform: translateY(-0.3125rem);
            box-shadow: 0 0.625rem 1.5625rem rgba(140, 58, 58, 0.3);
        }
        
        .process-card:hover .process-icon {
            color: #FFFFFF;
        }
        
        .process-card:hover h4 {
            color: #FFFFFF;
        }
        
        .process-card:hover p {
            color: rgba(255, 255, 255, 0.9);
        }
        
        .process-icon {
            font-size: 2.1875rem;
            color: #8C3A3A;
            margin-bottom: 0.9375rem;
            transition: color 0.3s ease;
        }
        
        .process-card h4 {
            font-family: 'Open Sans', sans-serif;
            font-size: 0.875rem;
            font-weight: 700;
            line-height: 1.25rem;
            color: #000000;
            text-align: center;
            margin-bottom: 0.625rem;
            transition: color 0.3s ease;
        }
        
        .process-card p {
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            font-size: 0.8125rem;
            line-height: 1.125rem;
            color: #000000;
            text-align: center;
            transition: color 0.3s ease;
        }

        /* Custom Finishes Section */
        .finishes-section {
            max-width: calc(var(--container-width) - (var(--margin-sides) * 2));
            width: calc(100% - (var(--margin-sides) * 2));
            margin: -1.875rem auto 1.875rem auto;
        }
        
        .mobile-heading-break { display: none; }

        .finishes-header {
            margin-top: 2.125rem;
            text-align: center;
            font-family: 'DM Sans', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #000;
            margin-bottom: 1.875rem;
        }
        
        .finishes-grid {
            display: flex;
            gap: 1.25rem;
            justify-content: space-between;
        }
        
        .finishes-image-container {
            flex: 1.34;
            height: 26.25rem;
            border-radius: 1rem;
            overflow: hidden;
            position: relative;
        }
        
        .finishes-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            opacity: 1 !important;
            filter: none !important;
        }
        
        .carousel-dots {
            position: absolute;
            bottom: 1.25rem;
            left: 1.875rem;
            display: flex;
            gap: 0.5rem;
        }
        
        .carousel-dot {
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 50%;
            border: 0.125rem solid #fff; /* Increased border to match the larger size visually */
            background: transparent;
            cursor: pointer;
        }
        
        .carousel-dot.active {
            background: #fff;
        }
        
        .finishes-details-box {
            flex: 1;
            height: 26.25rem;
            background-color: #F8EEEC;
            border-radius: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            padding: 3.125rem 1.25rem 1.875rem;
            box-sizing: border-box;
        }
        
        .finishes-top-text {
            font-family: 'Open Sans', sans-serif;
            font-size: 1.2019rem;
            font-weight: 600;
            line-height: 1.8025rem;
            letter-spacing: 0;
            text-align: center;
            color: #000000;
        }
        
        .finishes-middle-list {
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 0.9375rem;
        }
        
        .finish-item-light {
            font-family: 'DM Sans', sans-serif;
            font-size: 1.125rem;
            color: rgba(0,0,0,0.3);
            font-weight: 500;
        }
        
        .finish-item-dark {
            font-family: 'DM Sans', sans-serif;
            font-size: 2rem;
            color: #000;
            font-weight: 700;
        }
        
        .finishes-bottom-nav {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.9375rem;
            font-family: 'Open Sans', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            line-height: 1.1538rem;
            letter-spacing: 0;
            text-align: center;
            color: #000000;
        }
        
        .finishes-bottom-nav span {
            cursor: pointer;
            transition: color 0.3s ease;
        }
        
        .finishes-bottom-nav span:hover {
            color: var(--primary-color, #8C3A3A);
        }
        
        .finishes-bottom-nav span {
            cursor: pointer;
            transition: color 0.3s ease;
        }
        
        .finishes-bottom-nav span:not([style*="font-weight: 700"]) {
            color: #000000;
        }

        /* Quote Request Section */
        .quote-section {
            max-width: calc(var(--container-width) - (var(--margin-sides) * 2));
            width: calc(100% - (var(--margin-sides) * 2));
            margin: 0 auto 3.75rem;
            padding: 2.5rem 0;
            background-color: var(--primary-color);
            background-image: linear-gradient(
                45deg,
                transparent 40%,
                rgba(255,255,255,0.15) 40%, rgba(255,255,255,0.15) calc(40% + 1px),
                transparent calc(40% + 1px), transparent 48%,
                rgba(255,255,255,0.15) 48%, rgba(255,255,255,0.15) calc(48% + 1px),
                transparent calc(48% + 1px), transparent 56%,
                rgba(255,255,255,0.15) 56%, rgba(255,255,255,0.15) calc(56% + 1px),
                transparent calc(56% + 1px), transparent 64%,
                rgba(255,255,255,0.15) 64%, rgba(255,255,255,0.15) calc(64% + 1px),
                transparent calc(64% + 1px), transparent 72%,
                rgba(255,255,255,0.15) 72%, rgba(255,255,255,0.15) calc(72% + 1px),
                transparent calc(72% + 1px), transparent 80%,
                rgba(255,255,255,0.15) 80%, rgba(255,255,255,0.15) calc(80% + 1px),
                transparent calc(80% + 1px)
            );
            background-size: 85% 75%;
            background-position: left center;
            background-repeat: no-repeat;
            position: relative;
            overflow: hidden;
            border-radius: 1rem;
        }

        .quote-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 16.75rem;
            height: 18.375rem;
            background-image: url("{{ asset('uploads/request-sample-kit-dots.svg') }}");
            background-size: contain;
            background-repeat: no-repeat;
            background-position: top right;
            pointer-events: none;
            mix-blend-mode: screen;
        }

        .quote-section::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 8.75rem;
            height: 11.5rem;
            background-image: url("{{ asset('uploads/request-sample-kit-box.svg') }}");
            background-size: contain;
            background-repeat: no-repeat;
            background-position: bottom left;
            pointer-events: none;
            z-index: 1;
        }

        .quote-grid {
            display: flex;
            gap: 3.75rem;
            width: 100%;
            padding: 0 2.5rem;
            margin: 0 auto;
            align-items: center;
        }

        .quote-form {
            flex: 1.5;
            background: #fff;
            padding: 3.125rem;
            border-radius: 1.25rem;
            box-shadow: 0 0.625rem 2.5rem rgba(0,0,0,0.1);
            position: relative;
            z-index: 2;
        }
        
        .quote-form-header {
            display: flex;
            align-items: flex-start;
            gap: 0.9375rem;
            margin-bottom: 1.875rem;
        }
        
        .quote-icon-box {
            width: 3.125rem;
            height: 3.125rem;
            background-color: #F8EEEC;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        
        .quote-form h2 {
            font-family: 'Open Sans', sans-serif;
            font-size: 1.5rem;
            margin-bottom: 0.3125rem;
            color: #000;
        }
        
        .quote-form p {
            color: var(--color-text-secondary);
            font-size: 0.8125rem;
            margin-bottom: 0;
        }
        
        .form-row {
            display: flex;
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }
        
        .form-row .form-group {
            flex: 1;
            min-width: 0;
        }
        
        .quote-form label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #000;
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .quote-form .form-control {
            background-color: #FAFAFA;
            border: 0.0312rem solid #8d4445;
            font-size: 0.8125rem;
        }
        /* Apply the same border interaction to the product (hero) form. */
        .hero-form .form-control {
            border: 0.0312rem solid #8d4445;
        }

        .hero-form .form-control:focus {
            border: 1px solid #8d4445 !important;
        }

        .hero-form .custom-select-trigger {
            border: 0.0312rem solid #8d4445;
        }

        .hero-form .custom-select-trigger.open {
            border: 1px solid #8d4445 !important;
        }

        .quote-form .form-control:focus {
            border: 1px solid #8d4445 !important;
        }

        /* The Box Style select is rendered as this custom trigger by JavaScript. */
        .quote-form .custom-select-trigger {
            background-color: #FAFAFA;
            border: 0.0312rem solid #8d4445;
            font-size: 0.8125rem;
        }

        .quote-form .custom-select-trigger.open {
            border: 1px solid #8d4445 !important;
        }
        .hero-form .form-control.is-active,
        .quote-form .form-control.is-active,
        .hero-form .custom-select-trigger.is-active,
        .quote-form .custom-select-trigger.is-active,
        .hero-form .form-control:focus,
        .quote-form .form-control:focus,
        .hero-form .custom-select-trigger.open,
        .quote-form .custom-select-trigger.open {
            border: 1px solid #8d4445 !important;
            box-shadow: 0 0 0 0.1875rem rgba(141, 68, 69, 0.1);
            outline: none;
        }
        
        .btn-submit-quote {
            background-color: var(--primary-color);
            color: #fff;
            padding: 0.9375rem 2.5rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 700;
            font-size: 0.875rem;
            cursor: pointer;
            width: 15.625rem;
            margin: 0.625rem auto 0;
            display: inline-block;
        }
        
        .quote-info {
            flex: 1;
            color: #fff;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 2;
        }
        
        .quote-info h3 {
            font-family: 'Open Sans', sans-serif;
            font-size: 2.125rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.9375rem;
            line-height: 1.3;
            letter-spacing: 0.0312rem;
        }
        
        .quote-title-line {
            width: 5.375rem;
            height: 0.1875rem;
            background-color: #fff;
            margin-bottom: 2.5rem;
        }
        
        .quote-info img {
            width: 100%;
            max-width: 21.875rem;
            display: block;
            margin: 0 auto 2.5rem;
        }
        
        .features-list {
            display: flex;
            justify-content: center;
            gap: 0.9375rem;
        }
        
        .feature-item {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 8.75rem;
        }
        
        .feature-icon {
            width: auto;
            height: auto;
            background-color: transparent;
            color: var(--primary-color);
            border-radius: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .feature-icon img {
            width: 4.6875rem;
            height: 4.6875rem;
            object-fit: contain;
            display: block;
            margin: 0;
        }
        
        .feature-item span {
            font-family: 'Open Sans', sans-serif;
            font-size: 1.125rem;
            font-weight: 600;
            line-height: 1.25rem;
            letter-spacing: 0;
            color: #fff;
            display: block;
            width: 100%;
        }

        /* Related Products Section */
        .related-products {
            margin-top: 0;
            padding: 2.5rem 0 1.25rem;
            background-color: #fff;
        }
        
        .related-products .container {
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 0 var(--margin-sides);
        }
        
        .related-products h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 2.5rem;
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.875rem;
            max-width: 100%;
        }
        
        .product-card {
            background: #fff;
            border-radius: 0.75rem;
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s;
            width: 100%;
            max-width: 100%;
        }
        
        .product-card:hover {
            transform: translateY(-0.3125rem);
        }
        
        .product-image {
            width: 100%;
            height: auto;
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.9375rem;
            border-radius: 0.75rem;
            overflow: hidden;
        }
        
        .product-card h4 {
            font-size: 1.125rem;
            font-weight: 700;
            color: #000;
            margin-bottom: 0.625rem;
            font-family: 'Open Sans', sans-serif;
        }

        /* Responsive Margins */
        @media (min-width: 100rem) {
            :root { --margin-sides: 3.4375rem; }
            .hero-container {
                gap: 3.125rem;
            }
        }
        @media (max-width: 90rem) {
            :root { --margin-sides: 3.4375rem; }
        }
        @media (max-width: 75rem) and (min-width: 64.0625rem) {
            :root { --margin-sides: 3.4375rem; }
            .hero-container {
                gap: 1.875rem;
            }
        }
        @media (max-width: 64rem) {
            :root { --margin-sides: 3.4375rem; }
            .hero-container {
                gap: 1.5625rem;
            }
        }
        @media (max-width: 48rem) {
            :root { --margin-sides: 1.25rem; }
            .hero-container {
                gap: 1.25rem;
            }
            .hero-section {
                padding-bottom: 1rem !important;
            }
            .specs-section {
                margin-top: 0.5rem !important;
            }
        }
        @media (max-width: 30rem) {
            :root { --margin-sides: 1rem; }
        }

        @media (max-width: 61.9375rem) {
            .hero-container, .finishes-grid, .quote-grid {
                flex-direction: column;
            }
            .hero-images,
            .hero-form,
            .hero-details {
                width: 100%;
                max-width: 100%;
                flex: 1 1 100%;
            }
            .hero-images {
                gap: 0.625rem;
            }
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 47.9375rem) {
            .process-cards {
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }
            .content-section, .specs-section, .faqs-section {
                width: calc(100% - (var(--margin-sides) * 2)); margin-left: auto; margin-right: auto;
                margin-bottom: 0.625rem !important;
            }
            .content-section h2 {
                text-align: left;
            }
            .content-section .considerations-heading {
                font-size: 1.3125rem;
                line-height: 2rem;
                letter-spacing: 0;
            }
            .finishes-section {
                margin-top: 0;
            }
            .mobile-heading-break { display: none; }

        .finishes-header {
                margin: 0.3125rem 0 1.875rem;
                font-size: 1.25rem;
                line-height: 1.5rem;
                max-width: 16.25rem;
                margin-left: auto;
                margin-right: auto;
            }
            .finishes-grid {
                display: flex;
                flex-direction: column;
                gap: 1rem;
                position: relative;
                padding-top: 3.75rem;
            }
            .finishes-image-container {
                order: 1;
                flex: none;
                width: 100%;
                aspect-ratio: 1.34;
                height: auto;
                border-radius: 1rem;
                position: relative;
                overflow: hidden;
            }
            .finishes-details-box {
                order: 2;
                flex: none;
                width: 100%;
                height: auto;
                padding: 1.5rem 1.125rem;
                background: #FAF4F2;
                border-radius: 1rem;
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 1rem;
                box-sizing: border-box;
            }
            .finishes-top-text {
                display: block !important;
                font-family: 'DM Sans', sans-serif;
                font-size: 1.125rem;
                font-weight: 700;
                color: #000000;
            }
            .finishes-middle-list {
                display: flex !important;
                flex-direction: row !important;
                justify-content: center;
                align-items: center;
                gap: 1rem;
                width: 100%;
                overflow-x: auto;
                padding: 0.25rem 0;
                scrollbar-width: none;
            }
            .finish-item-light {
                font-size: 0.875rem;
                color: #999999;
                font-weight: 500;
                white-space: nowrap;
            }
            .finish-item-dark {
                font-size: 1rem;
                color: #000000;
                font-weight: 700;
                border-bottom: 0.125rem solid #8C3A3A;
                padding-bottom: 0.25rem;
                white-space: nowrap;
            }
            .finishes-bottom-nav {
                display: flex !important;
                flex-direction: row !important;
                flex-wrap: nowrap !important;
                justify-content: flex-start !important;
                gap: 0.5rem;
                width: 100%;
                margin: 0;
                padding: 0;
                border: none;
                position: absolute;
                top: 0;
                left: 0;
                overflow-x: auto;
                scrollbar-width: none;
                -webkit-overflow-scrolling: touch;
            }
            .finishes-bottom-nav::-webkit-scrollbar {
                display: none;
            }
            .finishes-bottom-nav span {
                display: inline-block;
                text-align: center;
                padding: 0.75rem 0.875rem;
                border: 1px solid #E5D5D5;
                border-radius: 0.375rem;
                background-color: #FFFFFF;
                font-weight: 600;
                font-size: 0.75rem;
                color: #333333;
                text-transform: uppercase;
                box-sizing: border-box;
                flex: 0 0 auto;
                white-space: nowrap;
                transition: all 0.3s ease;
                cursor: pointer;
            }
            .finishes-bottom-nav span:hover {
                background-color: var(--primary-color, #8C3A3A);
                color: #FFFFFF !important;
                border-color: var(--primary-color, #8C3A3A);
            }
            .finishes-bottom-nav span.active-nav,
            .finishes-bottom-nav span[style*="font-weight: 700"] {
                background-color: var(--primary-color, #8C3A3A) !important;
                color: #FFFFFF !important;
                border-color: var(--primary-color, #8C3A3A) !important;
                font-weight: 700 !important;
            }
            .carousel-dots {
                bottom: 0.625rem;
                left: 1.5625rem;
                gap: 0.1875rem;
            }
            .carousel-dot {
                width: 0.4375rem;
                height: 0.4375rem;
                border-width: 1px;
            }
            .main-image {
                height: auto;
                aspect-ratio: 1;
            }
            .thumbnails {
                flex-wrap: nowrap;
                gap: 0.5rem;
                margin-top: 0;
                width: 100%;
            }
            .thumb {
                width: calc((100% - 1.5rem) / 4);
                height: auto;
                aspect-ratio: 1 / 1;
                flex: 1;
            }
            .form-row, .form-grid-3, .form-grid-2-upload {
                display: grid;
                grid-template-columns: 1fr;
                gap: 0.9375rem;
            }
            .hero-form > p {
                font-size: 0.8125rem;
                line-height: 1.55;
            }

            #readMoreBtnLipstick {
                font-size: 0.75rem !important;
                margin-left: 0.1875rem !important;
                white-space: nowrap;
            }
            .form-grid-4, .form-grid-pref {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 0.9375rem;
            }
            .form-control option:checked {
                background: var(--primary-color) linear-gradient(0deg, var(--primary-color) 0%, var(--primary-color) 100%);
                color: #fff;
            }
            .form-row-2col {
                grid-template-columns: 1fr 1fr;
                gap: 0.5rem !important;
            }
            .badges-horizontal {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 1.75rem 1rem;
                align-items: center;
            }
            .badges-horizontal > div {
                min-width: 0;
            }
            .custom-select-trigger {
                white-space: nowrap !important;
                min-height: 2.8125rem !important;
                height: 2.8125rem !important;
                padding: 0.75rem 1rem 0.75rem 0.25rem !important;
                font-size: 0.875rem !important;
                line-height: 1.3125rem !important;
                display: block !important;
                overflow: hidden !important;
                text-overflow: clip !important;
                letter-spacing: -0.0063rem;
            }
            .custom-select-trigger::after {
                right: 0.3125rem !important;
            }
            .badges-horizontal > div {
                display: flex;
                align-items: center;
                gap: 0.375rem;
                text-align: left;
            }
            .badges-horizontal .badge-icon {
                display: block;
                width: 1.875rem;
                height: 1.875rem;
                flex: 0 0 1.875rem;
                object-fit: cover;
                object-position: left center;
            }
            .badges-horizontal .badge-label {
                display: block;
                font-family: 'DM Sans', sans-serif;
                font-size: 0.75rem;
                font-weight: 500;
                line-height: 0.875rem;
                color: #4D4D4D;
                white-space: nowrap;
            }
            
            .feature-item {
                display: flex;
                flex-direction: row !important;
                align-items: center;
                text-align: left;
                gap: 0.75rem;
                width: 100%;
                max-width: 18.75rem;
            }
            
            .feature-icon {
                width: 2.5rem !important;
                height: 2.5rem !important;
                flex-shrink: 0;
            }
            
            .feature-text {
                font-size: 1rem;
                flex: 1;
            }
            
            .features-badges-section .container {
                padding: 0 0.625rem;
            }
            .tabs-section {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                -ms-overflow-style: none;
                scrollbar-width: none;
                padding: 1.25rem 0 1.25rem 1.25rem;
            }
            .tabs-section {
                scroll-snap-type: x mandatory;
            }
            .tabs-list .tab-item {
                scroll-snap-align: center;
            }
            /* Final mobile tab styling */
            .tabs-section .container {
                border: none;
                border-radius: 0;
                background: transparent;
            }
            .tabs-list .tab-item.active {
                background: #8D4445;
                color: #FFFFFF;
            }
            /* Keep the tab border fixed while only its options scroll. */
            .tabs-section {
                overflow: hidden;
                padding: 1.25rem 0;
            }
            .tabs-section .container {
                width: calc(100% - (var(--margin-sides) * 2));
                margin: 0 auto;
                padding: 0;
                overflow-x: auto;
                border: none;
                scrollbar-width: none;
            }
            .tabs-section .container::-webkit-scrollbar {
                display: none;
            }
            .tabs-list {
                display: inline-flex;
                flex-wrap: nowrap;
                justify-content: flex-start;
                padding: 0.25rem;
                width: max-content;
                margin: 0;
                gap: 0.5rem;
                border: 0.125rem solid #8d4445;
                border-radius: 3.125rem;
                background: #FFFFFF;
            }
            .tabs-section::-webkit-scrollbar {
                display: none;
            }
            .tabs-list::-webkit-scrollbar {
                display: none;
            }
            .tab-item {
                flex: 0 0 auto;
                padding: 0.625rem 1.375rem;
                font-size: 0.9375rem;
                white-space: nowrap;
            }

            .finishes-middle-list {
                flex-direction: row;
                overflow-x: hidden;
                justify-content: center;
                align-items: center;
                gap: 1.25rem;
                width: 100%;
                margin: 1.25rem 0;
            }
            .finish-item-light {
                display: block;
                color: #A0A0A0;
                font-size: 0.8125rem;
                white-space: nowrap;
            }
            .finish-item-dark {
                color: #000;
                font-weight: 700;
                font-size: 0.9375rem;
                border-bottom: 0.1875rem solid #8c4446;
                padding-bottom: 0.3125rem;
                white-space: nowrap;
            }
            .finishes-image-container, .finishes-details-box {
                height: auto;
            }
            /* Removed conflicting column layout for mobile */
            /* Keep the full tab frame inside the shared page container. */
            .tabs-section .container {
                width: calc(100% - (var(--margin-sides) * 2)) !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }
            .mobile-heading-break { display: block; }

            /* Mobile finishes layout override */
            .finishes-details-box {
                order: 2;
                width: 100%;
                padding: 0 1.125rem;
                background: #FAF4F2;
                border-radius: 1rem;
            }
            .finishes-top-text {
                display: block !important;
            }
            .finishes-middle-list {
                display: flex !important;
                flex-direction: row !important;
            }
            .finishes-image-container {
                order: 1;
                width: 100%;
                border-radius: 1rem;
            }
            .carousel-dots {
                bottom: 0.75rem;
                left: 1.25rem;
                gap: 0.3125rem;
            }
            .carousel-dot {
                width: 0.4375rem;
                height: 0.4375rem;
                border-width: 1px;
            }
            .quote-form-header p {
                display: none;
            }

            .quote-icon-box {
                display: none;
            }

            .mobile-quote-btn {
                display: none !important;
            }
            .products-grid {
                display: flex;
                flex-wrap: nowrap;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                -ms-overflow-style: none;
                scrollbar-width: none;
                gap: 0.9375rem;
                padding-bottom: 0.3125rem;
            }
            .products-grid::-webkit-scrollbar {
                display: none;
            }
            .product-card {
                flex: 0 0 calc(50% - 0.4688rem);
                width: auto;
                max-width: none;
            }
            .product-image {
                width: 100%;
                height: auto;
                aspect-ratio: 1;
                margin-bottom: 0.625rem;
            }
            .product-image img {
                width: 100%;
                height: 100%;
                object-fit: contain !important;
            }
            .quote-info {
                display: none;
            }
            .quote-grid {
                padding: 0 0.9375rem;
                gap: 1.875rem;
            }
            .quote-form {
                padding: 1.5625rem 1.25rem;
            }
        }




        /* Keep the quote form balanced at 125% browser zoom. */
        @media (min-width: 48rem) and (max-width: 85.375rem) {
            .quote-form-header {
                gap: 0.625rem;
            }
            .quote-form h2 {
                font-size: 1.25rem;
                white-space: nowrap;
            }
            .quote-form .form-row {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 0.9375rem;
            }
            .quote-form .form-row.form-row-2col {
                grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr);
            }
            .quote-form .form-row .form-group {
                min-width: 0;
            }
            .quote-form label {
                white-space: nowrap;
            }
            .quote-form .form-control {
                min-width: 0;
                padding-left: 0.625rem;
                padding-right: 0.625rem;
            }
        }


        /* Review Section */
        .review-section-container {
            background-color: #EFEFEF;
            border: 0.0419rem solid #E6E6E6;
            border-radius: 0.75rem;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5625rem;
            width: 100%;
        }

        .review-item {
            display: flex;
            align-items: center;
            gap: 0.875rem;
        }

        .review-icon-box {
            width: 3.25rem;
            height: 3.25rem;
            background-color: #FFFFFF;
            border: 1px solid #E6E6E6;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 1px 0.125rem rgba(0,0,0,0.02);
        }

        .review-text-box {
            display: flex;
            flex-direction: column;
            gap: 0.125rem;
        }

        .review-title {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
            font-weight: 500;
            color: #000000;
            line-height: 1.2;
        }

        .review-rating {
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .rating-number {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
            font-weight: 700;
        }

        .google-color {
            color: #FEA500;
        }

        .rating-stars {
            display: flex;
            gap: 0.125rem;
            font-size: 0.75rem;
        }

        .review-rating-tp {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.6875rem;
            color: #000000;
            line-height: 1.2;
            margin-bottom: 0.1875rem;
        }

        .rating-stars-tp {
            display: flex;
            gap: 0.125rem;
        }

        .tp-star {
            width: 1rem;
            height: 1rem;
            background-color: #219653;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.125rem;
        }

        .tp-star i {
            color: #FFFFFF;
            font-size: 0.625rem;
        }
        
        .tp-star-half {
            background: linear-gradient(to right, #219653 50%, #DCDCE6 50%);
        }

        @media (max-width: 47.9375rem) {
            .review-section-container {
                display: none !important;
            }
        }

        /* BREADCRUMB CSS */
        .desktop-breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
            font-family: 'Open Sans', sans-serif;
            font-weight: 600;
            font-size: 0.8125rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--section-text-color, #191919);
        }

        .desktop-breadcrumb a {
            color: inherit;
            text-decoration: none;
        }

        .desktop-breadcrumb a:hover {
            text-decoration: none;
            color: var(--primary-color);
        }

        @media (max-width: 48rem) {
            .desktop-breadcrumb {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    @include('components.header')

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            @php
                $pTitle = $product['title'] ?? 'Custom Packaging Box';
                $productCatId = DB::table('admin_category_product')->where('product_id', $product['id'] ?? 0)->value('category_id');
                $productCategory = $productCatId ? DB::table('admin_categories')->where('id', $productCatId)->first() : null;
                $catTitle = $productCategory ? strtoupper($productCategory->title) : 'PRODUCTS';
                $catUrl = $productCategory ? url('/' . ($productCategory->slug ?? \Illuminate\Support\Str::slug($productCategory->title))) . '/' : '#';
                
                $descText = html_entity_decode(html_entity_decode(strip_tags($product['description'] ?? 'Custom printed boxes crafted to protect your products while showcasing your brand with premium-quality printing and luxury finishes.')));
                $limit = 260;
                $isLong = strlen($descText) > $limit;
            @endphp
            <div class="desktop-breadcrumb" style="font-size: 0.8125rem; margin-bottom: 0.9375rem; color: #333;">
                <a href="/" style="color: #333; text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 1.125rem; height: 1.125rem;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    Home
                </a> &gt; 
                <strong>{{ $pTitle }}</strong>
            </div>
            
            <div class="desktop-title-desc">
                <h1 style="font-size: 2.25rem; margin-bottom: 0.625rem; color: #000; line-height: 1.2; font-family: 'Open Sans', sans-serif;">{{ $pTitle }}</h1>
                
                <p class="desc-text" style="color: #000; font-size: 0.9375rem; line-height: 1.6; margin-bottom: 1.5625rem; text-align: justify;">
                    {{ $descText }}
                </p>
            </div>
        </div>
        <div class="container hero-container">
            @php
                $pGalleryRaw = [];
                if (!empty($product['images'])) {
                    $pGalleryRaw = is_string($product['images']) ? (json_decode($product['images'], true) ?: []) : (array) $product['images'];
                }
                
                $pMainImg = '';
                if (!empty($product['image'])) {
                    $pMainImg = $product['image'];
                } elseif (!empty($pGalleryRaw) && count($pGalleryRaw) > 0) {
                    $pMainImg = $pGalleryRaw[0];
                } else {
                    $pMainImg = 'uploads/Gift-Boxes.webp';
                }

                $normalizeImg = function($img) {
                    if (empty($img)) return '';
                    return \Illuminate\Support\Str::startsWith($img, ['storage/', 'uploads/', 'images/']) ? $img : 'storage/' . $img;
                };

                $pMainImg = $normalizeImg($pMainImg);
                $pGalleryRaw = array_map($normalizeImg, $pGalleryRaw);

                $pTitle = $product['title'] ?? 'Custom Packaging Box';
                // Always show the active/featured image first in the thumbnail row.
                $pGallery = array_values(array_unique(array_filter(array_merge([$pMainImg], $pGalleryRaw))));
            @endphp
            <div class="hero-images">
                <div class="main-image">
                    <div class="in-stock-tag">
                        <span class="stock-dot"></span> In Stock
                    </div>
                    @php
                        $pMainImgName = pathinfo(parse_url(asset($pMainImg), PHP_URL_PATH), PATHINFO_FILENAME);
                        $pMainImgCleanName = !empty($pTitle) ? $pTitle : ucwords(str_replace(['-', '_'], ' ', preg_replace('/-[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}/i', '', $pMainImgName)));
                    @endphp
                    <img id="product-main-image" src="{{ asset($pMainImg) }}" alt="{{ !empty($product['alt_text']) ? $product['alt_text'] : $pMainImgCleanName }}" title="{{ $pMainImgCleanName }}" onerror="this.src='https://placehold.co/600x500/eeeeee/555555?text={{ urlencode($pMainImgCleanName) }}'">
                </div>
                @if(count($pGallery))
                <div class="thumbnails">
                    @foreach($pGallery as $galleryIndex => $galleryImage)
                        @php $galleryImage = \Illuminate\Support\Str::startsWith($galleryImage, ['storage/', 'uploads/', 'images/']) ? $galleryImage : 'storage/' . $galleryImage; @endphp
                        <div class="thumb {{ $galleryImage === $pMainImg ? 'active' : '' }}" onclick="switchProductImage(this, '{{ asset($galleryImage) }}')">
                            <img src="{{ asset($galleryImage) }}" alt="{{ $pTitle }} thumbnail {{ $galleryIndex + 1 }}" style="width: 100%; height: 100%; object-fit: contain; border-radius: 0.375rem;" loading="lazy">
                        </div>
                    @endforeach
                </div>
                @endif
                
            </div>

            <div class="mobile-title-desc">
                <div class="mobile-product-title" style="font-size: 1.75rem; margin-bottom: 0.625rem; color: #000; line-height: 1.2; font-family: 'Open Sans', sans-serif; font-weight: 700;">{{ $pTitle }}</div>
                <p class="desc-text" style="color: #333; font-size: 0.9375rem; line-height: 1.6; margin-bottom: 1.25rem; text-align: justify;">
                    {{ $descText }}
                </p>
            </div>

            <script>
                function toggleTopReadMore() {
                    var shortText = document.getElementById('shortDescText');
                    var fullText = document.getElementById('fullDescText');
                    var btn = document.getElementById('readMoreBtn');
                    
                    if (fullText.style.display === 'none') {
                        fullText.style.display = 'inline';
                        shortText.style.display = 'none';
                        btn.textContent = 'Read Less';
                    } else {
                        fullText.style.display = 'none';
                        shortText.style.display = 'inline';
                        btn.textContent = 'Read More';
                    }
                }
            </script>
            <div class="hero-form hero-quote-box" style="background-color: #FFF8E7; padding: 1rem 0.8125rem 1.5rem; border-radius: 0.5rem; box-shadow: none; height: auto;">
                <span style="display: block; text-align: center; font-family: 'Open Sans', sans-serif; font-size: 1.125rem; line-height: 1.4; font-weight: 700; color: #000; margin-bottom: 1.375rem;">Instant Quotes, Quick Service</span>
                
                <form action="{{ url('/submit-quote') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('components.spam-guard-fields')
                    
                    <style>
                        .hero-quote-box .form-grid-3 {
                            display: grid; 
                            grid-template-columns: repeat(3, 1fr); 
                            gap: 0.625rem;
                            margin-bottom: 1.125rem;
                        }
                        .hero-quote-box .form-grid-4 {
                            display: grid; 
                            grid-template-columns: 1.55fr 1.55fr 1.55fr 1fr; 
                            gap: 0.625rem;
                            margin-bottom: 1.125rem;
                        }
                        .hero-quote-box .form-grid-2-upload {
                            display: grid; 
                            grid-template-columns: 1fr 1fr; 
                            gap: 0.75rem; 
                            margin-bottom: 0.625rem;
                        }

                        @media (max-width: 61.9375rem) {
                            .hero-quote-box {
                                padding: 1.5625rem 1.25rem !important;
                                border-radius: 0 !important;
                                width: 100vw !important;
                                margin-left: calc(-50vw + 50%) !important;
                                margin-right: calc(-50vw + 50%) !important;
                                max-width: 100vw !important;
                                box-sizing: border-box !important;
                                height: auto !important;
                            }
                        }
                        @media (max-width: 48rem) {
                            .hero-quote-box .form-grid-3,
                            .hero-quote-box .form-grid-2-upload {
                                grid-template-columns: 1fr;
                            }
                            .hero-quote-box .form-grid-4 {
                                grid-template-columns: 1fr 1fr;
                            }
                        }
                        .hero-quote-box .quote-input,
                        .hero-quote-box input.form-control,
                        .hero-quote-box select.form-control {
                            width: 100% !important;
                            background-color: #FFF8E7 !important;
                            border: 1px solid #D9D0C2 !important;
                            border-radius: 0.375rem !important;
                            color: #333333 !important;
                            font-family: 'Inter', sans-serif !important;
                            font-weight: 400 !important;
                            font-size: 0.875rem !important;
                            line-height: 1.375rem !important;
                            letter-spacing: 0 !important;
                            height: 3rem !important;
                            padding: 0.75rem 0.9375rem !important;
                            box-sizing: border-box !important;
                            outline: none !important;
                            box-shadow: none !important;
                            transition: border-color 0.2s ease !important;
                        }
                        .hero-quote-box .quote-input:focus,
                        .hero-quote-box input.form-control:focus,
                        .hero-quote-box select.form-control:focus,
                        .hero-quote-box textarea.form-control:focus {
                            border-color: #8c7d6d !important;
                            outline: none !important;
                            box-shadow: none !important;
                        }
                        .hero-quote-box input.quote-input:-webkit-autofill,
                        .hero-quote-box input.quote-input:-webkit-autofill:hover,
                        .hero-quote-box input.quote-input:-webkit-autofill:focus {
                            -webkit-text-fill-color: #333333 !important;
                            -webkit-box-shadow: 0 0 0 1000px #FFF8E7 inset !important;
                            box-shadow: 0 0 0 1000px #FFF8E7 inset !important;
                            caret-color: #333333;
                            transition: background-color 9999s ease-out 0s;
                        }
                        .hero-quote-box select.quote-input,
                        .hero-quote-box select.form-control {
                            appearance: none !important;
                            -webkit-appearance: none !important;
                            -moz-appearance: none !important;
                            background-color: #FFF8E7 !important;
                            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23333333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
                            background-repeat: no-repeat !important;
                            background-position: right 0.875rem center !important;
                            background-size: 0.875rem auto !important;
                            padding-right: 2.375rem !important;
                            cursor: pointer !important;
                        }
                        .hero-quote-box select option {
                            background-color: #FFF8E7 !important;
                            color: #333333 !important;
                        }
                        .hero-quote-box .quote-input::placeholder,
                        .hero-quote-box input::placeholder,
                        .hero-quote-box textarea::placeholder {
                            color: #736d66 !important;
                            opacity: 1 !important;
                        }
                        .hero-quote-box .product-fixed-box-style {
                            display: flex !important;
                            align-items: center !important;
                            cursor: default !important;
                        }
                        .hero-quote-box .file-upload-wrap {
                            display: flex !important;
                            height: 3rem !important;
                            position: relative !important;
                        }
                        .hero-quote-box .file-upload-wrap input[type="text"] {
                            border-radius: 0.5rem 0 0 0.5rem !important;
                            border-right: none !important;
                            background-color: #FFF8E7 !important;
                            flex: 1 !important;
                            height: 3rem !important;
                            font-size: 0.875rem !important;
                        }
                        .hero-quote-box .file-upload-wrap .upload-btn {
                            background-color: #FFB800 !important;
                            color: #000000 !important;
                            font-weight: 700 !important;
                            font-size: 0.875rem !important;
                            border: 1px solid #FFB800 !important;
                            border-radius: 0 0.5rem 0.5rem 0 !important;
                            padding: 0 1.5rem !important;
                            height: 3rem !important;
                            cursor: pointer !important;
                            display: flex !important;
                            align-items: center !important;
                            justify-content: center !important;
                        }
                        .hero-quote-box textarea.form-control,
                        .hero-quote-box textarea.quote-input {
                            width: 100% !important;
                            background-color: #FFF8E7 !important;
                            border: 1px solid #D9D0C2 !important;
                            border-radius: 0.375rem !important;
                            color: #333333 !important;
                            font-family: 'Inter', sans-serif !important;
                            font-weight: 400 !important;
                            font-size: 0.875rem !important;
                            line-height: 1.375rem !important;
                            height: 4.5rem !important;
                            min-height: 4.5rem !important;
                            max-height: 7rem !important;
                            resize: vertical !important;
                            padding: 0.75rem 0.9375rem !important;
                            box-sizing: border-box !important;
                        }
                        .hero-quote-box .quote-submit-btn {
                            background-color: #FFB800 !important;
                            color: #002147 !important;
                            border: none !important;
                            border-radius: 0.5rem !important;
                            font-weight: 700 !important;
                            font-size: 0.9375rem !important;
                            cursor: pointer !important;
                            width: 16.5rem !important;
                            max-width: 100% !important;
                            height: 2.875rem !important;
                            display: flex !important;
                            align-items: center !important;
                            justify-content: center !important;
                            margin: 0 auto !important;
                            transition: transform 0.2s ease, filter 0.2s ease !important;
                        }
                        .hero-quote-box .quote-submit-btn:hover {
                            filter: brightness(0.95) !important;
                        }
                        .hero-quote-box .input-group {
                            display: flex;
                            flex-direction: column;
                        }
                        .hero-quote-box .input-group label {
                            font-size: 0.75rem;
                            font-weight: 700;
                            color: #333;
                            margin-bottom: 0.375rem;
                            text-align: left;
                            font-family: 'DM Sans', sans-serif;
                        }
                        .hero-quote-box .form-grid-2 {
                            display: grid;
                            grid-template-columns: 1fr 1fr;
                            gap: 0.625rem;
                            margin-bottom: 1.125rem;
                        }
                        .hero-quote-box .form-upload-row {
                            margin-bottom: 1.125rem;
                        }
                        /* Smaller text in the 3-column dropdown row so placeholders show in full */
                        .hero-quote-box .form-grid-options select.quote-input {
                            font-size: 0.8125rem !important;
                            padding-left: 0.75rem !important;
                            padding-right: 1.875rem !important;
                            background-position: right 0.625rem center !important;
                        }
                        .hero-quote-box .input-group .qf-video-link {
                            margin-top: 0.375rem;
                        }
                        @media (max-width: 48rem) {
                            .hero-quote-box .form-grid-2 {
                                grid-template-columns: 1fr;
                            }
                        }
                            .hero-quote-box .quote-submit-btn {
                                width: 14.75rem !important;
                            }
                        }
                    </style>

                    <div class="form-grid-3">
                        <div class="input-group">
                            <input type="text" name="name" class="quote-input" placeholder="Name *" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" pattern=".*\S.*" data-qf-trim required>
                        </div>
                        <div class="input-group">
                            <input type="email" name="email" class="quote-input" placeholder="Email *" data-qf-trim required>
                        </div>
                        <div class="input-group">
                            <input type="tel" name="phone" class="quote-input" placeholder="Phone number *" oninput="this.value = this.value.replace(/[^0-9+\-\(\)\s]/g, '')" pattern=".*\S.*" data-qf-trim required>
                        </div>
                    </div>

                    <div class="form-grid-4">
                        <div class="input-group">
                            <input type="number" name="width" class="quote-input" placeholder="Width *" required>
                        </div>
                        <div class="input-group">
                            <input type="number" name="length" class="quote-input" placeholder="Length *" required>
                        </div>
                        <div class="input-group">
                            <input type="number" name="depth" class="quote-input" placeholder="Depth *" required>
                        </div>
                        <div class="input-group">
                            <select name="units" class="quote-input" required>
                                <option value="" selected disabled hidden>Unit *</option>
                                <option>mm</option>
                                <option>cm</option>
                                <option>inch</option>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="box_style" value="{{ $product['title'] ?? 'Custom Packaging Box' }}">
                    <input type="hidden" name="form_source" value="product">
                    <input type="hidden" name="source_form" value="Product Page - Top Form">
                    <input type="hidden" name="source_page" value="{{ url()->current() }}">

                    <!-- Paper Stock, Coating, Color -->
                    <div class="form-grid-3 form-grid-options">
                        <div class="input-group">
                            <select name="paper_stock" class="quote-input">
                                <option value="" selected disabled hidden>Select Paper Stock</option>
                                <option value="Not Sure">Not Sure</option>
                                <option>12pt Cardboard Stock</option>
                                <option>14pt Cardboard Stock</option>
                                <option>16pt Cardboard Stock</option>
                                <option>18pt Cardboard Stock</option>
                                <option>20pt Cardboard Stock</option>
                                <option>22pt Cardboard Stock</option>
                                <option>24pt Cardboard Stock</option>
                                <option>Kraft Stock</option>
                                <option>Recycled BuxBoard</option>
                                <option>Corrugated Stock</option>
                            </select>
                            <x-video-guide-link video="paper-stock" title="Paper Stock Guide" variant="light" />
                        </div>
                        <div class="input-group">
                            <select name="paper_coating" class="quote-input">
                                <option value="" selected disabled hidden>Select Paper Coating</option>
                                <option value="Not Sure">Not Sure</option>
                                <option>Aqueous Coating</option>
                                <option>Semi Gloss</option>
                                <option>Gloss UV</option>
                                <option>Matte UV</option>
                                <option>Semi Matte</option>
                            </select>
                            <x-video-guide-link video="paper-coating" title="Paper Coating Guide" variant="light" />
                        </div>
                        <div class="input-group">
                            <select name="color" class="quote-input">
                                <option value="" selected disabled hidden>Color Options</option>
                                <option value="Not Sure">Not Sure</option>
                                <option>1 color</option>
                                <option>2 color</option>
                                <option>3 color</option>
                                <option>4 color (CMYK)</option>
                                <option>No Printing</option>
                            </select>
                            <x-video-guide-link video="colors" title="Color Options Guide" variant="light" />
                        </div>
                    </div>

                    <!-- CAD Sample, Quantity -->
                    <div class="form-grid-2">
                        <div class="input-group">
                            <select name="cad_sample" class="quote-input">
                                <option value="" selected disabled hidden>Select CAD Sample</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <input type="number" name="quantity" class="quote-input" placeholder="Quantity *" required>
                        </div>
                    </div>

                    <!-- Upload (full width) -->
                    <div class="input-group form-upload-row">
                        <div class="file-upload-wrap">
                            <input type="file" name="quote_file" id="quote_file_input" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" onchange="document.getElementById('quote_file_text').value = this.files.length > 0 ? this.files[0].name : ''">
                            <input type="text" id="quote_file_text" class="quote-input" placeholder="No file chosen" readonly style="pointer-events: none;">
                            <button type="button" class="upload-btn" style="pointer-events: none;">Upload</button>
                        </div>
                    </div>

                    <div style="margin-bottom: 0.875rem; flex: 1; display: flex; flex-direction: column;" class="input-group">
                        <textarea name="message" class="quote-input" placeholder="Enter your message"></textarea>
                    </div>

                    <div style="text-align: center; padding-bottom: 0; margin-top: auto;">
                        <button type="submit" class="quote-submit-btn">Get Free Quote</button>
                    </div>
                </form>
                @include('components.quote-trim-script')
            </div>
        </div>
    </section>

    <!-- Features Badges Section -->
    <section class="features-badges-section">
        <div class="container">
            <div class="badges-horizontal">
                <div class="features-badges-wrapper">
                    <img src="{{ asset('uploads/competitive-icon.svg') }}" class="badge-icon-svg" alt="Competitive Pricing">
                    <span class="badge-label">Competitive Pricing</span>
                </div>
                <div class="trust-badges-wrapper">
                    <img src="{{ asset('uploads/no-die-icon.svg') }}" class="badge-icon-svg" alt="No Die or Plate Charges">
                    <span class="badge-label">No Die or Plate Charges</span>
                </div>
                <div class="shipping-badge-wrapper">
                    <img src="{{ asset('uploads/fast-turn-icon.svg') }}" class="badge-icon-svg" alt="Fast Turn Arounds">
                    <span class="badge-label">Fast Turn Arounds</span>
                </div>
                <div class="fourth-badge-wrapper">
                    <img src="{{ asset('uploads/free-ship-icon.svg') }}" class="badge-icon-svg" alt="Free Shipping">
                    <span class="badge-label">Free Shipping</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Specs Section -->
    <section class="specs-section" id="content-specs">
        <style>
            @media (max-width: 61.9375rem) {
                .specs-section h2 {
                    text-align: center !important;
                    font-size: 1.375rem !important;
                }
                .specs-table {
                    width: 100% !important;
                    border-collapse: collapse !important;
                }
                .specs-table td {
                    border: 1px solid #EAEAEA !important;
                    padding: 0.75rem 0.9375rem !important;
                    font-size: 0.8125rem !important;
                    color: #333 !important;
                }
                .specs-table tr:nth-child(odd) {
                    background-color: #FFF8E7 !important;
                }
                .specs-table tr:nth-child(even) {
                    background-color: #FFFFFF !important;
                }
                .specs-table tr td:first-child {
                    font-weight: 700 !important;
                    width: 35% !important;
                    color: #000 !important;
                }
            }
        </style>
        <span style="display: block; font-family: 'Inter', sans-serif; font-size: 1.5rem; font-weight: 700; color: #000; margin-bottom: 1.25rem; padding-left: 0;">Product Specifications</span>
        <div style="border-radius: 0.5rem; overflow: hidden; border: 1px solid #DDDDDD;">
            <table class="specs-table" style="border-style: hidden; width: 100%;">
                <tr>
                    <td>Retail Boxes</td>
                    <td>All Custom Sizes & Shapes</td>
                </tr>
                <tr>
                    <td>MOQ</td>
                    <td>{{ $product['moq'] ?? 'NO MOQ' }}</td>
                </tr>
                <tr>
                    <td>Paper Stock</td>
                    <td>10pt to 28pt (60lb to 400lb) Eco-Friendly Kraft, E-flute Corrugated, Bux Board, Cardstock</td>
                </tr>
                <tr>
                    <td>Printing</td>
                    <td>{{ $product['printing'] ?? 'Digital (Standard and HD Print), Lithography, CMYK, CMYK + 1 PMS color, CMYK + 2 PMS colors' }}</td>
                </tr>
                <tr>
                    <td>Finishing</td>
                    <td>{{ $product['finishing'] ?? 'Gloss Lamination, Matte Lamination, Gloss AQ, Gloss UV, Matte UV, Spot UV, Embossing, Foiling' }}</td>
                </tr>
                <tr>
                    <td>Included Options</td>
                    <td>Die Cutting, Gluing, Scored,Perforation</td>
                </tr>
                <tr>
                    <td>Proof</td>
                    <td>Flat View, 3D Mock-up, Physical Sampling (On request)</td>
                </tr>
                <tr>
                    <td>Turnaround</td>
                    <td>{{ $product['turnaround'] ?? '4-6 days Rush' }}</td>
                </tr>
                <tr>
                    <td>Shipping</td>
                    <td>Flat</td>
                </tr>
            </table>
        </div>
    </section>

    <!-- Customize Packaging Component (Coating and Finishing) -->
    @include('components.coating-finishing', ['productPageOnly' => true])

    <!-- How It Works Component (Simple 4-Step Order Process) -->
    @include('components.howitworks', ['hideOnMobile' => true])

    <!-- Product Testimonials -->
    @include('components.product-testimonials')

    <!-- Quote Section (Redesigned) -->
    @include('components.product-quote-new')

    <!-- SEO Content Section -->
    @php
        $productContentHtml = trim($product['long_description'] ?? '');
        if ($productContentHtml === '') {
            $productContentHtml = app(\App\Http\Controllers\AdminHomepageController::class)->loadSettings()['content_section'] ?? '';
        }
        $settings = ['content_section' => $productContentHtml];
    @endphp
    @include('components.content')

    <!-- FAQs Section -->
    @include('components.product-faq', ['displayFaqs' => $faqs])

    <!-- Related Products -->
    @php $rProds = !empty($relatedProducts) ? $relatedProducts : []; @endphp
    @if(count($rProds))
    <section class="related-products">
        <div class="container">
            <h2>Related Products</h2>
            <div class="products-grid">
                @foreach($rProds as $rp)
                    @php
                        $rpImg = '';
                        if (!empty($rp['image'])) {
                            $rpImg = $rp['image'];
                        } else {
                            $rpGalleryRaw = [];
                            if (!empty($rp['images'])) {
                                $rpGalleryRaw = is_string($rp['images']) ? (json_decode($rp['images'], true) ?: []) : (array) $rp['images'];
                            }
                            if (!empty($rpGalleryRaw) && count($rpGalleryRaw) > 0) {
                                $rpImg = $rpGalleryRaw[0];
                            } else {
                                $rpImg = 'uploads/Gift-Boxes.webp';
                            }
                        }
                        $rpImg = \Illuminate\Support\Str::startsWith($rpImg, ['storage/', 'uploads/', 'images/'])
                            ? $rpImg
                            : 'storage/' . $rpImg;
                        
                        $rpSlug = $rp['slug'] ?? \Illuminate\Support\Str::slug($rp['title']);
                        
                        $rpImgName = pathinfo(parse_url(asset($rpImg), PHP_URL_PATH), PATHINFO_FILENAME);
                        $rpImgCleanName = !empty($rp['title']) ? $rp['title'] : ucwords(str_replace(['-', '_'], ' ', preg_replace('/-[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}/i', '', $rpImgName)));
                    @endphp
                    <div class="product-card">
                        <a href="{{ url('/' . $rpSlug) }}/" style="text-decoration:none; color:inherit;">
                            <div class="product-image">
                                <img src="{{ asset($rpImg) }}" alt="{{ $rpImgCleanName }}" title="{{ $rpImgCleanName }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://placehold.co/284x284/eeeeee/555555?text={{ urlencode($rpImgCleanName) }}'">
                            </div>
                            <h4>{{ $rp['title'] }}</h4>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <script>
        function switchTab(tabId) {
            // Remove active class from all tabs
            document.querySelectorAll('.tab-item').forEach(el => el.classList.remove('active'));
            
            // Add active class to clicked tab
            if (document.getElementById('tab-btn-' + tabId)) {
                document.getElementById('tab-btn-' + tabId).classList.add('active');
                if (window.matchMedia('(max-width: 47.9375rem)').matches) {
                    const tabsScroller = document.querySelector('.tabs-section .container');
                    const selectedTab = document.getElementById('tab-btn-' + tabId);
                    if (tabsScroller && selectedTab) {
                        tabsScroller.scrollTo({
                            left: selectedTab.offsetLeft - (((window.innerWidth - tabsScroller.getBoundingClientRect().left) - selectedTab.offsetWidth) / 2),
                            behavior: 'smooth'
                        });
                    }
                }
            }
            
            // Hide all content sections
            if (document.getElementById('content-description')) document.getElementById('content-description').style.display = 'none';
            if (document.getElementById('content-specs')) document.getElementById('content-specs').style.display = 'none';
            if (document.getElementById('content-faqs')) document.getElementById('content-faqs').style.display = 'none';
            if (document.getElementById('content-order')) document.getElementById('content-order').style.display = 'none';
            
            // Show the target content
            if (document.getElementById('content-' + tabId)) {
                document.getElementById('content-' + tabId).style.display = 'block';
            }
        }
function toggleFaq(element) {
    const faqItemNode = element.closest('.faq-item');
    const answer = faqItemNode.querySelector('.faq-answer');
    const icon = element.querySelector('.faq-icon');

    // Close all other FAQs
    document.querySelectorAll('.faq-answer').forEach(item => {
        if (item !== answer) {
            item.style.display = 'none';

            const header = item.closest('.faq-item').querySelector('.faq-question');
            const headerIcon = header.querySelector('.faq-icon');

            header.style.backgroundColor = '';
            header.style.color = '';
            headerIcon.textContent = '+';
            headerIcon.style.color = '';
        }
    });

    // Toggle current FAQ
    if (answer.style.display === 'none' || answer.style.display === '') {
        answer.style.display = 'block';

        element.style.backgroundColor = '#8d4445';
        element.style.color = 'white';

        icon.textContent = '−';
        icon.style.color = 'white';
    } else {
        answer.style.display = 'none';

        element.style.backgroundColor = '';
        element.style.color = '';

        icon.textContent = '+';
        icon.style.color = '';
    }
}

        // READ MORE / READ LESS toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const readMoreBtn = document.getElementById('readMoreBtn');
            const moreDescription = document.getElementById('moreDescription');
            if (readMoreBtn && moreDescription) {
                readMoreBtn.addEventListener('click', function() {
                    const isOpen = this.getAttribute('aria-expanded') === 'true';
                    moreDescription.style.display = isOpen ? 'none' : 'block';
                    this.setAttribute('aria-expanded', String(!isOpen));
                    this.textContent = isOpen ? 'READ MORE' : 'READ LESS';
                });
            }
            
            // Lipstick Boxes READ MORE toggle
            const readMoreBtnLipstick = document.getElementById('readMoreBtnLipstick');
            const dotsLipstick = document.getElementById('dotsLipstick');
            const moreLipstick = document.getElementById('moreLipstick');
            
            if (readMoreBtnLipstick && dotsLipstick && moreLipstick) {
                readMoreBtnLipstick.addEventListener('click', function() {
                    if (dotsLipstick.style.display === 'none') {
                        dotsLipstick.style.display = 'inline';
                        moreLipstick.style.display = 'none';
                        this.setAttribute('aria-expanded', 'false');
                        this.textContent = 'READ MORE';
                    } else {
                        dotsLipstick.style.display = 'none';
                        moreLipstick.style.display = 'inline';
                        this.setAttribute('aria-expanded', 'true');
                        this.textContent = 'READ LESS';
                    }
                });
            }
        });
    </script>

    <!-- Finishes Tab and Carousel Script -->
    <script>
        // Finishes data for each tab with multiple products and their images
        const finishesData = {
            'Materials': {
                title: 'Materials We Offer',
                items: [
                    { name: 'Black Kraft', active: false, image: '{{ asset("uploads/finish-material-black-kraft.webp") }}' },
                    { name: 'Duplex Chipboard', active: false, image: '{{ asset("uploads/finish-material-duplex-chipboard.webp") }}' },
                    { name: 'Grey Board', active: true, image: '{{ asset("uploads/finish-material-grey-board.webp") }}' },
                    { name: 'Holographic', active: false, image: '{{ asset("uploads/finish-material-holographic.webp") }}' },
                    { name: 'Metallic Paper', active: false, image: '{{ asset("uploads/finish-material-metallic-paper.webp") }}' },
                    { name: 'Natural Brown Kraft', active: false, image: '{{ asset("uploads/finish-material-natural-brown.webp") }}' },
                    { name: 'SBS C2S', active: false, image: '{{ asset("uploads/finish-material-sbs-c2s.webp") }}' },
                    { name: 'Textured Paper', active: false, image: '{{ asset("uploads/finish-material-textured.webp") }}' }
                ]
            },
            'Printing Methods': {
                title: 'Printing Methods',
                items: [
                    { name: 'Digital Printing', active: false, image: '{{ asset("uploads/finish-print-digital.webp") }}' },
                    { name: 'Flexographic Printing', active: false, image: '{{ asset("uploads/finish-print-flexographic.webp") }}' },
                    { name: 'Gravure Printing', active: true, image: '{{ asset("uploads/finish-print-gravure.webp") }}' },
                    { name: 'Offset Printing', active: false, image: '{{ asset("uploads/finish-print-offset.webp") }}' },
                    { name: 'Rotogravure Printing', active: false, image: '{{ asset("uploads/finish-print-rotogravure.webp") }}' },
                    { name: 'Scodix Digital', active: false, image: '{{ asset("uploads/finish-print-scodix-digital.webp") }}' },
                    { name: 'Screen Printing', active: false, image: '{{ asset("uploads/finish-print-screen.webp") }}' },
                    { name: 'UV Printing', active: false, image: '{{ asset("uploads/finish-print-uv.webp") }}' }
                ]
            },
            'Inks': {
                title: 'Inks Available',
                items: [
                    { name: 'Oil Based Inks', active: false, image: '{{ asset("uploads/oil-based-inks.webp") }}' },
                    { name: 'Pantone', active: true, image: '{{ asset("uploads/patone.webp") }}' },
                    { name: 'Pantone metallic', active: false, image: '{{ asset("uploads/pantone-metallic.webp") }}' },
                    { name: 'Soy Vegetable Based Inks', active: false, image: '{{ asset("uploads/soy-vegetable-based-inks.webp") }}' },
                    { name: 'Water Based Inks', active: false, image: '{{ asset("uploads/water-based-inks.webp") }}' },
                    { name: 'Fluorescent Color Inks', active: false, image: '{{ asset("uploads/fluorescent-color-inks.webp") }}' }
                ]
            },
            'Finishing': {
                title: 'Finishing Options',
                items: [
                    { name: 'Anti-scratch Lamination', active: false, image: '{{ asset("uploads/Anti-scratch-Lamination-.webp") }}' },
                    { name: 'Aqueous Coating', active: false, image: '{{ asset("uploads/Aqueous-Coating-.webp") }}' },
                    { name: 'Lamination', active: true, image: '{{ asset("uploads/Lamination.webp") }}' },
                    { name: 'Soft-Touch Coating', active: false, image: '{{ asset("uploads/Soft-Touch-Coating-.webp") }}' },
                    { name: 'Soft-Touch Silk Lamination', active: false, image: '{{ asset("uploads/Soft-Touch-Silk-Lamination-.webp") }}' },
                    { name: 'Spot Gloss UV', active: false, image: '{{ asset("uploads/Spot-Gloss-UV.webp") }}' },
                    { name: 'Spot Gloss UV-2', active: false, image: '{{ asset("uploads/Spot-Gloss-UV-2.webp") }}' },
                    { name: 'UV Coating', active: false, image: '{{ asset("uploads/UV-Coating-.webp") }}' }
                ]
            },
            'Add-ons': {
                title: 'Add-ons Available',
                items: [
                    { name: 'Corrugated Box Bivider Inserts', alt: 'corrugated box bivider inserts', active: false, image: '{{ asset("uploads/corrugated-box-bivider-inserts.webp") }}' },
                    { name: 'Folding Carton Box Divider Inserts', alt: 'folding carton box divider inserts', active: true, image: '{{ asset("uploads/folding-carton-box-divider-inserts.webp") }}' },
                    { name: 'Hips Blister Insert', alt: 'hips blister insert', active: false, image: '{{ asset("uploads/hips-blister-insert.webp") }}' },
                    { name: 'Natural Kraft Corrugated Insert', alt: 'natural kraft corrugated insert', active: false, image: '{{ asset("uploads/natural-kraft-corrugated-insert.webp") }}' },
                    { name: 'Natural Kraft Paperboard Insert', alt: 'natural kraft paperboard insert', active: false, image: '{{ asset("uploads/natural-kraft-paperboard-insert.webp") }}' },
                    { name: 'Petg Blister Insert', alt: 'petg blister insert', active: false, image: '{{ asset("uploads/petg-blister-insert.webp") }}' },
                    { name: 'Pvc Blister Insert', alt: 'pvc blister insert', active: false, image: '{{ asset("uploads/pvc-blister-insert.webp") }}' },
                    { name: 'Standard White Corrugated Insert', alt: 'standard white corrugated insert', active: false, image: '{{ asset("uploads/standard-white-corrugated-insert.webp") }}' }
                ]
            },
            'Additional Options': {
                title: 'Additional Options',
                items: [
                    { name: 'Hot Foil Stamping', active: true, image: '{{ asset("uploads/hot-foil.webp") }}' },
                    { name: 'Cold Foil Printing', active: false, image: '{{ asset("uploads/cold-foil.webp") }}' },
                    { name: 'Blind Embossing', active: false, image: '{{ asset("uploads/blind-emboss.webp") }}' },
                    { name: 'Blind Debossing', active: false, image: '{{ asset("uploads/blind-deboss.webp") }}' },
                    { name: 'Registered Embossing', active: false, image: '{{ asset("uploads/registered-emboss.webp") }}' },
                    { name: 'Combination Embossing', active: false, image: '{{ asset("uploads/combo-emboss.webp") }}' },
                    { name: 'Window Patching', active: false, image: '{{ asset("uploads/window-patch.webp") }}' }
                ]
            }
        };

        // Tab switching functionality with scroll and image sync
        document.addEventListener('DOMContentLoaded', function() {
            const navItems = document.querySelectorAll('.finishes-bottom-nav span');
            const navContainer = document.querySelector('.finishes-bottom-nav');
            const titleElement = document.querySelector('.finishes-top-text');
            const itemsContainer = document.querySelector('.finishes-middle-list');
            const carouselImage = document.querySelector('.finishes-image-container img');
            const carouselDotsContainer = document.querySelector('.carousel-dots');
            let carouselDots = document.querySelectorAll('.carousel-dot');
            const tabNames = ['Materials', 'Printing Methods', 'Inks', 'Finishing', 'Add-ons', 'Additional Options'];
            let currentTabIndex = 0;
            let currentItemIndex = 2; // Start with middle item active

            function renderCarouselDots(count) {
                if (!carouselDotsContainer) return;
                carouselDotsContainer.innerHTML = '';
                for (let index = 0; index < count; index++) {
                    const dot = document.createElement('button');
                    dot.type = 'button';
                    dot.className = 'carousel-dot' + (index === currentItemIndex ? ' active' : '');
                    dot.setAttribute('aria-label', 'Show image ' + (index + 1));
                    dot.addEventListener('click', () => {
                        currentItemIndex = index;
                        updateTabContent(currentTabIndex);
                        clearInterval(autoplayTimer);
                        autoplayTimer = setInterval(advanceCarousel, 8000);
                    });
                    carouselDotsContainer.appendChild(dot);
                }
                carouselDots = carouselDotsContainer.querySelectorAll('.carousel-dot');
            }

            // Function to update image based on active product
            function updateProductImage(imageUrl, altText = '', dotIndex = null) {
                if (carouselImage && imageUrl) {
                    carouselImage.src = imageUrl;
                    carouselImage.alt = altText;
                    carouselImage.style.opacity = '1';
                }

                // Update dots if index provided
                if (dotIndex !== null) {
                    carouselDots.forEach((dot, i) => {
                        dot.classList.toggle('active', i === dotIndex);
                    });
                }
            }

            // Function to update tab content
            function updateTabContent(tabIndex, scrollDirection = 0) {
                // Remove active class from all tabs
                navItems.forEach(nav => {
                    nav.classList.remove('active-nav');
                    nav.style.fontWeight = '';
                    nav.style.color = '';
                });

                // Add active class to current tab
                navItems[tabIndex].classList.add('active-nav');
                navItems[tabIndex].style.fontWeight = '700';
                navItems[tabIndex].style.color = '#8D4445';
                if (navContainer) {
                    navContainer.scrollTo({
                        left: navItems[tabIndex].offsetLeft - ((navContainer.clientWidth - navItems[tabIndex].offsetWidth) / 2),
                        behavior: 'smooth'
                    });
                }

                // Get the tab name
                const tabName = tabNames[tabIndex];

                // Update content based on tab
                if (finishesData[tabName]) {
                    const data = finishesData[tabName];
                    
                    // Update title
                    titleElement.textContent = data.title;

                    // If scrolling within same tab, rotate the active item
                    if (scrollDirection !== 0 && currentTabIndex === tabIndex) {
                        // Rotate items
                        if (scrollDirection > 0) {
                            currentItemIndex = (currentItemIndex + 1) % data.items.length;
                        } else {
                            currentItemIndex = (currentItemIndex - 1 + data.items.length) % data.items.length;
                        }
                    } else if (currentTabIndex !== tabIndex) {
                        // When changing tabs, reset to index 0
                        currentItemIndex = 0;
                    }
                    
                    // Update active states in data
                    data.items.forEach((item, idx) => {
                        item.active = (idx === currentItemIndex);
                    });

                    renderCarouselDots(data.items.length);

                    // Update the product image for active item
                    const activeItem = data.items[currentItemIndex];
                    if (activeItem && activeItem.image) {
                        updateProductImage(activeItem.image, activeItem.alt || activeItem.name, currentItemIndex);
                    }

                    // Update labels immediately so they remain crisp and readable.
                    itemsContainer.innerHTML = '';
                        
                        // Show only 3 items at a time (before, current, after)
                        const visibleItems = [];
                        const visibleIndexes = [];
                        for (let i = -1; i <= 1; i++) {
                            const index = (currentItemIndex + i + data.items.length) % data.items.length;
                            visibleItems.push({...data.items[index]}); // Create a copy
                            visibleIndexes.push(index);
                        }
                        
                    visibleItems.forEach((item, relativeIndex) => {
                        const itemDiv = document.createElement('div');
                            // Only the middle item (index 1) should be dark
                            itemDiv.className = (relativeIndex === 1) ? 'finish-item-dark' : 'finish-item-light';
                            itemDiv.textContent = item.name;
                            
                            // Add click handler to ALL items to center them when clicked
                            itemDiv.style.cursor = 'pointer';
                            itemDiv.addEventListener('click', () => {
                                // Get the actual index from our visibleIndexes array
                                const actualIndex = visibleIndexes[relativeIndex];
                                currentItemIndex = actualIndex;
                                updateTabContent(currentTabIndex);
                                
                                // Reset autoplay timer
                                clearInterval(autoplayTimer);
                                autoplayTimer = setInterval(advanceCarousel, 8000);
                            });
                            
                        itemsContainer.appendChild(itemDiv);
                    });

                    itemsContainer.style.opacity = '1';
                }
                
                currentTabIndex = tabIndex;
            }

            // Click event for tabs
            navItems.forEach((item, index) => {
                item.addEventListener('click', function() {
                    updateTabContent(index);
                });
            });

            // Autoplay Carousel Logic
            let autoplayTimer;
            
            function advanceCarousel() {
                const tabName = tabNames[currentTabIndex];
                const data = finishesData[tabName];
                
                if (currentItemIndex + 1 >= data.items.length) {
                    // Switch to next tab automatically
                    let nextTabIndex = (currentTabIndex + 1) % tabNames.length;
                    updateTabContent(nextTabIndex);
                } else {
                    // Go to next item in current tab
                    updateTabContent(currentTabIndex, 1);
                }
            }

            // Start auto play
            autoplayTimer = setInterval(advanceCarousel, 8000);
            
            // Pause on hover
            const heroFormElement = document.querySelector('.hero-form');
            if (itemsContainer) {
                itemsContainer.addEventListener('mouseenter', () => clearInterval(autoplayTimer));
                itemsContainer.addEventListener('mouseleave', () => autoplayTimer = setInterval(advanceCarousel, 4000));
            }

            // Render the correct number of dots and load the initial final image.
            updateTabContent(currentTabIndex);

            // Add smooth transition for items and image
            if (itemsContainer) {
                itemsContainer.style.transition = 'opacity 0.5s ease';
            }
            if (carouselImage) {
                carouselImage.style.transition = 'opacity 0.5s ease';
            }

            // Keep the clicked control visibly active in both page forms.
            const formControlSelector = '.hero-form .form-control, .quote-form .form-control, .hero-form .custom-select-trigger, .quote-form .custom-select-trigger';
            document.addEventListener('click', function(event) {
                const activeControl = event.target.closest(formControlSelector);
                if (!activeControl) return;

                document.querySelectorAll(formControlSelector).forEach(control => {
                    control.classList.remove('is-active');
                });
                activeControl.classList.add('is-active');
            }, true);
            // Custom JS Select Implementation
            document.querySelectorAll('select.form-control:not(.quote-input)').forEach(select => {
                if (select.parentElement.classList.contains('custom-select-wrapper')) return;
                
                const wrapper = document.createElement('div');
                wrapper.className = 'custom-select-wrapper';
                
                select.parentNode.insertBefore(wrapper, select);
                wrapper.appendChild(select);
                select.style.display = 'none';
                
                const trigger = document.createElement('div');
                trigger.className = 'custom-select-trigger';
                trigger.textContent = select.options[select.selectedIndex]?.text || '';
                wrapper.appendChild(trigger);
                
                const optionsContainer = document.createElement('div');
                optionsContainer.className = 'custom-options';
                
                Array.from(select.options).forEach((option, index) => {
                    const customOption = document.createElement('div');
                    customOption.className = 'custom-option';
                    if (index === select.selectedIndex) customOption.classList.add('selected');
                    customOption.textContent = option.text;
                    customOption.setAttribute('data-value', option.value || option.text);
                    
                    customOption.addEventListener('click', function(e) {
                        e.stopPropagation();
                        select.selectedIndex = index;
                        select.dispatchEvent(new Event('change'));
                        
                        trigger.textContent = this.textContent;
                        trigger.classList.remove('open');
                        
                        optionsContainer.querySelectorAll('.custom-option').forEach(opt => opt.classList.remove('selected'));
                        this.classList.add('selected');
                        
                        optionsContainer.classList.remove('open');
                    });
                    optionsContainer.appendChild(customOption);
                });
                
                wrapper.appendChild(optionsContainer);
                
                trigger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    document.querySelectorAll('.custom-select-trigger').forEach(t => {
                        if (t !== trigger) {
                            t.classList.remove('open');
                            t.nextElementSibling.classList.remove('open');
                        }
                    });
                    this.classList.toggle('open');
                    optionsContainer.classList.toggle('open');
                });
            });
            
            document.addEventListener('click', function() {
                document.querySelectorAll('.custom-select-trigger').forEach(trigger => {
                    trigger.classList.remove('open');
                    trigger.nextElementSibling.classList.remove('open');
                });
            });

            // Initialize with first tab
            updateTabContent(0);
        });
    </script>


</script>
    
    <script>
        function switchProductImage(thumb, imageUrl) {
            const mainImage = document.getElementById('product-main-image');
            if (mainImage) mainImage.src = imageUrl;
            document.querySelectorAll('.thumbnails .thumb').forEach(function (item) {
                item.classList.toggle('active', item === thumb);
            });
        }

        document.addEventListener('click', function (event) {
            const formControlSelector = '.hero-form .form-control, .quote-form .form-control, .hero-form .custom-select-trigger, .quote-form .custom-select-trigger';
            const clickedControl = event.target.closest(formControlSelector);
            if (!clickedControl) return;

            document.querySelectorAll(formControlSelector).forEach(function (control) {
                control.style.setProperty('border', '0.0312rem solid #8d4445', 'important');
            });
            clickedControl.style.setProperty('border', '1px solid #8d4445', 'important');
        }, true);
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageWrap = document.querySelector('.main-image');
            const image = document.getElementById('product-main-image');
            if (!imageWrap || !image) return;

            function handleZoom(e) {
                const rect = imageWrap.getBoundingClientRect();
                const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                const clientY = e.touches ? e.touches[0].clientY : e.clientY;

                const x = clientX - rect.left;
                const y = clientY - rect.top;

                const xPercent = Math.max(0, Math.min(100, (x / rect.width) * 100));
                const yPercent = Math.max(0, Math.min(100, (y / rect.height) * 100));

                image.style.transformOrigin = `${xPercent}% ${yPercent}%`;
                image.style.transform = 'scale(1.5)';
            }

            function resetZoom() {
                image.style.transition = 'transform 0.3s ease-out, transform-origin 0.3s ease-out';
                image.style.transform = 'scale(1)';
                image.style.transformOrigin = 'center center';
            }

            imageWrap.addEventListener('mouseenter', function (e) {
                image.style.transition = 'transform 0.2s ease-out, transform-origin 0.05s linear';
                handleZoom(e);
            });

            imageWrap.addEventListener('mousemove', handleZoom);

            imageWrap.addEventListener('mouseleave', resetZoom);
            imageWrap.addEventListener('touchend', resetZoom);
            imageWrap.addEventListener('touchcancel', resetZoom);
        });
    </script>
    <script>
        let isScrollingToInvalid = false;
        document.addEventListener('invalid', function(e) {
            if (!isScrollingToInvalid) {
                isScrollingToInvalid = true;
                setTimeout(function() {
                    e.target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    e.target.focus();
                    setTimeout(() => isScrollingToInvalid = false, 1000);
                }, 10);
            }
        }, true);
    </script>

    @include('components.footer')
</body>
</html>
