@extends('frontend.layouts.app')

@section('title', __('تواصل معنا'))

@section('content')
{{-- Inner Page Hero --}}
<section class="inner-page-hero">
    <div class="inner-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1534536281715-e28d76689b4d?w=1600&q=80')"></div>
    <div class="inner-hero-overlay"></div>
    <div class="container position-relative" style="z-index: 2; padding-top:80px">
        <div class="inner-hero-content">
            <span class="section-suptitle text-white opacity-75">{{ __('تواصل بلا حدود') }}</span>
            <h1 class="inner-title">{{ __('نحن بانتظار سماعك') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb custom-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('اتصل بنا') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- Contact Section --}}
<section class="section-legendary">
    <div class="container">
        <div class="row g-5">
            {{-- Contact Information --}}
            <div class="col-lg-5" data-aos="fade-right">
                <div class="contact-info-card-premium p-5 text-white h-100" style="background: var(--primary-dark); border-radius: 40px; position: relative; overflow: hidden;">
                    <div style="position:relative; z-index:2;">
                        <h2 class="fw-black mb-5">{{ __('أين تجدنا؟') }}</h2>

                        <div class="info-item-v3 mb-5">
                            <div class="info-icon-v3"><i class="fas fa-map-marker-alt"></i></div>
                            <div>
                                <h6 class="fw-black mb-2 opacity-50 text-uppercase">{{ __('العنوان') }}</h6>
                                <p class="mb-0 fs-5 fw-bold">{{ setting('company_address_' . app()->getLocale()) }}</p>
                            </div>
                        </div>

                        <div class="info-item-v3 mb-5">
                            <div class="info-icon-v3"><i class="fas fa-phone-alt"></i></div>
                            <div>
                                <h6 class="fw-black mb-2 opacity-50 text-uppercase">{{ __('اتصل بنا') }}</h6>
                                <p class="mb-0 fs-4 fw-black" dir="ltr">{{ setting('company_phone') }}</p>
                            </div>
                        </div>

                        <div class="info-item-v3 mb-5">
                            <div class="info-icon-v3"><i class="fas fa-envelope"></i></div>
                            <div>
                                <h6 class="fw-black mb-2 opacity-50 text-uppercase">{{ __('البريد الإلكتروني') }}</h6>
                                <p class="mb-0 fs-5 fw-bold">{{ setting('company_email') }}</p>
                            </div>
                        </div>

                        {{-- Social Links --}}
                        <div class="mt-5 pt-5 border-top border-white border-opacity-10">
                            <h6 class="fw-black text-accent mb-4">{{ __('تابعنا على') }}</h6>
                            <div class="social-circles d-flex gap-3">
                                @if(setting('facebook_url')) <a href="{{ setting('facebook_url') }}" class="social-circle"><i class="fab fa-facebook-f"></i></a> @endif
                                @if(setting('twitter_url')) <a href="{{ setting('twitter_url') }}" class="social-circle"><i class="fab fa-twitter"></i></a> @endif
                                @if(setting('instagram_url')) <a href="{{ setting('instagram_url') }}" class="social-circle"><i class="fab fa-instagram"></i></a> @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="col-lg-7" data-aos="fade-left">
                <div class="contact-form-card p-5 bg-white shadow-soft" style="border-radius: 40px;">
                    <h2 class="fw-black mb-4">{{ __('أرسل رسالة') }}</h2>
                    <p class="text-secondary mb-5">{{ __('سواء كان لديك استفسار أو ترغب في بدء تعاون جديد، نحن دائماً هنا للمساعدة.') }}</p>

                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius:15px;">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-sm">{{ __('الاسم الكامل') }}</label>
                                <input type="text" name="name" class="form-control-legendary" placeholder="{{ __('اسمك الكريم') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-sm">{{ __('البريد الإلكتروني') }}</label>
                                <input type="email" name="email" class="form-control-legendary" placeholder="email@example.com" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold text-sm">{{ __('الموضوع') }}</label>
                                <input type="text" name="subject" class="form-control-legendary" placeholder="{{ __('عنوان رسالتك') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold text-sm">{{ __('الرسالة') }}</label>
                                <textarea name="message" class="form-control-legendary" rows="6" placeholder="{{ __('كيف يمكننا مساعدتك؟') }}" required></textarea>
                            </div>
                            <div class="col-12 mt-5">
                                <button type="submit" class="btn-legendary w-100 py-3 fs-5">
                                    {{ __('إرسال الرسالة') }} <i class="fas fa-paper-plane ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .info-item-v3 { display: flex; gap: 1.5rem; align-items: flex-start; }
    .info-icon-v3 {
        width: 50px; height: 50px;
        background: rgba(255,255,255,0.1);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.25rem;
        color: var(--accent);
    }
    .social-circle {
        width: 44px; height: 44px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: #fff;
        transition: 0.3s;
    }
    .social-circle:hover { background: var(--accent); color: #000; transform: translateY(-5px); }

    .form-control-legendary {
        display: block; width: 100%;
        padding: 1.1rem 1.5rem;
        background: var(--off-white);
        border: 2px solid transparent;
        border-radius: 16px;
        font-weight: 500;
        transition: 0.3s;
    }
    .form-control-legendary:focus {
        background: #fff;
        border-color: var(--primary);
        box-shadow: 0 10px 30px -10px rgba(26, 58, 107, 0.1);
    }
</style>
@endpush
