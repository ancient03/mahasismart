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
use App\Http\Controllers\profile\UlasanController; // Controller Ulasan
use App\Http\Controllers\toko\RegisterTokoController;
use App\Http\Controllers\toko\TokoController;
use App\Http\Controllers\toko\BarangController;
use App\Http\Controllers\toko\PesananMasukController; // Controller Pesanan Masuk (Penjual)
use App\Http\Controllers\transaksi\KeranjangController;
use App\Http\Controllers\transaksi\CheckoutController;
use App\Http\Controllers\admin\AdminTokoController; // Controller Admin Toko
use App\Http\Controllers\admin\KategoriController; // Controller Admin Kategori
use App\Http\Controllers\Admin\IklanController; // Controller Admin Iklan
use App\Http\Controllers\admin\AdminUserController; // Controller Admin User
use App\Http\Controllers\admin\AdminLaporanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\profile\LaporanController; // <-- Import controller baru
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MidtransController;

/*
|--------------------------------------------------------------------------
| Rute Publik (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/detailproduk/{barang}', [ProductDetailController::class, 'show'])->name('detailproduk.show');
Route::get('/detailtoko/{toko}', [TokoController::class, 'showPublicProfile'])->name('detailtoko.show');
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

Route::post('/midtrans/notification', [MidtransController::class, 'notificationHandler'])->name('midtrans.notification');



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

    // API Routes untuk RajaOngkir (CRUD Alamat)
Route::prefix('api/rajaongkir')->group(function () {
    Route::get('/provinsi', [AlamatController::class, 'getProvinsi'])->name('api.rajaongkir.provinsi');
    Route::get('/kota/{province_id}', [AlamatController::class, 'getKota'])->name('api.rajaongkir.kota');
    Route::get('/kecamatan/{city_id}', [AlamatController::class, 'getKecamatan'])->name('api.rajaongkir.kecamatan');
    Route::get('/desa/{district_id}', [AlamatController::class, 'getDesa'])->name('api.rajaongkir.desa');
});

    // --- Rute Pesanan User ("Pesanan Saya" - Histori Pembeli) ---
    
    // Halaman List Pesanan Saya
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan');

    // 👇 INI ROUTE DETAIL PESANAN (PEMBELI) 👇
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');

    // --- Rute Keranjang ---
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah/{barang}', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::patch('/keranjang/update/{id_barang}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/hapus/{id_barang}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');

        // --- FITUR LAPORAN (PEMBELI) ---
    // 👇 INI RUTE YANG ANDA MINTA 👇
    Route::get('/laporan-saya', [LaporanController::class, 'index'])->name('laporan.index'); // Lihat riwayat
    Route::get('/pesanan/{id}/lapor', [LaporanController::class, 'create'])->name('laporan.create'); // Form lapor
    Route::post('/laporan/store', [LaporanController::class, 'store'])->name('laporan.store'); // Simpan lapor
    
    // --- Rute Checkout ---
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // --- RUTE ULASAN (BARU) ---
    // Rute untuk menampilkan form ulasan
    Route::get('/ulasan/tulis/{id_transaksi}/{id_barang}', [UlasanController::class, 'create'])->name('ulasan.create');
    // Rute untuk menyimpan ulasan
    Route::post('/ulasan/simpan', [UlasanController::class, 'store'])->name('ulasan.store');

    // --- Rute Toko (Dashboard Penjual) ---
    Route::prefix('toko')->middleware(['auth', 'toko.banned'])->group(function () {
        
        Route::get('/', [TokoController::class, 'dashboard'])->name('toko.dashboard');
        // Register Toko (Buka Toko)
        Route::get('/register', [RegisterTokoController::class, 'create'])->name('register.toko.create');
        Route::post('/register', [RegisterTokoController::class, 'store'])->name('register.toko.store');
        Route::post('/register/validate-document', [RegisterTokoController::class, 'validateDocument'])
    ->name('register.toko.validate');


        // Profil Toko & Edit Toko
        Route::get('/profil', [TokoController::class, 'showProfile'])->name('profil-toko');
        Route::get('/{toko}/edit', [TokoController::class, 'edit'])->name('toko.edit');
        Route::put('/{toko}', [TokoController::class, 'update'])->name('toko.update');

            // 1. Rute Pembeli (Kirim Laporan)
    Route::post('/laporan/store', [LaporanController::class, 'store'])->name('laporan.store');

    // 2. Rute Toko (Lihat Laporan Masuk)
    Route::prefix('toko')->middleware(['toko.banned'])->group(function () {
        // ... rute toko lain ...
        Route::get('/laporan', [LaporanTokoController::class, 'index'])->name('toko.laporan');
    });

    // 3. Rute Admin (Kelola Laporan)
    Route::prefix('admin')->middleware(['admin'])->group(function () {
        // ... rute admin lain ...
        Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('admin.laporan');
        Route::patch('/laporan/{laporan}/update', [AdminLaporanController::class, 'updateStatus'])->name('admin.laporan.update');
    });
        // CRUD Barang (Produk Saya)
        // Rute ini akan membuat: produk-saya.index, produk-saya.create, produk-saya.store, dll.
        // Sesuai permintaan Anda untuk menggunakan 'produk-saya' sebagai nama resource
        Route::resource('produk-saya', BarangController::class);

        // Pesanan Masuk (Manajemen Pesanan untuk Penjual)
        Route::get('/pesanan-masuk', [PesananMasukController::class, 'index'])->name('toko.pesanan-masuk');

        // Update Status Pesanan Masuk
        Route::post('/pesanan-masuk/{transaksi}/update-status', [PesananMasukController::class, 'updateStatus'])
            ->name('pesanan-masuk.update-status');
        // ... di dalam grup 'toko'
    
    // Detail Pesanan Masuk (untuk Toko)
    Route::get('/pesanan-masuk/{transaksi}', [PesananMasukController::class, 'show'])
        ->name('pesanan-masuk.show');

        // Statistik (Halaman lain di dashboard)
        // Route::get('/statistik-penjualan', fn() => view('page/toko/statistik-penjualan'))->name('statistik-penjualan');
        Route::get('/statistik-penjualan', [TokoController::class, 'statistik'])->name('toko.statistik-penjualan');
    });

    // --- Rute Admin ---
    Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/', fn() => view('page.admin.dashboard-admin'))->name('admin.dashboard');

        // List Toko (Admin)
        Route::get('/list-toko', [AdminTokoController::class, 'index'])->name('admin.list-toko');

        // Update Status Toko (Banned/Aktif)
        Route::patch('/list-toko/{toko}/status', [AdminTokoController::class, 'updateStatus'])->name('admin.toko.update-status');

        // Manajemen User (List & Banned)
        Route::get('/list-user', [AdminUserController::class, 'index'])->name('admin.list-user'); // Gunakan controller, bukan view langsung
        Route::patch('/list-user/{user}/status', [AdminUserController::class, 'updateStatus'])->name('admin.user.update-status');
  
        // 👇 RUTE LAPORAN ADMIN (INI YANG ANDA CARI) 👇
        Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('admin.laporan');
        Route::patch('/laporan/{laporan}', [AdminLaporanController::class, 'updateStatus'])->name('admin.laporan.update');


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
        
                // --- Manajemen FAQ (Admin) ---
                Route::post('/faq', [FaqController::class, 'store'])->name('admin.faq.store');
                Route::put('/faq/{id}', [FaqController::class, 'update'])->name('admin.faq.update');
                Route::delete('/faq/{id}', [FaqController::class, 'destroy'])->name('admin.faq.destroy');
            });

    // --- Rute Notifikasi ---
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readall');

    // --- Rute Chat ---
    Route::prefix('page')->group(function () {
        Route::get('/chat', fn() => view('page.chat'))->name('page.chat');
    });
}); // Akhir middleware('auth') group
