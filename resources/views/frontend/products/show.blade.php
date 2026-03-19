@extends('frontend.layouts.app')

@section('title', $product->{'title_' . app()->getLocale()})

@section('content')

{{-- Inner Page Hero --}}
<section class="inner-page-hero">
    <div class="inner-hero-bg" style="background-image: url('{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1600&q=80' }}')"></div>
    <div class="inner-hero-overlay"></div>
    <div class="container position-relative" style="z-index: 2; padding-top:80px">
        <div class="inner-hero-content">
            <span class="section-suptitle text-white opacity-75">{{ __('تفاصيل المنتج') }}</span>
            <h1 class="inner-title">{{ $product->{'title_' . app()->getLocale()} }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb custom-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('المنتجات') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->{'title_' . app()->getLocale()} }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- Product Details --}}
<section class="section-legendary">
    <div class="container">
        <div class="row g-5">
            {{-- Left Column: Professional Gallery --}}
            <div class="col-lg-6" data-aos="fade-up">
                <div class="product-gallery-premium">
                    {{-- Main Swiper --}}
                    <div class="swiper productMainSwiper shadow-strong rounded-4 mb-3">
                        <div class="swiper-wrapper">
                            @if($product->image)
                                <div class="swiper-slide">
                                    <div class="gallery-main-img-wrap">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->{'title_' . app()->getLocale()} }}">
                                    </div>
                                </div>
                            @endif
                            @if($product->gallery && count($product->gallery) > 0)
                                @foreach($product->gallery as $galImg)
                                    <div class="swiper-slide">
                                        <div class="gallery-main-img-wrap">
                                            <img src="{{ asset('storage/' . $galImg) }}" alt="{{ $product->{'title_' . app()->getLocale()} }}">
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                    {{-- Thumbnails Swiper --}}
                    @if($product->gallery && count($product->gallery) > 0)
                    <div class="swiper productThumbSwiper mt-3">
                        <div class="swiper-wrapper">
                            @if($product->image)
                                <div class="swiper-slide thumb-slide">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="rounded-3">
                                </div>
                            @endif
                            @foreach($product->gallery as $galImg)
                                <div class="swiper-slide thumb-slide">
                                    <img src="{{ asset('storage/' . $galImg) }}" class="rounded-3">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Right Column: Product Info --}}
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                @if($product->agency)
                    <a href="{{ route('agencies.show', $product->agency->slug) }}" class="text-decoration-none">
                        <span class="badge rounded-pill mb-3" style="background:var(--accent);color:#000;font-weight:700;padding:6px 16px;">{{ $product->agency->{'name_' . app()->getLocale()} }}</span>
                    </a>
                @endif

                <h2 class="fw-black mb-3" style="font-size:2.2rem;color:var(--primary-dark);">{{ $product->{'title_' . app()->getLocale()} }}</h2>

                @if($product->price)
                    <div class="mb-4 d-flex align-items-center gap-3">
                        @if($product->discount)
                            <div class="price-discount-wrap">
                                <span class="text-muted text-decoration-line-through fs-5">{{ number_format($product->price, 2) }} {{ __('ر.س') }}</span>
                                <div class="final-price-badge">
                                    <span class="fw-black fs-2">{{ number_format($product->final_price, 2) }}</span>
                                    <span class="fs-6 fw-bold opacity-75 ms-1">{{ __('ر.س') }}</span>
                                </div>
                            </div>
                        @else
                            <div class="final-price-badge">
                                <span class="fw-black fs-2">{{ number_format($product->price, 2) }}</span>
                                <span class="fs-6 fw-bold opacity-75 ms-1">{{ __('ر.س') }}</span>
                            </div>
                        @endif
                    </div>
                @endif

                @if($product->{'description_' . app()->getLocale()})
                    <div class="cms-content mb-5 typography-rich" style="font-size: 1.1rem; line-height: 1.8;">
                        {!! $product->{'description_' . app()->getLocale()} !!}
                    </div>
                @endif

                {{-- Product Distributors --}}
                @if($product->distributors->count() > 0)
                    <div class="product-distributors-premium p-4 rounded-4 bg-light border mb-5">
                        <h5 class="fw-black mb-3 text-primary-dark d-flex align-items-center">
                            <i class="fas fa-certificate text-accent me-2"></i>
                            {{ __('الموزعون المعتمدون') }}
                        </h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($product->distributors as $distributor)
                                <a href="{{ route('distributors.show', $distributor->id) }}" class="distributor-pill">
                                    {{ $distributor->{'name_' . app()->getLocale()} }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="d-flex gap-3 mt-4">
                    <a href="{{ route('contact') }}" class="btn btn-primary-custom py-3 px-5 rounded-pill fw-bold fs-6">
                        {{ __('اطلب الآن') }}
                        <i class="fas fa-shopping-cart ms-2"></i>
                    </a>
                    <a href="https://wa.me/{{ setting('whatsapp_number') }}" target="_blank" class="btn btn-outline-success py-3 px-4 rounded-pill fw-bold fs-6">
                        <i class="fab fa-whatsapp me-1"></i> {{ __('استفسر') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- Related Products --}}
        @if($relatedProducts->count() > 0)
            <div class="mt-5 pt-5 border-top">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <h3 class="fw-black mb-0" style="color:var(--primary-dark);">{{ __('منتجات قد تعجبك') }}</h3>
                    <a href="{{ route('products.index') }}" class="text-accent fw-bold">{{ __('عرض الكل') }} <i class="fas fa-arrow-left ms-1"></i></a>
                </div>
                <div class="row g-4">
                    @foreach($relatedProducts as $related)
                        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <a href="{{ route('products.show', $related->slug) }}" class="text-decoration-none d-block h-100">
                                <div class="product-card-v3">
                                    <div class="product-img-wrap">
                                        @if($related->image)
                                            <img src="{{ asset('storage/' . $related->image) }}" class="product-img" alt="{{ $related->{'title_' . app()->getLocale()} }}">
                                        @endif
                                    </div>
                                    <div class="product-body">
                                        <h3 class="product-title">{{ $related->{'title_' . app()->getLocale()} }}</h3>
                                        @if($related->price)
                                            <span class="product-price-current">{{ number_format($related->final_price, 2) }} {{ __('ر.س') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

@endsection

@push('styles')
<style>
    /* ── Product Gallery ── */
    .productMainSwiper { height: 500px; }
    .gallery-main-img-wrap { width: 100%; height: 100%; background: #f8fafc; }
    .gallery-main-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
    
    .productThumbSwiper { height: 100px; box-sizing: border-box; padding: 10px 0; }
    .productThumbSwiper .swiper-slide {
        width: 25%; height: 100%; opacity: 0.4; transition: var(--transition-base); cursor: pointer;
    }
    .productThumbSwiper .swiper-slide-thumb-active { opacity: 1; transform: scale(1.05); }
    .productThumbSwiper .swiper-slide img { width: 100%; height: 100%; object-fit: cover; border: 2px solid transparent; }
    .productThumbSwiper .swiper-slide-thumb-active img { border-color: var(--accent); }

    /* ── Pricing ── */
    .final-price-badge { color: var(--accent-dark); }
    .distributor-pill {
        background: #fff; border: 1px solid var(--border-color);
        padding: 6px 16px; border-radius: 50px; color: var(--primary-dark);
        font-weight: 700; font-size: 0.85rem; transition: var(--transition-base);
    }
    .distributor-pill:hover { background: var(--accent); color: #000; border-color: var(--accent); }

    /* Override Swiper Buttons for Premium Look */
    .productMainSwiper .swiper-button-next, 
    .productMainSwiper .swiper-button-prev {
        width: 45px; height: 45px; background: rgba(255,255,255,0.9);
        border-radius: 50%; color: var(--primary);
    }
    .productMainSwiper .swiper-button-next:after, 
    .productMainSwiper .swiper-button-prev:after { font-size: 1.2rem; font-weight: 900; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Init Thumbnails first
        var thumbsSwiper = new Swiper(".productThumbSwiper", {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });

        // Init Main Swiper
        var mainSwiper = new Swiper(".productMainSwiper", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: thumbsSwiper,
            },
        });
    });
</script>
@endpush
