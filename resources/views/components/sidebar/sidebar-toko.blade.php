<aside class="md:col-span-1 mt-6">
    <div class="bg-white text-gray-800 lg:rounded-lg shadow-md lg:p-6 p-4">
        
        {{-- Pastikan user punya toko sebelum menampilkan info toko --}}
        @if(Auth::user()->toko) 
            @php 
                // Ambil data toko milik user yang login sekali saja
                $toko = Auth::user()->toko; 
            @endphp

            <div class="flex items-center space-x-4 mb-6">
                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden border">
                    {{-- Tampilkan logo toko atau placeholder --}}
                    @if ($toko->logo_toko)
                        <img src="{{ asset('img/logotoko/' . $toko->logo_toko) }}" alt="Logo Toko" class="w-full h-full object-cover"> 
                    @else
                        {{-- Placeholder SVG --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    @endif
                </div>
                <div>
                    {{-- Tampilkan nama toko --}}
                    <span class="font-bold text-lg">{{ $toko->nama_toko }}</span> 
                    {{-- Link ke halaman edit toko --}}
                    <a href="{{ route('toko.edit', $toko->id_toko) }}" class="text-sm text-blue-600 hover:underline block">Edit Toko</a>
                </div>
            </div>

            <nav class="space-y-2">
                {{-- Profil Toko --}}
                <a href="{{ route('profil-toko') }}" 
                    @class([
                        'flex items-center space-x-3 py-2 px-3 rounded-md',
                        'bg-green-100 text-green-700 font-semibold' => Route::is('profil-toko'), // Cek nama route ini
                        'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => !Route::is('profil-toko'),
                    ])>
                    <i class="bi bi-shop-window w-5 text-center"></i> {{-- Contoh ikon --}}
                    <span>Profil Toko</span>
                </a>

                {{-- Produk Saya --}}
                <a href="{{ route('produk-saya.index') }}" {{--  Ganti '#' jika route sudah ada --}}
                    @class([
                        'flex items-center space-x-3 py-2 px-3 rounded-md',
                        'bg-green-100 text-green-700 font-semibold' => Route::is('produk-saya.*'),
                        'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => !Route::is('produk-saya'),
                    ])>
                     <i class="bi bi-box-seam w-5 text-center"></i> {{-- Contoh ikon --}}
                    <span>Produk Saya</span>
                </a>

                {{-- Pesanan Masuk --}}
                <a href="pesanan-masuk" {{-- {{ route('pesanan-masuk') }} Ganti '#' jika route sudah ada --}} 
                    @class([
                        'flex items-center space-x-3 py-2 px-3 rounded-md',
                        'bg-green-100 text-green-700 font-semibold' => Route::is('pesanan-masuk'),
                        'text-gray-600 hover:bg-gray-100 hover:text-gray-900', // => !Route::is('pesanan-masuk'),
                    ])>
                    <i class="bi bi-cart-check w-5 text-center"></i> {{-- Contoh ikon --}}
                    <span>Pesanan Masuk</span>
                </a>

                {{-- Statistik Penjualan --}}
                <a href="statistik-penjualan" {{-- {{ route('statistik-penjualan') }} Ganti '#' jika route sudah ada --}}
                    @class([
                        'flex items-center space-x-3 py-2 px-3 rounded-md',
                        'bg-green-100 text-green-700 font-semibold' => Route::is('statistik-penjualan'),
                        'text-gray-600 hover:bg-gray-100 hover:text-gray-900', // => !Route::is('statistik-penjualan'),
                    ])>
                    <i class="bi bi-graph-up w-5 text-center"></i> {{-- Contoh ikon --}}
                    <span>Statistik Penjualan</span>
                </a>
            </nav>
        @else 
            {{-- Tampilkan pesan jika user belum punya toko --}}
            <div class="text-center text-gray-500 py-4">
                <p>Anda belum memiliki toko.</p>
                <a href="{{ route('register.toko.create') }}" class="mt-2 inline-block text-blue-600 hover:underline">Buka Toko Sekarang?</a>
            </div>
        @endif
    </div>
</aside>
