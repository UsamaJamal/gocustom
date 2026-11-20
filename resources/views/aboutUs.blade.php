@php
    // Hero banner at the top of the page, also used as the share image (og/twitter).
    $aboutHeroImage = 'uploads/about-us-hero.webp';
@endphp
@include('components.htmlboilerplate', [
    'image' => $aboutHeroImage,
    'imageAlt' => 'Luxury custom rigid boxes in green, navy, grey and cream',
    'title' => 'About Us | Go Custom Boxes',
    'metaDescription' => 'Learn more about Go Custom Boxes, our commitment to exceptional custom packaging, bespoke box printing, and wholesale packaging solutions.',
    'metaKeywords' => 'about go custom boxes, custom packaging company, box manufacturer usa',
    'robots' => 'index,follow'
])
<style>
/* Base Styles */
.about-us-page {
    font-family: 'Inter', sans-serif;
    color: #000;
}
.about-container {
    max-width: 75rem;
    margin: 0 auto;
    padding: 0 1.25rem;
}
.section-padding {
    padding: 5rem 0;
}



/* 2. Who We Are */
.who-we-are {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3.75rem;
    align-items: stretch;
}
.who-we-are-text {
    height: 100%;
}
.who-we-are-text h2 {
    font-family: var(--font-heading);
    font-size: 2.25rem;
    font-weight: 700;
    margin-top: 0;
    margin-bottom: 1.25rem;
    line-height: 1.2;
}
.who-we-are-text p {
    font-size: 1rem;
    line-height: 1.8;
    margin-bottom: 1.25rem;
    color: #000;
    text-align: justify;
}
.who-we-are-text p:last-child {
    margin-bottom: 0;
}
.who-we-are-grid {
    display: flex;
    gap: 0.9375rem;
}
.who-we-are-col {
    display: flex;
    flex-direction: column;
    gap: 0.9375rem;
    flex: 1;
}
.who-we-are-col img {
    width: 100%;
    object-fit: cover;
    border-radius: 0.5rem;
}
.img-tall {
    flex: 1.6;
}
.img-short {
    flex: 1;
}

/* 3. Making Custom Packaging Simple */
.making-simple {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3.75rem;
    align-items: center;
}
.making-simple-img {
    width: 100%;
    height: auto;
    aspect-ratio: 520 / 400;
    object-fit: cover;
    border-radius: 0.75rem;
}
.making-simple-text h2 {
    font-family: var(--font-heading);
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1.25rem;
}
.making-simple-text p {
    font-size: 1rem;
    line-height: 1.8;
    margin-bottom: 1.25rem;
    color: #000;
    text-align: justify;
}
.callout-box {
    background: #FDF9EE;
    padding: 1.25rem;
    border-radius: 0.5rem;
    display: inline-flex;
    align-items: center;
    gap: 0.625rem;
    font-weight: 600;
    color: #000;
}

/* 4. Built Around What Matters */
.built-around {
    text-align: center;
}
.built-around h2 {
    font-family: var(--font-heading);
    font-size: 2.25rem;
    font-weight: 700;
    margin-bottom: 0.9375rem;
}
.built-around p.subtitle {
    font-size: 0.875rem;
    color: #000 !important;
    margin-bottom: 1.75rem;
}
.features-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
}
.feature-card {
    background: #FDF9EE;
    padding: 1.875rem 1.25rem;
    border-radius: 0.75rem;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    box-shadow: 0 0.25rem 1rem rgba(0, 0, 0, 0.08);
}
.feature-icon {
    background: #0b1c31;
    width: 3.125rem;
    height: 3.125rem;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
}
.feature-icon img {
    width: 1.875rem;
}
.feature-card h3 {
    font-family: var(--font-heading);
    font-size: 1.125rem !important;
    font-weight: 700;
    margin-bottom: 0.9375rem;
    color: #000;
    white-space: nowrap;
}
.feature-card p {
    font-size: 0.875rem;
    color: #000;
    line-height: 1.6;
    text-align: justify;
}

/* 6. Our Valued Customers */
.valued-customers {
    text-align: center;
    padding: 1.25rem 0 !important;
}
.valued-customers h2 {
    font-family: var(--font-heading);
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
}
.logo-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
}
.logo-box {
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 7.1875rem;
    box-shadow: 0 0.25rem 1rem rgba(0, 0, 0, 0.08);
}
.logo-box img {
    max-height: 6.75rem;
    max-width: 6.75rem;
    object-fit: contain;
}

/* Responsive */
@media (max-width: 61.9375rem) {
    .bottom-cta-banner {
        grid-template-columns: 1fr;
        gap: 2.5rem;
    }
    .making-simple {
        grid-template-columns: 1fr;
        gap: 1.25rem;
    }
    .who-we-are {
        grid-template-columns: 1fr;
        gap: 1.25rem;
    }
    .who-we-are-text {
        order: 2;
    }
    .who-we-are-text p:last-child {
        margin-bottom: 0;
    }
    .who-we-are-grid {
        order: 1;
    }
    .features-grid, .steps-grid, .logo-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .bottom-cta-banner {
        flex-direction: column;
        text-align: center;
        padding: 2.5rem 1.25rem;
    }
    .cta-image {
        margin-top: 1.875rem;
    }
}
@media (max-width: 48rem) {
    .features-grid, .steps-grid {
        grid-template-columns: 1fr;
    }
    .who-we-are-text h2, .making-simple-text h2, .built-around h2, .order-process h2, .cta-text h2 {
        font-size: 1.75rem;
    }
    .built-around p.subtitle {
        text-align: justify;
        color: #000 !important;
    }
    .feature-card {
        min-height: 13.3125rem;
    }
}
</style>

<main class="about-us-page">
@include('components.header')

<!-- 1. Hero Section -->
<x-about-hero 
    title="About Us"
    description="From box styles and materials to custom sizes, pricing, and delivery, find quick answers to the questions we hear most."
    :bgImage="$aboutHeroImage"
    mobileBgImage="uploads/about-us-mobile.webp"
    breadcrumb="About Us"
/>

<!-- 2. Who We Are -->
<section class="section-padding" style="padding: 2.5rem 0;">
    <div class="about-container who-we-are">
        <div class="who-we-are-text">
            <h2>Who We Are</h2>
            <p>At Go Custom Boxes, we believe packaging is more than something that holds a product. It's an important part of your brand experience. Every box is an opportunity to make a strong first impression, communicate your brand identity, and give customers an experience worth remembering.</p>
            <p>We work with businesses to create custom packaging that balances design, durability, and functionality. From choosing the right material and dimensions to selecting printing and finishing options, we focus on the details that make your packaging truly fit your product.</p>
            <p>Our commitment extends beyond just providing boxes. We strive to offer sustainable, eco-friendly materials that help you reduce your environmental footprint without compromising on quality or aesthetics. By partnering with us, you gain a dedicated team ready to support your vision from the initial concept all the way to final delivery, ensuring every detail is perfectly executed.</p>
        </div>
        <div class="who-we-are-grid">
            <div class="who-we-are-col">
                <img src="{{ asset('uploads/who-img-1.jpg') }}" alt="Custom Perfume Box" class="img-tall" onerror="this.src='https://placehold.co/250x290/brown/white'">
                <img src="{{ asset('uploads/who-img-2.jpg') }}" alt="Custom Green Box" class="img-short" onerror="this.src='https://placehold.co/250x150/blue/white'">
            </div>
            <div class="who-we-are-col">
                <img src="{{ asset('uploads/who-img-3.jpg') }}" alt="Custom Blue Box" class="img-short" onerror="this.src='https://placehold.co/250x150/tan/white'">
                <img src="{{ asset('uploads/who-img-4.jpg') }}" alt="Custom Beige Box" class="img-tall" onerror="this.src='https://placehold.co/250x290/tan/white'">
            </div>
        </div>
    </div>
</section>

<!-- 3. Making Custom Packaging Simple -->
<section class="section-padding" style="padding-top: 0; padding-bottom: 1.25rem;">
    <div class="about-container making-simple">
        <div>
            <img src="{{ asset('uploads/making-simple-img.jpg') }}" alt="Custom Packaging" class="making-simple-img" onerror="this.src='https://placehold.co/600x600/darkgreen/white'">
        </div>
        <div class="making-simple-text">
            <h2>Making Custom Packaging Simple</h2>
            <p>Our purpose is to make custom packaging easier, more accessible, and more effective for businesses of all sizes. We help turn packaging ideas into practical, well-designed boxes that reflect each brand's unique identity.</p>
            <p>From selecting the right materials and dimensions to choosing printing and finishing options, we guide every project with care and attention to detail. Our goal is simple: create packaging that protects your product, strengthens your brand, and leaves a lasting impression.</p>
            <div class="callout-box">
                <span style="font-size: 1.75rem; font-weight: 900; font-family: serif; line-height: 0; position: relative; top: -0.3rem;">&ldquo;</span> 
                <span>Durable and high-quality materials for product protection.</span>
                <span style="font-size: 1.75rem; font-weight: 900; font-family: serif; line-height: 0; position: relative; top: 1rem;">&rdquo;</span>
            </div>
        </div>
    </div>
</section>

<!-- 4. Built Around What Matters -->
<section class="section-padding" style="padding-top: 0.625rem; padding-bottom: 1.875rem;">
    <div class="about-container built-around">
        <h2>Built Around What Matters</h2>
        <p class="subtitle">Every project starts with your product and ends with packaging designed to work for your brand.</p>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <img src="{{ asset('uploads/premium-quality.svg') }}" alt="Premium Quality" onerror="this.src='https://placehold.co/30x30/transparent/white?text=Q'">
                </div>
                <h3>Premium Quality</h3>
                <p>Every order undergoes a 12-point quality inspection. We use only premium-grade materials that look and feel exceptional.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <img src="{{ asset('uploads/fast-and-flexible.svg') }}" alt="Fast & Flexible" onerror="this.src='https://placehold.co/30x30/transparent/white?text=F'">
                </div>
                <h3>Fast & Flexible</h3>
                <p>Average production time is just 4-6 days. Rush options are available on select products to help keep your packaging on schedule.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <img src="{{ asset('uploads/design-and-support.svg') }}" alt="Design & Support" onerror="this.src='https://placehold.co/30x30/transparent/white?text=D'">
                </div>
                <h3>Design & Support</h3>
                <p>Enjoy unlimited design revisions and dedicated support from a packaging expert who understands your brand, specifications, and preferences from start to finish.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <img src="{{ asset('uploads/clear-and-sustainable.svg') }}" alt="Clear & Sustainable" onerror="this.src='https://placehold.co/30x30/transparent/white?text=S'">
                </div>
                <h3>Clear & Sustainable</h3>
                <p>No hidden fees or surprise charges. Get transparent pricing and recyclable packaging made from responsibly sourced materials.</p>
            </div>
        </div>
    </div>
</section>

<!-- 5. How It Works -->
@include('components.howitworks')

<!-- 6. Our Valued Customers -->
<section class="section-padding valued-customers">
    <div class="about-container">
        <h2>Our Valued Customers</h2>
        <div class="logo-grid">
            <div class="logo-box"><img src="{{ asset('uploads/trusted-true-girl.svg') }}" alt="TrueGirl" onerror="this.src='https://placehold.co/150x50/white/grey?text=Logo'"></div>
            <div class="logo-box"><img src="{{ asset('uploads/trusted-organics.svg') }}" alt="Organics" onerror="this.src='https://placehold.co/150x50/white/grey?text=Logo'"></div>
            <div class="logo-box"><img src="{{ asset('uploads/trusted-jeeter-mart.svg') }}" alt="Jeeter Mart" onerror="this.src='https://placehold.co/150x50/white/grey?text=Logo'"></div>
            <div class="logo-box"><img src="{{ asset('uploads/trusted-bass-pro-shop.svg') }}" alt="Bass Pro Shops" onerror="this.src='https://placehold.co/150x50/white/grey?text=Logo'"></div>
            <div class="logo-box"><img src="{{ asset('uploads/trusted-burger-bar.svg') }}" alt="Burger Bar" onerror="this.src='https://placehold.co/150x50/white/grey?text=Logo'"></div>
            <div class="logo-box"><img src="{{ asset('uploads/trusted-hulu-motor.svg') }}" alt="Hulu Motel" onerror="this.src='https://placehold.co/150x50/white/grey?text=Logo'"></div>
            <div class="logo-box"><img src="{{ asset('uploads/trusted-organics.svg') }}" alt="Organics" onerror="this.src='https://placehold.co/150x50/white/grey?text=Logo'"></div>
            <div class="logo-box"><img src="{{ asset('uploads/trusted-hulu-motor.svg') }}" alt="Hulu Motel" onerror="this.src='https://placehold.co/150x50/white/grey?text=Logo'"></div>
        </div>
    </div>
</section>

<!-- 7. Bottom CTA -->
@include('components.cta')

@include('components.footer')
</main>
