<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - توثيق مشروع الصفوة</title>
    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <!-- Prism for Code Highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />

    <style>
        body { font-family: 'Tajawal', sans-serif; background-color: #f8f9fa; color: #333; }
        .sidebar { position: fixed; top: 0; bottom: 0; right: 0; width: 280px; padding: 20px; background: #fff; border-left: 1px solid #dee2e6; overflow-y: auto; z-index: 1000; }
        .content { margin-right: 280px; padding: 40px; }
        .nav-link { color: #555; font-weight: 500; margin-bottom: 5px; border-radius: 5px; }
        .nav-link:hover, .nav-link.active { background-color: #e9ecef; color: #0d6efd; }
        .nav-group { margin-bottom: 20px; }
        .nav-group-title { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; color: #adb5bd; margin-bottom: 10px; font-weight: 700; }
        h1, h2, h3 { color: #2c3e50; font-weight: 700; }
        h1 { margin-bottom: 30px; border-bottom: 3px solid #0d6efd; padding-bottom: 15px; display: inline-block; }
        h2 { margin-top: 40px; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        h3 { margin-top: 30px; margin-bottom: 15px; font-size: 1.5rem; }
        .alert-info { border-right: 4px solid #0dcaf0; background-color: #f0fcff; }
        .alert-warning { border-right: 4px solid #ffc107; background-color: #fffbf0; }
        .img-fluid { border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin: 20px 0; border: 1px solid #eee; }
        code { background-color: #f1f3f5; padding: 2px 6px; border-radius: 4px; color: #d63384; }
        pre { border-radius: 8px; margin: 20px 0; }
        .step-number { display: inline-block; width: 30px; height: 30px; background: #0d6efd; color: #fff; text-align: center; line-height: 30px; border-radius: 50%; margin-left: 10px; font-weight: bold; }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(100%); transition: transform 0.3s ease; }
            .sidebar.show { transform: translateX(0); }
            .content { margin-right: 0; padding: 20px; }
        }
    </style>
</head>
<body>

    <!-- Mobile Toggle -->
    <button class="btn btn-primary d-lg-none m-3" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
        <i class="fas fa-bars"></i> القائمة
    </button>

    <!-- Sidebar -->
    <nav class="sidebar collapse d-lg-block" id="sidebarMenu">
        <div class="mb-4 text-center">
            <h4 class="fw-bold text-primary">📘 توثيق المشروع</h4>
            <p class="text-muted small">Al-Safua Documentation</p>
        </div>

        <div class="nav-group">
            <div class="nav-group-title">مقدمة</div>
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('docs.index') ? 'active' : '' }}" href="{{ route('docs.index') }}">
                    <i class="fas fa-home me-2"></i> نظرة عامة
                </a>
            </nav>
        </div>

        <div class="nav-group">
            <div class="nav-group-title">الأدلة</div>
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('docs.user-guide') ? 'active' : '' }}" href="{{ route('docs.user-guide') }}">
                    <i class="fas fa-user me-2"></i> دليل المستخدم
                </a>
                <a class="nav-link {{ request()->routeIs('docs.developer-guide') ? 'active' : '' }}" href="{{ route('docs.developer-guide') }}">
                    <i class="fas fa-code me-2"></i> دليل المطور
                </a>
            </nav>
        </div>

        <div class="mt-5 pt-3 border-top">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary w-100 btn-sm">
                <i class="fas fa-arrow-right me-2"></i> العودة للوحة التحكم
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content">
        @yield('content')

        <footer class="mt-5 pt-4 border-top text-center text-muted small">
            <p>&copy; {{ date('Y') }} جميع الحقوق محفوظة لشركة الصفوة.</p>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-bash.min.js"></script>
</body>
</html>
