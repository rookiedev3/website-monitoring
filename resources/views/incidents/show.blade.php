<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Incident - Website Monitoring IT Solution</title>
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
      --amber: #d98b1d;
      --amber-soft: rgba(217, 139, 29, 0.12);
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

    /* STYLE SIDEBAR (Konsisten) */
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
    
    .user-profile-container { position: relative; border-top: 1px solid var(--line); padding: 12px; }
    .user-profile-btn { width: 100%; background: transparent; border: none; display: flex; align-items: center; gap: 10px; padding: 8px; border-radius: 10px; cursor: pointer; color: var(--ink); text-align: left; white-space: nowrap; overflow: hidden; }
    .user-profile-btn:hover { background: var(--card-hover); }
    .user-avatar { width: 34px; height: 34px; border-radius: 50%; background: #24372d; color: #fff; display: grid; place-items: center; font-weight: 700; font-size: 12px; flex-shrink: 0; }
    .user-info { flex: 1; overflow: hidden; }
    .user-info h4 { font-size: 12px; margin: 0; color: #fff; text-overflow: ellipsis; overflow: hidden; }
    .user-info p { font-size: 10px; margin: 0; color: var(--muted); text-overflow: ellipsis; overflow: hidden; }
    aside.collapsed .user-info { display: none; }
    
    .user-popup-menu { position: absolute; bottom: 70px; left: 12px; right: 12px; background: #16241d; border: 1px solid var(--line); border-radius: 12px; box-shadow: var(--shadow); display: none; flex-direction: column; overflow: hidden; z-index: 10; }
    .user-popup-menu.show { display: flex; }
    .popup-item { padding: 10px 14px; font-size: 12px; color: var(--ink); display: flex; align-items: center; gap: 8px; background: transparent; border: none; cursor: pointer; text-align: left; width: 100%; }
    .popup-item:hover { background: #1f3328; color: #fff; }
    .popup-item.danger { color: var(--red); }

    .sidebar-toggle-bar { border-top: 1px solid var(--line); padding: 10px 14px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; background: rgba(0,0,0,0.1); font-size: 11px; color: var(--muted); }
    .sidebar-toggle-bar:hover { background: var(--card-hover); color: #fff; }
    aside.collapsed .sidebar-toggle-text { display: none; }
    aside.collapsed .sidebar-toggle-bar { justify-content: center; }

    /* STYLE MAIN CONTENT */
    main { margin-left: var(--sidebar-width); flex: 1; padding: 30px; min-width: 0; }
    aside.collapsed ~ main { margin-left: var(--sidebar-collapsed); }
    .container { max-width: 1000px; margin: 0 auto; }
    
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px; }
    .page-header h2 { font-size: 24px; margin: 0 0 4px; color: #fff; }
    .page-header p { margin: 0; color: var(--muted); font-size: 13px; }

    .btn-secondary { background: transparent; border: 1px solid var(--line); color: var(--muted); padding: 8px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
    .btn-secondary:hover { color: #fff; background: var(--card-hover); }

    /* Grid Detail */
    .grid-2 { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px; margin-bottom: 24px; }
    .card { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 20px; box-shadow: var(--shadow); }
    .card-title { font-size: 14px; font-weight: 700; color: #fff; margin-bottom: 16px; text-transform: uppercase; letter-spacing: .05em; border-bottom: 1px solid var(--line); padding-bottom: 10px; }

    .info-list { display: flex; flex-direction: column; gap: 12px; font-size: 13px; }
    .info-item { display: flex; justify-content: space-between; }
    .info-label { color: var(--muted); }
    .info-value { color: #fff; font-weight: 600; text-align: right; }

    /* Form Update */
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 12px; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 6px; }
    .form-control { width: 100%; background: var(--bg); border: 1px solid var(--line); color: var(--ink); padding: 10px 14px; border-radius: 10px; font-size: 13px; outline: none; }
    .form-control:focus { border-color: var(--green); }
    textarea.form-control { resize: vertical; min-height: 90px; }

    .btn-primary { background: var(--green); color: #fff; border: none; padding: 10px 18px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; width: 100%; }
    .btn-primary:hover { opacity: 0.9; }

    .badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 99px; font-size: 11px; font-weight: 700; }
    .badge.open { background: var(--red-soft); color: var(--red); }
    .badge.progress { background: var(--amber-soft); color: var(--amber); }

    /* Timeline Notes */
    .timeline { display: flex; flex-direction: column; gap: 14px; margin-top: 10px; }
    .timeline-item { background: var(--bg); border: 1px solid var(--line); padding: 12px 14px; border-radius: 10px; font-size: 12px; }
    .timeline-header { display: flex; justify-content: space-between; margin-bottom: 4px; color: var(--muted); font-weight: 600; }
    .timeline-body { color: var(--ink); }

    @media (max-width: 768px) {
      .grid-2 { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

  <!-- MEMANGGIL SIDEBAR -->
  @include('layouts.sidebar')

  <!-- MAIN CONTENT -->
  <main>
    <div class="container">
      
      <!-- PAGE HEADER -->
      <div class="page-header">
        <div>
          <h2>Detail & Penanganan Incident</h2>
          <p>ID Gangguan: <b>#INC-2026-0828</b></p>
        </div>
        <a href="{{ route('incidents.index') }}" class="btn-secondary">
          &larr; Kembali ke Daftar Error
        </a>
      </div>

      <!-- GRID INFORMASI & FORM UPDATE -->
      <div class="grid-2">
        
        <!-- Kolom 1: Informasi Gangguan -->
<!-- Di dalam file resources/views/incidents/show.blade.php -->
<div class="card">
  <div class="card-title">Informasi Gangguan</div>
  <div class="info-list">
    <div class="info-item">
      <span class="info-label">Website / Domain</span>
      <span class="info-value">portal-store.id</span>
    </div>
    <div class="info-item">
      <span class="info-label">Customer</span>
      <span class="info-value">CV Berkah Abadi</span>
    </div>
    <div class="info-item">
      <span class="info-label">Jenis Error</span>
      <span class="info-value" style="color:var(--red)">Connection Timeout</span>
    </div>
    <div class="info-item">
      <span class="info-label">HTTP Code</span>
      <span class="info-value">500</span>
    </div>
    <div class="info-item">
      <span class="info-label">Response Time</span>
      <span class="info-value">3,200 ms</span>
    </div>
    <div class="info-item">
      <span class="info-label">Mulai Error</span>
      <span class="info-value">28 Agu 2026, 08:12 WIB</span>
    </div>
    <div class="info-item">
      <span class="info-label">Durasi Gangguan</span>
      <span class="info-value">45 Menit</span>
    </div>
  </div>
</div>

        <!-- Kolom 2: Form Update oleh Programmer -->
        <div class="card">
          <div class="{{ route('incidents.update', $id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="form-group">
              <label>Ubah Status Pekerjaan</label>
              <select class="form-control" required>
                <option value="open" selected>Open (Belum Ditangani)</option>
                <option value="progress">On Progress (Sedang Dikerjakan)</option>
                <option value="resolved">Resolved (Selesai / Normal Kembali)</option>
              </select>
            </div>

            <div class="form-group">
              <label>Catatan Perbaikan / Root Cause</label>
              <textarea class="form-control" placeholder="Tuliskan kendala, hasil investigasi, atau langkah perbaikan..."></textarea>
            </div>

            <button type="submit" class="btn-primary">Simpan Pembaruan</button>
          </form>
        </div>

      </div>

      <!-- Riwayat Catatan Penanganan (Timeline) -->
      <div class="card">
        <div class="card-title">Riwayat Catatan Penanganan</div>
        <div class="timeline">
          <div class="timeline-item">
            <div class="timeline-header">
              <span><b>Budi</b> (Programmer)</span>
              <span>28 Agu 2026, 08:25 WIB</span>
            </div>
            <div class="timeline-body">
              Menerima penugasan. Sedang melakukan pengecekan log error di server database.
            </div>
          </div>
          <div class="timeline-item" style="border-style: dashed; opacity: 0.7;">
            <div class="timeline-header">
              <span>Sistem Monitoring</span>
              <span>28 Agu 2026, 08:12 WIB</span>
            </div>
            <div class="timeline-body">
              Incident otomatis dibuat oleh sistem akibat kegagalan koneksi (HTTP 500 Internal Server Error).
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>

</body>
</html>