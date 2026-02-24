@extends('frontend.layouts.app')

@section('title', $page->{'title_' . app()->getLocale()})

@section('content')
{{-- Inner Page Hero --}}
<section class="inner-page-hero">
    <div class="inner-hero-bg" style="background-image: url('{{ $page->image ? asset('storage/' . $page->image) : 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=1600&q=80' }}')"></div>
    <div class="inner-hero-overlay"></div>
    <div class="container position-relative" style="z-index: 2; padding-top:80px">
        <div class="inner-hero-content">
            <h1 class="inner-title">{{ $page->{'title_' . app()->getLocale()} }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb custom-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page->{'title_' . app()->getLocale()} }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- Page Content --}}
<section class="page-content-section section-pad">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="content-card-premium" data-aos="fade-up">
                    <div class="content-body typography-rich">
                        {!! $page->{'content_' . app()->getLocale()} !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Typography */
    .typography-rich {
        color: var(--gray-800);
        line-height: 2;
    }
    .typography-rich h2, .typography-rich h3 {
        color: var(--primary);
        font-weight: 800;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
</style>
@endpush
