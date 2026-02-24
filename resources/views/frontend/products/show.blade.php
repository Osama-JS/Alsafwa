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
            <div class="col-lg-6" data-aos="fade-up">
                <div class="product-detail-img">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->{'title_' . app()->getLocale()} }}" class="rounded-4 shadow-strong w-100" style="object-fit:cover; max-height:500px;">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light rounded-4" style="height:400px;">
                            <i class="fas fa-box fs-1 opacity-25"></i>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                @if($product->agency)
                    <span class="badge rounded-pill mb-3" style="background:var(--accent);color:#000;font-weight:700;padding:6px 16px;">{{ $product->agency->{'name_' . app()->getLocale()} }}</span>
                @endif

                <h2 class="fw-black mb-3" style="font-size:2.2rem;color:var(--primary-dark);">{{ $product->{'title_' . app()->getLocale()} }}</h2>

                @if($product->price)
                    <div class="mb-4">
                        @if($product->discount)
                            <span style="text-decoration:line-through;color:#94a3b8;font-size:1.2rem;">{{ number_format($product->price, 2) }} {{ __('ر.س') }}</span>
                            <span class="ms-2 fw-black" style="color:var(--accent-dark);font-size:1.8rem;">{{ number_format($product->final_price, 2) }} {{ __('ر.س') }}</span>
                        @else
                            <span class="fw-black" style="color:var(--accent-dark);font-size:1.8rem;">{{ number_format($product->price, 2) }} {{ __('ر.س') }}</span>
                        @endif
                    </div>
                @endif

                @if($product->{'description_' . app()->getLocale()})
                    <div class="mb-4" style="color:#475569;line-height:1.8;">
                        {!! nl2br(e($product->{'description_' . app()->getLocale()})) !!}
                    </div>
                @endif

                <a href="{{ route('contact') }}" class="btn-legendary py-3 px-5 fs-6">
                    {{ __('تواصل معنا للطلب') }}
                    <i class="fas fa-arrow-left ms-2"></i>
                </a>
            </div>
        </div>

        @if($relatedProducts->count() > 0)
            <div class="mt-5 pt-5 border-top">
                <h3 class="fw-black mb-4" style="color:var(--primary-dark);">{{ __('منتجات ذات صلة') }}</h3>
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
