<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Provider OAuth yang diizinkan.
     */
    protected array $allowedProviders = ['google', 'github'];

    /**
     * Menampilkan halaman login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Menampilkan halaman daftar akun baru.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Memproses pendaftaran akun baru.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'captcha_verified' => ['required', 'accepted'],
        ], [
            'email.unique' => 'Email ini sudah terdaftar. Coba masuk, atau pakai email lain.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'captcha_verified.accepted' => 'Selesaikan verifikasi captcha terlebih dahulu.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user, true);

        return redirect()->intended('/');
    }

    /**
     * Memproses percobaan login lewat email/password.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
            'captcha_verified' => ['required', 'accepted'],
        ], [
            'captcha_verified.accepted' => 'Selesaikan verifikasi captcha terlebih dahulu.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt(
            $request->only('email', 'password'),
            $remember
        )) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()
            ->withErrors([
                'email' => 'Email atau kata sandi tidak cocok dengan data kami.',
            ])
            ->onlyInput('email');
    }

    /**
     * Memproses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Mengarahkan pengguna ke halaman login provider OAuth.
     */
    public function redirectToProvider(string $provider)
    {
        $this->ensureProviderAllowed($provider);

        // Memaksa Google selalu menampilkan opsi pilihan akun setiap kali diklik
        if ($provider === 'google') {
            return Socialite::driver($provider)->with(['prompt' => 'select_account'])->redirect();
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Menerima balasan dari provider OAuth setelah pengguna login di sana.
     */
    public function handleProviderCallback(string $provider)
    {
        $this->ensureProviderAllowed($provider);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Throwable $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Gagal masuk lewat ' . ucfirst($provider) . '. Silakan coba lagi.']);
        }

        // Cari user berdasarkan kombinasi provider + provider_id dulu (paling akurat)
        $user = User::where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        if (! $user) {
            // Kalau belum ada, cek apakah emailnya sudah terdaftar lewat cara lain
            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                // Sudah ada akun dengan email sama — tautkan ke provider ini
                $user->forceFill([
                    'provider'    => $provider,
                    'provider_id' => $socialUser->getId(),
                ])->save();
            } else {
                // Buat akun baru dengan helper kompatibel Laravel 7
                $user = User::create([
                    'name'        => $socialUser->getName() ?: $socialUser->getNickname() ?: 'Pengguna',
                    'email'       => $socialUser->getEmail(),
                    'password'    => bcrypt(Str::random(32)),
                    'provider'    => $provider,
                    'provider_id' => $socialUser->getId(),
                ]);
            }
        }

        Auth::login($user, true);

        return redirect()->intended('/');
    }

    /**
     * Menolak provider yang tidak dikenal supaya tidak sembarang string bisa dipakai.
     */
    protected function ensureProviderAllowed(string $provider): void
    {
        if (! in_array($provider, $this->allowedProviders, true)) {
            abort(404);
        }
    }
}