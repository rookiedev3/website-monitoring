
<h1>Tambah Pengguna</h1>

<form action="{{ route('users.store') }}" method="POST">
    @csrf
    @include('user._form')
    <button type="submit">Simpan</button>
    <a href="{{ route('users.index') }}">Batal</a>
</form>
