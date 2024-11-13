<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    // Menampilkan daftar kasir
    public function index(Request $request)
    {
        if (auth()->user()->role === 'Admin') {
            $kasir = User::paginate(1); // Ganti get() dengan paginate()
        } else {
            $kasir = User::isNotAdmin()->isNotOwner()->paginate(1); // Ganti get() dengan paginate()
        }
        return view('kasir.index', compact('kasir'));
    }

    // Menyimpan data kasir baru
    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role' => 'required|in:admin,kasir,owner', // Role harus valid
    ]);

    // Membuat kasir baru
    $kasir = User::create([
        'name' => $request->nama,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $request->role,
    ]);

    return redirect()->route('kasir.index')->with('success', 'Kasir berhasil ditambahkan.');
}


public function edit(Request $request)
{
    $kasir = User::where('name', $request->name)->first();  // Mencari kasir berdasarkan nama
    if ($kasir) {
        return response()->json([
            'html' => view('kasir.edit', compact('kasir'))->render() // Kembalikan form edit sebagai HTML
        ]);
    } else {
        return response()->json(['error' => 'Kasir tidak ditemukan'], 404);
    }
}





public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email',
        'role' => 'required|in:admin,kasir,owner',
    ]);

    $kasir = User::findOrFail($id);
    $kasir->update([
        'name' => $request->nama,
        'email' => $request->email,
        'role' => $request->role,
    ]);

    return redirect()->route('kasir.index')->with('success', 'Data Kasir berhasil diperbarui.');
}



    // Hapus data kasir
    public function delete($id)
    {
        $delete = User::find($id);  // Cari berdasarkan ID
        if ($delete) {
            $delete->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
    }
    
}
