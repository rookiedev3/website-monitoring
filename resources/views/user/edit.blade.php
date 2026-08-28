
<h1>Edit Pengguna</h1>

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    @include('user._form')
    <button type="submit">Update</button>
    <a href="{{ route('users.index') }}">Batal</a>
</form>
