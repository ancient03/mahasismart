<x-layout.layout-admin>
    <section class="md:col-span-3">

        {{-- Header --}}
        <div class="py-3 px-5 flex justify-between items-center lg:rounded-md shadow-md bg-white mb-6">
            <h1 class="lg:text-2xl text-1xl font-semibold">Daftar Kategori</h1>
            <a href="{{ route('admin.tambah-kategori') }}"
                class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 transition">
                + Tambah Kategori
            </a>
        </div>

        {{-- Notifikasi --}}
        @if (session('status'))
            <div class="mb-4 rounded-md bg-green-100 p-4 text-sm font-medium text-green-700">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-100 p-4 text-sm font-medium text-red-700">
                <strong>Ups! Ada yang salah.</strong>
                <ul class="mt-2 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Daftar Kategori --}}
        @forelse ($kategori as $item)
            <div class="py-3 px-5 mb-4 flex items-center justify-between rounded-md shadow-md bg-white">
                <div class="flex gap-4 items-center">
                    {{-- Foto kategori --}}
                    <div
                        class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center border border-gray-300 overflow-hidden">
                        @if ($item->gambar && file_exists(public_path($item->gambar)))
                            <img src="{{ asset($item->gambar) }}" alt="{{ $item->nama_kategori }}"
                                class="object-cover w-full h-full">
                        @else
                            <i class="bi bi-image text-3xl text-gray-400"></i>
                        @endif
                    </div>

                    {{-- Info kategori --}}
                    <div>
                        <p class="font-semibold text-lg">{{ $item->nama_kategori }}</p>
                        <p class="text-sm text-gray-600"><span>{{ $item->barang_count }}</span> Produk</p>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.kategori.edit', $item->id_kategori) }}"
                        class="bg-blue-600 text-white py-2 px-3 flex items-center gap-2 rounded-md shadow-md hover:bg-blue-700 transition duration-300 cursor-pointer">
                        <i class="bi bi-pencil-square"></i>
                        <span>Edit</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-10">
                Belum ada kategori.
            </div>
        @endforelse

    </section>
</x-layout.layout-admin>
