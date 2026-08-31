<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Website Monitoring IT Solution</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg-main: #020617;
            --card-bg: rgba(15, 23, 42, 0.75);
            --border-color: rgba(52, 211, 153, 0.2);
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
            /* Background Dinamis & Berwarna (Navy, Teal, Emerald) */
            background: linear-gradient(135deg, #020617 0%, #064e3b 50%, #0f172a 100%);
            background-size: 200% 200%;
            animation: gradientBG 12s ease infinite;
            color: var(--text-main);
            overflow-x: hidden;
            position: relative;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Ambient Glow & Floating Orbs Animation */
        .glow-orb-1 {
            position: absolute;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.25) 0%, rgba(0, 0, 0, 0) 70%);
            top: -100px;
            left: -100px;
            pointer-events: none;
            animation: floatOrb 8s ease-in-out infinite alternate;
        }

        .glow-orb-2 {
            position: absolute;
            width: 550px;
            height: 550px;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.2) 0%, rgba(0, 0, 0, 0) 70%);
            bottom: -150px;
            right: -150px;
            pointer-events: none;
            animation: floatOrb 10s ease-in-out infinite alternate-reverse;
        }

        @keyframes floatOrb {
            0% { transform: translateY(0px) scale(1); }
            100% { transform: translateY(30px) scale(1.08); }
        }

        /* Card Wrapper with Entrance Animation */
        .login-card-container {
            width: 90%;
            max-width: 980px;
            min-height: 580px;
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6), 0 0 40px rgba(16, 185, 129, 0.1);
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            overflow: hidden;
            position: relative;
            z-index: 10;
            animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes slideUpFade {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Left Side: Cyber Graphics & Brand Area */
        .login-illustration-side {
            background: linear-gradient(145deg, rgba(16, 185, 129, 0.12) 0%, rgba(15, 23, 42, 0.8) 100%);
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            border-right: 1px solid var(--border-color);
        }

        .brand-logo-area img {
            max-height: 32px;
            width: auto;
            filter: drop-shadow(0 2px 8px rgba(0,0,0,0.5));
        }

        .illustration-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin: auto 0;
        }

        /* Animated Pulse Server Frame */
        .server-art {
            width: 140px;
            height: 140px;
            background: rgba(16, 185, 129, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.4);
            border-radius: 28px;
            display: grid;
            place-items: center;
            color: var(--accent-green);
            font-size: 52px;
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.2);
            margin-bottom: 24px;
            position: relative;
            transition: all 0.3s ease;
        }

        .server-art:hover {
            transform: scale(1.05);
            box-shadow: 0 0 45px rgba(16, 185, 129, 0.4);
        }

        .status-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(16, 185, 129, 0.25);
            padding: 4px 10px;
            border-radius: 20px;
            border: 1px solid var(--accent-green);
            font-size: 10px;
            font-weight: 700;
            color: var(--accent-green);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            background: var(--accent-green);
            border-radius: 50%;
            box-shadow: 0 0 8px var(--accent-green);
            animation: pulse 1.8s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(1.3); }
            100% { opacity: 1; transform: scale(1); }
        }

        /* Right Side: Form Controls */
        .login-form-side {
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-label {
            font-size: 11px !important;
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
            left: 16px;
            color: var(--text-muted);
            font-size: 16px;
            z-index: 10;
            transition: color 0.2s ease;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 16px 12px 46px;
            font-size: 14px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background-color: rgba(2, 6, 23, 0.5);
            color: var(--text-main);
            transition: all 0.25s ease;
        }

        .password-container .form-control {
            padding-right: 48px;
        }

        .form-control:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 4px var(--accent-glow);
            background-color: rgba(2, 6, 23, 0.8);
            color: #fff;
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
            right: 14px;
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
            background: var(--accent-green);
            color: #022c22;
            border: none;
            border-radius: 12px;
            padding: 13px;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 0.3px;
            transition: all 0.25s ease;
            box-shadow: 0 4px 20px var(--accent-glow);
        }

        .btn-custom-login:hover {
            background: #34d399;
            color: #022c22;
            box-shadow: 0 6px 24px rgba(52, 211, 153, 0.5);
            transform: translateY(-2px);
        }

        .btn-back-home {
            background: rgba(255, 255, 255, 0.03);
            color: var(--text-muted);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 11px;
            font-size: 13px;
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
        }

        .form-check-input {
            background-color: rgba(2, 6, 23, 0.6);
            border-color: rgba(255, 255, 255, 0.2);
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--accent-green);
            border-color: var(--accent-green);
        }

        @media (max-width: 991px) {
            .login-card-container {
                grid-template-columns: 1fr;
                max-width: 440px;
            }
            .login-illustration-side {
                display: none;
            }
            .login-form-side {
                padding: 36px 28px;
            }
        }
    </style>
</head>

<body>

    <div class="glow-orb-1"></div>
    <div class="glow-orb-2"></div>

    <div class="login-card-container">
        
        <div class="login-illustration-side">
            <div class="brand-logo-area">
                <img src="{{ asset('images/foto-perusahaan.jpg') }}" alt="Logo Perusahaan">
            </div>

            <div class="illustration-box">
                <div class="server-art">
                    <i class="bi bi-cpu-fill"></i>
                    <div class="status-badge">
                        <span class="status-dot"></span> Live
                    </div>
                </div>
                <h5 class="fw-bold mb-2" style="color: #fff; font-size: 18px; letter-spacing: -0.3px;">IT Solution Monitoring</h5>
                <p style="font-size: 12.5px; color: var(--text-muted); max-width: 260px; line-height: 1.5;">
                    Pusat kontrol pemantauan server dan infrastruktur uptime jaringan secara real-time.
                </p>
            </div>

            <div style="font-size: 11px; color: #64748b;">
                &copy; {{ date('Y') }} IT Solution Corp. All rights reserved.
            </div>
        </div>

        <div class="login-form-side">
            
            <div class="mb-4">
                <h3 class="fw-bold mb-1" style="color: #fff; font-size: 22px; letter-spacing: -0.4px;">Login Admin</h3>
                <p class="mb-0" style="font-size: 13px; color: var(--text-muted);">Masukkan kredensial Anda untuk masuk ke sistem.</p>
            </div>

            @if (session('success'))
                <div style="background-color: rgba(16, 185, 129, 0.1); color: var(--accent-green); padding: 10px 14px; border-radius: 10px; font-size: 12.5px; margin-bottom: 20px; border: 1px solid rgba(16, 185, 129, 0.3); font-weight: 500;">
                    <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background-color: var(--red-glow); color: var(--red-alert); padding: 10px 14px; border-radius: 10px; font-size: 12.5px; margin-bottom: 20px; border: 1px solid rgba(239, 68, 68, 0.3); font-weight: 500;">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.proses') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Username / Email</label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="name@company.com" autocomplete="email">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="password-container">
                        <i class="bi bi-shield-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-control" required placeholder="••••••••">
                        <button type="button" class="password-toggle-btn" id="togglePassword">
                            <i class="bi bi-eye-slash" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4" style="font-size: 12.5px;">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label ms-1" for="remember" style="color: var(--text-muted); font-weight: 500; cursor: pointer;">
                            Ingat Saya
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-custom-login w-100 mb-3">
                    Masuk ke Sistem <i class="bi bi-arrow-right ms-1"></i>
                </button>
            </form>

            <div>
                <a href="{{ url('/') }}" class="btn-back-home">
                    <i class="bi bi-house"></i> Kembali ke Beranda
                </a>
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