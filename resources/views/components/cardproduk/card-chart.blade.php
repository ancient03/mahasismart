@props(['item'])

{{-- $item adalah objek Keranjang, $item->barang adalah objek Barang --}}
@if ($item->barang) {{-- Hanya tampilkan jika barang masih ada/terkait --}}
<div class="bg-white rounded-lg shadow-md p-4 flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
    
    <!-- Gambar -->
    <div class="flex-shrink-0 w-full md:w-24 h-48 md:h-24 bg-gray-300 rounded-lg">
        @if ($item->barang->foto_barang)
            <img src="{{ asset('img/fotobarang/' . $item->barang->foto_barang) }}" alt="{{ $item->barang->nama_barang }}" class="w-full h-full object-cover rounded-lg">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-400 rounded-lg bg-gray-200">
                <i class="bi bi-image text-3xl"></i>
            </div>
        @endif
    </div>

    <!-- Info & Harga -->
    <div class="flex-grow flex flex-col justify-between">
        <div>
            <span class="text-sm text-gray-600">{{ $item->barang->toko?->nama_toko ?? 'Toko' }}</span>
            <h3 class="font-bold text-lg text-gray-900">{{ $item->barang->nama_barang }}</h3>
            <span class="font-medium text-lg text-gray-800">Rp. {{ number_format($item->barang->harga, 0, ',', '.') }}</span>
        </div>
    </div>

    <!-- Aksi (Kuantitas & Hapus) -->
    <div class="flex-shrink-0 flex flex-row md:flex-col justify-between items-center md:items-end">
        
        {{-- Form Hapus (Tombol Sampah) --}}
        <form action="{{ route('keranjang.destroy', $item->barang->id_barang) }}" method="POST" onsubmit="return confirm('Hapus barang ini dari keranjang?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-gray-500 hover:text-red-600 p-1">
                <i class="bi bi-trash3-fill text-xl"></i>
            </button>
        </form>
        
        {{-- Form Update Kuantitas --}}
        <form action="{{ route('keranjang.update', $item->barang->id_barang) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="flex items-center border border-gray-300 rounded-lg">
                {{-- Tombol Kurang --}}
                <button type="button" 
                        onclick="this.nextElementSibling.stepDown(); this.nextElementSibling.dispatchEvent(new Event('change'));"
                        class="w-8 h-8 flex items-center justify-center text-gray-700 hover:bg-gray-100 rounded-l-lg focus:outline-none">
                    <i class="bi bi-dash-lg"></i>
                </button>
                
                {{-- Input Kuantitas --}}
                <input type="number" 
                       name="kuantitas" 
                       value="{{ $item->kuantitas }}" 
                       min="0" {{-- Jika 0, controller akan menghapus --}}
                       class="w-12 h-8 text-center border-l border-r border-gray-300 focus:outline-none"
                       {{-- Auto-submit saat nilai berubah --}}
                       onchange="this.form.submit()"> 
                
                {{-- Tombol Tambah --}}
                <button type="button" 
                        onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.dispatchEvent(new Event('change'));"
                        class="w-8 h-8 flex items-center justify-center text-gray-700 hover:bg-gray-100 rounded-r-lg focus:outline-none">
                    <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endif
