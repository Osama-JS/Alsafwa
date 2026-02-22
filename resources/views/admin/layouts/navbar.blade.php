<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Right navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link" target="_blank">
                <i class="fas fa-external-link-alt ml-1"></i> زيارة الموقع
            </a>
        </li>
    </ul>

    <!-- Left navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- User Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
                <span class="d-none d-md-inline">{{ auth()->user()->name ?? 'المستخدم' }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
                <span class="dropdown-item dropdown-header">الإعدادات</span>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.users.edit', auth()->id()) }}" class="dropdown-item">
                    <i class="fas fa-user-cog mr-2"></i> الملف الشخصي
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('admin.logout') }}" method="POST" class="d-block">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt mr-2"></i> تسجيل الخروج
                    </button>
                </form>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
