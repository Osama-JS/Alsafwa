@extends('frontend.layouts.app')

@section('title', __('أنشطتنا'))

@section('content')
{{-- Inner Page Hero --}}
<section class="inner-page-hero">
    <div class="inner-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1600&q=80')"></div>
    <div class="inner-hero-overlay"></div>
    <div class="container position-relative" style="z-index: 2; padding-top:80px">
        <div class="inner-hero-content">
            <span class="section-suptitle text-white opacity-75">{{ __('الحيوية والتفاعل') }}</span>
            <h1 class="inner-title">{{ __('الأنشطة والفعاليات') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb custom-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('أنشطتنا') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- Activities Grid --}}
<section class="section-legendary">
    <div class="container">
        <div class="row g-4">
            @forelse($activities as $activity)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="activity-card-legendary">
                        <div class="activity-img-wrap">
                            <img src="{{ $activity->image ? asset('storage/' . $activity->image) : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600&q=80' }}" alt="{{ $activity->title_ar }}">
                            @if($activity->category)
                                <span class="activity-cat-badge">{{ $activity->category->{'name_' . app()->getLocale()} }}</span>
                            @endif
                        </div>
                        <div class="activity-body-v3">
                            <span class="activity-date"><i class="far fa-calendar-alt me-2"></i>{{ $activity->created_at->format('Y/m/d') }}</span>
                            <h4 class="fw-black my-3">{{ $activity->{'title_' . app()->getLocale()} }}</h4>
                            <p class="opacity-75 mb-4">{{ Str::limit($activity->{'description_' . app()->getLocale()}, 110) }}</p>
                            <a href="{{ route('activities.show', $activity->slug) }}" class="btn-legendary py-2 px-4 fs-6">
                                {{ __('إقرأ المزيد') }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h3 class="text-muted">{{ __('لا توجد أنشطة حالياً') }}</h3>
                </div>
            @endforelse
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $activities->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .activity-card-legendary {
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
        transition: var(--transition-base);
    }
    .activity-card-legendary:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-strong);
    }
    .activity-img-wrap { position: relative; height: 260px; }
    .activity-img-wrap img { height: 100%; width: 100%; object-fit: cover; }
    .activity-cat-badge {
        position: absolute;
        top: 20px; 
        inset-inline-end: 20px;
        background: var(--accent);
        color: #000;
        padding: 5px 15px;
        border-radius: 50px;
        font-weight: 800;
        font-size: 0.75rem;
    }
    .activity-body-v3 { padding: 2rem; }
    .activity-date { color: var(--accent-dark); font-weight: 700; font-size: 0.85rem; }
</style>
@endpush
