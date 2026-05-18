<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user();

            // Redirect based on user role
            if ($user->isAdmin()) {
                return redirect()->intended('/admin/divisi');
            } elseif ($user->isKepalaKepegawaian()) {
                return redirect()->intended('/kepala-kepegawaian/dashboard');
            } elseif ($user->isKepalaBagian()) {
                return redirect()->intended('/kepala-bagian/dashboard');
            } elseif ($user->isKepalaRuangan()) {
                return redirect()->intended('/kepala-ruangan/dashboard');
            } else {
                // Default user dashboard
                return redirect()->intended('/user/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
