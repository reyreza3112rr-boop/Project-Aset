<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stoks';
    protected $primaryKey = 'id_stok';

    protected $fillable = [
        'id_barang',
        'jumlah',
        'keterangan',
    ];

    /**
     * Relasi ke Model Barang
     * Menghubungkan data Stok dengan Barang terkait
     */
    public function barang()
    {
        // Sesuaikan parameter 'id_barang' dengan nama primary key pada tabel barangs teman Anda
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
