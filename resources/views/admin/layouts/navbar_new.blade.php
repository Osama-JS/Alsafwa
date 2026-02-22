<nav class="top-navbar">
    <div class="d-flex align-items-center">
        <button class="btn btn-light d-lg-none me-3" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="d-none d-md-block">
            <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-external-link-alt me-1"></i> زيارة الموقع
            </a>
        </div>
    </div>

    <div class="d-flex align-items-center">
        <!-- Language Switcher -->
        <div class="dropdown me-3">
            <a href="#" class="btn btn-light btn-sm dropdown-toggle" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-globe me-1"></i> العربية
            </a>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                <li><a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL('ar') }}">العربية</a></li>
                <li><a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL('en') }}">English</a></li>
            </ul>
        </div>

        <!-- User Profile -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <span class="ms-2 fw-medium d-none d-md-inline text-dark">{{ auth()->user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm" aria-labelledby="userDropdown">
                <li class="px-3 py-2 text-center">
                    <div class="fw-bold">{{ auth()->user()->name }}</div>
                    <div class="text-muted text-xs">{{ auth()->user()->email }}</div>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('admin.users.edit', auth()->id()) }}"><i class="fas fa-user-cog me-2 text-secondary"></i> الملف الشخصي</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}"><i class="fas fa-sliders-h me-2 text-secondary"></i> الإعدادات</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i> تسجيل الخروج
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
