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

    .container {
      max-width: 1280px;
      margin: 0 auto;
      width: 100%;
    }

    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 14px; }
    .page-header h2 { font-size: 24px; margin: 0 0 4px; color: #fff; }
    .page-header p { margin: 0; color: var(--muted); font-size: 13px; }

    .filter-card { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 20px; box-shadow: var(--shadow); margin-bottom: 24px; }
    .filter-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 14px; }
    .filter-title { font-size: 14px; font-weight: 700; color: #fff; text-transform: uppercase; letter-spacing: .05em; }

    .filter-controls { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
    .filter-select, .filter-date { background: var(--bg); border: 1px solid var(--line); color: var(--ink); padding: 10px 14px; border-radius: 10px; font-size: 13px; outline: none; }
    .filter-date { display: none; }
    .filter-date.show { display: inline-block; }
    .btn-apply {
      background: var(--green); border: none; color: #fff;
      padding: 10px 16px; border-radius: 10px; font-size: 13px;
      font-weight: 700; cursor: pointer;
    }
    .btn-apply:hover { opacity: .9; }

    .metrics-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 12px;
    }
    .metric-box { background: var(--bg); border: 1px solid var(--line); border-radius: 12px; padding: 14px; text-align: center; }
    .metric-label { font-size: 11px; color: var(--muted); text-transform: uppercase; margin-bottom: 6px; font-weight: 600; }
    .metric-val { font-size: 16px; font-weight: 700; color: #fff; }

    .ranking-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 16px;
    }
    .ranking-card { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 20px; box-shadow: var(--shadow); }
    .ranking-card-title { font-size: 13px; font-weight: 700; color: #fff; margin-bottom: 4px; }
    .ranking-card-desc { font-size: 11px; color: var(--muted); margin: 0 0 12px; }
    .ranking-item { display: flex; justify-content: space-between; font-size: 12px; padding: 6px 0; border-top: 1px solid var(--line); }
    .ranking-empty { font-size: 12px; color: var(--muted); padding: 10px 0; }

    @media (max-width: 768px) {
      main {
        margin-left: 0 !important;
        width: 100% !important;
        padding: 14px;
        padding-top: 60px;
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

  @include('layouts.sidebar')

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
              <div class="metric-val" style="color: var(--green);">
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
              <b style="color:var(--green)">{{ number_format($item->uptime, 2) }}%</b>
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