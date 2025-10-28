<aside class="md:col-span-1">
    <div class="bg-white text-gray-800 lg:rounded-lg shadow-md lg:p-6 p-4">

        <div class="flex items-center space-x-4 mb-6">
            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden border"> {{-- Tambah overflow-hidden dan border --}}
                @if (Auth::user()->foto_profil)
                    <img src="{{ asset('img/fotoprofile/' . Auth::user()->foto_profil) }}" alt="Foto Profil"
                         class="w-full h-full rounded-full object-cover"> {{-- Ubah w-16 h-16 menjadi w-full h-full --}}
                @else
                    <i class="bi bi-person-fill text-4xl text-gray-400"></i>
                @endif
            </div>
            <div>
                <span class="font-bold text-lg">{{ Auth::user()->username }}</span>
            </div>
        </div>
        <nav class="space-y-2">

            <!-- Link Profil --><a href="{{ route('profile') }}" @class([
                'flex items-center space-x-3 py-2 px-3 rounded-md', // Kelas dasar (selalu ada)
                'bg-green-100 text-green-700 font-semibold' => Route::is('profile'), // Kelas aktif
                'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => !Route::is('profile'), // Kelas inaktif
            ])>
                <i class="bi bi-person-fill w-5 text-center"></i> {{-- Icon Profil --}}
                <span>Profil</span>
            </a>

            <!-- Link Alamat --><a href="{{ route('alamat.index') }}" @class([
                'flex items-center space-x-3 py-2 px-3 rounded-md', // Kelas dasar
                'bg-green-100 text-green-700 font-semibold' => Route::is('alamat.*'), // Gunakan wildcard '*'
                'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => !Route::is('alamat.*'), // Gunakan wildcard '*'
            ])>
                <i class="bi bi-geo-alt-fill w-5 text-center"></i> {{-- Icon Alamat --}}
                <span>Alamat</span>
            </a>
            
            <!-- Link Pesanan Saya --><a href="{{ route('pesanan') }}" @class([
                'flex items-center space-x-3 py-2 px-3 rounded-md',
                'bg-green-100 text-green-700 font-semibold' => Route::is('pesanan'), 
                'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => !Route::is('pesanan'),
            ])>
                <i class="bi bi-bag-fill w-5 text-center"></i> {{-- Icon Pesanan --}}
                <span>Pesanan Saya</span>
            </a>
        </nav>
    </div>
</aside>
