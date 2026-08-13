<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'kategoris';

    // Kolom yang diizinkan untuk diisi data
    protected $fillable = [
        'kode_kategori',
        'nama_kategori',
        'deskripsi',
        'status',
    ];
}