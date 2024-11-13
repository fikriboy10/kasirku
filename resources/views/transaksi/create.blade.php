<form action="{{ route('transaksi.store') }}" method="POST">
    @csrf
    <div>
        <label for="kd_barang">Kode Barang</label>
        <select name="kd_barang" id="kd_barang">
            @foreach ($barang as $item)
                <option value="{{ $item->id }}">{{ $item->nama_barang }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="nm_kasir">Kasir</label>
        <select name="nm_kasir" id="nm_kasir">
            @foreach ($kasir as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="jumlah">Jumlah</label>
        <input type="number" name="jumlah" id="jumlah" required>
    </div>

    <div>
        <label for="subtotal">Subtotal</label>
        <input type="number" step="0.01" name="subtotal" id="subtotal" required>
    </div>

    <div>
        <label for="jenis_pembayaran_id">Jenis Pembayaran</label>
        <select name="jenis_pembayaran_id" id="jenis_pembayaran_id">
            @foreach ($jenisPembayaran as $jenis)
                <option value="{{ $jenis->id }}">{{ $jenis->nama_pembayaran }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="tanggal_transaksi">Tanggal Transaksi</label>
        <input type="date" name="tanggal_transaksi" id="tanggal_transaksi" required>
    </div>

    <button type="submit">Simpan</button>
</form>