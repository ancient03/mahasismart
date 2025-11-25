@props(['avgRating' => 0, 'totalRating' => 0])

<div>
    {{-- Judul --}}
    <h1 class="text-xl lg:text-2xl font-semibold">Penilaian Produk</h1>

    {{-- Jumlah dan Filter --}}
    <div class="p-6 bg-zinc-100 rounded-lg flex flex-col lg:flex-row lg:items-center mt-6 gap-8">
        
        {{-- Bagian Rating + Dropdown (mobile) --}}
        <div class="w-full flex justify-between items-center lg:block lg:w-auto">
            {{-- Rating (Dinamis) --}}
            <div class="text-center">
                <h1 class="text-2xl lg:text-4xl font-bold">
                    <span>{{ number_format($avgRating, 1) }}</span>
                    <span class="text-base lg:text-xl font-normal">dari</span>
                    <span>5</span>
                </h1>
                <div class="flex items-center justify-center gap-1 lg:gap-3 mt-1 lg:mt-2 text-yellow-400">
                    {{-- Logika Bintang (Penuh, Setengah, Kosong) --}}
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($avgRating >= $i)
                            <i class="bi bi-star-fill text-xl lg:text-3xl"></i>
                        @elseif ($avgRating >= $i - 0.5)
                            <i class="bi bi-star-half text-xl lg:text-3xl"></i>
                        @else
                            <i class="bi bi-star text-xl lg:text-3xl text-gray-400"></i>
                        @endif
                    @endfor
                </div>
                <p class="text-sm text-gray-500 mt-2">{{ $totalRating }} Ulasan</p>
            </div>

            {{-- Dropdown (mobile) --}}
            <div class="block lg:hidden w-1/2">
                <select class="w-full p-2 rounded-md bg-zinc-200 border border-zinc-300 cursor-pointer text-sm focus:ring-2 focus:ring-[#00795E] focus:outline-none">
                    <option value="all">Semua</option>
                    <option value="5">5 Bintang</option>
                    <option value="4">4 Bintang</option>
                    <option value="3">3 Bintang</option>
                    <option value="2">2 Bintang</option>
                    <option value="1">1 Bintang</option>
                </select>
            </div>
        </div>

        {{-- Tombol Filter (desktop - UI Saja) --}}
        <div class="hidden lg:flex flex-wrap gap-4 p-2 justify-start">
            <button class="py-2 px-4 bg-white border border-green-600 text-green-700 shadow rounded-lg transition cursor-pointer font-medium">Semua</button>
            <button class="py-2 px-4 bg-white border border-gray-300 shadow rounded-lg hover:bg-gray-50 transition cursor-pointer">5 Bintang</button>
            <button class="py-2 px-4 bg-white border border-gray-300 shadow rounded-lg hover:bg-gray-50 transition cursor-pointer">4 Bintang</button>
            <button class="py-2 px-4 bg-white border border-gray-300 shadow rounded-lg hover:bg-gray-50 transition cursor-pointer">3 Bintang</button>
            <button class="py-2 px-4 bg-white border border-gray-300 shadow rounded-lg hover:bg-gray-50 transition cursor-pointer">2 Bintang</button>
            <button class="py-2 px-4 bg-white border border-gray-300 shadow rounded-lg hover:bg-gray-50 transition cursor-pointer">1 Bintang</button>
            <button class="py-2 px-4 bg-white border border-gray-300 shadow rounded-lg hover:bg-gray-50 transition cursor-pointer">Dengan Gambar</button>
            <button class="py-2 px-4 bg-white border border-gray-300 shadow rounded-lg hover:bg-gray-50 transition cursor-pointer">Dengan Komentar</button>
        </div>
    </div>
</div>