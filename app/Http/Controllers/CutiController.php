<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CutiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Jika kepala bagian kepegawaian atau kepala bagian, tampilkan daftar cuti pending untuk approval
        if ($user->role === 'kepala_bagian_kepegawaian' || $user->role === 'kepala_bagian') {
            $cutis = Cuti::where('status', 'pending')
                ->with(['user', 'disetujuiOleh'])
                ->orderByDesc('created_at')
                ->get();
            return view('kepala_bagian.cuti.index', compact('cutis', 'user'));
        }

        // Jika kepala ruangan, tampilkan daftar cuti bawahan di divisi yang sama
        if ($user->role === 'kepala_ruangan') {
            $employees = User::where('divisi_id', $user->divisi_id)
                ->where('id', '!=', $user->id)
                ->where('role', 'karyawan')
                ->with('unitAktif')
                ->get();
            $cutis = Cuti::whereIn('user_id', $employees->pluck('id'))
                ->with(['user', 'disetujuiOleh'])
                ->orderByDesc('created_at')
                ->get();
            return view('kepala_ruangan.cuti.index', compact('cutis', 'user', 'employees'));
        }

        $cutis = $user->cutis()->with('disetujuiOleh')->orderByDesc('created_at')->get();
        return view('user.cuti.index', compact('cutis', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        // Kepala ruangan, kepala bagian kepegawaian, dan kepala bagian: bisa ajukan cuti untuk karyawan di divisi yang sama
        if ($user->role === 'kepala_ruangan') {
            $employees = User::where('divisi_id', $user->divisi_id)
                ->where('id', '!=', $user->id)
                ->where('role', 'karyawan')
                ->with(['unitAktif'])
                ->get();
            // Include the kepala_ruangan user itself as an option for cuti
            return view('kepala_ruangan.cuti.create', compact('user', 'employees'));
        }
        if ($user->role === 'kepala_bagian_kepegawaian' || $user->role === 'kepala_bagian') {
            $employees = User::where('divisi_id', $user->divisi_id)
                ->where('id', '!=', $user->id)
                ->where('role', 'karyawan')
                ->with(['unitAktif'])
                ->get();
            return view('kepala_bagian.cuti.create', compact('user', 'employees'));
        }
        return view('user.cuti.create', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string',
        ];
        // Jika kepala ruangan, wajib pilih karyawan tujuan
        if ($user->role === 'kepala_ruangan') {
            $rules['user_id'] = 'required|exists:users,id';
        }
        // Jika kepala bagian kepegawaian atau kepala bagian, opsional pilih karyawan
        if ($user->role === 'kepala_bagian_kepegawaian' || $user->role === 'kepala_bagian') {
            if ($request->filled('user_id')) {
                $rules['user_id'] = 'exists:users,id';
            }
        }
        $request->validate($rules);

        $tanggalMulai = Carbon::parse($request->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($request->tanggal_selesai);
        $lamaCuti = $tanggalMulai->diffInDays($tanggalSelesai) + 1;

        // Tentukan target karyawan (karyawan sendiri atau bawahan)
        $targetUser = $user;
        if ($request->filled('user_id')) {
            $targetUser = User::findOrFail($request->user_id);
            // Pastikan bawahan: satu divisi dan role karyawan
            if ($targetUser->divisi_id !== $user->divisi_id || $targetUser->role !== 'karyawan') {
                return redirect()->back()->with('error', 'Anda hanya dapat mengajukan cuti untuk karyawan dalam divisi Anda.');
            }
        }

        // Validasi sisa cuti target
        if ($targetUser->sisa_cuti < $lamaCuti) {
            return redirect()->back()->with('error', 'Sisa cuti tidak mencukupi! Sisa: ' . $targetUser->sisa_cuti . ' hari, dibutuhkan: ' . $lamaCuti . ' hari.');
        }

        // Validasi overlap cuti
        $overlapCuti = Cuti::where('user_id', $targetUser->id)
            ->whereIn('status', ['pending', 'disetujui'])
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
            return redirect()->back()->with('error', 'Tanggal cuti bertabrakan dengan cuti yang sudah diajukan atau disetujui!');
        }

        $cutiData = [
            'user_id' => $targetUser->id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan,
            'status' => 'pending'
        ];

        // Jika user adalah kepala bagian kepegawaian atau kepala bagian dan mengajukan untuk diri sendiri, langsung setujui
        if (($user->role === 'kepala_bagian_kepegawaian' || $user->role === 'kepala_bagian') && $targetUser->id === $user->id) {
            $cutiData['status'] = 'disetujui';
            $cutiData['disetujui_oleh_kepala_bagian'] = $user->id;
            $cutiData['disetujui_oleh'] = $user->id;
        }

        Cuti::create($cutiData);

        return redirect()->back()->with('success', 'Pengajuan cuti berhasil ditambahkan');
    }

    public function history()
    {
        $user = Auth::user();
        $cutis = $user->cutis()->with('disetujuiOleh')->orderByDesc('updated_at')->get();
        return view('user.cuti.history', compact('cutis', 'user'));
    }

    public function approveCuti($id)
    {
        $cuti = Cuti::findOrFail($id);
        $user = Auth::user();

        // Validasi status
        if ($cuti->status !== 'pending') {
            return redirect()->back()->with('error', 'Status cuti tidak valid untuk disetujui!');
        }

        // Jika user adalah kepala bagian kepegawaian, langsung approve
        if ($user->role === 'kepala_bagian_kepegawaian') {
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

            DB::transaction(function () use ($cuti, $user, $lamaCuti) {
                $cuti->update([
                    'disetujui_oleh_kepala_bagian' => $user->id,
                ]);

                // Jika karyawan medis, kepala bagian approval sudah cukup
                if ($cuti->user->jenis_karyawan === 'medis') {
                    $cuti->update([
                        'status' => 'disetujui',
                        'disetujui_oleh' => $user->id,
                    ]);
                    $cuti->user->decrement('sisa_cuti', $lamaCuti);
                }
                // Jika non-medis, harus sudah disetujui kepala ruangan
                elseif ($cuti->disetujui_oleh_kepala_ruangan) {
                    $cuti->update([
                        'status' => 'disetujui',
                        'disetujui_oleh' => $user->id,
                    ]);
                    $cuti->user->decrement('sisa_cuti', $lamaCuti);
                }
            });

            return redirect()->back()->with('success', 'Cuti berhasil disetujui oleh Kepala Bagian Kepegawaian!');
        }

    // Jika user adalah kepala ruangan, proses approval seperti sebelumnya
    if ($user->role === 'kepala_ruangan') {
        // Validasi cuti milik divisi kepala ruangan dan karyawan non-medis
        if ($cuti->user->divisi_id !== $user->divisi_id || $cuti->user->jenis_karyawan !== 'non-medis') {
            return redirect()->back()->with('error', 'Anda tidak berhak approve cuti ini!');
        }

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

        DB::transaction(function () use ($cuti, $user, $lamaCuti) {
            // Set approval for kepala ruangan
            $cuti->update([
                'disetujui_oleh_kepala_ruangan' => $user->id
            ]);

            // For non-medis karyawan, kepala ruangan approval is sufficient
            if ($cuti->user->jenis_karyawan === 'non-medis') {
                $cuti->update([
                    'status' => 'disetujui',
                    'disetujui_oleh' => $user->id
                ]);

                // Kurangi sisa cuti
                $cuti->user->decrement('sisa_cuti', $lamaCuti);
            }
            // For medis karyawan, need both approvals
            elseif ($cuti->disetujui_oleh_kepala_bagian) {
                $cuti->update([
                    'status' => 'disetujui',
                    'disetujui_oleh' => $user->id
                ]);

                // Kurangi sisa cuti
                $cuti->user->decrement('sisa_cuti', $lamaCuti);
            }
        });

        return redirect()->back()->with('success', 'Cuti berhasil disetujui!');
    }

    return redirect()->back()->with('error', 'Anda tidak memiliki hak untuk menyetujui cuti ini!');
}

    public function rejectCuti($id)
    {
        $cuti = Cuti::findOrFail($id);
        $user = Auth::user();

        // Validasi status
        if ($cuti->status !== 'pending') {
            return redirect()->back()->with('error', 'Status cuti tidak valid untuk ditolak!');
        }

        // Jika user adalah kepala bagian kepegawaian
        if ($user->role === 'kepala_bagian_kepegawaian') {
            if ($cuti->user->divisi_id !== $user->divisi_id) {
                return redirect()->back()->with('error', 'Anda tidak berhak menolak cuti ini!');
            }

            $cuti->update([
                'status' => 'ditolak',
                'disetujui_oleh_kepala_bagian' => $user->id,
            ]);

            return redirect()->back()->with('success', 'Cuti berhasil ditolak oleh Kepala Bagian Kepegawaian!');
        }

        // Jika user adalah kepala ruangan
        if ($user->role === 'kepala_ruangan') {
            if ($cuti->user->divisi_id !== $user->divisi_id || $cuti->user->jenis_karyawan !== 'non-medis') {
                return redirect()->back()->with('error', 'Anda tidak berhak menolak cuti ini!');
            }

            $cuti->update([
                'status' => 'ditolak',
                'disetujui_oleh' => $user->id,
            ]);

            return redirect()->back()->with('success', 'Cuti berhasil ditolak!');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki hak untuk menolak cuti ini!');
    }
}
