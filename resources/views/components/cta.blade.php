<style>
    /* ─────────────────────────────────────────
       CTA BANNER SECTION
    ───────────────────────────────────────── */
    .cta-section {
        background: var(--background-color);
        padding: 0.625rem 0 1.875rem;
    }

    .cta-container {
        max-width: 80rem;
        margin: 0 auto;
        padding: 0 1.5rem;
        box-sizing: border-box;
    }

    .mobile-br { display: none; }
    .desktop-only-space { display: inline; }

    .cta-banner {
        width: 100%;
        max-width: 72rem;
        margin: 0 auto;
        display: flex;
        position: relative;
        overflow: hidden;
        border-radius: 2rem;
    }

    .cta-text-card {
        width: 100%;
        min-height: 23rem;
        background: linear-gradient(to right, #FDD471, #FFB400);
        border-radius: 2rem;
        padding: 3rem 31rem 3rem 5rem;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    /* Large circle — bottom right, partially off-edge */
    .cta-text-card::before {
        display: none;
    }

    /* Smaller circle — above the large one, right side */
    .cta-text-card::after {
        display: none;
    }

    .cta-ellipse {
        position: absolute;
        pointer-events: none;
        user-select: none;
        display: none;
    }

    /* Ellipse-793: large, bottom-right, partially clipped off right edge */
    .cta-ellipse-1 {
        width: 15rem;
        height: 15rem;
        bottom: -4.375rem;
        right: -3.75rem;
    }

    /* Ellipse-794: smaller, sits on top of the large circle */
    .cta-ellipse-2 {
        width: 8.75rem;
        height: 8.75rem;
        bottom: 0.625rem;
        right: 1.25rem;
    }

    .cta-heading {
        font-family: 'Open Sans', sans-serif;
        font-size: 1.875rem;
        font-weight: 800;
        color: var(--primary-color);
        line-height: 1.25;
        margin-bottom: 0.875rem;
    }

    .cta-desc {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.9375rem;
        color: #000;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        max-width: 30rem;
    }

    .cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-color);
        color: var(--secondary-color);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.875rem;
        font-weight: 700;
        padding: 0.875rem 1.5rem;
        border-radius: 0.25rem;
        text-decoration: none;
        border: none;
        cursor: pointer;
        width: fit-content;
        align-self: flex-start;
        flex-shrink: 0;
        transition: opacity 0.2s;
    }

    .cta-btn:hover {
        opacity: 0.9;
    }

    .cta-image-wrapper {
        position: absolute;
        right: 2rem;
        top: 2rem;
        width: 29rem;
        height: 18rem;
    }

    .cta-desktop-ellipse {
        display: none;
    }

    .cta-image-wrapper .cta-main-img {
        position: relative;
        z-index: 1;
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        display: block;
    }

    @media (max-width: 68.75rem) {
        .cta-text-card {
            padding: 2.5rem 24rem 2.5rem 3rem;
        }
        .cta-image-wrapper {
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            width: 21rem;
            height: 13.25rem;
        }
    }

    @media (max-width: 48rem) {
        .mobile-br { display: block; }
        .desktop-only-space { display: none; }

        .cta-section {
            padding: 1.875rem 0.9375rem !important;
            margin: 0 !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
        main > section.cta-section > .cta-container,
        .cta-section > .cta-container {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }
        .cta-banner {
            display: flex;
            flex-direction: column;
            width: 100% !important;
            max-width: 23.75rem !important;
            height: 37.75rem !important;
            margin: 0 auto !important;
            padding: 2.8125rem 0 0 !important;
            overflow: hidden !important;
            background: linear-gradient(to right, #FDD471, #FFB400) !important;
            border-radius: 1.25rem !important;
            box-sizing: border-box !important;
            position: relative;
        }
        .cta-text-card {
            order: 1;
            width: 100%;
            min-height: 0;
            padding: 0 1.25rem;
            background: transparent !important;
            border-radius: 0 !important;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .cta-heading {
            font-size: 1.625rem;
            line-height: 1.3;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .cta-desc {
            max-width: 20rem;
            margin: 0 auto 1.75rem;
            font-size: 0.9375rem;
            line-height: 1.5;
            text-align: center;
        }
        .cta-btn {
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-size: 0.9375rem;
            align-self: center;
            margin: 0 auto 2.1875rem;
        }
        .cta-image-wrapper {
            position: relative;
            left: auto;
            right: auto;
            top: auto;
            transform: none;
            order: 2;
            z-index: 1;
            width: 100%;
            max-width: 23.75rem;
            height: 14.25rem;
            margin: 0 auto;
            border-radius: 0 0 1.25rem 1.25rem;
            overflow: visible !important;
            display: flex;
            justify-content: center;
            align-items: flex-end;
        }
        .cta-desktop-ellipse {
            display: none !important;
            width: 21.8938rem !important;
            height: 9.9563rem !important;
            bottom: -4.2594rem !important;
            right: auto !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            opacity: 1.32 !important;
            z-index: 0 !important;
        }
        .cta-image-wrapper .cta-main-img {
            height: 100%;
            width: 100%;
            object-fit: contain;
            object-position: center bottom;
            border-radius: 0;
            display: block;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            bottom: 0;
        }
        .cta-text-card > :not(.cta-ellipse) {
            position: relative;
            z-index: 1;
        }
    }

    @media (max-width: 36rem) {
        .cta-section {
            padding: 1.875rem 0 1.875rem !important;
        }
    }
</style>

<section class="cta-section">
    <div class="cta-container">
        <div class="cta-banner">
            <div class="cta-text-card">
                <img src="{{ asset('uploads/cta-ellipse-1.png') }}" alt="Decorative yellow ellipse" class="cta-ellipse cta-ellipse-1">
                <img src="{{ asset('uploads/cta-ellipse-2.png') }}" alt="Decorative blue ellipse" class="cta-ellipse cta-ellipse-2">
                <span class="cta-heading" style="display: block;">Get Your Custom<br class="mobile-br"> <span class="desktop-only-space"> </span>Packaging Today</span>
                <p class="cta-desc">Deliver elegance, protection, and a<br class="mobile-br"> memorable unboxing experience with<br class="mobile-br"> fully customized rigid box solutions.</p>
                <a href="/request-quote/" class="cta-btn">
                    Get a Quote
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 8h10M9 4l4 4-4 4"/>
                    </svg>
                </a>
            </div>
            <div class="cta-image-wrapper">
                <img src="{{ asset('uploads/Ellipse 793.webp') }}" alt="Decorative packaging background ellipse" class="cta-desktop-ellipse" width="351" height="162">
                <img src="{{ asset('uploads/cta-img.webp') }}" class="cta-main-img" alt="Custom Packaging" onerror="this.src='https://placehold.co/540x324/f5bd00/112a46?text=Custom+Packaging'">
            </div>
        </div>
    </div>
</section>
