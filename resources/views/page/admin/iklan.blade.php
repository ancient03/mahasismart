<x-layout.layout-admin>
    <section class="md:col-span-3">

        {{-- Header --}}
        <div class="py-3 px-5 flex justify-between items-center lg:rounded-md shadow-md bg-white mb-6">
            <h1 class="lg:text-2xl text-xl font-semibold text-gray-800">Daftar Iklan</h1>
            <a href="{{ route('admin.tambah-iklan') }}"
                class="bg-black text-white px-5 py-2 rounded-md hover:bg-gray-800 transition duration-300 font-medium">
                + Tambah Iklan
            </a>
        </div>

        {{-- Iklan Card --}}
        <div class="py-4 px-4 shadow-xl rounded-lg border border-zinc-200 hover:shadow-2xl transition duration-300">
            <div class="flex gap-6">
                {{-- Gambar --}}
                <div class="relative flex-shrink-0">
                    {{-- edit --}}
                    <a href="{{ route('admin.edit-iklan') }}"
                        class="absolute top-3 left-3 flex items-center justify-center bg-white rounded-full py-2 px-3 shadow-md border border-zinc-300 hover:bg-blue-600 hover:text-white transition duration-300">
                        <i class="bi bi-pencil-square text-base"></i>
                    </a>
                    {{-- hapus --}}
                    <a href=""
                        class="absolute top-3 left-14 flex items-center justify-center bg-white rounded-full py-2 px-3 shadow-md border border-zinc-300 hover:bg-red-600 hover:text-white transition duration-300">
                        <i class="bi bi-trash text-base"></i>
                    </a>
                    <img src="{{ asset('img/baner.png') }}" alt=""
                        class="h-[150px] w-96 object-cover rounded-lg shadow-md border border-zinc-100">
                </div>

                {{-- Konten --}}
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-800">Nama Promo</h1>
                        <h3 class="font-medium text-zinc-500 mt-1">Slogan</h3>
                        <p class="mt-2 text-gray-700 line-clamp-2">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Labore ullam consectetur totam
                            reprehenderit aliquid in eius odio aliquam itaque! Et ut corporis iure enim suscipit nulla
                            illo rerum voluptatem...
                        </p>
                    </div>
                    <div class="mt-4 flex gap-2 text-sm text-gray-500">
                        <div class="flex items-center gap-1">
                            <i class="bi bi-calendar4"></i>
                            <p>31/10/2025</p>
                        </div>

                        <span>-</span>

                        <div class="flex items-center gap-1">
                            <i class="bi bi-calendar-check"></i>
                            <p>5/11/2025</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>
</x-layout.layout-admin>
