<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan foreign key constraint yang sebelumnya belum ada,
     * supaya integritas relasi (kategori, ruangan, barang) dijaga
     * langsung di level database, bukan cuma di validasi aplikasi.
     */
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->foreign('id_kategori')
                ->references('id')->on('kategoris')
                ->nullOnDelete();

            $table->foreign('id_ruangan')
                ->references('id')->on('ruangans')
                ->nullOnDelete();
        });

        Schema::table('stoks', function (Blueprint $table) {
            $table->foreign('id_barang')
                ->references('id_barang')->on('barangs')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
            $table->dropForeign(['id_ruangan']);
        });

        Schema::table('stoks', function (Blueprint $table) {
            $table->dropForeign(['id_barang']);
        });
    }
};
