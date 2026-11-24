@props([
    'video',
    'title' => 'Video Guide',
    'variant' => 'dark',
])

{{-- "Watch Video Guide" link for quote forms. variant: "dark" (navy form) or "light" (cream form). --}}
<button type="button"
        class="qf-video-link qf-video-link--{{ $variant }}"
        data-video-src="{{ asset('uploads/video-guides/' . $video . '.mp4') }}"
        data-video-poster="{{ asset('uploads/video-guides/' . $video . '.webp') }}"
        data-video-title="{{ $title }}">
    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="11"/><path d="M10 8l6 4-6 4z"/></svg>
    <span>Watch Video Guide</span>
</button>

@once
    <style>
        .qf-video-link {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            align-self: flex-start;
            width: auto;
            background: none;
            border: none;
            padding: 0;
            margin: 0;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.75rem;
            font-weight: 500;
            line-height: 1.2;
            cursor: pointer;
        }
        .qf-video-link span {
            text-decoration: underline;
            text-underline-offset: 0.1875rem;
        }
        .qf-video-link svg {
            width: 1rem;
            height: 1rem;
            flex-shrink: 0;
        }
        .qf-video-link svg circle { fill: var(--secondary-color, #FFB400); }
        .qf-video-link svg path { fill: var(--primary-color, #0B2240); }
        .qf-video-link--dark { color: #FFFFFF; }
        .qf-video-link--light { color: #2D2D2D; }
        .qf-video-link--dark:hover span,
        .qf-video-link--dark:focus-visible span { color: var(--secondary-color, #FFB400); }
        .qf-video-link--light:hover span,
        .qf-video-link--light:focus-visible span { color: var(--primary-color, #0B2240); }
        .qf-video-link:focus-visible {
            outline: 1px dashed currentColor;
            outline-offset: 0.1875rem;
        }
        @media (max-width: 48rem) {
            .qf-video-link { font-size: 0.6875rem; }
        }

        .qf-video-modal {
            position: fixed;
            inset: 0;
            z-index: 10000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: rgba(0, 0, 0, 0.8);
        }
        .qf-video-modal.is-open { display: flex; }
        .qf-video-dialog {
            position: relative;
            width: 100%;
            max-width: 56rem;
            background: var(--primary-color, #0B2240);
            border-radius: 0.75rem;
            padding: 1rem;
            box-sizing: border-box;
        }
        .qf-video-title {
            display: block;
            margin: 0 2.5rem 0.75rem 0;
            color: #FFFFFF;
            font-family: 'Open Sans', sans-serif;
            font-size: 1rem;
            font-weight: 700;
        }
        .qf-video-dialog video {
            display: block;
            width: 100%;
            max-height: 75vh;
            border-radius: 0.5rem;
            background: #000;
        }
        .qf-video-close {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            width: 2.25rem;
            height: 2.25rem;
            border: none;
            border-radius: 50%;
            background: transparent;
            color: #FFFFFF;
            font-size: 1.75rem;
            line-height: 1;
            cursor: pointer;
        }
        .qf-video-close:hover { color: var(--secondary-color, #FFB400); }
    </style>

    <div class="qf-video-modal" id="qf-video-modal" role="dialog" aria-modal="true" aria-labelledby="qf-video-title" hidden>
        <div class="qf-video-dialog">
            <button type="button" class="qf-video-close" aria-label="Close video">&times;</button>
            <span class="qf-video-title" id="qf-video-title">Video Guide</span>
            <video controls controlslist="nodownload noplaybackrate" disablepictureinpicture disableremoteplayback playsinline preload="none" oncontextmenu="return false;"></video>
        </div>
    </div>

    <script>
    (function() {
        var modal = document.getElementById('qf-video-modal');
        if (!modal) return;
        // Move the modal out of the form so no parent styles (overflow, transforms) can clip it.
        document.addEventListener('DOMContentLoaded', function() { document.body.appendChild(modal); });

        var video = modal.querySelector('video');
        var title = modal.querySelector('.qf-video-title');
        var lastTrigger = null;

        function openVideo(btn) {
            lastTrigger = btn;
            title.textContent = btn.dataset.videoTitle || 'Video Guide';
            video.poster = btn.dataset.videoPoster || '';
            video.src = btn.dataset.videoSrc;
            modal.hidden = false;
            modal.classList.add('is-open');
            document.body.style.overflow = 'hidden';
            modal.querySelector('.qf-video-close').focus();
            var playing = video.play();
            if (playing && playing.catch) playing.catch(function() {});
        }

        function closeVideo() {
            video.pause();
            video.removeAttribute('src');
            video.load();
            modal.classList.remove('is-open');
            modal.hidden = true;
            document.body.style.overflow = '';
            if (lastTrigger) lastTrigger.focus();
        }

        document.addEventListener('click', function(e) {
            var btn = e.target.closest && e.target.closest('.qf-video-link');
            if (btn) openVideo(btn);
        });
        modal.querySelector('.qf-video-close').addEventListener('click', closeVideo);
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeVideo();
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('is-open')) closeVideo();
        });
    })();
    </script>
@endonce
