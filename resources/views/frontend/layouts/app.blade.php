<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @include('frontend.layouts.seo')

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 RTL/LTR -->
    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    @endif

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <!-- AOS Animations -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">

    <!-- Frontend CSS -->
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}">

    {{-- ── Dynamic Theme Colors from Admin Settings ── --}}
    <style>
        :root {
            --primary:       {{ setting('theme_primary_color', '#1a3a6b') }};
            --primary-dark:  {{ setting('theme_primary_dark', '#0f2347') }};
            --primary-light: {{ setting('theme_primary_light', '#2a5298') }};
            --accent:        {{ setting('theme_accent_color', '#c9a84c') }};
            --accent-dark:   {{ setting('theme_accent_dark', '#a8893a') }};
            --accent-light:  {{ setting('theme_accent_light', '#e8c96a') }};
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="bg-mesh" style="z-index: -999;"></div>
    <div class="cursor-dot" id="cursorDot" style="z-index: 9999; pointer-events: none;"></div>

    @include('frontend.layouts.navbar')

    <main>
        @yield('content')
    </main>

    @include('frontend.layouts.footer')

    {{-- Back to Top --}}
    <button class="back-to-top" id="backToTop" aria-label="Back to top">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <script>
        // High-priority toggle logic to run early
        (function() {
            function initMenu() {
                const mobMenu = document.getElementById('mobileMenu');
                const openBtn = document.getElementById('mobileMenuToggle');
                const closeBtn = document.getElementById('closeMobileMenu');

                if (openBtn && mobMenu) {
                    openBtn.onclick = function(e) {
                        e.preventDefault();
                        mobMenu.classList.add('open');
                        document.body.style.overflow = 'hidden';
                    };
                }
                if (closeBtn && mobMenu) {
                    closeBtn.onclick = function(e) {
                        e.preventDefault();
                        mobMenu.classList.remove('open');
                        document.body.style.overflow = '';
                    };
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initMenu);
            } else {
                initMenu();
            }
        })();

        // Secondary logic
        document.addEventListener('DOMContentLoaded', function() {
            try {
                if (typeof AOS !== 'undefined') {
                    AOS.init({ duration: 700, once: true, offset: 60 });
                }
            } catch(e) {}

            const navbar = document.getElementById('siteNavbar');
            if (navbar) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 50) navbar.classList.add('scrolled');
                    else navbar.classList.remove('scrolled');
                });
            }

            document.querySelectorAll('.mobile-nav-link[data-submenu]').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.getElementById(this.dataset.submenu);
                    if (target) {
                        const isOpen = target.classList.toggle('open');
                        const icon = this.querySelector('i');
                        if (icon) {
                            icon.classList.toggle('fa-chevron-down', !isOpen);
                            icon.classList.toggle('fa-chevron-up', isOpen);
                        }
                    }
                });
            });

            const backBtn = document.getElementById('backToTop');
            if (backBtn) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 400) backBtn.classList.add('visible');
                    else backBtn.classList.remove('visible');
                });
                backBtn.onclick = function() { window.scrollTo({ top: 0, behavior: 'smooth' }); };
            }

            const dot = document.getElementById('cursorDot');
            if (dot && window.innerWidth > 991) {
                document.addEventListener('mousemove', function(e) {
                    dot.style.transform = 'translate(' + e.clientX + 'px, ' + e.clientY + 'px)';
                });
            }

            const counters = document.querySelectorAll('.stat-number');
            if (counters.length && typeof IntersectionObserver !== 'undefined') {
                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            const el = entry.target;
                            const target = parseInt(el.dataset.target || el.innerText.replace(/\D/g, '')) || 0;
                            const suffix = el.dataset.suffix || '';
                            let current = 0;
                            const duration = 1500;
                            const startTime = performance.now();
                            function update(currentTime) {
                                const elapsed = currentTime - startTime;
                                const progress = Math.min(elapsed / duration, 1);
                                current = Math.floor(progress * target);
                                el.innerText = current.toLocaleString('en-US') + suffix;
                                if (progress < 1) requestAnimationFrame(update);
                            }
                            requestAnimationFrame(update);
                            observer.unobserve(el);
                        }
                    });
                }, { threshold: 0.5 });
                counters.forEach(function(c) { observer.observe(c); });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
