            <aside class="md:col-span-1">
                <div class="bg-white text-gray-800 rounded-lg shadow p-6">
                    
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-bold text-lg">{{ Auth::user()->username }}</span>
                            <a href="#" class="text-sm text-blue-600 hover:underline">Edit Profil</a>
                        </div>
                    </div>
<nav class="space-y-2">

    <!-- Link Profil (Dinamis) -->
    <a href="profile" 
       @class([
           'flex items-center space-x-3 py-2 px-3 rounded-md', // Kelas dasar (selalu ada)
           'bg-green-100 text-green-700 font-semibold' => Route::is('profile'), // Kelas aktif
           'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => !Route::is('profile') // Kelas inaktif
       ])>
        <span>Profil</span>
    </a>

    <!-- Link Alamat (Dinamis) -->
    <a href="alamat" 
       @class([
           'flex items-center space-x-3 py-2 px-3 rounded-md', // Kelas dasar
           'bg-green-100 text-green-700 font-semibold' => Route::is('alamat'), // Kelas aktif
           'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => !Route::is('alamat') // Kelas inaktif
       ])>
        <span>Alamat</span>
    </a>

    <!-- Link Pesanan Saya (Ganti '#' dengan route Anda nanti) -->
    <a href="#" 
       @class([
           'flex items-center space-x-3 py-2 px-3 rounded-md',
           // 'bg-green-100 text-green-700 font-semibold' => Route::is('pesanan'), // Aktifkan ini jika sudah ada rutenya
           'text-gray-600 hover:bg-gray-100 hover:text-gray-900' // => !Route::is('pesanan')
       ])>
        <span>Pesanan Saya</span>
    </a>

    <!-- Link Toko Saya (Ganti '#' dengan route Anda nanti) -->
    <a href="#" 
       @class([
           'flex items-center space-x-3 py-2 px-3 rounded-md',
           // 'bg-green-100 text-green-700 font-semibold' => Route::is('toko'), // Aktifkan ini jika sudah ada rutenya
           'text-gray-600 hover:bg-gray-100 hover:text-gray-900' // => !Route::is('toko')
       ])>
        <span>Toko Saya</span>
    </a>
</nav>
                </div>
            </aside>