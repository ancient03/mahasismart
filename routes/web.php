<?php

use Illuminate\Support\Facades\Route;

// ============================================================================
// IMPORT SEMUA CONTROLLER (WAJIB ADA)
// ============================================================================
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\profile\ProfileController;
use App\Http\Controllers\profile\AlamatController;
use App\Http\Controllers\profile\PesananController; // Controller Pesanan Saya (Pembeli)
use App\Http\Controllers\toko\RegisterTokoController;
use App\Http\Controllers\toko\TokoController;
use App\Http\Controllers\toko\BarangController;
use App\Http\Controllers\toko\PesananMasukController; // Controller Pesanan Masuk (Penjual)
use App\Http\Controllers\transaksi\KeranjangController;
use App\Http\Controllers\transaksi\CheckoutController;
use App\Http\Controllers\admin\AdminTokoController; // Controller Admin Toko
use App\Http\Controllers\admin\KategoriController; // Controller Admin Kategori
use App\Http\Controllers\Admin\IklanController; // Controller Admin Iklan
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\FaqController;

/*
|--------------------------------------------------------------------------
| Rute Publik (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/detailproduk/{barang}', [ProductDetailController::class, 'show'])->name('detailproduk.show');


/*
|--------------------------------------------------------------------------
| Rute Autentikasi (Register, Login, Logout)
|--------------------------------------------------------------------------
*/
// Rute untuk Tamu (Guest)
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::get('/faq', fn() => view('page.faq'))->name('faq');

// Rute Logout (Hanya untuk yang sudah login)
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')->name('logout');


/*
|--------------------------------------------------------------------------
| Rute yang Memerlukan login (Dilindungi Middleware 'auth')
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // --- Rute Profil User ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // --- Rute CRUD Alamat ---
    Route::resource('alamat', AlamatController::class)->except(['show']);

    // --- Rute Pesanan User ("Pesanan Saya" - Histori Pembeli) ---
    // Pastikan PesananController.php ada di app/Http/Controllers/profile/
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan');

    // --- Rute Keranjang ---
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah/{barang}', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::patch('/keranjang/update/{id_barang}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/hapus/{id_barang}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');

    // --- Rute Checkout ---
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // --- Rute Toko (Dashboard Penjual) ---
    Route::prefix('toko')->middleware(['auth', 'toko.banned'])->group(function () {
        // Register Toko (Buka Toko)
        Route::get('/register', [RegisterTokoController::class, 'create'])->name('register.toko.create');
        Route::post('/register', [RegisterTokoController::class, 'store'])->name('register.toko.store');

        // Profil Toko & Edit Toko
        Route::get('/profil', [TokoController::class, 'showProfile'])->name('profil-toko');
        Route::get('/{toko}/edit', [TokoController::class, 'edit'])->name('toko.edit');
        Route::put('/{toko}', [TokoController::class, 'update'])->name('toko.update');

        // CRUD Barang (Produk Saya)
        // Rute ini akan membuat: produk-saya.index, produk-saya.create, produk-saya.store, dll.
        // Sesuai permintaan Anda untuk menggunakan 'produk-saya' sebagai nama resource
        Route::resource('produk-saya', BarangController::class);

        // Pesanan Masuk (Manajemen Pesanan untuk Penjual)
        Route::get('/pesanan-masuk', [PesananMasukController::class, 'index'])->name('pesanan-masuk');

        // Update Status Pesanan Masuk
        Route::post('/pesanan-masuk/{transaksi}/update-status', [PesananMasukController::class, 'updateStatus'])
            ->name('pesanan-masuk.update-status');

        // Statistik (Halaman lain di dashboard)
        Route::get('/statistik-penjualan', fn() => view('page/toko/statistik-penjualan'))->name('statistik-penjualan');
    });

    // --- Rute Admin ---
    Route::prefix('admin')->group(function () {
        Route::get('/profile-admin', fn() => view('page.admin.profile-admin'))->name('admin.profile');

        // List Toko (Admin)
        Route::get('/list-toko', [AdminTokoController::class, 'index'])->name('admin.list-toko');

        // Update Status Toko (Banned/Aktif)
        Route::patch('/list-toko/{toko}/status', [AdminTokoController::class, 'updateStatus'])->name('admin.toko.update-status');

        Route::get('/list-user', fn() => view('page.admin.list-user'))->name('admin.list-user');
        Route::get('/laporan', fn() => view('page.admin.laporan'))->name('admin.laporan');

        // --- Manajemen Kategori (Admin) ---
        Route::get('/kategori', [KategoriController::class, 'index'])->name('admin.kategori');
        Route::get('/kategori/tambah-kategori', [KategoriController::class, 'create'])->name('admin.tambah-kategori');
        Route::post('/kategori/store', [KategoriController::class, 'store'])->name('admin.kategori.store');
        Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('admin.kategori.edit');
        Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('admin.kategori.update');

        // --- Manajemen Iklan (Admin) ---
        Route::get('/iklan', [IklanController::class, 'index'])->name('admin.iklan');
        Route::get('/iklan/tambah-iklan', [IklanController::class, 'create'])->name('admin.tambah-iklan');
        Route::post('/iklan/tambah-iklan', [IklanController::class, 'store'])->name('admin.store-iklan');
        Route::get('/iklan/{id}/edit-iklan', [IklanController::class, 'edit'])->name('admin.edit-iklan');
        Route::put('/iklan/{id}', [IklanController::class, 'update'])->name('admin.iklan.update');
        Route::delete('/iklan/{id}', [IklanController::class, 'destroy'])->name('admin.hapus-iklan');
    });

    // --- Rute Chat ---
    Route::prefix('page')->group(function () {
        Route::get('/chat', fn() => view('page.chat'))->name('page.chat');
    });
}); // Akhir middleware('auth') group
