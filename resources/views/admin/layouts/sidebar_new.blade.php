<aside class="sidebar">
    <div class="sidebar-header">
        <i class="fas fa-cube text-primary fs-3 me-2"></i>
        <span class="logo-text">الصفوة <span class="text-secondary fw-light text-sm">لوحة التحكم</span></span>
    </div>

    <div class="sidebar-menu">
        <div class="menu-item">
            <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home menu-icon"></i>
                <span>الرئيسية</span>
            </a>
        </div>

        <div class="text-uppercase text-muted text-xs fw-bold px-3 mt-3 mb-2">المحتوى</div>

        <div class="menu-item">
            <a href="{{ route('admin.pages.index') }}" class="menu-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                <i class="fas fa-file-alt menu-icon"></i>
                <span>الصفحات</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('admin.services.index') }}" class="menu-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <i class="fas fa-concierge-bell menu-icon"></i>
                <span>الخدمات</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('admin.sliders.index') }}" class="menu-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                <i class="fas fa-images menu-icon"></i>
                <span>السلايدر</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('admin.agencies.index') }}" class="menu-link {{ request()->routeIs('admin.agencies.*') ? 'active' : '' }}">
                <i class="fas fa-building menu-icon"></i>
                <span>الوكالات</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('admin.activities.index') }}" class="menu-link {{ request()->routeIs('admin.activities.*') ? 'active' : '' }}">
                <i class="fas fa-newspaper menu-icon"></i>
                <span>المركز الإعلامي</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('admin.gallery.index') }}" class="menu-link {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                <i class="fas fa-photo-video menu-icon"></i>
                <span>معرض الصور</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('admin.branches.index') }}" class="menu-link {{ request()->routeIs('admin.branches.*') ? 'active' : '' }}">
                <i class="fas fa-map-marked-alt menu-icon"></i>
                <span>الفروع</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('admin.counters.index') }}" class="menu-link {{ request()->routeIs('admin.counters.*') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt menu-icon"></i>
                <span>إحصائيات الشركة</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('admin.products.index') }}" class="menu-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fas fa-box menu-icon"></i>
                <span>المنتجات</span>
            </a>
        </div>
        
        <div class="menu-item">
            <a href="{{ route('admin.partners.index') }}" class="menu-link {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
                <i class="fas fa-handshake menu-icon"></i>
                <span>الشركاء</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('admin.distributors.index') }}" class="menu-link {{ request()->routeIs('admin.distributors.*') ? 'active' : '' }}">
                <i class="fas fa-truck-loading menu-icon"></i>
                <span>الموزعين</span>
            </a>
        </div>

        <div class="text-uppercase text-muted text-xs fw-bold px-3 mt-3 mb-2">الإدارة</div>

        <div class="menu-item">
            <a href="{{ route('admin.users.index') }}" class="menu-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users menu-icon"></i>
                <span>المستخدمين</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('admin.roles.index') }}" class="menu-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                <i class="fas fa-user-shield menu-icon"></i>
                <span>الأدوار والصلاحيات</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('admin.settings.index') }}" class="menu-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fas fa-cogs menu-icon"></i>
                <span>الإعدادات العامة</span>
            </a>
        </div>

        <div class="menu-item">
             <a href="{{ route('admin.reports.index') }}" class="menu-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <i class="fas fa-chart-pie menu-icon"></i>
                <span>التقارير</span>
            </a>
        </div>
    </div>

    <div class="sidebar-footer">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100 btn-sm">
                <i class="fas fa-sign-out-alt me-1"></i> تسجيل الخروج
            </button>
        </form>
    </div>
</aside>
