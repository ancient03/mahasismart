<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController; 
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\profile\ProfileController;

Route::get('/', function () {
    return view('page/home');
});

route::get('/search', function () {
    return view('page/search');
});


route::get('/keranjang', function () {
    return view('page/products/chart');
});
  
route::get('/detailproduk', function () {
    return view('page/products/detailproduk');
});


Route::get('/alamat', function () {
    return view('page/profile/alamat');
})->middleware('auth')->name('alamat'); // <-- NAMA SUDAH ADA

/*
|--------------------------------------------------------------------------
| Rute Autentikasi
|--------------------------------------------------------------------------
*/

// BIARKAN BARIS INI (INI YANG BENAR)
Route::get('register', [RegisteredUserController::class, 'create'])
            ->middleware('guest')
            ->name('register');

// Rute untuk MEMPROSES form registrasi (POST)
Route::post('register', [RegisteredUserController::class, 'store'])
            ->middleware('guest');

            // --- Rute Login ---
Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->middleware('guest')
            ->name('login'); // <-- Ini memperbaiki error "Route [login] not defined"

Route::post('login', [AuthenticatedSessionController::class, 'store'])
            ->middleware('guest');

// --- Rute Logout ---
// Kita butuh ini agar pengguna bisa keluar
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->middleware('auth') // Hanya bisa diakses jika SUDAH login
            ->name('logout');


// GET /profile : Menampilkan form (method 'edit' di controller)
Route::get('/profile', [ProfileController::class, 'edit'])
    ->middleware('auth')->name('profile');

// PATCH /profile : Menyimpan data (method 'update' di controller)
Route::patch('/profile', [ProfileController::class, 'update'])
    ->middleware('auth')->name('profile.update');