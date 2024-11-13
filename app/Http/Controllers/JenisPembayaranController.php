<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisPembayaran;

class JenisPembayaranController extends Controller
{
    // Menampilkan halaman utama Jenis Pembayaran
    public function index()
    {
        $jenispembayaran = JenisPembayaran::paginate(1);
        return view('jenispembayaran.index', compact('jenispembayaran'));
    }

    // Menyimpan data baru Jenis Pembayaran
    // Controller Method (store)
    public function store(Request $request)
    {
        $request->validate([
            'nama_pembayar' => 'required|string|max:255',
            'jenis_pembayaran' => 'required|in:Cash,Transferbank,Qris', // Validasi jenis pembayaran
        ]);
    
        // Menyimpan data ke database
        JenisPembayaran::create([
            'nama_pembayar' => $request->nama_pembayar,
            'jenis_pembayaran' => $request->jenis_pembayaran,
        ]);
    
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('jenispembayaran.index')->with('success', 'Jenis Pembayaran berhasil ditambahkan.');
    }
    

    // Menampilkan form edit Jenis Pembayaran
    public function edit(Request $request)
    {
        $jenispembayaran = JenisPembayaran::find($request->id);
        if ($jenispembayaran) {
            return response()->json([
                'html' => view('jenispembayaran.edit', compact('jenispembayaran'))->render()
            ]);
        } else {
            return response()->json(['error' => 'Data tidak ditemukan.']);
        }
    }

    // Memperbarui data Jenis Pembayaran
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pembayar' => 'required|string|max:255',
            'jenis_pembayaran' => 'required|string|max:255'
        ]);
    
        $jenispembayaran = JenisPembayaran::find($id);
        if ($jenispembayaran) {
            $jenispembayaran->update([
                'nama_pembayar' => $request->nama_pembayar,
                'jenis_pembayaran' => $request->jenis_pembayaran
            ]);
    
            return redirect()->route('jenispembayaran.index')->with('success', 'Jenis Pembayaran berhasil diperbarui.');
        } else {
            return redirect()->route('jenispembayaran.index')->with('warning', 'Jenis Pembayaran tidak ditemukan.');
        }
    }
    

    // Menghapus data Jenis Pembayaran
    public function destroy($id)
    {
        $jenispembayaran = JenisPembayaran::find($id);
        if ($jenispembayaran) {
            $jenispembayaran->delete();
            return redirect()->route('jenispembayaran.index')->with('success', 'Jenis Pembayaran berhasil dihapus.');
        } else {
            return redirect()->route('jenispembayaran.index')->with('warning', 'Jenis Pembayaran tidak ditemukan.');
        }
    }
}
