<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User - Website Monitoring IT Solution</title>
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
      --amber: #d97706;
      --amber-soft: #fef3c7;
      --blue: #0284c7;
      --blue-soft: #e0f2fe;
      --shadow: 0 10px 25px -5px rgba(31, 53, 97, 0.05), 0 8px 10px -6px rgba(31, 53, 97, 0.03);
      --sidebar-width: 260px;
      --sidebar-collapsed: 80px;
    }

    * { box-sizing: border-box; }
    
    body {
      margin: 0;
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: var(--ink);
      background: var(--bg);
      display: flex;
      min-height: 100vh;
      overflow-x: hidden;
    }

    a { color: inherit; text-decoration: none; }

    /* STYLE SIDEBAR */
    aside {
      position: fixed; 
      top: 0; 
      left: 0; 
      height: 100vh;
      width: var(--sidebar-width); 
      background: #013220;
      border-right: 1px solid #04472d; 
      display: flex;
      flex-direction: column; 
      z-index: 100; 
      box-shadow: var(--shadow);
      transition: width 0.3s ease;
    }

    aside.collapsed { width: var(--sidebar-collapsed); }

    .brand-area { 
      padding: 20px 16px; 
      display: flex; 
      align-items: center; 
      gap: 12px; 
      border-bottom: 1px solid #04472d; 
      overflow: hidden; 
      white-space: nowrap; 
    }

    .logo { 
      width: 40px; 
      height: 40px; 
      border-radius: 10px; 
      background: #ffffff; 
      border: 1px solid #04472d; 
      display: grid; 
      place-items: center; 
      font-weight: 900; 
      color: var(--green); 
      flex-shrink: 0; 
    }

    .brand-text h1 { font-size: 14px; margin: 0; color: #fff; font-weight: 700; }
    .brand-text small { font-size: 11px; color: #8fa394; }

    .menu-list { 
      flex: 1; 
      padding: 16px 10px; 
      overflow-y: auto; 
      overflow-x: hidden; 
      display: flex; 
      flex-direction: column; 
      gap: 4px; 
    }

    .menu-title { 
      font-size: 10px; 
      font-weight: 800; 
      letter-spacing: .1em; 
      color: #8fa394; 
      padding: 10px 10px 4px; 
      text-transform: uppercase; 
      white-space: nowrap; 
    }

    aside.collapsed .menu-title { display: none; }

    .nav-item { 
      display: flex; 
      align-items: center; 
      gap: 12px; 
      padding: 11px 12px; 
      border-radius: 10px; 
      color: #d1d5db; 
      font-size: 13px; 
      font-weight: 600; 
      white-space: nowrap; 
      cursor: pointer; 
    }

    .nav-item:hover, .nav-item.active { 
      background: #C7AB6B; 
      color: #013220; 
      font-weight: 700; 
    }

    .nav-item svg { 
      width: 20px; 
      height: 20px; 
      stroke: currentColor; 
      fill: none; 
      stroke-width: 2; 
      stroke-linecap: round; 
      stroke-linejoin: round; 
      flex-shrink: 0; 
    }

    aside.collapsed .nav-item span { display: none; }

    /* STYLE MAIN CONTENT & RESPONSIF SIDEBAR */
    main { 
      margin-left: var(--sidebar-width); 
      flex: 1; 
      padding: 85px 12px 16px 12px; 
      min-width: 0; 
      width: calc(100% - var(--sidebar-width));
      transition: margin-left 0.3s ease, width 0.3s ease;
    }

    aside.collapsed ~ main { 
      margin-left: var(--sidebar-collapsed); 
      width: calc(100% - var(--sidebar-collapsed));
    }

    .container { max-width: none; margin: 0; width: 100%; }

    .page-header { margin-bottom: 24px; }
    .page-header h2 { font-size: 22px; margin: 0 0 4px; color: var(--ink); font-weight: 800; }
    .page-header p { margin: 0; color: var(--muted); font-size: 12px; font-weight: 600; }

    .alert-error {
      background: var(--red-soft);
      border: 1px solid var(--red);
      color: var(--red);
      padding: 12px 16px;
      border-radius: 10px;
      margin-bottom: 20px;
      font-size: 13px;
      font-weight: 600;
    }

    .card { 
      background: var(--card); 
      border: 1px solid var(--line); 
      border-radius: 18px; 
      padding: 20px; 
      box-shadow: var(--shadow); 
    }

    .form-group { margin-bottom: 20px; }
    .form-group label { 
      display: block; 
      font-size: 10px; 
      font-weight: 700; 
      color: var(--muted); 
      text-transform: uppercase; 
      margin-bottom: 8px; 
      letter-spacing: 0.5px; 
    }

    .form-control { 
      width: 100%; 
      background: #fbfcfe; 
      border: 1px solid var(--line); 
      color: var(--ink); 
      padding: 10px 14px; 
      border-radius: 10px; 
      font-size: 13px; 
      font-weight: 600;
      outline: none; 
      transition: border-color 0.2s ease, box-shadow 0.2s ease; 
    }

    .form-control:focus { 
      border-color: var(--green-vibrant); 
      background: #ffffff;
      box-shadow: 0 0 0 3px rgba(0, 107, 63, 0.1);
    }

    .form-control::placeholder { color: var(--muted); font-weight: 500; }
    .form-control.is-invalid { border-color: var(--red) !important; }
    select.form-control { cursor: pointer; }

    /* MENCEGAH KOLOM BERUBAH JADI PUTIH SAAT AUTOFILL */
    input:-webkit-autofill,
    input:-webkit-autofill:hover, 
    input:-webkit-autofill:focus, 
    input:-webkit-autofill:active {
      -webkit-box-shadow: 0 0 0 30px #fbfcfe inset !important;
      -webkit-text-fill-color: var(--ink) !important;
      transition: background-color 5000s ease-in-out 0s;
    }

    .error-text { display: block; color: var(--red); font-size: 11px; margin-top: 6px; font-weight: 600; }

    .form-row { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }

    .form-actions { 
      display: flex; 
      justify-content: flex-end; 
      gap: 12px; 
      margin-top: 30px; 
      border-top: 1px solid var(--line); 
      padding-top: 20px; 
      flex-wrap: wrap; 
    }

    .btn-secondary { 
      background: #f8fafc; 
      border: 1px solid var(--line); 
      color: var(--ink); 
      padding: 10px 18px; 
      border-radius: 10px; 
      font-size: 13px; 
      font-weight: 700; 
      cursor: pointer; 
      text-align: center; 
      display: inline-flex; 
      align-items: center; 
      justify-content: center; 
      transition: all 0.2s ease;
    }

    .btn-secondary:hover { 
      background: var(--card-hover); 
      color: var(--green); 
      border-color: var(--muted); 
    }

    .btn-primary { 
      background: var(--green); 
      color: #fff; 
      border: none; 
      padding: 10px 20px; 
      border-radius: 10px; 
      font-size: 13px; 
      font-weight: 700; 
      cursor: pointer; 
      display: inline-flex; 
      align-items: center; 
      justify-content: center; 
      gap: 6px; 
      box-shadow: 0 4px 12px rgba(1, 50, 32, 0.2);
      transition: opacity 0.2s ease;
    }

    .btn-primary:hover { opacity: 0.9; }

    /* ==========================================================
       MEDIA QUERY: RESPONSIF UNTUK LAYAR HP & TABLET (Max 768px)
       ========================================================== */
    @media (max-width: 768px) {
      main { 
        margin-left: 0 !important; 
        width: 100% !important; 
        padding: 85px 16px 16px 16px;
      }
      .card { padding: 16px; }
      .form-row { grid-template-columns: 1fr; gap: 0; }
      .form-actions { flex-direction: column-reverse; gap: 10px; }
      .btn-primary, .btn-secondary { width: 100%; }
    }
  </style>
</head>
<body>

  <!-- SIDEBAR / NAVIGATION -->
  @include('layouts.navigation')

  <!-- MAIN CONTENT -->
  <main>
    <div class="container">

      <!-- PAGE HEADER -->
      <div class="page-header">
        <h2>Edit User</h2>
        <p>Perbarui informasi akun, role, status, atau password pengguna.</p>
      </div>

      <!-- ALERT ERROR -->
      @if ($errors->any())
        <div class="alert-error" id="alertError">
          Terdapat {{ $errors->count() }} kesalahan pada form, silakan periksa kembali isian di bawah.
        </div>
      @else
        <div class="alert-error" id="alertError" style="display: none;"></div>
      @endif

      <!-- FORM CARD -->
      <div class="card">
        <form action="{{ route('users.update', $user) }}" method="POST" id="userForm">
          @csrf
          @method('PUT')

          <!-- NAMA & EMAIL -->
          <div class="form-row">
            <div class="form-group">
              <label for="name">Nama Lengkap *</label>
              <input
                type="text"
                id="name"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Contoh: Budi Santoso"
                value="{{ old('name', $user->name) }}"
                required>
              @error('name')
                <span class="error-text">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group">
              <label for="email">Email Akses *</label>
              <input
                type="email"
                id="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="Contoh: budi@itsolution.id"
                value="{{ old('email', $user->email) }}"
                required>
              @error('email')
                <span class="error-text">{{ $message }}</span>
              @enderror
            </div>
          </div>

          <!-- PASSWORD BARU & KONFIRMASI PASSWORD -->
          <div class="form-row">
            <div class="form-group">
              <label for="password">Password Baru (Opsional)</label>
              <input
                type="password"
                id="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Kosongkan jika tidak ingin mengubah password">
              @error('password')
                <span class="error-text" id="passwordError">{{ $message }}</span>
              @else
                <span class="error-text" id="passwordError" style="display: none;"></span>
              @enderror
            </div>

            <div class="form-group">
              <label for="password_confirmation">Konfirmasi Password Baru</label>
              <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Ulangi password baru">
            </div>
          </div>

          <!-- ROLE & STATUS AKUN -->
          <div class="form-row">
            <div class="form-group">
              <label for="role">Role / Hak Akses *</label>
              <select
                id="role"
                name="role"
                class="form-control @error('role') is-invalid @enderror"
                required>
                <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                <option value="programmer" {{ old('role', $user->role) == 'programmer' ? 'selected' : '' }}>Programmer</option>
                <option value="viewer" {{ old('role', $user->role) == 'viewer' ? 'selected' : '' }}>Viewer</option>
              </select>
              @error('role')
                <span class="error-text">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group">
              <label for="is_active">Status Akun *</label>
              <select
                id="is_active"
                name="is_active"
                class="form-control @error('is_active') is-invalid @enderror"
                required>
                <option value="1" {{ old('is_active', $user->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('is_active', $user->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Nonaktif</option>
              </select>
              @error('is_active')
                <span class="error-text">{{ $message }}</span>
              @enderror
            </div>
          </div>

          <!-- ACTIONS -->
          <div class="form-actions">
            <a href="{{ route('users.index') }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">Perbarui User</button>
          </div>

        </form>
      </div>

    </div>
  </main>

  <!-- SCRIPT VALIDASI PASSWORD SAAT PERBARUI USER -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const userForm = document.getElementById('userForm');
      const passwordInput = document.getElementById('password');
      const confirmInput = document.getElementById('password_confirmation');
      const passwordError = document.getElementById('passwordError');
      const alertError = document.getElementById('alertError');

      function resetError() {
        passwordInput.classList.remove('is-invalid');
        confirmInput.classList.remove('is-invalid');
        passwordError.style.display = 'none';
      }

      passwordInput.addEventListener('input', resetError);
      confirmInput.addEventListener('input', resetError);

      userForm.addEventListener('submit', function(e) {
        const passVal = passwordInput.value;
        const confirmVal = confirmInput.value;

        let hasError = false;
        let passMsg = '';

        if (passVal.length > 0 || confirmVal.length > 0) {
          if (passVal.length < 8) {
            hasError = true;
            passMsg = 'Password minimal harus 8 karakter.';
          } else if (passVal !== confirmVal) {
            hasError = true;
            passMsg = 'Konfirmasi password tidak cocok dengan password.';
          }
        }

        if (hasError) {
          e.preventDefault();

          passwordInput.classList.add('is-invalid');
          confirmInput.classList.add('is-invalid');

          passwordError.textContent = passMsg;
          passwordError.style.display = 'block';

          alertError.textContent = 'Terdapat kesalahan pada form password, silakan periksa kembali isian di bawah.';
          alertError.style.display = 'block';
          
          window.scrollTo({ top: 0, behavior: 'smooth' });
        }
      });
    });
  </script>

</body>
</html>