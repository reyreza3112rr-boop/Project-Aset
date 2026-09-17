<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Ruangan;
use App\Models\Stok;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Batas stok dianggap menipis. Ubah angka ini saja untuk mengubah
    // ambang batas di seluruh dashboard.
    const BATAS_STOK_MENIPIS = 10;

    public function index()
    {
        // 1. Total ringkasan
        $totalAset = Barang::count();
        $totalKategori = Kategori::count();
        $totalRuangan = Ruangan::count();
        
        // Menghitung stok yang jumlahnya <= batas stok menipis
        $stokMenipis = Stok::where('jumlah', '<=', self::BATAS_STOK_MENIPIS)->count();

        // 2. Statistik Barang per Kategori (Menyesuaikan id_kategori & id)
        $kategoriStats = Kategori::select('kategoris.nama_kategori')
            ->selectRaw('COUNT(barangs.id_barang) as total')
            ->leftJoin('barangs', 'kategoris.id', '=', 'barangs.id_kategori')
            ->groupBy('kategoris.id', 'kategoris.nama_kategori')
            ->get();

        // 2b. Statistik Kondisi Aset (baik / perlu perbaikan / rusak)
        $kondisiCounts = Barang::selectRaw('kondisi, COUNT(*) as total')
            ->groupBy('kondisi')
            ->pluck('total', 'kondisi');

        $jumlahBaik = $kondisiCounts->get('baik', 0);
        $jumlahPerluPerbaikan = $kondisiCounts->get('perlu_perbaikan', 0);
        $jumlahRusak = $kondisiCounts->get('rusak', 0);
        $totalKondisi = $jumlahBaik + $jumlahPerluPerbaikan + $jumlahRusak;

        $persenBaik = $totalKondisi > 0 ? round(($jumlahBaik / $totalKondisi) * 100) : 0;
        $persenPerluPerbaikan = $totalKondisi > 0 ? round(($jumlahPerluPerbaikan / $totalKondisi) * 100) : 0;
        $persenRusak = $totalKondisi > 0 ? (100 - $persenBaik - $persenPerluPerbaikan) : 0;

        $kondisiAset = [
            'baik' => $persenBaik,
            'perlu_perbaikan' => $persenPerluPerbaikan,
            'rusak' => $persenRusak,
        ];

        // 3. Daftar item stok yang menipis
        $listStokMenipis = Stok::with('barang')
            ->where('jumlah', '<=', self::BATAS_STOK_MENIPIS)
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
            'kondisiAset',
            'listStokMenipis',
            'barangTerbaru'
        ));
    }
}