<style>
    :root {
        --site-container-width: 80rem;
        --site-container-gutter: 3.4375rem;
        --primary-color: #0B2240;
        --secondary-color: #FFB400;
        --background-color: #FFFFFF;
        --footer-color: #0B2240;
        --header-bg: #FFFFFF;
        --topbar-bg: #0B2545;
        --section-text-color: #000000;
        --section-background: #FFFBF0;
        --heading-h1-size: 32px;
        --heading-h2-size: 24px;
        --heading-h3-size: 20px;
        --heading-h4-size: 18px;
        --heading-h5-size: 1.125rem;
        --heading-h6-size: 1rem;
    }

    body h1 {
        font-size: var(--heading-h1-size) !important;
    }

    body h2 {
        font-size: var(--heading-h2-size) !important;
    }

    body h3 {
        font-size: var(--heading-h3-size) !important;
    }

    body h4 {
        font-size: var(--heading-h4-size) !important;
    }

    body h5 {
        font-size: var(--heading-h5-size) !important;
    }

    body h6 {
        font-size: var(--heading-h6-size) !important;
    }

    /* Global breadcrumb uniform styling */
    [class*="breadcrumb"], 
    [class*="breadcrumb"] a, 
    [class*="breadcrumb"] span, 
    [class*="breadcrumb"] strong, 
    [class*="breadcrumb"] b {
        font-weight: 600 !important;
        font-size: 0.8125rem !important;
    }

    /* Global mobile heading sizes — desktop values are too large on phones */
    @media (max-width: 48rem) {
        :root {
            --heading-h1-size: 28px;
            --heading-h2-size: 24px;
            --heading-h3-size: 20px;
            --heading-h4-size: 1.125rem;
            --heading-h5-size: 1rem;
            --heading-h6-size: 0.9375rem;
        }
    }

    @media (max-width: 30rem) {
        :root {
            --heading-h1-size: 26px;
            --heading-h2-size: 22px;
            --heading-h3-size: 19px;
        }
    }

    /* Global mobile paragraph size — overrides section-specific p sizes on phones */
    @media (max-width: 48rem) {
        p {
            font-size: 16px !important;
        }
    }

    .header-container {
        width: 100% !important;
        max-width: var(--site-container-width) !important;
        padding-left: 3.4375rem !important;
        padding-right: 3.4375rem !important;
        margin-left: auto !important;
        margin-right: auto !important;
        box-sizing: border-box !important;
        min-width: 0;
    }

    @media (max-width: 48rem) {
        .header-container {
            padding-left: 1.25rem !important;
            padding-right: 1.25rem !important;
        }
    }

    @media (max-width: 30rem) {
        .header-container {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
    }

    .site-header {
        background: var(--header-bg);
        width: 100%;
        border-bottom: 0.0125rem solid rgba(0, 0, 0, 0.1);
        color: var(--primary-color);
        font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        position: sticky;
        top: 0;
        z-index: 1000;
        /* Isolate header from page CSS resets */
        line-height: normal;
        font-size: initial;
    }

    .site-header * {
        box-sizing: border-box;
    }

    .header-top {
        display: flex;
        align-items: center;
        width: 100%;
        min-height: 5.5rem;
    }

    .header-logo {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #fff;
        flex: 0 0 12.8125rem;
        width: 12.8125rem;
        outline: none;
    }
    
    .header-logo:focus, .header-logo:active {
        outline: none;
        box-shadow: none;
    }

    .header-logo-img {
        width: 12.8125rem !important;
        height: 4.375rem !important;
        display: block;
        flex-shrink: 0;
    }

    /* Align the desktop logo artwork with the page's left content guide. */
    @media (min-width: 61.9376rem) {
        .header-main .header-logo {
            transform: translateX(-0.5rem);
        }
    }

    .header-search {
        width: clamp(15rem, 20vw, 20.625rem);
        max-width: 100%;
        position: relative;
        margin: 0 0 0 clamp(1.25rem, 2.5vw, 2.8125rem) !important;
        flex: 0 1 20.625rem;
    }

    .header-search input {
        width: 100%;
        height: 2.75rem;
        background: transparent;
        border: 0.0375rem solid rgba(255, 255, 255, 0.6);
        border-radius: 0.4375rem;
        padding: 0 2.1875rem 0 3rem;
        color: #fff;
        outline: none;
        transition: border-color 0.3s;
        font-family: inherit;
        font-size: 0.9375rem;
        margin: 0 !important;
    }

    .header-search input:focus {
        border-color: #fff;
    }

    .header-search input::placeholder {
        color: rgba(255, 255, 255, 0.8);
    }

    /* Fix for browser autofill white background */
    .header-search input:-webkit-autofill,
    .header-search input:-webkit-autofill:hover, 
    .header-search input:-webkit-autofill:focus, 
    .header-search input:-webkit-autofill:active {
        transition: background-color 5000s ease-in-out 0s;
        -webkit-text-fill-color: #fff !important;
        caret-color: #fff !important;
    }

    .header-search .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        width: 1.375rem;
        height: 1.375rem;
        fill: rgba(255, 255, 255, 0.8);
    }

    .header-search .clear-icon {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        width: 1.125rem;
        height: 1.125rem;
        fill: rgba(255, 255, 255, 0.6);
        cursor: pointer;
        transition: fill 0.2s;
    }

    .header-search .clear-icon:hover {
        fill: rgba(255, 255, 255, 1);
    }

    .header-contact {
        display: flex;
        align-items: center;
        gap: clamp(0.75rem, 1.5vw, 1.5rem);
        margin: 0 0 0 auto !important;
        flex: 0 0 auto;
        flex-shrink: 0;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        margin: 0 !important;
        padding: 0 !important;
        flex-shrink: 0;
        white-space: nowrap;
    }

    .contact-item-phone,
    .contact-item-email {
        min-width: 0;
    }

    .site-header .contact-item svg {
        width: 2.125rem;
        height: 2.125rem;
        flex-shrink: 0;
        fill: none;
        stroke: var(--primary-color);
        stroke-width: 1.5;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .contact-item-text {
        white-space: nowrap;
        font-variant-numeric: tabular-nums;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .contact-item-text span {
        display: block;
        font-size: 0.875rem;
        color: #fff;
        font-weight: 700;
        white-space: nowrap;
        line-height: 1.2;
    }

    .contact-item-text strong {
        display: block;
        font-size: 1rem;
        line-height: 1.35;
        font-weight: 400;
        margin-top: 1px;
        letter-spacing: 0;
        white-space: nowrap;
        font-variant-numeric: tabular-nums;
    }

    .get-quote-btn {
        background-color: #fff;
        color: var(--primary-color);
        width: auto;
        min-height: 2.75rem;
        padding: 0 clamp(0.75rem, 1.2vw, 1.25rem);
        border-radius: 0.375rem;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9375rem;
        transition: background-color 0.3s, color 0.3s;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0.1875rem 0.3125rem rgba(55, 21, 22, .25);
        flex-shrink: 0;
        white-space: nowrap;
    }

    .get-quote-btn:hover {
        background-color: var(--secondary-color);
    }

    .header-bottom {

        position: relative;
    }

    .header-nav {
        display: flex;
        justify-content: center;
        width: 100%;
        height: 100%;
        min-height: 3rem;
        list-style: none;
        gap: clamp(2.25rem, 4vw, 3.875rem);
        align-items: center;
        padding: 0;
        margin: 0;
    }

    @media (max-width: 48rem) {
        :root { --site-container-gutter: 1.25rem; }
    }

    @media (max-width: 30rem) {
        :root { --site-container-gutter: 1rem; }
    }

    .header-nav li {
        position: relative;
    }

    .header-nav li a,
    .header-nav li .mega-trigger {
        color: #fff;
        text-decoration: none;
        font-size: 1rem;
        font-weight: 700;
        font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        line-height: 1;
        letter-spacing: normal;
        text-transform: none;
        transition: opacity 0.3s;
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 0;
        margin: 0;
        white-space: nowrap;
    }

    .header-nav li .mega-trigger {
        background: transparent;
        border: 0;
        cursor: pointer;
        white-space: nowrap;
    }

    .header-nav li a:hover,
    .header-nav li .mega-trigger:hover {
        opacity: 0.85;
    }

    .header-nav li.has-mega > .mega-trigger::after {
        content: '';
        display: inline-block;
        width: 0.375rem;
        height: 0.375rem;
        margin: 0 0 0.125rem 0.4375rem;
        border-right: 0.0938rem solid #fff;
        border-bottom: 0.0938rem solid #fff;
        transform: rotate(45deg);
        transition: transform 0.2s ease;
    }

    .header-nav li.has-mega:hover > a::after,
    .header-nav li.has-mega.active > a::after {
        transform: rotate(225deg) translateY(-0.125rem);
    }

    /* Category Mega Menu */
    .mega-menu {
        position: absolute;
        z-index: 1200;
        top: 100%;
        left: 1rem;
        width: min(65rem, calc(100vw - 2rem));
        height: auto;
        padding: 1.75rem 2rem 1.25rem;
        background: #FAF5F2; /* Cream background matching screenshot */
        border: none;
        
        box-shadow: 0 0.75rem 2.25rem rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
        opacity: 0;
        visibility: hidden;
        transform: translateY(0.5rem);
        transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s ease;
    }

    .mega-menu.is-open {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .mega-menu-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1.125rem 1.75rem;
        margin-bottom: 1.5rem;
    }

    .mega-menu-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.25rem 0.25rem;
        border-radius: 0.375rem;
        text-decoration: none;
        color: #1A1A1A;
        font-family: 'DM Sans', 'Plus Jakarta Sans', sans-serif;
        font-size: 0.9375rem;
        font-weight: 600;
        line-height: 1.35;
        transition: color 0.15s ease, transform 0.15s ease, background 0.15s ease;
    }

    .mega-menu-item:hover {
        color: #0B2545;
        background: rgba(141, 68, 69, 0.06);
        transform: translateX(0.1875rem);
    }

    .mega-menu-icon {
        width: 1.5rem;
        height: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .mega-menu-icon svg {
        width: 1.375rem;
        height: 1.375rem;
        stroke: #0B2545;
        fill: none;
    }

    .mega-menu-icon img {
        width: 1.375rem;
        height: 1.375rem;
        display: block;
        object-fit: contain;
    }

    /* Footer / Bottom Banner */
    .mega-menu-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1.125rem;
        border-top: 1px solid rgba(0, 0, 0, 0.08);
    }

    .mega-menu-footer-left {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #1A1A1A;
        font-family: 'DM Sans', 'Plus Jakarta Sans', sans-serif;
        font-size: 0.9375rem;
        font-weight: 700;
    }

    .mega-menu-footer-icon {
        width: 1.5rem;
        height: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .mega-menu-footer-icon svg {
        width: 1.375rem;
        height: 1.375rem;
        stroke: #0B2545;
    }

    .mega-menu-cta {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5625rem 1.375rem;
        border-radius: 0.5rem;
        background: #8D4445;
        color: #ffffff !important;
        font-family: 'DM Sans', 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 0.875rem;
        text-decoration: none;
        box-shadow: 0 0.125rem 0.5rem rgba(141, 68, 69, 0.2);
        transition: background 0.2s ease, transform 0.2s ease;
    }

    .mega-menu-cta:hover {
        background: #753435;
        transform: translateY(-1px);
    }


    /* Modifiers for Popular products & Resources */
    .mega-menu.mega-menu--products {
        width: min(23rem, calc(100vw - 2rem));
        height: auto;
        padding: 1.375rem 1.75rem;
        background: #fff;
        border: 1px solid #e5e5e5;
        
    }
    .mega-menu--products .mega-menu-footer { display: none; }
    .mega-menu--products .mega-menu-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1.125rem 1.375rem;
        margin-bottom: 0;
    }
    .mega-menu--products .mega-menu-item { gap: 0.5625rem; }
    .mega-menu--products .mega-menu-icon,
    .mega-menu--products .mega-menu-icon img { width: 2.625rem; height: 2.625rem; }
    .mega-menu--products .mega-menu-icon img { border-radius: 0.1875rem; object-fit: cover; }

    .mega-menu.mega-menu--resources {
        width: 15.625rem;
        height: auto;
        padding: 1rem 1.25rem;
        /* Match the Industry mega menu palette. */
        background: #FAF5F2;
        border: none;
        border-radius: 0.5rem;
    }
    .mega-menu--resources .mega-menu-footer { display: none; }
    .mega-menu--resources .mega-menu-grid {
        grid-template-columns: 1fr;
        gap: 0.25rem;
        margin-bottom: 0;
    }
    .mega-menu--resources .mega-menu-icon {
        display: none;
    }
    .mega-menu--resources .mega-menu-item {
        padding: 0.5rem 0.75rem;
        font-size: 1rem;
        color: #1A1A1A;
        font-weight: 500;
        gap: 0;
    }
    .mega-menu--resources .mega-menu-item:hover {
        background: rgba(141, 68, 69, 0.06);
        color: #0B2545;
    }

    /* Material menu uses the same clean style as the other dropdowns. */
    .mega-menu.mega-menu--material {
        border-top: none !important;
    }

    .custom-boxes-menu {
        position: relative;
        align-self: stretch;
        display: flex;
        align-items: center;
    }
    .custom-boxes-dropdown {
        position: absolute;
        top: 100%;
        left: -6.875rem; /* Offset to center it a bit better since it's wider now */
        z-index: 1300;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        column-gap: 0.875rem;
        row-gap: 1.125rem;
        width: min(31.25rem, calc(100vw - 0.5rem));
        padding: 1.375rem;
        box-sizing: border-box;
        background: #fff;
        border: 1px solid #1f1f1f;
        border-radius: 0.1875rem;
        box-shadow: 0 0.625rem 1.5rem rgba(0, 0, 0, 0.12);
        opacity: 0;
        visibility: hidden;
        transform: translateY(0.5rem);
        transition: opacity .18s ease, transform .18s ease, visibility .18s ease;
    }
    .custom-boxes-menu:hover .custom-boxes-dropdown,
    .custom-boxes-menu:focus-within .custom-boxes-dropdown { opacity: 1; visibility: visible; transform: translateY(0); }
    .header-nav .custom-boxes-dropdown a {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        min-width: 0;
        padding: 0;
        margin: 0;
        color: #111 !important;
        font-size: 0.75rem;
        font-weight: 400;
        line-height: 1.3;
        text-decoration: none;
        opacity: 1;
    }
    .header-nav .custom-boxes-dropdown a span {
        display: block;
        min-width: 0;
        color: #111 !important;
        font-size: 0.75rem;
        font-weight: 400;
        line-height: 1.3;
        white-space: normal;
        overflow-wrap: anywhere;
        opacity: 1 !important;
        visibility: visible !important;
    }
    .custom-boxes-dropdown img { width:3rem; height:3rem; flex:0 0 3rem; object-fit:cover; border-radius:0.3125rem; background:#eee; }

    .mega-menu-footer-left {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #000000;
        font-size: 0.9375rem;
        font-weight: 700;
    }

    .mega-menu-footer-icon {
        width: 1.625rem;
        height: 1.625rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--secondary-color);
    }

    .mega-menu-cta {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.625rem 1.5rem;
        border-radius: 0.375rem;
        background: var(--secondary-color);
        color: var(--primary-color) !important;
        font-weight: 700;
        font-size: 0.875rem;
        text-decoration: none;
        box-shadow: 0 0.25rem 0.625rem rgba(0, 0, 0, 0.1);
        transition: background 0.2s ease, transform 0.2s ease;
    }

    .mega-menu-cta:hover {
        background: #e6a600;
        transform: translateY(-1px);
    }

    /* Desktop only items & Scroll Behavior */
    @media (min-width: 68.8125rem) {
        .mobile-actions, .mobile-overlay, .mobile-sidebar {
            display: none !important;
        }
        .site-header {
            transition: top 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    }



    /* Mobile Styles */
    @media (max-width: 68.75rem) {
        .header-topbar {
            display: none !important;
        }

        .header-main {
            position: relative;
        }

        .header-nav, .get-quote-btn {
            display: none !important;
        }

        .header-logo {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            margin: 0 !important;
        }

        .header-right-actions {
            width: 100%;
            justify-content: space-between !important;
            margin-left: 0 !important;
            gap: 0 !important;
        }

        .search-trigger-btn, .mobile-menu-btn {
            width: 2.75rem;
            height: 2.75rem;
            background: #fff !important;
            border-radius: 0.75rem;
            display: flex !important;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0.25rem 0.9375rem rgba(0,0,0,0.05);
            border: 1px solid #f0f0f0 !important;
            padding: 0 !important;
            outline: none !important;
            -webkit-tap-highlight-color: transparent;
        }

        .search-trigger-btn svg, .mobile-menu-btn svg {
            width: 1.25rem !important;
            height: 1.25rem !important;
            stroke: var(--primary-color);
        }
        
        .mobile-menu-btn svg rect {
            fill: var(--primary-color);
            stroke: none;
        }

        #desktopSearchForm {
            width: calc(100% - 2rem) !important;
            left: 1rem !important;
            right: 1rem !important;
            top: 100% !important;
            margin-top: 0.9375rem !important;
            box-sizing: border-box;
        }

        .mobile-search-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.3125rem;
            margin-right: 0.625rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mobile-search-btn svg {
            width: 1.5rem;
            height: 1.5rem;
            fill: #fff;
        }

        .mobile-menu-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.3125rem;
        }

        .mobile-menu-btn svg { width: 1rem; height: 0.75rem; stroke: none; }

        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0,0,0,0.5);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .mobile-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .mobile-sidebar {
            position: fixed;
            top: 0;
            left: -80vw;
            width: 80vw;
            height: 100vh;
            background: var(--primary-color);
            z-index: 999;
            transition: left 0.3s ease;
            box-shadow: -0.125rem 0 0.625rem rgba(0,0,0,0.1);
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .mobile-sidebar.active {
            left: 0;
        }

        .mobile-sidebar-header {
            padding: 1.125rem 1.25rem;
            background: var(--primary-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            box-sizing: border-box;
        }

        .close-menu-btn {
            background: none;
            border: none;
            color: #fff;
            cursor: pointer;
            padding: 0.3125rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .mobile-sidebar-header .header-logo {
            margin-left: auto !important;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .mobile-sidebar-header .header-logo img {
            height: 3.75rem !important;
            max-height: 3.75rem !important;
            width: auto !important;
            max-width: 100% !important;
            object-fit: contain;
        }

        .close-menu-btn svg {
            width: 1.75rem;
            height: 1.75rem;
            stroke: #fff;
            stroke-width: 2;
        }

        .mobile-sidebar-content {
            padding: 1.25rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .mobile-search {
            margin-bottom: 1.25rem;
            position: relative;
        }

        .mobile-search input {
            width: 100%;
            padding: 0.75rem 2.1875rem 0.75rem 2.5rem;
            border: 1px solid #ddd;
            border-radius: 0.25rem;
            outline: none;
            font-family: inherit;
        }

        .mobile-search .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            width: 1.125rem;
            height: 1.125rem;
            fill: #0B2545;
        }

        .mobile-search .clear-icon {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            width: 1.125rem;
            height: 1.125rem;
            fill: #0B2545;
            cursor: pointer;
        }

        .mobile-nav {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .mobile-nav-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.18) !important;
            width: 100%;
        }

        .mobile-nav-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.875rem 0;
            cursor: pointer;
            width: 100%;
        }

        .mobile-nav-link-top,
        .mobile-nav > li > a {
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 600;
            font-family: 'DM Sans', 'Open Sans', sans-serif;
            display: flex;
            align-items: center;
            flex: 1;
            padding: 0;
        }

        .mobile-nav-header .mobile-nav-link-top {
            padding: 0.875rem 0;
            margin: -0.875rem 0;
            align-self: stretch;
        }

        .mobile-dropdown-toggle {
            background: none;
            border: none;
            padding: 0.875rem 0.5rem;
            margin: -0.875rem 0;
            min-width: 2.75rem;
            cursor: pointer;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            align-self: stretch;
        }

        .mobile-dropdown-toggle .chevron-icon {
            width: 1rem;
            height: 1rem;
            stroke: #fff;
            stroke-width: 2.2;
            transition: transform 0.3s ease;
            display: block;
        }

        .mobile-nav-item.has-dropdown.open .chevron-icon {
            transform: rotate(180deg);
        }

        .mobile-submenu {
            display: none;
            list-style: none;
            padding: 0.375rem 0 0.875rem 1rem;
            margin: 0;
            flex-direction: column;
            gap: 0.5rem;
        }

        .mobile-nav-item.has-dropdown.open .mobile-submenu {
            display: flex;
        }

        .mobile-submenu li {
            width: 100%;
        }

        .mobile-submenu li a {
            color: #e0e0e0;
            text-decoration: none;
            font-size: 0.9375rem;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            display: block;
            padding: 0.375rem 0;
            border: none;
            transition: color 0.2s ease;
        }

        .mobile-submenu li a:hover {
            color: var(--secondary-color);
        }

        .mobile-contact {
            margin-top: 1.875rem;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            margin-bottom: 1.875rem;
        }

        .site-header .mobile-contact .contact-item svg {
            stroke: var(--primary-color);
        }

        .mobile-contact .contact-item-text span {
            color: #666;
        }

        .mobile-contact .contact-item-text strong {
            color: var(--primary-color);
        }
    }

    @media (max-width: 36rem) {
        .header-logo-img {
            height: 3.75rem;
        }
        .mobile-search-btn {
            margin-right: 0.3125rem;
        }
    }

    .visually-hidden {
        position: absolute !important;
        width: 1px !important;
        height: 1px !important;
        padding: 0 !important;
        margin: -1px !important;
        overflow: hidden !important;
        clip: rect(0, 0, 0, 0) !important;
        white-space: nowrap !important;
        border: 0 !important;
    }
</style>

<header class="site-header">
    <div class="header-topbar" style="background-color: var(--topbar-bg); color: #fff; padding: 0.75rem 0; font-size: 0.875rem;">
        <div class="header-container" style="display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; gap: 1.875rem;">
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['company_phone'] ?? '847-200-0971') }}" style="display: flex; align-items: center; gap: 0.5rem; color: inherit; text-decoration: none;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2a1.011 1.011 0 011.02-.24c1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                    <span>{{ $siteSettings['company_phone'] ?? '847-200-0971' }}</span>
                </a>
                <a href="mailto:{{ $siteSettings['company_email'] ?? 'support@gocustomboxes.com' }}" style="display: flex; align-items: center; gap: 0.5rem; color: inherit; text-decoration: none;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                    <span>{{ $siteSettings['company_email'] ?? 'support@gocustomboxes.com' }}</span>
                </a>
            </div>
            <div style="display: flex; align-items: center; gap: 0.9375rem;">
                <span>Follow Us:</span>
                <div style="display: flex; gap: 0.625rem;">
                    @if(!empty($siteSettings['social_facebook']))<a href="{{ $siteSettings['social_facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook" style="background: #fff; color: var(--topbar-bg); border-radius: 0.5rem; width: 1.875rem; height: 1.875rem; display: flex; align-items: center; justify-content: center;"><span class="visually-hidden">Facebook</span><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg></a>@endif
                    @if(!empty($siteSettings['social_instagram']))<a href="{{ $siteSettings['social_instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram" style="background: #fff; color: var(--topbar-bg); border-radius: 0.5rem; width: 1.875rem; height: 1.875rem; display: flex; align-items: center; justify-content: center;"><span class="visually-hidden">Instagram</span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>@endif
                    @if(!empty($siteSettings['social_linkedin']))<a href="{{ $siteSettings['social_linkedin'] }}" target="_blank" rel="noopener" aria-label="LinkedIn" style="background: #fff; color: var(--topbar-bg); border-radius: 0.5rem; width: 1.875rem; height: 1.875rem; display: flex; align-items: center; justify-content: center;"><span class="visually-hidden">LinkedIn</span><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg></a>@endif
                    @if(!empty($siteSettings['social_youtube']))<a href="{{ $siteSettings['social_youtube'] }}" target="_blank" rel="noopener" aria-label="YouTube" style="background: #fff; color: var(--topbar-bg); border-radius: 0.5rem; width: 1.875rem; height: 1.875rem; display: flex; align-items: center; justify-content: center;"><span class="visually-hidden">YouTube</span><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 00-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 00-1.94 2A29 29 0 001 11.75a29 29 0 00.46 5.33 2.78 2.78 0 001.94 2c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 001.94-2 29 29 0 00.46-5.33 29 29 0 00-.46-5.33zM9.75 15.02V8.48l6.19 3.27-6.19 3.27z"/></svg></a>@endif
                </div>
            </div>
        </div>
    </div>
    
    @php
        $navCatsAll = $navCategories ?? [];
        $navParents = array_values(array_filter($navCatsAll, fn($c) => empty($c['parent_id']) && ($c['slug'] ?? '') !== 'custom-boxes'));
        $navChildren = array_filter($navCatsAll, fn($c) => !empty($c['parent_id']));
        
        if (count($navParents) <= 1) {
            $navParents = [
                ['id' => 101, 'title' => 'Industries', 'slug' => 'box-by-industry'],
                ['id' => 102, 'title' => 'Box By Material', 'slug' => 'box-by-material'],
                ['id' => 103, 'title' => 'Box by Style', 'slug' => 'box-by-style'],
            ];
        }

        $navByParentSlug = [];
        foreach ($navParents as $parent) {
            $slug = $parent['slug'];
            $children = array_filter($navChildren, fn($c) => isset($c['parent_id']) && $c['parent_id'] == $parent['id']);
            $navByParentSlug[$slug] = array_values($children);
        }
        $navParentItems = $navParents;
        // Navbar labels come straight from each category's own title, so they can
        // be renamed from the admin panel (Edit category → Title).
        $customBoxProducts = \Illuminate\Support\Facades\DB::table('admin_products')
            ->select('title', 'slug', 'image', 'nav_image')
            ->where('status', 'published')
            ->where('show_as_custom_box', 1)
            ->orderBy('id')
            ->get();
    @endphp

    <div class="header-main header-container" style="display: flex; align-items: center; height: 5rem;">
        <a href="/" class="header-logo" style="flex-shrink: 0; display: flex; align-items: center; margin-right: 1.875rem;">
            <img src="{{ asset('uploads/header-logo.svg') }}" alt="The Rigid Boxes" class="header-logo-img" width="205" height="70" fetchpriority="high">
            <span class="visually-hidden">Go Custom Boxes home</span>
        </a>
        
        <ul class="header-nav" style="display: flex; align-items: center; justify-content: center; margin: 0; padding: 0; list-style: none; flex-grow: 1; gap: 1.75rem;">
            <li><a href="/" style="color: #000000; text-decoration: none; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.9375rem;">Home</a></li>
            <li class="has-mega" data-mega-type="custom-boxes">
                <a href="{{ url('/popular-products/') }}" class="mega-trigger" aria-haspopup="true" style="color: #000000; text-decoration: none; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.9375rem;">Hot Products</a>
            </li>
            @foreach($navParentItems as $navParent)
            <li class="has-mega" data-mega-type="{{ $navParent['slug'] }}">
                <button type="button" class="mega-trigger" aria-haspopup="true" style="color: #000000; text-decoration: none; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.9375rem;">{{ $navParent['title'] }}</button>
            </li>
            @endforeach
            <li class="has-mega" data-mega-type="resources">
                <button type="button" class="mega-trigger" aria-haspopup="true" style="color: #000000; text-decoration: none; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.9375rem;">Resources</button>
            </li>
        </ul>
        
        <div class="header-right-actions" style="display: flex; align-items: center; gap: 1.5rem; flex-shrink: 0; margin-left: 1.875rem;">
            <button class="search-trigger-btn" style="background: none; border: none; cursor: pointer; color: var(--primary-color); padding: 0; display: flex; align-items: center;" onclick="const sf = document.getElementById('desktopSearchForm'); sf.style.display = (sf.style.display === 'none' || sf.style.display === '') ? 'block' : 'none';">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </button>
            
            <a href="/request-quote/" class="get-quote-btn" style="background-color: var(--secondary-color); color: var(--primary-color); width: 9.0625rem; height: 3rem; padding: 0; border-radius: 0.25rem; text-decoration: none; font-weight: 700; font-size: 1rem; font-family: 'Plus Jakarta Sans', sans-serif; display: flex; align-items: center; justify-content: center; box-shadow: none; white-space: nowrap;">Get a Quote</a>
            
            <button class="mobile-menu-btn" onclick="toggleMobileMenu()" style="display: none; background: none; border: none; color: var(--primary-color);">
                <svg width="16" height="12" viewBox="0 0 16 12" fill="var(--primary-color)"><rect x="0" y="0" width="16" height="2"/><rect x="0" y="5" width="16" height="2"/><rect x="0" y="10" width="16" height="2"/></svg>
            </button>
        </div>
    </div>

    <div id="desktopSearchForm" style="display: none; position: absolute; right: 11.25rem; top: 100%; margin-top: 0.625rem; width: 20rem; background: #fff; border-radius: 3.125rem; box-shadow: 0 0.9375rem 2.1875rem rgba(0,0,0,0.1); padding: 0.375rem; z-index: 1001; border: 1px solid #eaeaea;">
        <form action="/search" method="GET" style="display: flex; width: 100%; position: relative; align-items: center;">
            <input type="text" name="q" placeholder="Search products..." style="flex: 1; height: 2.875rem; padding: 0 2.5rem 0 1.5rem; border: none; border-radius: 3.125rem; outline: none; font-family: inherit; font-size: 0.9375rem; color: #333;" autocomplete="off" oninput="this.nextElementSibling.style.display = this.value ? 'block' : 'none';">
            <svg class="clear-icon" viewBox="0 0 24 24" style="display: none; position: absolute; right: 3.5rem; width: 1.25rem; height: 1.25rem; cursor: pointer; fill: none; stroke: #0B2545; stroke-width: 2;" onclick="this.previousElementSibling.value=''; this.style.display='none'; this.previousElementSibling.focus();">
                <circle cx="12" cy="12" r="10"></circle>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9l-6 6M9 9l6 6"></path>
            </svg>
            <button type="submit" style="width: 2.875rem; height: 2.875rem; background-color: var(--secondary-color); color: var(--primary-color); border: none; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </button>
        </form>
    </div>

    <div class="header-bottom" style="display: none;">
    </div><!-- Mega Menu Panel -->
        <div class="mega-menu" id="megaMenu">
            <div class="mega-menu-grid" id="megaMenuGrid"></div>
            
            <div class="mega-menu-footer">
                <div class="mega-menu-footer-left">
                    <div class="mega-menu-footer-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
                            <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
                            <path d="M14 22h-4"></path>
                        </svg>
                    </div>
                    <span>Need a custom packaging solution?</span>
                </div>
                <a href="/contact-us/" class="mega-menu-cta">Talk to us</a>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar -->
    <div class="mobile-overlay" id="mobileOverlay" onclick="toggleMobileMenu()"></div>
    <div class="mobile-sidebar" id="mobileSidebar">
        <div class="mobile-sidebar-header" style="display: flex !important; justify-content: space-between !important; align-items: center !important; width: 100% !important; padding: 1.125rem 1.25rem !important; box-sizing: border-box !important;">
            <button class="close-menu-btn" onclick="toggleMobileMenu()" style="background: none !important; border: none !important; color: #fff !important; cursor: pointer !important; padding: 0.3125rem !important; display: flex !important; align-items: center !important; justify-content: center !important; flex-shrink: 0 !important;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" style="width: 1.625rem !important; height: 1.625rem !important; display: block !important;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <a href="/" class="header-logo" style="margin: 0 0 0 auto !important; display: flex !important; align-items: center !important; justify-content: flex-end !important; text-decoration: none !important; max-width: calc(100% - 3.125rem) !important;">
                <img src="{{ asset('uploads/hamberger-logo.svg') }}" alt="Go Custom Boxes" style="height: 3.75rem !important; max-height: 3.75rem !important; width: auto !important; max-width: 100% !important; object-fit: contain !important; display: block !important;">
                <span class="visually-hidden">Go Custom Boxes home</span>
            </a>
        </div>

        <div class="mobile-sidebar-content">
            <form action="/search" method="GET" class="mobile-search">
                <svg class="search-icon" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                </svg>
                <input type="text" name="q" placeholder="Search products..." oninput="this.nextElementSibling.style.display = this.value ? 'block' : 'none';">
                <svg class="clear-icon" viewBox="0 0 24 24" style="display: none; fill: none; stroke: #0B2545; stroke-width: 2;" onclick="this.previousElementSibling.value=''; this.style.display='none'; this.previousElementSibling.focus();">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9l-6 6M9 9l6 6"></path>
                </svg>
            </form>

            <ul class="mobile-nav">
                <li class="mobile-nav-item">
                    <div class="mobile-nav-header">
                        <a href="/" class="mobile-nav-link-top">Home</a>
                    </div>
                </li>
                <li class="mobile-nav-item has-dropdown">
                    <div class="mobile-nav-header">
                        <a href="{{ url('/popular-products/') }}" class="mobile-nav-link-top">Hot Products</a>
                        <button type="button" class="mobile-dropdown-toggle" aria-label="Toggle Hot product dropdown" onclick="this.closest('.mobile-nav-item').classList.toggle('open');">
                            <svg class="chevron-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                    </div>
                    @if(count($customBoxProducts) > 0)
                        <ul class="mobile-submenu">
                            @foreach($customBoxProducts as $product)
                                <li>
                                    <a href="{{ url('/' . $product->slug) }}/">{{ $product->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
                @foreach($navParents as $navParent)
                    @php
                        $children = $navByParentSlug[$navParent['slug']] ?? [];
                    @endphp
                    <li class="mobile-nav-item has-dropdown">
                        <div class="mobile-nav-header" onclick="this.parentElement.classList.toggle('open')">
                            <a href="#" class="mobile-nav-link-top" onclick="event.preventDefault(); event.stopPropagation(); this.parentElement.parentElement.classList.toggle('open');">{{ $navParent['title'] }}</a>
                            <button type="button" class="mobile-dropdown-toggle" aria-label="Toggle {{ $navParent['title'] }} dropdown">
                                <svg class="chevron-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </button>
                        </div>
                        @if(count($children) > 0)
                            <ul class="mobile-submenu">
                                @foreach($children as $child)
                                    <li>
                                        <a href="{{ url('/' . $child['slug']) }}/">{{ $child['title'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
                <li class="mobile-nav-item has-dropdown">
                    <div class="mobile-nav-header" onclick="this.parentElement.classList.toggle('open')">
                        <a href="#" class="mobile-nav-link-top" onclick="event.preventDefault(); event.stopPropagation(); this.parentElement.parentElement.classList.toggle('open');">Resources</a>
                        <button type="button" class="mobile-dropdown-toggle" aria-label="Toggle Resources dropdown">
                            <svg class="chevron-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                    </div>
                    @php
                        try {
                            $faqRow = DB::table('homepage_contents')->where('section', 'faq_page')->where('field_key', 'faq_page_slug')->first();
                            $faqSlug = $faqRow ? $faqRow->value : 'frequentlyAskedQuestions';
                        } catch (\Exception $e) {
                            $faqSlug = 'frequentlyAskedQuestions';
                        }
                        $faqSlug = strtolower(ltrim($faqSlug, '/'));
                    @endphp
                    <ul class="mobile-submenu">
                        <li><a href="/{{ $faqSlug }}/">FAQ's</a></li>
                        <li><a href="/blog/">Blog</a></li>
                        <li><a href="/about-us/">About Us</a></li>
                        <li><a href="/contact-us/">Contact Us</a></li>
                    </ul>
                </li>
            </ul>

            <a href="/request-quote/" class="mobile-get-quote-btn" style="display:flex; width: 100%; text-align: center; justify-content: center; margin: 1.875rem 0; background: #FFB800; color: #002147; padding: 0.75rem 1.25rem; border-radius: 0.25rem; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 1rem; text-decoration: none;">Get Instant Quote</a>

            <div class="mobile-contact" style="margin-top: 0; gap: 0; display: flex; flex-direction: column; align-items: flex-start;">
                <span style="font-family: 'DM Sans', sans-serif; font-size: 1.125rem; font-weight: 700; margin-bottom: 1.25rem; color: #fff; text-align: left;">Get In Touch</span>
                
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['company_phone'] ?? '1800-518-9441') }}" class="mobile-contact-item" style="display: flex; align-items: flex-start; justify-content: flex-start !important; gap: 0.9375rem; margin-bottom: 1.25rem; width: 100%; text-align: left; text-decoration: none;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 1.25rem; height: 1.25rem; stroke: var(--secondary-color); flex-shrink: 0; margin-top: 0.125rem;">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    <span style="font-family: 'DM Sans', sans-serif; font-size: 1rem; color: #fff; font-weight: 400; text-align: left;">{{ $siteSettings['company_phone'] ?? '1800-518-9441' }}</span>
                </a>

                <a href="mailto:{{ $siteSettings['company_email'] ?? 'example@gmail.com' }}" class="mobile-contact-item" style="display: flex; align-items: flex-start; justify-content: flex-start !important; gap: 0.9375rem; margin-bottom: 1.25rem; width: 100%; text-align: left; text-decoration: none;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 1.25rem; height: 1.25rem; stroke: var(--secondary-color); flex-shrink: 0; margin-top: 0.125rem;">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <span style="font-family: 'DM Sans', sans-serif; font-size: 1rem; color: #fff; font-weight: 400; text-align: left;">{{ $siteSettings['company_email'] ?? 'example@gmail.com' }}</span>
                </a>

                <div class="mobile-contact-item" style="display: flex; align-items: flex-start; justify-content: flex-start !important; gap: 0.9375rem; width: 100%; text-align: left;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 1.25rem; height: 1.25rem; stroke: var(--secondary-color); flex-shrink: 0; margin-top: 0.125rem;">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <span style="font-family: 'DM Sans', sans-serif; font-size: 1rem; color: #fff; font-weight: 400; text-align: left;">{!! strip_tags(str_replace('<br>', ' ', $siteSettings['company_address'] ?? '1880 S Dairy Ashford Rd Suite 207 Houston, TX 77077')) !!}</span>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    (function() {
        const giftBoxSvg = `<svg viewBox="0 0 24 24" fill="none" stroke="#0B2545" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="8" width="18" height="4" rx="1"></rect>
            <path d="M12 8v13"></path>
            <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"></path>
            <path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"></path>
        </svg>`;

        // Build megaData dynamically from DB categories
        @php
            $navCatsAll = $navCategories ?? [];
            $navParents = array_filter($navCatsAll, fn($c) => empty($c['parent_id']) && ($c['slug'] ?? '') !== 'custom-boxes');
            $navChildren = array_filter($navCatsAll, fn($c) => !empty($c['parent_id']));
            
            // Map: parent_slug => [children]
            $navByParentSlug = [];
            foreach ($navParents as $parent) {
                $slug = $parent['slug'];
                $children = array_filter($navChildren, fn($c) => $c['parent_id'] == $parent['id']);
                $navByParentSlug[$slug] = array_values($children);
            }
        @endphp

        const megaData = {
            @foreach($navParents as $parent)
            "{{ $parent['slug'] }}": [
                @foreach($navByParentSlug[$parent['slug']] ?? [] as $child)
                @php
                    $childIcon = !empty($child['icon'])
                        ? (\Illuminate\Support\Str::startsWith($child['icon'], ['storage/', 'uploads/', 'images/'])
                            ? asset($child['icon'])
                            : asset('storage/' . $child['icon']))
                        : '';
                @endphp
                { title: @json($child['title']), slug: @json($child['slug']), icon: @json($childIcon) },
                @endforeach
            ],
            @endforeach
            "custom-boxes": [
                @foreach($customBoxProducts as $product)
                @php
                    $productNavImage = $product->nav_image ?: $product->image;
                    $productImage = !empty($productNavImage)
                        ? (\Illuminate\Support\Str::startsWith($productNavImage, ['storage/', 'uploads/', 'images/'])
                            ? asset($productNavImage)
                            : asset('storage/' . $productNavImage))
                        : '';
                @endphp
                {
                    title: @json($product->title),
                    slug: @json($product->slug),
                    image: @json($productImage),
                    fallbackImage: @json(asset('uploads/gift-box.png'))
                },
                @endforeach
            ],
            "resources": [
                { title: "FAQ's", slug: "{{ $faqSlug }}" },
                { title: "Blog", slug: "blog" },
                { title: "About Us", slug: "about-us" },
                { title: "Contact Us", slug: "contact-us" }
            ],
        };

        // Map nav li data-mega-type to parent slug
        const navMapping = {
            @foreach($navParents as $parent)
            "{{ $parent['slug'] }}": "{{ $parent['slug'] }}",
            @endforeach
        };

        const megaMenu = document.getElementById('megaMenu');
        const megaMenuGrid = document.getElementById('megaMenuGrid');
        const hasMegaLis = document.querySelectorAll('.has-mega');
        let activeType = null;
        let hoverTimeout = null;

        function getCategoryIcon(title, slug) {
            const t = ((title || '') + ' ' + (slug || '')).toLowerCase();
            if (t.includes('apparel') || t.includes('shirt') || t.includes('cloth') || t.includes('garment')) {
                return `<svg viewBox="0 0 24 24" fill="none" stroke="#0B2545" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/></svg>`;
            }
            if (t.includes('bakery') || t.includes('cake') || t.includes('pastry') || t.includes('cookie') || t.includes('bread') || t.includes('donut')) {
                return `<svg viewBox="0 0 24 24" fill="none" stroke="#0B2545" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="10" width="18" height="11" rx="2"/><path d="M7 10V7a5 5 0 0 1 10 0v3"/><path d="M12 14v3"/><circle cx="12" cy="4" r="1"/></svg>`;
            }
            if (t.includes('cbd') || t.includes('tincture') || t.includes('vape') || t.includes('oil') || t.includes('dropper') || t.includes('serum')) {
                return `<svg viewBox="0 0 24 24" fill="none" stroke="#0B2545" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M10 2h4"/><path d="M12 2v4"/><path d="M7 8h10a1 1 0 0 1 1 1v11a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V9a1 1 0 0 1 1-1Z"/><path d="M10 14h4"/></svg>`;
            }
            if (t.includes('stationery') || t.includes('pen') || t.includes('pencil') || t.includes('card') || t.includes('paper') || t.includes('notebook')) {
                return `<svg viewBox="0 0 24 24" fill="none" stroke="#0B2545" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>`;
            }
            if (t.includes('roll') || t.includes('pre roll') || t.includes('cigar') || t.includes('cigarette')) {
                return `<svg viewBox="0 0 24 24" fill="none" stroke="#0B2545" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="6" width="18" height="12" rx="2"/><path d="M3 12h18"/><circle cx="7" cy="12" r="1"/><circle cx="17" cy="12" r="1"/></svg>`;
            }
            if (t.includes('cosmetic') || t.includes('beauty') || t.includes('makeup') || t.includes('cream') || t.includes('lotion') || t.includes('perfume') || t.includes('fragrance') || t.includes('skincare')) {
                return `<svg viewBox="0 0 24 24" fill="none" stroke="#0B2545" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 3h6v4H9z"/><rect x="7" y="7" width="10" height="14" rx="2"/><path d="M10 12h4"/><path d="M12 12v4"/></svg>`;
            }
            if (t.includes('jewelry') || t.includes('jewel') || t.includes('ring') || t.includes('diamond') || t.includes('watch') || t.includes('necklace')) {
                return `<svg viewBox="0 0 24 24" fill="none" stroke="#0B2545" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12l4 6-10 12L2 9Z"/><path d="M11 3 8 9l4 12 4-12-3-6"/><path d="M2 9h20"/></svg>`;
            }
            if (t.includes('chocolate') || t.includes('candy') || t.includes('sweet') || t.includes('snack')) {
                return `<svg viewBox="0 0 24 24" fill="none" stroke="#0B2545" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 10h18"/><path d="M3 16h18"/><path d="M9 4v16"/><path d="M15 4v16"/></svg>`;
            }
            if (t.includes('food') || t.includes('pizza') || t.includes('meal') || t.includes('burger') || t.includes('restaurant')) {
                return `<svg viewBox="0 0 24 24" fill="none" stroke="#0B2545" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>`;
            }
            if (t.includes('gift')) {
                return `<svg viewBox="0 0 24 24" fill="none" stroke="#0B2545" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="8" width="18" height="4" rx="1"/><path d="M12 8v13"/><path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"/><path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"/></svg>`;
            }
            return giftBoxSvg;
        }

        function renderMegaGrid(type) {
            const isProductMenu = type === 'custom-boxes';
            const isResourcesMenu = type === 'resources';
            const isMaterialMenu = type === 'box-by-material';
            // Popular products use the same full-width grid and positioning
            // as the Industry mega menu; only their image data is different.
            megaMenu.classList.remove('mega-menu--products');
            megaMenu.classList.toggle('mega-menu--resources', isResourcesMenu || isMaterialMenu);
            megaMenu.classList.toggle('mega-menu--material', isMaterialMenu);

            const items = megaData[type] || [];
            if (items.length === 0) {
                megaMenuGrid.innerHTML = '<p style="color:#999;padding:0.75rem;font-size:0.8125rem;grid-column:1/-1;">No subcategories found.</p>';
                return;
            }
            megaMenuGrid.innerHTML = items.map(item => {
                const title = typeof item === 'string' ? item : item.title;
                const slug = typeof item === 'string' ? title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '') : item.slug;
                
                let iconHtml = '';
                if (isProductMenu && item.image) {
                    iconHtml = `<img src="${item.image}" alt="" loading="lazy" onerror="this.onerror=null;this.src='${item.fallbackImage}'">`;
                } else if (isProductMenu) {
                    iconHtml = `<img src="${item.fallbackImage}" alt="" loading="lazy">`;
                } else if (item.icon) {
                    iconHtml = `<img src="${item.icon}" alt="" loading="lazy">`;
                } else {
                    iconHtml = getCategoryIcon(title, slug);
                }
                
                return `<a href="/${slug}/" class="mega-menu-item">
                    <div class="mega-menu-icon">${iconHtml}</div>
                    <span>${title}</span>
                </a>`;
            }).join('');
        }

        function openMenu(type, li) {
            clearTimeout(hoverTimeout);
            activeType = type;
            hasMegaLis.forEach(l => l.classList.remove('active'));
            li.classList.add('active');
            renderMegaGrid(type);
            positionMegaMenu();
            megaMenu.classList.add('is-open');
        }

        function positionMegaMenu() {
            const header = document.querySelector('.site-header');
            const homeItem = document.querySelector('.header-nav li:first-child');
            const lastNavItem = document.querySelector('.header-nav li:last-child');
            if (!header || !homeItem || !lastNavItem) return;

            const headerRect = header.getBoundingClientRect();
            const homeRect = homeItem.getBoundingClientRect();
            const lastNavRect = lastNavItem.getBoundingClientRect();
            const isProductMenu = megaMenu.classList.contains('mega-menu--products');
            const isResourcesMenu = megaMenu.classList.contains('mega-menu--resources');
            const isMaterialMenu = megaMenu.classList.contains('mega-menu--material');
            
            const menuPaddingLeft = parseFloat(getComputedStyle(megaMenu).paddingLeft) || 0;
            
            if (isResourcesMenu || isMaterialMenu) {
                // Position below the active nav item — left edge aligned
                const activeMenuItem = document.querySelector('.header-nav .has-mega.active');
                const activeMenuRect = activeMenuItem ? activeMenuItem.getBoundingClientRect() : lastNavRect;
                megaMenu.style.width = '';
                const menuWidth = megaMenu.offsetWidth;
                // Align center of menu with center of the nav item
                let desiredLeft = (activeMenuRect.left + (activeMenuRect.width / 2) - (menuWidth / 2)) - headerRect.left;
                // Don't go off right edge
                const maximumLeft = Math.max(4, header.clientWidth - menuWidth - 4);
                megaMenu.style.left = `${Math.min(Math.max(4, desiredLeft), maximumLeft)}px`;
            } else if (isProductMenu) {
                // Center below the active nav item
                const activeMenuItem = document.querySelector('.header-nav .has-mega.active');
                const activeMenuRect = activeMenuItem ? activeMenuItem.getBoundingClientRect() : homeRect;
                megaMenu.style.width = '';
                const menuWidth = megaMenu.offsetWidth;
                let desiredLeft = (activeMenuRect.left + (activeMenuRect.width / 2) - (menuWidth / 2)) - headerRect.left;
                const maximumLeft = Math.max(4, header.clientWidth - menuWidth - 4);
                megaMenu.style.left = `${Math.min(Math.max(4, desiredLeft), maximumLeft)}px`;
            } else {
                // Grid menus (Industry, Box by Style) start from Home
                const desiredLeft = (homeRect.left - headerRect.left) - menuPaddingLeft;
                const calculatedNavWidth = lastNavRect.right - homeRect.left;
                const desiredWidth = Math.min(Math.max(760, calculatedNavWidth + (menuPaddingLeft * 2)), header.clientWidth - 32);
                megaMenu.style.width = `${desiredWidth}px`;
                const maximumLeft = Math.max(4, header.clientWidth - desiredWidth - 16);
                megaMenu.style.left = `${Math.min(Math.max(4, desiredLeft), maximumLeft)}px`;
            }
        }

        function closeMenu() {
            clearTimeout(hoverTimeout);
            hoverTimeout = setTimeout(() => {
                hasMegaLis.forEach(l => l.classList.remove('active'));
                megaMenu.classList.remove('is-open');
                activeType = null;
            }, 120);
        }

        hasMegaLis.forEach(li => {
            const type = li.dataset.megaType;
            li.addEventListener('mouseenter', () => openMenu(type, li));
            li.addEventListener('mouseleave', () => closeMenu());
        });

        const customBoxesTrigger = document.querySelector('.has-mega[data-mega-type="custom-boxes"]');
        if (customBoxesTrigger) {
            customBoxesTrigger.addEventListener('mouseenter', () => openMenu('custom-boxes', customBoxesTrigger));
            customBoxesTrigger.querySelector('.mega-trigger')?.addEventListener('focus', () => openMenu('custom-boxes', customBoxesTrigger));
        }

        megaMenu.addEventListener('mouseenter', () => clearTimeout(hoverTimeout));
        megaMenu.addEventListener('mouseleave', () => closeMenu());
        window.addEventListener('resize', positionMegaMenu);
    })();

    function toggleMobileMenu() {
        document.getElementById('mobileSidebar').classList.toggle('active');
        document.getElementById('mobileOverlay').classList.toggle('active');
        document.body.style.overflow = document.getElementById('mobileSidebar').classList.contains('active') ? 'hidden' : '';
    }

    function toggleMobileSearch() {
        const dropdown = document.getElementById('mobileSearchDropdown');
        if (dropdown.style.display === 'none' || dropdown.style.display === '') {
            dropdown.style.display = 'block';
            dropdown.querySelector('input').focus();
        } else {
            dropdown.style.display = 'none';
        }
    }

    // Sticky Navbar Scroll Behavior
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.querySelector('.site-header');
        const headerTop = document.querySelector('.header-topbar');
        let lastScrollY = window.scrollY;
        
        window.addEventListener('scroll', function() {
            if (window.innerWidth <= 1100) return;
            
            const currentScrollY = window.scrollY;
            const headerTopHeight = headerTop ? headerTop.offsetHeight : 42;
            
            if (currentScrollY > lastScrollY) {
                // Scrolling down
                if (currentScrollY > headerTopHeight) {
                    header.style.top = `-${headerTopHeight}px`;
                }
            } else {
                // Scrolling up
                header.style.top = '0';
            }
            
            lastScrollY = currentScrollY;
        }, { passive: true });
    });
</script>

<script>
    (function () {
        function imageNameFromSrc(image) {
            const source = image.currentSrc || image.getAttribute('src') || '';
            if (!source || source.startsWith('data:') || source.startsWith('blob:')) return '';

            try {
                const pathname = new URL(source, window.location.href).pathname;
                const filename = decodeURIComponent(pathname.split('/').pop() || '');
                return filename.replace(/\.[a-z0-9]+$/i, '');
            } catch (error) {
                return '';
            }
        }

        function applyImageMetadata(image) {
            const imageName = imageNameFromSrc(image);
            if (!imageName) return;

            const words = imageName
                .replace(/([a-z0-9])([A-Z])/g, '$1 $2')
                .replace(/[^a-zA-Z0-9]+/g, ' ')
                .trim()
                .split(/\s+/)
                .filter(Boolean);

            if (!words.length) return;

            image.alt = words.map(word => word.toLowerCase()).join('-');
            image.title = words
                .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
                .join(' ');
        }

        function applyToImages(root) {
            if (root instanceof HTMLImageElement) applyImageMetadata(root);
            if (root.querySelectorAll) root.querySelectorAll('img').forEach(applyImageMetadata);
        }

        function initializeImageMetadata() {
            applyToImages(document);

            document.addEventListener('load', event => {
                if (event.target instanceof HTMLImageElement) applyImageMetadata(event.target);
            }, true);

            new MutationObserver(mutations => {
                mutations.forEach(mutation => {
                    mutation.addedNodes.forEach(node => {
                        if (node.nodeType === Node.ELEMENT_NODE) applyToImages(node);
                    });
                });
            }).observe(document.body, { childList: true, subtree: true });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeImageMetadata);
        } else {
            initializeImageMetadata();
        }
    })();
</script>

<style>
@media (max-width: 61.9375rem) {
    .header-nav { display: none !important; }
    .get-quote-btn { display: none !important; }
    .header-topbar { display: none !important; }
    .header-main { justify-content: space-between !important; position: relative; }
    .header-logo { position: absolute !important; left: 50% !important; transform: translateX(-50%) !important; margin: 0 !important; }
    .header-logo-img { width: 10.9375rem !important; height: 3.75rem !important; }
    .header-main > div { display: contents !important; }
    .mobile-menu-btn { display: block !important; order: -1 !important; margin-left: 0 !important; }
    .search-trigger-btn { order: 1 !important; margin-right: 0 !important; }
}
</style>













