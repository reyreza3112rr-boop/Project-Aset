<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangans';
    protected $primaryKey = 'id'; // Sesuai HeidiSQL (id)

    protected $fillable = [
        'kode_ruangan',
        'nama_ruangan',
        'kapasitas',
        'keterangan',
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'id_ruangan', 'id');
    }
}