@extends('frontend.layouts.app')

@section('title', $agency->{'name_' . app()->getLocale()})

@section('content')
{{-- Inner Page Hero --}}
<section class="inner-page-hero">
    <div class="inner-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1560179707-f14e90ef3623?w=1600&q=80')"></div>
    <div class="inner-hero-overlay"></div>
    <div class="container position-relative" style="z-index: 2; padding-top:80px">
        <div class="inner-hero-content">
            <span class="section-suptitle text-white opacity-75">{{ __('الوكالات المعتمدة') }}</span>
            <h1 class="inner-title">{{ $agency->{'name_' . app()->getLocale()} }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb custom-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('agencies.index') }}">{{ __('الوكالات') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $agency->{'name_' . app()->getLocale()} }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- Agency Content --}}
<section class="section-legendary bg-light">
    <div class="container">
        <div class="row g-5">
            {{-- About Agency --}}
            <div class="col-lg-8">
                <div class="agency-content-card bg-white p-5 rounded-4 shadow-soft mb-5" data-aos="fade-up">
                    <div class="d-flex align-items-center gap-4 mb-4 border-bottom pb-4">
                        <div class="agency-detail-logo-v2 shadow-sm border p-3 rounded-4 bg-white" style="width: 120px; height: 120px;">
                            @if($agency->logo)
                                <img src="{{ asset('storage/' . $agency->logo) }}" alt="{{ $agency->{'name_' . app()->getLocale()} }}" class="w-100 h-100 object-fit-contain">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light rounded-3">
                                    <i class="fas fa-certificate text-primary fs-2"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <span class="badge bg-accent text-dark mb-2 px-3 py-2 rounded-pill fw-bold">
                                <i class="fas fa-certificate me-1"></i> {{ __('وكالة معتمدة') }}
                            </span>
                            <h2 class="fw-black mb-0">{{ $agency->{'name_' . app()->getLocale()} }}</h2>
                        </div>
                    </div>

                    <h4 class="fw-black mb-4">{{ __('عن الوكالة') }}</h4>
                    <div class="cms-content">
                        {!! $agency->{'description_' . app()->getLocale()} !!}
                    </div>

                    @if($agency->map_url)
                        <h4 class="fw-black mb-3 mt-5">{{ __('موقعنا') }}</h4>
                        <a href="{{ $agency->map_url }}" target="_blank" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="fas fa-map-marked-alt me-2"></i> {{ __('عرض على الخريطة') }}
                        </a>
                    @endif
                </div>

                {{-- Products Grid --}}
                <div class="agency-products-section" data-aos="fade-up">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-black mb-0">{{ __('منتجات الوكالة') }}</h3>
                        <span class="badge bg-primary px-3 py-2 rounded-pill">{{ $agency->products->count() }} {{ __('منتج') }}</span>
                    </div>

                    @if(isset($categories) && count($categories) > 0)
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <a href="{{ route('agencies.show', $agency->slug) }}" class="btn rounded-pill px-4 {{ !request('category_id') ? 'btn-primary shadow-sm' : 'btn-light border fw-bold' }}">
                            {{ __('الكل') }}
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ route('agencies.show', ['slug' => $agency->slug, 'category_id' => $cat->id]) }}" class="btn rounded-pill px-4 {{ request('category_id') == $cat->id ? 'btn-primary shadow-sm' : 'btn-light border fw-bold text-dark' }}">
                                {{ $cat->{'name_' . app()->getLocale()} }}
                            </a>
                        @endforeach
                    </div>
                    @endif

                    <div class="row g-4">
                        @forelse($agency->products as $product)
                            <div class="col-md-6 col-lg-4">
                                <div class="product-card-v3">
                                    <a href="{{ route('products.show', $product->slug) }}" class="product-img-wrap text-decoration-none">
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
                                    </a>

                                    <div class="product-body">
                                        <div class="product-meta-tags">
                                            @if($product->agency)
                                                <span class="product-badge-agency">
                                                    <i class="fas fa-building me-1 opacity-75"></i> {{ $product->agency->{'name_' . app()->getLocale()} }}
                                                </span>
                                            @endif

                                            @if($product->productCategory)
                                                <a href="{{ route('products.index', ['category_id' => $product->productCategory->id]) }}" class="product-badge-category">
                                                    <i class="fas fa-tag me-1 opacity-75"></i> {{ $product->productCategory->{'name_' . app()->getLocale()} }}
                                                </a>
                                            @endif
                                        </div>

                                        <h3 class="product-title">
                                            <a href="{{ route('products.show', $product->slug) }}">
                                                {{ $product->{'title_' . app()->getLocale()} }}
                                            </a>
                                        </h3>

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

                                        <div class="product-card-actions">
                                            <a href="{{ route('products.show', $product->slug) }}" class="btn-order-now">
                                                <span>{{ __('اطلب الآن') }}</span>
                                                <i class="fas fa-shopping-cart"></i>
                                            </a>
                                            @php
                                                $waNum = preg_replace('/[^0-9]/', '', setting('whatsapp_number', ''));
                                                $waText = urlencode(__('مرحباً، أود الاستفسار عن: ') . $product->{'title_' . app()->getLocale()});
                                            @endphp
                                            <a href="{{ $waNum ? 'https://wa.me/' . $waNum . '?text=' . $waText : 'https://wa.me/' . setting('whatsapp_number') }}" target="_blank" class="btn-whatsapp-card" title="{{ __('استفسر عبر الواتساب') }}">
                                                <i class="fab fa-whatsapp fs-5"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 py-5 text-center">
                                <div class="opacity-25 mb-3"><i class="fas fa-box-open fa-4x"></i></div>
                                <h4 class="text-secondary">{{ __('لا توجد منتجات مرتبطة بهذه الوكالة حالياً') }}</h4>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Sidebar Info --}}
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <div class="contact-widget bg-primary p-5 rounded-4 text-white shadow-strong mb-4" data-aos="fade-left">
                        <h4 class="fw-black mb-4">{{ __('تواصل مع الوكيل') }}</h4>
                        <div class="contact-list-v4 d-flex flex-column gap-4">
                            @if($agency->phone)
                                <div class="d-flex align-items-center gap-3">
                                    <div class="icon-circle bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-phone-alt"></i>
                                    </div>
                                    <div>
                                        <small class="d-block opacity-50">{{ __('رقم الهاتف') }}</small>
                                        <span class="fw-bold fw-black">{{ $agency->phone }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($agency->email)
                                <div class="d-flex align-items-center gap-3">
                                    <div class="icon-circle bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div>
                                        <small class="d-block opacity-50">{{ __('البريد الإلكتروني') }}</small>
                                        <span class="fw-bold fw-black overflow-hidden" style="text-overflow: ellipsis; display: block;">{{ $agency->email }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($agency->website)
                                <a href="{{ $agency->website }}" target="_blank" class="btn btn-white w-100 py-3 rounded-pill fw-bold mt-2">
                                    {{ __('زيارة الموقع الإلكتروني') }} <i class="fas fa-external-link-alt ms-2"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="share-widget bg-white p-4 rounded-4 shadow-soft" data-aos="fade-left" data-aos-delay="100">
                        <h6 class="fw-black mb-3">{{ __('مشاركة الوكالة') }}</h6>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-light border text-dark flex-grow-1 rounded-pill"><i class="fab fa-facebook-f"></i></button>
                            <button class="btn btn-outline-light border text-dark flex-grow-1 rounded-pill"><i class="fab fa-twitter"></i></button>
                            <button class="btn btn-outline-light border text-dark flex-grow-1 rounded-pill"><i class="fab fa-whatsapp"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .agency-detail-logo-v2 img {
        object-fit: contain;
    }
    .btn-white {
        background: #fff;
        color: var(--primary);
        transition: 0.3s;
    }
    .btn-white:hover {
        background: var(--accent);
        color: var(--primary-dark);
        transform: translateY(-3px);
    }
</style>
@endpush
