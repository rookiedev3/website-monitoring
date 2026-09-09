<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | IT Solution Monitoring</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.jpeg') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg-main: #ffffff;
            --border-focus: #10b981;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --accent-green: #059669;
            --accent-glow: rgba(16, 185, 129, 0.15);
            --red-alert: #dc2626;
            --red-glow: rgba(220, 38, 38, 0.1);
        }

        * {
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            width: 100vw;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-main);
            color: var(--text-main);
            overflow-x: hidden;
            overflow-y: auto;
            position: relative;
        }

        .login-fullscreen-wrapper {
            width: 100vw;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1.15fr 1fr;
            position: relative;
            animation: fadeIn 0.8s ease forwards;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        .left-wave-side {
            background: #064e3b;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 60px 80px;
        }

        .wave-svg-container {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        .wave-svg {
            position: absolute;
            top: -15%; left: -15%;
            width: 155%; height: 130%;
            object-fit: fill;
        }

        .wave-layer-1 {
            animation: waveFloat1 10s ease-in-out infinite alternate;
            opacity: 0.95;
        }

        .wave-layer-2 {
            animation: waveFloat2 14s ease-in-out infinite alternate;
            opacity: 0.65;
        }

        @keyframes waveFloat1 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-3%, 2%) scale(1.04); }
        }

        @keyframes waveFloat2 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(4%, -3%) scale(1.06); }
        }

        .left-content {
            position: relative;
            z-index: 3;
            max-width: 520px;
            margin: auto 0;
        }

        .welcome-title {
            font-size: 52px;
            font-weight: 800;
            letter-spacing: -1.5px;
            color: #fff;
            margin-bottom: 8px;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }

        .welcome-subtitle {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 3px;
            color: #ffffff; /* Diubah menjadi putih agar sangat jelas dan kontras */
            text-transform: uppercase;
        }

        .left-footer-info {
            position: relative;
            z-index: 3;
            font-size: 13px;
            color: #cbd5e1;
        }

        /* SISI KANAN: Form Sign In (Tanpa border/bayangan sama sekali) */
        .right-form-side {
            padding: 40px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #ffffff;
            position: relative;
            max-width: 540px;
            width: 100%;
            margin: auto;
            z-index: 3;
            box-shadow: none !important;
            border: none !important;
            min-height: 100vh;
        }

        .form-label {
            font-size: 12px !important;
            font-weight: 700 !important;
            color: var(--text-muted) !important;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 6px !important;
        }

        .input-group-custom, .password-container {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            color: var(--text-muted);
            font-size: 18px;
            z-index: 10;
            transition: color 0.3s ease;
        }

        .form-control {
            border-radius: 14px;
            padding: 12px 18px 12px 50px;
            font-size: 14.5px;
            border: 1px solid #cbd5e1;
            background-color: #f8fafc;
            color: var(--text-main);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .password-container .form-control {
            padding-right: 50px;
        }

        .form-control:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 4px var(--accent-glow);
            background-color: #ffffff;
            color: #0f172a;
            transform: translateY(-1px);
        }

        .form-control:focus + .input-icon,
        .input-group-custom:focus-within .input-icon {
            color: var(--accent-green);
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #f8fafc inset !important;
            -webkit-text-fill-color: var(--text-main) !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        .password-toggle-btn {
            position: absolute;
            right: 16px;
            background: transparent;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            z-index: 10;
            transition: color 0.2s ease;
        }

        .password-toggle-btn:hover {
            color: var(--accent-green);
        }

        .btn-custom-login {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            border: none;
            border-radius: 14px;
            padding: 14px;
            font-weight: 700;
            font-size: 15px;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);
            position: relative;
            overflow: hidden;
        }

        .btn-custom-login::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
            transition: 0.5s;
        }

        .btn-custom-login:hover::after {
            left: 100%;
        }

        .btn-custom-login:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: #ffffff;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            transform: translateY(-2px);
        }

        .form-check-input {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            cursor: pointer;
            width: 18px;
            height: 18px;
        }

        .form-check-input:checked {
            background-color: var(--accent-green);
            border-color: var(--accent-green);
        }

        .divider-text {
            display: flex;
            align-items: center;
            text-align: center;
            color: var(--text-muted);
            font-size: 12px;
            margin: 14px 0;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .divider-text::before,
        .divider-text::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .divider-text:not(:empty)::before {
            margin-right: 0.75em;
        }

        .divider-text:not(:empty)::after {
            margin-left: 0.75em;
        }

        .btn-google {
            background: #f8fafc;
            color: var(--text-main);
            border: 1px solid #cbd5e1;
            border-radius: 14px;
            padding: 12px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.2s ease;
            width: 100%;
            text-decoration: none;
        }

        .btn-google:hover {
            background: #f1f5f9;
            color: var(--text-main);
            border-color: #94a3b8;
            transform: translateY(-1px);
        }

        .btn-google img {
            width: 18px;
            height: 18px;
        }

        .register-link-text {
            text-align: center;
            font-size: 13.5px;
            color: var(--text-muted);
            margin-top: 14px;
            margin-bottom: 0;
        }

        .register-link-text a {
            color: var(--accent-green);
            font-weight: 600;
            text-decoration: none;
        }

        .register-link-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 991px) {
            .login-fullscreen-wrapper {
                grid-template-columns: 1fr;
            }
            .left-wave-side {
                display: none;
            }
            .right-form-side {
                padding: 40px 24px;
                min-height: 100vh;
                justify-content: center;
                box-shadow: none;
            }
        }
    </style>
</head>

<body>

    <div class="login-fullscreen-wrapper">

        <!-- SISI KIRI -->
        <div class="left-wave-side">
            <div class="wave-svg-container">
                <svg class="wave-svg wave-layer-2" viewBox="0 0 1000 1000" preserveAspectRatio="none">
                    <path d="M 0,0 
                            C 550,180 250,450 680,620 
                            C 950,750 450,920 850,1000 
                            L 0,1000 Z" fill="url(#gradGreenBack)"/>
                    <defs>
                        <linearGradient id="gradGreenBack" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#059669" />
                            <stop offset="45%" stop-color="#047857" />
                            <stop offset="100%" stop-color="#022c22" />
                        </linearGradient>
                    </defs>
                </svg>

                <svg class="wave-svg wave-layer-1" viewBox="0 0 1000 1000" preserveAspectRatio="none">
                    <path d="M 0,0 
                            C 650,140 300,400 750,580 
                            C 980,700 400,880 780,1000 
                            L 0,1000 Z" fill="url(#gradGreenMain)"/>
                    <path d="M 0,20 
                            C 660,150 310,410 760,590 
                            C 990,710 410,890 790,1000" 
                          stroke="rgba(52, 211, 153, 0.4)" stroke-width="4" fill="none"/>
                    <defs>
                        <linearGradient id="gradGreenMain" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#34d399" />
                            <stop offset="25%" stop-color="#10b981" />
                            <stop offset="60%" stop-color="#047857" />
                            <stop offset="100%" stop-color="#022c22" />
                        </linearGradient>
                    </defs>
                </svg>
            </div>

            <div></div>

            <div class="left-content">
                <div class="welcome-subtitle">IT Solution</div>
                <div class="welcome-title">WEBSITE MONITORING</div>
                <p style="font-size: 15.5px; color: rgba(255, 255, 255, 0.9); margin-top: 14px; line-height: 1.6; max-width: 440px; text-shadow: 0 2px 10px rgba(0,0,0,0.2);">
                    Platform pemantauan otomatis status website klien, pelacakan incident, dan kalkulasi uptime secara real-time untuk penanganan tim IT.
                </p>
            </div>

            <div class="left-footer-info">
                &copy; {{ date('Y') }} IT Solution Corp. All rights reserved.
            </div>
        </div>

        <!-- SISI KANAN: Form Sign In -->
        <div class="right-form-side">

            <div class="mb-3">
                <h3 class="fw-bold mb-1" style="color: #0f172a; font-size: 28px; letter-spacing: -0.5px;">LOGIN</h3>
                <p class="mb-0" style="font-size: 13.5px; color: var(--text-muted);">Masukkan kredensial Anda untuk mengakses sistem.</p>
            </div>

            @if (session('success'))
                <div style="background-color: rgba(16, 185, 129, 0.1); color: var(--accent-green); padding: 10px 14px; border-radius: 12px; font-size: 13px; margin-bottom: 16px; border: 1px solid rgba(16, 185, 129, 0.3); font-weight: 500;">
                    <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background-color: var(--red-glow); color: var(--red-alert); padding: 10px 14px; border-radius: 12px; font-size: 13px; margin-bottom: 16px; border: 1px solid rgba(239, 68, 68, 0.3); font-weight: 500;">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.proses') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="Masukkan email Anda" autocomplete="email">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="password-container">
                        <i class="bi bi-shield-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-control" required placeholder="Masukkan password Anda">
                        <button type="button" class="password-toggle-btn" id="togglePassword">
                            <i class="bi bi-eye-slash" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3" style="font-size: 13px;">
                    <div class="form-check d-flex align-items-center gap-2">
                        <input class="form-check-input mt-0" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember" style="color: var(--text-muted); font-weight: 500; cursor: pointer;">
                            Ingat Saya
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-custom-login w-100 mb-1">
                    LOGIN <i class="bi bi-arrow-right ms-1"></i>
                </button>
            </form>

            <div class="divider-text">atau</div>

            <a href="{{ route('google.redirect') }}" class="btn-google">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
                Login dengan Google
            </a>

            <p class="register-link-text">
                Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
            </p>

        </div>

    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            eyeIcon.className = type === 'password' ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>