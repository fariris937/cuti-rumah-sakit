<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MutasiController extends Controller
{
    public function history()
    {
        $user = Auth::user();

        // Ambil riwayat mutasi user dengan data pivot
        $mutasiHistory = User::find($user->id)->units()
            ->orderByPivot('tanggal_mulai', 'desc')
            ->get();

        return view('user.mutasi.history', compact('mutasiHistory'));
    }
}
