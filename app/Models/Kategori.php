<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';
    protected $primaryKey = 'id'; // Sesuai HeidiSQL (id)

    protected $fillable = [
        'kode_kategori',
        'nama_kategori',
        'deskripsi',
        'status',
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'id_kategori', 'id');
    }
}