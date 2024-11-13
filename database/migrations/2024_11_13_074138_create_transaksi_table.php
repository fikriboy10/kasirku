<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi'); // Kolom primary key id_transaksi
            $table->unsignedBigInteger('kd_barang'); // Relasi dengan data_barang
            $table->unsignedBigInteger('nm_kasir'); // Relasi dengan kolom id dari users (kasir)
            $table->integer('jumlah'); // Jumlah barang yang terjual
            $table->decimal('subtotal', 10, 2); // Subtotal transaksi (jumlah * harga)
            $table->unsignedBigInteger('jenis_pembayaran_id'); // Relasi dengan tabel jenis_pembayaran
            $table->date('tanggal_transaksi'); // Tanggal transaksi
            $table->timestamps(); // Kolom created_at dan updated_at

            // Foreign key constraints
            $table->foreign('kd_barang')->references('id')->on('data_barang')->onDelete('cascade');
            $table->foreign('nm_kasir')->references('id')->on('users')->onDelete('cascade'); // Menggunakan id sebagai foreign key
            $table->foreign('jenis_pembayaran_id')->references('id')->on('jenis_pembayaran')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};
