<style>
    /* ─────────────────────────────────────────
       TEXT CONTENT SECTION
    ───────────────────────────────────────── */
    .text-content-section {
        background: var(--background-color);
        padding: 1.25rem 0 1.5625rem 0;
    }

    .text-content-container {
        max-width: 90rem;
        margin: 0 auto;
        padding: 0 1.5rem;
        box-sizing: border-box;
        display: flex;
        justify-content: center;
    }

    .text-content-card {
        width: 100%;
        max-width: 64.375rem;
        background: #FFF8E7;
        border-radius: 0.625rem;
        border: none;
        padding: 3rem 1.25rem 3rem 3.5rem;
        box-sizing: border-box;
        max-height: 49.1875rem;
    }

    .text-content-inner {
        max-height: calc(49.1875rem - 6rem);
        overflow-y: auto;
        padding-right: 1.625rem;
        scrollbar-width: thin;
        scrollbar-color: var(--primary-color) #F0F0F0;
    }

    .text-content-inner::-webkit-scrollbar {
        width: 0.625rem;
    }

    .text-content-inner::-webkit-scrollbar-track {
        background: #F0F0F0;
        border-radius: 1.25rem;
    }

    .text-content-inner::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: 1.25rem;
    }

    .text-content-inner::-webkit-scrollbar-thumb:hover {
        background: var(--footer-color);
    }

    .text-content-heading,
    .text-content-body h1,
    .text-content-body h2,
    .text-content-body h3,
    .text-content-body h4,
    .text-content-body h5,
    .text-content-body h6 {
        font-family: 'Open Sans', sans-serif;
        font-weight: 700;
        color: #000000;
        line-height: 1.4;
    }

    .text-content-heading,
    .text-content-body h2 {
        font-size: 1.5rem;
        margin-bottom: 1.25rem;
    }

    .text-content-body p {
        font-family: 'Open Sans', sans-serif;
        font-size: 1rem;
        color: #000000;
        line-height: 1.7;
        margin-bottom: 0.875rem;
    }

    .text-content-body p:last-child {
        margin-bottom: 0;
    }

    .text-content-body ul,
    .text-content-body ol {
        padding-left: 2rem;
        margin: 0 0 0.875rem 0;
    }

    .text-content-body ul {
        list-style-type: disc;
    }

    .text-content-body ol {
        list-style-type: decimal;
    }

    .text-content-body li {
        font-family: 'Open Sans', sans-serif;
        font-size: 1rem;
        color: #000000;
        line-height: 1.7;
        padding-left: 0.25rem;
        margin-bottom: 0.25rem;
    }

    .text-content-body li::marker {
        color: #000000;
        font-weight: 600;
    }

    .text-content-body a,
    .text-content-body a * {
        color: var(--primary-color) !important;
        text-decoration: underline !important;
        text-decoration-color: var(--primary-color) !important;
    }

    .text-content-body a:hover,
    .text-content-body a:hover * {
        color: var(--primary-color) !important;
        text-decoration: underline !important;
        text-decoration-color: var(--primary-color) !important;
    }

    .text-content-body ul li a,
    .text-content-body ol li a,
    .text-content-body ul li a *,
    .text-content-body ol li a * {
        color: var(--primary-color) !important;
        text-decoration: underline !important;
        text-decoration-color: var(--primary-color) !important;
    }

    .text-content-body ul li a:hover,
    .text-content-body ol li a:hover,
    .text-content-body ul li a:hover *,
    .text-content-body ol li a:hover * {
        color: var(--primary-color) !important;
        text-decoration: underline !important;
        text-decoration-color: var(--primary-color) !important;
    }

    @media (max-width: 62rem) {
        .text-content-card {
            padding: 2rem 0.75rem 2rem 1.5rem;
            height: 28.75rem;
        }
        .text-content-inner {
            height: 100%;
            overflow-y: auto;
            padding-right: 0.875rem;
        }
    }

    @media (max-width: 48rem) {
        .text-content-section {
            padding: 0 0 1.5rem 0;
        }
        .text-content-container {
            padding: 0 1rem;
        }
        .text-content-card {
            padding: 1.5rem 0 1.5rem 1.25rem;
            border-radius: 0.625rem;
            border: none;
            max-height: 39.625rem;
            position: relative;
        }
        .text-content-inner {
            max-height: calc(39.625rem - 3rem);
            overflow-y: auto;
            padding-right: 1.25rem;
            /* Hide native scrollbar on mobile */
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .text-content-inner::-webkit-scrollbar {
            display: none;
        }
        /* Custom scrollbar track */
        .tc-scrollbar-track {
            position: absolute;
            top: 1.125rem;
            right: 0.375rem;
            width: 0.375rem;
            bottom: 1.125rem;
            background: #EBEBEB;
            border-radius: 0.625rem;
            display: none;
        }
        /* Custom scrollbar thumb */
        .tc-scrollbar-thumb {
            position: absolute;
            width: 0.375rem;
            background: #0B2240;
            border-radius: 0.625rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .text-content-heading,
        .text-content-body h2 {
            font-size: 1.125rem;
            line-height: 1.35;
            margin-bottom: 0.875rem;
        }
        .text-content-body p,
        .text-content-body li {
            font-size: 0.8438rem;
            line-height: 1.55;
            margin-bottom: 0.625rem;
            text-align: justify;
        }
    }
</style>

{{-- ═══════════════════════════════════════
     TEXT CONTENT SECTION
═══════════════════════════════════════ --}}
<section class="text-content-section">
    <div class="text-content-container">
        <div class="text-content-card" id="tcCard">
            <!-- Custom scrollbar for mobile -->
            <div class="tc-scrollbar-track" id="tcTrack">
                <div class="tc-scrollbar-thumb" id="tcThumb"></div>
            </div>
            <div class="text-content-inner" id="tcInner">
                <div class="text-content-body">
                    @php
                        $dynamicContentSettings = $settings ?? app(\App\Http\Controllers\AdminHomepageController::class)->loadSettings();
                        $dynamicContentHtml = $dynamicContentSettings['content_section'] ?? '';
                    @endphp
                    {!! $dynamicContentHtml !!}
                </div>
            </div>
        </div>
    </div>
</section>

<script>
(function() {
    function initMobileScrollbar() {
        if (window.innerWidth > 768) return;
        var inner = document.getElementById('tcInner');
        var track = document.getElementById('tcTrack');
        var thumb = document.getElementById('tcThumb');
        if (!inner || !track || !thumb) return;

        // Only show the custom scrollbar when the content actually overflows.
        var hasOverflow = inner.scrollHeight > inner.clientHeight + 2;
        track.style.display = hasOverflow ? 'block' : 'none';
        if (!hasOverflow) return;

        function updateThumb() {
            var trackH = track.offsetHeight;
            var ratio = inner.clientHeight / inner.scrollHeight;
            var thumbH = Math.max(30, trackH * ratio);
            thumb.style.height = thumbH + 'px';
            var scrollRatio = inner.scrollTop / (inner.scrollHeight - inner.clientHeight);
            thumb.style.top = (scrollRatio * (trackH - thumbH)) + 'px';
        }

        inner.addEventListener('scroll', updateThumb);
        window.addEventListener('resize', updateThumb);
        updateThumb();

        // Drag thumb
        var startY, startScrollTop;
        thumb.addEventListener('mousedown', function(e) {
            startY = e.clientY;
            startScrollTop = inner.scrollTop;
            document.addEventListener('mousemove', onDrag);
            document.addEventListener('mouseup', stopDrag);
        });
        thumb.addEventListener('touchstart', function(e) {
            startY = e.touches[0].clientY;
            startScrollTop = inner.scrollTop;
            document.addEventListener('touchmove', onTouchDrag);
            document.addEventListener('touchend', stopDrag);
        }, {passive: true});

        function onDrag(e) {
            var dy = e.clientY - startY;
            var trackH = track.offsetHeight;
            var thumbH = thumb.offsetHeight;
            inner.scrollTop = startScrollTop + (dy / (trackH - thumbH)) * (inner.scrollHeight - inner.clientHeight);
        }
        function onTouchDrag(e) {
            var dy = e.touches[0].clientY - startY;
            var trackH = track.offsetHeight;
            var thumbH = thumb.offsetHeight;
            inner.scrollTop = startScrollTop + (dy / (trackH - thumbH)) * (inner.scrollHeight - inner.clientHeight);
        }
        function stopDrag() {
            document.removeEventListener('mousemove', onDrag);
            document.removeEventListener('mouseup', stopDrag);
            document.removeEventListener('touchmove', onTouchDrag);
            document.removeEventListener('touchend', stopDrag);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMobileScrollbar);
    } else {
        initMobileScrollbar();
    }
})();
</script>
