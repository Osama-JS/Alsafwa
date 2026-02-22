<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('تسجيل الدخول') }} | {{ setting('company_name_' . app()->getLocale(), 'الصفوة') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">

    <style>
        :root {
            --primary: {{ setting('theme_primary_color', '#0f2347') }};
            --primary-dark: {{ setting('theme_primary_dark', '#050a14') }};
            --accent: {{ setting('theme_accent_color', '#c9a84c') }};
            --accent-light: {{ setting('theme_accent_light', '#dbc078') }};
            --glass: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'IBM+Plex+Sans+Arabic', sans-serif;
            background-color: var(--primary-dark);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
            color: #fff;
        }

        /* Abstract Background Particles */
        .bg-glow {
            position: fixed;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(201, 168, 76, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            z-index: -1;
            filter: blur(80px);
        }
        .glow-1 { top: -200px; left: -200px; }
        .glow-2 { bottom: -200px; right: -200px; }

        .login-card {
            width: 100%;
            max-width: 450px;
            background: var(--glass);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 30px;
            padding: 3rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
            animation: fadeInScale 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.9) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .brand-logo {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .brand-logo h1 {
            font-family: 'Orbitron', sans-serif;
            font-weight: 900;
            letter-spacing: 2px;
            font-size: 2rem;
            margin: 0;
            background: linear-gradient(to right, #fff, var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 0.8rem;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 0.8rem 1.2rem;
            color: #fff;
            transition: all 0.3s;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(201, 168, 76, 0.15);
            color: #fff;
        }

        .btn-login {
            background: var(--accent);
            color: #000;
            border: none;
            border-radius: 12px;
            padding: 1rem;
            font-weight: 800;
            width: 100%;
            margin-top: 2rem;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-login:hover {
            background: var(--accent-light);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(201, 168, 76, 0.3);
            color: #000;
        }

        .error-msg {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #ff8e9a;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-size: 0.9rem;
            text-align: center;
        }

        .footer-text {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body>
    <div class="bg-glow glow-1"></div>
    <div class="bg-glow glow-2"></div>

    <div class="login-card">
        <div class="brand-logo">
            <h1>ALSAFUA</h1>
            <p class="mt-2 text-uppercase fw-bold text-accent" style="font-size: 0.7rem; letter-spacing: 3px;">{{ __('بوابة المدير') }}</p>
        </div>

        @if($errors->any())
            <div class="error-msg">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label">{{ __('البريد الإلكتروني') }}</label>
                <div class="position-relative">
                    <input type="email" name="email" class="form-control" placeholder="admin@alsafua.com" required value="{{ old('email') }}" autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">{{ __('كلمة المرور') }}</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label text-sm opacity-50" for="remember" style="font-size: 0.8rem;">
                        {{ __('تذكرني') }}
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-login">
                {{ __('دخول للنظام') }}
            </button>
        </form>

        <div class="footer-text">
            &copy; {{ date('Y') }} {{ setting('company_name_' . app()->getLocale(), 'الصفوة') }}. {{ __('جميع الحقوق محفوظة') }}
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
