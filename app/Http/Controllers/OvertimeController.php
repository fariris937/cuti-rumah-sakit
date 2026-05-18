<?php

namespace App\Http\Controllers;

use App\Models\Overtime;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OvertimeController extends Controller
{
    /**
     * Show the form for creating a new overtime request (for karyawan).
     */
    public function create()
    {
        return view('overtime.create');
    }

    /**
     * Store a newly created overtime request in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'keterangan' => 'nullable|string',
        ]);

        $overtime = new Overtime();
        $overtime->user_id = Auth::id();
        $overtime->tanggal = $request->tanggal;
        $overtime->jam_mulai = $request->jam_mulai;
        $overtime->jam_selesai = $request->jam_selesai;
        $overtime->keterangan = $request->keterangan;
        $overtime->status = 'pending';
        $overtime->save();

        return redirect()->route('user.dashboard')->with('success', 'Form lembur berhasil dikirim dan menunggu persetujuan.');
    }

    /**
     * Display a listing of overtime requests for kepala ruangan to approve.
     */
    public function approvalList()
    {
        $user = Auth::user();

        // Kepala ruangan sees overtime requests from their unit only
        if ($user->role === 'kepala_ruangan') {
            // Get user's active units
            $userUnits = $user->unitAktif->pluck('id')->toArray();

            if (empty($userUnits)) {
                // If user has no active units, show no overtime requests
                $overtimes = collect();
            } else {
                $overtimes = Overtime::where('status', 'pending')
                    ->whereHas('user', function($query) use ($userUnits) {
                        $query->whereHas('unitAktif', function($q) use ($userUnits) {
                            $q->whereIn('units.id', $userUnits);
                        });
                    })
                    ->with('user')
                    ->get();
            }

            return view('overtime.approval', compact('overtimes'));
        }

        abort(403, 'Unauthorized');
    }

    /**
     * Approve an overtime request.
     */
    public function approve($id)
    {
        $user = Auth::user();

        if ($user->role !== 'kepala_ruangan') {
            abort(403, 'Unauthorized');
        }

        $overtime = Overtime::findOrFail($id);
        $overtime->status = 'approved';
        $overtime->approved_by = $user->id;
        $overtime->save();

        return redirect()->route('overtime.approval')->with('success', 'Lembur disetujui.');
    }

    /**
     * Reject an overtime request.
     */
    public function reject($id)
    {
        $user = Auth::user();

        if ($user->role !== 'kepala_ruangan') {
            abort(403, 'Unauthorized');
        }

        $overtime = Overtime::findOrFail($id);
        $overtime->status = 'rejected';
        $overtime->approved_by = $user->id;
        $overtime->save();

        return redirect()->route('overtime.approval')->with('success', 'Lembur ditolak.');
    }

    /**
     * Display overtime reports based on user role.
     */
    public function report()
    {
        $user = Auth::user();

        if ($user->role === 'kepala_kepegawaian') {
            // Kepala kepegawaian sees all overtime reports
            $overtimes = Overtime::with('user')->orderByDesc('tanggal')->paginate(10);
        } elseif ($user->role === 'kepala_bagian') {
            // Kepala bagian sees overtime reports from their division
            $overtimes = Overtime::whereHas('user', function($query) use ($user) {
                $query->where('divisi_id', $user->divisi_id);
            })->with('user')->orderByDesc('tanggal')->paginate(10);
        } elseif ($user->role === 'kepala_ruangan') {
            // Kepala ruangan sees all overtime reports from their unit only
            $userUnits = $user->unitAktif->pluck('id')->toArray();

            if (empty($userUnits)) {
                // If user has no active units, show no overtime reports
                $overtimes = collect();
            } else {
                $overtimes = Overtime::where(function($query) use ($user) {
                    $query->where('approved_by', $user->id)
                          ->orWhere('status', 'pending');
                })
                ->whereHas('user', function($query) use ($userUnits) {
                    $query->whereHas('unitAktif', function($q) use ($userUnits) {
                        $q->whereIn('units.id', $userUnits);
                    });
                })
                ->with('user')
                ->orderByDesc('tanggal')
                ->paginate(10);
            }
        } else {
            // Regular users see only their own overtime reports
            $overtimes = Overtime::where('user_id', $user->id)
                ->with('user')
                ->orderByDesc('tanggal')
                ->paginate(10);
        }

        return view('overtime.report', compact('overtimes'));
    }
}
