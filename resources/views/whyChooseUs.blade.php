@php
    // Hero banner at the top of the page, also used as the share image (og/twitter).
    $whyHeroImage = 'uploads/why-choose-us-hero.webp';
    $whyHeroImageAlt = 'Go Custom Boxes logo with custom printed shopping bag, perfume box, mailer and gift boxes';

    // Image of the craftsmanship section; it is sized to the height of the text next to it.
    $whyUsImage = 'uploads/why-choose-us-craftsmanship.webp';
    $whyUsImageAlt = 'Black and gold rigid boxes, the Go Custom Boxes foil logo and an offset printing press';

    // FAQs shown on this page (components/faq) and in its FAQPage schema.
    $whyUsFaqs = [
        ['question' => 'What makes Go Custom Boxes different from other packaging suppliers?',
         'answer' => 'We combine the care of a design studio with factory-direct pricing. Every order includes free graphic design support, a digital proof before production, no minimum order quantity, no die or plate charges, and free shipping.'],
        ['question' => 'Is there a minimum order quantity?',
         'answer' => 'No. There is no minimum order quantity (No MOQ), so you can order exactly the number of boxes you need, from a small trial run to a large production order.'],
        ['question' => 'Do you charge for design, dies or printing plates?',
         'answer' => 'No. Our design team helps with your artwork for free, and there are no die or plate charges. Your quote covers your boxes and shipping, with no hidden setup fees.'],
        ['question' => 'Will I see my design before production starts?',
         'answer' => 'Yes. We send a digital proof of your box for approval before anything is printed, and you can request a physical sample or prototype before full production.'],
        ['question' => 'How long does production take?',
         'answer' => 'Standard production takes 8 to 10 business days after you approve the final digital proof. If you have a strict deadline, rush production and shipping options are available.'],
        ['question' => 'Do you offer eco-friendly packaging?',
         'answer' => 'Yes. We use responsibly sourced paperboard, recyclable materials and eco-friendly inks, and we can recommend kraft and other sustainable options that suit your product.'],
    ];
@endphp
@include('components.htmlboilerplate', [
    'image' => $whyHeroImage,
    'imageAlt' => $whyHeroImageAlt,
    'faqs' => $whyUsFaqs,
    'title' => 'Why Choose Us | Go Custom Boxes',
    'metaDescription' => 'Discover why brands choose Go Custom Boxes for custom printed packaging, superior structural strength, wholesale pricing, and reliable delivery.',
    'metaKeywords' => 'why choose go custom boxes, custom packaging benefits, box printing quality',
    'robots' => 'index,follow'
])
<style>
    /* =========================================
       Global Box Sizing (Fixes 100% overflow)
       ========================================= */
    .why-us-section *,
    .trust-us-section *,
    .sustainable-section * {
        box-sizing: border-box;
    }

    /* =========================================
       SECTION 1: Craftsmanship Meets Precision
       ========================================= */
    .why-us-section {
        padding: 2.5rem 0;
        background-color: #faf9f9;
        display: flex;
        justify-content: center;
        overflow: hidden;
    }

    .why-us-section .container {
        max-width: 90rem;
        width: 100%;
        margin: 0 auto;
        padding: 0 5%;
        overflow: hidden;
    }

    .why-us-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2.5rem;
        flex-wrap: wrap;
        overflow: hidden;
    }

    /* Desktop: the image takes the height of the text next to it, never taller. */
    .why-us-section .why-us-content {
        align-items: stretch;
    }

    .why-us-image {
        flex: 1;
        min-width: 0;
        display: flex;
        justify-content: flex-start;
        position: relative;
        min-height: 18rem;
    }

    .why-us-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        max-width: 37.25rem;
        height: 100%;
        border-radius: 1.25rem;
        object-fit: cover;
    }

    .why-us-points {
        list-style: none;
        margin: 1.25rem 0 0;
        padding: 0;
        display: grid;
        gap: 0.75rem;
    }

    .why-us-points li {
        position: relative;
        padding-left: 2rem;
        font-family: 'DM Sans', sans-serif;
        font-size: 1rem;
        line-height: 1.5rem;
        color: var(--section-text-color, #000);
    }

    /* Yellow circle with a navy tick */
    .why-us-points li::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0.125rem;
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        background: #FFB400;
    }

    .why-us-points li::after {
        content: "";
        position: absolute;
        left: 0.45rem;
        top: 0.38rem;
        width: 0.3rem;
        height: 0.55rem;
        border: solid #0B2240;
        border-width: 0 0.125rem 0.125rem 0;
        transform: rotate(45deg);
    }

    .why-us-text {
        flex: 1;
        min-width: 0;
        max-width: 32.625rem;
    }

    .why-us-text h2 {
        font-family: 'Open Sans', sans-serif;
        font-weight: 700;
        font-size: 2rem;
        line-height: 2.5rem;
        letter-spacing: -0.02rem;
        color: var(--section-text-color, #000);
        margin-top: 0;
        margin-bottom: 1.5rem;
    }

    .why-us-text p {
        font-family: 'DM Sans', sans-serif;
        font-weight: 400;
        font-size: 1rem;
        line-height: 1.5rem;
        text-align: justify;
        color: var(--section-text-color, #000);
        margin: 0;
    }

    /* =========================================
       SECTION 2: Why Brands Trust Us
       ========================================= */
    .trust-us-section {
        background-color: var(--secondary-color);
        padding: 1.5rem 0;
    }

    .trust-us-container {
        max-width: 90rem;
        width: 100%;
        margin: 0 auto;
        padding: 0 5%;
    }

    .trust-us-header {
        text-align: center;
        margin-bottom: 1.25rem;
    }

    .trust-us-header h2 {
        font-family: 'Open Sans', sans-serif;
        font-weight: 700;
        font-size: 2rem;
        color: var(--section-text-color);
        margin-bottom: 0.9375rem;
        margin-top: 0;
    }

    .trust-us-header p {
        font-family: 'DM Sans', sans-serif;
        font-weight: 400;
        font-size: 1rem;
        color: var(--section-text-color);
        margin: 0;
        line-height: 1.5;
    }

    .trust-us-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
    }

    .trust-card {
        background: #FFFFFF;
        border: 0.0312rem solid #8D4445;
        border-radius: 0.75rem;
        padding: 1.5rem 1.25rem;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .trust-card:hover {
        transform: translateY(-0.3125rem);
        box-shadow: 0 0.625rem 1.25rem rgba(141, 68, 69, 0.1);
    }

    .trust-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 3.75rem;
        height: 3.75rem;
        border-radius: 50%;
        background-color: var(--secondary-color);
        margin-bottom: 1rem;
    }

    .trust-icon img {
        max-width: 2.1875rem;
        max-height: 2.1875rem;
        object-fit: contain;
    }

    .trust-card h3 {
        font-family: 'Open Sans', sans-serif;
        font-weight: 700;
        font-size: 1rem;
        line-height: 1.2rem;
        color: var(--section-text-color);
        margin-bottom: 0.75rem;
        margin-top: 0;
    }

    .trust-card p {
        font-family: 'DM Sans', sans-serif;
        font-weight: 400;
        font-size: 0.875rem;
        line-height: 1.3562rem;
        letter-spacing: 0.0144rem;
        color: var(--section-text-color);
        margin: 0;
    }

    /* =========================================
       SECTION 3: Sustainable Packaging
       ========================================= */
    .sustainable-section {
        padding: 2.5rem 0;
        background-color: #ffffff;
        display: flex;
        justify-content: center;
    }

    .sustainable-section .container {
        max-width: 90rem;
        width: 100%;
        margin: 0 auto;
        padding: 0 5%;
    }

    .sustainable-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2.5rem;
        flex-wrap: wrap;
    }

    .sustainable-content {
        flex: 1;
        min-width: 0;
        max-width: 32.625rem;
    }

    .sustainable-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .sustainable-badge span {
        font-family: 'Open Sans', sans-serif;
        font-weight: 600;
        font-size: 1rem;
        line-height: 1.5rem;
        letter-spacing: 0.1rem;
        text-transform: uppercase;
        color: #166534;
    }

    .sustainable-content h2 {
        font-family: 'Open Sans', sans-serif;
        font-weight: 700;
        font-size: 2rem;
        color: var(--section-text-color, #000);
        margin: 0 0 1rem 0;
    }

    .sustainable-content p {
        font-family: 'DM Sans', sans-serif;
        font-weight: 400;
        font-size: 1rem;
        line-height: 1.5rem;
        text-align: justify;
        color: var(--section-text-color, #000);
        margin: 0;
    }

    .sustainable-icons {
        display: flex;
        gap: 1.25rem;
        padding-top: 1rem;
    }

    .icon-box {
        width: 4rem;
        height: 4rem;
        border: 1px solid rgba(116, 120, 120, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'DM Sans', sans-serif;
        font-weight: 600;
        font-size: 1rem;
        line-height: 1.5rem;
        color: var(--section-text-color);
    }

    .sustainable-image {
        flex: 1;
        min-width: 0;
        display: flex;
        justify-content: flex-end;
    }

    .sustainable-image img {
        width: 100%;
        max-width: 30.8125rem;
        height: auto;
        aspect-ratio: 493 / 448;
        border-radius: 1.25rem;
        object-fit: cover;
    }

    /* =========================================
       Responsive Styles
       ========================================= */
    @media (max-width: 68.75rem) {
        .why-us-content, .sustainable-wrapper {
            flex-direction: column;
            text-align: left;
        }

        .sustainable-wrapper {
            flex-direction: column-reverse;
        }

        .why-us-image, .sustainable-image {
            justify-content: center;
            width: 100%;
            min-width: 0;
        }

        .why-us-image img,
        .sustainable-image img {
            max-width: 100%;
        }

        /* Stacked layout: the image keeps its own shape above the text. */
        .why-us-image {
            position: static;
            min-height: 0;
        }

        .why-us-image img {
            position: static;
            height: auto;
            aspect-ratio: 16 / 10;
        }

        .why-us-text, .sustainable-content {
            max-width: 100%;
            min-width: 0;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .why-us-text p, .sustainable-content p {
            text-align: left;
        }

        .trust-us-container {
            padding: 0 5%;
        }

        .trust-us-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
        }
    }

    @media (max-width: 47.9375rem) {
        .why-us-section,
        .trust-us-section,
        .sustainable-section {
            padding: 1.5rem 0;
        }

        .why-us-section .container,
        .sustainable-section .container,
        .trust-us-container {
            padding: 0 1.25rem;
        }

        .why-us-content {
            gap: 2rem;
        }

        .why-us-image {
            width: 100%;
            min-width: 0;
        }

        .why-us-image img {
            width: 100%;
            max-width: 100%;
            height: auto;
            border-radius: 0.75rem;
        }

        .why-us-text {
            width: 100%;
            min-width: 0;
            max-width: 100%;
        }

        .why-us-text h2 {
            font-size: 1.5rem;
            line-height: 2rem;
            margin-bottom: 1rem;
            text-align: left;
        }

        .why-us-text p {
            font-size: 0.9375rem;
            line-height: 1.5rem;
            text-align: left;
        }

        .trust-us-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .trust-us-header h2 {
            font-size: 1.5rem;
            margin-bottom: 0.625rem;
        }

        .trust-us-header p {
            font-size: 0.875rem;
        }

        .trust-card {
            width: 100%;
            margin: 0 auto;
            border-radius: 0.75rem;
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .trust-icon {
            width: 4.375rem;
            height: 4.375rem;
            margin-bottom: 1rem;
        }

        .trust-icon img {
            max-width: 2.1875rem;
            max-height: 2.1875rem;
        }

        .trust-card h3 {
            font-size: 1.0625rem;
            font-weight: 700;
            margin-bottom: 0.625rem;
            text-align: center;
        }

        .trust-card p {
            font-size: 0.875rem;
            line-height: 1.5;
            text-align: center;
        }

        .trust-us-header p br {
            display: none;
        }

        .sustainable-wrapper {
            gap: 2rem;
        }

        .sustainable-content {
            min-width: 0;
            width: 100%;
        }

        .sustainable-content h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .sustainable-content p {
            font-size: 0.9375rem;
            text-align: left;
        }

        .sustainable-icons {
            justify-content: flex-start;
        }
    }

    @media (max-width: 30rem) {
        .why-us-text p,
        .sustainable-content p {
            font-size: 0.875rem;
        }

        .why-us-text h2,
        .sustainable-content h2,
        .trust-us-header h2 {
            font-size: 1.375rem;
        }
    }
</style>
<main class="why-choose-us">

@include('components.header')
<x-about-hero
    title="Why Choose Go Custom Boxes"
    description="From free design support and no minimum order quantity to fast production and free shipping, we make custom packaging simple, affordable, and built around your brand."
    :bgImage="$whyHeroImage"
    mobileBgImage="uploads/why-choose-us-hero-mobile.webp"
    breadcrumb="Why Choose Us"
    overlay="rgba(10, 34, 64, 0.55)"
/>
<!-- Section 1: Craftsmanship -->
<section class="why-us-section">
    <div class="container">
        <div class="why-us-content">
            <div class="why-us-image">
                <img src="{{ asset($whyUsImage) }}" alt="{{ $whyUsImageAlt }}" width="1280" height="800" loading="lazy">
            </div>
            <div class="why-us-text">
                <h2>Studio-Level Craftsmanship, Factory-Direct Scale</h2>
                <p>Every order gets the attention of a dedicated packaging studio and the capacity of a full production facility. Our team helps you choose the right structure, material, and finish, checks your artwork, and prints your boxes on commercial offset and digital presses, so a small trial order looks as good as a run of 10,000.</p>
                <ul class="why-us-points">
                    <li>Free design support and a digital proof before we print</li>
                    <li>No minimum order quantity (No MOQ) and no die or plate charges</li>
                    <li>Premium finishes: foil stamping, embossing, spot UV, and soft-touch</li>
                    <li>Production in 8 to 10 business days after proof approval, plus free shipping</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Section 2: Why Brands Trust Us -->
<section class="trust-us-section">
    <div class="trust-us-container">
        <div class="trust-us-header">
            <h2>Why Brands Trust Us</h2>
            <p>Every advantage is designed to make your packaging procurement seamless,<br>cost-effective, and world-class.</p>
        </div>
        <div class="trust-us-grid">
            <div class="trust-card">
                <span class="trust-icon">
                    <img src="{{ asset('uploads/no-die-plate-charges.svg') }}" alt="No Die & Plate Charges" loading="lazy">
                </span>
                <h3>No Die & Plate Charges</h3>
                <p>No added tooling fees, just straightforward pricing</p>
            </div>

            <div class="trust-card">
                <span class="trust-icon">
                    <img src="{{ asset('uploads/customer-satisfaction.svg') }}" alt="Customer Satisfaction" loading="lazy">
                </span>
                <h3>Customer Satisfaction</h3>
                <p>Built on trust, quality, and long term partnerships.</p>
            </div>

            <div class="trust-card">
                <span class="trust-icon">
                    <img src="{{ asset('uploads/low-minimum-order-quantity.svg') }}" alt="No Minimum Order Quantity" loading="lazy">
                </span>
                <h3>No Minimum Order Quantity</h3>
                <p>Order exactly the quantity you need, big or small.</p>
            </div>

            <div class="trust-card">
                <span class="trust-icon">
                    <img src="{{ asset('uploads/free-shipping.svg') }}" alt="Free Shipping" loading="lazy">
                </span>
                <h3>Free Shipping</h3>
                <p>No shipping costs, no last-minute surprises.</p>
            </div>

            <div class="trust-card">
                <span class="trust-icon">
                    <img src="{{ asset('uploads/free-graphic-design.svg') }}" alt="Free Graphic Design">
                </span>
                <h3>Free Graphic Design</h3>
                <p>Professional designs at no extra cost.</p>
            </div>

            <div class="trust-card">
                <span class="trust-icon">
                    <img src="{{ asset('uploads/fast-turn-around.svg') }}" alt="Fast Turnaround Time">
                </span>
                <h3>Fast Turnaround Time</h3>
                <p>Quick production with consistent quality.</p>
            </div>
        </div>
    </div>
</section>

<!-- Section 3: Sustainable Packaging (Footer Se Pehle) -->
<section class="sustainable-section">
    <div class="container">
        <div class="sustainable-wrapper">
            <div class="sustainable-content">
                <div class="sustainable-badge">
                    <img src="{{ asset('uploads/ethically-manufactured.svg') }}" alt="Ethically Manufactured" width="20" height="20">
                    <span>ETHICALLY MANUFACTURED</span>
                </div>
                <h2>Sustainable Packaging</h2>
                <p>Every box is produced with responsibly sourced materials, recyclable paperboard, and eco-friendly inks. We combine premium craftsmanship with sustainable practices to help your brand reduce its environmental impact without compromising on quality.</p>
                <div class="sustainable-icons">
                    <div class="icon-box">FSC</div>
                    <div class="icon-box">ISO</div>
                    <div class="icon-box">PEFC</div>
                </div>
            </div>
            <div class="sustainable-image">
                <img src="{{ asset('uploads/sustainable-packaging.png') }}" alt="Sustainable Packaging">
            </div>
        </div>
    </div>
</section>

@include('components.faq', ['faqs' => $whyUsFaqs])
@include('components.cta')
@include('components.footer')

</main>
