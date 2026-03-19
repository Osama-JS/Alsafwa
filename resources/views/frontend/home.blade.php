@extends('frontend.layouts.app')

@section('title', __('الرئيسية'))

@section('content')



{{-- ================================================================
     HERO SLIDER SECTION
     ================================================================ --}}
<section class="hero-slider-section">
    <div class="swiper heroSwiper">
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
                <div class="swiper-slide">
                    <div class="hero-slide" style="background-image: url('{{ $slider->image && Storage::disk('public')->exists($slider->image) ? asset('storage/' . $slider->image) : asset('images/hero-fallback.jpg') }}');">
                        <div class="hero-slide-overlay"></div>
                        <div class="container hero-slide-content">
                            <div class="hero-text-box">
                                @if($slider->{'subtitle_' . app()->getLocale()})
                                    <span class="hero-badge">{{ $slider->{'subtitle_' . app()->getLocale()} }}</span>
                                @endif
                                <h1 class="hero-main-title">{{ $slider->{'title_' . app()->getLocale()} }}</h1>
                                <div class="hero-cta-group">
                                    <a href="{{ $slider->link ?: route('services.index') }}" class="btn-hero-primary">
                                        {{ $slider->{'button_text_' . app()->getLocale()} ?: __('اكتشف المزيد') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="swiper-button-prev hero-nav-prev"></div>
        <div class="swiper-button-next hero-nav-next"></div>
        <div class="swiper-pagination hero-pagination"></div>

        <div class="hero-slide-counter">
            <span class="current-num">1</span> / <span class="total-num">{{ $sliders->count() }}</span>
        </div>
    </div>
</section>


{{-- ================================================================
     GLOWING STATS
     ================================================================ --}}
<section class="stats-legendary">
    <div class="container">
        <div class="row g-4 justify-content-center">
            @foreach($counters as $counter)
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="stat-card-premium">
                        <div class="stat-icon-wrapper-premium">
                            <i class="{{ $counter->icon ?? 'fas fa-star' }}"></i>
                        </div>
                        <div class="stat-number-mega stat-number"
                             data-target="{{ $counter->value }}"
                             data-suffix="+">0+</div>
                        <div class="stat-title-premium text-uppercase">
                            {{ $counter->{'title_' . app()->getLocale()} }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ================================================================
     SERVICES: 3D PERSPECTIVE
     ================================================================ --}}
<section class="section-legendary">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-lg-7" data-aos="fade-up">
                <span class="section-suptitle">{{ __('ما نتميز به') }}</span>
                <h2 class="section-maintitle">{{ __('خدماتنا المصممة') }} <br> {{ __('لطموحك') }}</h2>
            </div>
            <div class="col-lg-5 text-lg-end mb-4" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ route('services.index') }}" class="btn-primary-site">{{ __('عرض الكل') }} <i class="fas fa-arrow-left ms-2"></i></a>
            </div>
        </div>

        <div class="service-grid-legendary">
            @forelse($services as $service)
                <div class="service-card-v3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <img src="{{ $service->image ? asset('storage/' . $service->image) : 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80' }}" class="service-cover" alt="{{ $service->title_ar }}">
                    <div class="service-float-body">
                        <div class="service-icon-box">
                            <i class="{{ $service->icon ?: 'fas fa-rocket' }}"></i>
                        </div>
                        <h3 class="fw-black mb-3">{{ $service->{'title_' . app()->getLocale()} }}</h3>
                        <p class="opacity-75 mb-4">{{ Str::limit($service->{'description_' . app()->getLocale()}, 120) }}</p>
                        <a href="{{ route('services.show', $service->slug) }}" class="btn-legendary py-2 px-4 fs-6">
                            {{ __('التفاصيل') }}
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12 py-5 text-center opacity-50">
                    <i class="fas fa-cubes fs-1 mb-3"></i>
                    <p>{{ __('تم تحديث الخدمات قريباً') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ================================================================
     AGENCIES: LOGO MARQUEE
     ================================================================ --}}
<section class="section-legendary bg-primary-dark">
    <div class="container text-center mb-5">
        <span class="section-suptitle text-accent">{{ __('شراكاتنا') }}</span>
        <h2 class="text-white fw-black">{{ __('الوكالات التي نفخر بتمثيلها') }}</h2>
    </div>
    <div class="container overflow-hidden">
        <div class="swiper agenciesSwiper">
            <div class="swiper-wrapper align-items-center">
                @forelse($agencies as $agency)
                    <div class="swiper-slide px-4">
                        <img src="{{ asset('storage/' . $agency->logo) }}" class="agency-logo-v3" alt="{{ $agency->{'name_' . app()->getLocale()} }}">
                    </div>
                @empty
                    <div class="text-center text-white py-5 w-100">
                        <i class="fas fa-handshake fs-1 mb-3 opacity-50"></i>
                        <p class="opacity-75">{{ __('لا توجد وكالات حالياً') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     ABOUT: LEGENDARY STORY
     ================================================================ --}}
@if($about)
<section class="section-legendary" style="background: var(--white); border-radius: var(--radius-xl) var(--radius-xl) 0 0; margin-top: -40px; position: relative; z-index: 5;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="position-relative">
                    <img src="{{ $about->image ? asset('storage/' . $about->image) : 'https://images.unsplash.com/photo-1573164067507-406cd9ad4b6a?w=800&q=80' }}" class="rounded-5 shadow-strong" alt="About">
                    <div class="floating-experience-card" data-aos="zoom-in" data-aos-delay="300">
                        <span class="fs-1 fw-black d-block text-accent">14+</span>
                        <span class="text-white opacity-75 text-uppercase fw-bold">{{ __('عام من الخبرة') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <span class="section-suptitle">{{ __('قصة النجاح') }}</span>
                <h2 class="section-maintitle">{{ $about->{'title_' . app()->getLocale()} }}</h2>
                <div class="typography-rich mb-4">
                    {!! Str::limit(strip_tags($about->{'content_' . app()->getLocale()}), 450) !!}
                </div>
                <a href="{{ route('about') }}" class="btn-legendary">{{ __('إقرأ المزيد عن قصتنا') }}</a>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ================================================================
     ACTIVITIES: CLEAN GRID
     ================================================================ --}}
<section class="section-legendary bg-off-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <span class="section-suptitle">{{ __('الأخبار والفعاليات') }}</span>
                <h2 class="section-maintitle mb-0">{{ __('أحدث أخبارنا') }}</h2>
            </div>
            <a href="{{ route('activities.index') }}" class="text-primary fw-bold">{{ __('المركز الإعلامي') }} <i class="fas fa-arrow-left ms-2"></i></a>
        </div>
        <div class="row g-4">
            @forelse($activities as $activity)
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="activity-card-minimal">
                        <div class="activity-date">{{ $activity->created_at->format('d M, Y') }}</div>
                        <img src="{{ asset('storage/' . $activity->image) }}" class="activity-img" alt="{{ $activity->{'title_' . app()->getLocale()} }}">
                        <div class="p-4">
                            <h4 class="fw-bold fs-5 mb-3">{{ $activity->{'title_' . app()->getLocale()} }}</h4>
                            <p class="text-muted text-sm">{{ Str::limit($activity->{'description_' . app()->getLocale()}, 100) }}</p>
                            <a href="{{ route('activities.show', $activity->slug) }}" class="text-accent fw-bold text-sm">{{ __('اقرأ المزيد') }}</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 py-5 text-center opacity-50">
                    <i class="fas fa-calendar-alt fs-1 mb-3"></i>
                    <p>{{ __('لا توجد أنشطة حالياً') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ================================================================
     FEATURED PRODUCTS
     ================================================================ --}}
@if($products->count() > 0)
<section class="section-legendary">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-lg-7" data-aos="fade-up">
                <span class="section-suptitle">{{ __('منتجاتنا') }}</span>
                <h2 class="section-maintitle">{{ __('أبرز المنتجات') }}</h2>
            </div>
            <div class="col-lg-5 text-lg-end mb-4" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ route('products.index') }}" class="btn-primary-site">{{ __('عرض الكل') }} <i class="fas fa-arrow-left ms-2"></i></a>
            </div>
        </div>

        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                        <div class="product-card-home">
                            <div class="product-card-home-img-wrap">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->{'title_' . app()->getLocale()} }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                        <i class="fas fa-box fs-1 opacity-25"></i>
                                    </div>
                                @endif
                                @if($product->discount && $product->price)
                                    <span class="product-sale-badge">{{ __('خصم') }}</span>
                                @endif
                            </div>
                            <div class="product-card-home-body">
                                @if($product->agency)
                                    <span class="product-agency-tag">{{ $product->agency->{'name_' . app()->getLocale()} }}</span>
                                @endif
                                <h4 class="product-card-home-title">{{ $product->{'title_' . app()->getLocale()} }}</h4>
                                @if($product->price)
                                    <div class="d-flex align-items-center gap-2">
                                        @if($product->discount)
                                            <span class="text-decoration-line-through opacity-50 small">{{ number_format($product->price, 2) }}</span>
                                            <span class="fw-black" style="color:var(--accent-dark);">{{ number_format($product->final_price, 2) }} {{ __('ر.س') }}</span>
                                        @else
                                            <span class="fw-black" style="color:var(--accent-dark);">{{ number_format($product->price, 2) }} {{ __('ر.س') }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================================================================
     CONTACT CALL-OUT
     ================================================================ --}}
<section class="section-legendary text-center" data-aos="zoom-in">
    <div class="container">
        <div class="cta-box-legendary">
            <h2 class="fw-black text-white mb-4 fs-1">{{ __('هل أنت جاهز للبدء؟') }}</h2>
            <p class="text-white opacity-75 mb-5 fs-5 max-w-600 mx-auto">{{ __('نحن هنا لتحويل تطلعاتك إلى واقع ملموس. فريقنا المتخصص بانتظارك.') }}</p>
            <a href="{{ route('contact') }}" class="btn-legendary btn-lg">{{ __('تواصل معنا الآن') }}</a>
        </div>
    </div>
</section>

    {{-- ── Partners Section ── --}}
    @if(isset($partners) && $partners->count() > 0)
    <section class="partners-section py-5" style="background: rgba(var(--primary-rgb), 0.02);">
        <div class="container" data-aos="fade-up">
            <div class="section-header text-center mb-5">
                <h6 class="text-primary text-uppercase fw-bold mb-2">{{ app()->getLocale() == 'ar' ? 'شركاء النجاح' : 'Success Partners' }}</h6>
                <h2 class="fw-bold">{{ app()->getLocale() == 'ar' ? 'نعتز بثقتهم' : 'Our Trusted Partners' }}</h2>
            </div>

            <!-- Partners Swiper -->
            <div class="swiper partnersSwiper">
                <div class="swiper-wrapper align-items-center">
                    @foreach($partners as $partner)
                    <div class="swiper-slide text-center px-4">
                        @if($partner->url)
                            <a href="{{ $partner->url }}" target="_blank" class="partner-logo-link">
                        @endif
                        <img src="{{ asset('storage/' . $partner->logo) }}" 
                             alt="{{ $partner->name_ar }}" 
                             class="img-fluid partner-logo grayscale hover-color transition-300" 
                             style="max-height: 80px; width: auto; object-fit: contain;">
                        @if($partner->url)
                            </a>
                        @endif
                    </div>
                    @endforeach
                </div>
                <!-- Pagination if needed -->
                {{-- <div class="swiper-pagination mt-4"></div> --}}
            </div>
        </div>
    </section>

    @push('styles')
    <style>
        .partner-logo {
            filter: grayscale(100%);
            opacity: 0.6;
            transition: all 0.4s ease;
        }
        .partner-logo:hover {
            filter: grayscale(0%);
            opacity: 1;
            transform: scale(1.05);
        }
        .partner-logo-link {
            display: inline-block;
        }
    </style>
    @endpush

    @endif

@endsection

@push('styles')
<style>
    /* ──────────────────────────────────────────
       HERO SLIDER
    ────────────────────────────────────────── */
    .hero-slider-section {
        position: relative;
        width: 100%;
        height: 100vh;
        min-height: 600px;
        max-height: 900px;
        overflow: hidden;
    }
    .heroSwiper {
        width: 100%;
        height: 100%;
    }
    .heroSwiper .swiper-wrapper {
        width: 100%;
        height: 100%;
    }
    .heroSwiper .swiper-slide {
        width: 100%;
        height: 100%;
        flex-shrink: 0;
    }

    .hero-slide {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
        display: flex;
        align-items: center;
    }
    .hero-slide-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(10,25,55,0.85) 0%, rgba(10,30,70,0.5) 60%, rgba(0,0,0,0.2) 100%);
    }
    .hero-slide-content {
        position: relative;
        z-index: 5;
        padding-top: 120px;
        padding-bottom: 60px;
    }
    .hero-text-box {
        max-width: 750px;
    }
    .hero-badge {
        display: inline-flex;
        align-items: center;
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 1px;
        margin-bottom: 1.5rem;
    }
    .hero-main-title {
        color: #fff;
        font-size: clamp(2.2rem, 5vw, 4rem);
        font-weight: 900;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        text-shadow: 0 4px 30px rgba(0,0,0,0.3);
    }
    .hero-divider {
        width: 80px;
        height: 4px;
        border-radius: 4px;
        background: var(--accent, #c9a84c);
        margin-bottom: 2rem;
    }
    .hero-cta-group { display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; }
    .btn-hero-primary {
        display: inline-flex;
        align-items: center;
        background: var(--accent, #c9a84c);
        color: #0f1e3d;
        padding: 16px 36px;
        border-radius: 50px;
        font-weight: 800;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 8px 30px rgba(201,168,76,0.35);
    }
    .btn-hero-primary:hover {
        background: #e8c96a;
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(201,168,76,0.5);
        color: #0f1e3d;
    }
    .btn-hero-secondary {
        display: inline-flex;
        align-items: center;
        border: 2px solid rgba(255,255,255,0.5);
        color: #fff;
        padding: 14px 32px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        backdrop-filter: blur(4px);
    }
    .btn-hero-secondary:hover {
        border-color: #fff;
        background: rgba(255,255,255,0.15);
        color: #fff;
        transform: translateY(-3px);
    }

    /* ── Nav Arrows (Swiper standard buttons, custom styled) ── */
    .hero-nav-prev,
    .hero-nav-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 100;
        width: 54px;
        height: 54px;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(8px);
        border: 1.5px solid rgba(255,255,255,0.3);
        color: #fff;
        transition: all 0.3s ease;
        margin: 0;
        cursor: pointer;
        pointer-events: auto !important;
    }
    .hero-nav-prev::after,
    .hero-nav-next::after {
        font-size: 1.1rem;
        font-weight: 900;
        color: #fff;
    }
    .hero-nav-prev:hover,
    .hero-nav-next:hover {
        background: var(--accent, #c9a84c);
        border-color: var(--accent, #c9a84c);
    }
    .hero-nav-prev:hover::after,
    .hero-nav-next:hover::after { color: #0f1e3d; }
    .hero-nav-prev { left: 30px !important; right: auto !important; }
    .hero-nav-next { right: 30px !important; left: auto !important; }
    @media (max-width: 767px) {
        .hero-nav-prev { left: 12px !important; }
        .hero-nav-next { right: 12px !important; }
    }

    /* ── Pagination ── */
    .hero-pagination {
        bottom: 30px !important;
        z-index: 20;
    }
    .hero-pagination .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        background: rgba(255,255,255,0.4);
        opacity: 1;
        border-radius: 50px;
        transition: all 0.3s ease;
    }
    .hero-pagination .swiper-pagination-bullet-active {
        background: var(--accent, #c9a84c);
        width: 30px;
    }

    /* ── Slide Counter ── */
    .hero-slide-counter {
        position: absolute;
        bottom: 30px;
        inset-inline-start: 30px;
        z-index: 20;
        color: rgba(255,255,255,0.6);
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 2px;
    }
    .hero-slide-counter .current-num {
        color: var(--accent, #c9a84c);
        font-size: 1.4rem;
        font-weight: 900;
        line-height: 1;
    }

    /* ── Responsive ── */
    @media (max-width: 767px) {
        .hero-slider-section { height: 100svh; max-height: 700px; }
        .hero-main-title { font-size: 2rem; }
        .btn-hero-primary, .btn-hero-secondary { padding: 12px 24px; font-size: 0.9rem; }
        .hero-nav-btn { width: 40px; height: 40px; font-size: 0.9rem; }
        .hero-prev { inset-inline-start: 12px; }
        .hero-next { inset-inline-end: 12px; }
        .hero-slide-counter { display: none; }
    }

    /* ── Other ── */
    .stat-label-v3 { font-weight: 800; text-transform: uppercase; letter-spacing: 2px; font-size: 0.8rem; opacity: 0.5; }
    .fw-black { font-weight: 900; }
    .max-w-600 { max-width: 600px; }
    .floating-experience-card {
        position: absolute; bottom: -30px; inset-inline-end: -20px;
        background: var(--primary-dark); padding: 2.5rem; border-radius: 24px;
        box-shadow: var(--shadow-strong); text-align: center;
    }
    .cta-box-legendary {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        padding: 100px 50px; border-radius: var(--radius-xl); box-shadow: var(--shadow-strong);
        position: relative; overflow: hidden;
    }
    .cta-box-legendary::before {
        content: ""; position: absolute; inset: 0;
        background: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');
        opacity: 0.1;
    }
</style>
@endpush

@push('scripts')
<script>
window.addEventListener('load', function() {
    try {
        if (typeof Swiper === 'undefined') return;

        const heroBox = document.querySelector('.heroSwiper');
        const hSlides = heroBox ? heroBox.querySelectorAll('.swiper-slide') : [];
        
        if (heroBox && hSlides.length > 0) {
            const heroPagination = heroBox.querySelector('.hero-pagination');
            const heroPrev = heroBox.querySelector('.hero-nav-prev');
            const heroNext = heroBox.querySelector('.hero-nav-next');

            new Swiper(heroBox, {
                loop: true,
                speed: 1000,
                autoplay: { delay: 5000, disableOnInteraction: false },
                pagination: { el: heroPagination, clickable: true },
                navigation: { nextEl: heroNext, prevEl: heroPrev },
                observer: true,
                observeParents: true,
                loopAdditionalSlides: 2,
                on: {
                    slideChange: function() {
                        const cur = document.querySelector('.hero-slide-counter .current-num');
                        if (cur) cur.textContent = this.realIndex + 1;
                    }
                }
            });
        }

        const agencyBox = document.querySelector('.agenciesSwiper');
        if (agencyBox) new Swiper(agencyBox, { slidesPerView: 2, loop: true, autoplay: true, breakpoints: { 1024: { slidesPerView: 5 } } });
        
        const partnersBox = document.querySelector('.partnersSwiper');
        if (partnersBox) new Swiper(partnersBox, { slidesPerView: 2, loop: true, autoplay: true, breakpoints: { 992: { slidesPerView: 5 } } });

    } catch (err) { console.error("Swiper Error:", err); }
});
</script>
@endpush
