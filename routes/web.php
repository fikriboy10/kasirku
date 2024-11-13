<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\JenisPembayaranController;
use App\Http\Controllers\DataBarangController;
use App\Http\Controllers\TransaksiController;


Route::get('/', function () {
    return view('/dashboard/welcome'); // Ganti 'welcome' dengan nama view yang ingin ditampilkan
});


Route::middleware(['guest'])->group(function () {  
    Route::get('/login', [SesiController::class, 'index'])->name('login');
    Route::post('/login', [SesiController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    //admin
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/admin', [AdminController::class, 'admin'])
    ->middleware('userAkses:admin')
    ->name('admin');

    Route::get('/admin/kasir', [AdminController::class, 'kasir'])->middleware('userAkses:kasir');
    Route::get('/admin/owner', [AdminController::class, 'owner'])->middleware('userAkses:owner');
   
    
    //logout
    Route::get('/logout', [SesiController::class, 'logout']);

    
    
    
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index'); // Menampilkan daftar kasir
    Route::get('/kasir/create', [KasirController::class, 'create'])->name('kasir.create'); // Form untuk menambah kasir
    Route::post('/kasir/store', [KasirController::class, 'store']);    // Menyimpan kasir baru
    Route::post('/kasir/edit', [KasirController::class, 'edit'])->name('kasir.edit');    // Form untuk mengedit kasir
    Route::put('/kasir/update/{id}', [KasirController::class, 'update'])->name('kasir.update'); // Memperbarui kasir
    Route::delete('/kasir/{id}', [KasirController::class, 'delete'])->name('kasir.delete'); // Menghapus kasir


    Route::get('/jenispembayaran', [JenisPembayaranController::class, 'index'])->name('jenispembayaran.index');
    Route::post('/jenispembayaran/store', [JenisPembayaranController::class, 'store'])->name('jenispembayaran.store');
    Route::post('/jenispembayaran/edit', [JenisPembayaranController::class, 'edit'])->name('jenispembayaran.edit');
    Route::put('/jenispembayaran/update/{id}', [JenisPembayaranController::class, 'update'])->name('jenispembayaran.update');    
    Route::delete('/jenispembayaran/delete/{id}', [JenisPembayaranController::class, 'destroy'])->name('jenispembayaran.delete');


    Route::get('/databarang', [DataBarangController::class, 'index'])->name('databarang.index');
    Route::post('/databarang/store', [DataBarangController::class, 'store'])->name('databarang.store');
    Route::post('/databarang/edit/{id}', [DataBarangController::class, 'edit'])->name('databarang.edit');
    Route::put('/databarang/update/{id}', [DataBarangController::class, 'update'])->name('databarang.update');    
    Route::delete('/databarang/delete/{id}', [DataBarangController::class, 'destroy'])->name('databarang.delete');

    Route::resource('transaksi', TransaksiController::class);
    Route::get('transaksi/{transaksi}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::post('/transaksi/store', [DataBarangController::class, 'store'])->name('transaksi.store');

});