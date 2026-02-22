<footer class="footer-legendary">
    <div class="container">
        <div class="row g-5">
            {{-- Brand Section --}}
            <div class="col-lg-4 footer-brand">
                <h4 class="text-white fw-black">{{ setting('company_name_' . app()->getLocale(), __('الصفوة')) }}</h4>
                <p class="mb-4 text-white opacity-50">{{ setting('company_tagline_' . app()->getLocale(), __('للتجارة والاستثمار - شريككم الموثوق في النجاح')) }}</p>
                <div class="social-links d-flex gap-3">
                    @php
                        $socials = [
                            'facebook' => ['url' => setting('facebook_url'), 'icon' => 'fab fa-facebook-f'],
                            'twitter' => ['url' => setting('twitter_url'), 'icon' => 'fab fa-twitter'],
                            'instagram' => ['url' => setting('instagram_url'), 'icon' => 'fab fa-instagram'],
                            'linkedin' => ['url' => setting('linkedin_url'), 'icon' => 'fab fa-linkedin-in'],
                        ];
                    @endphp
                    @foreach($socials as $name => $data)
                        <a href="{{ $data['url'] ?: '#' }}" class="social-link" target="_blank"><i class="{{ $data['icon'] }}"></i></a>
                    @endforeach
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="col-lg-2 col-md-4 footer-link-group">
                <h5 class="text-white">{{ __('روابط سريعة') }}</h5>
                <ul class="footer-links list-unstyled p-0">
                    <li><a href="{{ route('home') }}" class="text-white opacity-75">{{ __('الرئيسية') }}</a></li>
                    <li><a href="{{ route('about') }}" class="text-white opacity-75">{{ __('من نحن') }}</a></li>
                    <li><a href="{{ route('services.index') }}" class="text-white opacity-75">{{ __('خدماتنا') }}</a></li>
                    <li><a href="{{ route('contact') }}" class="text-white opacity-75">{{ __('تواصل معنا') }}</a></li>
                </ul>
            </div>

            {{-- Services --}}
            <div class="col-lg-3 col-md-4 footer-link-group">
                <h5 class="text-white">{{ __('خدماتنا') }}</h5>
                <ul class="footer-links list-unstyled p-0">
                    @php $footerServices = \App\Models\Service::where('status','published')->take(5)->get(); @endphp
                    @forelse($footerServices as $svc)
                        <li><a href="{{ route('services.show', $svc->slug) }}" class="text-white opacity-75">{{ $svc->{'title_' . app()->getLocale()} }}</a></li>
                    @empty
                        <li><span class="text-white opacity-50">{{ __('متوفرة قريباً') }}</span></li>
                    @endforelse
                </ul>
            </div>

            {{-- Contact Info --}}
            <div class="col-lg-3 col-md-4 footer-link-group">
                <h5 class="text-white">{{ __('معلومات الاتصال') }}</h5>
                <ul class="footer-links contact-details list-unstyled p-0">
                    <li class="d-flex gap-3 mb-3">
                        <i class="fas fa-map-marker-alt text-accent mt-1"></i>
                        <span class="text-white opacity-75">{{ setting('company_address_' . app()->getLocale(), __('المملكة العربية السعودية، جدة')) }}</span>
                    </li>
                    <li class="d-flex gap-3 mb-3">
                        <i class="fas fa-phone-alt text-accent mt-1"></i>
                        <span class="text-white opacity-75" dir="ltr">{{ setting('company_phone', '+966 000 000 000') }}</span>
                    </li>
                    <li class="d-flex gap-3">
                        <i class="fas fa-envelope text-accent mt-1"></i>
                        <span class="text-white opacity-75">{{ setting('company_email', 'info@alsafua.com') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom mt-5 pt-4 border-top border-secondary border-opacity-10 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <p class="mb-0 text-sm opacity-50 text-white">© {{ date('Y') }} {{ setting('company_name_' . app()->getLocale(), __('الصفوة')) }}. {{ __('جميع الحقوق محفوظة') }}</p>
            <div class="d-flex gap-4 text-sm">
                <a href="#" class="text-white opacity-50">{{ __('سياسة الخصوصية') }}</a>
                <a href="#" class="text-white opacity-50">{{ __('الشروط والأحكام') }}</a>
            </div>
        </div>
    </div>
</footer>

<style>
    .social-link {
        width: 40px; height: 40px;
        background: rgba(255,255,255,0.05);
        display: flex; align-items: center; justify-content: center;
        border-radius: 12px;
        color: #fff;
        transition: 0.3s;
    }
    .social-link:hover {
        background: var(--accent);
        color: #000;
        transform: translateY(-5px);
    }
    .text-accent { color: var(--accent); }
</style>
