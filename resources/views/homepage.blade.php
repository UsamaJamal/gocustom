<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0B2240">
    <link rel="icon" href="{{ asset('uploads/go-custom-boxes-favicon.png') }}" type="image/png">
    @php
        $homeTitle = !empty($settings['meta_title']) ? $settings['meta_title'] : 'Custom Printed Boxes & Luxury Packaging | Go Custom Boxes';
        $homeDesc = !empty($settings['meta_description']) ? $settings['meta_description'] : 'Custom printed rigid packaging boxes at wholesale rates. Premium luxury boxes for retail, cosmetic, and gift packaging.';
    @endphp
    <title>{{ $homeTitle }}</title>
    <meta name="description" content="{{ $homeDesc }}">
    @if(!empty($settings['meta_keywords']))
    <meta name="keywords" content="{{ $settings['meta_keywords'] }}">
    @endif
    <meta name="robots" content="{{ $settings['robots'] ?? 'index,follow' }}">
    <meta name="author" content="Go Custom Boxes">
    <meta name="publisher" content="Go Custom Boxes">

    <!-- Open Graph / Facebook -->
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $homeTitle }}">
    <meta property="og:description" content="{{ $homeDesc }}">
    <meta property="og:url" content="{{ rtrim(url('/'), '/') }}">
    <meta property="og:image" content="{{ asset('uploads/Home-Banner.webp') }}">
    <meta property="og:image:alt" content="{{ $homeTitle }}">
    <meta property="og:site_name" content="Go Custom Boxes">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $homeTitle }}">
    <meta name="twitter:description" content="{{ $homeDesc }}">
    <meta name="twitter:image" content="{{ asset('uploads/Home-Banner.webp') }}">
    <meta name="twitter:image:alt" content="{{ $homeTitle }}">

    @include('components.canonical')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Open+Sans:wght@300;400;600;700;800;900&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            overflow-x: clip;
            width: 100%;
        }

        body {
            font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--background-color, #FAF8F8);
            color: #000000;
        }

        .home-page,
        .home-page>section {
            width: 100%;
            max-width: 100%;
            overflow-x: clip;
        }

        /* Shared canvas aligned with the header's centered 80rem container. */
        .home-page>section>[class$="-container"],
        .home-page>section>[class$="-inner"],
        .home-page>section>[class$="-wrapper"] {
            width: 100%;
            max-width: 80rem !important;
            margin-left: auto;
            margin-right: auto;
            padding-left: 3.4375rem !important;
            padding-right: 3.4375rem !important;
            box-sizing: border-box;
            min-width: 0;
        }

        @media (max-width: 48rem) {

            .home-page>section>[class$="-container"],
            .home-page>section>[class$="-inner"],
            .home-page>section>[class$="-wrapper"] {
                padding-left: 1.25rem !important;
                padding-right: 1.25rem !important;
            }
        }

        @media (max-width: 30rem) {

            .home-page>section>[class$="-container"],
            .home-page>section>[class$="-inner"],
            .home-page>section>[class$="-wrapper"] {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
        }

        /* ─────────────────────────────────────────
           SECTION: CUSTOM BOXES FOR EVERY INDUSTRY
        ───────────────────────────────────────── */
        .custom-boxes-section {
            background: #fff;
            padding: 0.625rem 0 1.875rem;
        }

        .custom-boxes-container {
            max-width: 90rem;
            margin: 0 auto;
            padding: 0 1.5rem;
            text-align: center;
        }

        .custom-boxes-heading {
            display: block;
            font-family: 'Open Sans', sans-serif;
            font-weight: 700;
            font-size: 2rem;
            line-height: 100%;
            letter-spacing: 0%;
            text-transform: capitalize;
            color: var(--section-text-color);
            margin-bottom: 1.125rem;
        }

        .custom-boxes-container .section-desc {
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            font-size: 1rem;
            line-height: 1.5;
            letter-spacing: 0%;
            text-align: center;
            color: var(--section-text-color);
            max-width: 47rem;
            margin: 0 auto 1.75rem;
            text-align: justify;
        }

        /* ─────────────────────────────────────────
           CARDS GRID
        ───────────────────────────────────────── */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1.5rem;
            justify-content: start;
            max-width: 100%;
            align-items: stretch;
        }

        /* ─────────────────────────────────────────
           CARD  (exact Figma spec: 297.86 x 391)
        ───────────────────────────────────────── */
        .industry-card {
            width: 100%;
            min-height: 0;
            background: #F8F5EE;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: inherit;
            box-sizing: border-box;
            border-radius: 0.25rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Image area */
        .industry-card__image-wrap {
            width: 100% !important;
            aspect-ratio: 1 / 1 !important;
            background: #F8F5EE;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden;
            flex-shrink: 0;
            box-sizing: border-box;
            display: block;
        }

        .industry-card__image-wrap img {
            width: 100% !important;
            height: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            object-fit: cover !important;
            object-position: center;
            display: block;
            transition: transform 0.4s ease;
        }

        @media (hover: hover) {
            .industry-card:hover {
                transform: translateY(-0.3125rem);
                box-shadow: 0 0.625rem 1.25rem rgba(0, 0, 0, 0.08);
            }

            .industry-card:hover .industry-card__image-wrap img {
                transform: scale(1.05);
            }

            .industry-card:hover .industry-card__arrow {
                transform: rotate(-45deg) translate(0.125rem, -0.125rem);
            }
        }

        /* Bottom content area — Figma: 5.375rem (391 - 305) */
        .industry-card__bottom {
            display: flex;
            flex-direction: column;
            justify-content: center;
            flex: 1;
            min-height: 5.375rem;
            width: 100%;
            box-sizing: border-box;
            padding: 0.75rem 0.875rem;
            background: #F8F5EE;
        }

        .industry-card__bottom-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.25rem;
        }

        /* Card title */
        .industry-card__title {
            display: block;
            font-family: 'Open Sans', sans-serif;
            font-weight: 700;
            font-size: 0.9375rem;
            line-height: 1.2;
            letter-spacing: 0;
            text-transform: capitalize;
            text-align: left;
            color: #111;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding: 0;
        }

        .industry-card__arrow {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2F4235;
            flex-shrink: 0;
            margin-left: 0.5rem;
            transition: transform 0.3s ease;
        }

        /* Text area */
        .industry-card__text {
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            font-size: 0.75rem;
            line-height: 1.35;
            color: #000;
            text-align: left;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ─────────────────────────────────────────
           VIEW ALL CATEGORIES BUTTON
           Figma: w:200 h:46, border-radius:0.25rem,
                  padding:12/20/12/20, centered
        ───────────────────────────────────────── */
        .view-all-wrap {
            margin-top: 1.75rem;
            display: flex;
            justify-content: center;
        }

        .view-all-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 12.5rem;
            height: 2.875rem;
            background: var(--secondary-color);
            color: var(--primary-color);
            font-family: 'DM Sans', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            line-height: 1.5rem;
            letter-spacing: 0%;
            text-decoration: none;
            border-radius: 0.25rem;
            padding: 0.75rem 1.25rem;
            gap: 0.625rem;
            cursor: pointer;
            transition: background 0.25s, color 0.25s;
            border: none;
        }

        .view-all-btn:hover {
            background: #e6a200;
            /* Slightly darker shade of secondary color (#FFB400) */
            color: var(--primary-color);
        }

        /* ─────────────────────────────────────────
           WHY CHOOSE US SECTION
        ───────────────────────────────────────── */
        .why-choose-section {
            background: var(--background-color, #FAF8F8);
            padding: 0.625rem 0 1.875rem;
        }

        .why-choose-container {
            max-width: 90rem;
            margin: 0 auto;
            padding: 0 1.5rem;
            text-align: center;
        }

        .why-choose-container h2,
        .why-choose-container .h2-heading {
            display: block;
            font-family: 'Open Sans', sans-serif;
            font-weight: 700;
            font-size: 2rem;
            line-height: 100%;
            letter-spacing: 0%;
            text-transform: capitalize;
            color: var(--section-text-color);
            margin-bottom: 0.75rem;
        }

        .why-choose-container .why-desc {
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            font-size: 1rem;
            line-height: 1.5;
            color: var(--section-text-color);
            margin-bottom: 2.25rem;
        }

        /* ─────────────────────────────────────────
           BENTO WRAPPER
        ───────────────────────────────────────── */
        .why-bento {
            width: 100%;
            max-width: 100%;
            margin: 0;
            text-align: left;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            grid-template-rows: 10rem 6.25rem 10rem;
            gap: 0.875rem;
        }

        /* each row is a flex row */
        .why-row {
            display: contents;
        }

        .why-row+.why-row {
            margin-top: 0;
        }

        /* ── Base card ── */
        .why-card {
            border-radius: 1rem;
            padding: 1.25rem 1rem;
            display: block;
            position: relative;
            overflow: hidden;
            box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(0, 0, 0, 0.03);
            flex-shrink: 0;
        }

        .why-card__title {
            display: block;
            font-family: 'Open Sans', sans-serif;
            font-weight: 700;
            font-size: 0.9375rem;
            line-height: 1.2;
            color: var(--section-text-color);
            margin-bottom: 0.375rem;
            text-align: center;
        }

        .why-card__text {
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            font-size: 0.7812rem;
            line-height: 1.4;
            color: var(--section-text-color);
            text-align: center;
        }

        .why-card__content {
            width: 100%;
            position: relative;
            z-index: 2;
        }

        /* ── Image box ── */
        .why-card__img-box {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 8.75rem;
            height: 8.75rem;
            background: transparent;
            border-radius: 0.75rem;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            gap: 0.625rem;
            box-sizing: border-box;
        }

        .why-card__img-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 0.75rem;
        }

        /* ─────────────────────────────────────────
           CARD 1 — pink-1: Free Design Support
        ───────────────────────────────────────── */
        .wc-pink1 {
            background: #FDF0F6;
            width: 100%;
            height: 17.125rem;
            grid-column: 1;
            grid-row: 1 / span 2;
        }

        /* ─────────────────────────────────────────
           CARD 2 — pink-2: Premium Quality Materials
        ───────────────────────────────────────── */
        .wc-pink2 {
            background: #FCECEE;
            width: 100%;
            height: 17.125rem;
            grid-column: 2;
            grid-row: 1 / span 2;
        }

        /* ─────────────────────────────────────────
           CARD 3 — blue: Low MOQ
        ───────────────────────────────────────── */
        .wc-blue {
            background: #EAF3FB;
            width: 100%;
            height: 10rem;
            position: relative;
            grid-column: 3 / span 2;
            grid-row: 1;
            display: flex;
            align-items: center;
        }

        .wc-blue .why-card__content {
            max-width: 55%;
            position: relative;
            z-index: 2;
            text-align: left;
        }

        .wc-blue .why-card__title,
        .wc-blue .why-card__text,
        .wc-yellow .why-card__title,
        .wc-yellow .why-card__text {
            text-align: left;
        }

        .wc-blue .why-card__img-box {
            position: absolute;
            top: 0;
            right: 0;
            left: auto;
            transform: none;
            width: 58%;
            height: 100%;
            border-radius: 0;
        }

        .wc-blue .why-card__img-box img {
            object-fit: contain;
            object-position: right bottom;
            border-radius: 0;
        }

        /* ─────────────────────────────────────────
           CARD 4 — yellow: Dedicated Customer Service
        ───────────────────────────────────────── */
        .wc-yellow {
            background: #FDF7E7;
            width: 100%;
            height: 10rem;
            grid-column: 1 / span 2;
            grid-row: 3;
            display: flex;
            align-items: center;
        }

        .wc-yellow .why-card__content {
            max-width: 55%;
            position: relative;
            z-index: 2;
        }

        .wc-yellow .why-card__img-box {
            top: 0;
            left: auto;
            right: 0;
            transform: none;
            width: 58%;
            height: 100%;
            border-radius: 0;
        }

        .wc-yellow .why-card__img-box img {
            object-fit: contain;
            object-position: right bottom;
            border-radius: 0;
        }

        /* ─────────────────────────────────────────
           CARD 5 — green: Custom Sizes & Designs
        ───────────────────────────────────────── */
        .wc-green {
            background: #ECFBEF;
            width: 100%;
            height: 17.125rem;
            grid-column: 3;
            grid-row: 2 / span 2;
        }

        /* ─────────────────────────────────────────
           CARD 6 — skin: Fast Production Time
        ───────────────────────────────────────── */
        .wc-skin {
            background: #FDF3E9;
            width: 100%;
            height: 17.125rem;
            grid-column: 4;
            grid-row: 2 / span 2;
        }

        /* ─────────────────────────────────────────
           RESPONSIVE — Why Choose Us
        ───────────────────────────────────────── */

        /* Laptop container padding */
        @media (max-width: 81.25rem) and (min-width: 62.0625rem) {
            .why-choose-container {
                padding: 0 1.5rem;
            }

            .why-bento {
                gap: 0.625rem;
            }

            .why-card {
                padding: 1.5rem 1.125rem;
            }

            .why-card__title {
                font-size: 1rem;
                margin-bottom: 0.5rem;
            }

            .why-card__text {
                font-size: 0.8125rem;
                line-height: 1.45;
            }
        }

        /* Tablet: 2-col fluid stack below 62rem */
        @media (max-width: 62rem) {
            .why-choose-container {
                padding: 0 1.5rem;
            }

            .why-bento {
                width: 100%;
                display: block;
            }

            .why-row {
                display: flex;
                flex-wrap: wrap;
            }

            .why-row+.why-row {
                margin-top: 0.875rem;
            }

            .wc-pink1,
            .wc-pink2 {
                width: calc(50% - 0.4375rem);
                height: 22.5rem;
            }

            .wc-blue {
                width: 100%;
                height: auto;
                min-height: 17.5rem;
            }

            .wc-blue .why-card__illus {
                left: auto;
                right: 1.5rem;
                top: 1.0625rem;
            }

            .wc-blue .why-card__content {
                max-width: 55%;
            }

            .wc-yellow {
                width: 100%;
                height: auto;
                min-height: 11.25rem;
            }

            .wc-green,
            .wc-skin {
                width: calc(50% - 0.4375rem);
                height: 15.125rem;
            }
        }

        /* Mobile: single column */
        @media (max-width: 37.5rem) {
            .why-choose-section {
                padding: 0.3125rem 0 2.5rem;
            }

            .why-choose-container {
                padding: 0 1rem;
            }

            .why-choose-container h2 {
                font-size: 1.5rem;
            }

            .why-bento {
                width: 100%;
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .why-row {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .why-row+.why-row {
                margin-top: 0;
            }

            .why-card {
                display: flex !important;
                flex-direction: row !important;
                align-items: center !important;
                padding: 1rem 1.125rem !important;
                gap: 1rem !important;
                border-radius: 1rem !important;
                box-shadow: none !important;
                border: none !important;
            }

            .why-card__img-box,
            .why-card__illus {
                order: -1;
                width: 5.3125rem !important;
                height: 5.3125rem !important;
                margin: 0 !important;
                padding: 0 !important;
                background: transparent !important;
                position: static !important;
                display: flex !important;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                transform: none !important;
            }

            .why-card__img-box img,
            .why-card__illus {
                width: 100% !important;
                height: 100% !important;
                object-fit: contain !important;
                object-position: center !important;

            }

            .why-card__content {
                order: 1;
                flex: 1 !important;
                width: auto !important;
                max-width: none !important;
                text-align: left !important;
            }

            .why-card__title {
                font-size: 1rem !important;
                font-weight: 700 !important;
                margin-bottom: 0.25rem !important;
                line-height: 1.25 !important;
                text-align: left !important;
            }

            .why-card__text {
                font-size: 0.8125rem !important;
                line-height: 1.45 !important;
                color: #444 !important;
                text-align: left !important;
            }

            .wc-pink1,
            .wc-pink2,
            .wc-blue,
            .wc-yellow,
            .wc-green,
            .wc-skin {
                width: 100% !important;
                height: auto !important;
                min-height: 0 !important;
            }
        }

        /* ─────────────────────────────────────────
           PREMIUM CUSTOM RIGID BOXES SECTION
        ───────────────────────────────────────── */
        .premium-section {
            background: var(--primary-color, #8D4445);
            padding: 2.5rem 0 1.25rem;
            overflow: hidden;
        }

        .premium-inner {
            max-width: 90rem;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            gap: 3rem;
        }

        /* ── LEFT: two overlapping images ── */
        .premium-images {
            position: relative;
            width: 50%;
            height: 28.75rem;
            flex-shrink: 0;
        }

        .premium-img1 {
            position: absolute;
            top: 0;
            left: 0;
            width: 78%;
            height: 21.875rem;
            border-radius: 1.32rem;
            object-fit: cover;
            display: block;
        }

        /* img2 offset relative to img1 */
        .premium-img2 {
            position: absolute;
            top: 11.25rem;
            left: 36%;
            width: 55%;
            height: 16.25rem;
            border-radius: 0.9694rem;
            object-fit: cover;
            display: block;
            z-index: 2;
        }

        /* ── RIGHT: content col ── */
        .premium-content {
            width: auto;
            min-width: 0;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .premium-heading {
            display: block;
            font-family: 'Open Sans', sans-serif;
            font-weight: 700;
            font-size: 2rem;
            line-height: 2rem;
            letter-spacing: 0%;
            text-transform: capitalize;
            color: #fff;
            margin-bottom: 1.25rem;
            width: 100%;
        }

        .premium-desc {
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            font-size: 1rem;
            line-height: 1.6;
            letter-spacing: 0%;
            text-align: justify;
            color: rgba(255, 255, 255, 0.9);
            width: 100%;
            margin-bottom: 2rem;
        }

        /* Icons row */
        .premium-icons {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            gap: 2.5rem;
            margin-bottom: 2rem;
        }

        .premium-icon-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.625rem;
            width: 5.3125rem;
        }

        .premium-icon-item img {
            width: 3.125rem;
            height: 3.125rem;
            object-fit: contain;
            flex-shrink: 0;
        }

        .premium-icon-text {
            font-family: 'Open Sans', sans-serif;
            font-weight: 600;
            font-size: 0.9419rem;
            line-height: 1.0469rem;
            letter-spacing: 0%;
            text-align: center;
            color: #fff;
            width: 100%;
        }

        /* Order Now button */
        .premium-btn {
            display: inline-block;
            background: #fff;
            color: var(--primary-color, #8D4445);
            font-family: 'DM Sans', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            line-height: 1.5rem;
            text-decoration: none;
            border-radius: 0.25rem;
            padding: 0.75rem 2.5rem;
            transition: background 0.25s, color 0.25s;
        }

        .premium-btn:hover {
            background: var(--secondary-color, #F8EEEC);
        }

        /* RESPONSIVE — Premium Section */
        @media (max-width: 75rem) {
            .premium-inner {
                padding: 0 2.5rem;
                gap: 2.5rem;
            }

            .premium-images {
                width: 27.5rem;
                height: 26.25rem;
            }

            .premium-img1 {
                width: 23.75rem;
                height: 20rem;
            }

            .premium-img2 {
                top: 10rem;
                left: 10rem;
                width: 16.25rem;
                height: 15rem;
            }

            .premium-content {
                width: auto;
                flex: 1;
            }

            .premium-heading,
            .premium-desc {
                width: 100%;
            }
        }

        @media (max-width: 56.25rem) {
            .premium-inner {
                flex-direction: column;
                padding: 0 1.5rem;
                gap: 2rem;
            }

            .premium-images {
                width: 100%;
                height: 21.25rem;
            }

            .premium-img1 {
                width: 75%;
                height: 16.25rem;
            }

            .premium-img2 {
                top: 7.5rem;
                left: 36%;
                width: 55%;
                height: auto;
                aspect-ratio: 370/341;
            }

            .premium-content {
                width: 100%;
            }

            .premium-heading,
            .premium-desc {
                width: 100%;
            }
        }

        @media (max-width: 48rem) {
            .premium-icons {
                display: none;
            }
        }

        @media (max-width: 30rem) {
            .premium-section {
                padding: 1.25rem 0 1.875rem;
            }

            .premium-inner {
                flex-direction: column;
                padding: 0 1rem;
                gap: 1.5rem;
            }

            .premium-heading {
                font-size: 1.375rem;
                line-height: 1.75rem;
                width: 100%;
            }

            .premium-desc {
                width: 100%;
                font-size: 0.875rem;
            }

            .premium-icons {
                display: none;
            }

            .premium-content {
                width: 100%;
            }

            .premium-images {
                width: 100%;
                height: auto;
                position: relative;
            }

            .premium-img1 {
                width: 100%;
                height: auto;
                max-height: 21.875rem;
                position: relative;
            }

            .premium-img2 {
                display: none;
            }
        }

        /* ─────────────────────────────────────────
           BEST SELLER SECTION
        ───────────────────────────────────────── */
        .bestseller-section {
            background: var(--secondary-color, #F8EEEC);
            padding: 1.25rem 0;
            overflow: hidden;
            width: 100%;
        }

        .bestseller-inner {
            max-width: 90rem;
            width: 100%;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 2.5rem;
            box-sizing: border-box;
            overflow: hidden;
        }

        /* Left content block — w:260 */
        .bestseller-left {
            width: 16.25rem;
            flex-shrink: 0;
        }

        .bestseller-heading {
            display: block;
            font-family: 'Open Sans', sans-serif;
            font-weight: 700;
            font-size: 2rem;
            line-height: 2.5rem;
            letter-spacing: 0%;
            text-transform: capitalize;
            color: var(--section-text-color);
            margin-bottom: 1rem;
        }

        .bestseller-desc {
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            font-size: 1rem;
            line-height: 1.375rem;
            letter-spacing: 0%;
            text-align: justify;
            color: var(--section-text-color);
            margin-bottom: 1.5rem;
        }

        /* Dots — 4 circles, total width ~4.7812rem */
        .bestseller-right {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            flex: 1;
            min-width: 0;
            width: 100%;
        }

        .bestseller-dots {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 0.5rem;
        }

        .bestseller-dot {
            appearance: none;
            padding: 0;
            cursor: pointer;
            width: 0.9375rem;
            height: 0.9375rem;
            border-radius: 50%;
            flex-shrink: 0;
            border: 0.125rem solid var(--section-text-color, #000);
            background: transparent;
        }

        .bestseller-dot.active {
            background: var(--primary-color, #8D4445);
            border-color: var(--primary-color, #8D4445);
        }

        .bestseller-card--mobile-only {
            display: none !important;
        }

        /* Cards row */
        .bestseller-cards {
            display: flex;
            flex-direction: row;
            gap: 1.25rem;
            width: 100%;
            min-width: 0;
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
            scroll-behavior: smooth;
        }

        .bestseller-cards::-webkit-scrollbar {
            display: none;
        }

        .bestseller-card {
            width: 17.1875rem;
            min-width: 17.1875rem;
            height: 20.3125rem;
            flex: 0 0 17.1875rem;
            border-radius: 1.0762rem;
            overflow: hidden;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: transparent;
        }

        .bestseller-card__img {
            width: 17.1875rem;
            height: 17.1875rem;
            aspect-ratio: auto;
            border-radius: 1.0762rem;
            overflow: hidden;
            border: 0.0675rem solid #4A4E541A;
            flex-shrink: 0;
        }

        .bestseller-card__img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 1.0762rem;
        }

        .bestseller-card__title {
            font-family: 'Open Sans', sans-serif;
            font-weight: 700;
            font-size: 0.875rem;
            line-height: 1.4;
            color: var(--section-text-color);
            text-align: center;
            padding: 0.625rem 0.5rem 0;
        }

        /* ─────────────────────────────────────────
           RESPONSIVE — Best Seller
        ───────────────────────────────────────── */
        @media (max-width: 75rem) {
            .bestseller-inner {
                padding: 0 2.5rem;
                gap: 2rem;
            }
        }

        @media (max-width: 48rem) {
            .bestseller-section {
                padding: 0.625rem 0 1.875rem;
                margin-bottom: 1.25rem;
            }

            .bestseller-inner {
                flex-direction: column;
                padding: 0 1.25rem;
                gap: 1.25rem;
                align-items: center;
                text-align: center;
            }

            .bestseller-left {
                width: 100%;
            }

            .bestseller-heading {
                font-size: 1.5rem;
                line-height: 2rem;
                text-align: center;
            }

            .bestseller-desc {
                font-size: 0.875rem;
                text-align: center;
            }

            .bestseller-dots {
                display: none !important;
            }

            /* 2×2 card grid */
            .bestseller-cards {
                width: 100%;
                display: flex;
                flex-wrap: wrap;
                flex-direction: row;
                gap: 0.75rem;
                justify-content: flex-start;
            }

            .bestseller-card {
                width: calc(50% - 0.375rem);
                min-width: 0;
                height: auto;
                flex: 0 0 calc(50% - 0.375rem);
            }

            .bestseller-card--mobile-only {
                display: flex !important;
            }

            .bestseller-card__img {
                width: 100%;
                height: auto;
                aspect-ratio: 1 / 1;
            }

            .bestseller-card__img img {
                position: static;
                width: 100%;
                height: 100%;
            }
        }

        @media (min-width: 48.0625rem) and (max-width: 120rem) {
            .cards-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 1.5rem;
            }

            .industry-card {
                width: 100%;
                min-height: 0;
            }

            .industry-card__image-wrap {
                width: 100% !important;
                height: auto !important;
                aspect-ratio: 1 / 1 !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .industry-card__image-wrap img {
                width: 100% !important;
                height: 100% !important;
                object-fit: cover !important;
            }
        }

        /* Tablet portrait */
        @media (max-width: 48rem) {
            .custom-boxes-section {
                padding: 1.5rem 0 1.25rem;
            }

            .custom-boxes-container {
                padding: 0 1.25rem;
            }

            .cards-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .industry-card {
                width: 100%;
                min-height: auto;
            }

            .industry-card__image-wrap {
                width: 100% !important;
                height: auto !important;
                aspect-ratio: 1 / 1 !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .industry-card__image-wrap img {
                width: 100% !important;
                height: 100% !important;
                object-fit: cover !important;
            }

            .industry-card__bottom {
                padding: 0.75rem;
            }
        }

        /* Mobile */
        @media (max-width: 30rem) {
            .custom-boxes-container {
                padding: 0 0.75rem !important;
            }

            .custom-boxes-heading {
                font-size: 1.5rem;
            }

            .custom-boxes-container .section-desc {
                font-size: 0.875rem;
                margin-bottom: 1.5rem;
                text-align: center;
            }

            .cards-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.625rem;
            }

            .industry-card__image-wrap {
                width: 100% !important;
                height: auto !important;
                aspect-ratio: 1 / 1 !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .industry-card__image-wrap img {
                width: 100% !important;
                height: 100% !important;
                object-fit: cover !important;
            }

            .industry-card__bottom {
                padding: 0.5rem 0.625rem 0.75rem;
                min-height: auto;
            }

            .industry-card__text {
                display: none !important;
            }

            .industry-card__btn {
                font-size: 0.75rem;
                height: 2.25rem;
                padding: 0.4375rem 0.625rem;
                width: 100%;
                margin-left: 0;
                margin-top: 0.625rem;
            }

            .view-all-wrap {
                display: none !important;
            }

            .view-all-btn {
                font-size: 0.875rem;
                width: 11.25rem;
            }
        }

        /* ─────────────────────────────────────────
           CUSTOMIZE EVERY DETAIL SECTION
        ───────────────────────────────────────── */
        .customize-detail-section {
            background: var(--background-color, #FAF8F8);
            padding: 3rem 0 1.5625rem;
        }

        .customize-detail-inner {
            width: 100%;
            max-width: 82.5rem;
            margin: 0 auto;
            padding: 0 1.5rem !important;
            box-sizing: border-box;
        }

        /* Heading */
        .customize-detail-heading {
            display: block;
            font-family: 'Open Sans', sans-serif;
            font-weight: 700;
            font-size: 2rem;
            line-height: 100%;
            letter-spacing: 0%;
            text-transform: capitalize;
            color: var(--section-text-color);
            text-align: center;
            margin-bottom: 0.75rem;
        }

        /* Paragraph */
        .customize-detail-desc {
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            font-size: 1rem;
            line-height: 1.5;
            text-align: justify;
            color: var(--section-text-color);
            max-width: 34.25rem;
            margin: 0 auto 1.5rem;
        }

        /* Options pill bar */
        .customize-detail-options-wrapper {
            width: 100%;
            margin: 0 0 1.25rem 0;
            overflow-x: auto;
            scrollbar-width: none;
            cursor: grab;
        }

        .customize-detail-options-wrapper::-webkit-scrollbar {
            display: none;
        }

        .customize-detail-options-wrapper.grabbing {
            cursor: grabbing;
        }

        .customize-detail-options {
            min-width: 100%;
            width: max-content;
            border: 1px solid var(--section-text-color, #000);
            border-radius: 6.25rem;
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 0.3125rem 0.375rem;
            gap: 0.25rem;
            justify-content: space-between;
            user-select: none;
            box-sizing: border-box;
        }

        .cdo-btn {
            flex: 1 1 auto;
            height: 2.5rem;
            padding: 0 1.25rem;
            border-radius: 6.25rem;
            border: none;
            background: transparent;
            font-family: 'Open Sans', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--section-text-color);
            cursor: pointer;
            white-space: nowrap;
            transition: background 0.2s, color 0.2s;
        }

        .cdo-btn.active {
            background: #8d4445;
            color: #fff;
        }

        .cdo-btn:hover:not(.active) {
            background: transparent;
        }

        /* Cards row */
        .customize-detail-cards {
            width: 100%;
            max-width: none;
            display: flex;
            flex-direction: row;
            gap: 0.625rem;
            justify-content: center;
        }

        /* Each card: equal flex, square-ish aspect ratio */
        .cdc-card {
            position: relative;
            border-radius: 0.75rem;
            overflow: hidden;
            flex: 0 1 21.875rem;
            width: 100%;
            max-width: 21.875rem;
            min-width: 0;
            aspect-ratio: 350 / 406;
            background: #e8e8e8;
        }

        .cdc-card img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            display: block;
        }

        .cdc-card__label {
            display: none;
        }

        /* ─────────────────────────────────────────
           RESPONSIVE — Customize Detail
        ───────────────────────────────────────── */
        @media (max-width: 75rem) {
            .customize-detail-inner {
                padding: 0 1.5rem;
            }

            .cdo-btn {
                font-size: 0.875rem;
                padding-inline: 0.875rem;
            }
        }

        @media (max-width: 56.25rem) {
            .customize-detail-inner {
                padding: 0 1.5rem !important;
            }
        }

        @media (max-width: 48rem) {
            .customize-detail-section {
                padding: 1.25rem 0 1.625rem;
            }

            .customize-detail-inner {
                padding: 0 1.25rem !important;
            }

            .customize-detail-heading {
                font-size: 1.5rem;
            }

            .customize-detail-desc {
                font-size: 0.875rem;
                max-width: 100%;
            }

            .customize-detail-options {
                justify-content: flex-start;
                gap: 0.5rem;
            }

            .cdo-btn {
                font-size: 0.8125rem;
                padding: 0 0.875rem;
                height: 2.375rem;
                flex: 0 0 auto;
            }

            /* horizontal scroll */
            .customize-detail-cards {
                flex-direction: row;
                gap: 0.875rem;
                overflow-x: auto;
                justify-content: flex-start;
                scrollbar-width: none;
                -ms-overflow-style: none;
                scroll-behavior: smooth;
            }

            .customize-detail-cards::-webkit-scrollbar {
                display: none;
            }

            .cdc-card {
                flex: 0 0 80vw;
                width: 80vw;
                max-width: 21.875rem;
                aspect-ratio: 350 / 406;
                align-self: center;
            }
        }

        /* ─────────────────────────────────────────
           SUSTAINABLE PACKAGING SOLUTIONS SECTION
        ───────────────────────────────────────── */
        .sustainable-section {
            background: #FAF8F8;
            padding: 1.25rem 0 1.25rem;
        }

        .sustainable-inner {
            max-width: 90rem;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* heading */
        .sustainable-heading {
            display: block;
            font-family: 'Open Sans', sans-serif;
            font-weight: 700;
            font-size: 2rem;
            line-height: 100%;
            letter-spacing: 0%;
            text-transform: capitalize;
            color: var(--section-text-color);
            text-align: center;
            margin-bottom: 0.75rem;
        }

        /* paragraph */
        .sustainable-desc {
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            font-size: 1rem;
            line-height: 1.5;
            text-align: justify;
            color: var(--section-text-color);
            max-width: 39rem;
            margin: 0 auto 1.5rem;
        }

        /* 2-col grid: left big image | right two stacked images */
        .sustainable-grid {
            width: 100%;
            display: flex;
            flex-direction: row;
            gap: 1.25rem;
            align-items: stretch;
        }

        /* ── LEFT: big image with overlay text + button ── */
        .sustainable-left {
            width: 37.875rem;
            height: 37.5rem;
            flex-shrink: 0;
            border-radius: 0.5rem;
            overflow: hidden;
            position: relative;
        }

        .sustainable-left img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 0.5rem;
        }

        .sustainable-left__overlay {
            position: absolute;
            bottom: 2.75rem;
            left: 3.5rem;
            right: 1.5rem;
        }

        .sustainable-eco-label {
            font-family: 'Open Sans', sans-serif;
            font-weight: 600;
            font-size: 1.125rem;
            line-height: 100%;
            color: #fff;
            margin-bottom: 0.75rem;
            display: block;
        }

        .sustainable-tagline {
            font-family: 'Open Sans', sans-serif;
            font-weight: 700;
            font-size: 2rem;
            line-height: 1.2;
            color: #fff;
            margin-bottom: 1.25rem;
            max-width: 27.4375rem;
        }

        .sustainable-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 12.5rem;
            height: 3.125rem;
            background: var(--primary-color, #8D4445);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-weight: 700;
            font-size: 0.9375rem;
            text-decoration: none;
            border-radius: 0.25rem;
            padding: 0.75rem 1.25rem;
            gap: 0.625rem;
            box-shadow: 0 0.125rem 0.25rem 0 #00000040;
            transition: background 0.25s;
        }

        .sustainable-btn:hover {
            background: var(--footer-color, #5F2D2F);
        }

        /* ── RIGHT: two stacked images ── */
        .sustainable-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            height: 37.5rem;
        }

        .sustainable-right__card {
            flex: 1;
            border-radius: 0.5rem;
            overflow: hidden;
            position: relative;
            min-height: 0;
        }

        .sustainable-right__card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 0.5rem;
        }

        .sustainable-right__label {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Open Sans', sans-serif;
            font-weight: 700;
            font-size: 2rem;
            line-height: 100%;
            color: #FFFFFF;
            white-space: nowrap;
        }

        /* ─────────────────────────────────────────
           RESPONSIVE — Sustainable
        ───────────────────────────────────────── */
        @media (max-width: 75rem) {
            .sustainable-inner {
                padding: 0 2.5rem;
            }

            .sustainable-left {
                width: 48%;
            }
        }

        @media (max-width: 48rem) {
            .sustainable-section {
                padding: 0 0 1.5625rem;
            }

            .sustainable-inner {
                padding: 0 1rem;
            }

            .sustainable-heading {
                font-size: 1.5rem;
                line-height: 1.2;
            }

            .sustainable-desc {
                font-size: 0.875rem;
                max-width: 100%;
            }

            /* horizontal scroll */
            .sustainable-grid {
                flex-direction: row;
                gap: 0.875rem;
                overflow-x: auto;
                justify-content: flex-start;
                scrollbar-width: none;
                -ms-overflow-style: none;
                scroll-behavior: smooth;
            }

            .sustainable-grid::-webkit-scrollbar {
                display: none;
            }

            .sustainable-left {
                width: 100%;
                height: 23.75rem;
                flex: 1;
            }

            /* overlay adjustments */
            .sustainable-left__overlay {
                left: 1.25rem;
                right: 1.25rem;
                bottom: 1.75rem;
            }

            .sustainable-eco-label {
                font-size: 0.8125rem;
                margin-bottom: 0.5rem;
            }

            .sustainable-tagline {
                font-size: 1.375rem;
                line-height: 1.25;
                margin-bottom: 1rem;
            }

            .sustainable-btn {
                width: 10.625rem;
                height: 2.75rem;
                font-size: 0.875rem;
            }

            /* right column: hide on mobile as requested */
            .sustainable-right {
                display: none;
            }

            .sustainable-right__card {
                width: 85vw;
                height: 23.75rem;
                flex: 0 0 85vw;
            }

            .sustainable-right__label {
                font-size: 1.125rem;
                white-space: normal;
                text-align: center;
                width: 90%;
            }
        }


        /* ═══════════════════════════════════
           CUSTOM QUOTE
        ═══════════════════════════════════ */
        .quote-section {
            background: var(--primary-color);
            width: 100%;
            padding: 1.25rem 0 3.375rem;
            position: relative;
            overflow: hidden;
            margin-top: 1.25rem;
        }

        .quote-container {
            max-width: 90rem;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 2.5rem;
            position: relative;
            z-index: 2;
        }

        .quote-form-card {
            width: 46.1875rem;
            min-height: auto;
            flex-shrink: 0;
            background: #fff;
            border-radius: 1.25rem;
            padding: 2.875rem;
            box-sizing: border-box;
        }

        .quote-form-title {
            font-family: 'Open Sans', sans-serif;
            font-size: 2rem !important;
            font-weight: 800;
            color: var(--section-text-color);
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .form-section-label {
            font-family: 'Open Sans', sans-serif;
            font-weight: 700;
            font-size: 0.9375rem;
            color: var(--primary-color);
            margin-bottom: 0.625rem;
            margin-top: 1.375rem;
        }

        .form-row {
            display: flex;
            gap: 0.75rem;
            width: 100%;
            box-sizing: border-box;
        }

        .form-row input,
        .form-row select,
        .form-row textarea {
            flex: 1;
            min-width: 0;
            height: 2.75rem;
            border: 0.0125rem solid var(--section-text-color);
            border-radius: 0.375rem;
            padding: 0 0.875rem;
            font-size: 0.875rem;
            color: #333;
            background: #FAFAFA;
            outline: none;
            box-sizing: border-box;
            appearance: none;
            -webkit-appearance: none;
        }

        .form-row input::placeholder,
        .form-row textarea::placeholder {
            color: #AAAAAA;
        }

        .form-row input:focus,
        .form-row select:focus,
        .form-row textarea:focus {
            border-color: var(--primary-color);
            background: #fff;
        }

        .select-wrapper {
            flex: 1;
            min-width: 0;
            position: relative;
        }

        .select-wrapper select {
            width: 100%;
            padding-right: 2.25rem;
            cursor: pointer;
        }

        .select-wrapper::after {
            content: '';
            position: absolute;
            right: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            border-left: 0.3125rem solid transparent;
            border-right: 0.3125rem solid transparent;
            border-top: 0.375rem solid #666;
            pointer-events: none;
        }

        .specs-row {
            display: flex;
            gap: 0.75rem;
            width: 100%;
            box-sizing: border-box;
        }

        .specs-row input {
            flex: 1;
            min-width: 0;
            height: 2.75rem;
            border: 0.0125rem solid var(--section-text-color);
            border-radius: 0.375rem;
            padding: 0 0.875rem;
            font-size: 0.875rem;
            color: #333;
            background: #FAFAFA;
            outline: none;
            box-sizing: border-box;
        }

        .specs-unit {
            position: relative;
            width: 4.5rem;
            flex-shrink: 0;
        }

        .specs-unit select {
            width: 100%;
            height: 2.75rem;
            border: 0.0125rem solid var(--section-text-color);
            border-radius: 0.375rem;
            padding: 0 1.5rem 0 0.625rem;
            font-size: 0.875rem;
            color: #333;
            background: #FAFAFA;
            appearance: none;
            -webkit-appearance: none;
            box-sizing: border-box;
        }

        .specs-unit::after {
            content: '';
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            border-left: 0.25rem solid transparent;
            border-right: 0.25rem solid transparent;
            border-top: 0.3125rem solid #666;
            pointer-events: none;
        }

        .preferences-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.75rem;
            width: 100%;
        }

        .textarea-row {
            width: 100%;
        }

        .textarea-row textarea {
            width: 100%;
            height: 8rem;
            border: 0.0125rem solid var(--section-text-color);
            border-radius: 0.5rem;
            padding: 0.75rem 0.875rem;
            font-size: 0.875rem;
            color: #333;
            background: #FAFAFA;
            outline: none;
            resize: vertical;
            box-sizing: border-box;
        }

        .quote-btn-wrap {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
        }

        .quote-submit-btn {
            width: 17.75rem;
            height: 3.125rem;
            background: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 0.25rem;
            padding: 0.75rem 1.25rem;
            font-family: 'Open Sans', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
        }

        .quote-steps {
            flex: 1;
            padding-top: 3.5625rem;
            display: flex;
            flex-direction: column;
        }

        .quote-steps-inner {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .quote-step {
            display: flex;
            align-items: flex-start;
            gap: 0.875rem;
            position: relative;
        }

        .quote-step:not(:last-child) {
            flex-grow: 1;
            padding-bottom: 2.5rem;
        }

        .quote-step:not(:last-child)::before {
            content: '';
            position: absolute;
            left: 2.25rem;
            top: 4.5625rem;
            bottom: 0;
            width: 1px;
            background: rgba(255, 255, 255, 0.15);
        }

        .step-number-block {
            position: relative;
            flex-shrink: 0;
            width: 7.3125rem;
        }

        .step-num-box {
            width: 4.5625rem;
            height: 4.5625rem;
            background: #fff;
            border-radius: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Open Sans', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary-color);
            z-index: 2;
            flex-shrink: 0;
        }

        .step-ghost-num {
            position: absolute;
            left: 5.3125rem;
            top: -0.75rem;
            font-size: 5rem;
            font-weight: 900;
            color: rgba(255, 255, 255, 0.15);
            line-height: 1;
            pointer-events: none;
            user-select: none;
        }

        .step-text {
            flex: 1;
            padding-top: 0.375rem;
        }

        .step-title {
            font-family: 'Open Sans', sans-serif;
            font-size: 1.125rem !important;
            font-weight: 800;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.0312rem;
            margin-bottom: 0.625rem;
        }

        .step-desc {
            font-size: 0.875rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.75);
        }

        @media (max-width: 80rem) {
            .quote-container {
                padding: 0 2.5rem;
                gap: 1.875rem;
            }

            .quote-form-card {
                width: 37.5rem;
            }
        }

        @media (max-width: 62rem) {
            .quote-section {
                padding: 2.5rem 0 3.125rem;
                margin-top: 0;
            }

            .quote-container {
                flex-direction: column-reverse;
                padding: 0 5%;
            }

            .quote-form-card {
                width: 100%;
                min-height: unset;
            }

            .quote-steps {
                padding-top: 0;
                padding-bottom: 2.5rem;
            }
        }

        @media (max-width: 36rem) {
            .quote-container {
                padding: 0 5%;
            }

            .quote-form-card {
                padding: 1.25rem;
                border-radius: 1.125rem;
            }

            .quote-form-title {
                font-size: 1.25rem !important;
            }

            .form-row {
                flex-direction: column;
                gap: 0.625rem;
            }

            .preferences-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .quote-submit-btn {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    @php
    $settings = $settings ?? [];
    $categories = $categories ?? [];
    $products = $products ?? [];
    @endphp

    @include('components.header')

    <main class="home-page">
        @include('components.herohome')
        @include('components.logo')
        <!-- Custom Printed Boxes for Every Industry Section -->
        <section class="custom-boxes-section">
            <div class="custom-boxes-container">

                <span class="custom-boxes-heading">Packaging Solutions for Brands To Stand Out</span>
                <p class="section-desc">Businesses look for packaging solutions that boost visual brand identity and elevate customers’ experience. We have a huge range of precision-crafted solutions. Explore this section to get the desired packaging.</p>

                <div class="cards-grid">
                    @php
                    $featuredCatIds = array_map('intval', (array) ($settings['featured_categories'] ?? []));





                    $categoriesById = collect($categories)->keyBy('id');
                    $featuredCategories = collect($featuredCatIds)
                        ->map(fn ($id) => $categoriesById->get($id))
                        ->filter(fn ($cat) => $cat && ($cat['status'] ?? 'published') === 'published')
                        ->values()
                        ->all();



                    @endphp

                    @if(empty($featuredCategories))
                    <p style="grid-column: 1 / -1; text-align: center; color: #667085; padding: 1.5rem 0;">Select
                        categories from Home Page Settings to show them here.</p>
                    @endif
                    @foreach ($featuredCategories as $cat)
                    @php
                    $catSlug = $cat['slug'] ?? Str::slug($cat['title']);
                    $catUrl = url('/' . $catSlug) . '/';
                    $cImg = !empty($cat['image'])
                    ? (\Illuminate\Support\Str::startsWith($cat['image'], [
                    'storage/',
                    'uploads/',
                    'images/',
                    ])
                    ? $cat['image']
                    : 'storage/' . $cat['image'])
                    : 'uploads/Gift-Boxes.webp';
                    @endphp
                    <a href="{{ $catUrl }}" class="industry-card">
                        <div class="industry-card__image-wrap">
                            <img src="{{ asset($cImg) }}" alt="{{ $cat['title'] }}" title="{{ $cat['title'] }}"
                                onerror="this.src='https://placehold.co/275x266/dddddd/555555?text={{ urlencode($cat['title']) }}'">
                        </div>
                        <div class="industry-card__bottom">
                            <div class="industry-card__bottom-top">
                                <span class="industry-card__title">{{ $cat['title'] }}</span>
                                <span class="industry-card__arrow">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14M12 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </div>
                            <p class="industry-card__text">
                                {{ Str::limit(html_entity_decode(html_entity_decode(strip_tags($cat['description'] ??
                                'Premium packaging with a luxury feel and durable structure.'))), 45) }}
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div><!-- /.cards-grid -->

            </div><!-- /.custom-boxes-container -->
        </section>

        <!-- ═══════════════════════════════════════
             BEST SELLER PRODUCT SECTION
        ═══════════════════════════════════════ -->
        <style>
            .best-seller-section {
                padding: 0.625rem 0 3.75rem 0;
                background: #fff;
                width: 100%;
            }

            .best-seller-container {
                max-width: 80rem;
                margin: 0 auto;
                padding: 0 3.4375rem;
                box-sizing: border-box;
                width: 100%;
            }

            .best-seller-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 1.5rem;
                margin-top: 1.875rem;
                width: 100%;
            }

            .bs-card {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-decoration: none;
            }

            .bs-card__img-wrap {
                width: 100%;
                aspect-ratio: 1;
                border-radius: 0.75rem;
                overflow: hidden;
                background: #F6F4F0;
                margin-bottom: 0.75rem;
            }

            .bs-card__img-wrap img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.3s;
            }

            .bs-card:hover .bs-card__img-wrap img {
                transform: scale(1.05);
            }

            .bs-card__title {
                font-family: 'Open Sans', sans-serif;
                font-weight: 700;
                font-size: 0.9375rem;
                color: #222;
                text-align: center;
            }

            .bs-heading {
                display: block;
                font-family: 'Open Sans', sans-serif;
                font-size: 1.75rem;
                font-weight: 700;
                color: #000;
                margin-bottom: 0.5rem;
            }

            .bs-desc {
                font-family: 'DM Sans', sans-serif;

                color: #000;
                margin-bottom: 0;
            }

            @media (max-width: 61.9375rem) {
                .best-seller-grid {
                    grid-template-columns: repeat(3, 1fr);
                }
            }

            @media (max-width: 48rem) {
                .best-seller-section {
                    padding: 0.9375rem 0 1.875rem 0;
                }

                .best-seller-grid {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 1rem;
                }

                .bs-heading {
                    text-align: center;
                    font-size: 1.5rem;
                }

                .bs-desc {
                    text-align: center;
                    font-size: 0.875rem;
                    margin-bottom: 1.25rem;
                }
            }
        </style>
        <section class="best-seller-section">
            <div class="best-seller-container">
                <span class="bs-heading">Best Seller Product</span>
                <p class="bs-desc">Custom packaging for every industry, from retail and beauty to
                    electronics&mdash;designed to fit your style and requirements.</p>

                <div class="best-seller-grid">
                    @php
                    $bestSellerProductIds = array_map('intval', (array) ($settings['bestseller_products'] ?? []));
                    $productsById = collect($products)->keyBy('id');
                    $bestSellers = collect($bestSellerProductIds)
                    ->map(fn ($id) => $productsById->get($id))
                    ->filter(fn ($product) => $product && ($product['status'] ?? '') === 'published')
                    ->values();
                    @endphp
                    @foreach($bestSellers as $item)
                    @php
                    $catSlug = $item['slug'] ?? Str::slug($item['title']);
                    $catUrl = url('/' . $catSlug) . '/';
                    $bsImg = !empty($item['image'])
                    ? (\Illuminate\Support\Str::startsWith($item['image'], ['storage/', 'uploads/', 'images/'])
                    ? $item['image']
                    : 'storage/' . $item['image'])
                    : 'uploads/Gift-Boxes.webp';
                    @endphp
                    <a href="{{ $catUrl }}" class="bs-card">
                        <div class="bs-card__img-wrap">
                            <img src="{{ asset($bsImg) }}" alt="{{ $item['title'] }}" title="{{ $item['title'] }}"
                                onerror="this.src='https://placehold.co/300x300/dddddd/555555?text={{ urlencode($item['title']) }}'">
                        </div>
                        <span class="bs-card__title">{{ $item['title'] }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════
             SEE AND FEEL THE DIFFERENCE SECTION
        ═══════════════════════════════════════ -->
        <!-- ═══════════════════════════════════════
             SEE AND FEEL THE DIFFERENCE SECTION
        ═══════════════════════════════════════ -->
        <style>
            .see-feel-section {
                padding: 0 0 1.25rem 0;
                background: #fff;
                width: 100%;
            }

            .see-feel-inner {
                width: 100%;
                max-width: 80rem;
                margin: 0 auto;
                padding: 0 3.4375rem;
                box-sizing: border-box;
            }

            .see-feel-box {
                width: 100%;
                background: #0B2240;
                border-radius: 0.75rem;
                padding: 3.125rem 3.75rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 2.5rem;
                box-sizing: border-box;
            }

            .see-feel-left {
                flex: 1;
                max-width: 31.25rem;
                color: #fff;
            }

            .see-feel-heading {
                font-family: 'Open Sans', sans-serif;
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 1.25rem;
                line-height: 1.2;
                display: block;
            }

            .see-feel-desc {
                font-family: 'DM Sans', sans-serif;

                margin-bottom: 1.875rem;
                line-height: 1.6;
                color: rgba(255, 255, 255, 0.85);
                text-align: justify;
            }

            .see-feel-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background: #FFB400;
                color: #0B2240;
                font-family: 'DM Sans', sans-serif;
                font-weight: 700;
                font-size: 0.9375rem;
                padding: 0.875rem 2.25rem;
                border-radius: 0.25rem;
                text-decoration: none;
                transition: background 0.3s;
                width: auto;
                white-space: nowrap;
                height: 3.5rem;
            }

            .see-feel-btn:hover {
                background: #e6a200;
                color: #0B2240;
            }

            .see-feel-right {
                flex: 1;
                background: transparent;
                border-radius: 0.75rem;
                aspect-ratio: 16/10;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 1.25rem;
                color: #000;
            }

            .sfr-icon {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                opacity: 0.3;
            }

            .sfr-img {
                width: 100%;
                height: 100%;
                object-fit: contain;
                border-radius: 0.75rem;
                display: block;
            }

            .sfr-text {
                font-family: 'Open Sans', sans-serif;
                font-weight: 800;
                font-size: 1.5rem;
                opacity: 1;
                margin: 0 0.625rem;
            }

            @media (max-width: 61.9375rem) {
                .see-feel-box {
                    flex-direction: column;
                    padding: 2rem 1.5rem;
                    gap: 1.5rem;
                }

                .see-feel-left {
                    max-width: 100%;
                    text-align: left;
                }

                .see-feel-heading {
                    text-align: left;
                    font-size: 1.5rem;
                    margin-bottom: 0.75rem;
                }

                .see-feel-desc {
                    text-align: justify;
                    margin-bottom: 0;
                }

                /* Image and layout for mobile */
                .see-feel-right {
                    width: 100%;
                    max-width: 20.375rem;
                    aspect-ratio: 326 / 218.69;
                    margin: 0 auto;
                    border-radius: 0.75rem;
                    flex: none !important;
                }

                .sfr-icon,
                .sfr-text {
                    display: none !important;
                }

                /* Button visibility */
                .desktop-btn {
                    display: none !important;
                }

                .mobile-btn {
                    display: flex !important;
                    width: auto;
                    margin-top: 0.5rem;
                    justify-content: center;
                    white-space: nowrap;
                    padding: 0.875rem 1.5rem;
                }
            }

            @media (min-width: 62rem) {
                .mobile-btn {
                    display: none !important;
                }
            }

            @media (max-width: 48rem) {
                .see-feel-inner {
                    padding: 0 1.25rem;
                }
            }

            @media (max-width: 30rem) {
                .see-feel-inner {
                    padding: 0 1rem;
                }
            }
        </style>
        <section class="see-feel-section">
            <div class="see-feel-inner">
                <div class="see-feel-box">
                    <div class="see-feel-left">
                        <span class="see-feel-heading">Designed to Impress, Crafted to Represent Your Brand</span>
                        <p class="see-feel-desc">Custom boxes with logos are not just about tailor packaging. It is beyond that. Research data shows that customers get influenced by packaging while making buying decisions. Hence, we design your packaging with visual hierarchy that tells your brand story. We are determined to crafting personalized solutions with product-focused approach. Give your product an attention grabbing appearance and a risk-free protection.</p>
                        <a href="/request-quote/" class="see-feel-btn desktop-btn">Get Instant Quote</a>
                    </div>
                    <div class="see-feel-right">
                        <img src="{{ asset('uploads/see-feel-image.webp') }}?v={{ @filemtime(public_path('uploads/see-and-feel.jpeg')) ?: 1 }}"
                            alt="Sustainable packaging materials" class="sfr-img">
                    </div>
                    <a href="/request-quote/" class="see-feel-btn mobile-btn">Get Instant Quote</a>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════
             MAKE YOUR BOX UNIQUELY YOURS SECTION
        ═══════════════════════════════════════ -->
        <style>
            .uniquely-yours-section {
                padding: 0 0;
                background: #fff;
                text-align: center;
                width: 100%;
            }

            .uniquely-yours-container {
                max-width: 80rem;
                margin: 0 auto;
                padding: 0 3.4375rem;
                box-sizing: border-box;
                width: 100%;
            }

            .uy-heading {
                font-family: 'Open Sans', sans-serif;
                font-size: 2rem;
                font-weight: 700;
                color: #000;
                margin-bottom: 0.625rem;
                display: block;
            }

            .uy-desc {
                text-align: center;
                font-family: 'DM Sans', sans-serif;

                color: #000;
                max-width: 37.5rem;
                margin: 0 auto 2.5rem auto;
                line-height: 1.5;
            }

            .uy-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                grid-auto-rows: 14.4375rem;
                gap: 1.125rem;
                width: 100%;
                max-width: 100%;
                margin: 0;
            }

            .uy-card {
                position: relative;
                border-radius: 0.5rem;
                overflow: hidden;
                background: #333;
            }

            .uy-card img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.4s ease;
            }

            .uy-card:hover img {
                transform: scale(1.05);
            }

            .uy-label {
                position: absolute;
                bottom: 1.25rem;
                left: 1.25rem;
                color: #fff;
                font-family: 'Open Sans', sans-serif;
                font-weight: 700;
                font-size: 1rem;
                text-shadow: 0 1px 0.25rem rgba(0, 0, 0, 0.6);
                z-index: 2;
                margin: 0;
            }

            /* Gradient overlay for text readability */
            .uy-card::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 50%;
                background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 100%);
                pointer-events: none;
                z-index: 1;
            }

            .uy-gloss {
                grid-column: span 2;
            }

            .uy-embossing {
                grid-column: span 2;
            }

            .uy-debossing {
                grid-column: span 2;
            }

            .uy-matte {
                grid-column: span 1;
                grid-row: span 2;
            }

            .uy-holo {
                grid-column: span 1;
            }

            .uy-silver {
                grid-column: span 1;
            }

            .uy-spot {
                grid-column: span 1;
            }

            .uy-gold {
                grid-column: span 1;
            }

            @media (max-width: 61.9375rem) {
                .uy-grid {
                    grid-template-columns: repeat(2, 1fr);
                }

                .uy-gloss,
                .uy-embossing,
                .uy-debossing {
                    grid-column: span 2;
                }

                .uy-matte {
                    grid-row: span 1;
                }
            }

            @media (max-width: 48rem) {
                .uniquely-yours-section {
                    display: none !important;
                }
            }
        </style>

        <section class="uniquely-yours-section">
            <div class="uniquely-yours-container">
                <span class="uy-heading">Finishing Touches That Make Customers Take Notice</span>
                <p class="uy-desc">We have refined finishes that give your packaging a polished and distinctive look.</p>

                <div class="uy-grid">
                    <div class="uy-card uy-gloss">
                        <img src="{{ asset('uploads/gloss-home.webp') }}" alt="Gloss Lamination"
                            onerror="this.src='https://placehold.co/610x231/111/fff?text=Gloss+Lamination'">
                        <span class="uy-label">Gloss Lamination</span>
                    </div>
                    <div class="uy-card uy-embossing">
                        <img src="{{ asset('uploads/embossing-home.png') }}" alt="Embossing"
                            onerror="this.src='https://placehold.co/610x231/f0f0f0/333?text=Embossing'">
                        <span class="uy-label">Embossing</span>
                    </div>
                    <div class="uy-card uy-debossing">
                        <img src="{{ asset('uploads/debossing-home-img.webp') }}" alt="Debossing"
                            onerror="this.src='https://placehold.co/610x231/333/fff?text=Debossing'">
                        <span class="uy-label">Debossing</span>
                    </div>
                    <div class="uy-card uy-matte">
                        <img src="{{ asset('uploads/matte-lamination.webp') }}" alt="Matte Lamination"
                            onerror="this.src='https://placehold.co/293x481/222/fff?text=Matte+Lamination'">
                        <span class="uy-label">Matte Lamination</span>
                    </div>
                    <div class="uy-card uy-holo">
                        <img src="{{ asset('uploads/holographic-homepage.webp') }}?v={{ @filemtime(public_path('uploads/holographic-foiling.webp')) ?: time() }}"
                            alt="Holographic Foiling">
                        <span class="uy-label">Holographic Foiling</span>
                    </div>
                    <div class="uy-card uy-silver">
                        <img src="{{ asset('uploads/silver-foiling-home.jpg') }}" alt="Silver Foiling"
                            onerror="this.src='https://placehold.co/293x231/444/fff?text=Silver+Foiling'">
                        <span class="uy-label">Silver Foiling</span>
                    </div>
                    <div class="uy-card uy-spot">
                        <img src="{{ asset('uploads/spot-uv-home.png') }}" alt="Spot UV"
                            onerror="this.src='https://placehold.co/293x231/111/fff?text=Spot+UV'">
                        <span class="uy-label">Spot UV</span>
                    </div>
                    <div class="uy-card uy-gold">
                        <img src="{{ asset('uploads/gold-foiling-home.png') }}?v={{ @filemtime(public_path('uploads/gold-foiling.webp')) ?: time() }}"
                            alt="Gold Foiling">
                        <span class="uy-label">Gold Foiling</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════
             WHY CHOOSE GO CUSTOM BOXES SECTION
        ═══════════════════════════════════════ -->
        <style>
            .why-choose-section-custom {
                padding: 1.25rem 0 2.5rem 0;
                background: #fff;
                width: 100%;
            }

            .why-choose-inner {
                max-width: 80rem;
                margin: 0 auto;
                padding: 0 3.4375rem;
                box-sizing: border-box;
                width: 100%;
                display: flex;
                justify-content: space-between;
                gap: 2.5rem;
                align-items: stretch;
            }

            .wcc-left {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                flex: 0 0 29.25rem;
                max-width: 29.25rem;
            }

            .wcc-title {
                display: block;
                font-family: 'Open Sans', sans-serif;
                font-size: 1.75rem !important;
                font-weight: 700;
                color: #000;
                margin-bottom: 0.9375rem;
                line-height: 1.2;
            }

            .wcc-desc {
                text-align: justify;
                font-family: 'DM Sans', sans-serif;
                font-size: 0.875rem;
                color: #000;
                margin-bottom: 1.5625rem;
                line-height: 1.5;
            }

            .wcc-collage {
                display: grid;
                grid-template-columns: 14.25rem 14.25rem;
                gap: 0.75rem;
                width: 29.25rem;
                height: 22.0625rem;
                margin-top: auto;
            }

            .wcc-col {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .wcc-img {
                width: 100%;
                border-radius: 0.5rem;
                object-fit: cover;
                display: block;
            }

            .wcc-right {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                grid-template-rows: repeat(2, 1fr);
                gap: 1.25rem;
                flex: 1;
            }

            .wcc-feature-card {
                background: #FBF6E9;
                border-radius: 0.5rem;
                padding: 1.75rem;
                display: flex;
                flex-direction: column;
                width: 100%;
                height: 100%;
                min-height: 15.0625rem;
                box-sizing: border-box;
            }

            .wcc-icon-wrap {
                width: 3.125rem;
                height: 3.125rem;
                background: #fff;
                border-radius: 0.4688rem;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 0.9375rem;
                box-shadow: 0 0.125rem 0.3125rem rgba(0, 0, 0, 0.05);
            }

            .wcc-icon-wrap img {
                width: 1.875rem;
                height: 1.875rem;
                object-fit: contain;
            }

            .wcc-feature-title {
                font-family: 'Open Sans', sans-serif;
                font-size: 1rem;
                font-weight: 700;
                color: #000;
                margin-bottom: 0.625rem;
            }

            .wcc-feature-desc {
                text-align: justify;
                font-family: 'DM Sans', sans-serif;
                font-size: 0.8125rem;
                color: #000;
                line-height: 1.5;
                margin: 0;
            }

            @media (max-width: 61.9375rem) {
                .why-choose-section-custom {
                    padding: 2.5rem 0;
                }

                .why-choose-inner {
                    flex-direction: column;
                    align-items: center;
                    gap: 1.25rem;
                }

                .wcc-left {
                    max-width: 100%;
                    width: 100%;
                    flex: none !important;
                }

                .wcc-title {
                    text-align: center;
                }

                .wcc-desc {
                    text-align: center;
                    color: #000;
                    margin-bottom: 0 !important;
                }

                .wcc-collage {
                    width: 100%;
                    max-width: 29.25rem;
                    margin: 0 auto;
                }

                .wcc-right {
                    max-width: 100%;
                    width: 100%;
                    flex: none !important;
                }

                .wcc-feature-card {
                    align-items: center;
                    text-align: center;
                }

                .wcc-feature-title {
                    text-align: center;
                }

                .wcc-feature-desc {
                    text-align: center;
                }
            }

            @media (max-width: 48rem) {
                .why-choose-inner {
                    padding: 0 1.25rem;
                }

                .wcc-feature-card {
                    align-items: center;
                    text-align: center;
                }

                .wcc-feature-title {
                    text-align: center;
                }

                .wcc-feature-desc {
                    text-align: center;
                }
            }

            @media (max-width: 42.5rem) {
                .why-choose-section-custom {
                    padding: 0.3125rem 0 0.5rem 0;
                }

                .why-choose-inner {
                    gap: 0.9375rem !important;
                }

                .wcc-left {
                    flex: none !important;
                    margin-bottom: 0 !important;
                }

                .wcc-title {
                    text-align: center;
                    font-size: 1.5rem;
                    margin-bottom: 0.375rem;
                }

                .wcc-desc {
                    text-align: center;
                    color: #000;
                    margin-bottom: 0 !important;
                }

                .wcc-right {
                    grid-template-columns: 1fr;
                    width: 100%;
                    flex: none !important;
                }

                .wcc-feature-card {
                    width: 100%;
                    height: auto;
                    min-height: auto;
                    align-items: center;
                    text-align: center;
                    padding: 1.5rem 1.25rem;
                    border: 1px solid rgba(0, 0, 0, 0.05);
                }

                .wcc-feature-title {
                    text-align: center;
                }

                .wcc-feature-desc {
                    text-align: center;
                }

                .wcc-collage {
                    display: none !important;
                }
            }

            @media (max-width: 30rem) {
                .why-choose-inner {
                    padding: 0 1rem;
                }

                .wcc-title {
                    font-size: 1.25rem;
                    margin-bottom: 0.25rem;
                }

                .wcc-feature-card {
                    align-items: center;
                    text-align: center;
                }

                .wcc-feature-title {
                    text-align: center;
                }

                .wcc-feature-desc {
                    text-align: center;
                }
            }

            /* How It Works is hidden on mobile home (≤48rem), so the testimonials
               section's own top padding provides the gap — avoid doubling it here. */
            @media (max-width: 48rem) {
                .why-choose-section-custom {
                    padding-bottom: 0;
                }
            }
        </style>

        <section class="why-choose-section-custom">
            <div class="why-choose-inner">

                <!-- LEFT CONTENT & COLLAGE -->
                <div class="wcc-left">
                    <span class="wcc-title">The GoCustomBoxes Advantage
</span>
                    <p class="wcc-desc">GoCustomBoxes is the top packaging manufacturer in the USA. With 15 years of experience, we create impactful packaging that is detail-oriented and function-focused.  Join us if you want to get:<p>

                    <div class="wcc-collage">
                        <div class="wcc-col">
                            <img src="{{ asset('uploads/custom-maroon-heart-chocolate-box.webp') }}"
                                alt="Custom maroon heart chocolate box" class="wcc-img" style="height: 13.0625rem;">
                            <img src="{{ asset('uploads/custom-navy-blue-rigid-gift-box.webp') }}"
                                alt="Custom navy blue rigid gift box" class="wcc-img" style="height: 8.25rem;">
                        </div>
                        <div class="wcc-col">
                            <img src="{{ asset('uploads/custom-green-gable-packaging-box.webp') }}"
                                alt="Custom green gable packaging box" class="wcc-img" style="height: 8.25rem;">
                            <img src="{{ asset('uploads/custom-cream-square-luxury-box.webp') }}"
                                alt="Custom cream square luxury box" class="wcc-img" style="height: 13.0625rem;">
                        </div>
                    </div>
                </div>

                <!-- RIGHT FEATURES -->
                <div class="wcc-right">

                    <!-- Feature 1 -->
                    <div class="wcc-feature-card">
                        <div class="wcc-icon-wrap">
                            <img src="{{ asset('uploads/premium-quality.svg') }}" alt="Premium Quality">
                        </div>
                        <span class="wcc-feature-title">Built for Brand Impact
</span>
                        <p class="wcc-feature-desc">Let your customers have a long-lasting impression at first glance. We make the first interaction impactful with high-quality materials, luxurious finishes, and refined details.
        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="wcc-feature-card">
                        <div class="wcc-icon-wrap">
                            <img src="{{ asset('uploads/fast-flexible.svg') }}" alt="Fast & Flexible">
                        </div>
                        <span class="wcc-feature-title">Production Without Delays</span>
                        <p class="wcc-feature-desc">We have a reliable production process. As we receive approved samples, the process will be started without any further delays. Want to launch new products? No need to worry about timeline. We have a fast turnaround time.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="wcc-feature-card">
                        <div class="wcc-icon-wrap">
                            <img src="{{ asset('uploads/design-support.svg') }}" alt="Design & Support">
                        </div>
                        <span class="wcc-feature-title">Designs That Sell</span>
                        <p class="wcc-feature-desc">That’s where experience matters. We have professionals with polished skills. They turn ordinary designs into branded packaging.</p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="wcc-feature-card">
                        <div class="wcc-icon-wrap">
                            <img src="{{ asset('uploads/plant-care.svg') }}" alt="Clear & Sustainable">
                        </div>
                        <span class="wcc-feature-title">Quality at Every Stage
</span>
                        <p class="wcc-feature-desc">Customer satisfaction is our priority. We have a dedicated quality check team to supervise each box. We ensure every box has gone through a quality check before delivery.
<p>
                    </div>

                </div>
            </div>
        </section>

        @include('components.howitworks')
        @include('components.testimonials_faq')
        @include('components.customquote', ['quoteSource' => 'Homepage - Get Custom Quote'])
        @include('components.content')
        @include('components.faq_mobile')
        @include('components.blogs')
    </main>

    @include('components.footer')

    <script>
        function toggleMobileMenu() {
            document.getElementById('mobileSidebar').classList.toggle('active');
            document.getElementById('mobileOverlay').classList.toggle('active');
            document.body.style.overflow = document.getElementById('mobileSidebar').classList.contains('active') ?
                'hidden' : '';
        }

        /* ── Customize Every Detail — option switch + drag scroll ── */
        (function () {
            var cdoData = {
                foiling: [{
                    src: '{{ asset('uploads/ addon - gold - foil.webp') }}',
                    label: 'Gold Foil'
                    },
                {
                    src: '{{ asset('uploads/silver-Foiling.webp')
        }}',
        label: 'Silver Foil'
                    },
        {
            src: '{{ asset('uploads / addon - Holographic.webp') }}',
                label: 'Holographic Foil'
        }
                ],
        embossing: [{
            src: '{{ asset('uploads/ embossing.webp') }}',
            label: 'Embossing'
                    },
        {
            src: '{{ asset('uploads/ debossing.webp') }}',
            label: 'Debossing'
                    },
        {
            src: '{{ asset('uploads/ blind - emboss.webp') }}',
            label: 'Blind Emboss'
                    }
        ],
            laminations: [{
                src: '{{ asset('uploads/ gloss - lamination.webp') }}',
                label: 'Gloss Lamination'
                    },
            {
                src: '{{ asset('uploads/ matte - lamination.webp') }}',
                label: 'Matte Lamination'
                    },
            {
                src: '{{ asset('uploads/ soft - touch - lamination.webp') }}',
                label: 'Soft-Touch Lamination'
                    }
            ],
                magnetic: [{
                    src: '{{ asset('uploads/ magnetic - closure.webp') }}',
                    label: 'Magnetic Closure'
                    },
                {
                    src: '{{ asset('uploads/ luxury - magnetic.webp') }}',
                    label: 'Luxury Magnetic Box'
                    },
                {
                    src: '{{ asset('uploads/ presentation - magnetic.webp') }}',
                    label: 'Presentation Closure'
                    }
                ],
                    inserts: [{
                        src: '{{ asset('uploads/ foam - Insert.webp') }}',
                        label: 'Foam Insert'
                    },
                    {
                        src: '{{ asset('uploads/ paper - insert.webp') }}',
                        label: 'Paper Insert'
                    },
                    {
                        src: '{{ asset('uploads/ corrugated - insert.webp') }}',
                        label: 'Corrugated Insert'
                    }
                    ],
                        coating: [{
                            src: '{{ asset('uploads/ uv - coating.webp') }}',
                            label: 'UV Coating'
                    },
                        {
                            src: '{{ asset('uploads/ aqueous - coating.webp') }}',
                            label: 'Aqueous Coating'
                    },
                        {
                            src: '{{ asset('uploads/ protective - varnish.webp') }}',
                            label: 'Protective Varnish'
                    }
                        ]
            };

        // Preload all customization images in the background so tabs switch instantly
        window.addEventListener('load', function () {
            setTimeout(function () {
                for (var key in cdoData) {
                    if (cdoData.hasOwnProperty(key)) {
                        cdoData[key].forEach(function (item) {
                            var img = new Image();
                            img.src = item.src;
                        });
                    }
                }
            }, 500); // Start preloading half a second after page load
        });

        var bar = document.getElementById('cdoBar');

        window.switchCustomizeDetail = function (btn) {
            if (!btn || !bar) return;
            bar.querySelectorAll('.cdo-btn').forEach(function (b) {
                b.classList.remove('active');
            });
            btn.classList.add('active');

            /* Smooth scroll selected option into the center of the scrollbar */
            try {
                btn.scrollIntoView({
                    behavior: 'smooth',
                    inline: 'center',
                    block: 'nearest'
                });
            } catch (err) {
                // Fallback for older browsers
                btn.scrollIntoView(false);
            }

            var data = cdoData[btn.dataset.cdo] || cdoData.foiling;
            data.forEach(function (item, i) {
                var img = document.getElementById('cdo-img-' + (i + 1));
                var lbl = document.getElementById('cdo-label-' + (i + 1));
                if (img) {
                    img.src = item.src;
                    img.alt = item.label;
                }
                if (lbl) {
                    lbl.textContent = item.label;
                }
            });
        };

        /* drag-to-scroll on options bar */
        var isDown = false,
            startX, scrollLeft;
        bar.addEventListener('pointerdown', function (e) {
            if (e.target.closest('.cdo-btn')) return;
            isDown = true;
            bar.classList.add('grabbing');
            startX = e.pageX - bar.offsetLeft;
            scrollLeft = bar.scrollLeft;
            bar.setPointerCapture(e.pointerId);
        });

        /* Buttons must remain normal clickable controls even though the
           surrounding pill supports drag-to-scroll. */
        bar.querySelectorAll('.cdo-btn').forEach(function (btn) {
            btn.addEventListener('pointerdown', function (e) {
                e.stopPropagation();
            });
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                window.switchCustomizeDetail(btn);
            });
        });
        bar.addEventListener('pointermove', function (e) {
            if (!isDown) return;
            var x = e.pageX - bar.offsetLeft;
            bar.scrollLeft = scrollLeft - (x - startX);
        });
        ['pointerup', 'pointercancel'].forEach(function (ev) {
            bar.addEventListener(ev, function () {
                isDown = false;
                bar.classList.remove('grabbing');
            });
        });
        }());
    </script>

    <script>
        (function () {
            var cardsContainer = document.querySelector('.bestseller-cards');
            var dotsContainer = document.getElementById('bestsellerDots');
            if (!cardsContainer || !dotsContainer) return;

            var cards = cardsContainer.querySelectorAll('.bestseller-card');
            if (cards.length === 0) return;

            var currentIndex = 0;
            var autoPlayInterval;
            var dots = [];

            function renderDots() {
                var isMobile = window.innerWidth <= 768;
                var scrollMultiplier = isMobile ? 1 : 3;
                var numDots = Math.ceil(cards.length / scrollMultiplier);

                // Don't show dots if only 1 page
                if (numDots <= 1) {
                    dotsContainer.innerHTML = '';
                    dots = [];
                    return;
                }

                dotsContainer.innerHTML = '';
                dots = [];
                for (var i = 0; i < numDots; i++) {
                    var btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = (i === currentIndex) ? 'bestseller-dot active' : 'bestseller-dot';
                    btn.setAttribute('role', 'tab');
                    btn.setAttribute('aria-selected', (i === currentIndex) ? 'true' : 'false');
                    btn.setAttribute('aria-label', 'Best seller tab ' + (i + 1));
                    dotsContainer.appendChild(btn);
                    dots.push(btn);

                    (function (index) {
                        btn.addEventListener('click', function () {
                            currentIndex = index;
                            goToDot(index);
                            resetAutoPlay();
                        });
                    })(i);
                }
            }

            function goToDot(index) {
                if (dots.length === 0) return;
                dots.forEach(function (item) {
                    item.classList.remove('active');
                    item.setAttribute('aria-selected', 'false');
                });
                if (dots[index]) {
                    dots[index].classList.add('active');
                    dots[index].setAttribute('aria-selected', 'true');
                }

                var firstCard = cards[0];
                var cardWidth = firstCard ? firstCard.offsetWidth : 275;
                var isMobile = window.innerWidth <= 768;
                var scrollMultiplier = isMobile ? 1 : 3;
                cardsContainer.scrollTo({
                    left: index * (cardWidth + 20) * scrollMultiplier,
                    behavior: 'smooth'
                });
            }

            function nextSlide() {
                if (dots.length <= 1) return;
                currentIndex++;
                if (currentIndex >= dots.length) {
                    currentIndex = 0;
                }
                goToDot(currentIndex);
            }

            function resetAutoPlay() {
                clearInterval(autoPlayInterval);
                if (dots.length > 1) {
                    autoPlayInterval = setInterval(nextSlide, 3500); // Auto-play every 3.5 seconds
                }
            }

            // Initial render
            renderDots();
            resetAutoPlay();

            // Re-render on resize
            window.addEventListener('resize', function () {
                var oldDotsCount = dots.length;
                renderDots();
                if (dots.length !== oldDotsCount) {
                    currentIndex = 0;
                    goToDot(0);
                    resetAutoPlay();
                }
            });
        })();
    </script>

</body>

</html>