@extends('frontend.layouts.app')

@section('title', __('الوكالات'))

@section('content')
{{-- Inner Page Hero --}}
<section class="inner-page-hero">
    <div class="inner-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1560179707-f14e90ef3623?w=1600&q=80')"></div>
    <div class="inner-hero-overlay"></div>
    <div class="container position-relative" style="z-index: 2; padding-top:80px">
        <div class="inner-hero-content">
            <span class="section-suptitle text-white opacity-75">{{ __('شركاء النجاح') }}</span>
            <h1 class="inner-title">{{ __('وكالاتنا المعتمدة') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb custom-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('الوكالات') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- Agencies Grid --}}
<section class="section-legendary">
    <div class="container">
        <div class="row g-4">
            @forelse($agencies as $agency)
                <div class="col-lg-3 col-md-4 col-6" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 60 }}">
                    <div class="agency-card-v3">
                        <div class="agency-logo-inner">
                            @if($agency->logo)
                                <img src="{{ asset('storage/' . $agency->logo) }}" alt="{{ $agency->name_ar }}">
                            @else
                                <span class="fw-black text-primary fs-4">{{ $agency->{'name_' . app()->getLocale()} }}</span>
                            @endif
                        </div>
                        <div class="agency-info-overlay">
                            <h6 class="fw-black mb-1 p-2">{{ $agency->{'name_' . app()->getLocale()} }}</h6>
                            @if($agency->website)
                                <a href="{{ $agency->website }}" target="_blank" class="btn-legendary p-1 px-3 fs-xs rounded-pill" style="font-size:.7rem;">{{ __('الموقع الرسمي') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h3 class="text-muted">{{ __('لا توجد وكالات حالياً') }}</h3>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .agency-card-v3 {
        position: relative;
        background: #fff;
        aspect-ratio: 1/1;
        border-radius: 30px;
        display: flex; align-items: center; justify-content: center;
        padding: 2rem;
        border: 1px solid rgba(0,0,0,0.05);
        transition: var(--transition-base);
        overflow: hidden;
    }
    .agency-card-v3:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-soft);
    }
    .agency-card-v3 img { max-width: 80%; max-height: 80%; object-fit: contain; filter: grayscale(1); transition: 0.5s; }
    .agency-card-v3:hover img { filter: grayscale(0); transform: scale(1.1); }

    .agency-info-overlay {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(10px);
        padding: 1rem;
        text-align: center;
        transform: translateY(100%);
        transition: var(--transition-base);
    }
    .agency-card-v3:hover .agency-info-overlay { transform: translateY(0); }
</style>
@endpush
