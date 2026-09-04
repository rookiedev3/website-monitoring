{{-- resources/views/errors/419.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="3;url={{ route('login') }}">
  <title>Sesi Berakhir</title>
          <link rel="icon" type="image/png" href="{{ asset('img/logo.jpeg') }}">
  <style>
    body { margin:0; min-height:100vh; display:flex; align-items:center; justify-content:center; background:#0b120f; color:#dce9e1; font-family: Inter, sans-serif; text-align:center; }
    .box { max-width: 380px; padding: 20px; }
    h1 { color:#fff; font-size: 20px; }
    p { color:#82988c; font-size: 13px; }
    a { color:#0f9f6e; font-weight:700; }
  </style>
</head>
<body>
  <div class="box">
    <h1>Sesi Anda Telah Berakhir</h1>
    <p>Anda akan dialihkan ke halaman login dalam 3 detik...</p>
    <p><a href="{{ route('login') }}">Klik di sini</a> jika tidak dialihkan otomatis.</p>
  </div>
</body>
</html>