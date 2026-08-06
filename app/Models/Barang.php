<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';
    protected $primaryKey = 'id_barang'; // Karena primary key-nya id_barang

    protected $fillable = [
        'id_kategori',
        'id_ruangan',
        'nama_barang',
        'merek',
        'harga',
    ];
}