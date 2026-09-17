<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';
    protected $primaryKey = 'id_barang';

    protected $fillable = [
        'id_kategori',
        'id_ruangan',
        'nama_barang',
        'merek',
        'harga',
        'kondisi',
    ];

    // Relasi ke Kategori (Foreign Key: id_kategori, Primary Key Kategori: id)
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }

    // Relasi ke Ruangan (Foreign Key: id_ruangan, Primary Key Ruangan: id)
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id');
    }

    // Relasi ke Stok
    public function stok()
    {
        return $this->hasMany(Stok::class, 'id_barang', 'id_barang');
    }
}