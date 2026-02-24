@extends('frontend.layouts.app')

@section('title', __('معرض الصور'))

@section('content')
{{-- Inner Page Hero --}}
<section class="inner-page-hero">
    <div class="inner-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1542031026-64c8d5573752?w=1600&q=80')"></div>
    <div class="inner-hero-overlay"></div>
    <div class="container position-relative" style="z-index: 2; padding-top:80px">
        <div class="inner-hero-content">
            <span class="section-suptitle text-white opacity-75">{{ __('توثيق الإنجازات') }}</span>
            <h1 class="inner-title">{{ __('معرض الصور') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb custom-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('المعرض') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- Gallery Section --}}
<section class="section-legendary">
    <div class="container">
        {{-- Categories Filter --}}
        <div class="d-flex flex-wrap justify-content-center gap-2 mb-5" data-aos="fade-up">
            <a href="{{ route('gallery.index') }}" class="btn-filter {{ !request('category') ? 'active' : '' }}">{{ __('الكل') }}</a>
            @php $g_categories = \App\Models\GalleryCategory::where('status','active')->get(); @endphp
            @foreach($g_categories as $cat)
                <a href="{{ route('gallery.index', ['category' => $cat->slug]) }}" class="btn-filter {{ request('category') == $cat->slug ? 'active' : '' }}">
                    {{ $cat->{'name_' . app()->getLocale()} }}
                </a>
            @endforeach
        </div>

        <div class="row g-4 masonry-grid">
            @forelse($images as $image)
                <div class="col-lg-4 col-md-6 grid-item" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 50 }}">
                    <div class="gallery-item-v3">
                        <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $image->title_ar }}">
                        <div class="gallery-overlay-legend">
                            <h6 class="text-white fw-black mb-1">{{ $image->{'title_' . app()->getLocale()} }}</h6>
                            <span class="text-accent text-sm fw-bold">{{ optional($image->category)->{'name_' . app()->getLocale()} }}</span>
                            <a href="{{ asset('storage/' . $image->image) }}" class="btn-zoom-gallery mt-3" data-fancybox="gallery">
                                <i class="fas fa-search-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h3 class="text-muted">{{ __('لا توجد صور في هذا القسم حالياً') }}</h3>
                </div>
            @endforelse
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $images->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .btn-filter {
        padding: 10px 25px;
        background: #fff;
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 50px;
        font-weight: 700;
        transition: 0.3s;
        color: var(--primary-dark);
    }
    .btn-filter.active, .btn-filter:hover {
        background: var(--primary);
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px -5px rgba(26, 58, 107, 0.2);
    }
    .gallery-item-v3 {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        aspect-ratio: 4/5;
        background: #eee;
    }
    .gallery-item-v3 img { width: 100%; height: 100%; object-fit: cover; transition: 0.8s; }
    .gallery-overlay-legend {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15, 35, 71, 0.9) 0%, transparent 60%);
        display: flex; flex-direction: column; justify-content: flex-end;
        padding: 2.5rem;
        opacity: 0;
        transition: var(--transition-base);
    }
    .gallery-item-v3:hover .gallery-overlay-legend { opacity: 1; }
    .gallery-item-v3:hover img { transform: scale(1.1); }
    .btn-zoom-gallery {
        width: 44px; height: 44px;
        background: var(--accent);
        color: #000;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem;
    }
</style>
@endpush
