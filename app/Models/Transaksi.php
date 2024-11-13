<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi'; // Specify the table if it's not the plural of the model name

    protected $fillable = [
        'kd_barang',
        'nm_kasir',
        'jumlah',
        'subtotal',
        'jenis_pembayaran_id',
        'tanggal_transaksi',
    ];

    // Define relationships
    public function barang()
    {
        return $this->belongsTo(DataBarang::class, 'kd_barang');
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'nm_kasir');
    }

    public function jenisPembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class, 'jenis_pembayaran_id');
    }
}
