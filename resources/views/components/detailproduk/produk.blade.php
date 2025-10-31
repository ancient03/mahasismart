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

        {{-- Slideshow (Masih statis, perlu galeri foto di DB) --}}
        {{--<div class="flex gap-4 mt-4 items-center lg:justify-center flex-wrap">
            <button class="cursor-pointer hidden lg:block"> <i class="bi bi-arrow-left-circle text-2xl"></i> </button>
            <button class="cursor-pointer"><img src="https://down-id.img.susercontent.com/file/id-11134207-7ra0o-mcirttrwonqna2@resize_w450_nl.webp" alt="" class="lg:h-24 h-16 rounded-md"></button>
            <button class="cursor-pointer"><img src="https://down-id.img.susercontent.com/file/id-11134207-7ra0u-mcixki1oeas8a9@resize_w450_nl.webp" alt="" class="lg:h-24 h-16 rounded-md"></button>
            <button class="cursor-pointer"><img src="https://down-id.img.susercontent.com/file/id-11134207-7ra0o-mcirttrwonqna2@resize_w450_nl.webp" alt="" class="lg:h-24 h-16 rounded-md"></button>
            <button class="cursor-pointer"><img src="https://down-id.img.susercontent.com/file/id-11134207-7ra0u-mcixki1oeas8a9@resize_w450_nl.webp" alt="" class="lg:h-24 h-16 rounded-md"></button>
            <button class="cursor-pointer hidden lg:block"> <i class="bi bi-arrow-right-circle text-2xl"></i> </button>
        </div> --}}
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

        {{-- Deskripsi (Contoh, tambahkan kolom 'deskripsi' ke tabel barang) --}}
        <p class="my-2 text-gray-700 mt-4">
            {{ $barang->deskripsi ?? 'Tidak ada deskripsi untuk produk ini.' }}
        </p>

        {{-- kuantitas --}}
        <div class="mt-8">
            <label class="block text-sm font-medium text-gray-700 mb-2">Kuantitas:</label>
            <div class=" items-center bg-gray-200 rounded overflow-hidden inline-flex">
                <button 
                    class="px-4 py-2 text-xl font-bold border-r border-gray-400 hover:bg-gray-300"
                    onclick="decreaseQuantity()"
                >−</button>
                <input 
                    type="text" 
                    id="quantity" 
                    value="1"
                    class="w-12 text-center bg-gray-200 font-semibold focus:outline-none"
                    readonly
                >
                <button 
                    class="px-4 py-2 text-xl font-bold border-l border-gray-400 hover:bg-gray-300"
                    onclick="increaseQuantity()"
                >+</button>
            </div>
        </div>

        {{-- tombol beli sekarang & tambah ke keranjang --}}
        <div class=" flex gap-4 mt-10 flex-wrap ">
            <button class="bg-[#00795E] text-white px-6 py-3 rounded hover:bg-[#005a47] transition cursor-pointer font-semibold">
                Beli Sekarang
            </button>
            <button class="bg-zinc-300 text-zinc-800 px-6 py-3 rounded hover:bg-zinc-500 transition cursor-pointer font-semibold">
                Tambah ke Keranjang
            </button>
        </div>
    </div>
</div>

{{-- 
  Pindahkan script ke layout utama atau push ke stack
  agar tidak tercampur di dalam komponen 
--}}
@push('scripts')
<script>
    function decreaseQuantity() {
        const input = document.getElementById('quantity');
        let value = parseInt(input.value);
        if (value > 1) input.value = value - 1;
    }

    function increaseQuantity() {
        const input = document.getElementById('quantity');
        let value = parseInt(input.value);
        input.value = value + 1; // Nanti tambahkan cek stok
    }
</script>
@endpush
