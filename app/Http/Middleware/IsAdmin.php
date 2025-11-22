<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. CEK ROLE
        // Pastikan di tabel 'users' ada kolom 'role' dan nilainya 'admin'
        if (Auth::user()->role === 'admin') {
            return $next($request); // Lanjutkan akses jika admin
        }

        // 3. Jika bukan admin, tolak akses (redirect ke home dengan error)
        return redirect('/')->with('error', 'Akses Ditolak! Halaman ini khusus Admin.');
    }
}