<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPembayaran extends Model
{
    use HasFactory;

    protected $table = 'jenis_pembayaran'; // Set the correct table name here
    
    protected $fillable = ['nama_pembayar', 'jenis_pembayaran']; // Assuming 'jenis' is the only column you're saving
}
