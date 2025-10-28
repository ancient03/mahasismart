{{-- Memanggil layout Anda (Pastikan nama ini benar) --}}
<x-layout.layout-profile>

    {{-- Kolom Kanan Konten Produk (Ini akan masuk ke $slot layout Anda) --}}
    <section class="md:col-span-3">
        {{-- Header --}}
        <div class="py-3 px-5 lg:rounded-t-lg flex items-center justify-between shadow-md bg-white border-b border-gray-200"> {{-- Tambah border-b --}}
            <h1 class="lg:text-2xl text-xl font-semibold">Produk Toko Saya</h1> {{-- Ubah judul --}}
            {{-- Tombol Tambah Produk Baru --}}
            <a href="{{ route('produk-saya.create') }}"
               class="bg-[#FDBA38] text-black py-2 px-4 rounded-md font-medium hover:bg-[#c48a18] transition duration-300 text-sm">
                <i class="bi bi-plus-lg"></i> Tambah Produk
            </a>
        </div>

        <!-- Menampilkan pesan Sukses/Status dari Controller -->
        @if (session('status'))
            <div class="mb-4 rounded-md bg-green-100 p-4 text-sm font-medium text-green-700 mx-4 md:mx-0 mt-4">
                {{ session('status') }}
            </div>
        @endif
         <!-- Menampilkan pesan Error (jika ada dari redirect) -->
        @if (session('error'))
            <div class="mb-4 rounded-md bg-red-100 p-4 text-sm font-medium text-red-700 mx-4 md:mx-0 mt-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- Container untuk daftar produk --}}
        <div class="bg-white lg:rounded-b-lg shadow-md p-4 md:p-6 space-y-6">

            {{-- Looping melalui daftar barang ($barangList dari controller) --}}
            @forelse ($barangList as $itemBarang)
            <div class="p-4 border rounded-lg flex flex-col md:flex-row gap-4">
                {{-- Foto Barang --}}
                <div class="flex-shrink-0 w-full md:w-32 h-40 md:h-32 flex items-center justify-center">
                    @if ($itemBarang->foto_barang)
                        <img src="{{ asset('img/fotobarang/' . $itemBarang->foto_barang) }}"
                             alt="{{ $itemBarang->nama_barang }}" class="h-full w-full md:w-32 rounded-md object-cover">
                    @else
                        {{-- Placeholder jika tidak ada foto --}}
                        <div class="h-32 w-32 rounded-md bg-gray-200 flex items-center justify-center text-gray-400">
                             <i class="bi bi-image text-4xl"></i>
                        </div>
                    @endif
                </div>

                {{-- Detail Produk --}}
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <h2 class="lg:text-xl text-lg font-semibold">{{ $itemBarang->nama_barang }}</h2>
                        {{-- Tampilkan Nama Kategori (jika relasi 'kategori' di-load) --}}
                        @if($itemBarang->kategori)
                            <span class="text-xs bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full">{{ $itemBarang->kategori->nama_kategori }}</span>
                        @endif
                        <p class="text-xl md:text-2xl font-bold text-zinc-800 mt-1">Rp {{ number_format($itemBarang->harga, 0, ',', '.') }}</p>
                    </div>

                    {{-- Tombol Aksi (Edit & Hapus) --}}
                    <div class="flex items-center justify-end space-x-3 mt-4 md:mt-0">
                        {{-- Tombol Edit --}}
                        <a href="{{ route('produk-saya.edit', $itemBarang->id_barang) }}"
                           class="bg-[#00795E] text-white py-2 px-5 rounded-md font-medium hover:bg-[#00674f] transition duration-300 text-sm">
                            Edit
                        </a>
                        {{-- Tombol Hapus (dalam form) --}}
                        <form action="{{ route('produk-saya.destroy', $itemBarang->id_barang) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-md font-medium hover:bg-red-700 transition duration-300 text-sm" title="Hapus Barang">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            {{-- Pesan jika tidak ada barang --}}
            <div class="text-center text-gray-500 py-10 border border-dashed rounded-lg">
               <i class="bi bi-box-seam text-4xl mb-2"></i>
               <p>Anda belum menambahkan barang ke toko.</p>
               <a href="{{ route('produk-saya.create') }}" class="mt-4 inline-block bg-green-100 text-green-700 py-2 px-4 rounded-lg font-semibold hover:bg-green-200 transition-colors text-sm">
                   Tambah Produk Pertama Anda
               </a>
            </div>
            @endforelse
            {{-- Akhir Loop --}}
            
        </div> {{-- Akhir container daftar produk --}}

    </section>
</x-layout.layout-profile>

