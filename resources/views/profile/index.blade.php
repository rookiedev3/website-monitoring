<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil User - Website Monitoring IT Solution</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <style>
    :root {
      --bg: #0b120f;
      --card: #111b16;
      --card-hover: #17231d;
      --ink: #dce9e1;
      --muted: #82988c;
      --line: #2e4a3b;
      --green: #0f9f6e;
      --green-soft: rgba(15, 159, 110, 0.12);
      --red: #d94c4c;
      --red-soft: rgba(217, 76, 76, 0.12);
      --shadow: 0 10px 30px rgba(0,0,0,.3);
      --sidebar-width: 215px;
      --sidebar-collapsed: 62px;
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

    /* STYLE MAIN CONTENT & PERGESERAN SIDEBAR RESPONSIF */
    main { 
      margin-left: var(--sidebar-width); 
      flex: 1; 
      padding: 24px; 
      min-width: 0; 
      transition: margin-left 0.3s ease, width 0.3s ease;
      width: calc(100% - var(--sidebar-width));
    }
    aside#sidebar.collapsed ~ main { 
      margin-left: var(--sidebar-collapsed); 
      width: calc(100% - var(--sidebar-collapsed));
    }
    .container { max-width: 1100px; margin: 0 auto; width: 100%; }

    .page-header { margin-bottom: 24px; }
    .page-header h2 { font-size: 24px; margin: 0 0 4px; color: #fff; }
    .page-header p { margin: 0; color: var(--muted); font-size: 13px; }

    /* ALERT */
    .alert-success {
      background: var(--green-soft);
      border: 1px solid var(--green);
      color: var(--green);
      padding: 12px 16px;
      border-radius: 10px;
      margin-bottom: 20px;
      font-size: 13px;
      font-weight: 600;
    }

    /* GRID LAYOUT HALAMAN PROFIL */
    .profile-grid {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 20px;
    }
    .profile-col-left {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .card { 
      background: var(--card); 
      border: 1px solid var(--line); 
      border-radius: 16px; 
      padding: 24px; 
      box-shadow: var(--shadow); 
    }

    .card-header-flex {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      flex-wrap: wrap;
      gap: 10px;
    }
    .card-title-group {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 15px;
      font-weight: 700;
      color: #fff;
    }
    .card-title-group i {
      font-size: 18px;
      color: var(--green);
    }

    /* BOX DATA DALAM KARTU */
    .info-boxes-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 16px;
    }
    .info-box-item {
      background: var(--bg);
      border: 1px solid var(--line);
      border-radius: 12px;
      padding: 16px;
      word-break: break-word;
    }
    .info-box-label {
      font-size: 10px;
      font-weight: 700;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: .05em;
      margin-bottom: 6px;
    }
    .info-box-value {
      font-size: 14px;
      font-weight: 600;
      color: #fff;
      word-break: break-word;
    }

    /* TOMBOL AKSI */
    .btn-edit {
      background: var(--green);
      color: #fff;
      border: none;
      padding: 8px 16px;
      border-radius: 10px;
      font-size: 12px;
      font-weight: 700;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: opacity 0.2s;
      white-space: nowrap;
    }
    .btn-edit:hover { opacity: 0.9; }

    /* ==========================================================
       MEDIA QUERY: RESPONSIF UNTUK LAYAR TABLET & HP (Max 900px)
       ========================================================== */
    @media (max-width: 900px) {
      main { 
        margin-left: 0 !important; 
        width: 100% !important; 
        padding: 14px;
        padding-top: 60px; /* Ruang untuk toggle sidebar di mobile */
      }
      .profile-grid {
        grid-template-columns: 1fr; /* Mengubah grid 2 kolom menjadi 1 kolom vertikal */
      }
    }

    /* ==========================================================
       MEDIA QUERY: KHUSUS LAYAR KECIL / HP (Max 600px)
       ========================================================== */
    @media (max-width: 600px) {
      .card {
        padding: 16px;
      }
      .info-boxes-grid {
        grid-template-columns: 1fr; /* Kotak info di dalam card menjadi 1 kolom bertumpuk */
      }
      .card-header-flex {
        flex-direction: column;
        align-items: flex-start;
      }
      .btn-edit {
        width: 100%;
        justify-content: center;
      }
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
        <h2>Profil Pengguna</h2>
        <p>Kelola informasi data diri, akun, dan keamanan kata sandi Anda.</p>
      </div>

      @if(session('success'))
        <div class="alert-success">
          ✓ {{ session('success') }}
        </div>
      @endif

      <div class="profile-grid">
        
        <!-- KOLOM KIRI (DATA DIRI & KEAMANAN PASSWORD) -->
        <div class="profile-col-left">
          
          <!-- KARTU 1: DETAIL DATA DIRI -->
          <div class="card">
            <div class="card-header-flex">
              <div class="card-title-group">
                <i class="bi bi-person"></i>
                <span>Detail Data Diri</span>
              </div>
              <a href="{{ route('profile.edit') }}" class="btn-edit">
                <i class="bi bi-pencil-square"></i> Edit Profil
              </a>
            </div>

            <div class="info-boxes-grid">
              <div class="info-box-item">
                <div class="info-box-label">Nama Lengkap</div>
                <div class="info-box-value">{{ $user->name }}</div>
              </div>
              <div class="info-box-item">
                <div class="info-box-label">Alamat Email</div>
                <div class="info-box-value">{{ $user->email }}</div>
              </div>
            </div>
          </div>

          <!-- KARTU 2: KEAMANAN & PASSWORD -->
          <div class="card">
            <div class="card-header-flex">
              <div class="card-title-group">
                <i class="bi bi-key"></i>
                <span>Keamanan & Password</span>
              </div>
            </div>

            <div class="info-boxes-grid">
              <div class="info-box-item" style="grid-column: 1 / -1;">
                <div class="info-box-label">Kata Sandi Akun</div>
                <div class="info-box-value" style="letter-spacing: 3px; color: var(--muted);">••••••••••••</div>
              </div>
            </div>
          </div>

        </div>

        <!-- KOLOM KANAN (INFORMASI SISTEM / ROLE) -->
        <div>
          <div class="card">
            <div class="card-title-group" style="margin-bottom: 20px;">
              <i class="bi bi-shield-shaded"></i>
              <span>Informasi Sistem</span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 16px;">
              <div class="info-box-item">
                <div class="info-box-label">ID PENGGUNA</div>
                <div class="info-box-value">#USR-{{ $user->id }}</div>
              </div>

              <div class="info-box-item">
                <div class="info-box-label">ROLE SISTEM</div>
                <div class="info-box-value" style="color: var(--green);">
                  {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                </div>
              </div>

            <div class="info-box-item">
              <div class="info-box-label">LOGIN TERAKHIR</div>
              <div class="info-box-value" style="font-size: 12px; color: var(--muted);">
                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum pernah login' }}
              </div>
            </div>
            </div>

          </div>
        </div>

      </div>

    </div>
  </main>

</body>
</html>