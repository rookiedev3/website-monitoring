<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | IT Solution Monitoring</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.jpeg') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg-main: #020617;
            --border-focus: #10b981;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --accent-green: #10b981;
            --accent-glow: rgba(16, 185, 129, 0.35);
            --red-alert: #ef4444;
            --red-glow: rgba(239, 68, 68, 0.2);
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
            background: #020617;
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
            background: transparent;
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
            text-shadow: 0 4px 20px rgba(0,0,0,0.8);
        }

        .welcome-subtitle {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 3px;
            color: #000000;
            text-transform: uppercase;
        }

        .left-footer-info {
            position: relative;
            z-index: 3;
            font-size: 13px;
            color: var(--text-muted);
        }

        /* SISI KANAN: Form Register */
        .right-form-side {
            padding: 30px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: transparent;
            position: relative;
            max-width: 540px;
            width: 100%;
            margin: auto;
            z-index: 3;
        }

        .form-label {
            font-size: 11px !important;
            font-weight: 700 !important;
            color: var(--text-muted) !important;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 4px !important;
        }

        .input-group-custom, .password-container {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            color: var(--text-muted);
            font-size: 16px;
            z-index: 10;
            transition: color 0.3s ease;
        }

        .form-control {
            border-radius: 12px;
            padding: 10px 16px 10px 46px;
            font-size: 14px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background-color: rgba(15, 23, 42, 0.6);
            color: var(--text-main);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .password-container .form-control {
            padding-right: 46px;
        }

        .form-control:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 4px var(--accent-glow);
            background-color: rgba(15, 23, 42, 0.95);
            color: #fff;
            transform: translateY(-1px);
        }

        .form-control:focus + .input-icon,
        .input-group-custom:focus-within .input-icon {
            color: var(--accent-green);
        }

        .form-control::placeholder {
            color: #64748b;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #0f172a inset !important;
            -webkit-text-fill-color: var(--text-main) !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        .password-toggle-btn {
            position: absolute;
            right: 14px;
            background: transparent;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            z-index: 10;
            transition: color 0.2s ease;
        }

        .password-toggle-btn:hover {
            color: var(--accent-green);
        }

        .btn-custom-login {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #022c22;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            font-size: 14.5px;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px var(--accent-glow);
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
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            color: #022c22;
            box-shadow: 0 6px 25px rgba(52, 211, 153, 0.5);
            transform: translateY(-2px);
        }

        .divider-text {
            display: flex;
            align-items: center;
            text-align: center;
            color: var(--text-muted);
            font-size: 11.5px;
            margin: 12px 0;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .divider-text::before,
        .divider-text::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .divider-text:not(:empty)::before {
            margin-right: 0.75em;
        }

        .divider-text:not(:empty)::after {
            margin-left: 0.75em;
        }

        .btn-google {
            background: rgba(255, 255, 255, 0.03);
            color: var(--text-main);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 10px;
            font-size: 13.5px;
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
            background: rgba(255, 255, 255, 0.08);
            color: var(--text-main);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        .btn-google img {
            width: 16px;
            height: 16px;
        }

        .login-link-text {
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 12px;
            margin-bottom: 0;
        }

        .login-link-text a {
            color: var(--accent-green);
            font-weight: 600;
            text-decoration: none;
        }

        .login-link-text a:hover {
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
                            <stop offset="0%" stop-color="#06b6d4" />
                            <stop offset="45%" stop-color="#047857" />
                            <stop offset="100%" stop-color="#020617" />
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
                          stroke="rgba(52, 211, 153, 0.5)" stroke-width="4" fill="none"/>
                    <defs>
                        <linearGradient id="gradGreenMain" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#34d399" />
                            <stop offset="25%" stop-color="#10b981" />
                            <stop offset="60%" stop-color="#064e3b" />
                            <stop offset="100%" stop-color="#020617" />
                        </linearGradient>
                    </defs>
                </svg>
            </div>

            <div></div>

            <div class="left-content">
                <div class="welcome-subtitle">IT Solution</div>
                <div class="welcome-title">DAFTAR AKUN</div>
                <p style="font-size: 15.5px; color: rgba(248, 250, 252, 0.85); margin-top: 14px; line-height: 1.6; max-width: 440px; text-shadow: 0 2px 10px rgba(0,0,0,0.5);">
                    Buat akun baru untuk mengakses platform pemantauan status website klien. Akun akan aktif setelah disetujui oleh admin.
                </p>
            </div>

            <div class="left-footer-info">
                &copy; {{ date('Y') }} IT Solution Corp. All rights reserved.
            </div>
        </div>

        <!-- SISI KANAN: Form Register -->
        <div class="right-form-side">

            <div class="mb-3">
                <h3 class="fw-bold mb-1" style="color: #fff; font-size: 26px; letter-spacing: -0.5px;">REGISTER</h3>
                <p class="mb-0" style="font-size: 13px; color: var(--text-muted);">Buat akun baru untuk mengajukan akses ke sistem.</p>
            </div>

            @if ($errors->any())
                <div style="background-color: var(--red-glow); color: var(--red-alert); padding: 8px 12px; border-radius: 10px; font-size: 12.5px; margin-bottom: 12px; border: 1px solid rgba(239, 68, 68, 0.3); font-weight: 500;">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('register.proses') }}" method="POST">
                @csrf

                <div class="mb-2">
                    <label class="form-label">Nama Lengkap</label>
                    <div class="input-group-custom">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap Anda" autocomplete="name">
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label">Email</label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="Masukkan email Anda" autocomplete="email">
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label">Password</label>
                    <div class="password-container">
                        <i class="bi bi-shield-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-control" required placeholder="Minimal 8 karakter">
                        <button type="button" class="password-toggle-btn" id="togglePassword">
                            <i class="bi bi-eye-slash" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="password-container">
                        <i class="bi bi-shield-lock input-icon"></i>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Ulangi password Anda">
                        <button type="button" class="password-toggle-btn" id="togglePasswordConfirm">
                            <i class="bi bi-eye-slash" id="eyeIconConfirm"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-custom-login w-100">
                    DAFTAR <i class="bi bi-arrow-right ms-1"></i>
                </button>
            </form>

            <div class="divider-text">atau</div>

            <a href="{{ route('google.redirect.register') }}" class="btn-google">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
                Daftar dengan Google
            </a>

            <p class="login-link-text">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </p>

        </div>

    </div>

    <script>
        function setupToggle(buttonId, inputId, iconId) {
            const toggleBtn = document.getElementById(buttonId);
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            toggleBtn.addEventListener('click', function () {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                icon.className = type === 'password' ? 'bi bi-eye-slash' : 'bi bi-eye';
            });
        }

        setupToggle('togglePassword', 'password', 'eyeIcon');
        setupToggle('togglePasswordConfirm', 'password_confirmation', 'eyeIconConfirm');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>