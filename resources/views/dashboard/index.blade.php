<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Website Monitoring IT Solution</title>
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
    
    .user-profile-container { position: relative; border-top: 1px solid var(--line); padding: 12px; }
    .user-profile-btn { width: 100%; background: transparent; border: none; display: flex; align-items: center; gap: 10px; padding: 8px; border-radius: 10px; cursor: pointer; color: var(--ink); text-align: left; white-space: nowrap; overflow: hidden; }
    .user-profile-btn:hover { background: var(--card-hover); }
    .user-avatar { width: 34px; height: 34px; border-radius: 50%; background: #24372d; color: #fff; display: grid; place-items: center; font-weight: 700; font-size: 12px; flex-shrink: 0; }
    .user-info { flex: 1; overflow: hidden; }
    .user-info h4 { font-size: 12px; margin: 0; color: #fff; text-overflow: ellipsis; overflow: hidden; }
    .user-info p { font-size: 10px; margin: 0; color: var(--muted); text-overflow: ellipsis; overflow: hidden; }
    aside.collapsed .user-info, aside.collapsed .popup-arrow { display: none; }
    
    .user-popup-menu { position: absolute; bottom: 70px; left: 12px; right: 12px; background: #16241d; border: 1px solid var(--line); border-radius: 12px; box-shadow: var(--shadow); display: none; flex-direction: column; overflow: hidden; z-index: 10; }
    .user-popup-menu.show { display: flex; }
    .popup-item { padding: 10px 14px; font-size: 12px; color: var(--ink); display: flex; align-items: center; gap: 8px; background: transparent; border: none; cursor: pointer; text-align: left; width: 100%; }
    .popup-item:hover { background: #1f3328; color: #fff; }
    .popup-item.danger { color: var(--red); }
    .popup-item.danger:hover { background: rgba(217,76,76,0.15); }

    .sidebar-toggle-bar { border-top: 1px solid var(--line); padding: 10px 14px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; background: rgba(0,0,0,0.1); font-size: 11px; color: var(--muted); }
    .sidebar-toggle-bar:hover { background: var(--card-hover); color: #fff; }
    aside.collapsed .sidebar-toggle-text { display: none; }
    aside.collapsed .sidebar-toggle-bar { justify-content: center; }

    /* STYLE MAIN CONTENT */
    main { margin-left: var(--sidebar-width); flex: 1; padding: 30px; min-width: 0; }
    aside.collapsed ~ main { margin-left: var(--sidebar-collapsed); }
    .container { max-width: 1180px; margin: 0 auto; }
    
    /* Header & Alert */
    .dashboard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px; }
    .dashboard-header h2 { font-size: 24px; margin: 0 0 4px; color: #fff; }
    .dashboard-header p { margin: 0; color: var(--muted); font-size: 13px; }
    .system-alert-badge { background: var(--red-soft); border: 1px solid rgba(217,76,76,0.3); color: var(--red); padding: 10px 16px; border-radius: 12px; font-size: 12px; font-weight: 700; }
    
    /* Metrics Grid */
    .metrics-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; margin-bottom: 24px; }
    .metric-card { background: var(--card); border: 1px solid var(--line); border-radius: 14px; padding: 18px; box-shadow: var(--shadow); }
    .metric-card span { font-size: 11px; color: var(--muted); font-weight: 700; text-transform: uppercase; }
    .metric-card h3 { font-size: 26px; margin: 6px 0 6px; color: #fff; }
    .metric-card p { font-size: 11px; margin: 0; color: var(--muted); }
    
    /* Stacked Sections (Lebar & Lega ke Bawah) */
    .dashboard-stack { display: flex; flex-direction: column; gap: 20px; }
    .card { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 20px; box-shadow: var(--shadow); }
    .card-title { font-size: 15px; font-weight: 700; color: #fff; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center; }
    
    table { width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; }
    th { color: var(--muted); font-size: 11px; text-transform: uppercase; padding: 10px 12px; border-bottom: 1px solid var(--line); }
    td { padding: 12px; border-bottom: 1px solid var(--line); color: var(--ink); }
    tr:last-child td { border-bottom: none; }
    
    .badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 99px; font-size: 11px; font-weight: 700; }
    .badge.online { background: var(--green-soft); color: var(--green); }
    .badge.down { background: var(--red-soft); color: var(--red); }
    .badge.warning { background: var(--amber-soft); color: var(--amber); }

    /* Responsive adjustments */
    @media (max-width: 1024px) {
      .metrics-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
  </style>
</head>
<body>

  <!-- MEMANGGIL SIDEBAR YANG SUDAH DIPISAH -->
  @include('layouts.sidebar')

  <!-- MAIN CONTENT -->
  <main>
    <div class="container">
      
      <!-- HEADER & ALERT -->
      <div class="dashboard-header">
        <div>
          <h2>Dashboard Utama</h2>
          <p>Pantauan kondisi seluruh website customer saat ini.</p>
        </div>
        <div class="system-alert-badge">
          ⚠️ ADA 8 WEBSITE MEMERLUKAN PERHATIAN
        </div>
      </div>

      <!-- 4 METRIK CARD -->
      <div class="metrics-grid">
        <div class="metric-card">
          <span>Total Website</span>
          <h3>405</h3>
          <p>Total website aktif dimonitor</p>
        </div>
        <div class="metric-card">
          <span>Online</span>
          <h3 style="color:var(--green)">397</h3>
          <p>Jumlah & persentase website normal</p>
        </div>
        <div class="metric-card">
          <span>Uptime Rata-rata</span>
          <h3>99.42%</h3>
          <p>Default 30 hari terakhir</p>
        </div>
        <div class="metric-card">
          <span>Total Error</span>
          <h3 style="color:var(--red)">8</h3>
          <p>Incident open + on progress</p>
        </div>
      </div>

      <!-- STACKED SECTIONS (Lebar & Lega ke Bawah) -->
      <div class="dashboard-stack">
        
        <!-- 1. Daftar Website Dipantau -->
        <div class="card">
          <div class="card-title">
            Daftar Website Dipantau
            <span style="font-size:11px; color:var(--muted); font-weight:normal;">Menampilkan status terbaru</span>
          </div>
          <table>
            <thead>
              <tr>
                <th>Domain</th>
                <th>Status</th>
                <th>Response</th>
                <th>Uptime</th>
                <th>Dicek</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><b>client-one.com</b></td>
                <td><span class="badge online">● Online</span></td>
                <td>240 ms</td>
                <td>99.9%</td>
                <td>Baru saja</td>
              </tr>
              <tr>
                <td><b>portal-store.id</b></td>
                <td><span class="badge down">● Down</span></td>
                <td>-</td>
                <td>94.2%</td>
                <td>1 m lalu</td>
              </tr>
              <tr>
                <td><b>logistics-hub.co</b></td>
                <td><span class="badge warning">● Warning</span></td>
                <td>3,410 ms</td>
                <td>98.1%</td>
                <td>2 m lalu</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- 2. Rekap Website Error (Pindah ke Bawah & Full Width) -->
        <div class="card">
          <div class="card-title">
            Rekap Website Error
            <span style="font-size:11px; color:var(--muted); font-weight:normal;">Daftar incident aktif yang memerlukan penanganan</span>
          </div>
          <table>
            <thead>
              <tr>
                <th>Website</th>
                <th>Jenis Error</th>
                <th>Sejak</th>
                <th>PIC</th>
                <th>Status Pekerjaan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><b>portal-store.id</b></td>
                <td><span class="badge down">Timeout (500)</span></td>
                <td>08:12 WIB</td>
                <td>Budi</td>
                <td><span class="badge warning">Open</span></td>
              </tr>
              <tr>
                <td><b>logistics-hub.co</b></td>
                <td><span class="badge warning">Slow Response</span></td>
                <td>07:45 WIB</td>
                <td>Andi</td>
                <td><span class="badge online" style="background:var(--amber-soft); color:var(--amber);">On Progress</span></td>
              </tr>
            </tbody>
          </table>
        </div>
        
      </div> <!-- End of Dashboard Stack -->

    </div>
  </main>

</body>
</html>