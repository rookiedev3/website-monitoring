<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

        public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
        ]);

        $kredensial = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (! Auth::attempt($kredensial, $remember)) {
            return back()->withErrors([
                'email' => 'Email atau password salah',
            ]);
        }

        $user = Auth::user();

        if (! $user->is_active) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'Akun Anda dinonaktifkan. Silakan hubungi admin.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route($this->dashboardRouteFor($user->role));
    }

    private function dashboardRouteFor(string $role): string
    {
        return match ($role) {
        // 'super_admin' => 'super_admin.dashboard',
        // 'programmer'  => 'programmer.dashboard',
        // 'viewer'      => 'viewer.dashboard',
        'super_admin' => 'dashboard.index',
        'programmer'  => 'dashboard.index',
        'viewer'      => 'dashboard.index',
        default       => 'login',
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('message', 'Silahkan login kembali.');
    }
}
