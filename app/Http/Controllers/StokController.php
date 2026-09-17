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
        $barang = Barang::all();

        return view('stok.index', compact('stok', 'barang'));
    }

    public function create()
    {
        return redirect()->route('stok.index');
    }

    public function edit($id)
    {
        return redirect()->route('stok.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_barang'  => 'required|exists:barangs,id_barang',
            'jumlah'     => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Stok::create($validated);

        return redirect()->route('stok.index')->with('success', 'Data stok berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_barang'  => 'required|exists:barangs,id_barang',
            'jumlah'     => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $stok = Stok::findOrFail($id);
        $stok->update($validated);

        return redirect()->route('stok.index')->with('success', 'Data stok berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $stok = Stok::findOrFail($id);
        $stok->delete();

        return redirect()->route('stok.index')->with('success', 'Data stok berhasil dihapus!');
    }
}