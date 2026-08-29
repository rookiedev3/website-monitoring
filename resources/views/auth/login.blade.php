<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Website Monitoring IT Solution</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg: #0b120f;
            --card: #111b16;
            --card-hover: #17231d;
            --ink: #dce9e1;
            --muted: #82988c;
            --line: #1b2a22;
            --green: #0f9f6e;
            --green-soft: rgba(15, 159, 110, 0.15);
            --red: #d94c4c;
            --red-soft: rgba(217, 76, 76, 0.15);
            --shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
        }

        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            width: 100vw;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg);
            color: var(--ink);
            overflow-x: hidden;
            position: relative;
        }

        /* Background Glow Ambient ala Referensi */
        body::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(15, 159, 110, 0.12) 0%, rgba(11, 18, 15, 0) 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        /* Container Card Besar di Tengah (Floating Card) */
        .login-card-container {
            width: 90%;
            max-width: 1050px;
            min-height: 580px;
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 28px;
            box-shadow: var(--shadow);
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            overflow: hidden;
            position: relative;
            z-index: 10;
        }

        /* Sisi Kiri: Ilustrasi & Branding Area (Latar Putih/Soft Sesuai Referensi) */
        .login-illustration-side {
            background: #ffffff;
            color: #0b120f;
            padding: 45px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        /* Bentuk organik latar belakang ilustrasi sisi kiri */
        .login-illustration-side::before {
            content: '';
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 300px;
            height: 300px;
            background: rgba(15, 159, 110, 0.08);
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            pointer-events: none;
        }

        .brand-logo-area img {
            max-height: 28px;
            width: auto;
            display: block;
        }

        /* Area Ilustrasi Server / Monitoring Center */
        .illustration-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin: auto 0;
            padding: 20px 0;
        }

        .server-art {
            width: 160px;
            height: 160px;
            background: linear-gradient(135deg, #0f9f6e, #075c3f);
            border-radius: 24px;
            display: grid;
            place-items: center;
            color: #fff;
            font-size: 56px;
            box-shadow: 0 15px 30px rgba(15, 159, 110, 0.3);
            margin-bottom: 20px;
            position: relative;
        }

        /* Indikator Titik Hijau Berdenyut */
        .server-art::after {
            content: '';
            position: absolute;
            top: 15px;
            right: 15px;
            width: 14px;
            height: 14px;
            background: #22c55e;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 0 10px #22c55e;
        }

        /* Sisi Kanan: Form Input Login (Dark Theme) */
        .login-form-side {
            padding: 50px 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: var(--card);
        }

        .form-label {
            font-size: 12px !important;
            font-weight: 700 !important;
            color: var(--muted) !important;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px !important;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            color: var(--muted);
            font-size: 16px;
            z-index: 10;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 16px 12px 46px;
            font-size: 14px;
            border: 1px solid var(--line);
            background-color: var(--bg);
            color: var(--ink);
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 4px var(--green-soft);
            background-color: var(--card-hover);
            color: #fff;
        }

        .form-control::placeholder {
            color: var(--muted);
        }

        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }

        .password-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-container .form-control {
            padding-right: 48px;
        }

        .password-toggle-btn {
            position: absolute;
            right: 14px;
            background: transparent;
            border: none;
            color: var(--muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            z-index: 10;
        }

        .password-toggle-btn:hover {
            color: var(--green);
        }

        .btn-custom-login {
            background-color: var(--green);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 13px;
            font-weight: 700;
            font-size: 14.5px;
            transition: all 0.2s ease;
            box-shadow: 0 8px 20px rgba(15, 159, 110, 0.25);
        }

        .btn-custom-login:hover {
            background-color: #0d8a5f;
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-back-home {
            background: var(--bg);
            color: var(--ink);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 11px 16px;
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
            background: var(--card-hover);
            color: #fff;
            border-color: var(--green);
        }

        @media (max-width: 991px) {
            .login-card-container {
                grid-template-columns: 1fr;
                max-width: 480px;
                margin: 20px;
            }
            .login-illustration-side {
                display: none; /* Sembunyikan sisi ilustrasi di layar kecil agar pas */
            }
            .login-form-side {
                padding: 40px 30px;
            }
        }
    </style>
</head>

<body>

    <div class="login-card-container">
        
        <!-- Sisi Kiri: Ilustrasi & Identitas Sistem (Gaya Referensi) -->
        <div class="login-illustration-side">
            <div class="brand-logo-area">
                <img src="{{ asset('images/foto-perusahaan.jpg') }}" alt="Logo Perusahaan">
            </div>

            <div class="illustration-box">
                <div class="server-art">
                    <i class="bi bi-hdd-rack"></i>
                </div>
                <h5 class="fw-bold mb-1" style="color: #0b120f; font-size: 18px;">IT Solution Monitoring</h5>
                <p class="text-secondary mb-0" style="font-size: 12.5px; max-width: 260px;">Pusat kontrol pemantauan server dan infrastruktur uptime jaringan secara real-time.</p>
            </div>

            <div style="font-size: 11.5px; color: #64748b;">
                &copy; {{ date('Y') }} IT Solution Corp. All rights reserved.
            </div>
        </div>

        <!-- Sisi Kanan: Form Login (Fungsionalitas Asli Dipertahankan) -->
        <div class="login-form-side">
            
            <div class="mb-4">
                <h3 class="fw-bold mb-1" style="color: #fff; font-size: 24px; letter-spacing: -0.3px;">Login Admin</h3>
                <p class="mb-0" style="font-size: 13px; color: var(--muted);">Masukkan kredensial Anda untuk masuk ke sistem.</p>
            </div>

            @if (session('success'))
                <div style="background-color: var(--green-soft); color: var(--green); padding: 10px 14px; border-radius: 10px; font-size: 12.5px; margin-bottom: 16px; border: 1px solid rgba(15,159,110,0.3); font-weight: 600;">
                    <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background-color: var(--red-soft); color: var(--red); padding: 10px 14px; border-radius: 10px; font-size: 12.5px; margin-bottom: 16px; border: 1px solid rgba(217,76,76,0.3); font-weight: 600;">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.proses') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Username / Email</label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="Enter your email" autocomplete="email">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="password-container">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-control" required placeholder="Enter your password">
                        <button type="button" class="password-toggle-btn" id="togglePassword">
                            <i class="bi bi-eye-slash" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4" style="font-size: 13px;">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" style="cursor: pointer; width: 16px; height: 16px; margin-top: 2px; background-color: var(--bg); border-color: var(--line);">
                        <label class="form-check-label ms-1" for="remember" style="color: var(--muted); font-weight: 600; cursor: pointer;">
                            Ingat Saya
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-custom-login w-100 shadow-sm mb-3">
                    Login to System
                </button>
            </form>

            <div>
                <a href="{{ url('/') }}" class="btn-back-home shadow-sm">
                    <span style="font-size: 14px; line-height: 1; color: var(--muted);">&#8592;</span> Kembali ke Beranda
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>