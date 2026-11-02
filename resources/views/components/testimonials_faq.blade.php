<style>
    .testimonials-faq-section {
        background: var(--background-color, #FAF8F8);
        padding: 3.75rem 0 1.25rem 0;
        font-family: 'DM Sans', sans-serif;
    }

    .testimonials-faq-container {
        max-width: var(--site-container-width, 80rem);
        margin: 0 auto;
        padding: 0 var(--site-container-gutter, 3.4375rem);
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3.75rem;
    }

    /* Left Column: Testimonials */
    .testimonials-col, .faq-col {
        width: 100%;
        max-width: 35rem;
    }

    .testimonials-col {
        height: 38.6456rem;
        contain: layout paint;
    }

    .faq-col {
        height: auto;
    }

    .testimonials-col h2, .faq-col h2 {
        font-family: 'Open Sans', sans-serif;
        font-weight: 700;
        font-size: 2rem;
        color: var(--primary-color, #0B2240);
        margin-bottom: 1.875rem;
    }

    .testimonial-cards-wrap {
        display: grid;
        grid-template-rows: repeat(2, 14.75rem);
        grid-auto-columns: 100%;
        grid-auto-flow: column;
        gap: 1.5rem;
        height: 31rem; /* Exactly fits 2 cards + 1 gap */
        overflow-x: auto;
        overflow-y: hidden;
        scroll-snap-type: x mandatory;
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none;  /* Internet Explorer 10+ */
    }

    .testimonial-cards-wrap::-webkit-scrollbar { 
        display: none; /* Safari and Chrome */
    }

    .tf-testimonial-card {
        width: 100%;
        max-width: 35rem;
        height: 14.75rem;
        background-color: #FFF8E7;
        border-radius: 0.75rem;
        padding: 1.875rem;
        box-shadow: none;
        scroll-snap-align: start;
        flex-shrink: 0;
        box-sizing: border-box;
    }

    .tf-stars {
        color: #FFB400;
        font-size: 1rem;
        margin-bottom: 0.875rem;
        letter-spacing: 0.125rem;
    }
    
    .tf-stars span.gray {
        color: #ddd;
    }

    .tf-quote {
        font-size: 0.9062rem;
        line-height: 1.6;
        color: #000;
        margin-bottom: 1.25rem;
        font-style: normal;
    }

    .tf-author-area {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .tf-author-initial {
        width: 2.25rem;
        height: 2.25rem;
       
        border-radius: 50%;
        color: #E25C5C;
        font-weight: 700;
        font-size: 0.9375rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .tf-author-details {
        display: flex;
        flex-direction: column;
    }

    .tf-author-name {
        font-family: 'Open Sans', sans-serif;
        font-weight: 700;
        font-size: 0.9375rem;
        color: #0B2240;
    }

    .tf-author-title {
        font-size: 0.7812rem;
        color: #777;
    }

    .tf-pagination {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1.5625rem;
    }

    .tf-dot {
        width: 0.375rem;
        height: 0.375rem;
        background: #D9D9D9;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .tf-dot.active {
        width: 1.5rem;
        height: 0.375rem;
        border-radius: 0.1875rem;
        background: #0B2240;
    }

    /* Right Column: FAQs */
    .tf-accordion {
        display: flex;
        flex-direction: column;
    }

    .tf-accordion-item {
        border-bottom: 1px solid #888;
    }

    .tf-accordion-btn {
        width: 100%;
        max-width: 35rem;
        height: 3.3125rem;
        background: transparent;
        border: none;
        padding: 0;
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        font-weight: 500;
        font-size: 1.125rem;
        color: var(--primary-color, #000);
        text-align: left;
    }

    .tf-accordion-btn svg {
        width: 1.2rem;
        height: 1.2rem;
        transition: transform 0.3s ease;
        stroke: #666;
        fill: none;
    }

    .tf-accordion-item.active .tf-accordion-btn svg {
        transform: rotate(180deg);
    }

    .tf-accordion-item.active .tf-accordion-btn::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 1px;
        background-color: #888;
    }

    .tf-accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .tf-accordion-content-inner {
        padding-top: 1.5rem;
        padding-bottom: 1.25rem;
        font-size: 0.9062rem;
        line-height: 1.5;
        color: #000;
        text-align: justify;
    }

    @media (max-width: 62rem) {
        .testimonials-faq-section {
            /* Top padding matches the h2 margin-bottom so the heading has equal space above and below */
            padding: 1.875rem 0 2.5rem 0;
            overflow: hidden;
            width: 100%;
        }
        .testimonials-faq-container {
            grid-template-columns: 100%;
            gap: 2.5rem;
            padding: 0 1rem;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            overflow: hidden;
        }
        .testimonials-col {
            height: auto;
            width: 100%;
            max-width: 100%;
            min-width: 0;
            contain: none;
            box-sizing: border-box;
        }
        .testimonials-col h2 {
            width: 90vw;
            max-width: 100vw;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }
        .faq-col { display: none; }
        .testimonial-cards-wrap {
            display: flex;
            flex-direction: row;
            width: 100%;
            max-width: 100%;
            min-width: 0;
            overflow-x: auto;
            overflow-y: hidden;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            height: auto;
            gap: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-overflow-scrolling: touch;
        }
        .tf-testimonial-card {
            flex: 0 0 100%;
            width: 100%;
            max-width: 100%;
            min-width: 100%;
            height: auto;
            min-height: auto;
            padding: 1.5rem;
            box-sizing: border-box;
            scroll-snap-align: start;
        }
        .tf-quote {
            font-size: 0.875rem;
            line-height: 1.6;
            margin-bottom: 1.125rem;
            text-align: left;
        }
        .tf-pagination {
            justify-content: center;
            margin-top: 1.125rem;
            gap: 0.5rem;
        }
    }
</style>

<section class="testimonials-faq-section">
    <div class="testimonials-faq-container">
        <!-- Left: Testimonials -->
        <div class="testimonials-col">
            <h2>What Our Clients Say</h2>
            <div class="testimonial-cards-wrap">
                <!-- Card 1 -->
                <div class="tf-testimonial-card">
                    <div class="tf-stars">★★★★<span class="gray">★</span></div>
                    <p class="tf-quote">"Beautiful custom boxes that perfectly represent our brand. The foil stamping and matte finish give our products a luxury feel. Highly recommend for any beauty brand."</p>
                    <div class="tf-author-area">
                        <div class="tf-author-initial">E</div>
                        <div class="tf-author-details">
                            <span class="tf-author-name">Emily Rodriguez</span>
                            <span class="tf-author-title">Gloom Cosmetics</span>
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="tf-testimonial-card">
                    <div class="tf-stars">★★★★<span class="gray">★</span></div>
                    <p class="tf-quote">"Beautiful custom boxes that perfectly represent our brand. The foil stamping and matte finish give our products a luxury feel. Highly recommend for any beauty brand."</p>
                    <div class="tf-author-area">
                        <div class="tf-author-initial">E</div>
                        <div class="tf-author-details">
                            <span class="tf-author-name">Emily Rodriguez</span>
                            <span class="tf-author-title">Gloom Cosmetics</span>
                        </div>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="tf-testimonial-card">
                    <div class="tf-stars">★★★★★</div>
                    <p class="tf-quote">"Outstanding quality and incredible customer service! The team helped us perfect our design and the final boxes exceeded our expectations. Will definitely order again."</p>
                    <div class="tf-author-area">
                        <div class="tf-author-initial">M</div>
                        <div class="tf-author-details">
                            <span class="tf-author-name">Michael Chen</span>
                            <span class="tf-author-title">TechGear Pro</span>
                        </div>
                    </div>
                </div>
            <!-- Card 4 -->
                <div class="tf-testimonial-card">
                    <div class="tf-stars">★★★★<span class="gray">★</span></div>
                    <p class="tf-quote">"The turnaround time was amazingly fast without compromising on the quality. These custom mailer boxes have completely elevated our unboxing experience."</p>
                    <div class="tf-author-area">
                        <div class="tf-author-initial">S</div>
                        <div class="tf-author-details">
                            <span class="tf-author-name">Sarah Jenkins</span>
                            <span class="tf-author-title">Artisan Coffee Co.</span>
                        </div>
                    </div>
                </div>
                <!-- Card 5 -->
                <div class="tf-testimonial-card">
                    <div class="tf-stars">★★★★★</div>
                    <p class="tf-quote">"I was amazed by the eco-friendly materials and vibrant colors! The structural integrity of the boxes is top-notch. Highly recommended for sustainable brands."</p>
                    <div class="tf-author-area">
                        <div class="tf-author-initial">D</div>
                        <div class="tf-author-details">
                            <span class="tf-author-name">David Lawson</span>
                            <span class="tf-author-title">Nature's Essence</span>
                        </div>
                    </div>
                </div>
                <!-- Card 6 -->
                <div class="tf-testimonial-card">
                    <div class="tf-stars">★★★★★</div>
                    <p class="tf-quote">"Perfectly tailored to our product specifications. The custom inserts fit our fragile items securely. Very happy with the final packaging solution!"</p>
                    <div class="tf-author-area">
                        <div class="tf-author-initial">A</div>
                        <div class="tf-author-details">
                            <span class="tf-author-name">Amanda Brooks</span>
                            <span class="tf-author-title">Crystal Clear</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="tf-pagination">
                <!-- Dots generated by JS -->
            </div>
        </div>

        @php
            $displayFaqs = isset($category) ? ($faqs ?? []) : ($settings['faqs'] ?? []);
        @endphp
        @if(count($displayFaqs))
            <div class="faq-col">
                <h2>Frequently Asked Questions</h2>
                <div class="tf-accordion">
                    @foreach($displayFaqs as $faq)
                        <div class="tf-accordion-item">
                            <h3 style="margin: 0; padding: 0;">
<button class="tf-accordion-btn" type="button" onclick="toggleTfFaq(this)">
                                {{ is_array($faq) ? ($faq['question'] ?? '') : ($faq->question ?? '') }}
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </button>
</h3>
                            <div class="tf-accordion-content">
                                <div class="tf-accordion-content-inner">{!! nl2br(e(is_array($faq) ? ($faq['answer'] ?? '') : ($faq->answer ?? ''))) !!}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

<script>
    function toggleTfFaq(btn) {
        const item = btn.closest('.tf-accordion-item');
        const content = item.querySelector('.tf-accordion-content');
        
        // Close others
        document.querySelectorAll('.tf-accordion-item').forEach(other => {
            if (other !== item) {
                other.classList.remove('active');
                other.querySelector('.tf-accordion-content').style.maxHeight = null;
            }
        });
        
        // Toggle current
        if (item.classList.contains('active')) {
            item.classList.remove('active');
            content.style.maxHeight = null;
        } else {
            item.classList.add('active');
            content.style.maxHeight = content.scrollHeight + "px";
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const cardWrap = document.querySelector('.testimonial-cards-wrap');
        const pagination = document.querySelector('.tf-pagination');
        const cards = document.querySelectorAll('.tf-testimonial-card');
        let dots = [];
        let currentDot = 0;
        let autoSlideInterval;

        function initPagination() {
            if (!pagination || !cardWrap) return;
            
            let isMobile = window.innerWidth <= 992;
            let itemsPerPage = isMobile ? 1 : 2;
            let totalPages = Math.ceil(cards.length / itemsPerPage);
            
            if (dots.length !== totalPages) {
                pagination.innerHTML = '';
                dots = [];
                for(let i=0; i<totalPages; i++) {
                    let d = document.createElement('div');
                    d.className = 'tf-dot' + (i === 0 ? ' active' : '');
                    pagination.appendChild(d);
                    dots.push(d);
                    
                    d.addEventListener('click', () => {
                        let cardWidth = cardWrap.offsetWidth;
                        let gap = isMobile ? 0 : 24;
                        cardWrap.scrollTo({ left: i * (cardWidth + gap), behavior: 'smooth' });
                        dots.forEach(dot => dot.classList.remove('active'));
                        d.classList.add('active');
                        currentDot = i;
                    });
                }
            }
        }
        
        initPagination();
        window.addEventListener('resize', initPagination);

        // On scroll, sync active dot
        if (cardWrap) {
            cardWrap.addEventListener('scroll', () => {
                let isMobile = window.innerWidth <= 992;
                let cardWidth = cardWrap.offsetWidth;
                let gap = isMobile ? 0 : 24;
                let activeIndex = Math.round(cardWrap.scrollLeft / (cardWidth + gap));
                if (dots[activeIndex] && !dots[activeIndex].classList.contains('active')) {
                    dots.forEach(dot => dot.classList.remove('active'));
                    dots[activeIndex].classList.add('active');
                    currentDot = activeIndex;
                }
            }, { passive: true });
        }

        // Auto slide every 4 seconds
        autoSlideInterval = setInterval(() => {
            if (cardWrap && dots.length > 0) {
                currentDot = (currentDot + 1) % dots.length;
                let isMobile = window.innerWidth <= 992;
                let cardWidth = cardWrap.offsetWidth;
                let gap = isMobile ? 0 : 24;
                cardWrap.scrollTo({ left: currentDot * (cardWidth + gap), behavior: 'smooth' });
                
                dots.forEach(dot => dot.classList.remove('active'));
                dots[currentDot].classList.add('active');
            }
        }, 4000);
    });
</script>
