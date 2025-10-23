<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function create(): View
    {
        // Path ini sudah benar
        return view('page.auth.login');
    }

    /**
     * Menangani permintaan login (VERSI BARU UNTUK MULTI-KREDENSIAL).
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi input (kita sebut 'login' untuk field gabungan)
        $request->validate([
            'login' => ['required', 'string'], // Ini adalah field 'No. Handphone / Username / Email'
            'password' => ['required', 'string'],
        ]);

        $login = $request->input('login');
        $password = $request->input('password');
        $remember = $request->boolean('remember'); // Ambil 'remember me' (jika ada)

        // 2. Coba login dengan Email
        if (Auth::attempt(['email' => $login, 'password' => $password], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/'); // Redirect ke halaman utama
        }

        // 3. Jika gagal, coba login dengan Username
        if (Auth::attempt(['username' => $login, 'password' => $password], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/'); // Redirect ke halaman utama
        }

        // 4. Jika gagal, coba login dengan No. HP
        if (Auth::attempt(['no_hp' => $login, 'password' => $password], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/'); // Redirect ke halaman utama
        }

        // 5. Jika semua gagal, lempar error
        throw ValidationException::withMessages([
            'login' => 'Kredensial (username/email/no.hp) atau password salah.',
        ]);
    }

    /**
     * Menghancurkan sesi (logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}