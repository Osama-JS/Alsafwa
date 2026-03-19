@extends('frontend.layouts.app')

@section('title', __('الموزعون المعتمدون'))

@section('content')
{{-- Inner Page Hero --}}
<section class="inner-page-hero">
    <div class="inner-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=1600&q=80')"></div>
    <div class="inner-hero-overlay"></div>
    <div class="container position-relative" style="z-index: 2; padding-top:80px">
        <div class="inner-hero-content">
            <span class="section-suptitle text-white opacity-75">{{ __('شبكة عالمية') }}</span>
            <h1 class="inner-title">{{ __('الموزعون المعتمدون') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb custom-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('الموزعون') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- Distributors Grid --}}
<section class="section-legendary bg-light">
    <div class="container">
        <div class="row g-4">
            @forelse($distributors as $distributor)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <a href="{{ route('distributors.show', $distributor->id) }}" class="text-decoration-none">
                        <div class="distributor-card-premium h-100">
                            <div class="distributor-logo-wrap mb-4">
                                @if($distributor->logo)
                                    <img src="{{ asset('storage/' . $distributor->logo) }}" alt="{{ $distributor->{'name_' . app()->getLocale()} }}" class="distributor-logo">
                                @else
                                    <div class="distributor-logo-placeholder">
                                        <i class="fas fa-truck-loading fs-2 text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="distributor-content p-2 text-center">
                                <h3 class="fw-black mb-2 text-primary-dark h5">{{ $distributor->{'name_' . app()->getLocale()} }}</h3>
                                @if($distributor->{'address_' . app()->getLocale()})
                                    <p class="text-muted small mb-0"><i class="fas fa-map-marker-alt me-1 text-accent"></i> {{ $distributor->{'address_' . app()->getLocale()} }}</p>
                                @endif
                            </div>
                            <div class="text-center mt-3">
                                <span class="text-accent fw-bold small">{{ __('عرض التفاصيل') }} <i class="fas fa-arrow-left ms-1"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="empty-state-v2">
                        <i class="fas fa-truck-loading fs-1 text-muted opacity-25 mb-4"></i>
                        <h3 class="text-muted fw-bold">{{ __('لا يوجد موزعون حالياً') }}</h3>
                        <p class="text-muted">{{ __('يرجى التحقق لاحقاً') }}</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($distributors->hasPages())
            <div class="mt-5 d-flex justify-content-center">
                {{ $distributors->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    .distributor-card-premium {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.03);
        transition: all 0.4s ease;
        display: flex;
        flex-direction: column;
        padding: 30px;
    }
    .distributor-card-premium:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        border-color: var(--primary);
    }
    .distributor-logo-wrap {
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        border-radius: 15px;
        padding: 20px;
        overflow: hidden;
    }
    .distributor-logo {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .distributor-logo-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .description-text {
        font-size: 0.9rem;
        line-height: 1.6;
        color: #64748b;
        height: 4.8em;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }
    .empty-state-v2 { padding: 60px 0; }
</style>
@endpush
