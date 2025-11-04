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

        {{-- Form Tambah Iklan --}}
        <div class="py-6 px-6 shadow-xl rounded-lg border border-zinc-200 hover:shadow-2xl transition duration-300">
            <form action="{{ route('admin.store-iklan') }}" method="POST" enctype="multipart/form-data"
                class="flex flex-col gap-4">
                @csrf

                <!-- Nama Iklan & Slogan -->
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-gray-700 font-medium mb-1">Nama Iklan</label>
                        <input type="text" name="nama_iklan" required
                            class="w-full border border-zinc-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 font-medium mb-1">Slogan</label>
                        <input type="text" name="slogan"
                            class="w-full border border-zinc-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="4"
                        class="w-full border border-zinc-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required></textarea>
                </div>

                <!-- Dimulai & Berakhir -->
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-gray-700 font-medium mb-1">Dimulai</label>
                        <input type="datetime-local" name="dimulai" required
                            class="w-full border border-zinc-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 font-medium mb-1">Berakhir</label>
                        <input type="datetime-local" name="berakhir" required
                            class="w-full border border-zinc-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Upload + Preview Gambar -->
                <div class="flex flex-col">
                    <label class="block text-gray-700 font-medium mb-2">Gambar</label>

                    {{-- Area preview / upload --}}
                    <div id="preview-area"
                        class="w-full h-64 border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center cursor-pointer hover:border-blue-400 transition relative bg-gray-50 overflow-hidden">

                        {{-- Placeholder ikon + teks --}}
                        <div id="placeholder" class="flex flex-col items-center text-gray-500">
                            <i class="bi bi-image fs-1 text-4xl mb-2"></i>
                            <p class="font-medium">Tambah Gambar</p>
                            <p class="text-sm text-gray-400">Klik di sini untuk memilih file</p>
                        </div>

                        {{-- Preview gambar --}}
                        <img id="preview-img" src="" alt="Preview"
                            class="hidden w-full h-full object-cover rounded-lg absolute top-0 left-0">
                    </div>

                    {{-- Input file tersembunyi --}}
                    <input type="file" name="gambar" id="gambar" accept="image/*" class="hidden" required>
                </div>

                <!-- Tombol Submit -->
                <div class="mt-4">
                    <button type="submit"
                        class="bg-black text-white px-6 py-2 rounded-md hover:bg-gray-800 transition duration-300 font-medium">
                        Buat Iklan
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{-- Script Preview --}}
    <script>
        const previewArea = document.getElementById('preview-area');
        const fileInput = document.getElementById('gambar');
        const previewImg = document.getElementById('preview-img');
        const placeholder = document.getElementById('placeholder');

        // Klik area → buka file picker
        previewArea.addEventListener('click', () => fileInput.click());

        // Saat pilih gambar → tampilkan preview
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-layout.layout-admin>
