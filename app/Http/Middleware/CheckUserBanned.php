<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserBanned
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->status_user === 'banned') {
            
            $alasan = Auth::user()->catatan_admin ?? 'Akun Anda telah dinonaktifkan.';

            // Logout paksa
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirect ke login dengan pesan error
            return redirect()->route('login')->withErrors([
                'email' => 'Akun ini telah dibanned. Alasan: ' . $alasan,
            ]);
        }

        return $next($request);
    }
}