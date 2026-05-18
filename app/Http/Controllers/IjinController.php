<?php

namespace App\Http\Controllers;

use App\Models\Ijin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IjinController extends Controller
{
    public function create()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        return view('ijin.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_ijin' => 'required|date',
            'keterangan' => 'required|string',
            'berkas_pendukung' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $ijin = new Ijin();
        $ijin->user_id = Auth::id();
        $ijin->tanggal_ijin = $request->tanggal_ijin;
        $ijin->keterangan = $request->keterangan;
        $ijin->status = 'pending';

        // Handle file upload
        if ($request->hasFile('berkas_pendukung')) {
            $file = $request->file('berkas_pendukung');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('berkas_pendukung', $filename, 'public');
            $ijin->berkas_pendukung = $filename;
        }

        $ijin->save();

        return redirect()->route('user.dashboard')->with('success', 'Pengajuan ijin berhasil dikirim.');
    }
}
