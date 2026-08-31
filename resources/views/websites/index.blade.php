<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Website Management - Website Monitoring IT Solution</title>
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
      --amber: #d98b1d;
      --amber-soft: rgba(217, 139, 29, 0.12);
      --blue: #2563eb;
      --blue-soft: rgba(37, 99, 235, 0.12);
      --shadow: 0 10px 30px rgba(0, 0, 0, .3);
      --sidebar-width: 215px;
      --sidebar-collapsed: 62px;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, sans-serif;
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

    /* STYLE SIDEBAR */
    aside {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: var(--sidebar-width);
      background: var(--card);
      border-right: 1px solid var(--line);
      display: flex;
      flex-direction: column;
      z-index: 100;
      box-shadow: var(--shadow);
    }

    aside.collapsed {
      width: var(--sidebar-collapsed);
    }

    .brand-area {
      padding: 20px 16px;
      display: flex;
      align-items: center;
      gap: 12px;
      border-bottom: 1px solid var(--line);
      overflow: hidden;
      white-space: nowrap;
    }

    .logo {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      background: linear-gradient(135deg, #17231d, #24372d);
      border: 1px solid var(--line);
      display: grid;
      place-items: center;
      font-weight: 900;
      color: var(--green);
      flex-shrink: 0;
    }

    .brand-text h1 {
      font-size: 14px;
      margin: 0;
      color: #fff;
      font-weight: 700;
    }

    .brand-text small {
      font-size: 11px;
      color: var(--muted);
    }

    .menu-list {
      flex: 1;
      padding: 16px 10px;
      overflow-y: auto;
      overflow-x: hidden;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .menu-title {
      font-size: 10px;
      font-weight: 800;
      letter-spacing: .1em;
      color: var(--muted);
      padding: 10px 10px 4px;
      text-transform: uppercase;
      white-space: nowrap;
    }

    aside.collapsed .menu-title {
      display: none;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 11px 12px;
      border-radius: 10px;
      color: var(--muted);
      font-size: 13px;
      font-weight: 600;
      white-space: nowrap;
      cursor: pointer;
    }

    .nav-item:hover,
    .nav-item.active {
      background: var(--card-hover);
      color: #fff;
    }

    .nav-item svg {
      width: 20px;
      height: 20px;
      stroke: currentColor;
      fill: none;
      stroke-width: 2;
      stroke-linecap: round;
      stroke-linejoin: round;
      flex-shrink: 0;
    }

    aside.collapsed .nav-item span {
      display: none;
    }

    .user-profile-container {
      position: relative;
      border-top: 1px solid var(--line);
      padding: 12px;
    }

    .user-profile-btn {
      width: 100%;
      background: transparent;
      border: none;
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 8px;
      border-radius: 10px;
      cursor: pointer;
      color: var(--ink);
      text-align: left;
      white-space: nowrap;
      overflow: hidden;
    }

    .user-profile-btn:hover {
      background: var(--card-hover);
    }

    .user-avatar {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      background: #24372d;
      color: #fff;
      display: grid;
      place-items: center;
      font-weight: 700;
      font-size: 12px;
      flex-shrink: 0;
    }

    .user-info {
      flex: 1;
      overflow: hidden;
    }

    .user-info h4 {
      font-size: 12px;
      margin: 0;
      color: #fff;
      text-overflow: ellipsis;
      overflow: hidden;
    }

    .user-info p {
      font-size: 10px;
      margin: 0;
      color: var(--muted);
      text-overflow: ellipsis;
      overflow: hidden;
    }

    aside.collapsed .user-info {
      display: none;
    }

    .user-popup-menu {
      position: absolute;
      bottom: 70px;
      left: 12px;
      right: 12px;
      background: #16241d;
      border: 1px solid var(--line);
      border-radius: 12px;
      box-shadow: var(--shadow);
      display: none;
      flex-direction: column;
      overflow: hidden;
      z-index: 10;
    }

    .user-popup-menu.show {
      display: flex;
    }

    .popup-item {
      padding: 10px 14px;
      font-size: 12px;
      color: var(--ink);
      display: flex;
      align-items: center;
      gap: 8px;
      background: transparent;
      border: none;
      cursor: pointer;
      text-align: left;
      width: 100%;
    }

    .popup-item:hover {
      background: #1f3328;
      color: #fff;
    }

    .popup-item.danger {
      color: var(--red);
    }

    .sidebar-toggle-bar {
      border-top: 1px solid var(--line);
      padding: 10px 14px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      cursor: pointer;
      background: rgba(0, 0, 0, 0.1);
      font-size: 11px;
      color: var(--muted);
    }

    .sidebar-toggle-bar:hover {
      background: var(--card-hover);
      color: #fff;
    }

    aside.collapsed .sidebar-toggle-text {
      display: none;
    }

    aside.collapsed .sidebar-toggle-bar {
      justify-content: center;
    }

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
      max-width: 1180px;
      margin: 0 auto;
      width: 100%;
    }

    /* Header & Actions Bar */
    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
      flex-wrap: wrap;
      gap: 14px;
    }

    .page-header h2 {
      font-size: 24px;
      margin: 0 0 4px;
      color: #fff;
    }

    .page-header p {
      margin: 0;
      color: var(--muted);
      font-size: 13px;
    }

    .btn-primary {
      background: var(--green);
      color: #fff;
      border: none;
      padding: 10px 16px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      white-space: nowrap;
    }

    .btn-primary:hover {
      opacity: 0.9;
    }

    /* Alert Message */
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

    /* Filter & Search Bar */
    .filter-card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 14px;
      padding: 16px;
      margin-bottom: 20px;
      box-shadow: var(--shadow);
    }

    .filter-grid {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
    }

    .search-box {
      flex: 1;
      min-width: 250px;
      position: relative;
    }

    .search-box input {
      width: 100%;
      background: var(--bg);
      border: 1px solid var(--line);
      color: var(--ink);
      padding: 10px 12px 10px 36px;
      border-radius: 10px;
      font-size: 13px;
      outline: none;
      transition: border-color 0.2s ease;
    }

    .search-box input:focus {
      border-color: var(--green);
    }

    .search-box i {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--muted);
    }

    .filter-dropdown select {
      background: var(--bg);
      border: 1px solid var(--line);
      color: var(--ink);
      padding: 10px 14px;
      border-radius: 10px;
      font-size: 13px;
      outline: none;
      cursor: pointer;
      transition: border-color 0.2s ease;
    }

    .filter-dropdown select:focus {
      border-color: var(--green);
    }

    /* Table Card */
    .card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 16px;
      padding: 20px;
      box-shadow: var(--shadow);
    }

    /* ==========================================================
       KODE RESPONSIF: TABEL AGAR BISA DI-SCROLL DI HP
       ========================================================== */
    .table-responsive {
      width: 100%;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
      font-size: 13px;
      min-width: 650px; /* Mencegah kolom tabel tertekan terlalu kecil di layar HP */
    }

    th {
      color: var(--muted);
      font-size: 11px;
      text-transform: uppercase;
      padding: 10px 12px;
      border-bottom: 1px solid var(--line);
      white-space: nowrap;
    }

    td {
      padding: 14px 12px;
      border-bottom: 1px solid var(--line);
      color: var(--ink);
      vertical-align: middle;
    }

    tr:last-child td {
      border-bottom: none;
    }

    .badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 4px 10px;
      border-radius: 99px;
      font-size: 11px;
      font-weight: 700;
      border: none;
      cursor: pointer;
      white-space: nowrap;
    }

    .badge.active {
      background: var(--green-soft);
      color: var(--green);
    }

    .badge.paused {
      background: var(--blue-soft);
      color: var(--blue);
    }

    .badge-status {
      display: inline-block;
      padding: 3px 8px;
      border-radius: 6px;
      font-size: 11px;
      font-weight: 600;
      white-space: nowrap;
    }

    .badge-status.online {
      background: var(--green-soft);
      color: var(--green);
    }

    .badge-status.warning {
      background: var(--amber-soft);
      color: var(--amber);
    }

    .badge-status.down {
      background: var(--red-soft);
      color: var(--red);
    }

    .badge-status.ssl_warning {
      background: var(--blue-soft);
      color: var(--blue);
    }

    .badge-status.none {
      background: rgba(255, 255, 255, 0.05);
      color: var(--muted);
    }

    .action-btns {
      display: flex;
      gap: 6px;
      align-items: center;
      justify-content: center;
    }

    .btn-icon {
      background: var(--line);
      border: none;
      color: var(--ink);
      padding: 6px 10px;
      border-radius: 8px;
      font-size: 11px;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      white-space: nowrap;
    }

    .btn-icon:hover {
      background: var(--card-hover);
      color: #fff;
    }

    .btn-icon.danger {
      color: var(--red);
      background: var(--red-soft);
    }

    code {
      font-family: monospace;
      color: var(--green);
      background: rgba(15, 159, 110, 0.1);
      padding: 2px 6px;
      border-radius: 4px;
    }

    /* Pagination Controls */
    .pagination-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 16px;
      margin-top: 12px;
      border-top: 1px solid var(--line);
      flex-wrap: wrap;
      gap: 12px;
    }

    .pagination-info {
      font-size: 12px;
      color: var(--muted);
    }

    .pagination-buttons {
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .btn-page {
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid var(--line);
      color: var(--ink);
      padding: 6px 12px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      transition: all 0.2s ease;
    }

    .btn-page:hover:not(:disabled) {
      background: var(--card-hover);
      color: #fff;
      border-color: var(--muted);
    }

    .btn-page:disabled {
      opacity: 0.4;
      cursor: not-allowed;
    }

    .page-numbers {
      display: flex;
      gap: 4px;
    }

    .page-num {
      min-width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
      border: 1px solid var(--line);
      background: transparent;
      color: var(--ink);
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .page-num:hover {
      background: var(--card-hover);
      color: #fff;
    }

    .page-num.active {
      background: var(--green);
      color: #fff;
      border-color: var(--green);
    }

    .page-dots {
      color: var(--muted);
      font-size: 12px;
      padding: 0 4px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    /* ==========================================================
       KODE RESPONSIF: KHUSUS LAYAR HP & TABLET (Max-width: 768px)
       ========================================================== */
    @media (max-width: 768px) {
      main {
        margin-left: 0 !important;
        width: 100% !important;
        padding: 14px;
        padding-top: 60px; /* Ruang untuk tombol toggle sidebar di layar kecil */
      }

      .page-header {
        flex-direction: column;
        align-items: flex-start;
      }

      .filter-grid {
        flex-direction: column;
      }

      .search-box {
        width: 100%;
      }

      .filter-dropdown select {
        width: 100%;
      }
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
          <h2>Website Management</h2>
          <p>Kelola daftar master website customer yang dipantau oleh sistem.</p>
        </div>
        <a href="{{ route('websites.create') }}" class="btn-primary">
          + Tambah Website Baru
        </a>
      </div>

      <!-- NOTIFIKASI SUKSES -->
      @if(session('success'))
        <div class="alert-success">
          ✓ {{ session('success') }}
        </div>
      @endif

      <!-- CARDS FILTER STATUS & SEARCH -->
      <div class="filter-card">
        <div class="filter-grid">
          <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" id="search-input" placeholder="Cari berdasarkan domain, customer, atau nama website...">
          </div>
          <div class="filter-dropdown">
            <select id="category-filter">
              <option value="all">Semua Kategori</option>
              @foreach($categories as $cat)
                <option value="{{ $cat }}">{{ $cat }}</option>
              @endforeach
            </select>
          </div>
          <div class="filter-dropdown">
            <select id="status-filter">
              <option value="all">Status: Semua</option>
              <option value="active">Active</option>
              <option value="paused">Paused</option>
            </select>
          </div>
        </div>
      </div>

      <!-- TABEL WEBSITE MANAGEMENT -->
      <div class="card">
        <div class="table-responsive">
          <table>
            <thead>
              <tr>
                <th style="width: 22%;">Customer & Website</th>
                <th style="width: 16%;">Domain / URL</th>
                <th style="width: 12%;">Kategori</th>
                <th style="width: 12%;">Interval Check</th>
                <th style="width: 14%;">Status Pemantauan</th>
                <th style="width: 14%;">Status Terakhir</th>
                <th style="width: 10%; text-align: center;">Aksi</th>
              </tr>
            </thead>
            <tbody id="website-table-body">
              @forelse($websites as $site)
                <tr>
                  <td>
                    <b>{{ $site->customer_name }}</b><br>
                    <small style="color:var(--muted)">{{ $site->website_name }}</small>
                  </td>
                  <td>
                    <a href="{{ $site->url }}" target="_blank">
                      <code>{{ $site->domain }}</code>
                    </a>
                  </td>
                  <td>{{ $site->category ?? '-' }}</td>
                  <td>{{ $site->check_interval }} Menit</td>
                  <td>
                    <form action="{{ route('websites.toggle-status', $site) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('PATCH')
                      <button type="submit" class="badge {{ $site->monitoring_status === 'active' ? 'active' : 'paused' }}">
                        {{ $site->monitoring_status === 'active' ? '● Active' : '⏸ Paused' }}
                      </button>
                    </form>
                  </td>
                  <td>
                    @if($site->last_status == 'online')
                      <span class="badge-status online">🟢 Online</span>
                    @elseif($site->last_status == 'warning')
                      <span class="badge-status warning">🟡 Warning</span>
                    @elseif($site->last_status == 'down')
                      <span class="badge-status down">🔴 Down</span>
                    @elseif($site->last_status == 'ssl_warning')
                      <span class="badge-status ssl_warning">🔵 SSL Warning</span>
                    @else
                      <span class="badge-status none">⚪ Belum Dicek</span>
                    @endif
                  </td>
                  <td style="text-align: center;">
                    <div class="action-btns">
                      <a href="{{ route('websites.edit', $site) }}" class="btn-icon">Edit</a>
                      <form action="{{ route('websites.destroy', $site) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus website ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-icon danger">Hapus</button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" style="text-align: center; color: var(--muted); padding: 30px;">
                    Tidak ada data website yang ditemukan.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- UI Pagination Navigator Website Management -->
        <div class="pagination-container">
          <div class="pagination-info" id="pagination-info">
            Menampilkan 0 - 0 dari 0 data
          </div>
          <div class="pagination-buttons">
            <button id="btn-prev" class="btn-page" disabled>
              <i class="bi bi-chevron-left"></i> Prev
            </button>
            <div id="page-numbers" class="page-numbers"></div>
            <button id="btn-next" class="btn-page" disabled>
              Next <i class="bi bi-chevron-right"></i>
            </button>
          </div>
        </div>
      </div>

    </div>
  </main>

  @php
    $websitesForJs = $websites->map(function ($site) {
        return [
            'id' => $site->id,
            'customer_name' => $site->customer_name,
            'website_name' => $site->website_name,
            'domain' => $site->domain,
            'url' => $site->url,
            'category' => $site->category,
            'check_interval' => $site->check_interval,
            'monitoring_status' => $site->monitoring_status,
            'last_status' => $site->last_status,
        ];
    })->values();
  @endphp

  <!-- JAVASCRIPT: SEARCH, FILTER & PAGINATION CLIENT-SIDE -->
  <script>
    const csrfToken = "{{ csrf_token() }}";
    let rawWebsitesData = {!! $websitesForJs->toJson() !!};

    const toggleUrlTemplate = "{{ route('websites.toggle-status', ':id') }}";
    const editUrlTemplate = "{{ route('websites.edit', ':id') }}";
    const destroyUrlTemplate = "{{ route('websites.destroy', ':id') }}";

    let currentPage = 1;
    const perPage = 10;

    function renderTable() {
      const tbody = document.getElementById('website-table-body');
      const searchQuery = document.getElementById('search-input').value.toLowerCase().trim();
      const categoryFilter = document.getElementById('category-filter').value;
      const statusFilter = document.getElementById('status-filter').value;

      if (!tbody) return;

      const filteredWebsites = rawWebsitesData.filter(site => {
        const matchesSearch =
          (site.domain || '').toLowerCase().includes(searchQuery) ||
          (site.customer_name || '').toLowerCase().includes(searchQuery) ||
          (site.website_name || '').toLowerCase().includes(searchQuery);

        const matchesCategory = categoryFilter === 'all' || site.category === categoryFilter;
        const matchesStatus = statusFilter === 'all' || site.monitoring_status === statusFilter;

        return matchesSearch && matchesCategory && matchesStatus;
      });

      const totalItems = filteredWebsites.length;
      const totalPages = Math.ceil(totalItems / perPage) || 1;

      if (currentPage > totalPages) {
        currentPage = totalPages;
      }

      if (totalItems === 0) {
        tbody.innerHTML = `<tr><td colspan="7" style="text-align:center; color:var(--muted); padding:30px;">Tidak ada data website yang ditemukan.</td></tr>`;
        renderPaginationControls(0, 1, 0, 0);
        return;
      }

      const startIndex = (currentPage - 1) * perPage;
      const endIndex = startIndex + perPage;
      const pageItems = filteredWebsites.slice(startIndex, endIndex);

      let html = '';
      pageItems.forEach(site => {
        const editUrl = editUrlTemplate.replace(':id', site.id);
        const toggleUrl = toggleUrlTemplate.replace(':id', site.id);
        const destroyUrl = destroyUrlTemplate.replace(':id', site.id);

        const statusBadgeClass = site.monitoring_status === 'active' ? 'active' : 'paused';
        const statusBadgeText = site.monitoring_status === 'active' ? '● Active' : '⏸ Paused';

        let lastStatusHtml = '<span class="badge-status none">⚪ Belum Dicek</span>';
        if (site.last_status === 'online') {
          lastStatusHtml = '<span class="badge-status online">🟢 Online</span>';
        } else if (site.last_status === 'warning') {
          lastStatusHtml = '<span class="badge-status warning">🟡 Warning</span>';
        } else if (site.last_status === 'down') {
          lastStatusHtml = '<span class="badge-status down">🔴 Down</span>';
        } else if (site.last_status === 'ssl_warning') {
          lastStatusHtml = '<span class="badge-status ssl_warning">🔵 SSL Warning</span>';
        }

        html += `
          <tr>
            <td>
              <b>${site.customer_name}</b><br>
              <small style="color:var(--muted)">${site.website_name}</small>
            </td>
            <td>
              <a href="${site.url}" target="_blank"><code>${site.domain}</code></a>
            </td>
            <td>${site.category || '-'}</td>
            <td>${site.check_interval} Menit</td>
            <td>
              <form action="${toggleUrl}" method="POST" style="display:inline;">
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="_method" value="PATCH">
                <button type="submit" class="badge ${statusBadgeClass}">${statusBadgeText}</button>
              </form>
            </td>
            <td>${lastStatusHtml}</td>
            <td style="text-align: center;">
              <div class="action-btns">
                <a href="${editUrl}" class="btn-icon">Edit</a>
                <form action="${destroyUrl}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus website ini?')">
                  <input type="hidden" name="_token" value="${csrfToken}">
                  <input type="hidden" name="_method" value="DELETE">
                  <button type="submit" class="btn-icon danger">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
        `;
      });

      tbody.innerHTML = html;
      renderPaginationControls(totalItems, totalPages, startIndex + 1, Math.min(endIndex, totalItems));
    }

    function renderPaginationControls(totalItems, totalPages, from = 0, to = 0) {
      const infoEl = document.getElementById('pagination-info');
      const prevBtn = document.getElementById('btn-prev');
      const nextBtn = document.getElementById('btn-next');
      const pageNumbersEl = document.getElementById('page-numbers');

      if (infoEl) {
        infoEl.innerText = totalItems > 0
          ? `Menampilkan ${from} - ${to} dari ${totalItems} data`
          : 'Menampilkan 0 - 0 dari 0 data';
      }

      if (prevBtn) prevBtn.disabled = currentPage <= 1;
      if (nextBtn) nextBtn.disabled = currentPage >= totalPages;

      if (!pageNumbersEl) return;

      let pagesHtml = '';
      const side = 1;
      const start = Math.max(1, currentPage - side);
      const end = Math.min(totalPages, currentPage + side);

      if (start > 1) {
        pagesHtml += `<button class="page-num" onclick="goToPage(1)">1</button>`;
        if (start > 2) {
          pagesHtml += `<span class="page-dots">...</span>`;
        }
      }

      for (let p = start; p <= end; p++) {
        pagesHtml += p === currentPage
          ? `<span class="page-num active">${p}</span>`
          : `<button class="page-num" onclick="goToPage(${p})">${p}</button>`;
      }

      if (end < totalPages) {
        if (end < totalPages - 1) {
          pagesHtml += `<span class="page-dots">...</span>`;
        }
        pagesHtml += `<button class="page-num" onclick="goToPage(${totalPages})">${totalPages}</button>`;
      }

      pageNumbersEl.innerHTML = pagesHtml;
    }

    function goToPage(page) {
      currentPage = page;
      renderTable();
    }

    document.getElementById('btn-prev').addEventListener('click', () => {
      if (currentPage > 1) {
        currentPage--;
        renderTable();
      }
    });

    document.getElementById('btn-next').addEventListener('click', () => {
      currentPage++;
      renderTable();
    });

    document.getElementById('search-input').addEventListener('input', () => {
      currentPage = 1;
      renderTable();
    });

    document.getElementById('category-filter').addEventListener('change', () => {
      currentPage = 1;
      renderTable();
    });

    document.getElementById('status-filter').addEventListener('change', () => {
      currentPage = 1;
      renderTable();
    });

    renderTable();
  </script>

</body>

</html>