            <aside class="md:col-span-1">
                <div class="bg-white text-gray-800 lg:rounded-lg shadow-md lg:p-6 p-4">
                    
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                            @if(Auth::user()->foto_profil)
                                <img src="{{ asset('img/fotoprofile/' . Auth::user()->foto_profil) }}" alt="Foto Profil" class="w-16 h-16 rounded-full object-cover">
                            @else
                                <i class="bi bi-person-fill text-4xl text-gray-400"></i>
                            @endif

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

<!-- Link Alamat (Dinamis Diperbaiki) -->
<a href="{{ route('alamat.index') }}" {{-- 1. Perbaiki href --}}
   @class([
       'flex items-center space-x-3 py-2 px-3 rounded-md', // Kelas dasar
       'bg-green-100 text-green-700 font-semibold' => Route::is('alamat.*'), // 2. Gunakan wildcard '*'
       'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => !Route::is('alamat.*') // 2. Gunakan wildcard '*'
   ])>
    <span>Alamat</span>
</a>
    <!-- Link Pesanan Saya (Ganti '#' dengan route Anda nanti) -->
    <a href="pesanan" 
       @class([
           'flex items-center space-x-3 py-2 px-3 rounded-md',
           'bg-green-100 text-green-700 font-semibold' => Route::is('pesanan'), // Aktifkan ini jika sudah ada rutenya
           'text-gray-600 hover:bg-gray-100 hover:text-gray-900'  => !Route::is('pesanan')
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