{{-- Menerima variabel $barang dari view utama --}}
@props(['barang'])

<div class="flex flex-col lg:flex-row gap-8 mt-12">
    {{-- Left Section --}}
    <div class="w-full lg:w-1/2 text-center">
        {{-- Gambar Utama --}}
        <img 
            src="{{ $barang->foto_barang ? asset('img/fotobarang/' . $barang->foto_barang) : 'https://via.placeholder.com/600x600?text=Tidak+Ada+Foto' }}" 
            alt="{{ $barang->nama_barang }}" 
            class="lg:h-[30rem] lg:w-[30rem] w-full h-auto aspect-square object-cover rounded-md mx-auto"
        >

        {{-- Slideshow (Statis) --}}
        {{-- <div class="flex gap-4 mt-4 items-center lg:justify-center flex-wrap"> ... </div> --}}
    </div>

    {{-- Right Section --}}
    <div class="w-full lg:w-1/2 pr-0 lg:pr-8">
        {{-- Nama Produk --}}
        <div class="lg:text-3xl text-2xl font-bold">
            {{ $barang->nama_barang }}
        </div>

        {{-- rate (contoh statis) --}}
        <div class=" items-center gap-3 lg:flex hidden mt-2">
            <i class="bi bi-star-fill text-2xl text-yellow-500 "></i>
            <p class="text-xl">4.8</p>
        </div>

        {{-- harga --}}
        <h1 class="font-bold lg:text-4xl text-3xl mt-3 ">
            Rp {{ number_format($barang->harga, 0, ',', '.') }}
        </h1>

        {{-- garis --}}
        <div class="border-b-2 border-zinc-200 mt-12 mb-10 lg:block hidden"></div>

        {{-- Kategori (Dinamis dari relasi) --}}
        @if($barang->kategori)
        <p class="my-2 lg:block hidden">
            <span class="text-gray-600">Kategori:</span> 
            <span class="font-medium">{{ $barang->kategori->nama_kategori }}</span>
        </p>
        @endif

        {{-- Deskripsi (Gunakan $barang->deskripsi) --}}
        <p class="my-2 text-gray-700 mt-4">
            {{ $barang->deskripsi ?? 'Tidak ada deskripsi untuk produk ini.' }}
        </p>

        {{-- ============================================= --}}
        {{-- FORM TAMBAH KE KERANJANG - DIMULAI DI SINI --}}
        {{-- ============================================= --}}
        <form action="{{ route('keranjang.store', $barang->id_barang) }}" method="POST">
            @csrf

            {{-- kuantitas --}}
            <div class="mt-8">
                <label class="block text-sm font-medium text-gray-700 mb-2">Kuantitas:</label>
                <div class=" items-center bg-gray-200 rounded overflow-hidden inline-flex">
                    <button 
                        type="button" {{-- Tipe 'button' agar tidak submit form --}}
                        class="px-4 py-2 text-xl font-bold border-r border-gray-400 hover:bg-gray-300"
                        onclick="decreaseQuantity()"
                    >−</button>
                    <input 
                        type="text" 
                        id="quantity" 
                        name="kuantitas" {{-- WAJIB ADA 'name' --}}
                        value="1"
                        class="w-12 text-center bg-gray-200 font-semibold focus:outline-none"
                        readonly
                    >
                    <button 
                        type="button" {{-- Tipe 'button' agar tidak submit form --}}
                        class="px-4 py-2 text-xl font-bold border-l border-gray-400 hover:bg-gray-300"
                        onclick="increaseQuantity()"
                    >+</button>
                </div>
            </div>

            {{-- tombol beli sekarang & tambah ke keranjang --}}
            <div class=" flex gap-4 mt-10 flex-wrap ">
                <button 
                    type="button" {{-- Tipe 'button' agar tidak submit form --}}
                    class="bg-[#00795E] text-white px-6 py-3 rounded hover:bg-[#005a47] transition cursor-pointer font-semibold">
                    Beli Sekarang
                </button>
                <button 
                    type="submit" {{-- Tipe 'submit' untuk mengirim form --}}
                    class="bg-zinc-300 text-zinc-800 px-6 py-3 rounded hover:bg-zinc-500 transition cursor-pointer font-semibold">
                    Tambah ke Keranjang
                </button>
            </div>

        </form>
        {{-- ============================================= --}}
        {{-- AKHIR FORM TAMBAH KE KERANJANG --}}
        {{-- ============================================= --}}

    </div>
</div>

{{-- 
  Script ini harus ada di layout utama Anda (app-layout.blade.php)
  atau dipastikan di-load oleh view detailproduk.blade.php
--}}
@push('scripts')
<script>
    if (typeof decreaseQuantity !== 'function') { // Cek agar tidak duplikat
        function decreaseQuantity() {
            const input = document.getElementById('quantity');
            let value = parseInt(input.value);
            if (value > 1) {
                input.value = value - 1;
            }
        }

        function increaseQuantity() {
            const input = document.getElementById('quantity');
            let value = parseInt(input.value);
            input.value = value + 1; // Nanti tambahkan cek stok
        }
    }
</script>
@endpush

