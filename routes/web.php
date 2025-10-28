<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\profile\ProfileController;
use App\Http\Controllers\profile\AlamatController;
use App\Http\Controllers\Toko\TokoController;
use App\Http\Controllers\toko\RegisterTokoController;
use App\Http\Controllers\toko\BarangController;

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


Route::get('/profil-toko', function () {
    return view('page/profile/profil-toko');
})->middleware('auth')->name('profil-toko');

Route::get('/checkout', function () {
    return view('page/products/checkout');
})->middleware('auth')->name('checkout');



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


Route::resource('alamat', AlamatController::class)->except(['show']); // 'show' tidak kita perlukan
Route::get('/pesanan', fn() => view('page/profile/pesanan'))
    ->middleware('auth')
    ->name('pesanan');

// Profil Toko
Route::get('/profil-toko', fn() => view('page/toko/profil-toko'))
    ->middleware('auth')
    ->name('profil-toko');

// Produk Saya
Route::get('/produk-saya', fn() => view('page/toko/produk-saya'))
    ->middleware('auth')
    ->name('produk-saya');

// Pesanan Masuk
Route::get('/pesanan-masuk', fn() => view('page/toko/pesanan-masuk'))
    ->middleware('auth')
    ->name('pesanan-masuk');

// Statistik Penjualan
Route::get('/statistik-penjualan', fn() => view('page/toko/statistik-penjualan'))
    ->middleware('auth')
    ->name('statistik-penjualan');


        // 👇 RUTE UNTUK REGISTER TOKO (MENGGUNAKAN CONTROLLER BARU) 👇


    Route::middleware('auth')->group(function () {

    // ... Rute profile, alamat, dll. ...

    // Rute Register Toko
    Route::get('/register-toko', [RegisterTokoController::class, 'create'])->name('register.toko.create');
    Route::post('/register-toko', [RegisterTokoController::class, 'store'])->name('register.toko.store');

    // 👇 INI RUTE UNTUK METHOD showProfile() 👇
    Route::get('/profil-toko', [TokoController::class, 'showProfile'])
        ->name('profil-toko'); 

        // 👇 RUTE UNTUK EDIT PROFIL TOKO 👇
    // Menampilkan form edit (GET)
    // {toko} adalah parameter route model binding, merujuk ke ID toko
    Route::get('/toko/{toko}/edit', [TokoController::class, 'edit'])->name('toko.edit');
    
    // Menyimpan perubahan (PUT/PATCH)
    // Method di form Anda adalah PUT (@method('PUT'))
    Route::put('/toko/{toko}', [TokoController::class, 'update'])->name('toko.update'); 

    // ... Rute toko lainnya ...

}); 

// admin
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/profile-admin', fn() => view('page.admin.profile-admin'))->name('admin.profile');
});

// list-toko
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/list-toko', fn() => view('page.admin.list-toko'))->name('admin.list-toko');
});

// list-admin
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/list-user', fn() => view('page.admin.list-user'))->name('admin.list-user');
});

// laporan
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/laporan', fn() => view('page.admin.laporan'))->name('admin.laporan');
});

// Rute CRUD Barang (Menggunakan Resource Controller)
Route::resource('produk-saya', BarangController::class)->middleware('auth'); 
