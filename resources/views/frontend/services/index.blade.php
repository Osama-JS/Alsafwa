@extends('frontend.layouts.app')

@section('title', __('خدماتنا'))

@section('content')
{{-- Inner Page Hero --}}
<section class="inner-page-hero">
    <div class="inner-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1497366216548-37526070297c?w=1600&q=80')"></div>
    <div class="inner-hero-overlay"></div>
    <div class="container position-relative" style="z-index: 2; padding-top:80px">
        <div class="inner-hero-content">
            <span class="section-suptitle text-white opacity-75">{{ __('التميز في الأداء') }}</span>
            <h1 class="inner-title">{{ __('خدماتنا') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb custom-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('خدماتنا') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- Services Grid --}}
<section class="section-legendary">
    <div class="container">
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
                <div class="col-12 text-center py-5">
                    <h3 class="text-muted">{{ __('لا توجد خدمات متاحة حالياً') }}</h3>
                </div>
            @endforelse
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $services->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .fw-black { font-weight: 900; }
</style>
@endpush
