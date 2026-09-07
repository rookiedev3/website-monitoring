<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectLogin()
    {
        session(['google_intent' => 'login']);
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }


    public function redirectRegister()
    {
        session(['google_intent' => 'register']);
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $intent = session('google_intent', 'login');
        session()->forget('google_intent');

        $user = User::where('google_id', $googleUser->id)
            ->orWhere('email', $googleUser->email)
            ->first();

        // ==== INTENT: LOGIN ====
        if ($intent === 'login') {
            if (! $user) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Akun Google ini belum terdaftar. Silakan daftar terlebih dahulu.',
                ]);
            }

            if (! $user->google_id) {
                $user->forceFill(['google_id' => $googleUser->id])->save();
            }

            if (! $user->is_active) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Akun Anda belum disetujui admin atau dinonaktifkan.',
                ]);
            }

            Auth::login($user, true);
            $user->forceFill(['last_login_at' => now()])->saveQuietly();

            return redirect()->route($this->dashboardRouteFor($user->role));
        }

        // ==== INTENT: REGISTER ====
        if ($user) {
            return redirect()->route('login')->withErrors([
                'email' => 'Email ini sudah terdaftar. Silakan login.',
            ]);
        }

        User::create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'google_id' => $googleUser->id,
            'password' => null,
            'role' => null,
            'is_active' => false,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi via Google berhasil. Akun kamu menunggu persetujuan admin sebelum bisa login.');
    }

    private function dashboardRouteFor(?string $role): string
    {
        return match ($role) {
            'super_admin', 'programmer', 'viewer' => 'dashboard.index',
            default => 'login',
        };
    }
}