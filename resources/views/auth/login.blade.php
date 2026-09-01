<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | IT Solution Monitoring</title>

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
            overflow: hidden;
            position: relative;
        }

        .login-fullscreen-wrapper {
            width: 100vw;
            height: 100vh;
            display: grid;
            grid-template-columns: 1.15fr 1fr;
            position: relative;
            overflow: hidden;
            animation: fadeIn 0.8s ease forwards;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        /* SISI KIRI: Welcome & Background Gelombang */
        .left-wave-side {
            background: transparent;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 80px;
        }

        /* Container Gelombang Ekstra Lebar & Besar */
        .wave-svg-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        .wave-svg {
            position: absolute;
            top: -15%;
            left: -15%;
            width: 155%;
            height: 130%;
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

        /* Teks Welcome */
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

        /* SISI KANAN: Form Sign In */
        .right-form-side {
            padding: 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: transparent;
            position: relative;
            max-width: 580px;
            width: 100%;
            margin: 0 auto;
            z-index: 3;
        }

        .form-label {
            font-size: 12px !important;
            font-weight: 700 !important;
            color: var(--text-muted) !important;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 8px !important;
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
            padding: 15px 18px 15px 50px;
            font-size: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background-color: rgba(15, 23, 42, 0.6);
            color: var(--text-main);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .password-container .form-control {
            padding-right: 50px;
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
            color: #022c22;
            border: none;
            border-radius: 14px;
            padding: 16px;
            font-weight: 700;
            font-size: 15.5px;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px var(--accent-glow);
            position: relative;
            overflow: hidden;
        }

        .btn-custom-login::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
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

        .btn-back-home {
            background: rgba(255, 255, 255, 0.03);
            color: var(--text-muted);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 13px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
            width: 100%;
        }

        .btn-back-home:hover {
            background: rgba(255, 255, 255, 0.08);
            color: var(--text-main);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        .form-check-input {
            background-color: rgba(2, 6, 23, 0.6);
            border-color: rgba(255, 255, 255, 0.2);
            cursor: pointer;
            width: 18px;
            height: 18px;
        }

        .form-check-input:checked {
            background-color: var(--accent-green);
            border-color: var(--accent-green);
        }

        @media (max-width: 991px) {
            .login-fullscreen-wrapper {
                grid-template-columns: 1fr;
                overflow-y: auto;
            }
            .left-wave-side {
                display: none;
            }
            .right-form-side {
                padding: 40px 24px;
                height: 100vh;
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <div class="login-fullscreen-wrapper">
        
        <!-- SISI KIRI: Gelombang Ekstra Besar Mengisi Ruang -->
        <div class="left-wave-side">
            <div class="wave-svg-container">
                <!-- Layer 2: Gelombang Belakang (Memencar Luas ke Kanan Atas & Tengah) -->
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

                <!-- Layer 1: Gelombang Utama (Ekstra Lebar & Tebal) -->
                <svg class="wave-svg wave-layer-1" viewBox="0 0 1000 1000" preserveAspectRatio="none">
                    <path d="M 0,0 
                             C 650,140 300,400 750,580 
                             C 980,700 400,880 780,1000 
                             L 0,1000 Z" fill="url(#gradGreenMain)"/>
                    
                    <!-- Garis Aksentuasi Meliuk Tebal -->
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
    <div class="welcome-title">WEBSITE MONITORING</div>
    <p style="font-size: 15.5px; color: rgba(248, 250, 252, 0.85); margin-top: 14px; line-height: 1.6; max-width: 440px; text-shadow: 0 2px 10px rgba(0,0,0,0.5);">
        Platform pemantauan otomatis status website klien, pelacakan incident, dan kalkulasi uptime secara real-time untuk penanganan tim IT.
    </p>
</div>

            <div class="left-footer-info">
                &copy; {{ date('Y') }} IT Solution Corp. All rights reserved.
            </div>
        </div>

        <!-- SISI KANAN: Form Sign In -->
        <div class="right-form-side">
            
            <div class="mb-4">
                <h3 class="fw-bold mb-1" style="color: #fff; font-size: 30px; letter-spacing: -0.5px;">LOGIN</h3>
                <p class="mb-0" style="font-size: 14px; color: var(--text-muted);">Masukkan kredensial Anda untuk mengakses sistem.</p>
            </div>

            @if (session('success'))
                <div style="background-color: rgba(16, 185, 129, 0.1); color: var(--accent-green); padding: 12px 16px; border-radius: 12px; font-size: 13.5px; margin-bottom: 24px; border: 1px solid rgba(16, 185, 129, 0.3); font-weight: 500;">
                    <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background-color: var(--red-glow); color: var(--red-alert); padding: 12px 16px; border-radius: 12px; font-size: 13.5px; margin-bottom: 24px; border: 1px solid rgba(239, 68, 68, 0.3); font-weight: 500;">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.proses') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label">Email</label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="Masukkan email Anda" autocomplete="email">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label"> Password</label>
                    <div class="password-container">
                        <i class="bi bi-shield-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-control" required placeholder="Masukkan password Anda">
                        <button type="button" class="password-toggle-btn" id="togglePassword">
                            <i class="bi bi-eye-slash" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4" style="font-size: 13.5px;">
                    <div class="form-check d-flex align-items-center gap-2">
                        <input class="form-check-input mt-0" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember" style="color: var(--text-muted); font-weight: 500; cursor: pointer;">
                            Ingat Saya
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-custom-login w-100 mb-3">
                    LOGIN <i class="bi bi-arrow-right ms-1"></i>
                </button>
            </form>

            <div>
               
            </div>

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