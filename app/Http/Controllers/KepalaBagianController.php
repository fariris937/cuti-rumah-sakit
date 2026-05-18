<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Unit;
use App\Models\Cuti;
use App\Models\Divisi;
use App\Models\Ijin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KepalaBagianController extends Controller
{
    /**
     * Dashboard kepala bagian
     */
    public function index()
    {
        $kepalaBagian = Auth::user();

        // ambil karyawan dalam divisi kepala bagian
        $users = User::where('divisi_id', $kepalaBagian->divisi_id)
            ->where('id', '!=', $kepalaBagian->id) // exclude kepala bagian sendiri
            ->with(['units' => function($q) {
                $q->orderByDesc('pivot_tanggal_mulai');
            }])
            ->get();

        // Semua karyawan untuk mutasi (baik medis maupun non-medis)
        if (str_contains($kepalaBagian->role, 'kepegawaian')) {
            // Kepala bagian kepegawaian dapat melihat semua karyawan dari semua divisi
            $usersForMutasi = User::where('id', '!=', $kepalaBagian->id) // exclude kepala bagian sendiri
                ->whereNotNull('nama') // pastikan nama tidak null
                ->orderBy('nama', 'asc') // urutkan berdasarkan nama agar mudah dilihat
                ->with(['units' => function($q) {
                    $q->orderByDesc('pivot_tanggal_mulai');
                }])
                ->get();
        } else {
            // Kepala bagian biasa hanya dapat melihat karyawan dalam divisi mereka
            $usersForMutasi = $users;
        }

        // cuti yang menunggu persetujuan kepala bagian
        $cutiPending = Cuti::whereHas('user', function($q) use ($kepalaBagian) {
            $q->where('divisi_id', $kepalaBagian->divisi_id);
        })->pending()->with('user')->get();

        // cuti yang sudah disetujui/ditolak
        $cutiHistory = Cuti::whereHas('user', function($q) use ($kepalaBagian) {
            $q->where('divisi_id', $kepalaBagian->divisi_id);
        })->whereIn('status', ['disetujui', 'ditolak'])
        ->with(['user', 'disetujuiOleh'])
        ->orderByDesc('updated_at')
        ->limit(10)
        ->get();

        // ambil lembur yang sudah disetujui oleh kepala ruangan untuk divisi kepala bagian
        $overtimeApproved = \App\Models\Overtime::whereHas('user', function($q) use ($kepalaBagian) {
            $q->where('divisi_id', $kepalaBagian->divisi_id);
        })->where('status', 'disetujui')
        ->with('user')
        ->orderByDesc('updated_at')
        ->limit(10)
        ->get();

        $units = Unit::all();
        $divisi = Divisi::find($kepalaBagian->divisi_id);

        return view('kepala_bagian.dashboard', compact('users', 'usersForMutasi', 'cutiPending', 'cutiHistory', 'units', 'divisi', 'overtimeApproved'));
    }

    /**
     * Approve cuti
     */
    public function approveCuti($id)
    {
        $cuti = Cuti::findOrFail($id);
        $kepalaBagian = Auth::user();

        // Validasi status
        if ($cuti->status !== 'pending') {
            return redirect()->back()->with('error', 'Status cuti tidak valid untuk disetujui!');
        }

        // pastikan cuti milik divisi kepala bagian
        if ($cuti->user->divisi_id !== $kepalaBagian->divisi_id) {
            return redirect()->back()->with('error', 'Anda tidak berhak approve cuti ini!');
        }

        // Hitung lama cuti
        $tanggalMulai = Carbon::parse($cuti->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($cuti->tanggal_selesai);
        $lamaCuti = $tanggalMulai->diffInDays($tanggalSelesai) + 1;

        // Validasi sisa cuti
        if ($cuti->user->sisa_cuti < $lamaCuti) {
            return redirect()->back()->with('error', 'Sisa cuti tidak mencukupi! Sisa: ' . $cuti->user->sisa_cuti . ' hari, dibutuhkan: ' . $lamaCuti . ' hari.');
        }

        // Validasi overlap cuti
        $overlapCuti = Cuti::where('user_id', $cuti->user_id)
            ->where('status', 'disetujui')
            ->where(function($q) use ($tanggalMulai, $tanggalSelesai) {
                $q->whereBetween('tanggal_mulai', [$tanggalMulai, $tanggalSelesai])
                  ->orWhereBetween('tanggal_selesai', [$tanggalMulai, $tanggalSelesai])
                  ->orWhere(function($q2) use ($tanggalMulai, $tanggalSelesai) {
                      $q2->where('tanggal_mulai', '<=', $tanggalMulai)
                         ->where('tanggal_selesai', '>=', $tanggalSelesai);
                  });
            })
            ->exists();

        if ($overlapCuti) {
            return redirect()->back()->with('error', 'Tanggal cuti bertabrakan dengan cuti yang sudah disetujui!');
        }

        DB::transaction(function () use ($cuti, $kepalaBagian, $lamaCuti) {
            // Set approval for kepala bagian
            $cuti->update([
                'disetujui_oleh_kepala_bagian' => $kepalaBagian->id
            ]);

            // For medis karyawan, kepala bagian approval is sufficient
            if ($cuti->user->jenis_karyawan === 'medis') {
                $cuti->update([
                    'status' => 'disetujui',
                    'disetujui_oleh' => $kepalaBagian->id
                ]);

                // Kurangi sisa cuti
                $cuti->user->decrement('sisa_cuti', $lamaCuti);
            }
            // For non-medis karyawan, need both approvals
            elseif ($cuti->disetujui_oleh_kepala_ruangan) {
                $cuti->update([
                    'status' => 'disetujui',
                    'disetujui_oleh' => $kepalaBagian->id
                ]);

                // Kurangi sisa cuti
                $cuti->user->decrement('sisa_cuti', $lamaCuti);
            }
        });

        return redirect()->back()->with('success', 'Cuti berhasil disetujui!');
    }

    /**
     * Tolak cuti
     */
    public function rejectCuti($id)
    {
        $cuti = Cuti::findOrFail($id);
        $kepalaBagian = Auth::user();

        // Validasi status
        if ($cuti->status !== 'pending') {
            return redirect()->back()->with('error', 'Status cuti tidak valid untuk ditolak!');
        }

        if ($cuti->user->divisi_id !== $kepalaBagian->divisi_id) {
            return redirect()->back()->with('error', 'Anda tidak berhak menolak cuti ini!');
        }

        $cuti->update([
            'status' => 'ditolak',
            'disetujui_oleh' => $kepalaBagian->id
        ]);

        return redirect()->back()->with('success', 'Cuti berhasil ditolak!');
    }

    /**
     * Mutasi karyawan medis
     */
    public function mutasi(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'unit_id' => 'required|exists:units,id',
        ]);

        $kepalaBagian = Auth::user();
        $user = User::findOrFail($request->user_id);
        $unitBaru = Unit::findOrFail($request->unit_id);

        // Validasi berdasarkan role kepala bagian
        if (str_contains($kepalaBagian->role, 'kepegawaian')) {
            // Kepala bagian kepegawaian bisa mutasi semua karyawan (medis dan non-medis)
            if ($user->divisi_id !== $kepalaBagian->divisi_id) {
                return redirect()->back()->with('error', 'Anda hanya dapat memutasi karyawan dalam divisi Anda!');
            }
            // Unit tujuan bisa medis atau non-medis, tidak dibatasi
        } else {
            // Kepala bagian biasa hanya bisa mutasi karyawan medis
            if ($user->jenis_karyawan !== 'medis' || $user->divisi_id !== $kepalaBagian->divisi_id) {
                return redirect()->back()->with('error', 'Anda hanya dapat memutasi karyawan medis dalam divisi Anda!');
            }
            // Unit tujuan harus medis
            if ($unitBaru->tipe_unit !== 'medis') {
                return redirect()->back()->with('error', 'Unit tujuan bukan unit medis!');
            }
        }

        // Pastikan tidak mutasi ke unit yang sama
        $currentUnit = $user->units()->wherePivotNull('tanggal_selesai')->first();
        if ($currentUnit && $currentUnit->id == $unitBaru->id) {
            return redirect()->back()->with('error', 'Karyawan sudah berada di unit tersebut!');
        }

        DB::transaction(function () use ($user, $unitBaru, $currentUnit) {
            // Tutup unit lama
            if ($currentUnit) {
                $user->units()->updateExistingPivot($currentUnit->id, [
                    'tanggal_selesai' => now()
                ]);
            }

            // Tambahkan unit baru
            $user->units()->attach($unitBaru->id, [
                'tanggal_mulai' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return redirect()->back()->with('success', 'Mutasi karyawan berhasil disimpan!');
    }

    /**
     * Create ijin form for kepala bagian
     */
    public function createIjin()
    {
        $kepalaBagian = Auth::user();
        return view('kepala_bagian.ijin.create', compact('kepalaBagian'));
    }

    /**
     * Store ijin for kepala bagian (auto-approved)
     */
    public function storeIjin(Request $request)
    {
        $request->validate([
            'tanggal_ijin' => 'required|date',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i',
            'jenis_ijin' => 'required|string',
            'keterangan' => 'required|string',
            'berkas_pendukung' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $kepalaBagian = Auth::user();

        $ijin = new Ijin();
        $ijin->user_id = $kepalaBagian->id;
        $ijin->tanggal_ijin = $request->tanggal_ijin;
        $ijin->jam_mulai = $request->jam_mulai;
        $ijin->jam_selesai = $request->jam_selesai;
        $ijin->jenis_ijin = $request->jenis_ijin;
        $ijin->keterangan = $request->keterangan;
        $ijin->status = 'disetujui'; // Auto-approved for kepala bagian
        $ijin->disetujui_oleh_kepala_bagian = $kepalaBagian->id; // Auto-approved by themselves
        $ijin->tanggal_persetujuan = now();

        // Handle file upload
        if ($request->hasFile('berkas_pendukung')) {
            $file = $request->file('berkas_pendukung');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('berkas_pendukung', $filename, 'public');
            $ijin->berkas_pendukung = $filename;
        }

        $ijin->save();

        return redirect()->route('kepala-bagian.dashboard')->with('success', 'Pengajuan ijin berhasil diajukan dan otomatis disetujui.');
    }

    /**
     * Index ijin for kepala bagian approval
     */
    public function ijinIndex()
    {
        $kepalaBagian = Auth::user();

        // Get ijin that have been approved by kepala ruangan and need kepala bagian approval
        $ijinPending = Ijin::whereHas('user', function($q) use ($kepalaBagian) {
            $q->where('divisi_id', $kepalaBagian->divisi_id);
        })
        ->whereNotNull('disetujui_oleh_kepala_ruangan')
        ->whereNull('disetujui_oleh_kepala_bagian')
        ->with(['user', 'disetujuiOlehKepalaRuangan'])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        // Get approved ijin
        $ijinApproved = Ijin::whereHas('user', function($q) use ($kepalaBagian) {
            $q->where('divisi_id', $kepalaBagian->divisi_id);
        })
        ->whereNotNull('disetujui_oleh_kepala_bagian')
        ->with(['user', 'disetujuiOlehKepalaBagian'])
        ->orderBy('updated_at', 'desc')
        ->paginate(10);

        return view('kepala_bagian.ijin.index', compact('ijinPending', 'ijinApproved'));
    }

    /**
     * Approve ijin by kepala bagian
     */
    public function approveIjin($id)
    {
        $ijin = Ijin::findOrFail($id);
        $kepalaBagian = Auth::user();

        // Validasi bahwa ijin sudah disetujui oleh kepala ruangan
        if (is_null($ijin->disetujui_oleh_kepala_ruangan)) {
            return redirect()->back()->with('error', 'Ijin belum disetujui oleh kepala ruangan!');
        }

        // Validasi bahwa ijin belum disetujui oleh kepala bagian
        if (!is_null($ijin->disetujui_oleh_kepala_bagian)) {
            return redirect()->back()->with('error', 'Ijin sudah disetujui!');
        }

        // Validasi bahwa ijin milik divisi kepala bagian
        if ($ijin->user->divisi_id !== $kepalaBagian->divisi_id) {
            return redirect()->back()->with('error', 'Anda tidak berhak menyetujui ijin ini!');
        }

        $ijin->update([
            'status' => 'disetujui',
            'disetujui_oleh_kepala_bagian' => $kepalaBagian->id,
            'tanggal_persetujuan' => now(),
        ]);

        return redirect()->back()->with('success', 'Ijin berhasil disetujui!');
    }

    /**
     * Reject ijin by kepala bagian
     */
    public function rejectIjin($id)
    {
        $ijin = Ijin::findOrFail($id);
        $kepalaBagian = Auth::user();

        // Validasi bahwa ijin sudah disetujui oleh kepala ruangan
        if (is_null($ijin->disetujui_oleh_kepala_ruangan)) {
            return redirect()->back()->with('error', 'Ijin belum disetujui oleh kepala ruangan!');
        }

        // Validasi bahwa ijin belum disetujui oleh kepala bagian
        if (!is_null($ijin->disetujui_oleh_kepala_bagian)) {
            return redirect()->back()->with('error', 'Ijin sudah diproses!');
        }

        // Validasi bahwa ijin milik divisi kepala bagian
        if ($ijin->user->divisi_id !== $kepalaBagian->divisi_id) {
            return redirect()->back()->with('error', 'Anda tidak berhak menolak ijin ini!');
        }

        $ijin->update([
            'status' => 'ditolak',
            'disetujui_oleh_kepala_bagian' => $kepalaBagian->id,
            'tanggal_persetujuan' => now(),
        ]);

        return redirect()->back()->with('success', 'Ijin berhasil ditolak!');
    }
}
