{{-- Menerima variabel $toko dari view utama --}}
@props(['toko'])

@if($toko) {{-- Hanya tampilkan jika barang punya toko --}}
<div class="my-10">
    {{-- garis atas --}}
    <div class="border-2 border-zinc-100 bg-zinc-100 lg:h-4 h-2"></div>

    {{-- toko --}}
    <div class="lg:py-6 lg:px-8 py-4">
        <div class="flex flex-col lg:flex-row flex-wrap items-center gap-6">

            {{-- info toko dan lokasi --}}
            <div class="flex flex-col lg:flex-row gap-8 w-full lg:w-auto lg:my-0 my-4">
                {{-- info toko --}}
                <div class="flex items-center gap-4">
                    {{-- Gambar Toko --}}
                    <img 
                        src="{{ $toko->logo_toko ? asset('img/logotoko/' . $toko->logo_toko) : asset('img/kuning.png') }}" 
                        alt="Logo {{ $toko->nama_toko }}" 
                        class="h-28 w-28 rounded-full object-cover border-2 border-gray-200"
                    >

                    {{-- Info Toko --}}
                    <div>
                        {{-- Nama Toko --}}
                        <h2 class="lg:text-2xl text-1xl font-semibold">
                            {{ $toko->nama_toko }}
                        </h2>

                        {{-- Rating & Total Terjual (Statis, perlu data) --}}
                        <div class="flex items-center gap-3 mt-2 text-sm text-zinc-600">
                            <div class="flex items-center gap-1">
                                <i class="bi bi-star-fill text-yellow-400 text-xl"></i>
                                <span>4.8</span>
                            </div>
                            <span>|</span>
                            <span>89 Terjual</span>
                        </div>

                        {{-- Tombol --}}
                        <button 
                            class="mt-4 bg-white text-[#00795E] border-2 border-[#00795E] 
                                   lg:px-4 lg:py-2 px-3 py-1 rounded-lg hover:bg-[#00795E] hover:text-white 
                                   transition cursor-pointer lg:font-medium text-sm">
                            Kunjungi Toko
                        </button>
                    </div>
                </div>


                {{-- pembatas (desktop only) --}}
                <div class="hidden lg:block border-l-2 border-zinc-100 h-24"></div>

                {{-- lokasi (Statis, perlu data) --}}
                <div class=" flex-col justify-center mt-6 lg:mt-0 lg:flex hidden">
                    <span class="flex items-center gap-2">
                        <i class="bi bi-geo-alt-fill text-1xl text-zinc-500"></i>
                        <p class="text-zinc-500">Lokasi</p>
                    </span>
                    <p classs="font-semibold text-lg mt-2">Bandung, Jawa Barat</p>
                    <p class="text-sm text-gray-600">bergabung {{ $toko->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- garis bawah --}}
    <div class="border-2 border-zinc-100 bg-zinc-100 lg:h-4 h-2"></div>
</div>
@endif
