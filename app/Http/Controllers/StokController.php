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
        $request->validate([
            'id_barang'  => 'required',
            'jumlah'     => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Menyimpan data secara eksplisit agar aman dari field _token
        Stok::create([
            'id_barang'  => $request->id_barang,
            'jumlah'     => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('stok.index')->with('success', 'Data stok berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_barang'  => 'required',
            'jumlah'     => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $stok = Stok::where('id_stok', $id)->orWhere('id', $id)->firstOrFail();
        $stok->update([
            'id_barang'  => $request->id_barang,
            'jumlah'     => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('stok.index')->with('success', 'Data stok berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $stok = Stok::where('id_stok', $id)->orWhere('id', $id)->firstOrFail();
        $stok->delete();

        return redirect()->route('stok.index')->with('success', 'Data stok berhasil dihapus!');
    }
}