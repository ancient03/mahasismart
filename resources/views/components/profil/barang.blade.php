{{-- contoh produk dengan status di proses --}}
<div class="p-4 mt-6 lg:rounded-md shadow-md bg-white w-full">
    {{-- toko --}}
    <div class="flex items-center gap-4 mb-4">
        <img src="{{ asset('img/kuning.png') }}" alt="" class="h-8 w-8 rounded-full object-cover">
        <h1 class="lg:text-1xl text-xl font-semibold">Toko Taufan Afandi</h1>
    </div>

    {{-- barang --}}
    <div class="flex flex-col md:flex-row gap-4">
        {{-- foto barang --}}
        <div class="flex-shrink-0">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQssFrYujuBrf5Et_UF5x0IbeDzh4q6qGuFFw&s"
                 alt="Foto Produk"
                 class="h-32 w-auto rounded-md object-cover">
        </div>

        {{-- detail produk --}}
        <div class="flex-1">
            {{-- deskripsi produk --}}
            <div class="flex items-start justify-between w-full">
                <div class="border-2 border-transparent">
                    {{-- nama produk --}}
                    <h1 class="lg:text-2xl text-lg font-semibold">Pocari Sweet</h1>

                    {{-- harga --}}
                    <p class="text-2xl md:text-3xl font-bold text-zinc-800">Rp 5.000</p>
                </div>

                <div class="text-right flex items-center gap-2">
                    {{-- total produk --}}
                    <p class="font-medium text-zinc-700">Total: 10</p>

                    <span>|</span>

                    {{-- metode pembayaran --}}
                    <p class="font-medium text-zinc-700">COD</p>
                </div>
            </div>

            <div class="flex items-center justify-between mt-4">
                {{-- status pesanan--}}
                <div class="bg-zinc-200 py-2 px-6 rounded-md text-zinc-700 font-medium">
                    Diproses
                </div>

                {{-- hubungi penjual --}}
                <a class="bg-white py-2 px-6 rounded-md font-medium cursor-pointer border-2 border-[#00795E] text-[#00795E] hover:bg-[#00795E] hover:text-white transition duration-500">
                    Hubungi Penjual
                </a>
            </div>
        </div>
    </div>
</div>


{{-- contoh produk dengan status di proses --}}
<div class="p-4 mt-6 lg:rounded-md shadow-md bg-white w-full mb-96">
    {{-- toko --}}
    <div class="flex items-center gap-4 mb-4">
        <img src="{{ asset('img/kuning.png') }}" alt="" class="h-8 w-8 rounded-full object-cover">
        <h1 class="lg:text-1xl text-xl font-semibold">Toko Taufan Afandi</h1>
    </div>

    {{-- barang --}}
    <div class="flex flex-col md:flex-row gap-4">
        {{-- foto barang --}}
        <div class="flex-shrink-0">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQssFrYujuBrf5Et_UF5x0IbeDzh4q6qGuFFw&s"
                 alt="Foto Produk"
                 class="h-32 w-auto rounded-md object-cover">
        </div>

        {{-- detail produk --}}
        <div class="flex-1">
            {{-- deskripsi produk --}}
            <div class="flex items-start justify-between w-full">
                <div class="border-2 border-transparent">
                    {{-- nama produk --}}
                    <h1 class="lg:text-2xl text-lg font-semibold">Pocari Sweet</h1>

                    {{-- harga --}}
                    <p class="text-2xl md:text-3xl font-bold text-zinc-800">Rp 5.000</p>
                </div>

                <div class="text-right flex items-center gap-2">
                    {{-- total produk --}}
                    <p class="font-medium text-zinc-700">Total: 10</p>

                    <span>|</span>

                    {{-- metode pembayaran --}}
                    <p class="font-medium text-zinc-700">COD</p>
                </div>
            </div>

            <div class="flex items-center justify-between mt-4">
                {{-- status pesanan--}}
                <div class="py-2 px-6 rounded-md text-white font-medium bg-[#00795E]">
                    Selesai
                </div>

                <div class="flex items-center gap-4">
                    {{-- ulasan --}}
                    <a href="" class="bg-zinc-200 py-2 px-6 rounded-md text-zinc-700 font-medium cursor-pointer hover:bg-zinc-300 transition duration-500">Beri Ulasan</a>

                    {{-- hubungi penjual --}}
                    <a class="bg-white py-2 px-6 rounded-md font-medium cursor-pointer border-2 border-[#00795E] text-[#00795E] hover:bg-[#00795E] hover:text-white transition duration-500">
                        Hubungi Penjual
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
