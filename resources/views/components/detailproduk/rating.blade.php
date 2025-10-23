<div>
    {{-- Judul --}}
    <h1 class="text-xl lg:text-2xl font-semibold">Penilaian Produk</h1>

    {{-- Jumlah dan Filter --}}
    <div class="p-6 bg-zinc-100 rounded-lg flex flex-col lg:flex-row lg:items-center mt-6 gap-8">
        {{-- Bagian Rating + Dropdown (mobile) --}}
        <div class="w-full flex justify-between items-center lg:block lg:w-auto">
            {{-- Rating --}}
            <div class="text-center">
                <h1 class="text-2xl lg:text-4xl font-bold">
                    <span>4.5</span>
                    <span class="text-base lg:text-xl font-normal">dari</span>
                    <span>5</span>
                </h1>
                <div class="flex items-center gap-1 lg:gap-3 mt-1 lg:mt-2">
                    <i class="bi bi-star-fill text-yellow-400 text-xl lg:text-3xl"></i>
                    <i class="bi bi-star-fill text-yellow-400 text-xl lg:text-3xl"></i>
                    <i class="bi bi-star-fill text-yellow-400 text-xl lg:text-3xl"></i>
                    <i class="bi bi-star-fill text-yellow-400 text-xl lg:text-3xl"></i>
                    <i class="bi bi-star-fill text-yellow-400 text-xl lg:text-3xl"></i>
                </div>
            </div>

            {{-- Dropdown (mobile) --}}
            <div class="block lg:hidden w-1/2">
                <select
                    class="w-full p-2 rounded-md bg-zinc-200 border border-zinc-300 cursor-pointer text-sm focus:ring-2 focus:ring-[#00795E] focus:outline-none"
                >
                    <option value="all">Semua</option>
                    <option value="5">5 Bintang (10)</option>
                    <option value="4">4 Bintang (12)</option>
                    <option value="3">3 Bintang (21)</option>
                    <option value="2">2 Bintang (10)</option>
                    <option value="1">1 Bintang (2)</option>
                    <option value="gambar">Dengan Gambar</option>
                    <option value="komentar">Dengan Komentar</option>
                </select>
            </div>
        </div>

        {{-- Tombol (desktop) --}}
        <div class="hidden lg:flex flex-wrap gap-4 p-2 justify-start">
            <button class="py-2 px-4 bg-zinc-200 shadow rounded-lg hover:bg-zinc-100 transition cursor-pointer">Semua</button>
            <button class="py-2 px-4 bg-zinc-200 shadow rounded-lg hover:bg-zinc-100 transition cursor-pointer">5 Bintang <span>(10)</span></button>
            <button class="py-2 px-4 bg-zinc-200 shadow rounded-lg hover:bg-zinc-100 transition cursor-pointer">4 Bintang <span>(12)</span></button>
            <button class="py-2 px-4 bg-zinc-200 shadow rounded-lg hover:bg-zinc-100 transition cursor-pointer">3 Bintang <span>(21)</span></button>
            <button class="py-2 px-4 bg-zinc-200 shadow rounded-lg hover:bg-zinc-100 transition cursor-pointer">2 Bintang <span>(10)</span></button>
            <button class="py-2 px-4 bg-zinc-200 shadow rounded-lg hover:bg-zinc-100 transition cursor-pointer">1 Bintang <span>(2)</span></button>
            <button class="py-2 px-4 bg-zinc-200 shadow rounded-lg hover:bg-zinc-100 transition cursor-pointer">Dengan Gambar</button>
            <button class="py-2 px-4 bg-zinc-200 shadow rounded-lg hover:bg-zinc-100 transition cursor-pointer">Dengan Komentar</button>
        </div>
    </div>
</div>
