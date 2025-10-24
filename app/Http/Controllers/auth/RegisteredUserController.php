<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User; // Pastikan ini mengarah ke model Anda
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Carbon\Carbon; // Import Carbon untuk tanggal

class RegisteredUserController extends Controller
{
    /**
     * Menampilkan halaman registrasi.
     */
    public function create(): View
    {
        // Arahkan ke view auth.register
        return view('page/auth/register');
    }

    /**
     * Menangani permintaan registrasi yang masuk.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // VALIDASI: Disesuaikan dengan tabel database Anda
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'no_hp' => ['nullable', 'string', 'max:255', 'unique:'.User::class], // Opsional
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // BUAT USER: Disesuaikan dengan model Anda
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'no_hp' => $request->no_hp, // Akan menyimpan NULL jika kosong
            'password' => Hash::make($request->password),
            'tanggal' => Carbon::now()->toDateString(), // Mengisi 'tanggal'
        ]);

        // Event bawaan Laravel
        event(new Registered($user));

        // Login user secara otomatis
        Auth::login($user);

        // Arahkan ke Halaman Home
        return redirect("login");
    }
}