<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::orderBy('nama_unit')->get();
        return view('admin.units.index', compact('units'));
    }

    public function create()
    {
        return view('admin.units.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255',
            'tipe_unit' => 'required|in:medis,non-medis',
        ]);

        Unit::create($request->only(['nama_unit', 'tipe_unit']));

        return redirect()->route('admin.units.index')->with('success', 'Unit berhasil ditambahkan');
    }

    public function edit(Unit $unit)
    {
        return view('admin.units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255',
            'tipe_unit' => 'required|in:medis,non-medis',
        ]);

        $unit->update($request->only(['nama_unit', 'tipe_unit']));

        return redirect()->route('admin.units.index')->with('success', 'Unit berhasil diperbarui');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('admin.units.index')->with('success', 'Unit berhasil dihapus');
    }
}




