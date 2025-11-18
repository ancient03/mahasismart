<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTokoBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // 1. Cek apakah user punya toko
        if ($user && $user->toko) {
            
            // 2. Cek apakah status tokonya 'banned'
            if ($user->toko->status_toko === 'banned') {
                
                // 3. Jika banned, tendang ke halaman profil dengan pesan error
                $pesan = 'Akses Ditolak! Toko Anda sedang dibanned.';
                
                if ($user->toko->catatan_admin) {
                    $pesan .= ' Alasan: ' . $user->toko->catatan_admin;
                }

                return redirect()->route('profile')->with('error', $pesan);
            }
        }

        // Jika tidak banned (atau belum punya toko), biarkan lanjut
        // (Controller masing-masing nanti yang akan cek apakah user punya toko atau tidak)
        return $next($request);
    }
}