{{-- resources/views/errors/403.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Akses Ditolak - Website Monitoring IT Solution</title>
  <style>
    :root {
      --bg: #0b120f;
      --card: #111b16;
      --ink: #dce9e1;
      --muted: #82988c;
      --line: #1b2a22;
      --green: #0f9f6e;
      --red: #d94c4c;
      --red-soft: rgba(217, 76, 76, 0.12);
    }
    * { box-sizing: border-box; }
    body {
      margin: 0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--bg);
      color: var(--ink);
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, sans-serif;
      text-align: center;
      padding: 20px;
    }
    .box {
      max-width: 420px;
    }
    .icon {
      width: 72px; height: 72px;
      margin: 0 auto 24px;
      border-radius: 20px;
      background: var(--red-soft);
      border: 1px solid var(--red);
      display: grid;
      place-items: center;
    }
    .icon svg { width: 32px; height: 32px; stroke: var(--red); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    h1 { font-size: 56px; margin: 0; color: #fff; font-weight: 800; letter-spacing: -.02em; }
    h2 { font-size: 18px; margin: 8px 0 8px; color: #fff; }
    p { color: var(--muted); font-size: 13px; margin: 0 0 28px; line-height: 1.6; }
    .btn {
      display: inline-flex; align-items: center; gap: 8px;
      background: var(--green); color: #fff; border: none;
      padding: 12px 22px; border-radius: 10px; font-size: 13px; font-weight: 700;
      text-decoration: none;
    }
    .btn:hover { opacity: .9; }
  </style>
</head>
<body>
  <div class="box">
    <div class="icon">
      <svg viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v2"/></svg>
    </div>
    <h1>403</h1>
    <h2>Akses Ditolak</h2>
    <p>{{ $exception->getMessage() ?: 'Anda tidak memiliki izin untuk mengakses halaman ini. Hubungi Super Admin jika ini seharusnya bisa diakses.' }}</p>
    <a href="{{ url('/') }}" class="btn">Kembali ke Dashboard</a>
  </div>
</body>
</html>