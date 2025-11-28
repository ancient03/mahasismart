<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// 👇 Import Class Wajib untuk menangani Auth Exception
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan alias middleware Anda di sini
        $middleware->alias([
            'toko.banned' => \App\Http\Middleware\CheckTokoBanned::class,
            'admin'       => \App\Http\Middleware\IsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
        // 👇 LOGIKA PENANGANAN USER BELUM LOGIN 👇
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            // Jika request mengharapkan JSON (misal API), kembalikan 401 JSON
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            // Jika akses web biasa, redirect ke rute 'login' dengan pesan error
            return redirect()->guest(route('login'))
                ->with('error', 'Eits, kamu harus login dulu untuk mengakses halaman ini!');
        });

    })->create();