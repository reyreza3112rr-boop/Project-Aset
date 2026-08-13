<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stoks', function (Blueprint $table) {
            $table->id('id_stok');
            $table->unsignedBigInteger('id_barang');
            $table->integer('jumlah');
            $table->string('keterangan')->nullable(); // Contoh: 'Stok Awal', 'Pembelian Baru', dll.
            $table->timestamps();

            // Opsional: Foreign Key ke tabel barangs (jika kolom primary key di barangs bernama id_barang)
            // $table->foreign('id_barang')->references('id_barang')->on('barangs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stoks');
    }
};