<footer class="main-footer">
    <!-- Top Cards Section -->
    <div class="top-cards-section">
        <div class="container">
            @php
                $cardEmail = !empty($siteSettings['company_email']) ? $siteSettings['company_email'] : 'support@gocustomboxes.com';
                $cardPhone = !empty($siteSettings['company_phone']) && $siteSettings['company_phone'] !== '0123456789' && $siteSettings['company_phone'] !== '1800-315-8441' ? $siteSettings['company_phone'] : '1-773-945-5230';
                $cardAddress = !empty($siteSettings['company_address']) && !str_contains($siteSettings['company_address'], 'Montrose') ? $siteSettings['company_address'] : '1941 Waverly way Montgomery IL 60538';
                $cleanPhone = preg_replace('/[^0-9+]/', '', $cardPhone);
                $mapQuery = urlencode(strip_tags(str_replace(['<br>', '<br/>', '<br />'], ' ', $cardAddress)));
            @endphp
            <div class="top-cards-grid">
                <a href="mailto:{{ $cardEmail }}" class="top-card" style="text-decoration: none; cursor: pointer; color: inherit;">
                    <div class="top-card-icon">
                        <img src="{{ asset('images/contact-email.webp') }}" alt="Email" width="25" height="20">
                    </div>
                    <div class="top-card-title">Get In Touch</div>
                    <div class="top-card-text">
                        {{ $cardEmail }}
                    </div>
                </a>
                <a href="tel:{{ $cleanPhone }}" class="top-card" style="text-decoration: none; cursor: pointer; color: inherit;">
                    <div class="top-card-icon">
                        <img src="{{ asset('images/material-symbols_call-sharp.webp') }}" alt="Phone" width="30" height="30">
                    </div>
                    <div class="top-card-title">Call Us</div>
                    <div class="top-card-text">
                        {{ $cardPhone }}
                    </div>
                </a>
                <a href="https://www.google.com/maps/place/Go+Custom+Boxes/@41.7238237,-88.40347,19.63z/data=!4m15!1m8!3m7!1s0x880ee8cc8e1048af:0x22c732baaebb1bb2!2s1941+Waverly+Way,+Montgomery,+IL+60538,+USA!3b1!8m2!3d41.7238163!4d-88.4034576!16s%2Fg%2F11snnlvyv7!3m5!1s0x880ee9cb9d7bb8a7:0xc217e8b02a3b96f8!8m2!3d41.723822!4d-88.403468!16s%2Fg%2F11hyl38x8n?entry=ttu&g_ep=EgoyMDI2MTExOC4xIKXMDSoASAFQAw%3D%3D" target="_blank" rel="noopener noreferrer" class="top-card" style="text-decoration: none; cursor: pointer; color: inherit;">
                    <div class="top-card-icon">
                        <img src="{{ asset('images/contact-address.webp') }}" alt="Address" width="19" height="27">
                    </div>
                    <div class="top-card-title">Address</div>
                    <div class="top-card-text">
                        {!! $cardAddress !!}
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Footer Content -->
    <div class="footer-content">
        <div class="container">
            <div class="footer-grid">
                <!-- Brand Column -->
                <div class="footer-column brand-column">
                    <div class="footer-logo">
                        <img src="{{ asset('uploads/footer-logo (2).svg') }}" alt="Footer Logo" class="logo-image">
                    </div>
                    <p class="brand-description">
                        {{ $siteSettings['footer_description'] ?? 'The Rigid Boxes is a leading custom packaging manufacturer, delivering premium boxes and packaging solutions tailored to your brand. From design to delivery, we ensure unmatched quality, style, and customer service.' }}
                    </p>
                </div>

                <!-- Categories Column -->
                <div class="footer-column mobile-accordion">
                    <span class="footer-heading" onclick="this.parentElement.classList.toggle('open')" style="display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                        Categories <span class="toggle-icon">+</span>
                    </span>
                    <ul class="footer-links accordion-content">
                        @php
                            $footerCatIds = array_slice($siteSettings['footer_categories'] ?? [], 0, 5);
                            $footerCats = [];
                            if (!empty($footerCatIds)) {
                                try {
                                    $footerCats = \Illuminate\Support\Facades\DB::table('admin_categories')
                                        ->whereIn('id', $footerCatIds)
                                        ->where('status', 'published')
                                        ->get();
                                } catch (\Exception $e) {
                                    $footerCats = collect();
                                }
                            }
                        @endphp
                        @if(empty($footerCatIds) || count($footerCats) == 0)
                            <li><a href="/super-boxes">Super Boxes</a></li>
                            <li><a href="/rigid-boxes">Rigid Boxes</a></li>
                            <li><a href="/mailer-boxes">Mailer Boxes</a></li>
                            <li><a href="/jewelry-boxes">Jewelry Boxes</a></li>
                            <li><a href="/hang-tags">Hang Tags</a></li>
                        @else
                            @foreach($footerCats->take(5) as $cat)
                                <li><a href="{{ url('/' . $cat->slug) }}/">{{ $cat->title ?? $cat->name }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <!-- Products Column -->
                <div class="footer-column mobile-accordion">
                    <span class="footer-heading" onclick="this.parentElement.classList.toggle('open')" style="display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                        Products <span class="toggle-icon">+</span>
                    </span>
                    <ul class="footer-links accordion-content">
                        @php
                            $footerProductIds = array_slice($siteSettings['footer_products'] ?? [], 0, 5);
                            $footerProducts = [];
                            if (!empty($footerProductIds)) {
                                try {
                                    $footerProducts = \Illuminate\Support\Facades\DB::table('admin_products')
                                        ->whereIn('id', $footerProductIds)
                                        ->where('status', 'published')
                                        ->get();
                                } catch (\Exception $e) {
                                    $footerProducts = collect();
                                }
                            }
                        @endphp
                        @if(!empty($footerProducts) && count($footerProducts) > 0)
                            @foreach($footerProducts->take(5) as $prod)
                                <li><a href="{{ url('/' . ltrim($prod->slug, '/')) }}/">{{ $prod->title }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <!-- Quick Links Column -->
                <div class="footer-column mobile-accordion">
                    <span class="footer-heading" onclick="this.parentElement.classList.toggle('open')" style="display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                        Quick Links <span class="toggle-icon">+</span>
                    </span>
                    <ul class="footer-links accordion-content">
                        @php
                            $quickLinks = array_slice($siteSettings['footer_quick_links'] ?? [], 0, 5);
                        @endphp
                        @if(empty($quickLinks))
                            <li><a href="/about-us/">About Us</a></li>
                            <li><a href="/contact-us/">Contact Us</a></li>
                            <li><a href="/request-quote/">Get A Free Quote</a></li>
                            <li><a href="/terms-of-services/">Terms of Services</a></li>
                            <li><a href="/blog/">Blog</a></li>
                        @else
                            @foreach(array_slice($quickLinks, 0, 5) as $link)
                                <li><a href="{{ $link['url'] }}">{{ $link['name'] }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                    
                    <div class="desktop-social-section" style="margin-top: 2rem;">
                        <span class="footer-heading" style="display: block; margin-bottom: 1.25rem;">Follow Us</span>
                        <div class="social-links desktop-social-links" style="display: flex; justify-content: flex-start; gap: 0.9375rem;">
                            <a href="{{ $siteSettings['social_facebook'] ?? '#' }}" target="_blank" rel="noopener" class="social-icon" aria-label="Facebook">
                                <img src="{{ asset('images/social-facebook.webp') }}" alt="Facebook" class="social-icon-img" width="30" height="30">
                            </a>
                            
                            <a href="{{ $siteSettings['social_instagram'] ?? '#' }}" target="_blank" rel="noopener" class="social-icon" aria-label="Instagram">
                                <img src="{{ asset('images/social-instagram.webp') }}" alt="Instagram" class="social-icon-img" width="30" height="30">
                            </a>
                            
                            <a href="{{ $siteSettings['social_linkedin'] ?? '#' }}" target="_blank" rel="noopener" class="social-icon" aria-label="LinkedIn">
                                <img src="{{ asset('images/social-linkedin.webp') }}" alt="LinkedIn" class="social-icon-img" width="30" height="30">
                            </a>
                            
                            <a href="{{ $siteSettings['social_pinterest'] ?? '#' }}" target="_blank" rel="noopener" class="social-icon" aria-label="Pinterest">
                                <img src="{{ asset('images/bi_pinterest.webp') }}" alt="Pinterest" class="social-icon-img" width="32" height="32">
                            </a>
                            
                            @if(!empty($siteSettings['social_youtube']))
                                <a href="{{ $siteSettings['social_youtube'] }}" target="_blank" rel="noopener" class="social-icon" aria-label="YouTube">
                                    <span class="visually-hidden">YouTube</span>
                                    <img src="{{ asset('images/social-youtube.webp') }}" alt="YouTube" class="social-icon-img" width="30" height="24">
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <div class="social-links mobile-social-links">
                    <a href="{{ $siteSettings['social_facebook'] ?? '#' }}" target="_blank" rel="noopener" class="social-icon" aria-label="Facebook">
                        <img src="{{ asset('images/social-facebook.webp') }}" alt="Facebook" class="social-icon-img" width="30" height="30">
                    </a>
                    
                    <a href="{{ $siteSettings['social_instagram'] ?? '#' }}" target="_blank" rel="noopener" class="social-icon" aria-label="Instagram">
                        <img src="{{ asset('images/social-instagram.webp') }}" alt="Instagram" class="social-icon-img" width="30" height="30">
                    </a>
                    
                    <a href="{{ $siteSettings['social_linkedin'] ?? '#' }}" target="_blank" rel="noopener" class="social-icon" aria-label="LinkedIn">
                        <img src="{{ asset('images/social-linkedin.webp') }}" alt="LinkedIn" class="social-icon-img" width="30" height="30">
                    </a>
                    
                    <a href="{{ $siteSettings['social_pinterest'] ?? '#' }}" target="_blank" rel="noopener" class="social-icon" aria-label="Pinterest">
                        <img src="{{ asset('images/bi_pinterest.webp') }}" alt="Pinterest" class="social-icon-img" width="32" height="32">
                    </a>
                    
                    @if(!empty($siteSettings['social_youtube']))
                        <a href="{{ $siteSettings['social_youtube'] }}" target="_blank" rel="noopener" class="social-icon" aria-label="YouTube">
                            <span class="visually-hidden">YouTube</span>
                            <img src="{{ asset('images/social-youtube.webp') }}" alt="YouTube" class="social-icon-img" width="30" height="24">
                        </a>
                    @endif
                </div>
                <p class="copyright">© 2026 Go Custom Boxes. All rights reserved.</p>
                <div class="payment-methods">
                    <img src="{{ asset('images/Group 1000006247.webp') }}" alt="Payment Methods" class="payment-group" width="375" height="26">
                </div>
            </div>
        </div>
    </div>
</footer>

<div id="successPopup" class="success-popup-overlay" style="display: none;">
    <div class="success-popup-box">
        <div class="success-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <span class="thank-you-title">Thank You!</span>
        <p>{{ session('success') }}</p>
        <button onclick="document.getElementById('successPopup').style.display='none'">Close</button>
    </div>
</div>
<style>
.success-popup-overlay {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.6); z-index: 9999;
    display: flex; align-items: center; justify-content: center;
}
.success-popup-box {
    background: #fff; padding: 1.875rem; border-radius: 0.75rem;
    text-align: center; max-width: 25rem; width: 90%;
    box-shadow: 0 0.625rem 1.5625rem rgba(0,0,0,0.2);
    animation: popIn 0.4s ease;
}
.success-icon {
    width: 3.75rem; height: 3.75rem; border-radius: 50%;
    background: #e8f5e9; color: #4caf50;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 0.9375rem;
}
.success-icon svg { width: 2.1875rem; height: 2.1875rem; }
.success-popup-box h2, .success-popup-box .thank-you-title { color: #333; margin-bottom: 0.625rem; font-family: 'Open Sans', sans-serif; display: block; }
.success-popup-box p { color: #666; font-size: 1rem; margin-bottom: 1.5625rem; line-height: 1.5; font-family: 'DM Sans', sans-serif; }
.success-popup-box button {
    background: #8D4445; color: #fff; border: none;
    padding: 0.625rem 1.875rem; border-radius: 0.375rem; font-size: 1rem;
    cursor: pointer; font-weight: 600; transition: background 0.2s;
}
.success-popup-box button:hover { background: #6b3334; }
.ajax-inline-success {
    width: 100%;
    box-sizing: border-box;
    margin: 0 0 1.25rem;
    padding: 1rem 1.25rem;
    border: 1px solid var(--primary-color, #0B2240);
    border-radius: 0.75rem;
    background: #FFFFFF;
    color: var(--primary-color, #0B2240);
    font-family: 'Open Sans', sans-serif;
    font-size: 0.9375rem;
    font-weight: 700;
    line-height: 1.4;
    text-align: center;
}
.quote-success-message.ajax-inline-success {
    margin: -0.25rem 0 1.875rem;
    padding: 1.6rem 1.25rem;
    border-radius: 1.125rem;
    font-size: 1.125rem;
}
@keyframes popIn {
    0% { transform: scale(0.8); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}
</style>
<script>
    setTimeout(function() {
        var popup = document.getElementById('successPopup');
        if(popup) { popup.style.display = 'none'; }
    }, 6000);
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Keep meaningful image alt text consistent without changing decorative alt="" images.
    const normalizeImageAlt = function(image) {
        const alt = image.getAttribute('alt');
        if (alt === null || alt.trim() === '') return;

        image.setAttribute(
            'alt',
            alt
                .trim()
                .replace(/[-_]+/g, ' ')
                .replace(/\s+/g, ' ')
                .toLowerCase()
        );
    };

    document.querySelectorAll('img[alt]').forEach(normalizeImageAlt);

    // Normalize images added later by sliders, AJAX content, or other components.
    const imageObserver = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                if (!(node instanceof Element)) return;
                if (node.matches('img[alt]')) normalizeImageAlt(node);
                node.querySelectorAll('img[alt]').forEach(normalizeImageAlt);
            });
        });
    });
    imageObserver.observe(document.body, { childList: true, subtree: true });

    const ajaxForms = document.querySelectorAll('form[action*="/submit-quote"], form[action*="/submit-newsletter"], form[action*="/submit-contact"]');
    
    ajaxForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn ? submitBtn.innerHTML : '';
            if(submitBtn) submitBtn.innerHTML = 'Submitting...';
            
            const formData = new FormData(form);

            const send = () => fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            // 419 = the session behind the page's CSRF token expired (e.g. the tab was left open).
            // Get a fresh CSRF token for a new session and send the same data once more.
            const refreshCsrfAndResend = () => fetch('{{ url('/spam-guard/token') }}/?captcha=0', {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                credentials: 'same-origin',
                cache: 'no-store'
            })
            .then(r => r.json())
            .then(d => {
                if(!d.csrf) throw new Error('No CSRF token');
                const tokenInput = form.querySelector('input[name="_token"]');
                if(tokenInput) tokenInput.value = d.csrf;
                formData.set('_token', d.csrf);
                return send();
            });

            send()
            .then(response => response.status === 419 ? refreshCsrfAndResend() : response)
            .then(response => response.json().catch(() => ({})).then(data => ({ ok: response.ok, status: response.status, data })))
            .then(({ ok, status, data }) => {
                if(submitBtn) submitBtn.innerHTML = originalBtnText;

                if(!ok) {
                    const errors = data && data.errors ? Object.values(data.errors).flat() : [];
                    let message = errors.length ? errors.join('\n') : (data && data.message) || 'Please check the form and try again.';
                    if(status === 419) message = 'Your session has expired. Please refresh the page and try again.';
                    if(status === 429) message = 'Too many attempts. Please wait a few minutes and try again.';
                    alert(message);
                    return;
                }

                let inlineMsg = form.querySelector('.ajax-inline-success');
                if(!inlineMsg) {
                    inlineMsg = document.createElement('div');
                    inlineMsg.className = 'quote-success-message ajax-inline-success';
                    inlineMsg.style.transition = 'opacity 0.5s';
                    form.parentNode.insertBefore(inlineMsg, form);
                }
                inlineMsg.innerText = data.success || 'Submitted successfully!';
                inlineMsg.style.display = 'block';
                inlineMsg.style.opacity = '1';
                inlineMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Reset form
                form.reset();
                
                // Hide after 20 seconds
                setTimeout(() => {
                    if(inlineMsg) {
                        inlineMsg.style.opacity = '0';
                        setTimeout(() => inlineMsg.style.display = 'none', 500);
                    }
                }, 20000);
            })
            .catch(error => {
                console.error('Error:', error);
                if(submitBtn) submitBtn.innerHTML = originalBtnText;
                alert('An error occurred. Please try again.');
            });
        });
    });
});
</script>

<script src="https://tcbconnect.com/widget.js" data-livechat-key="wk_485cf856a40d" async></script>
