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
        $request->validate([
            'nama_barang' => 'required',
            'id_kategori' => 'required',
            'id_ruangan'  => 'required',
            'harga'       => 'nullable|numeric',
        ]);

        Barang::create($request->all());

        return redirect()->route('barang.index')->with('success', 'Data Barang berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'id_kategori' => 'required',
            'id_ruangan'  => 'required',
            'harga'       => 'nullable|numeric',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect()->route('barang.index')->with('success', 'Data Barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Data Barang berhasil dihapus!');
    }
}