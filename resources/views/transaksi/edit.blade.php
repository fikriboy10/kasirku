<form action="{{ route('transaksi.update', $transaksi->id_transaksi) }}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <label for="kd_barang">Kode Barang</label>
        <select name="kd_barang" id="kd_barang">
            @foreach ($barang as $item)
                <option value="{{ $item->id }}" {{ $item->id == $transaksi->kd_barang ? 'selected' : '' }}>
                    {{ $item->nama_barang }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="nm_kasir">Kasir</label>
        <select name="nm_kasir" id="nm_kasir">
            @foreach ($kasir as $user)
                <option value="{{ $user->id }}" {{ $user->id == $transaksi->nm_kasir ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="jumlah">Jumlah</label>
        <input type="number" name="jumlah" id="jumlah" value="{{ $transaksi->jumlah }}" required>
    </div>

    <div>
        <label for="subtotal">Subtotal</label>
        <input type="number" step="0.01" name="subtotal" id="subtotal" value="{{ $transaksi->subtotal }}" required>
    </div>

    <div>
        <label for="jenis_pembayaran_id">Jenis Pembayaran</label>
        <select name="jenis_pembayaran_id" id="jenis_pembayaran_id">
            @foreach ($jenisPembayaran as $jenis)
                <option value="{{ $jenis->id }}" {{ $jenis->id == $transaksi->jenis_pembayaran_id ? 'selected' : '' }}>
                    {{ $jenis->nama_pembayaran }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="tanggal_transaksi">Tanggal Transaksi</label>
        <input type="date" name="tanggal_transaksi" id="tanggal_transaksi" value="{{ $transaksi->tanggal_transaksi }}" required>
    </div>

    <button type="submit">Update</button>
</form>