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
      --line: #2e4a3b;
      --green: #0f9f6e;
      --green-soft: rgba(15, 159, 110, 0.12);
      --red: #d94c4c;
      --red-soft: rgba(217, 76, 76, 0.12);
      --amber: #d98b1d;
      --amber-soft: rgba(217, 139, 29, 0.12);
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

    /* ==========================================================
       KODE RESPONSIF: STYLE MAIN CONTENT & PERGESERAN SIDEBAR
       ========================================================== */
    main { 
      margin-left: var(--sidebar-width); 
      flex: 1; 
      padding: 24px; 
      min-width: 0; 
      transition: margin-left 0.3s ease, width 0.3s ease;
      width: calc(100% - var(--sidebar-width));
    }
    
    /* Jika sidebar diperkecil (collapsed) di laptop */
    aside#sidebar.collapsed ~ main { 
      margin-left: var(--sidebar-collapsed); 
      width: calc(100% - var(--sidebar-collapsed));
    }

    .container { 
      max-width: 1280px; 
      margin: 0 auto; 
      width: 100%;
    }
    
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 14px; }
    .page-header h2 { font-size: 24px; margin: 0 0 4px; color: #fff; }
    .page-header p { margin: 0; color: var(--muted); font-size: 13px; }

    /* FILTER & METRIC SECTION */
    .filter-card { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 20px; box-shadow: var(--shadow); margin-bottom: 24px; }
    .filter-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 14px; }
    .filter-title { font-size: 14px; font-weight: 700; color: #fff; text-transform: uppercase; letter-spacing: .05em; }
    
    .filter-controls { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
    .filter-select { background: var(--bg); border: 1px solid var(--line); color: var(--ink); padding: 10px 14px; border-radius: 10px; font-size: 13px; outline: none; }

    /* ==========================================================
       KODE RESPONSIF: 5 KOTAK METRIK (GRID OTOMATIS)
       Menggunakan auto-fit agar menyesuaikan layar secara otomatis
       ========================================================== */
    .metrics-grid { 
      display: grid; 
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); 
      gap: 12px; 
    }
    .metric-box { background: var(--bg); border: 1px solid var(--line); border-radius: 12px; padding: 14px; text-align: center; }
    .metric-label { font-size: 11px; color: var(--muted); text-transform: uppercase; margin-bottom: 6px; font-weight: 600; }
    .metric-val { font-size: 16px; font-weight: 700; color: #fff; }

    /* ==========================================================
       KODE RESPONSIF: 3 KARTU RANKING (GRID OTOMATIS)
       ========================================================== */
    .ranking-grid { 
      display: grid; 
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); 
      gap: 16px; 
    }
    .ranking-card { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 20px; box-shadow: var(--shadow); }
    .ranking-card-title { font-size: 13px; font-weight: 700; color: #fff; margin-bottom: 4px; }
    .ranking-card-desc { font-size: 11px; color: var(--muted); margin: 0 0 12px; }
    .ranking-item { display: flex; justify-content: space-between; font-size: 12px; padding: 6px 0; border-top: 1px solid var(--line); }

    /* ==========================================================
       KODE RESPONSIF: KHUSUS LAYAR HP & TABLET (Max-width: 768px)
       ========================================================== */
    @media (max-width: 768px) {
      main { 
        margin-left: 0 !important; 
        width: 100% !important; 
        padding: 14px;
        padding-top: 60px; /* Ruang untuk tombol hamburger sidebar */
      }
      .filter-header {
        flex-direction: column;
        align-items: flex-start;
      }
      .filter-controls, .filter-select {
        width: 100%;
      }
    }
    .main-content,
    main {
      margin-top: var(--navbar-height, 60px);
    }
  </style>
</head>
<body>

  <!-- MEMANGGIL SIDEBAR -->
  @include('layouts.navigation')

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

      <!-- FILTER ANALYTICS & METRICS SECTION -->
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

        <!-- Daftar Metric -->
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

      <!-- 3 KARTU RANKING UTAMA -->
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