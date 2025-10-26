<aside class="md:col-span-1 mt-6">
    <div class="bg-white text-gray-800 lg:rounded-lg shadow-md lg:p-6 p-4">
        <div class="flex items-center space-x-4 mb-6">
            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                {{-- <img src="" alt="Foto Profil" class="w-16 h-16 rounded-full object-cover"> --}}
                <i class="bi bi-person-fill text-4xl text-gray-400"></i>
            </div>
            <div>
                <span class="font-bold text-lg">Toko Saya</span>
            </div>
        </div>

        <nav class="space-y-2">
            {{-- Profil Toko --}}
            <a href="{{ route('profil-toko') }}" 
                @class([
                    'flex items-center space-x-3 py-2 px-3 rounded-md',
                    'bg-green-100 text-green-700 font-semibold' => Route::is('profil-toko'),
                    'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => !Route::is('profil-toko'),
                ])>
                <span>Profil Toko</span>
            </a>

            {{-- Produk Saya --}}
            <a href="{{ route('produk-saya') }}" 
                @class([
                    'flex items-center space-x-3 py-2 px-3 rounded-md',
                    'bg-green-100 text-green-700 font-semibold' => Route::is('produk-saya'),
                    'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => !Route::is('produk-saya'),
                ])>
                <span>Produk Saya</span>
            </a>

            {{-- Pesanan Masuk --}}
            <a href="{{ route('pesanan-masuk') }}" 
                @class([
                    'flex items-center space-x-3 py-2 px-3 rounded-md',
                    'bg-green-100 text-green-700 font-semibold' => Route::is('pesanan-masuk'),
                    'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => !Route::is('pesanan-masuk'),
                ])>
                <span>Pesanan Masuk</span>
            </a>

            {{-- Statistik Penjualan --}}
            <a href="{{ route('statistik-penjualan') }}" 
                @class([
                    'flex items-center space-x-3 py-2 px-3 rounded-md',
                    'bg-green-100 text-green-700 font-semibold' => Route::is('statistik-penjualan'),
                    'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => !Route::is('statistik-penjualan'),
                ])>
                <span>Statistik Penjualan</span>
            </a>
        </nav>
    </div>
</aside>
