<div class="flex flex-col lg:flex-row gap-8 mt-12">
    {{-- Left Section --}}
    <div class="w-full lg:w-1/2 text-center">
        {{-- Gambar Utama --}}
        <img 
            src="https://down-id.img.susercontent.com/file/id-11134207-7ra0h-mcirttrwrgvj12@resize_w900_nl.webp" 
            alt="Sepatu Sneakers" 
            class="lg:h-[30rem] lg:w-[30rem] w-full object-cover rounded-md mx-auto"
        >

        {{-- Slideshow --}}
        <div class="flex gap-4 mt-4 items-center lg:justify-center  flex-wrap">
            <button class="cursor-pointer hidden lg:block">
                <i class="bi bi-arrow-left-circle text-2xl"></i>
            </button>

            <button class="cursor-pointer"><img src="https://down-id.img.susercontent.com/file/id-11134207-7ra0o-mcirttrwonqna2@resize_w450_nl.webp" alt="" class="lg:h-24 h-16 rounded-md"></button>
            <button class="cursor-pointer"><img src="https://down-id.img.susercontent.com/file/id-11134207-7ra0u-mcixki1oeas8a9@resize_w450_nl.webp" alt="" class="lg:h-24 h-16 rounded-md"></button>
            <button class="cursor-pointer"><img src="https://down-id.img.susercontent.com/file/id-11134207-7ra0o-mcirttrwonqna2@resize_w450_nl.webp" alt="" class="lg:h-24 h-16 rounded-md"></button>
            <button class="cursor-pointer"><img src="https://down-id.img.susercontent.com/file/id-11134207-7ra0u-mcixki1oeas8a9@resize_w450_nl.webp" alt="" class="lg:h-24 h-16 rounded-md"></button>

            <button class="cursor-pointer hidden lg:block">
                <i class="bi bi-arrow-right-circle text-2xl"></i>
            </button>
        </div>
    </div>

    {{-- Right Section --}}
    <div class="w-full lg:w-1/2 pr-0 lg:pr-8 lg:ml-0 ml-2">
        {{-- Nama Produk --}}
        <div class="text-3xl font-bold">
            Baju Hitam
        </div>

        {{-- rate --}}
        <div class=" items-center gap-3 lg:flex hidden">
            <i class="bi bi-star-fill text-2xl text-yellow-500 "></i>
            <p>4.8</p>
        </div>

        {{-- harga --}}
        <h1 class="font-bold text-4xl mt-3 ">Rp 100.000</h1>

        {{-- garis --}}
        <div class="border-b-2 border-zinc-200 mt-12 mb-10 lg:block hidden"></div>

        {{-- kategori --}}
        <p class="my-2 lg:block hidden">Kategori: Makanan</p>

        {{-- kondisi --}}
        <p class="my-2 lg:block hidden">Kondisi: Baru</p>

        {{-- ketersediaan produk --}}
        <p class="my-2 lg:block hidden">Ketersediaan Produk: Pre-Order</p>

        {{-- keterangan --}}
        <p class="my-2 lg:block hidden">Min. Pesanan: 1 Buah</p>

        {{-- kuantitas --}}
        <div class=" items-center bg-gray-200 rounded overflow-hidden lg:inline-flex hidden">
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

        <script>
        function decreaseQuantity() {
            const input = document.getElementById('quantity');
            let value = parseInt(input.value);
            if (value > 1) input.value = value - 1;
        }

        function increaseQuantity() {
            const input = document.getElementById('quantity');
            let value = parseInt(input.value);
            input.value = value + 1;
        }
        </script>

        {{-- tombol beli sekarang & tambah ke keranjang --}}
        <div class=" lg:flex hidden gap-4 mt-16 flex-wrap ">
            <button class="bg-[#00795E] text-white px-6 py-3 rounded hover:bg-[#005a47] transition cursor-pointer">
                Beli Sekarang
            </button>
            <button class="bg-zinc-300 text-zinc-800 px-6 py-3 rounded hover:bg-zinc-500 transition cursor-pointer">
                Tambah ke Keranjang
            </button>
        </div>
    </div>
</div>
