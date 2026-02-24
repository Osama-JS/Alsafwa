@extends('frontend.layouts.app')

@section('title', $activity->{'title_' . app()->getLocale()})

@section('content')
{{-- Inner Page Hero --}}
<section class="inner-page-hero">
    <div class="inner-hero-bg" style="background-image: url('{{ $activity->image ? asset('storage/' . $activity->image) : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1600&q=80' }}')"></div>
    <div class="inner-hero-overlay"></div>
    <div class="container position-relative" style="z-index: 2; padding-top:80px">
        <div class="inner-hero-content" data-aos="fade-up">
            @if($activity->category)
                <span class="section-suptitle text-white opacity-75">{{ $activity->category->{'name_' . app()->getLocale()} }}</span>
            @endif
            <h1 class="inner-title">{{ $activity->{'title_' . app()->getLocale()} }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb custom-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('activities.index') }}">{{ __('الأنشطة') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $activity->{'title_' . app()->getLocale()} }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- Activity Detail Content --}}
<section class="section-legendary">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-10 mx-auto" data-aos="fade-up">
                <div class="activity-detail-card-premium overflow-hidden">
                    @if($activity->image)
                        <div class="detail-main-img mb-5">
                            <img src="{{ asset('storage/' . $activity->image) }}" class="w-100 rounded-5 shadow-strong" alt="{{ $activity->title_ar }}">
                        </div>
                    @endif

                    <div class="detail-body px-md-5">
                        <div class="d-flex align-items-center gap-4 mb-4 pb-4 border-bottom">
                            <div class="detail-date-box text-center">
                                <span class="d-block fs-3 fw-black text-primary">{{ $activity->created_at->format('d') }}</span>
                                <span class="text-xs text-uppercase opacity-50">{{ $activity->created_at->format('M Y') }}</span>
                            </div>
                            <div>
                                <h2 class="fw-black mb-1">{{ $activity->{'title_' . app()->getLocale()} }}</h2>
                                @if($activity->category) <span class="text-accent fw-bold">{{ $activity->category->{'name_' . app()->getLocale()} }}</span> @endif
                            </div>
                        </div>

                        <div class="typography-rich mb-5">
                            {!! $activity->{'description_' . app()->getLocale()} !!}
                        </div>

                        {{-- Gallery / Video (If any) --}}
                        @if($activity->video_url)
                            <div class="video-container rounded-5 overflow-hidden shadow-strong mt-5">
                                <iframe width="100%" height="500" src="{{ str_replace('watch?v=', 'embed/', $activity->video_url) }}" frameborder="0" allowfullscreen></iframe>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .detail-date-box {
        padding: 10px 20px;
        background: var(--off-white);
        border-radius: 18px;
        min-width: 90px;
    }
</style>
@endpush
