<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Analytics - Website Monitoring IT Solution</title>
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
    .container { max-width: 1280px; margin: 0 auto; }
    
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 14px; }
    .page-header h2 { font-size: 24px; margin: 0 0 4px; color: #fff; }
    .page-header p { margin: 0; color: var(--muted); font-size: 13px; }

    /* FILTER & METRIC SECTION (DI ATAS) */
    .filter-card { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 20px; box-shadow: var(--shadow); margin-bottom: 24px; }
    .filter-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 14px; }
    .filter-title { font-size: 14px; font-weight: 700; color: #fff; text-transform: uppercase; letter-spacing: .05em; }
    
    .filter-controls { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
    .filter-select { background: var(--bg); border: 1px solid var(--line); color: var(--ink); padding: 10px 14px; border-radius: 10px; font-size: 13px; outline: none; }

    /* METRIC CARDS GRID */
    .metrics-grid { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 12px; }
    .metric-box { background: var(--bg); border: 1px solid var(--line); border-radius: 12px; padding: 14px; text-align: center; }
    .metric-label { font-size: 11px; color: var(--muted); text-transform: uppercase; margin-bottom: 6px; font-weight: 600; }
    .metric-val { font-size: 16px; font-weight: 700; color: #fff; }

    /* 3 RANKING CARDS (DI BAWAHNYA) */
    .ranking-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; }
    .ranking-card { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 20px; box-shadow: var(--shadow); }
    .ranking-card-title { font-size: 13px; font-weight: 700; color: #fff; margin-bottom: 4px; }
    .ranking-card-desc { font-size: 11px; color: var(--muted); margin: 0 0 12px; }
    .ranking-item { display: flex; justify-content: space-between; font-size: 12px; padding: 6px 0; border-top: 1px solid var(--line); }

    @media (max-width: 1024px) {
      .metrics-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 768px) {
      .ranking-grid, .metrics-grid { grid-template-columns: 1fr; }
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
          <h2>Analytics</h2>
          <p>Analitik untuk melihat kualitas layanan hosting / website customer.</p>
        </div>
      </div>

      <!-- FILTER ANALYTICS & METRICS SECTION (POSISI DI ATAS) -->
      <div class="filter-card">
        <div class="filter-header">
          <div class="filter-title">Filter Analytics & Performa Metrik</div>
          
          <!-- Pilihan Rentang Waktu -->
          <div class="filter-controls">
            <select class="filter-select">
              <option value="today">Hari Ini</option>
              <option value="7days" selected>7 Hari</option>
              <option value="30days">30 Hari</option>
              <option value="custom">Custom Date Range</option>
            </select>
          </div>
        </div>

        <!-- Daftar Metric Sesuai Blueprint -->
        <div class="metrics-grid">
          <div class="metric-box">
            <div class="metric-label">Average Response Time</div>
            <div class="metric-val">245 ms</div>
          </div>
          <div class="metric-box">
            <div class="metric-label">Total Incident</div>
            <div class="metric-val" style="color: var(--red);">8 Kasus</div>
          </div>
          <div class="metric-box">
            <div class="metric-label">Total Downtime</div>
            <div class="metric-val">42 Menit</div>
          </div>
          <div class="metric-box">
            <div class="metric-label">Uptime %</div>
            <div class="metric-val" style="color: var(--green);">99.85%</div>
          </div>
          <div class="metric-box">
            <div class="metric-label">Recovery Time</div>
            <div class="metric-val">12 Menit</div>
          </div>
        </div>
      </div>

      <!-- 3 KARTU RANKING UTAMA (POSISI DI BAWAHNYA) -->
      <div class="ranking-grid">
        <div class="ranking-card">
          <div class="ranking-card-title">Website Paling Stabil</div>
          <p class="ranking-card-desc">Ranking uptime tertinggi</p>
          <div class="ranking-item"><span>1. portal-store.id</span> <b style="color:var(--green)">100%</b></div>
          <div class="ranking-item"><span>2. logistics-hub.co</span> <b style="color:var(--green)">99.9%</b></div>
        </div>
        <div class="ranking-card">
          <div class="ranking-card-title">Website Paling Sering Error</div>
          <p class="ranking-card-desc">Ranking jumlah incident</p>
          <div class="ranking-item"><span>1. my-shop.com</span> <b style="color:var(--red)">5 Kasus</b></div>
          <div class="ranking-item"><span>2. app-finance.id</span> <b style="color:var(--red)">3 Kasus</b></div>
        </div>
        <div class="ranking-card">
          <div class="ranking-card-title">Website Paling Lambat</div>
          <p class="ranking-card-desc">Average response tertinggi</p>
          <div class="ranking-item"><span>1. media-news.co</span> <b style="color:var(--amber)">3,410 ms</b></div>
          <div class="ranking-item"><span>2. store-online.id</span> <b style="color:var(--amber)">2,850 ms</b></div>
        </div>
      </div>

    </div>
  </main>

</body>
</html>