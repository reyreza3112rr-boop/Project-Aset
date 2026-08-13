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
        $request->validate([
            'kode_kategori' => 'required|unique:kategoris,kode_kategori',
            'nama_kategori' => 'required',
            'status'        => 'required',
        ]);

        Kategori::create($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Update Data Kategori
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_kategori' => 'required|unique:kategoris,kode_kategori,'.$id,
            'nama_kategori' => 'required',
            'status'        => 'required',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->all());

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