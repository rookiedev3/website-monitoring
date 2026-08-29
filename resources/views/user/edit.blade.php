<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User - Website Monitoring IT Solution</title>
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

    * { box-sizing: border-box; transition: width 0.3s ease, padding 0.3s ease; }
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

    /* STYLE MAIN CONTENT */
    main { margin-left: var(--sidebar-width); flex: 1; padding: 30px; min-width: 0; }
    aside.collapsed ~ main { margin-left: var(--sidebar-collapsed); }
    .container { max-width: 800px; margin: 0 auto; }

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

    .form-control { width: 100%; background: var(--bg); border: 1px solid var(--line); color: var(--ink); padding: 12px 14px; border-radius: 10px; font-size: 13px; outline: none; }
    .form-control:focus { border-color: var(--green); }
    .form-control::placeholder { color: var(--muted); }
    .form-control.is-invalid { border-color: var(--red); }

    .error-text { display: block; color: var(--red); font-size: 11px; margin-top: 6px; font-weight: 600; }

    .form-row { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }

    .form-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 30px; border-top: 1px solid var(--line); padding-top: 20px; }

    .btn-secondary { background: transparent; border: 1px solid var(--line); color: var(--muted); padding: 10px 18px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; }
    .btn-secondary:hover { color: #fff; background: var(--card-hover); }

    .btn-primary { background: var(--green); color: #fff; border: none; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
    .btn-primary:hover { opacity: 0.9; }

    @media (max-width: 768px) {
      .form-row { grid-template-columns: 1fr; }
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
        <h2>Edit User</h2>
        <p>Perbarui informasi akun, role, status, atau password pengguna.</p>
      </div>

      <!-- ALERT ERROR -->
      @if ($errors->any())
        <div class="alert-error">
          Terdapat {{ $errors->count() }} kesalahan pada form, silakan periksa kembali isian di bawah.
        </div>
      @endif

      <!-- FORM CARD -->
      <div class="card">
        <form action="{{ route('users.update', $user) }}" method="POST">
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
                <span class="error-text">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group">
              <label for="password_confirmation">Konfirmasi Password Baru</label>
              <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-control"
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

</body>
</html>
