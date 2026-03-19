<!DOCTYPE html>
<html style="overflow-x: hidden;" lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head >
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

        /* ── CMS Content Typography ── */
        .cms-content, .typography-rich {
            line-height: 1.8;
            color: #475569;
        }
        .cms-content h2, .typography-rich h2,
        .cms-content h3, .typography-rich h3,
        .cms-content h4, .typography-rich h4 {
            color: var(--primary-dark);
            font-weight: 800;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }
        .cms-content ul, .typography-rich ul,
        .cms-content ol, .typography-rich ol {
            margin-bottom: 1.5rem;
            padding-inline-start: 1.5rem;
        }
        .cms-content li, .typography-rich li {
            margin-bottom: 0.5rem;
        }
        .cms-content p, .typography-rich p {
            margin-bottom: 1.2rem;
        }
        .cms-content a, .typography-rich a {
            color: var(--primary);
            text-decoration: underline;
        }
        .cms-content blockquote, .typography-rich blockquote {
            border-inline-start: 4px solid var(--accent);
            padding: 1rem 1.5rem;
            background: #f8fafc;
            border-radius: 8px;
            font-style: italic;
            margin-bottom: 1.5rem;
        }
        .cms-content table, .typography-rich table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem;
        }
        .cms-content table td, .cms-content table th,
        .typography-rich table td, .typography-rich table th {
            border: 1px solid #e2e8f0;
            padding: 0.75rem;
        }
        .cms-content table th, .typography-rich table th {
            background: #f1f5f9;
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
(function () {

    console.log("MOBILE MENU SCRIPT LOADED");

    const mobMenu   = document.getElementById('mobileMenu');
    const closeBtn  = document.getElementById('closeMobileMenu');

    if (!mobMenu) {
        console.error('mobileMenu element NOT FOUND');
        return;
    }

    /* ========================
       OPEN MOBILE MENU (FORCED)
       ======================== */
    document.addEventListener('click', function (e) {
        const openBtn = e.target.closest('#mobileMenuToggle');
        if (!openBtn) return;

        console.log('MOBILE MENU OPEN');

        e.preventDefault();
        e.stopPropagation();

        mobMenu.classList.add('open');
        document.body.style.overflow = 'hidden';
    }, true);


    /* ========================
       CLOSE MOBILE MENU
       ======================== */
    document.addEventListener('click', function (e) {
        const closeBtnClicked = e.target.closest('#closeMobileMenu');
        const overlayClicked = e.target.closest('.mobile-menu-overlay');

        if (!closeBtnClicked && !overlayClicked) return;

        console.log('MOBILE MENU CLOSE');

        e.preventDefault();
        e.stopPropagation();

        mobMenu.classList.remove('open');
        document.body.style.overflow = '';
    }, true);


    /* ========================
       CLOSE ON ESC
       ======================== */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && mobMenu.classList.contains('open')) {
            mobMenu.classList.remove('open');
            document.body.style.overflow = '';
        }
    });


    /* ========================
       SUBMENU TOGGLE
       ======================== */
    document.querySelectorAll('.mobile-nav-link[data-submenu]').forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            const target = document.getElementById(this.dataset.submenu);
            if (!target) return;

            const isOpen = target.classList.toggle('open');
            const icon   = this.querySelector('i');

            if (icon) {
                icon.classList.toggle('fa-chevron-down', !isOpen);
                icon.classList.toggle('fa-chevron-up', isOpen);
            }
        });
    });


    console.log("MOBILE MENU READY");

})();

/* ============================================================
   GLOBAL SITE INTERACTIONS (RESTORED)
   ============================================================ */
document.addEventListener('DOMContentLoaded', function() {
    // 1. AOS Animations
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 800, once: true, offset: 50 });
    }

    // 2. Navbar Scroll Effect & Back-to-Top
    const navbar = document.getElementById('siteNavbar');
    const backBtn = document.getElementById('backToTop');
    
    window.addEventListener('scroll', function() {
        const scrolled = window.scrollY > 50;
        if (navbar) navbar.classList.toggle('scrolled', scrolled);
        if (backBtn) backBtn.classList.toggle('visible', window.scrollY > 400);
    });

    if (backBtn) {
        backBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    }

    // 3. Mega Menu Logic (Desktop Hover + Mobile Click)
    const isMobile = () => window.innerWidth <= 991;
    const megaTriggers = document.querySelectorAll('.mega-trigger');
    const megaMenus = document.querySelectorAll('.mega-menu-v3');

    // Handle Mobile Click
    megaTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            if (!isMobile()) return;
            e.preventDefault();
            e.stopPropagation();
            const menu = this.closest('.has-mega-menu').querySelector('.mega-menu-v3');
            if (menu) {
                const isActive = menu.classList.contains('active');
                megaMenus.forEach(m => m.classList.remove('active'));
                if (!isActive) menu.classList.add('active');
            }
        });
    });

    // Close Mega Menus on Outside Click (Mobile)
    document.addEventListener('click', function(e) {
        if (isMobile() && !e.target.closest('.has-mega-menu')) {
            megaMenus.forEach(m => m.classList.remove('active'));
        }
    });

    // 4. Statistics Counters
    const counters = document.querySelectorAll('.stat-number');
    if (counters.length && typeof IntersectionObserver !== 'undefined') {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.dataset.target || 0);
                    const suffix = el.dataset.suffix || '';
                    let current = 0;
                    const duration = 2000;
                    const startTime = performance.now();

                    function animate(time) {
                        const progress = Math.min((time - startTime) / duration, 1);
                        current = Math.floor(progress * target);
                        el.innerText = current.toLocaleString() + suffix;
                        if (progress < 1) requestAnimationFrame(animate);
                    }
                    requestAnimationFrame(animate);
                    obs.unobserve(el);
                }
            });
        }, { threshold: 0.2 });
        counters.forEach(c => obs.observe(c));
    }
});
</script>


    @stack('scripts')
</body>
</html>
