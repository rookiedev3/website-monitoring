<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profil - Website Monitoring IT Solution</title>
  <link rel="icon" type="image/png" href="{{ asset('img/logo.jpeg') }}">

  <!-- Fonts & Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

  <style>
    :root {
      --bg: #f4f7fc;
      --card: #ffffff;
      --card-hover: #f8fafc;
      --ink: #172033;
      --muted: #778195;
      --line: #e8edf5;
      --green: #013220;
      --green-vibrant: #006B3F;
      --green-soft: #e6f7ee;
      --red: #dc2626;
      --red-soft: #fef2f2;
      --shadow: 0 10px 25px -5px rgba(31, 53, 97, 0.05), 0 8px 10px -6px rgba(31, 53, 97, 0.03);
      --sidebar-width: 260px;
      --sidebar-collapsed: 80px;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: var(--ink);
      background: var(--bg);
      display: flex;
      min-height: 100vh;
      overflow-x: hidden;
    }

    a {
      color: inherit;
      text-decoration: none;
    }

    /* ==========================================================
       KODE RESPONSIF: MAIN CONTENT & PERGESERAN SIDEBAR
       ========================================================== */
    main {
      margin-left: var(--sidebar-width);
      flex: 1;
      padding: 85px 12px 16px 12px;
      min-width: 0;
      transition: margin-left 0.3s ease, width 0.3s ease;
      width: calc(100% - var(--sidebar-width));
    }

    aside#sidebar.collapsed ~ main {
      margin-left: var(--sidebar-collapsed);
      width: calc(100% - var(--sidebar-collapsed));
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      width: 100%;
    }

    .page-header {
      margin-bottom: 24px;
    }

    .page-header h2 {
      font-size: 22px;
      margin: 0 0 4px;
      color: var(--ink);
      font-weight: 800;
    }

    .page-header p {
      margin: 0;
      color: var(--muted);
      font-size: 12px;
      font-weight: 600;
    }

    .card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 18px;
      padding: 24px;
      box-shadow: var(--shadow);
      margin-bottom: 20px;
    }
    
    .card-title-group {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 13px;
      font-weight: 800;
      color: var(--ink);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .card-title-group i {
      font-size: 16px;
      color: var(--green);
    }

    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 8px; letter-spacing: .05em; }
    
    .input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
      width: 100%;
    }
    .form-control { 
      width: 100%; 
      background: #fbfcfe; 
      border: 1px solid var(--line); 
      color: var(--ink); 
      padding: 12px 14px; 
      border-radius: 10px; 
      font-size: 13px;
      font-weight: 600;
      outline: none; 
      transition: border-color 0.2s ease, box-shadow 0.2s ease; 
    }
    .form-control:focus { border-color: var(--green-vibrant); box-shadow: 0 0 0 3px rgba(0, 107, 63, 0.1); }
    .form-control.is-invalid { border-color: var(--red); }
    .input-icon-right {
      position: absolute;
      right: 14px;
      color: var(--muted);
      cursor: pointer;
    }
    .input-icon-right:hover { color: var(--ink); }

    .invalid-feedback {
      display: block;
      font-size: 11px;
      font-weight: 700;
      color: var(--red);
      margin-top: 6px;
    }

    .alert-error {
      background: var(--red-soft);
      border: 1px solid var(--red);
      color: var(--red);
      padding: 12px 16px;
      border-radius: 10px;
      margin-bottom: 20px;
      font-size: 13px;
      font-weight: 700;
    }

    .form-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 30px; border-top: 1px solid var(--line); padding-top: 20px; flex-wrap: wrap; }
    
    .btn-secondary { background: transparent; border: 1px solid var(--line); color: var(--muted); padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; text-align: center; display: inline-flex; align-items: center; justify-content: center; }
    .btn-secondary:hover { color: var(--ink); background: var(--card-hover); }

    .btn-primary { background: var(--green); color: #fff; border: none; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 6px; box-shadow: 0 4px 12px rgba(1, 50, 32, 0.2); }
    .btn-primary:hover { opacity: 0.9; }

    /* ==========================================================
       MEDIA QUERY: RESPONSIF UNTUK LAYAR TABLET & HP (Max 768px)
       ========================================================== */
    @media (max-width: 768px) {
      main { 
        margin-left: 0 !important; 
        width: 100% !important; 
        padding: 85px 16px 16px 16px;
      }
      .card {
        padding: 16px; 
      }
      .form-actions { 
        flex-direction: column-reverse; 
        width: 100%; 
        gap: 10px;
      }
      .btn-primary, .btn-secondary { 
        width: 100%; 
        justify-content: center; 
      }
    }
  </style>
</head>
<body>

  <!-- NAVIGASI & SIDEBAR UTAMA -->
  @include('layouts.navigation')

  <!-- MAIN CONTENT -->
  <main>
    <div class="container">
      
      <div class="page-header">
        <h2>Edit Profil & Keamanan</h2>
        <p>Perbarui informasi data diri atau ubah kata sandi akun Anda.</p>
      </div>

      @if($errors->any() && !$errors->has('current_password'))
        <div class="alert-error">
          Terjadi kesalahan, periksa kembali data yang Anda masukkan.
        </div>
      @endif

      <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- KARTU: INFORMASI DATA DIRI -->
        <div class="card">
          <div class="card-title-group" style="margin-bottom: 20px; border-bottom: 1px solid var(--line); padding-bottom: 12px;">
            <i class="bi bi-person"></i>
            <span>Informasi Data Diri</span>
          </div>

          <div class="form-group">
            <label>Nama Lengkap</label>
            <input
              type="text"
              name="name"
              class="form-control @error('name') is-invalid @enderror"
              value="{{ old('name', $user->name) }}"
              required
            >
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group" style="margin-bottom: 0;">
            <label>Alamat Email</label>
            <input
              type="email"
              name="email"
              class="form-control @error('email') is-invalid @enderror"
              value="{{ old('email', $user->email) }}"
              required
            >
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <!-- KARTU: KEAMANAN & PASSWORD -->
        <div class="card">
          <div class="card-title-group" style="margin-bottom: 12px; border-bottom: 1px solid var(--line); padding-bottom: 12px;">
            <i class="bi bi-key"></i>
            <span>Keamanan & Password</span>
          </div>
          <p style="font-size: 11px; font-weight: 600; color: var(--muted); margin-bottom: 20px;">
            Kosongkan bagian ini jika Anda tidak ingin mengubah kata sandi.
          </p>

          <div class="form-group">
            <label>Kata Sandi Saat Ini</label>
            <div class="input-wrapper">
              <input
                type="password"
                name="current_password"
                class="form-control toggle-password @error('current_password') is-invalid @enderror"
                placeholder="Masukkan kata sandi lama"
              >
              <i class="bi bi-eye input-icon-right"></i>
            </div>
            @error('current_password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label>Kata Sandi Baru</label>
            <div class="input-wrapper">
              <input
                type="password"
                name="new_password"
                class="form-control toggle-password @error('new_password') is-invalid @enderror"
                placeholder="Masukkan kata sandi baru (min. 8 karakter)"
              >
              <i class="bi bi-eye input-icon-right"></i>
            </div>
            @error('new_password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group" style="margin-bottom: 0;">
            <label>Konfirmasi Kata Sandi Baru</label>
            <div class="input-wrapper">
              <input
                type="password"
                name="new_password_confirmation"
                class="form-control toggle-password"
                placeholder="Ulangi kata sandi baru"
              >
              <i class="bi bi-eye input-icon-right"></i>
            </div>
          </div>

          <!-- TOMBOL AKSI -->
          <div class="form-actions" style="margin-bottom: 0;">
            <a href="{{ route('profile.index') }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">
              <i class="bi bi-check-lg"></i> Simpan Perubahan
            </button>
          </div>
        </div>

      </form>

    </div>
  </main>

  <script>
    // Toggle show/hide untuk setiap input password yang punya ikon mata
    document.querySelectorAll('.input-icon-right').forEach(function (icon) {
      icon.addEventListener('click', function () {
        const input = icon.previousElementSibling;
        if (!input) return;

        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
      });
    });
  </script>

</body>
</html>