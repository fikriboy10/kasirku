<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBarang extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan nama model yang jamak
    protected $table = 'data_barang';

    // Tentukan kolom yang bisa diisi
    protected $fillable = ['nm_barang', 'harga_jual', 'kd_barang'];
}
