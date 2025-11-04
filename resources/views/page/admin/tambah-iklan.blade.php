<x-layout.layout-admin>
    <section class="md:col-span-3">

        {{-- Header --}}
        <div class="py-3 px-5 flex justify-between items-center lg:rounded-md shadow-md bg-white mb-6">
            <h1 class="lg:text-2xl text-xl font-semibold text-gray-800">Tambah Iklan</h1>
            <a href="{{ route('admin.iklan') }}"
                class="bg-black text-white flex items-center gap-2 px-5 py-2 rounded-md hover:bg-gray-800 transition duration-300 font-medium">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
        </div>

        {{-- form iklan --}}
        {{-- form iklan --}}
        {{-- form iklan --}}
        <div class="py-6 px-6 shadow-xl rounded-lg border border-zinc-200 hover:shadow-2xl transition duration-300">
            <form action="#" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">

                <!-- Nama Iklan & Slogan -->
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-gray-700 font-medium mb-1">Nama Iklan</label>
                        <input type="text" name="nama_iklan"
                            class="w-full border border-zinc-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 font-medium mb-1">Slogan</label>
                        <input type="text" name="slogan"
                            class="w-full border border-zinc-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="5"
                        class="w-full border border-zinc-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <!-- Dimulai & Berakhir -->
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-gray-700 font-medium mb-1">Dimulai</label>
                        <input type="datetime-local" name="dimulai"
                            class="w-full border border-zinc-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 font-medium mb-1">Berakhir</label>
                        <input type="datetime-local" name="berakhir"
                            class="w-full border border-zinc-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Preview Gambar -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Preview Gambar</label>
                    <img src="{{ asset('img/baner.png') }}" alt="Banner Preview"
                        class="w-full h-48 object-cover rounded-md border border-zinc-300 mb-2">
                </div>

                <!-- Input Gambar -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Gambar</label>
                    <input type="file" name="gambar"
                        class="w-full border border-zinc-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Button -->
                <div class="mt-4">
                    <button type="submit"
                        class="bg-black text-white px-6 py-2 rounded-md hover:bg-gray-800 transition duration-300 font-medium">
                        Buat Iklan
                    </button>
                </div>

            </form>
        </div>
    </section>
</x-layout.layout-admin>
