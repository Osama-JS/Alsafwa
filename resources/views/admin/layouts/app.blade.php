<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'لوحة التحكم') - الصفوة</title>

    <!-- Google Font: Tajawal -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AdminLTE & Bootstrap 4 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.5.3/css/bootstrap.min.css">

    <style>
        body, h1, h2, h3, h4, h5, h6, p, a, span, .btn, .form-control {
            font-family: 'Tajawal', sans-serif !important;
        }

        /* Custom RTL Overrides for AdminLTE 3 */
        .layout-fixed .main-sidebar {
            right: 0;
            left: auto;
        }
        .content-wrapper {
            margin-right: 250px;
            margin-left: 0;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                margin-right: 0;
            }
        }

        .nav-sidebar .nav-link p {
            margin-right: .5rem;
            margin-left: 0;
        }

        .nav-icon {
            margin-left: .5rem;
        }

        /* Float fixes */
        .float-right { float: left !important; }
        .float-left { float: right !important; }
        .text-right { text-align: left !important; }
        .text-left { text-align: right !important; }

        /* Navbar fixes */
        .navbar-nav {
            padding-right: 0;
        }
        .navbar-nav .nav-item {
            float: right;
        }

        /* Card fixes */
        .card-title {
            float: right;
        }
        .card-tools {
            float: left;
        }
    </style>

    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    @include('admin.layouts.navbar')

    <!-- Main Sidebar -->
    @include('admin.layouts.sidebar')

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> نجاح!</h5>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> خطأ!</h5>
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Main Content -->
        <section class="content">
            @yield('content')
        </section>
    </div>

    @include('admin.layouts.footer')
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 RTL -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@stack('scripts')
</body>
</html>
