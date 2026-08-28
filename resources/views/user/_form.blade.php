<div>
    <label>Nama</label><br>
    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}">
    @error('name') <div>{{ $message }}</div> @enderror
</div>

<div>
    <label>Email</label><br>
    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}">
    @error('email') <div>{{ $message }}</div> @enderror
</div>

<div>
    <label>Password {{ isset($user) ? '(kosongkan jika tidak diubah)' : '' }}</label><br>
    <input type="password" name="password">
    @error('password') <div>{{ $message }}</div> @enderror
</div>

<div>
    <labe>Konfirmasi Password</labe    l><br>
    <input type="password" name="password_confirmation">
</div>

<div>
    <label>Role</label><br>
    <select name="role">
        @foreach(['super_admin' => 'Super Admin', 'programmer' => 'Programmer', 'viewer' => 'Viewer'] as $value => $label)
            <option value="{{ $value }}" {{ old('role', $user->role ?? '') === $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('role') <div>{{ $message }}</div> @enderror
</div>

<div>
    <label>
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}>
        Aktif
    </label>
</div>