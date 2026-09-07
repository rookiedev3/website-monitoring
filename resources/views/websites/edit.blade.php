<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Website - Website Monitoring IT Solution</title>
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

    /* STYLE SIDEBAR */
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

    aside.collapsed {
      width: var(--sidebar-collapsed);
    }

    .brand-area {
      padding: 20px 16px;
      display: flex;
      align-items: center;
      gap: 12px;
      border-bottom: 1px solid #04472d;
      overflow: hidden;
      white-space: nowrap;
    }

    .logo {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      background: #ffffff;
      border: 1px solid #04472d;
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
      color: #8fa394;
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
      color: #8fa394;
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
      color: #d1d5db;
      font-size: 13px;
      font-weight: 600;
      white-space: nowrap;
      cursor: pointer;
    }

    .nav-item:hover,
    .nav-item.active {
      background: #C7AB6B;
      color: #013220;
      font-weight: 700;
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
        KODE RESPONSIF: STYLE MAIN CONTENT & PERGESERAN SIDEBAR
        ========================================================== */
    main { 
      margin-left: var(--sidebar-width); 
      flex: 1; 
      /* Disesuaikan: Atas 85px agar aman dari navbar, Kiri-Kanan 12px agar konsisten melebar */
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

    .alert-error {
      background: var(--red-soft);
      border: 1px solid var(--red);
      color: var(--red);
      padding: 12px 16px;
      border-radius: 10px;
      margin-bottom: 20px;
      font-size: 13px;
      font-weight: 600;
    }

    .card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 18px;
      padding: 20px;
      box-shadow: var(--shadow);
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-size: 10px;
      font-weight: 700;
      color: var(--muted);
      text-transform: uppercase;
      margin-bottom: 8px;
      letter-spacing: 0.5px;
    }

    .form-control { 
      width: 100%; 
      background: #fbfcfe; 
      border: 1px solid var(--line); 
      color: var(--ink); 
      padding: 10px 14px; 
      border-radius: 10px; 
      font-size: 13px; 
      font-weight: 600;
      outline: none; 
      transition: border-color 0.2s ease, box-shadow 0.2s ease; 
    }
    
    .form-control:focus { 
      border-color: var(--green-vibrant); 
      background: #ffffff;
      box-shadow: 0 0 0 3px rgba(0, 107, 63, 0.1);
    }
    
    .form-control::placeholder { 
      color: var(--muted); 
      font-weight: 500;
    }
    
    .form-control.is-invalid { 
      border-color: var(--red); 
    }

    select.form-control {
      cursor: pointer;
    }

    /* MENCEGAH INPUT BERUBAH MENJADI PUTIH SAAT AUTOFILL / DIKETIK */
    input:-webkit-autofill,
    input:-webkit-autofill:hover, 
    input:-webkit-autofill:focus, 
    input:-webkit-autofill:active {
      -webkit-box-shadow: 0 0 0 30px #fbfcfe inset !important;
      -webkit-text-fill-color: var(--ink) !important;
      transition: background-color 5000s ease-in-out 0s;
    }

    .error-text {
      display: block;
      color: var(--red);
      font-size: 11px;
      margin-top: 6px;
      font-weight: 600;
    }

    /* ==========================================================
        KODE RESPONSIF: FORM ROW 2 KOLOM
        ========================================================== */
    .form-row { 
      display: grid; 
      grid-template-columns: repeat(2, minmax(0, 1fr)); 
      gap: 16px; 
    }

    .form-actions { 
      display: flex; 
      justify-content: flex-end; 
      gap: 12px; 
      margin-top: 30px; 
      border-top: 1px solid var(--line); 
      padding-top: 20px; 
      flex-wrap: wrap; 
    }

    .btn-secondary {
      background: #f8fafc;
      border: 1px solid var(--line);
      color: var(--ink);
      padding: 10px 18px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      transition: all 0.2s ease;
    }

    .btn-secondary:hover {
      background: var(--card-hover);
      color: var(--green);
      border-color: var(--muted);
    }

    .btn-primary {
      background: var(--green);
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      box-shadow: 0 4px 12px rgba(1, 50, 32, 0.2);
      transition: opacity 0.2s ease;
    }

    .btn-primary:hover {
      opacity: 0.9;
    }

    /* ==========================================================
        KODE RESPONSIF: KHUSUS LAYAR HP & TABLET (Max-width: 768px)
        ========================================================== */
    @media (max-width: 768px) {
      main { 
        margin-left: 0 !important; 
        width: 100% !important; 
        padding: 85px 16px 16px 16px;
      }
      .form-row { 
        grid-template-columns: 1fr;
      }
      .form-actions {
        flex-direction: column-reverse;
        width: 100%;
      }
      .btn-primary, .btn-secondary {
        width: 100%;
        justify-content: center;
      }
    }
  </style>
</head>

<body>

  <!-- NAVBAR & SIDEBAR -->
  @include('layouts.navigation')

  <!-- MAIN CONTENT -->
  <main>
    <div class="container">

      <!-- PAGE HEADER -->
      <div class="page-header">
        <h2>Edit Website</h2>
        <p>Perbarui informasi atau konfigurasi pemantauan website customer.</p>
      </div>

      <!-- ALERT ERROR -->
      @if ($errors->any())
        <div class="alert-error">
          Terdapat {{ $errors->count() }} kesalahan pada form, silakan periksa kembali isian di bawah.
        </div>
      @endif

      <!-- FORM CARD -->
      <div class="card">
        <form action="{{ route('websites.update', $website->id) }}" method="POST">
          @csrf
          @method('PUT')

          <!-- NAMA CUSTOMER & NAMA WEBSITE -->
          <div class="form-row">
            <div class="form-group">
              <label for="customer_name">Nama Customer / Perusahaan *</label>
              <input type="text" id="customer_name" name="customer_name"
                class="form-control @error('customer_name') is-invalid @enderror" placeholder="Contoh: PT Maju Jaya"
                value="{{ old('customer_name', $website->customer_name) }}" required>
              @error('customer_name')
                <span class="error-text">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group">
              <label for="website_name">Nama Website / Label *</label>
              <input type="text" id="website_name" name="website_name"
                class="form-control @error('website_name') is-invalid @enderror" placeholder="Contoh: Client One Portal"
                value="{{ old('website_name', $website->website_name) }}" required>
              @error('website_name')
                <span class="error-text">{{ $message }}</span>
              @enderror
            </div>
          </div>

          <!-- URL TARGET -->
          <div class="form-group">
            <label for="url">URL Website *</label>
            <input type="url" id="url" name="url" class="form-control @error('url') is-invalid @enderror"
              placeholder="https://client-one.com" value="{{ old('url', $website->url) }}" required>
            @error('url')
              <span class="error-text">{{ $message }}</span>
            @enderror
          </div>

          <!-- KATEGORI & INTERVAL PENGECEKAN -->
          <div class="form-row">
            <div class="form-group">
              <label for="category">Kategori Website</label>
              @php $cat = old('category', $website->category); @endphp
              <select id="category" name="category" class="form-control @error('category') is-invalid @enderror">
                <option value="" {{ empty($cat) ? 'selected' : '' }}>Pilih Kategori (Opsional)...</option>
                <option value="ecommerce" {{ $cat == 'ecommerce' ? 'selected' : '' }}>E-Commerce</option>
                <option value="company" {{ $cat == 'company' ? 'selected' : '' }}>Company Profile</option>
                <option value="portal" {{ $cat == 'portal' ? 'selected' : '' }}>Portal Berita / Blog</option>
                <option value="webapp" {{ $cat == 'webapp' ? 'selected' : '' }}>Web Application</option>
              </select>
              @error('category')
                <span class="error-text">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group">
              <label for="check_interval">Interval Pengecekan (Menit) *</label>
              <input type="number" id="check_interval" name="check_interval"
                class="form-control @error('check_interval') is-invalid @enderror"
                placeholder="5" min="1" max="1440"
                value="{{ old('check_interval', $website->check_interval) }}" required>
              @error('check_interval')
                <span class="error-text">{{ $message }}</span>
              @enderror
            </div>
          </div>

          <!-- TIMEOUT & STATUS MONITORING -->
          <div class="form-row">
            <div class="form-group">
              <label for="timeout_seconds">Timeout Request (Detik) *</label>
              <input type="number" id="timeout_seconds" name="timeout_seconds"
                class="form-control @error('timeout_seconds') is-invalid @enderror"
                placeholder="10" min="1" max="60"
                value="{{ old('timeout_seconds', $website->timeout_seconds) }}" required>
              @error('timeout_seconds')
                <span class="error-text">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group">
              <label for="monitoring_status">Status Monitoring *</label>
              @php $st = old('monitoring_status', $website->monitoring_status); @endphp
              <select id="monitoring_status" name="monitoring_status"
                class="form-control @error('monitoring_status') is-invalid @enderror" required>
                <option value="active" {{ $st == 'active' ? 'selected' : '' }}>Active (Dipantau)</option>
                <option value="paused" {{ $st == 'paused' ? 'selected' : '' }}>Paused (Ditunda)</option>
              </select>
              @error('monitoring_status')
                <span class="error-text">{{ $message }}</span>
              @enderror
            </div>
          </div>

          <!-- NOTES -->
          <div class="form-group">
            <label for="notes">Catatan Tambahan</label>
            <textarea id="notes" name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror"
              placeholder="Contoh: Server Nginx AWS Singapore">{{ old('notes', $website->notes) }}</textarea>
            @error('notes')
              <span class="error-text">{{ $message }}</span>
            @enderror
          </div>

          <!-- ACTIONS -->
          <div class="form-actions">
            <a href="{{ route('websites.index') }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">Perbarui Website</button>
          </div>

        </form>
      </div>

    </div>
  </main>

</body>

</html>