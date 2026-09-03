<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Ruangan;
use App\Models\Stok;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total ringkasan
        $totalAset = Barang::count();
        $totalKategori = Kategori::count();
        $totalRuangan = Ruangan::count();
        
        // Menghitung stok yang berjumlah <= 5
        $stokMenipis = Stok::where('jumlah', '<=', 5)->count();

        // 2. Statistik Barang per Kategori (Menyesuaikan id_kategori & id)
        $kategoriStats = Kategori::select('kategoris.nama_kategori')
            ->selectRaw('COUNT(barangs.id_barang) as total')
            ->leftJoin('barangs', 'kategoris.id', '=', 'barangs.id_kategori')
            ->groupBy('kategoris.id', 'kategoris.nama_kategori')
            ->get();

        // 3. Daftar item stok yang menipis
        $listStokMenipis = Stok::with('barang')
            ->where('jumlah', '<=', 5)
            ->take(5)
            ->get();

        // 4. Aktivitas barang terbaru
        $barangTerbaru = Barang::with('kategori')
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalAset',
            'totalKategori',
            'totalRuangan',
            'stokMenipis',
            'kategoriStats',
            'listStokMenipis',
            'barangTerbaru'
        ));
    }
}