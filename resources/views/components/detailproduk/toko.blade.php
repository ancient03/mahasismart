<div class="my-16 mb-96">
    {{-- garis atas --}}
    <div class="border-2 border-zinc-100 bg-zinc-100 lg:h-4"></div>

    {{-- toko --}}
    <div class="lg:py-6 lg:px-8">
        <div class="flex items-center gap-6">
            {{-- gambar toko --}}
            <img src="{{ asset('img/kuning.png') }}" alt="" class="h-28 rounded-full">

            {{-- info toko --}}
            <div class="flex gap-16">
                {{-- pp toko nama, rating, total terjual --}}
                <div>
                    <div class="text-2xl font-semibold">
                        Toko Kuning
                    </div>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="flex items-center gap-2 text-sm text-zinc-600">
                            <p class="items-center flex gap-1">
                                <i class="bi bi-star-fill text-yellow-500 text-xl"></i>
                                4.8
                            </p>
                            <p>|</p>
                            <p>89 Terjual</p>
                        </span>
                    </div>
                    <button class="mt-4 bg-white text-[#00795E] border-2 border-[#00795E] px-4 py-2 rounded hover:bg-[#00795E] hover:text-white transition cursor-pointer">
                        Kunjungi Toko
                    </button>
                </div>
                {{-- pembatas --}}
                <div class="border-2 border-zinc-100"></div>
                {{-- lokasi --}}
                <div class="flex flex-col justify-center">
                    <span class="flex items-center gap-2">
                        <i class="bi bi-geo-alt-fill text-1xl text-zinc-500"></i>
                        <p class="text-zinc-500">Lokasi</p>
                    </span>
                    <p class="font-semibold text-lg mt-2">Bandung, Jawa Barat</p>
                    <p>bergabung 10 tahun lalu</p>
                </div>
            </div>
        </div>
    </div>
   
    {{-- garis bawah --}}
    <div class="border-2 border-zinc-100 bg-zinc-100 lg:h-4"></div>

    
</div>