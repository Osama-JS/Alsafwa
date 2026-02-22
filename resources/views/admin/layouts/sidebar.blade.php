<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">شركة الصفوة</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>الرئيسية</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.pages.index') }}" class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>الصفحات</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>الخدمات</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.sliders.index') }}" class="nav-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-images"></i>
                        <p>السلايدر</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.agencies.index') }}" class="nav-link {{ request()->routeIs('admin.agencies.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>الوكالات</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.activities.index') }}" class="nav-link {{ request()->routeIs('admin.activities.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>الأنشطة</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.gallery.index') }}" class="nav-link {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-images"></i>
                        <p>معرض الصور</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.branches.index') }}" class="nav-link {{ request()->routeIs('admin.branches.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-map-marker-alt"></i>
                        <p>الفروع</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>المستخدمين</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>الأدوار</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>الإعدادات</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
