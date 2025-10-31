<x-layout.layoutdetailproduk :barang="$barang">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        {{-- produk --}}
        {{-- Kirim data $barang ke komponen produk --}}
        <x-detailproduk.produk :barang="$barang" />

        {{-- toko --}}
        {{-- Kirim data $toko ke komponen toko --}}
        <x-detailproduk.toko :toko="$toko" />

        {{-- rating --}}
        {{-- Komponen ini berisi ringkasan rating dan filter --}}
        <x-detailproduk.rating /> {{-- Nanti bisa diisi data rating: :ratingData="$ratingData" --}}

        {{-- ulasan --}}
        {{-- Loop melalui data ulasan --}}
        @forelse ($ulasanList as $ulasan)
            <x-detailproduk.ulasan :ulasan="$ulasan" />
        @empty
            <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                <i class="bi bi-chat-right-text text-4xl mb-2"></i>
                <p>Belum ada ulasan untuk produk ini.</p>
            </div>
        @endforelse
        {{-- Contoh statis (hapus jika $ulasanList sudah dinamis) --}}
        <x-detailproduk.ulasan /> 

        {{-- rekomendasi produk --}}
        <h1 class="lg:text-2xl text-1xl font-semibold pt-6 border-t">Rekomendasi Produk</h1>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"> 
            
            {{-- Loop data rekomendasi dari controller --}}
            @forelse ($rekomendasiList as $rekBarang)
                {{-- 
                  Gunakan kartu produk yang sama dari halaman home/search
                  Pastikan nama komponen <x-cardproduk.card> ini benar
                --}}
                <a href="{{ route('detailproduk.show', $rekBarang->id_barang) }}" class="block w-full bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200 hover:bg-gray-100 transition duration-300 cursor-pointer">
                    <div class="w-full h-36 bg-gray-200 flex items-center justify-center">
                        @if ($rekBarang->foto_barang)
                            <img src="{{ asset('img/fotobarang/' . $rekBarang->foto_barang) }}" alt="{{ $rekBarang->nama_barang }}" class="w-full h-full object-cover">
                        @else
                             <span class="text-gray-400 text-sm">Tidak ada foto</span>
                        @endif
                    </div>
                    <div class="p-3 space-y-1.5">
                        <h3 class="font-semibold text-sm text-gray-900 truncate" title="{{ $rekBarang->nama_barang }}">{{ $rekBarang->nama_barang }}</h3>
                        <p class="font-bold text-base text-gray-900">Rp {{ number_format($rekBarang->harga, 0, ',', '.') }}</p>
                        <div class="flex items-center text-xs text-gray-600 space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.959a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.445a1 1 0 00-.364 1.118l1.286 3.959c.3.921-.755 1.688-1.538 1.118l-3.367-2.445a1 1 0 00-1.175 0l-3.367 2.445c-.783.57-1.838-.197-1.538-1.118l1.286-3.959a1 1 0 00-.364-1.118L2.06 9.386c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.959z" /></svg>
                            <span>4.8</span> {{-- Ganti rating dinamis jika ada --}}
                        </div>
                        <div class="flex items-center text-xs text-gray-600 space-x-1 truncate">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                            <span title="{{ $rekBarang->toko?->nama_toko ?? 'Toko' }}">{{ $rekBarang->toko?->nama_toko ?? 'Toko' }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <p class="col-span-full text-center text-gray-500 py-10">
                    Tidak ada produk rekomendasi.
                </p>
            @endforelse
        </div>
    </div>
</x-layout.layoutdetailproduk>
