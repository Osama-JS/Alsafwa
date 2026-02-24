@extends('frontend.layouts.app')

@section('title', __('المنتجات'))

@section('content')

{{-- Inner Page Hero --}}
<section class="inner-page-hero">
    <div class="inner-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1600&q=80')"></div>
    <div class="inner-hero-overlay"></div>
    <div class="container position-relative" style="z-index: 2; padding-top:80px">
        <div class="inner-hero-content">
            <span class="section-suptitle text-white opacity-75">{{ __('تسوّق الآن') }}</span>
            <h1 class="inner-title">{{ __('المنتجات') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb custom-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('المنتجات') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- Products Grid --}}
<section class="section-legendary">
    <div class="container">
        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none d-block h-100">
                        <div class="product-card-v3">
                            <div class="product-img-wrap">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="product-img" alt="{{ $product->{'title_' . app()->getLocale()} }}">
                                @else
                                    <div class="product-img-placeholder">
                                        <i class="fas fa-box fs-1 opacity-25"></i>
                                    </div>
                                @endif

                                @if($product->discount && $product->price)
                                    <span class="product-badge-sale">{{ __('خصم') }}</span>
                                @endif

                                @if($product->agency)
                                    <span class="product-badge-agency">{{ $product->agency->{'name_' . app()->getLocale()} }}</span>
                                @endif
                            </div>

                            <div class="product-body">
                                <h3 class="product-title">{{ $product->{'title_' . app()->getLocale()} }}</h3>

                                @if($product->{'description_' . app()->getLocale()})
                                    <p class="product-desc">{{ Str::limit($product->{'description_' . app()->getLocale()}, 80) }}</p>
                                @endif

                                @if($product->price)
                                    <div class="product-price-wrap">
                                        @if($product->discount)
                                            <span class="product-price-old">{{ number_format($product->price, 2) }} {{ __('ر.س') }}</span>
                                            <span class="product-price-current">{{ number_format($product->final_price, 2) }} {{ __('ر.س') }}</span>
                                        @else
                                            <span class="product-price-current">{{ number_format($product->price, 2) }} {{ __('ر.س') }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 py-5 text-center">
                    <i class="fas fa-box-open fs-1 mb-3 opacity-25 d-block"></i>
                    <h4 class="fw-bold mb-2">{{ __('لا توجد منتجات حالياً') }}</h4>
                    <p class="text-muted">{{ __('سيتم إضافة المنتجات قريباً، تابعونا!') }}</p>
                </div>
            @endforelse
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
</section>

@endsection
