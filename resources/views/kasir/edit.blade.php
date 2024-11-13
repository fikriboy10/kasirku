<form action="{{ route('kasir.update', $kasir->id) }}" method="POST">
    @csrf
    @method('PUT') <!-- Menambahkan method spoofing untuk PUT -->

    <div class="mb-3">
        <label for="nama" class="form-label">Nama Kasir</label>
        <input type="text" id="nama" class="form-control" name="nama" value="{{ $kasir->name }}" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email Kasir</label>
        <input type="email" id="email" class="form-control" name="email" value="{{ $kasir->email }}" required>
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Role Kasir</label>
        <select id="role" class="form-control" name="role" required>
            <option value="admin" {{ $kasir->role == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="kasir" {{ $kasir->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
            <option value="owner" {{ $kasir->role == 'owner' ? 'selected' : '' }}>Owner</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
</form>
