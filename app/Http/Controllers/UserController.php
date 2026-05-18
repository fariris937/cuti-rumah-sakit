<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Unit;
use App\Models\Divisi;
use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['unitAktif', 'divisi'])->get();
        $divisi = Divisi::all();
        return view('admin.users.index', compact('users', 'divisi'));
    }

    public function create()
    {
        $units = Unit::all();
        $divisi = Divisi::all();
        return view('admin.users.create', compact('units', 'divisi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jumlah_cuti' => 'required|integer|min:0',
            'divisi_id' => 'required|exists:divisi,id',
            'jabatan' => 'required',
            'jenis_karyawan' => 'required|in:medis,non-medis',
            'role' => 'required|in:admin,kepala_bagian,karyawan,kepala_ruangan,kepala_kepegawaian',
            'email' => 'nullable|email|unique:users',
            'password' => 'nullable|min:6'
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'jumlah_cuti' => $request->jumlah_cuti,
            'divisi_id' => $request->divisi_id,
            'jabatan' => $request->jabatan,
            'jenis_karyawan' => $request->jenis_karyawan,
            'role' => $request->role,
            'sisa_cuti' => 12,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : null
        ]);

        if ($request->unit_id) {
            $user->units()->attach($request->unit_id, ['tanggal_mulai' => now()]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function dashboard()
    {
        $user = Auth::user();

        // Cuti yang pending
        $cutiPending = $user->cutis()->where('status', 'pending')->get();

        // Cuti yang sudah disetujui/ditolak
        $cutiHistory = $user->cutis()->whereIn('status', ['disetujui', 'ditolak'])
            ->with('disetujuiOleh')
            ->orderByDesc('updated_at')
            ->get();

        // Laporan cuti karyawan lain yang sudah disetujui
        $cutiLain = Cuti::where('user_id', '!=', $user->id)
            ->where('status', 'disetujui')
            ->with(['user', 'disetujuiOleh'])
            ->orderByDesc('updated_at')
            ->get();

        // Riwayat mutasi
        $mutasiHistory = $user->units()->orderByDesc('pivot_tanggal_mulai')->get();

        // Ambil sisa cuti user
        $sisaCuti = $user->sisa_cuti;

        return view('user.dashboard', compact('user', 'cutiPending', 'cutiHistory', 'cutiLain', 'mutasiHistory', 'sisaCuti'));
    }

    public function mutasiHistory()
    {
        $user = Auth::user();
        $mutasiHistory = $user->units()->orderByDesc('pivot_tanggal_mulai')->get();

        return view('user.mutasi.history', compact('user', 'mutasiHistory'));
    }

    public function edit(User $user)
    {
        $units = Unit::all();
        $divisi = Divisi::all();
        return view('admin.users.edit', compact('user', 'units', 'divisi'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'required',
            'divisi_id' => 'required|exists:divisi,id',
            'jabatan' => 'required',
            'jenis_karyawan' => 'required|in:medis,non-medis',
            'role' => 'required|in:admin,kepala_bagian,karyawan,kepala_ruangan,kepala_kepegawaian',
            'jumlah_cuti' => 'required|integer|min:0',
            'sisa_cuti' => 'required|integer|min:0',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6'
        ]);

        $user->update([
            'nama' => $request->nama,
            'divisi_id' => $request->divisi_id,
            'jabatan' => $request->jabatan,
            'jenis_karyawan' => $request->jenis_karyawan,
            'role' => $request->role,
            'jumlah_cuti' => $request->jumlah_cuti,
            'sisa_cuti' => $request->sisa_cuti,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password
        ]);

        if ($request->unit_id) {
            $user->units()->sync([$request->unit_id => ['tanggal_mulai' => now()]]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
    }
}
