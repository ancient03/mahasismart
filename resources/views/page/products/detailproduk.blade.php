{{-- 
  Menggunakan layout khusus detail produk. 
  Kita kirim :barang="$barang" agar layout bisa mengakses data barang (misal untuk <title>).
--}}
<x-layout.layoutdetailproduk :barang="$barang">
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 space-y-6 pb-10">
        
        {{-- 1. KOMPONEN PRODUK UTAMA --}}
        {{-- Menampilkan gambar utama, slideshow, harga, dan tombol beli --}}
        <x-detailproduk.produk :barang="$barang" />

        {{-- 2. KOMPONEN INFO TOKO --}}
        {{-- Menampilkan nama toko, logo, dan lokasi --}}
        {{-- Kita gunakan 'nullsafe' agar tidak error jika toko dihapus --}}
        <x-detailproduk.toko :toko="$toko" :totalTerjualToko="$totalTerjualToko" />

        {{-- 3. KOMPONEN RATING & STATISTIK --}}
        {{-- Menampilkan ringkasan bintang (misal: 4.5 dari 5) --}}
        <x-detailproduk.rating :avgRating="$avgRating" :totalRating="$totalRating" />

        {{-- 4. DAFTAR ULASAN --}}
        <div id="review-list" class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Ulasan Pembeli</h2>
            
            {{-- Loop ulasan dari database --}}
            @forelse ($ulasanList as $ulasan)
                <x-detailproduk.ulasan 
                    :ulasan="$ulasan" 
                    class="review-item"
                    :data-rating="$ulasan->rating"
                    :data-has-image="$ulasan->fotoUlasan->isNotEmpty() ? 'true' : 'false'"
                    :data-has-comment="!empty($ulasan->komentar) ? 'true' : 'false'"
                />
            @empty
                <div class="text-center text-gray-500 py-10 border border-dashed rounded-lg">
                    <i class="bi bi-chat-square-text text-4xl mb-2 text-gray-300"></i>
                    <p>Belum ada ulasan untuk produk ini.</p>
                </div>
            @endforelse

            {{-- Pagination Ulasan --}}
            <div class="mt-4">
                {{ $ulasanList->links() }}
            </div>
        </div>

        {{-- 5. REKOMENDASI PRODUK --}}
        <div class="pt-8 border-t border-gray-200">
            <h1 class="lg:text-2xl text-xl font-semibold mb-6 text-gray-800">Rekomendasi Produk</h1>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"> 
                
                {{-- Loop data rekomendasi --}}
                @forelse ($rekomendasiList as $rekBarang)
                    
                    {{-- KARTU PRODUK (Sesuai template Anda) --}}
                    <a href="{{ route('detailproduk.show', $rekBarang->id_barang) }}" 
                       class="block w-full bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200 hover:bg-gray-50 transition duration-300 cursor-pointer hover:-translate-y-1">
                        
                        {{-- Foto Barang --}}
                        <div class="w-full h-36 bg-gray-200 flex items-center justify-center overflow-hidden">
                            @if ($rekBarang->foto_barang)
                                <img src="{{ asset('img/fotobarang/' . $rekBarang->foto_barang) }}" 
                                     alt="{{ $rekBarang->nama_barang }}" 
                                     class="w-full h-full object-cover">
                            @else
                                 <span class="text-gray-400 text-sm flex flex-col items-center">
                                    <i class="bi bi-image text-2xl mb-1"></i> No Image
                                 </span>
                            @endif
                        </div>

                        {{-- Info Produk --}}
                        <div class="p-3 space-y-1.5">
                            {{-- Nama --}}
                            <h3 class="font-semibold text-sm text-gray-900 truncate" title="{{ $rekBarang->nama_barang }}">
                                {{ $rekBarang->nama_barang }}
                            </h3>
                            {{-- Harga --}}
                            <p class="font-bold text-base text-gray-900">
                                Rp {{ number_format($rekBarang->harga, 0, ',', '.') }}
                            </p>

                            {{-- Rating Statis (Bisa diganti dinamis nanti) --}}
                            <div class="flex items-center text-xs text-gray-600 space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.959a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.445a1 1 0 00-.364 1.118l1.286 3.959c.3.921-.755 1.688-1.538 1.118l-3.367-2.445a1 1 0 00-1.175 0l-3.367 2.445c-.783.57-1.838-.197-1.538-1.118l1.286-3.959a1 1 0 00-.364-1.118L2.06 9.386c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.959z" />
                                </svg>
                                <span>4.8</span> 
                            </div>

                            {{-- Lokasi/Toko --}}
                            <div class="flex items-center text-xs text-gray-600 space-x-1 truncate">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <span title="{{ $rekBarang->toko?->nama_toko ?? 'Toko' }}">
                                    {{ $rekBarang->toko?->nama_toko ?? 'Toko' }}
                                </span>
                            </div>
                        </div>
                    </a>
                    {{-- AKHIR KARTU PRODUK --}}

                @empty
                    <div class="col-span-full text-center text-gray-500 py-10 border border-dashed rounded-lg bg-gray-50">
                        <p>Tidak ada produk rekomendasi saat ini.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-layout.layoutdetailproduk>