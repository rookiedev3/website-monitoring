<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Analytics - Website Monitoring IT Solution</title>
  <link rel="icon" type="image/png" href="{{ asset('img/logo.jpeg') }}">
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

    /* SIDEBAR STYLE */
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
    }
    aside.collapsed { width: var(--sidebar-collapsed); }

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

    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px; }
    .page-header h2 { font-size: 22px; margin: 0 0 4px; color: #172033; font-weight: 800; }
    .page-header p { margin: 0; color: var(--muted); font-size: 12px; font-weight: 600; }

    .filter-card { background: var(--card); border: 1px solid var(--line); border-radius: 18px; padding: 20px; box-shadow: var(--shadow); margin-bottom: 24px; }
    .filter-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 14px; }
    .filter-title { font-size: 14px; font-weight: 800; color: #172033; text-transform: uppercase; letter-spacing: .05em; }

    .filter-controls { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
    .filter-select, .filter-date { background: #fbfcfe; border: 1px solid var(--line); color: var(--ink); padding: 10px 14px; border-radius: 10px; font-size: 13px; font-weight: 600; outline: none; transition: border-color 0.2s ease; }
    .filter-select:focus, .filter-date:focus { border-color: var(--green-vibrant); background: #ffffff; box-shadow: 0 0 0 3px rgba(0, 107, 63, 0.1); }
    
    .filter-date { display: none; }
    .filter-date.show { display: inline-block; }
    
    .btn-apply {
      background: var(--green); border: none; color: #fff;
      padding: 10px 18px; border-radius: 10px; font-size: 13px;
      font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(1, 50, 32, 0.2);
      transition: opacity 0.2s ease;
    }
    .btn-apply:hover { opacity: .9; }

    .metrics-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
      gap: 16px;
    }
    .metric-box { background: #f8fafc; border: 1px solid var(--line); border-radius: 14px; padding: 16px; text-align: center; }
    .metric-label { font-size: 11px; color: var(--muted); text-transform: uppercase; margin-bottom: 6px; font-weight: 700; }
    .metric-val { font-size: 18px; font-weight: 800; color: #172033; }

    .ranking-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
    }
    .ranking-card { background: var(--card); border: 1px solid var(--line); border-radius: 18px; padding: 20px; box-shadow: var(--shadow); }
    .ranking-card-title { font-size: 14px; font-weight: 800; color: #172033; margin-bottom: 4px; }
    .ranking-card-desc { font-size: 11px; color: var(--muted); margin: 0 0 16px; font-weight: 600; }
    .ranking-item { display: flex; justify-content: space-between; font-size: 13px; padding: 10px 0; border-top: 1px solid var(--line); font-weight: 600; }
    .ranking-empty { font-size: 12px; color: var(--muted); padding: 14px 0; font-weight: 600; text-align: center; }

    @media (max-width: 768px) {
      main {
        margin-left: 0 !important;
        width: 100% !important;
        padding: 85px 16px 16px 16px;
      }
      .filter-header {
        flex-direction: column;
        align-items: flex-start;
      }
      .filter-controls, .filter-select, .filter-date, .btn-apply {
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <!-- MEMANGGIL SIDEBAR -->
  @include('layouts.navigation')

  <main>
    <div class="container">

      <div class="page-header">
        <div>
          <h2>Analytics</h2>
          <p>Analitik untuk melihat kualitas layanan hosting / website customer.</p>
        </div>
      </div>

      <div class="filter-card">
        <form method="GET" action="{{ route('analytics.index') }}" id="analyticsFilterForm">
          <div class="filter-header">
            <div class="filter-title">Filter Analytics & Performa Metrik</div>

            <div class="filter-controls">
              <select name="range" id="rangeSelect" class="filter-select" onchange="handleRangeChange()">
                <option value="today" @selected($range === 'today')>Hari Ini</option>
                <option value="7days" @selected($range === '7days')>7 Hari</option>
                <option value="30days" @selected($range === '30days')>30 Hari</option>
                <option value="custom" @selected($range === 'custom')>Custom Date Range</option>
              </select>

              <input
                type="date"
                name="start"
                id="startDate"
                class="filter-date {{ $range === 'custom' ? 'show' : '' }}"
                value="{{ $startDate }}"
                max="{{ now()->format('Y-m-d') }}"
              >
              <input
                type="date"
                name="end"
                id="endDate"
                class="filter-date {{ $range === 'custom' ? 'show' : '' }}"
                value="{{ $endDate }}"
                max="{{ now()->format('Y-m-d') }}"
              >

              <button type="submit" class="btn-apply">Terapkan</button>
            </div>
          </div>

          <div class="metrics-grid">
            <div class="metric-box">
              <div class="metric-label">Average Response Time</div>
              <div class="metric-val">
                {{ $stats['avg_response_time'] !== null ? number_format($stats['avg_response_time']) . ' ms' : '-' }}
              </div>
            </div>
            <div class="metric-box">
              <div class="metric-label">Total Incident</div>
              <div class="metric-val" style="color: var(--red);">{{ $stats['total_incidents'] }} Kasus</div>
            </div>
            <div class="metric-box">
              <div class="metric-label">Total Downtime</div>
              <div class="metric-val">{{ number_format($stats['total_downtime_minutes']) }} Menit</div>
            </div>
            <div class="metric-box">
              <div class="metric-label">Uptime %</div>
              <div class="metric-val" style="color: #137a48;">
                {{ $stats['uptime_percentage'] !== null ? number_format($stats['uptime_percentage'], 2) . '%' : '-' }}
              </div>
            </div>
            <div class="metric-box">
              <div class="metric-label">Recovery Time</div>
              <div class="metric-val">
                {{ $stats['recovery_time_minutes'] !== null ? number_format($stats['recovery_time_minutes']) . ' Menit' : '-' }}
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="ranking-grid">
        <div class="ranking-card">
          <div class="ranking-card-title">Website Paling Stabil</div>
          <p class="ranking-card-desc">Ranking uptime tertinggi</p>
          @forelse($mostStable as $index => $item)
            <div class="ranking-item">
              <span>{{ $index + 1 }}. {{ $item->website->website_name }}</span>
              <b style="color:#137a48">{{ number_format($item->uptime, 2) }}%</b>
            </div>
          @empty
            <div class="ranking-empty">Belum ada data pada rentang ini.</div>
          @endforelse
        </div>

        <div class="ranking-card">
          <div class="ranking-card-title">Website Paling Sering Error</div>
          <p class="ranking-card-desc">Ranking jumlah incident</p>
          @forelse($mostErrors as $index => $item)
            <div class="ranking-item">
              <span>{{ $index + 1 }}. {{ $item->website->website_name }}</span>
              <b style="color:var(--red)">{{ $item->incidents_count }} Kasus</b>
            </div>
          @empty
            <div class="ranking-empty">Belum ada data pada rentang ini.</div>
          @endforelse
        </div>

        <div class="ranking-card">
          <div class="ranking-card-title">Website Paling Lambat</div>
          <p class="ranking-card-desc">Average response tertinggi</p>
          @forelse($slowest as $index => $item)
            <div class="ranking-item">
              <span>{{ $index + 1 }}. {{ $item->website->website_name }}</span>
              <b style="color:var(--amber)">{{ number_format($item->avg_response_time) }} ms</b>
            </div>
          @empty
            <div class="ranking-empty">Belum ada data pada rentang ini.</div>
          @endforelse
        </div>
      </div>

    </div>
  </main>

  <script>
    function handleRangeChange() {
      const range = document.getElementById('rangeSelect').value;
      const startInput = document.getElementById('startDate');
      const endInput = document.getElementById('endDate');

      if (range === 'custom') {
        startInput.classList.add('show');
        endInput.classList.add('show');
      } else {
        startInput.classList.remove('show');
        endInput.classList.remove('show');
        document.getElementById('analyticsFilterForm').submit();
      }
    }
  </script>

</body>
</html>