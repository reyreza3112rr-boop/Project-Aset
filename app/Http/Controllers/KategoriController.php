<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Tampilkan Halaman Utama & Data Kategori
    public function index()
    {
        $kategori = Kategori::latest()->get();
        return view('kategori.index', compact('kategori'));
    }

    // Simpan Data Kategori Baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_kategori' => 'required|string|max:255|unique:kategoris,kode_kategori',
            'nama_kategori' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
            'status'        => 'required|in:Aktif,Tidak Aktif',
        ]);

        Kategori::create($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Update Data Kategori
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kode_kategori' => 'required|string|max:255|unique:kategoris,kode_kategori,'.$id,
            'nama_kategori' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
            'status'        => 'required|in:Aktif,Tidak Aktif',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    // Hapus Data Kategori
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}