<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangans = Ruangan::all();
        return view('ruangan.index', compact('ruangans'));
    }

    public function create()
    {
        return view('ruangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_ruangan' => 'required|unique:ruangans,kode_ruangan',
            'nama_ruangan' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        Ruangan::create($request->all());

        return redirect()->route('ruangan.index')->with('success', 'Data ruangan berhasil ditambahkan.');
    }

    public function edit(Ruangan $ruangan)
    {
        return view('ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $request->validate([
            'kode_ruangan' => 'required|unique:ruangans,kode_ruangan,' . $ruangan->id,
            'nama_ruangan' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $ruangan->update($request->all());

        return redirect()->route('ruangan.index')->with('success', 'Data ruangan berhasil diperbarui.');
    }

    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();

        return redirect()->route('ruangan.index')->with('success', 'Data ruangan berhasil dihapus.');
    }
}