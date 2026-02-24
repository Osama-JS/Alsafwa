@extends('frontend.layouts.app')

@section('title', __('نتائج البحث'))

@section('content')
{{-- Inner Page Hero --}}
<section class="inner-page-hero">
    <div class="inner-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1454165833967-0746e126c04f?w=1600&q=80')"></div>
    <div class="inner-hero-overlay"></div>
    <div class="container position-relative" style="z-index: 2; padding-top:80px">
        <div class="inner-hero-content">
            <span class="section-suptitle text-white opacity-75">{{ __('البحث الذكي') }}</span>
            <h1 class="inner-title">{{ __('نتائج البحث') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb custom-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('نتائج البحث') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- Search Results Section --}}
<section class="section-legendary">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                {{-- Search Header --}}
                <div class="search-header-premium mb-5" data-aos="fade-up">
                    <h2 class="fw-black mb-2">{{ __('نتائج البحث عن') }}: <span class="text-accent">"{{ $query }}"</span></h2>
                    <p class="text-secondary">{{ __('تم العثور على') }} {{ count($results) }} {{ __('نتيجة مطابقة') }}</p>
                </div>

                {{-- Results List --}}
                <div class="search-results-list">
                    @forelse($results as $result)
                        <div class="search-result-item-v3 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="badge bg-primary-dark rounded-pill px-3 py-2" style="font-size:0.75rem;">{{ $result['type'] }}</span>
                            </div>
                            <h4 class="fw-black mb-3"><a href="{{ $result['url'] }}" class="hover-text-primary">{{ $result['title'] }}</a></h4>
                            <p class="text-secondary mb-4 opacity-75">{{ $result['description'] }}</p>
                            <a href="{{ $result['url'] }}" class="btn-read-more-v3">
                                {{ __('شاهد التفاصيل') }} <i class="fas fa-arrow-left ms-2"></i>
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-5" data-aos="zoom-in">
                            <i class="fas fa-search fs-1 text-muted mb-4 opacity-25"></i>
                            <h3 class="text-muted">{{ __('لم نجد أي نتائج تتطابق مع بحثك') }}</h3>
                            <p class="text-secondary mb-5">{{ __('حاول استخدام كلمات مفتاحية مختلفة') }}</p>
                            <a href="{{ route('home') }}" class="btn-legendary py-3 px-5">{{ __('العودة للرئيسية') }}</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .search-result-item-v3 {
        background: #fff;
        padding: 2.5rem;
        border-radius: 30px;
        border: 1px solid rgba(0,0,0,0.05);
        transition: var(--transition-base);
    }
    .search-result-item-v3:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-soft);
        border-color: var(--primary-light);
    }
    .hover-text-primary:hover { color: var(--primary); }
    .btn-read-more-v3 {
        display: inline-flex;
        align-items: center;
        font-weight: 800;
        color: var(--primary);
        font-size: 0.9rem;
        transition: 0.3s;
    }
    .btn-read-more-v3:hover { gap: 15px; color: var(--accent-dark); }
</style>
@endpush
