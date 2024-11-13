<form action="{{ route('databarang.update', $databarang->id) }}" method="POST">
    @csrf
    @method('PUT') <!-- Gunakan PUT untuk update data -->
    
    <div class="mb-3">
        <label for="nm_barang" class="form-label">Nama Barang</label>
        <input type="text" name="nm_barang" class="form-control" value="{{ old('nm_barang', $databarang->nm_barang) }}">
    </div>
    <div class="mb-3">
        <label for="harga_jual" class="form-label">Harga Jual</label>
        <input type="text" name="harga_jual" class="form-control" value="{{ old('harga_jual', $databarang->harga_jual) }}">
    </div>
    <div class="mb-3">
        <label for="kd_barang" class="form-label">Kode Barang</label>
        <input type="text" name="kd_barang" class="form-control" value="{{ old('kd_barang', $databarang->kd_barang) }}">
    </div>
    
    <button type="submit" class="btn btn-primary">Update</button>
</form>
