
<h1>Manajemen Pengguna</h1>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif
@if(session('error'))
    <p>{{ session('error') }}</p>
@endif

<a href="{{ route('users.create') }}">+ Tambah Pengguna</a>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $index => $u)
        <tr>
            <td>{{ $users->firstItem() + $index }}</td>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->role }}</td>
            <td>{{ $u->is_active ? 'Aktif' : 'Nonaktif' }}</td>
            <td>
                <a href="{{ route('users.edit', $u->id) }}">Edit</a>
                <form action="{{ route('users.destroy', $u->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus user ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">Belum ada data user.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $users->links() }}
