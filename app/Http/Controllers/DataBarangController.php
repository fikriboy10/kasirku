<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataBarang; // Ganti dengan model DataBarang

class DataBarangController extends Controller
{
    // Menampilkan halaman utama Data Barang
    public function index()
    {
        $databarang = DataBarang::paginate(10); // Menggunakan model DataBarang
        return view('databarang.index', compact('databarang')); // Ganti view ke databarang.index
    }

    // Menyimpan data baru Data Barang
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nm_barang' => 'required|string|max:255',
            'harga_jual' => 'required|numeric',
            'kd_barang' => 'required|string|max:255',
        ]);
    
        // Menyimpan data ke database
        $dataBarang = DataBarang::create([
            'nm_barang' => $request->nm_barang,
            'harga_jual' => $request->harga_jual,
            'kd_barang' => $request->kd_barang,
        ]);
    
        // Cek jika data berhasil disimpan
        if ($dataBarang) {
            return redirect()->route('databarang.index')->with('success', 'Data Barang berhasil ditambahkan.');
        } else {
            return back()->with('error', 'Gagal menambahkan data barang.');
        }
    }
    

    // Menampilkan form edit Data Barang
    public function edit($id)
{
    // Mendapatkan data barang berdasarkan ID
    $databarang = DataBarang::findOrFail($id);

    // Mengembalikan HTML form untuk edit
    return response()->json([
        'html' => view('databarang.edit', compact('databarang'))->render()
    ]);
}


public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'nm_barang' => 'required|string|max:255',
        'harga_jual' => 'required|numeric',
        'kd_barang' => 'required|string|max:255',
    ]);

    // Update data barang
    $databarang = DataBarang::findOrFail($id);
    $databarang->update([
        'nm_barang' => $request->nm_barang,
        'harga_jual' => $request->harga_jual,
        'kd_barang' => $request->kd_barang,
    ]);

    // Redirect kembali ke halaman utama dengan pesan sukses
    return redirect()->route('databarang.index')->with('success', 'Data Barang berhasil diperbarui.');
}


    // Menghapus data Data Barang
    public function destroy($id)
    {
        $databarang = DataBarang::find($id);
        if ($databarang) {
            $databarang->delete();
            return redirect()->route('databarang.index')->with('success', 'Data Barang berhasil dihapus.');
        } else {
            return redirect()->route('databarang.index')->with('warning', 'Data Barang tidak ditemukan.');
        }
    }
}
