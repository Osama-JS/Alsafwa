<nav class="site-navbar" id="siteNavbar">
    <div class="navbar-inner">
        {{-- Brand --}}
        <a href="{{ route('home') }}" class="navbar-brand-wrap d-flex align-items-center gap-3">
            @if(setting('company_logo'))
                <img src="{{ asset('storage/' . setting('company_logo')) }}" alt="{{ setting('company_name_' . app()->getLocale()) }}" style="height:44px;width:auto;">
            @else
                <div class="brand-fallback-logo" style="width:40px;height:40px;background:var(--primary);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:1.2rem;">
                    {{ mb_substr(setting('company_name_' . app()->getLocale(), 'S'), 0, 1) }}
                </div>
            @endif
            <div class="d-none d-lg-flex flex-column line-height-1">
                <span class="navbar-brand-text">
                    {{ setting('company_name_' . app()->getLocale(), __('الصفوة')) }}
                </span>
                <span class="text-xs opacity-50 fw-bold d-none d-md-block">{{ setting('company_tagline_' . app()->getLocale(), __('للتجارة والاستثمار')) }}</span>
            </div>
        </a>

        {{-- Desktop Nav --}}
        <div class="d-none d-lg-flex align-items-center gap-2">
            <ul class="navbar-nav-wrap">
                <li class="nav-item-wrap"><a href="{{ route('home') }}" class="nav-link-item {{ request()->routeIs('home') ? 'active' : '' }}">{{ __('الرئيسية') }}</a></li>

                {{-- Services with Mega Menu --}}
                <li class="nav-item-wrap has-mega-menu">
                    <a href="javascript:void(0)" class="nav-link-item mega-trigger {{ request()->routeIs('services.*') ? 'active' : '' }}">
                        {{ __('خدماتنا') }}
                        <i class="fas fa-chevron-down ms-1 fs-xs opacity-50"></i>
                    </a>

                    {{-- Mega Menu Container --}}
                    <div class="mega-menu-v3">
                        <div class="mega-menu-inner p-4 p-lg-5">
                            <div class="row g-4">
                                {{-- Left Info Column --}}
                                <div class="col-lg-3 border-end">
                                    <h5 class="fw-black text-primary mb-3">{{ __('خدماتنا المتميزة') }}</h5>
                                    <p class="text-sm text-secondary mb-4">{{ __('استكشف باقة واسعة من الخدمات الاحترافية') }}</p>
                                    <a href="{{ route('services.index') }}" class="btn-legendary py-2 px-4 fs-xs">
                                        {{ __('جميع الخدمات') }}
                                    </a>
                                </div>
                                {{-- Services Grid Column --}}
                                <div class="col-lg-9">
                                    <div class="row g-4">
                                        @php $megaServices = \App\Models\Service::where('status','published')->orderBy('order')->take(8)->get(); @endphp
                                        @foreach($megaServices as $ms)
                                            <div class="col-lg-3 col-md-6">
                                                <a href="{{ route('services.show', $ms->slug) }}" class="mega-service-item">
                                                    <div class="mega-service-icon">
                                                        <i class="{{ $ms->icon ?: 'fas fa-rocket' }}"></i>
                                                    </div>
                                                    <div class="mega-service-text">
                                                        <span class="d-block fw-bold text-dark fs-sm">{{ $ms->{'title_' . app()->getLocale()} }}</span>
                                                        <span class="text-xs text-secondary opacity-75">{{ Str::limit($ms->{'description_' . app()->getLocale()}, 30) }}</span>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item-wrap"><a href="{{ route('agencies.index') }}" class="nav-link-item {{ request()->routeIs('agencies.*') ? 'active' : '' }}">{{ __('الوكالات') }}</a></li>
                <li class="nav-item-wrap"><a href="{{ route('products.index') }}" class="nav-link-item {{ request()->routeIs('products.*') ? 'active' : '' }}">{{ __('المنتجات') }}</a></li>
                {{-- About Us with Mega Menu --}}
                <li class="nav-item-wrap has-mega-menu">
                    <a href="javascript:void(0)" class="nav-link-item mega-trigger {{ request()->routeIs('about') || request()->routeIs('activities.*') ? 'active' : '' }}">
                        {{ __('من نحن') }}
                        <i class="fas fa-chevron-down ms-1 fs-xs opacity-50"></i>
                    </a>

                    {{-- Mega Menu Container --}}
                    <div class="mega-menu-v3">
                        <div class="mega-menu-inner p-4 p-lg-5">
                            <div class="row g-4">
                                {{-- Left Info Column --}}
                                <div class="col-lg-5 border-end">
                                    <div class="d-flex flex-column gap-3">
                                        @if(setting('company_logo'))
                                            <img src="{{ asset('storage/' . setting('company_logo')) }}" alt="{{ setting('company_name_' . app()->getLocale()) }}" style="height:60px;width:auto;align-self: flex-start;">
                                        @endif
                                        <h5 class="fw-black text-primary mb-1">{{ setting('company_name_' . app()->getLocale(), __('الصفوة')) }}</h5>
                                        <p class="text-sm text-secondary mb-0" style="max-width: 300px;">
                                            {{ setting('company_description_' . app()->getLocale(), setting('company_tagline_' . app()->getLocale(), __('رؤيتك.. واقعنا'))) }}
                                        </p>
                                    </div>
                                </div>
                                {{-- Links Column --}}
                                <div class="col-lg-7">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <a href="{{ route('about') }}" class="mega-service-item">
                                                <div class="mega-service-icon">
                                                    <i class="fas fa-info-circle"></i>
                                                </div>
                                                <div class="mega-service-text">
                                                    <span class="d-block fw-bold text-dark fs-sm">{{ __('قصتنا') }}</span>
                                                    <span class="text-xs text-secondary opacity-75">{{ __('تعرف علينا أكثر وعلى رؤيتنا') }}</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ route('activities.index') }}" class="mega-service-item">
                                                <div class="mega-service-icon">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </div>
                                                <div class="mega-service-text">
                                                    <span class="d-block fw-bold text-dark fs-sm">{{ __('الأنشطة') }}</span>
                                                    <span class="text-xs text-secondary opacity-75">{{ __('أحدث مستجداتنا وفعالياتنا') }}</span>
                                                </div>
                                            </a>
                                        </div>
                                        {{-- Placeholder for future items --}}
                                        <div class="col-md-6 opacity-50">
                                            <div class="mega-service-item cursor-default">
                                                <div class="mega-service-icon">
                                                    <i class="fas fa-plus-circle"></i>
                                                </div>
                                                <div class="mega-service-text">
                                                    <span class="d-block fw-bold text-dark fs-sm">{{ __('قريباً') }}</span>
                                                    <span class="text-xs text-secondary opacity-75">{{ __('المزيد من المعلومات') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="d-flex align-items-center gap-2 gap-md-3">
            <a href="{{ route('contact') }}" class="navbar-cta d-flex align-items-center gap-2">
                <span class="d-none d-sm-inline">{{ __('تواصل معنا') }}</span>
                <span class="d-inline d-sm-none">{{ __('اتصل بنا') }}</span>
                <i class="fas fa-phone-alt fs-xs"></i>
            </a>

            {{-- Lang --}}
            <div class="dropdown">
                <button class="nav-link-item border-0 bg-transparent px-2 px-md-3" data-bs-toggle="dropdown">
                    <i class="fas fa-globe"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-strong border-0 p-2 mt-3" style="border-radius:20px;">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <li><a class="dropdown-item rounded-4 py-2" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">{{ $properties['native'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Mobile Toggle --}}
            <button class="d-lg-none btn border-0 fs-3 p-0 ms-1" id="mobileMenuToggle" style="color:var(--primary-dark);">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</nav>

{{-- Mobile Menu --}}
<div class="mobile-menu" id="mobileMenu">
    <div class="mobile-menu-header d-flex justify-content-between align-items-center mb-4">
        <span class="fw-black text-white fs-4">{{ __('القائمة') }}</span>
        <button class="btn text-white fs-3 p-0" id="closeMobileMenu"><i class="fas fa-times"></i></button>
    </div>

    <form class="mobile-search-form" action="{{ route('search') }}" method="GET">
        <input type="search" name="q" placeholder="{{ __('بحث ما الذي تبحث عنه؟') }}..." value="{{ request('q') }}">
        <button type="submit"><i class="fas fa-search"></i></button>
    </form>

    <div class="mobile-nav-links">
        <a href="{{ route('home') }}" class="mobile-nav-link">
            <span>{{ __('الرئيسية') }}</span>
            <i class="fas fa-home fs-6 opacity-25"></i>
        </a>

        <a href="#" class="mobile-nav-link" data-submenu="mobileServices">
            <span>{{ __('خدماتنا') }}</span>
            <i class="fas fa-chevron-down fs-6 opacity-25"></i>
        </a>
        <div class="mobile-submenu" id="mobileServices">
            @php $mobileServices = \App\Models\Service::where('status','published')->take(5)->get(); @endphp
            @foreach($mobileServices as $svc)
                <a href="{{ route('services.show', $svc->slug) }}">{{ $svc->{'title_' . app()->getLocale()} }}</a>
            @endforeach
            <a href="{{ route('services.index') }}" class="text-accent fw-bold">{{ __('جميع الخدمات') }}</a>
        </div>

        <a href="{{ route('agencies.index') }}" class="mobile-nav-link">{{ __('الوكالات') }}</a>
        <a href="{{ route('products.index') }}" class="mobile-nav-link">{{ __('المنتجات') }}</a>
        <a href="{{ route('branches.index') }}" class="mobile-nav-link">{{ __('الفروع') }}</a>

        <a href="#" class="mobile-nav-link" data-submenu="mobileAbout">
            <span>{{ __('من نحن') }}</span>
            <i class="fas fa-chevron-down fs-6 opacity-25"></i>
        </a>
        <div class="mobile-submenu" id="mobileAbout">
            <a href="{{ route('about') }}">{{ __('قصتنا') }}</a>
            <a href="{{ route('activities.index') }}">{{ __('الأنشطة') }}</a>
        </div>

        <a href="{{ route('contact') }}" class="mobile-nav-link text-accent">
            <span>{{ __('تواصل معنا') }}</span>
            <i class="fas fa-phone-alt fs-6"></i>
        </a>
    </div>

    <div class="mt-auto pt-4 border-top border-white border-opacity-10 d-flex gap-2 flex-wrap justify-content-center">
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <a rel="alternate" hreflang="{{ $localeCode }}"
               href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
               class="btn btn-sm px-4 rounded-pill {{ app()->getLocale() == $localeCode ? 'btn-accent text-dark fw-bold' : 'btn-outline-light' }}">
                {{ $properties['native'] }}
            </a>
        @endforeach
    </div>
</div>
