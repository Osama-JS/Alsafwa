<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('الموقع قيد الصيانة') }} | {{ setting('site_name', 'الصفوة') }}</title>

    <!-- Google Font: Tajawal -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #0d6efd;
            --primary-dark: #0a58ca;
            --accent: #6366f1;
            --dark: #0f172a;
            --glass: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Tajawal', sans-serif;
        }

        body {
            background: var(--dark);
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated Background Mesh */
        .bg-mesh {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            background: radial-gradient(circle at 20% 30%, rgba(13, 110, 253, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 80% 70%, rgba(99, 102, 241, 0.15) 0%, transparent 50%);
            filter: blur(80px);
            animation: pulse 15s infinite alternate;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            100% { transform: scale(1.2); }
        }

        /* Particles Layer */
        .particles {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(#ffffff 0.5px, transparent 0.5px);
            background-size: 50px 50px;
            opacity: 0.1;
            z-index: 1;
        }

        .maintenance-container {
            position: relative;
            z-index: 10;
            width: 90%;
            max-width: 700px;
            text-align: center;
            padding: 60px 40px;
            border-radius: 40px;
            background: var(--glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-logo {
            font-size: 3.5rem;
            color: var(--primary);
            margin-bottom: 20px;
            filter: drop-shadow(0 0 15px rgba(13, 110, 253, 0.5));
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .maintenance-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 15px;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .maintenance-desc {
            font-size: 1.1rem;
            color: #94a3b8;
            line-height: 1.8;
            margin-bottom: 40px;
        }

        /* Modern Progress Loader */
        .loader-wrapper {
            margin: 40px auto;
            width: 100%;
            max-width: 400px;
            height: 6px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .loader-bar {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 40%;
            background: linear-gradient(to right, var(--primary), var(--accent));
            border-radius: 10px;
            animation: loading 2s ease-in-out infinite;
            box-shadow: 0 0 15px var(--primary);
        }

        @keyframes loading {
            0% { left: -40%; }
            100% { left: 100%; }
        }

        .contact-info {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 50px;
        }

        .social-btn {
            width: 50px;
            height: 50px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--glass-border);
        }

        .social-btn:hover {
            background: var(--primary);
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .footer-tag {
            margin-top: 40px;
            font-size: 0.9rem;
            color: #64748b;
        }

        .btn-status {
            display: inline-block;
            padding: 8px 16px;
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 25px;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        [dir="rtl"] .maintenance-title { letter-spacing: 0; }
        [dir="ltr"] .maintenance-title { letter-spacing: -1px; }

        @media (max-width: 768px) {
            .maintenance-container { padding: 40px 20px; width: 95%; }
            .maintenance-title { font-size: 1.8rem; }
            .maintenance-desc { font-size: 1rem; }
        }
    </style>
</head>
<body>

    <div class="bg-mesh"></div>
    <div class="particles"></div>

    <div class="maintenance-container">
        <div class="btn-status">
            <i class="fas fa-tools me-1"></i> {{ __('يتم الآن التحديث والتحسين') }}
        </div>

        <div class="brand-branding mb-5">
            <a href="{{ route('home') }}" class="d-flex flex-column align-items-center gap-3 text-decoration-none">
                @if(setting('company_logo'))
                    <img src="{{ asset('storage/' . setting('company_logo')) }}" alt="{{ setting('company_name_' . app()->getLocale()) }}" class="maintenance-logo">
                @else
                    <div class="brand-fallback-logo-lg mb-2">
                        {{ mb_substr(setting('company_name_' . app()->getLocale(), 'S'), 0, 1) }}
                    </div>
                @endif
                <div class="brand-text-content">
                    <h2 class="maintenance-brand-name">
                        {{ setting('company_name_' . app()->getLocale(), __('الصفوة')) }}
                    </h2>
                    <p class="maintenance-tagline">
                        {{ setting('company_tagline_' . app()->getLocale(), __('للتجارة والاستثمار - شريككم الموثوق في النجاح')) }}
                    </p>
                </div>
            </a>
        </div>

        <h1 class="maintenance-title">{{ __('نعمل على تحسين تجربتكم') }}</h1>

        <p class="maintenance-desc">
            {{ __('نحن حالياً في مهمة لتحديث خدماتنا وتطوير الموقع لتقديم الأفضل لكم. سنعود قريباً جداً ببنية تحتية أقوى وأداء أسرع.') }}
            <br>
            <span style="font-style: italic; opacity: 0.8;">Working on something amazing. We will be back shortly!</span>
        </p>

        <div class="loader-wrapper">
            <div class="loader-bar"></div>
        </div>

        <div class="contact-info">
            <a href="mailto:{{ setting('site_email') }}" class="social-btn" title="Email Us">
                <i class="fas fa-envelope"></i>
            </a>
            <a href="{{ setting('facebook_url') }}" class="social-btn" title="Facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="{{ setting('twitter_url') }}" class="social-btn" title="Twitter">
                <i class="fab fa-x-twitter"></i>
            </a>
            <a href="tel:{{ setting('site_phone') }}" class="social-btn" title="Call Us">
                <i class="fas fa-phone"></i>
            </a>
        </div>

        <div class="footer-tag">
            &copy; {{ date('Y') }} {{ setting('site_name', 'شركة الصفوة') }}. All rights reserved.
        </div>
    </div>

</body>
</html>
