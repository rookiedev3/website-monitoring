<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah User Baru - Website Monitoring IT Solution</title>
  <style>
    :root {
      --bg: #0b120f;
      --card: #111b16;
      --card-hover: #17231d;
      --ink: #dce9e1;
      --muted: #82988c;
      --line: #1b2a22;
      --green: #0f9f6e;
      --green-soft: rgba(15, 159, 110, 0.12);
      --red: #d94c4c;
      --red-soft: rgba(217, 76, 76, 0.12);
      --shadow: 0 10px 30px rgba(0,0,0,.3);
      --sidebar-width: 260px;
      --sidebar-collapsed: 76px;
    }

    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, sans-serif;
      color: var(--ink);
      background: var(--bg);
      display: flex;
      min-height: 100vh;
      overflow-x: hidden;
    }
    a { color: inherit; text-decoration: none; }

    /* STYLE SIDEBAR */
    aside {
      position: fixed; top: 0; left: 0; height: 100vh;
      width: var(--sidebar-width); background: var(--card);
      border-right: 1px solid var(--line); display: flex;
      flex-direction: column; z-index: 100; box-shadow: var(--shadow);
      transition: width 0.3s ease;
    }
    aside.collapsed { width: var(--sidebar-collapsed); }
    .brand-area { padding: 20px 16px; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid var(--line); overflow: hidden; white-space: nowrap; }
    .logo { width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #17231d, #24372d); border: 1px solid var(--line); display: grid; place-items: center; font-weight: 900; color: var(--green); flex-shrink: 0; }
    .brand-text h1 { font-size: 14px; margin: 0; color: #fff; font-weight: 700; }
    .brand-text small { font-size: 11px; color: var(--muted); }
    .menu-list { flex: 1; padding: 16px 10px; overflow-y: auto; overflow-x: hidden; display: flex; flex-direction: column; gap: 4px; }
    .menu-title { font-size: 10px; font-weight: 800; letter-spacing: .1em; color: var(--muted); padding: 10px 10px 4px; text-transform: uppercase; white-space: nowrap; }
    aside.collapsed .menu-title { display: none; }
    .nav-item { display: flex; align-items: center; gap: 12px; padding: 11px 12px; border-radius: 10px; color: var(--muted); font-size: 13px; font-weight: 600; white-space: nowrap; cursor: pointer; }
    .nav-item:hover, .nav-item.active { background: var(--card-hover); color: #fff; }
    .nav-item svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0; }
    aside.collapsed .nav-item span { display: none; }

    /* STYLE MAIN CONTENT & RESPONSIF SIDEBAR */
    main { 
      margin-left: var(--sidebar-width); 
      flex: 1; 
      padding: 30px; 
      min-width: 0; 
      width: calc(100% - var(--sidebar-width));
      transition: margin-left 0.3s ease, width 0.3s ease;
    }
    aside.collapsed ~ main { 
      margin-left: var(--sidebar-collapsed); 
      width: calc(100% - var(--sidebar-collapsed));
    }
    .container { max-width: 800px; margin: 0 auto; width: 100%; }

    .page-header { margin-bottom: 24px; }
    .page-header h2 { font-size: 24px; margin: 0 0 4px; color: #fff; }
    .page-header p { margin: 0; color: var(--muted); font-size: 13px; }

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

    .card { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 24px; box-shadow: var(--shadow); }

    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-size: 12px; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 8px; letter-spacing: .05em; }

    .form-control { width: 100%; background: var(--bg); border: 1px solid var(--line); color: var(--ink); padding: 12px 14px; border-radius: 10px; font-size: 13px; outline: none; transition: border-color 0.2s ease; }
    .form-control:focus { border-color: var(--green); }
    .form-control::placeholder { color: var(--muted); }
    .form-control.is-invalid { border-color: var(--red) !important; }

    .error-text { display: block; color: var(--red); font-size: 11px; margin-top: 6px; font-weight: 600; }

    .form-row { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }

    .form-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 30px; border-top: 1px solid var(--line); padding-top: 20px; flex-wrap: wrap; }

    .btn-secondary { background: transparent; border: 1px solid var(--line); color: var(--muted); padding: 10px 18px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; text-align: center; display: inline-flex; align-items: center; justify-content: center; }
    .btn-secondary:hover { color: #fff; background: var(--card-hover); }

    .btn-primary { background: var(--green); color: #fff; border: none; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 6px; }
    .btn-primary:hover { opacity: 0.9; }

    /* MEDIA QUERY RESPONSIF MOBILE */
    @media (max-width: 768px) {
      main { 
        margin-left: 0 !important; 
        width: 100% !important; 
        padding: 16px;
        padding-top: 60px;
      }
      .card { padding: 16px; }
      .form-row { 
        grid-template-columns: 1fr; 
        gap: 0;
      }
      .form-actions {
        flex-direction: column-reverse;
        gap: 10px;
      }
      .btn-primary, .btn-secondary { width: 100%; }
    }
  </style>
</head>
<body>

  <!-- SIDEBAR -->
  @include('layouts.sidebar')

  <!-- MAIN CONTENT -->
  <main>
    <div class="container">

      <!-- PAGE HEADER -->
      <div class="page-header">
        <h2>Tambah User Baru</h2>
        <p>Daftarkan akun pengguna baru ke dalam sistem pemantauan.</p>
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
        <form action="{{ route('users.store') }}" method="POST" id="userForm">
          @csrf

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
                value="{{ old('name') }}"
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
                value="{{ old('email') }}"
                required>
              @error('email')
                <span class="error-text">{{ $message }}</span>
              @enderror
            </div>
          </div>

          <!-- PASSWORD & KONFIRMASI PASSWORD -->
          <div class="form-row">
            <div class="form-group">
              <label for="password">Password *</label>
              <input
                type="password"
                id="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Minimal 8 karakter"
                required>
              @error('password')
                <span class="error-text" id="passwordError">{{ $message }}</span>
              @else
                <span class="error-text" id="passwordError" style="display: none;"></span>
              @enderror
            </div>

            <div class="form-group">
              <label for="password_confirmation">Konfirmasi Password *</label>
              <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Ulangi password di atas"
                required>
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
                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih Role User...</option>
                <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                <option value="programmer" {{ old('role') == 'programmer' ? 'selected' : '' }}>Programmer</option>
                <option value="viewer" {{ old('role') == 'viewer' ? 'selected' : '' }}>Viewer</option>
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
                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
              </select>
              @error('is_active')
                <span class="error-text">{{ $message }}</span>
              @enderror
            </div>
          </div>

          <!-- ACTIONS -->
          <div class="form-actions">
            <a href="{{ route('users.index') }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">Simpan User</button>
          </div>

        </form>
      </div>

    </div>
  </main>

  <!-- SCRIPT VALIDASI PASSWORD SAAT SIMPAN USER -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const userForm = document.getElementById('userForm');
      const passwordInput = document.getElementById('password');
      const confirmInput = document.getElementById('password_confirmation');
      const passwordError = document.getElementById('passwordError');
      const alertError = document.getElementById('alertError');

      // Reset tampilan error saat user mulai mengetik ulang
      function resetError() {
        passwordInput.classList.remove('is-invalid');
        confirmInput.classList.remove('is-invalid');
        passwordError.style.display = 'none';
      }

      passwordInput.addEventListener('input', resetError);
      confirmInput.addEventListener('input', resetError);

      // Validasi berjalan HANYA saat tombol "Simpan User" diklik
      userForm.addEventListener('submit', function(e) {
        const passVal = passwordInput.value;
        const confirmVal = confirmInput.value;

        let hasError = false;
        let passMsg = '';

        // 1. Cek jika password kurang dari 8 karakter
        if (passVal.length < 8) {
          hasError = true;
          passMsg = 'Password minimal harus 8 karakter.';
        } 
        // 2. Cek jika password dan konfirmasi password tidak cocok
        else if (passVal !== confirmVal) {
          hasError = true;
          passMsg = 'Konfirmasi password tidak cocok dengan password.';
        }

        // Jika ada kesalahan
        if (hasError) {
          e.preventDefault(); // Batalkan submit form

          // Merahkan KEDUANYA (Password & Konfirmasi Password)
          passwordInput.classList.add('is-invalid');
          confirmInput.classList.add('is-invalid');

          // Tampilkan teks error HANYA DI BAWAH FORM PASSWORD PERTAMA
          passwordError.textContent = passMsg;
          passwordError.style.display = 'block';

          // Tampilkan Alert Error di bagian paling atas
          alertError.textContent = 'Terdapat kesalahan pada form password, silakan periksa kembali isian di bawah.';
          alertError.style.display = 'block';
          
          // Scroll halus ke atas
          window.scrollTo({ top: 0, behavior: 'smooth' });
        }
      });
    });
  </script>

</body>
</html>