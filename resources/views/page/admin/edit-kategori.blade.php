<x-layout.layout-admin>
    <section class="md:col-span-3">
        {{-- Header --}}
        <div class="py-3 px-5 flex justify-between items-center lg:rounded-md shadow-md bg-white mb-10">
            <h1 class="lg:text-2xl text-1xl font-semibold">Edit Kategori</h1>
        </div>

        {{-- Form Edit Kategori --}}
        <div class="border border-gray-200 bg-white shadow-md px-6 py-6 rounded-md w-full">
            <form action="{{ route('admin.kategori.update', $kategori->id_kategori) }}" method="POST" enctype="multipart/form-data"
                class="flex justify-between items-start gap-10">
                @csrf
                @method('PUT')

                <!-- Kiri: Input Nama Kategori -->
                <div class="w-1/2">
                    <label for="nama_kategori" class="block text-gray-800 font-semibold mb-2">
                        Nama Kategori:
                    </label>
                    <input type="text" id="nama_kategori" name="nama_kategori"
                        value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                        placeholder="Masukkan nama kategori..."
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-black focus:border-black focus:outline-none"
                        required />

                    <button type="submit"
                        class="mt-6 bg-black text-white px-6 py-2 rounded-md ring-2 ring-black hover:bg-gray-900 transition duration-300">
                        Update
                    </button>
                </div>

                <!-- Kanan: Upload Gambar -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-32 h-32 rounded-md bg-gray-200 flex items-center justify-center border border-gray-400 mb-3 overflow-hidden">
                        @if ($kategori->gambar && file_exists(public_path($kategori->gambar)))
                            <img src="{{ asset($kategori->gambar) }}" alt="{{ $kategori->nama_kategori }}"
                                class="object-cover w-full h-full">
                        @else
                            <i class="bi bi-image text-4xl text-gray-500"></i>
                        @endif
                    </div>

                    <label for="gambar"
                        class="cursor-pointer bg-gray-300 text-gray-800 px-4 py-1.5 rounded-md hover:bg-gray-400 transition">
                        Ganti Gambar
                    </label>
                    <input type="file" id="gambar" name="gambar" class="hidden" accept="image/*" />
                </div>
            </form>
        </div>

    </section>
</x-layout.layout-admin>
