<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        // Mengambil data barang beserta relasi kategori dan ruangan
        $barang = Barang::with(['kategori', 'ruangan'])->latest('id_barang')->get();
        
        // Ambil data untuk dropdown di modal
        $kategori = Kategori::all();
        $ruangan = Ruangan::all();

        return view('barang.index', compact('barang', 'kategori', 'ruangan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategoris,id',
            'id_ruangan'  => 'required|exists:ruangans,id',
            'harga'       => 'nullable|numeric',
            'kondisi'     => 'required|in:baik,perlu_perbaikan,rusak',
        ]);

        Barang::create($validated);

        return redirect()->route('barang.index')->with('success', 'Data Barang berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategoris,id',
            'id_ruangan'  => 'required|exists:ruangans,id',
            'harga'       => 'nullable|numeric',
            'kondisi'     => 'required|in:baik,perlu_perbaikan,rusak',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($validated);

        return redirect()->route('barang.index')->with('success', 'Data Barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Data Barang berhasil dihapus!');
    }
}