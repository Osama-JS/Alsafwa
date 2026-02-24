@extends('frontend.layouts.app')

@section('title', __('فروعنا'))

@section('content')
{{-- Inner Page Hero --}}
<section class="inner-page-hero">
    <div class="inner-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1497366216548-37526070297c?w=1600&q=80')"></div>
    <div class="inner-hero-overlay"></div>
    <div class="container position-relative" style="z-index: 2; padding-top:80px">
        <div class="inner-hero-content">
            <span class="section-suptitle text-white opacity-75">{{ __('تغطية واسعة') }}</span>
            <h1 class="inner-title">{{ __('تواجدنا في كل مكان') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb custom-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('الفروع') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- Branches Grid --}}
<section class="section-legendary">
    <div class="container">
        <div class="row g-4">
            @forelse($branches as $branch)
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="branch-card-premium d-flex flex-column flex-md-row gap-0 overflow-hidden">
                        <div class="branch-map-preview col-md-5">
                            @if($branch->map_url)
                                <iframe width="100%" height="100%" frameborder="0" style="border:0" src="{{ $branch->map_url }}" allowfullscreen></iframe>
                            @else
                                <div class="bg-primary-dark d-flex align-items-center justify-content-center text-white h-100">
                                    <i class="fas fa-map-marked-alt fs-1 opacity-25"></i>
                                </div>
                            @endif
                        </div>
                        <div class="branch-info-v3 p-4 p-md-5 col-md-7 bg-white">
                            <span class="badge text-bg-primary rounded-pill mb-3" style="font-size:0.7rem;">{{ __('مركز معتمد') }}</span>
                            <h3 class="fw-black mb-4">{{ $branch->{'name_' . app()->getLocale()} }}</h3>
                            <ul class="list-unstyled contact-list-v3">
                                <li class="mb-3 d-flex gap-3">
                                    <i class="fas fa-map-marker-alt text-accent"></i>
                                    <span class="text-sm">{{ $branch->{'address_' . app()->getLocale()} }}</span>
                                </li>
                                <li class="mb-3 d-flex gap-3">
                                    <i class="fas fa-phone-alt text-accent"></i>
                                    <span class="text-sm" dir="ltr">{{ $branch->phone }}</span>
                                </li>
                                <li class="mb-3 d-flex gap-3">
                                    <i class="fas fa-envelope text-accent"></i>
                                    <span class="text-sm">{{ $branch->email }}</span>
                                </li>
                                <li class="mb-0 d-flex gap-3">
                                    <i class="far fa-clock text-accent"></i>
                                    <span class="text-sm">{{ $branch->{'working_hours_' . app()->getLocale()} }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h3 class="text-muted">{{ __('لا توجد فروع حالياً') }}</h3>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .branch-card-premium {
        border-radius: 30px;
        box-shadow: var(--shadow-soft);
        border: 1px solid rgba(0,0,0,0.05);
        min-height: 400px;
        transition: var(--transition-base);
    }
    .branch-card-premium:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-strong);
    }
    .contact-list-v3 i { font-size: 1.1rem; width: 20px; text-align: center; }
    .text-sm { font-size: 0.9rem; font-weight: 600; color: var(--gray-700); }
</style>
@endpush
