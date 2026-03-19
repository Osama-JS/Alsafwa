@extends('frontend.layouts.app')

@section('title', $activity->{'title_' . app()->getLocale()})

@section('content')
{{-- Article Hero Section --}}
<section class="article-hero-section">
    <div class="article-hero-bg" style="background-image: url('{{ $activity->image ? asset('storage/' . $activity->image) : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1600&q=80' }}')"></div>
    <div class="article-hero-overlay"></div>
    <div class="container article-hero-container">
        <div class="article-hero-content" data-aos="fade-up">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb custom-breadcrumb light">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('activities.index') }}">{{ __('المركز الإعلامي') }}</a></li>
                    <li class="breadcrumb-item active text-white opacity-75" aria-current="page">{{ Str::limit($activity->{'title_' . app()->getLocale()}, 40) }}</li>
                </ol>
            </nav>
            
            @if($activity->category)
                <span class="article-category-badge mb-3">{{ $activity->category->{'name_' . app()->getLocale()} }}</span>
            @endif
            
            <h1 class="article-main-title">{{ $activity->{'title_' . app()->getLocale()} }}</h1>
            
            <div class="article-meta-header d-flex align-items-center gap-4 mt-4">
                <div class="meta-item-header">
                    <i class="far fa-calendar-alt text-accent me-2"></i>
                    <span>{{ $activity->created_at->format('M d, Y') }}</span>
                </div>
                <div class="meta-item-header">
                    <i class="far fa-clock text-accent me-2"></i>
                    <span>{{ __('5 دقائق قراءة') }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Article Content Section --}}
<section class="section-legendary bg-white">
    <div class="container">
        <div class="row g-5">
            {{-- Main Content --}}
            <div class="col-lg-8" data-aos="fade-up">
                <article class="article-body-wrapper">
                    <div class="article-intro-text mb-5">
                        {{ $activity->{'description_summary_' . app()->getLocale()} ?? Str::limit(strip_tags($activity->{'description_' . app()->getLocale()}), 200) }}
                    </div>
                    
                    <div class="typography-rich article-content-body">
                        {!! $activity->{'description_' . app()->getLocale()} !!}
                    </div>

                    @if($activity->video_url)
                        <div class="article-video-box mt-5 rounded-4 shadow-strong overflow-hidden">
                            <iframe width="100%" height="450" 
                                    src="{{ str_replace('watch?v=', 'embed/', $activity->video_url) }}" 
                                    frameborder="0" allowfullscreen></iframe>
                        </div>
                    @endif

                    {{-- Social Share --}}
                    <div class="article-share-footer mt-5 pt-4 border-top d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <h5 class="fw-bold mb-0">{{ __('هل أعجبك المقال؟ شاركه مع الآخرين') }}:</h5>
                        <div class="share-icons d-flex gap-2">
                            <a href="#" class="share-btn-round fb"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="share-btn-round tw"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="share-btn-round wa"><i class="fab fa-whatsapp"></i></a>
                            <a href="#" class="share-btn-round li"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </article>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                <aside class="article-sidebar" data-aos="fade-right">
                    {{-- Search Widget --}}
                    <div class="sidebar-widget mb-5">
                        <h5 class="widget-title mb-4">{{ __('بحث في المركز') }}</h5>
                        <form action="{{ route('activities.index') }}" method="GET" class="sidebar-search">
                            <input type="text" name="search" placeholder="{{ __('كلمة البحث...') }}" class="form-control rounded-pill px-4 py-3 border-0 bg-light">
                            <button type="submit" class="btn-search-sidebar"><i class="fas fa-search"></i></button>
                        </form>
                    </div>

                    {{-- Recent News Widget --}}
                    <div class="sidebar-widget mb-5">
                        <h5 class="widget-title mb-4">{{ __('أحدث الأخبار') }}</h5>
                        <div class="recent-posts-list d-flex flex-column gap-4">
                            @php 
                                $recentNews = \App\Models\Activity::where('id', '!=', $activity->id)->latest()->take(3)->get();
                            @endphp
                            @foreach($recentNews as $news)
                                <a href="{{ route('activities.show', $news->slug) }}" class="recent-post-item d-flex gap-3 text-decoration-none">
                                    <div class="recent-post-thumb">
                                        <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title_ar }}">
                                    </div>
                                    <div class="recent-post-info">
                                        <h6 class="text-dark fw-bold mb-1 line-clamp-2">{{ $news->{'title_' . app()->getLocale()} }}</h6>
                                        <span class="text-xs text-muted">{{ $news->created_at->format('d M, Y') }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Newsletter Widget --}}
                    <div class="sidebar-widget newsletter-widget-premium rounded-4 p-5 text-center text-white">
                        <i class="fas fa-envelope-open-text fs-1 mb-4"></i>
                        <h4 class="fw-black mb-3">{{ __('كن أول من يعلم') }}</h4>
                        <p class="text-sm opacity-75 mb-4">{{ __('اشترك في نشرتنا البريدية لتصلك آخر أخبار الصفوة مباشرة.') }}</p>
                        <form action="#" class="newsletter-sidebar-form">
                            <input type="email" placeholder="{{ __('بريدك الإلكتروني') }}" class="form-control rounded-pill mb-3 text-center border-0 py-3">
                            <button class="btn btn-accent w-100 rounded-pill py-3 fw-bold">{{ __('اشترك الآن') }}</button>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* ── Article Hero ── */
    .article-hero-section {
        position: relative;
        height: 60vh;
        min-height: 500px;
        display: flex;
        align-items: center;
        overflow: hidden;
    }
    .article-hero-bg {
        position: absolute; inset: 0;
        background-size: cover; background-position: center;
        transition: transform 10s ease;
    }
    .article-hero-section:hover .article-hero-bg { transform: scale(1.1); }
    .article-hero-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to bottom, rgba(10,25,55,0.4) 0%, rgba(10,25,55,0.9) 100%);
    }
    .article-hero-container { position: relative; z-index: 5; padding-top: 100px; }
    .article-main-title {
        color: #fff; font-size: clamp(2rem, 5vw, 3.5rem);
        font-weight: 900; line-height: 1.2; max-width: 900px;
    }
    .article-category-badge {
        display: inline-block; padding: 6px 18px;
        background: var(--accent); color: #000;
        border-radius: 50px; font-weight: 800; font-size: 0.85rem;
    }
    .meta-item-header { color: #fff; font-weight: 600; font-size: 0.95rem; }

    /* ── Article Content ── */
    .article-body-wrapper { line-height: 1.8; color: #444; }
    .article-intro-text {
        font-size: 1.25rem; font-weight: 600; color: var(--primary-dark);
        border-inline-start: 5px solid var(--accent); padding-inline-start: 25px;
    }
    .article-content-body { font-size: 1.15rem; }
    .article-content-body p { margin-bottom: 1.5rem; }
    
    /* ── Share Icons ── */
    .share-btn-round {
        width: 42px; height: 42px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        color: #fff; transition: var(--transition-base);
        text-decoration: none;
    }
    .share-btn-round:hover { transform: translateY(-3px); color: #fff; opacity: 0.9; }
    .fb { background: #3b5998; } .tw { background: #1da1f2; }
    .wa { background: #25d366; } .li { background: #0077b5; }

    /* ── Sidebar ── */
    .widget-title { font-weight: 800; border-inline-start: 4px solid var(--accent); padding-inline-start: 15px; }
    .sidebar-search { position: relative; }
    .btn-search-sidebar {
        position: absolute; inset-inline-end: 15px; top: 50%;
        transform: translateY(-50%); border: 0; background: none; color: var(--primary);
    }
    .recent-post-thumb { width: 80px; height: 80px; border-radius: 12px; overflow: hidden; flex-shrink: 0; }
    .recent-post-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .recent-post-item:hover h6 { color: var(--accent-dark) !important; }
    .newsletter-widget-premium {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        box-shadow: var(--shadow-strong);
    }
    .line-clamp-2 {
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
</style>
@endpush
