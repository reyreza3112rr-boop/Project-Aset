<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Barang;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        $stok = Stok::with('barang')->latest()->get();
        $barang = Barang::all(); // Untuk pilihan dropdown barang di Modal Tambah/Edit

        return view('stok.index', compact('stok', 'barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Stok::create($request->all());

        return redirect()->route('stok.index')->with('success', 'Data stok berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_barang' => 'required',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $stok = Stok::findOrFail($id);
        $stok->update($request->all());

        return redirect()->route('stok.index')->with('success', 'Data stok berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $stok = Stok::findOrFail($id);
        $stok->delete();

        return redirect()->route('stok.index')->with('success', 'Data stok berhasil dihapus!');
    }
}