<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DataBarang;
use App\Models\User;
use App\Models\JenisPembayaran;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::query();

        // Filter by nama_kasir (Kasir)
        if ($request->has('nama_kasir') && $request->nama_kasir != '') {
            $query->where('nm_kasir', 'like', '%' . $request->nama_kasir . '%');
        }

        $transaksi = $query->get();

        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $barang = DataBarang::all();
        $kasir = User::all();  // Assuming kasir are users
        $jenisPembayaran = JenisPembayaran::all();

        return view('transaksi.create', compact('barang', 'kasir', 'jenisPembayaran'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kd_barang' => 'required|exists:data_barang,id',
            'nm_kasir' => 'required|exists:users,id',
            'jumlah' => 'required|integer',
            'subtotal' => 'required|numeric',
            'jenis_pembayaran_id' => 'required|exists:jenis_pembayaran,id',
            'tanggal_transaksi' => 'required|date',
        ]);

        Transaksi::create($validated);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $barang = DataBarang::all();
        $kasir = User::all();  // Assuming kasir are users
        $jenisPembayaran = JenisPembayaran::all();

        return view('transaksi.edit', compact('transaksi', 'barang', 'kasir', 'jenisPembayaran'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kd_barang' => 'required|exists:data_barang,id',
            'nm_kasir' => 'required|exists:users,id',
            'jumlah' => 'required|integer',
            'subtotal' => 'required|numeric',
            'jenis_pembayaran_id' => 'required|exists:jenis_pembayaran,id',
            'tanggal_transaksi' => 'required|date',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update($validated);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
