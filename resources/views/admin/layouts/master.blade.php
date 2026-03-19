<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'لوحة التحكم') - الصفوة</title>

    <!-- Google Font: Tajawal -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    @stack('styles')
</head>
<body>

    <div class="dashboard-container">
        <!-- Sidebar -->
        @include('admin.layouts.sidebar_new')

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Navbar -->
            @include('admin.layouts.navbar_new')

            <!-- Page Content -->
            <div class="p-4">

                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="page-title">@yield('page_title')</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 text-sm opacity-75">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">الرئيسية</a></li>
                                @yield('breadcrumb')
                            </ol>
                        </nav>
                    </div>
                    <div>
                        @yield('action_button')
                    </div>
                </div>

                <!-- Alerts -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <ul class="mb-0 list-unstyled">
                            @foreach($errors->all() as $error)
                                <li><i class="fas fa-exclamation-triangle me-2"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Content -->
                @yield('content')

            </div>

            <!-- Footer -->
            <footer class="mt-auto p-4 text-center text-muted text-sm border-top">
                    جميع الحقوق محفوظة &copy; {{ date('Y') }} <span class="fw-bold text-primary">شركة الصفوة</span>
            </footer>
        </main>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (Optional, if needed for plugins) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>



    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Dashboard Script -->
    <script src="{{ asset('js/dashboard.js') }}"></script>

    <!-- Global Delete Confirmation Script -->
    <script>
        /* ── Legacy: intercept any form[action*=destroy] submit ── */
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('form[action*="destroy"]');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'هل أنت متأكد؟',
                        text: "لن تتمكن من التراجع عن هذا الإجراء!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'نعم، احذف!',
                        cancelButtonText: 'إلغاء',
                        customClass: { popup: 'swal2-rtl' }
                    }).then((result) => {
                        if (result.isConfirmed) { form.submit(); }
                    });
                });
            });
        });

        /* ── New: called directly from action buttons ── */
        function confirmDelete(url, itemName) {
            Swal.fire({
                title: 'تأكيد الحذف',
                html: `هل تريد حذف <strong>${itemName}</strong>؟<br><small class="text-muted">لا يمكن التراجع عن هذا الإجراء.</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="fas fa-trash me-1"></i> نعم، احذف',
                cancelButtonText: 'إلغاء',
                reverseButtons: false,
                customClass: { popup: 'swal2-rtl' }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;
                    form.innerHTML = `
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>

    <!-- CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editors = document.querySelectorAll('.editor-rich');
            editors.forEach(editor => {
                ClassicEditor
                    .create(editor, {
                        language: 'ar',
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo'],
                        dir: 'rtl'
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        });
    </script>

    @stack('scripts')

    {{-- Sidebar Toggle (inline — always fresh, no cache issues) --}}
    <script>
        (function() {
            var btn     = document.getElementById('sidebarToggle');
            var sidebar = document.querySelector('.sidebar');
            if (!btn || !sidebar) return;

            // overlay
            var overlay = document.createElement('div');
            overlay.style.cssText = 'display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:998;';
            document.body.appendChild(overlay);

            btn.addEventListener('click', function() {
                var open = sidebar.classList.toggle('active');
                overlay.style.display = open ? 'block' : 'none';
            });
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.style.display = 'none';
            });
        })();
    </script>
</body>
</html>
