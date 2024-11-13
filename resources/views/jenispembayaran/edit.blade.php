<form action="{{ route('jenispembayaran.update', $jenispembayaran->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="nama_pembayar" class="form-label">Nama Pembayar</label>
        <input type="text" name="nama_pembayar" id="nama_pembayar" value="{{ $jenispembayaran->nama_pembayar }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
        <select name="jenis_pembayaran" id="jenis_pembayaran" class="form-control">
            <option value="Cash" {{ $jenispembayaran->jenis_pembayaran == 'Cash' ? 'selected' : '' }}>Cash</option>
            <option value="Transferbank" {{ $jenispembayaran->jenis_pembayaran == 'Transferbank' ? 'selected' : '' }}>Transferbank</option>
            <option value="Qris" {{ $jenispembayaran->jenis_pembayaran == 'Qris' ? 'selected' : '' }}>Qris</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary w-100">Update</button>
</form>
