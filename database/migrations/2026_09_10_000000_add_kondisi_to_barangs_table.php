<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom kondisi aset (baik / perlu_perbaikan / rusak)
     * ke tabel barangs, supaya dashboard "Kondisi aset" punya data asli
     * untuk dihitung, bukan angka statis.
     */
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->enum('kondisi', ['baik', 'perlu_perbaikan', 'rusak'])
                ->default('baik')
                ->after('harga');
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn('kondisi');
        });
    }
};
