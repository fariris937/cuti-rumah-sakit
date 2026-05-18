<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    public function index()
    {
        //  $divisis = Divisi::all();
        $divisis = Divisi::orderBy('nama_divisi')->get();
        return view('admin.divisi.index', compact('divisis'));
    }

    public function create()
    {
        return view('admin.divisi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:255',
            'kepala_divisi' => 'nullable|string|max:255',
        ]);

        Divisi::create($request->only(['nama_divisi', 'kepala_divisi']));

        return redirect()->route('admin.divisi.index')->with('success', 'Divisi berhasil ditambahkan');
    }

    public function edit(Divisi $divisi)
    {
        return view('admin.divisi.edit', compact('divisi'));
    }

    public function update(Request $request, Divisi $divisi)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:255',
            'kepala_divisi' => 'nullable|string|max:255',
        ]);

        $divisi->update($request->only(['nama_divisi', 'kepala_divisi']));

        return redirect()->route('admin.divisi.index')->with('success', 'Divisi berhasil diperbarui');
    }

    public function destroy(Divisi $divisi)
    {
        $divisi->delete();
        return redirect()->route('admin.divisi.index')->with('success', 'Divisi berhasil dihapus');
    }
}




