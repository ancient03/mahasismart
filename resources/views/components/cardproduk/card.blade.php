{{-- Pastikan variabel $barang tersedia (misal: dari @forelse ($barangList as $barang)) --}}
<div class="w-full bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200 hover:bg-gray-100 transition duration-300 cursor-pointer"
     onclick="window.location.href='{{ route('detailproduk.show', $barang->id_barang) }}'">

    {{-- Foto Barang --}}
    <div class="w-full h-36 bg-gray-200 flex items-center justify-center"> {{-- Tambahkan flex & center untuk placeholder --}}
        @if ($barang->foto_barang)
            <img src="{{ asset('img/fotobarang/' . $barang->foto_barang) }}" 
                 alt="{{ $barang->nama_barang }}" 
                 class="w-full h-full object-cover">
        @else
            {{-- Placeholder jika tidak ada foto --}}
             <span class="text-gray-400 text-sm">Tidak ada foto</span>
             {{-- Alternatif Placeholder Icon: --}}
             {{-- <i class="bi bi-image text-4xl text-gray-400"></i> --}}
        @endif
    </div>

    {{-- Info Produk --}}
    <div class="p-3 space-y-1.5"> {{-- Menggunakan space-y-1.5 sesuai contoh --}}
        {{-- Nama Barang --}}
        <h3 class="font-semibold text-sm text-gray-900 truncate" title="{{ $barang->nama_barang }}">
            {{ $barang->nama_barang }}
        </h3>
        {{-- Harga --}}
        <p class="font-bold text-base text-gray-900">
            Rp {{ number_format($barang->harga, 0, ',', '.') }}
        </p>

        {{-- Rating (Contoh Statis) --}}
        <div class="flex items-center text-xs text-gray-600 space-x-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.959a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.445a1 1 0 00-.364 1.118l1.286 3.959c.3.921-.755 1.688-1.538 1.118l-3.367-2.445a1 1 0 00-1.175 0l-3.367 2.445c-.783.57-1.838-.197-1.538-1.118l1.286-3.959a1 1 0 00-.364-1.118L2.06 9.386c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.959z" />
            </svg>
            <span>4.8</span> {{-- Ganti dengan data rating jika ada --}}
        </div>

        {{-- Lokasi/Toko --}}
        <div class="flex items-center text-xs text-gray-600 space-x-1 truncate"> {{-- Tambah truncate jika perlu --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
            </svg>
            {{-- Tampilkan nama toko dari relasi --}}
            <span title="{{ $barang->toko?->nama_toko ?? 'Toko Tidak Diketahui' }}"> 
                  {{ $barang->toko?->nama_toko ?? 'Toko Tidak Diketahui' }} 
            </span>
        </div>
    </div>
</div>
