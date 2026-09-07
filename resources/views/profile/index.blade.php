<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil User - Website Monitoring IT Solution</title>
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
      max-width: none;
      margin: 0;
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

    /* ALERT */
    .alert-success {
      background: var(--green-soft);
      border: 1px solid #137a48;
      color: #137a48;
      padding: 12px 16px;
      border-radius: 10px;
      margin-bottom: 20px;
      font-size: 13px;
      font-weight: 700;
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
      border-radius: 18px;
      padding: 20px;
      box-shadow: var(--shadow);
    }

    .card-header-flex {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 16px;
      flex-wrap: wrap;
      gap: 10px;
      border-bottom: 1px solid var(--line);
      padding-bottom: 12px;
    }

    .card-title-group {
      display: flex;
      align-items: center;
      gap: 8px;
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

    /* BOX DATA DALAM KARTU */
    .info-boxes-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 16px;
    }

    .info-box-item {
      background: #fbfcfe;
      border: 1px solid var(--line);
      border-radius: 10px;
      padding: 14px;
      word-break: break-word;
    }

    .info-box-label {
      font-size: 10px;
      font-weight: 700;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 6px;
    }

    .info-box-value {
      font-size: 13px;
      font-weight: 700;
      color: var(--ink);
      word-break: break-word;
    }

    /* TOMBOL AKSI */
    .btn-edit {
      background: var(--green);
      color: #fff;
      border: none;
      padding: 8px 14px;
      border-radius: 10px;
      font-size: 12px;
      font-weight: 700;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: opacity 0.2s ease;
      white-space: nowrap;
      box-shadow: 0 4px 12px rgba(1, 50, 32, 0.2);
    }

    .btn-edit:hover {
      opacity: 0.9;
    }

    /* ==========================================================
       MEDIA QUERY: RESPONSIF UNTUK LAYAR TABLET & HP (Max 900px)
       ========================================================== */
    @media (max-width: 900px) {
      main {
        margin-left: 0 !important;
        width: 100% !important;
        padding: 85px 16px 16px 16px;
      }
      .profile-grid {
        grid-template-columns: 1fr;
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
        grid-template-columns: 1fr;
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

  <!-- NAVIGASI & SIDEBAR UTAMA -->
  @include('layouts.navigation')

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
            <div class="card-header-flex" style="margin-bottom: 12px; border-bottom: none; padding-bottom: 0;">
              <div class="card-title-group">
                <i class="bi bi-key"></i>
                <span>Keamanan & Password</span>
              </div>
            </div>

            <div class="info-boxes-grid" style="margin-top: 12px;">
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
            <div class="card-header-flex" style="margin-bottom: 16px;">
              <div class="card-title-group">
                <i class="bi bi-shield-shaded"></i>
                <span>Informasi Sistem</span>
              </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 12px;">
              <div class="info-box-item">
                <div class="info-box-label">ID PENGGUNA</div>
                <div class="info-box-value">#USR-{{ $user->id }}</div>
              </div>

              <div class="info-box-item">
                <div class="info-box-label">ROLE SISTEM</div>
                <div class="info-box-value" style="color: var(--green-vibrant);">
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