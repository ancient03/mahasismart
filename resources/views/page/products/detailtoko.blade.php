<x-layout>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 space-y-8 py-6">

        <!-- Banner Toko -->
        <section class="w-full h-64 bg-gray-200 rounded-lg shadow-md flex items-center justify-center overflow-hidden">
            @if($toko->banner_toko)
                <img src="{{ asset('img/bannertoko/' . $toko->banner_toko) }}" alt="Banner {{ $toko->nama_toko }}" class="w-full h-full object-cover">
            @else
                <p class="text-gray-500">Banner Toko</p>
            @endif
        </section>

        <!-- Informasi Toko -->
        <section class="bg-white p-5 rounded-xl shadow-lg flex items-center space-x-6">
            <div class="flex-shrink-0">                        
                <img 
                    src="{{ $toko->logo_toko ? asset('img/logotoko/' . $toko->logo_toko) : asset('img/kuning.png') }}" 
                    alt="Logo {{ $toko->nama_toko }}" 
                    class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-sm"
                >
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $toko->nama_toko }}</h1>
                <p class="text-gray-600 mt-1"><i class="bi bi-telephone-fill"></i> {{ $toko->no_hp_toko }}</p>
                <div class="mt-2">
                    @if($toko->status == 'verified')
                        <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                            <i class="bi bi-patch-check-fill"></i> Terverifikasi
                        </span>
                    @endif
                </div>
            </div>
        </section>

        <!-- Konten Utama: Filter + Produk -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Sidebar Kiri: Filter -->
            <aside class="lg:col-span-1">
                <div class="bg-white p-5 rounded-xl shadow-lg sticky top-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Kategori Produk</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('detailtoko.show', $toko->id_toko) }}" 
                               class="block w-full text-left px-4 py-2 rounded-md {{ !$selectedKategori ? 'bg-green-100 text-green-700 font-semibold' : 'hover:bg-gray-100' }}">
                                Semua Kategori
                            </a>
                        </li>
                        @foreach($kategoriProduk as $kategori)
                        <li>
                            <a href="{{ route('detailtoko.show', ['toko' => $toko->id_toko, 'kategori' => $kategori->id_kategori]) }}"
                               class="block w-full text-left px-4 py-2 rounded-md {{ $selectedKategori && $selectedKategori->id_kategori == $kategori->id_kategori ? 'bg-green-100 text-green-700 font-semibold' : 'hover:bg-gray-100' }}">
                                {{ $kategori->nama_kategori }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <!-- Kanan: Daftar Produk -->
            <main class="lg:col-span-3">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">
                    {{ $selectedKategori ? $selectedKategori->nama_kategori : 'Semua Produk' }}
                </h2>

                @if($barangs && $barangs->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                        @foreach ($barangs as $barang)
                            <x-cardproduk.card :barang="$barang" />
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-8">
                        {{ $barangs->appends(request()->query())->links() }}
                    </div>

                @else
                    <div class="text-center py-16 bg-white rounded-lg shadow col-span-full">
                        <i class="bi bi-box2-heart text-6xl text-gray-300"></i>
                        <p class="mt-4 text-lg font-semibold text-gray-600">Belum Ada Produk</p>
                        <p class="text-gray-400 mt-1">Tidak ada produk yang cocok dengan filter ini.</p>
                    </div>
                @endif
            </main>
        </div>
    </div>
</x-layout>