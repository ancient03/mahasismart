<x-layout>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 space-y-8 py-6">

        <!-- Banner Toko -->
        <section class="w-full h-64 bg-gray-200 rounded-lg shadow-md flex items-center justify-center">
            <p class="text-gray-500">Banner Toko</p>
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

        <!-- Daftar Produk Toko -->
        <section>
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Semua Produk dari {{ $toko->nama_toko }}</h2>

            @if($toko->barang && $toko->barang->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-5">
                    @foreach ($toko->barang as $barang)
                        <x-cardproduk.card :barang="$barang" />
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-lg shadow">
                    <i class="bi bi-box2-heart text-6xl text-gray-300"></i>
                    <p class="mt-4 text-lg font-semibold text-gray-600">Belum Ada Produk</p>
                    <p class="text-gray-400 mt-1">Toko ini belum memiliki produk untuk dijual.</p>
                </div>
            @endif
        </section>

    </div>
</x-layout>
