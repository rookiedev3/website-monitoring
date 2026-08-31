<div class="card">
  <form action="#" method="POST">
    @csrf

    <!-- NAMA LENGKAP -->
    <div class="form-group">
      <label for="name">Nama Lengkap *</label>
      <input
        type="text"
        id="name"
        name="name"
        class="form-control @error('name') is-invalid @enderror"
        placeholder="Contoh: Budi Santoso"
        value="{{ old('name', $user->name ?? '') }}"
        required>
      @error('name')
        <span class="error-text">{{ $message }}</span>
      @enderror
    </div>

    <!-- EMAIL AKSES -->
    <div class="form-group">
      <label for="email">Alamat Email *</label>
      <input
        type="email"
        id="email"
        name="email"
        class="form-control @error('email') is-invalid @enderror"
        placeholder="Contoh: budi@itsolution.id"
        value="{{ old('email', $user->email ?? '') }}"
        required>
      @error('email')
        <span class="error-text">{{ $message }}</span>
      @enderror
    </div>

    <!-- PASSWORD & KONFIRMASI (BERPASANGAN AGAR RESPONSIF) -->
    <div class="form-row">
      <div class="form-group">
        <label for="password">Password {{ isset($user) ? '(Opsional)' : '*' }}</label>
        <input
          type="password"
          id="password"
          name="password"
          class="form-control @error('password') is-invalid @enderror"
          placeholder="{{ isset($user) ? 'Kosongkan jika tidak diubah' : 'Minimal 8 karakter' }}"
          {{ isset($user) ? '' : 'required' }}>
        @error('password')
          <span class="error-text">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="password_confirmation">Konfirmasi Password {{ isset($user) ? '' : '*' }}</label>
        <input
          type="password"
          id="password_confirmation"
          name="password_confirmation"
          class="form-control"
          placeholder="Ulangi password di atas"
          {{ isset($user) ? '' : 'required' }}>
      </div>
    </div>

    <!-- ROLE & STATUS AKUN (BERPASANGAN AGAR RESPONSIF) -->
    <div class="form-row">
      <div class="form-group">
        <label for="role">Role / Hak Akses *</label>
        <select
          id="role"
          name="role"
          class="form-control @error('role') is-invalid @enderror"
          required>
          <option value="" disabled {{ old('role', $user->role ?? '') ? '' : 'selected' }}>Pilih Role User...</option>
          @foreach(['super_admin' => 'Super Admin', 'programmer' => 'Programmer', 'viewer' => 'Viewer'] as $value => $label)
            <option value="{{ $value }}" {{ old('role', $user->role ?? '') === $value ? 'selected' : '' }}>
              {{ $label }}
            </option>
          @endforeach
        </select>
        @error('role')
          <span class="error-text">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="is_active">Status Akun *</label>
        <select
          id="is_active"
          name="is_active"
          class="form-control @error('is_active') is-invalid @enderror"
          required>
          <option value="1" {{ old('is_active', $user->is_active ?? true) == '1' ? 'selected' : '' }}>Aktif</option>
          <option value="0" {{ old('is_active', $user->is_active ?? true) == '0' ? 'selected' : '' }}>Nonaktif</option>
        </select>
        @error('is_active')
          <span class="error-text">{{ $message }}</span>
        @enderror
      </div>
    </div>

    <!-- TOMBOL AKSI -->
    <div class="form-actions">
      <a href="{{ route('users.index') }}" class="btn-secondary">Batal</a>
      <button type="submit" class="btn-primary">Simpan Perubahan</button>
    </div>

  </form>
</div>