<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Overtime;
use App\Models\Ijin;
use Illuminate\Http\Request;

class KepalaRuanganController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Hitung jumlah lembur pending dan approved untuk widget
        $pendingOvertimeCount = 0;
        $approvedOvertimeCount = 0;

        // Hitung jumlah ijin pending dan approved untuk widget
        $pendingIjinCount = 0;
        $approvedIjinCount = 0;

        if ($user->role === 'kepala_ruangan') {
            $userUnits = $user->unitAktif->pluck('id')->toArray();

            if (!empty($userUnits)) {
                $pendingOvertimeCount = Overtime::where('status', 'pending')
                    ->whereHas('user', function($query) use ($userUnits) {
                        $query->whereHas('unitAktif', function($q) use ($userUnits) {
                            $q->whereIn('units.id', $userUnits);
                        });
                    })
                    ->count();

                $approvedOvertimeCount = Overtime::where('status', 'approved')
                    ->whereHas('user', function($query) use ($userUnits) {
                        $query->whereHas('unitAktif', function($q) use ($userUnits) {
                            $q->whereIn('units.id', $userUnits);
                        });
                    })
                    ->count();

                // Hitung ijin pending (belum disetujui oleh kepala ruangan)
                $pendingIjinCount = Ijin::whereNull('disetujui_oleh_kepala_ruangan')
                    ->whereHas('user', function($query) use ($userUnits) {
                        $query->whereHas('unitAktif', function($q) use ($userUnits) {
                            $q->whereIn('units.id', $userUnits);
                        });
                    })
                    ->count();

                // Hitung ijin yang sudah disetujui oleh kepala ruangan ini
                $approvedIjinCount = Ijin::where('disetujui_oleh_kepala_ruangan', $user->id)
                    ->whereHas('user', function($query) use ($userUnits) {
                        $query->whereHas('unitAktif', function($q) use ($userUnits) {
                            $q->whereIn('units.id', $userUnits);
                        });
                    })
                    ->count();
            }
        }

        return view('kepala_ruangan.dashboard', compact('pendingOvertimeCount', 'approvedOvertimeCount', 'pendingIjinCount', 'approvedIjinCount'));
    }

    public function ijinIndex()
    {
        $user = Auth::user();
        $userUnits = $user->unitAktif->pluck('id')->toArray();

        $ijin = Ijin::with('user')
            ->whereHas('user', function($query) use ($userUnits) {
                $query->whereHas('unitAktif', function($q) use ($userUnits) {
                    $q->whereIn('units.id', $userUnits);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('kepala_ruangan.ijin.index', compact('ijin'));
    }

    public function ijinCreate()
    {
        $user = Auth::user();
        return view('kepala_ruangan.ijin.create', compact('user'));
    }

    public function ijinApprove(Request $request, $id)
    {
        $ijin = Ijin::findOrFail($id);
        $user = Auth::user();

        // Pastikan kepala ruangan hanya bisa approve ijin dari unitnya
        $userUnits = $user->unitAktif->pluck('id')->toArray();
        if (!in_array($ijin->user->unitAktif->first()->id ?? null, $userUnits)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menyetujui ijin ini.');
        }

        $ijin->update([
            'status' => 'disetujui_kepala_ruangan',
            'disetujui_oleh_kepala_ruangan' => $user->id,
            'tanggal_persetujuan' => now(),
            'catatan_persetujuan' => $request->catatan_persetujuan,
        ]);

        return redirect()->back()->with('success', 'Ijin berhasil disetujui oleh kepala ruangan.');
    }

    public function ijinReject(Request $request, $id)
    {
        $ijin = Ijin::findOrFail($id);
        $user = Auth::user();

        // Pastikan kepala ruangan hanya bisa reject ijin dari unitnya
        $userUnits = $user->unitAktif->pluck('id')->toArray();
        if (!in_array($ijin->user->unitAktif->first()->id ?? null, $userUnits)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menolak ijin ini.');
        }

        $ijin->update([
            'disetujui_oleh_kepala_ruangan' => null,
            'tanggal_persetujuan' => null,
            'catatan_persetujuan' => $request->catatan_persetujuan,
        ]);

        return redirect()->back()->with('success', 'Ijin berhasil ditolak.');
    }
}
