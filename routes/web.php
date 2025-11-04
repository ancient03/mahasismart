<?php

use App\Http\Controllers\Admin\IklanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\profile\ProfileController;
use App\Http\Controllers\profile\AlamatController;
use App\Http\Controllers\Toko\TokoController;
use App\Http\Controllers\toko\RegisterTokoController;
use App\Http\Controllers\toko\BarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\admin\KategoriController;
use App\Http\Controllers\transaksi\KeranjangController;
use App\Http\Controllers\transaksi\CheckoutController;
use App\Http\Controllers\profile\PesananController;
use App\Http\Controllers\toko\PesananMasukController;

Route::get('/', [HomeController::class, 'index'])->name('home');

route::get('/search', function () {
    return view('page/search');
});


route::get('/keranjang', function () {
    return view('page/products/chart');
});

// 👇 RUTE LAMA (DIKOMENTARI/HAPUS) 👇
// route::get('/detailproduk', function () {
//     return view('page/products/detailproduk');
// });
// 👇 RUTE BARU UNTUK DETAIL PRODUK 👇
Route::get('/detailproduk/{barang}', [ProductDetailController::class, 'show'])->name('detailproduk.show');



Route::get('/profil-toko', function () {
    return view('page/profile/profil-toko');
})->middleware('auth')->name('profil-toko');


// --- RUTE CHECKOUT (BARU) ---
// Menampilkan halaman pilih alamat & konfirmasi
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
// Memproses pesanan (saat tombol "Buat Pesanan" diklik)
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');


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

Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan');

// Profil Toko
Route::get('/profil-toko', fn() => view('page/toko/profil-toko'))
    ->middleware('auth')
    ->name('profil-toko');

// Produk Saya
Route::get('/produk-saya', fn() => view('page/toko/produk-saya'))
    ->middleware('auth')
    ->name('produk-saya');

// Pesanan Masuk
// Pesanan Masuk (INI YANG BARU)
Route::get('/pesanan-masuk', [PesananMasukController::class, 'index'])->name('pesanan-masuk');
Route::post('/pesanan-masuk/{transaksi}/update-status', [PesananMasukController::class, 'updateStatus'])
    ->name('pesanan-masuk.update-status'); // <-- NAMA DIPERBAIKI DI SINI

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

// Kategori
Route::prefix('admin')->middleware('auth')->group(function () {
    // Daftar kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('admin.kategori');

    // Tambah kategori
    Route::get('/kategori/tambah-kategori', [KategoriController::class, 'create'])->name('admin.tambah-kategori');
    Route::post('/kategori/store', [KategoriController::class, 'store'])->name('admin.kategori.store');

    // Edit kategori
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('admin.kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('admin.kategori.update');
});

// iklan admin
Route::prefix('admin')->middleware('auth')->group(function () {
    // Daftar iklan
    Route::get('/iklan', [IklanController::class, 'index'])->name('admin.iklan');

    // Tambah iklan (form)
    Route::get('/iklan/tambah-iklan', [IklanController::class, 'create'])->name('admin.tambah-iklan');

    // Simpan iklan (proses form)
    Route::post('/iklan/tambah-iklan', [IklanController::class, 'store'])->name('admin.store-iklan');

    // Edit iklan
    Route::get('/iklan/{id}/edit-iklan', [IklanController::class, 'edit'])->name('admin.edit-iklan');
    Route::put('/iklan/{id}', [IklanController::class, 'update'])->name('admin.iklan.update');


    // Hapus iklan
    Route::delete('/iklan/{id}', [IklanController::class, 'destroy'])->name('admin.hapus-iklan');
});

// detail iklan
Route::get('/detail-iklan/{id}', [HomeController::class, 'show'])->name('detail-iklan');



// Rute CRUD Barang (Menggunakan Resource Controller)
Route::resource('produk-saya', BarangController::class)->middleware('auth');

// chat
Route::prefix('page')->middleware('auth')->group(function () {
    Route::get('/chat', fn() => view('page.chat'))->name('page.chat');
});

// search
Route::get('/search', [SearchController::class, 'index'])->name('search');

// 1. Menampilkan halaman keranjang (dipanggil oleh <x-layout.app-layout>)
Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');

// 2. Menambah barang ke keranjang (dipanggil dari hal. detail produk)
Route::post('/keranjang/tambah/{barang}', [KeranjangController::class, 'store'])->name('keranjang.store');

// 3. Mengupdate kuantitas (dipanggil oleh <x-cardproduk.card-chart>)
// {id_barang} di sini BUKAN model binding, tapi ID dari tabel keranjang/barang
Route::patch('/keranjang/update/{id_barang}', [KeranjangController::class, 'update'])->name('keranjang.update');

// 4. Menghapus barang (dipanggil oleh <x-cardproduk.card-chart>)
Route::delete('/keranjang/hapus/{id_barang}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
