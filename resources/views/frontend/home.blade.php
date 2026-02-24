@extends('frontend.layouts.app')

@section('title', __('الرئيسية'))

@section('content')

{{-- ================================================================
     LEGENDARY HERO SECTION
     ================================================================ --}}
<section class="hero-section hero-legendary-main">
    <div class="swiper heroSwiper" style="height: 100%;">
        <div class="swiper-wrapper">
            @forelse($sliders as $slider)
                <div class="swiper-slide">
                    <div class="hero-slide-item">
                        <div class="hero-slide-bg" style="background-image: url('{{ $slider->image && Storage::disk('public')->exists($slider->image) ? asset('storage/' . $slider->image) : asset('images/hero-fallback.jpg') }}');"></div>
                        <div class="hero-overlay-legend"></div>
                        <div class="container position-relative z-10 pt-5" style="padding-top:160px">
                            <div class="hero-content-wrap">
                                <span class="hero-subtitle-top">{{ $slider->{'subtitle_' . app()->getLocale()} }}</span>
                                <h1 class="hero-title-mega">
                                    {{ $slider->{'title_' . app()->getLocale()} }}
                                    <span class="stroked-text">{{ setting('company_name_' . app()->getLocale(), __('الصفوة')) }}</span>
                                </h1>
                                <div class="hero-btn-group mt-5">
                                    <a href="{{ $slider->link ?: route('services.index') }}" class="btn-legendary">
                                        {{ $slider->{'button_text_' . app()->getLocale()} ?: __('اكتشف المزيد') }}
                                        <i class="fas fa-chevron-left ms-2 fs-6 opacity-50"></i>
                                    </a>
                                    <a href="{{ route('contact') }}" class="btn-hero-outline">
                                        {{ __('تواصل معنا') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="swiper-slide">
                    <div class="hero-slide-item">
                        <div class="hero-slide-bg" style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1920&q=80');"></div>
                        <div class="hero-overlay-legend"></div>
                        <div class="container position-relative z-10" style="padding-top:160px">
                            <div class="hero-content-wrap">
                                <span class="hero-subtitle-top">{{ setting('company_tagline_' . app()->getLocale(), __('للتجارة والاستثمار')) }}</span>
                                <h1 class="hero-title-mega">
                                    {{ setting('company_name_' . app()->getLocale(), __('الصفوة')) }}
                                    <span class="stroked-text">{{ __('رؤيتك.. واقعنا') }}</span>
                                </h1>
                                <div class="hero-btn-group mt-5">
                                    <a href="{{ route('services.index') }}" class="btn-legendary">
                                        {{ __('خدماتنا') }}
                                    </a>
                                    <a href="{{ route('contact') }}" class="btn-hero-outline">
                                        {{ __('تواصل معنا') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        <div class="swiper-pagination"></div>
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
                <span class="section-suptitle">{{ __('آخر المستجدات') }}</span>
                <h2 class="section-maintitle mb-0">{{ __('أحدث أنشطتنا') }}</h2>
            </div>
            <a href="{{ route('activities.index') }}" class="text-primary fw-bold">{{ __('جميع الأنشطة') }} <i class="fas fa-arrow-left ms-2"></i></a>
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

@endsection

@push('styles')
<style>
    .stat-label-v3 { font-weight: 800; text-transform: uppercase; letter-spacing: 2px; font-size: 0.8rem; opacity: 0.5; }
    .fw-black { font-weight: 900; }
    .max-w-600 { max-width: 600px; }
    .floating-experience-card {
        position: absolute;
        bottom: -30px; 
        inset-inline-end: -20px;
        background: var(--primary-dark);
        padding: 2.5rem;
        border-radius: 24px;
        box-shadow: var(--shadow-strong);
        text-align: center;
    }
    .cta-box-legendary {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        padding: 100px 50px;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-strong);
        position: relative;
        overflow: hidden;
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
    document.addEventListener('DOMContentLoaded', function() {
        // Hero Swiper
        const heroSlides = document.querySelectorAll('.heroSwiper .swiper-slide');
        if (heroSlides.length > 0) {
            new Swiper('.heroSwiper', {
                loop: heroSlides.length > 1,
                speed: 1200,
                autoplay: { delay: 6000, disableOnInteraction: false },
                effect: 'fade',
                fadeEffect: { crossFade: true },
                pagination: { el: '.swiper-pagination', clickable: true },
            });
        }

        // Agencies Swiper
        const agencySlides = document.querySelectorAll('.agenciesSwiper .swiper-slide');
        if (agencySlides.length > 0) {
            new Swiper('.agenciesSwiper', {
                slidesPerView: 2,
                spaceBetween: 30,
                loop: agencySlides.length > 5, // Enable loop only if we have more slides than visible
                autoplay: { delay: 3000, disableOnInteraction: false },
                breakpoints: {
                    640: { slidesPerView: 3 },
                    1024: { slidesPerView: 5 },
                }
            });
        }
    });
</script>
@endpush
