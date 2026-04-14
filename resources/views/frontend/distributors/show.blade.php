@extends('frontend.layouts.app')

@section('title', $distributor->{'name_' . app()->getLocale()})

@section('content')
{{-- Inner Page Hero --}}
<section class="inner-page-hero">
    <div class="inner-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=1600&q=80')"></div>
    <div class="inner-hero-overlay"></div>
    <div class="container position-relative" style="z-index: 2; padding-top:80px">
        <div class="inner-hero-content text-center">
            <nav aria-label="breadcrumb" class="d-flex justify-content-center mb-4">
                <ol class="breadcrumb custom-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('distributors.index') }}">{{ __('الموزعون') }}</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">{{ $distributor->{'name_' . app()->getLocale()} }}</li>
                </ol>
            </nav>
            <h1 class="inner-title mb-0">{{ $distributor->{'name_' . app()->getLocale()} }}</h1>
        </div>
    </div>
</section>

{{-- Distributor Details --}}
<section class="section-legendary bg-white pb-0">
    <div class="container">
        <div class="row g-5">
            {{-- Column 1: Info & Logo --}}
            <div class="col-lg-4" data-aos="fade-up">
                <div class="distributor-sidebar shadow-strong rounded-4 p-4 sticky-top" style="top:100px; background:#f8fafc; border:1px solid rgba(0,0,0,0.05);">
                    <div class="distributor-detail-logo mb-4 bg-white rounded-3 p-4 text-center border">
                        @if($distributor->logo)
                            <img src="{{ asset('storage/' . $distributor->logo) }}" alt="{{ $distributor->{'name_' . app()->getLocale()} }}" class="img-fluid" style="max-height:100px;">
                        @else
                            <i class="fas fa-truck-loading fs-1 text-muted opacity-25"></i>
                        @endif
                    </div>
                    
                    <h4 class="fw-black mb-4 text-primary-dark border-bottom pb-2">{{ __('معلومات الاتصال') }}</h4>
                    
                    <ul class="list-unstyled mb-4">
                        @if($distributor->{'address_' . app()->getLocale()})
                            <li class="mb-4 d-flex gap-3">
                                <div class="icon-circle-v2 bg-white text-accent">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <span class="d-block text-xs text-secondary mb-1">{{ __('العنوان') }}</span>
                                    <span class="fw-bold small">{{ $distributor->{'address_' . app()->getLocale()} }}</span>
                                </div>
                            </li>
                        @endif
                        
                        @if($distributor->phone)
                            <li class="mb-4 d-flex gap-3">
                                <div class="icon-circle-v2 bg-white text-accent">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div>
                                    <span class="d-block text-xs text-secondary mb-1">{{ __('رقم الهاتف') }}</span>
                                    <a href="tel:{{ $distributor->phone }}" class="text-decoration-none text-dark fw-bold small" dir="ltr">{{ $distributor->phone }}</a>
                                </div>
                            </li>
                        @endif

                        @if($distributor->url)
                            <li class="mb-0 d-flex gap-3">
                                <div class="icon-circle-v2 bg-white text-accent">
                                    <i class="fas fa-globe"></i>
                                </div>
                                <div>
                                    <span class="d-block text-xs text-secondary mb-1">{{ __('الموقع الإلكتروني') }}</span>
                                    <a href="{{ $distributor->url }}" target="_blank" class="text-decoration-none text-dark fw-bold small">{{ $distributor->url }}</a>
                                </div>
                            </li>
                        @endif
                    </ul>

                    @if($distributor->phone)
                        <a href="tel:{{ $distributor->phone }}" class="btn btn-primary-custom w-100 py-3 rounded-pill fw-bold shadow-sm mb-3">
                            <i class="fas fa-phone-alt me-2"></i> {{ __('تواصل الآن') }}
                        </a>
                    @else
                        <a href="{{ route('contact') }}?subject={{ __('استفسار عن موزع: ') . $distributor->{'name_' . app()->getLocale()} }}" class="btn btn-primary-custom w-100 py-3 rounded-pill fw-bold shadow-sm mb-3">
                            <i class="fas fa-envelope me-2"></i> {{ __('تواصل معنا') }}
                        </a>
                    @endif
                </div>
            </div>

            {{-- Column 2: About & Products --}}
            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                <div class="distributor-main-content">
                    <div class="mb-5">
                        <h2 class="fw-black mb-4 text-primary-dark"><i class="fas fa-info-circle text-accent me-2"></i> {{ __('نبذة عن الموزع') }}</h2>
                        <div class="cms-content">
                            @if($distributor->{'description_' . app()->getLocale()})
                                {!! $distributor->{'description_' . app()->getLocale()} !!}
                            @else
                                <p class="text-muted italic">{{ __('لا يوجد وصف متاح حالياً لهذا الموزع.') }}</p>
                            @endif
                        </div>
                    </div>

                    @if($distributor->map_url)
                        <div class="mb-5">
                            <h2 class="fw-black mb-4 text-primary-dark"><i class="fas fa-map-marked-alt text-accent me-2"></i> {{ __('موقعنا على الخريطة') }}</h2>
                            <div class="map-container-v3 rounded-4 overflow-hidden border shadow-soft" style="height: 400px;">
                                <iframe src="{{ $distributor->map_url }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        </div>
                    @endif

                    @if($distributor->products->count() > 0)
                        <div class="mb-5 pt-4">
                            <h2 class="fw-black mb-4 text-primary-dark"><i class="fas fa-box text-accent me-2"></i> {{ __('المنتجات المتوفرة لوزعنا') }}</h2>

                            @if(isset($categories) && count($categories) > 0)
                            <div class="d-flex flex-wrap gap-2 mb-4">
                                <a href="{{ route('distributors.show', $distributor->id) }}" class="btn rounded-pill px-4 py-1 {{ !request('category_id') ? 'btn-primary shadow-sm' : 'btn-light border fw-bold text-dark' }}">
                                    {{ __('الكل') }}
                                </a>
                                @foreach($categories as $cat)
                                    <a href="{{ route('distributors.show', ['id' => $distributor->id, 'category_id' => $cat->id]) }}" class="btn rounded-pill px-4 py-1 {{ request('category_id') == $cat->id ? 'btn-primary shadow-sm' : 'btn-light border fw-bold text-dark' }}">
                                        {{ $cat->{'name_' . app()->getLocale()} }}
                                    </a>
                                @endforeach
                            </div>
                            @endif

                            <div class="row g-4">
                                @foreach($distributor->products as $product)
                                    <div class="col-md-6">
                                        <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                                            <div class="product-item-horizontal shadow-sm rounded-3 p-3 bg-light d-flex gap-3 align-items-center border">
                                                <div class="product-img-mini rounded border" style="width:80px;height:80px;flex-shrink:0; background: #fff;">
                                                    @if($product->image)
                                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-100 h-100 object-fit-cover rounded" alt="{{ $product->{'title_' . app()->getLocale()} }}">
                                                    @else
                                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted opacity-25"><i class="fas fa-box"></i></div>
                                                    @endif
                                                </div>
                                                <div class="product-info-mini">
                                                    @if($product->productCategory)
                                                        <span class="badge mb-1 px-2 py-1" style="background:#ede9fe; color:#4f46e5; border-radius:12px; font-size:0.65rem;">
                                                            <i class="fas fa-tag"></i> {{ $product->productCategory->{'name_' . app()->getLocale()} }}
                                                        </span>
                                                    @endif
                                                    <h6 class="fw-bold mb-1 text-dark">{{ $product->{'title_' . app()->getLocale()} }}</h6>
                                                    @if($product->price)
                                                        <span class="text-accent small fw-bold">{{ number_format($product->final_price, 2) }} {{ __('ر.س') }}</span>
                                                    @endif
                                                </div>
                                                <i class="fas fa-chevron-left ms-auto text-muted opacity-50"></i>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .icon-circle-v2 {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        flex-shrink: 0;
    }
    .line-height-1-8 { line-height: 1.8; }
    .product-item-horizontal { transition: all 0.3s ease; }
    .product-item-horizontal:hover {
        transform: scale(1.02);
        background: #fff !important;
        border-color: var(--primary) !important;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
    }
    .distributor-sidebar { transition: all 0.3s ease; }
</style>
@endpush
