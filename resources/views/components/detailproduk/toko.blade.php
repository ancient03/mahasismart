{{-- Menerima variabel $toko dan $totalTerjualToko --}}
@props(['toko' => null, 'totalTerjualToko' => 0]) 

@if($toko) 
<div class="my-10">
    {{-- Garis Atas --}}
    <div class="border-2 border-zinc-100 bg-zinc-100 lg:h-4 h-2"></div>

    <div class="lg:py-6 lg:px-8 py-4">
        <div class="flex flex-col lg:flex-row flex-wrap items-center gap-6">

            {{-- Info Toko & Lokasi --}}
            <div class="flex flex-col lg:flex-row gap-8 w-full lg:w-auto lg:my-0 my-4">
                {{-- Detail Toko --}}
                <div class="flex items-center gap-4">
                    {{-- Gambar Toko --}}
                    <div class="h-28 w-28 rounded-full overflow-hidden border-2 border-gray-200 flex-shrink-0">
                        <img 
                            src="{{ $toko->logo_toko ? asset('img/logotoko/' . $toko->logo_toko) : asset('img/kuning.png') }}" 
                            alt="Logo {{ $toko->nama_toko }}" 
                            class="w-full h-full object-cover"
                        >
                    </div>

                    {{-- Info Teks --}}
                    <div>
                        <h2 class="lg:text-2xl text-1xl font-semibold">
                            {{ $toko->nama_toko }}
                        </h2>

                        {{-- Rating & Total Terjual --}}
                        <div class="flex items-center gap-3 mt-2 text-sm text-zinc-600">
                            <div class="flex items-center gap-1">
                                <i class="bi bi-star-fill text-yellow-400 text-xl"></i>
                                <span>4.8</span> {{-- Rating Toko (Masih statis) --}}
                            </div>
                            <span>|</span>
                            
                            {{-- 👇 TAMPILKAN TOTAL TERJUAL DINAMIS DI SINI 👇 --}}
                            <span class="font-medium">{{ number_format($totalTerjualToko, 0, ',', '.') }} Terjual</span>
                        </div>

                        <button 
                            class="mt-4 bg-white text-[#00795E] border-2 border-[#00795E] 
                                   lg:px-4 lg:py-2 px-3 py-1 rounded-lg hover:bg-[#00795E] hover:text-white 
                                   transition cursor-pointer lg:font-medium text-sm">
                            Kunjungi Toko
                        </button>
                    </div>
                </div>

                {{-- Pembatas (Desktop) --}}
                <div class="hidden lg:block border-l-2 border-zinc-100 h-24"></div>

                {{-- Lokasi --}}
                <div class=" flex-col justify-center mt-6 lg:mt-0 lg:flex hidden">
                    <span class="flex items-center gap-2">
                        <i class="bi bi-geo-alt-fill text-1xl text-zinc-500"></i>
                        <p class="text-zinc-500">Lokasi</p>
                    </span>
                    {{-- Lokasi statis, bisa ditambahkan kolom 'kota' di tabel toko nanti --}}
                    <p class="font-semibold text-lg mt-2">Bandung, Jawa Barat</p>
                    <p class="text-sm text-gray-600">bergabung {{ $toko->created_at ? $toko->created_at->diffForHumans() : '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Garis Bawah --}}
    <div class="border-2 border-zinc-100 bg-zinc-100 lg:h-4 h-2"></div>
</div>
@else
    {{-- Fallback jika toko tidak ditemukan (misal dihapus) --}}
    <div class="my-10 p-6 bg-gray-50 rounded-lg text-center border border-dashed border-gray-300">
        <p class="text-gray-500">Informasi toko tidak tersedia.</p>
    </div>
@endif