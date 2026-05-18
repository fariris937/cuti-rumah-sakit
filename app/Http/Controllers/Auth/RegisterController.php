<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'divisi_id' => ['required', 'exists:divisi,id'],
            'unit_id' => ['required', 'exists:units,id'],
            'jenis_karyawan' => ['required', 'in:medis,non-medis'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'nama' => $request->name,
            'email' => $request->email,
            'divisi_id' => $request->divisi_id,
            'jabatan' => 'Karyawan',
            'jenis_karyawan' => $request->jenis_karyawan,
            'sisa_cuti' => 12,
            'password' => Hash::make($request->password),
            'role' => 'karyawan', // default role
        ]);

        // Attach user to unit with current timestamp as start date
        $user->units()->attach($request->unit_id, [
            'tanggal_mulai' => now(),
        ]);

        Auth::login($user);

        return redirect('/user/dashboard');
    }
}
