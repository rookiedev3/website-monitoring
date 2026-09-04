<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Incidents & Errors - Website Monitoring IT Solution</title>
        <link rel="icon" type="image/png" href="{{ asset('img/logo.jpeg') }}">
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

    /* ==========================================================
       KODE RESPONSIF: MAIN CONTENT & PERGESERAN SIDEBAR
       ========================================================== */
    main {
      margin-left: var(--sidebar-width);
      flex: 1;
      padding: 24px;
      min-width: 0;
      transition: margin-left 0.3s ease, width 0.3s ease;
      width: calc(100% - var(--sidebar-width));
    }

    aside#sidebar.collapsed~main {
      margin-left: var(--sidebar-collapsed);
      width: calc(100% - var(--sidebar-collapsed));
    }

    .container {
      max-width: 1180px;
      margin: 0 auto;
      width: 100%;
    }

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

    /* Filter Bar Responsive */
    .filter-bar {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
      flex-wrap: wrap;
      align-items: center;
    }

    .search-input,
    .filter-select {
      background: var(--card);
      border: 1px solid var(--line);
      color: var(--ink);
      padding: 10px 14px;
      border-radius: 10px;
      font-size: 13px;
      outline: none;
    }

    .search-input {
      flex: 1;
      min-width: 220px;
    }

    .search-input::placeholder {
      color: var(--muted);
    }

    .card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 16px;
      padding: 20px;
      box-shadow: var(--shadow);
    }

    /* ==========================================================
       KODE RESPONSIF: TABEL AGAR BISA DIGESER HORIZONTAL DI HP
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
      min-width: 800px;
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
      text-transform: uppercase;
      white-space: nowrap;
    }

    .badge.open {
      background: var(--red-soft);
      color: var(--red);
    }

    .badge.progress {
      background: var(--amber-soft);
      color: var(--amber);
    }

    .badge.solved {
      background: var(--green-soft);
      color: var(--green);
    }

    .btn-action {
      background: var(--line);
      border: none;
      color: #fff;
      padding: 6px 12px;
      border-radius: 8px;
      font-size: 11px;
      font-weight: 600;
      cursor: pointer;
      text-align: center;
      display: inline-block;
      white-space: nowrap;
    }

    .btn-action:hover {
      background: var(--card-hover);
    }

    .assign-btn {
      background: var(--bg);
      border: 1px solid var(--line);
      color: var(--ink);
      padding: 6px 12px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      white-space: nowrap;
    }

    .assign-btn:hover {
      border-color: var(--green);
      color: #fff;
      background: var(--card-hover);
    }

    /* Modal */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(4px);
      display: none;
      place-items: center;
      z-index: 1000;
      padding: 16px;
    }

    .modal-overlay.active {
      display: grid;
    }

    .modal-card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 16px;
      padding: 24px;
      width: 100%;
      max-width: 420px;
      box-shadow: var(--shadow);
    }

    .modal-header {
      font-size: 16px;
      font-weight: 700;
      color: #fff;
      margin-bottom: 16px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .modal-close {
      background: transparent;
      border: none;
      color: var(--muted);
      font-size: 18px;
      cursor: pointer;
    }

    .modal-close:hover {
      color: #fff;
    }

    .modal-body {
      margin-bottom: 20px;
    }

    .modal-footer {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      flex-wrap: wrap;
    }

    /* ==========================================================
       PAGINATION (disamakan dengan Dashboard)
       ========================================================== */
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
      text-decoration: none;
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
        padding-top: 60px;
        /* Ruang untuk tombol navigasi toggle sidebar */
      }

      .filter-bar {
        flex-direction: column;
        align-items: stretch;
      }

      .search-input,
      .filter-select,
      .filter-bar button {
        width: 100%;
      }

      .pagination-container {
        flex-direction: column;
        align-items: stretch;
      }

      .pagination-buttons {
        justify-content: center;
      }
    }

    .main-content,
    main {
      margin-top: var(--navbar-height, 60px);
    }
  </style>
</head>

<body>

  @include('layouts.navigation')


  <main>
    <div class="container">

      <div class="page-header">
        <div>
          <h2>Incidents & Errors</h2>
          <p>Daftar seluruh gangguan website yang memerlukan penanganan.</p>
        </div>
      </div>

      @if(session('success'))
        <p style="color: var(--green); margin-bottom: 12px; font-size: 13px;">{{ session('success') }}</p>
      @endif
      @if(session('error'))
        <p style="color: var(--red); margin-bottom: 12px; font-size: 13px;">{{ session('error') }}</p>
      @endif

      {{-- Filter bar: realtime AJAX (client-side), tidak lagi submit/reload halaman --}}
      <div class="filter-bar">
        <input type="text" id="search-input" class="search-input"
          placeholder="Cari website, domain, atau jenis error...">
        <select id="status-filter" class="filter-select">
          <option value="">Status: Semua</option>
          <option value="open">Open</option>
          <option value="on_progress">On Progress</option>
          <option value="solved">Solved</option>
        </select>
        <select id="pic-filter" class="filter-select">
          <option value="">PIC: Semua</option>
          @foreach($picOptions as $pic)
            <option value="{{ $pic->id }}">{{ $pic->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="card">
        <div class="table-responsive">
          <table>
            <thead>
              <tr>
                <th>Website & Customer</th>
                <th>Jenis Error</th>
                <th>Mulai Error</th>
                <th>Selesai / Resolve</th>
                <th>Durasi</th>
                <th>PIC</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody id="incident-table-body">
              <tr>
                <td colspan="8" style="text-align:center; color: var(--muted); padding: 30px;">Memuat data...</td>
              </tr>
            </tbody>
          </table>
        </div>

        {{-- ===== Pagination client-side, gaya sama dengan Dashboard ===== --}}
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

  @if(Auth::user()->role === 'super_admin')
    <div class="modal-overlay" id="assignModal">
      <div class="modal-card">
        <div class="modal-header">
          <span>Tugaskan PIC Incident</span>
          <button class="modal-close" onclick="closeAssignModal()">&times;</button>
        </div>
        <form id="assignForm" action="#" method="POST">
          @csrf
          @method('PATCH')
          <div class="modal-body">
            <p style="font-size: 12px; color: var(--muted); margin-bottom: 12px;">
              Pilih PIC untuk menangani gangguan pada <b id="modalWebsiteName" style="color: #fff;">-</b>:
            </p>
            <div class="form-group">
              <select name="assigned_to" id="modalPicSelect" class="filter-select" style="width: 100%; padding: 12px;"
                required>
                <option value="" disabled>Pilih Nama PIC...</option>
                @foreach($picOptions as $pic)
                  <option value="{{ $pic->id }}">{{ $pic->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn-action" style="background: transparent; border: 1px solid var(--line);"
              onclick="closeAssignModal()">Batal</button>
            <button type="submit" class="btn-action" style="background: var(--green);">Simpan Penugasan</button>
          </div>
        </form>
      </div>
    </div>
  @endif

  <!-- JAVASCRIPT: REAL-TIME AJAX SEARCH, FILTER & PAGINATION -->
  <script>
    const userRole = "{{ Auth::user()->role }}";

    let rawIncidentsData = [];
    let currentPage = 1;
    const perPage = 10; // samakan dengan paginate(10) versi server sebelumnya

    function fetchRealtimeData() {
      fetch("{{ route('api.incidents.status') }}")
        .then(response => response.json())
        .then(data => {
          if (data && data.incidents) {
            rawIncidentsData = data.incidents;
            renderTable();
          }
        })
        .catch(error => console.error('Error fetching incidents data:', error));
    }

    function escapeHtml(str) {
      if (!str) return '';
      return str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
    }

    // Format ke gaya "d M, H:i" WIB, sama seperti versi Blade sebelumnya
    function formatStartedAt(isoString) {
      if (!isoString) return '-';
      const date = new Date(isoString);
      const formatter = new Intl.DateTimeFormat('id-ID', {
        day: '2-digit',
        month: 'short',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false,
        timeZone: 'Asia/Jakarta',
      });
      return formatter.format(date) + ' WIB';
    }

    function badgeLabel(status) {
      return status.replace('_', ' ').replace(/\b\w/g, c => c.toUpperCase());
    }

    function renderTable() {
      const tbody = document.getElementById('incident-table-body');
      const searchQuery = document.getElementById('search-input').value.toLowerCase().trim();
      const statusFilter = document.getElementById('status-filter').value;
      const picFilter = document.getElementById('pic-filter').value;

      if (!tbody) return;

      const filteredIncidents = rawIncidentsData.filter(incident => {
        const matchesSearch = !searchQuery ||
          incident.website_name.toLowerCase().includes(searchQuery) ||
          (incident.domain || '').toLowerCase().includes(searchQuery) ||
          incident.incident_type.toLowerCase().includes(searchQuery);

        const matchesStatus = !statusFilter || incident.status === statusFilter;
        const matchesPic = !picFilter || String(incident.assigned_to) === String(picFilter);

        return matchesSearch && matchesStatus && matchesPic;
      });

      const totalItems = filteredIncidents.length;
      const totalPages = Math.ceil(totalItems / perPage) || 1;

      if (currentPage > totalPages) {
        currentPage = totalPages;
      }

      if (totalItems === 0) {
        tbody.innerHTML = `<tr><td colspan="8" style="text-align:center; color: var(--muted); padding: 30px;">Tidak ada incident yang sesuai pencarian/filter.</td></tr>`;
        renderPaginationControls(0, 1);
        return;
      }

      const startIndex = (currentPage - 1) * perPage;
      const endIndex = startIndex + perPage;
      const paginatedItems = filteredIncidents.slice(startIndex, endIndex);

      let html = '';

      paginatedItems.forEach(incident => {
        // Kolom PIC — tombol assign/ganti PIC HANYA muncul kalau incident
        // belum solved. Incident yang sudah solved statusnya final, jadi
        // PIC tidak bisa diubah lagi dari sini.
        let picHtml = '';
        if (incident.assigned_user_name) {
          picHtml = `${escapeHtml(incident.assigned_user_name)}`;
          if (userRole === 'super_admin' && incident.status !== 'solved') {
            picHtml += `<br><button class="assign-btn" style="margin-top:4px; padding:3px 8px; font-size:10px;"
              data-action="assign" data-id="${incident.id}"
              data-name="${escapeHtml(incident.website_name)}" data-pic="${incident.assigned_to ?? ''}">
              Ganti PIC
            </button>`;
          }
        } else if (incident.status === 'solved') {
          picHtml = `<span style="color: var(--green);">Auto-resolved</span>`;
        } else {
          if (userRole === 'super_admin') {
            picHtml = `<button class="assign-btn"
              data-action="assign" data-id="${incident.id}"
              data-name="${escapeHtml(incident.website_name)}" data-pic="">
              + Tugaskan PIC
            </button>`;
          } else {
            picHtml = `<span style="color: var(--muted);">Belum ditugaskan</span>`;
          }
        }

        // Kolom Selesai/Resolve: pakai resolved_at kalau sudah ada, kalau
        // masih berjalan (belum solved) tampilkan "-" biar jelas belum pulih.
        const resolvedHtml = incident.resolved_at
          ? formatStartedAt(incident.resolved_at)
          : '<span style="color: var(--muted);">-</span>';

        // Kolom Durasi: pakai string dari accessor formatted_duration (server),
        // dikasih label "(berjalan)" kalau incident belum solved.
        const durationHtml = incident.is_running
          ? `${escapeHtml(incident.duration)} <span style="color: var(--amber); font-size:11px;">(berjalan)</span>`
          : escapeHtml(incident.duration);

        html += `
        <tr>
          <td>
            <b>${escapeHtml(incident.website_name)}</b><br>
            <small style="color:var(--muted)">${escapeHtml(incident.customer_name)}</small>
          </td>
          <td><span style="color:var(--red)">${escapeHtml(incident.type_label)}</span></td>
          <td>${formatStartedAt(incident.started_at)}</td>
          <td>${resolvedHtml}</td>
          <td>${durationHtml}</td>
          <td>${picHtml}</td>
          <td><span class="badge ${incident.badge_class}">${badgeLabel(incident.status)}</span></td>
          <td>
            <a href="${incident.show_url}" class="btn-action">Detail & Update</a>
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
        if (start > 2) pagesHtml += `<span class="page-dots">...</span>`;
      }

      for (let p = start; p <= end; p++) {
        if (p === currentPage) {
          pagesHtml += `<span class="page-num active">${p}</span>`;
        } else {
          pagesHtml += `<button class="page-num" onclick="goToPage(${p})">${p}</button>`;
        }
      }

      if (end < totalPages) {
        if (end < totalPages - 1) pagesHtml += `<span class="page-dots">...</span>`;
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

    document.getElementById('status-filter').addEventListener('change', () => {
      currentPage = 1;
      renderTable();
    });

    document.getElementById('pic-filter').addEventListener('change', () => {
      currentPage = 1;
      renderTable();
    });

    fetchRealtimeData();
    setInterval(fetchRealtimeData, 5000);

    @if(Auth::user()->role === 'super_admin')
      // Delegated click handler buat tombol "Tugaskan PIC" / "Ganti PIC"
      // yang di-generate lewat JS (karena barisnya dibuat dinamis, bukan Blade lagi)
      document.getElementById('incident-table-body').addEventListener('click', (e) => {
        const btn = e.target.closest('[data-action="assign"]');
        if (!btn) return;
        const picId = btn.dataset.pic ? Number(btn.dataset.pic) : null;
        openAssignModal(btn.dataset.id, btn.dataset.name, picId);
      });

      const assignModal = document.getElementById('assignModal');
      const modalWebsiteName = document.getElementById('modalWebsiteName');
      const assignForm = document.getElementById('assignForm');
      const modalPicSelect = document.getElementById('modalPicSelect');

      function openAssignModal(incidentId, websiteName, currentPicId) {
        modalWebsiteName.textContent = websiteName;
        assignForm.action = `/incidents/${incidentId}`;
        modalPicSelect.value = currentPicId ?? '';
        assignModal.classList.add('active');
      }

      function closeAssignModal() {
        assignModal.classList.remove('active');
      }

      window.addEventListener('click', (e) => {
        if (e.target === assignModal) closeAssignModal();
      });
    @endif
  </script>

</body>

</html>