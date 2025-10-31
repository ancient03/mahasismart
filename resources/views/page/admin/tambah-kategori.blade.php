<x-layout.layout-admin>
    <section class="md:col-span-3">
        {{-- Header --}}
        <div class="py-3 px-5 flex justify-between items-center lg:rounded-md shadow-md bg-white mb-10">
            <h1 class="lg:text-2xl text-1xl font-semibold">Tambah Kategori</h1>
        </div>

        {{-- Form Tambah Kategori --}}
        <div class="border border-gray-200 bg-white shadow-md px-6 py-6 rounded-md w-full">
            <form action="{{ route('admin.kategori.store') }}" method="POST" enctype="multipart/form-data"
                class="flex justify-between items-start gap-10">
                @csrf

                <!-- Kiri: Input Nama Kategori -->
                <div class="w-1/2">
                    <label for="nama_kategori" class="block text-gray-800 font-semibold mb-2">
                        Nama Kategori:
                    </label>
                    <input type="text" id="nama_kategori" name="nama_kategori" placeholder="Masukkan nama kategori..."
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-black focus:border-black focus:outline-none"
                        required />

                    <button type="submit"
                        class="mt-6 bg-black text-white px-6 py-2 rounded-md ring-2 ring-black hover:bg-gray-900 transition duration-300">
                        Save
                    </button>
                </div>

                <!-- Kanan: Upload & Preview Gambar -->
                <div class="flex flex-col items-center">
                    <!-- Preview Image -->
                    <div id="preview-container"
                        class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center border border-gray-400 mb-3 overflow-hidden">
                        <i class="bi bi-image text-4xl text-gray-500" id="icon-preview"></i>
                        <img id="image-preview" src="" alt="Preview" class="hidden object-cover w-full h-full" />
                    </div>

                    <label for="gambar"
                        class="cursor-pointer bg-gray-300 text-gray-800 px-4 py-1.5 rounded-md hover:bg-gray-400 transition">
                        Pilih Gambar
                    </label>
                    <input type="file" id="gambar" name="gambar" class="hidden" accept="image/*" required />
                </div>
            </form>
        </div>

        {{-- Script Preview Gambar --}}
        <script>
            document.getElementById('gambar').addEventListener('change', function (event) {
                const file = event.target.files[0];
                const preview = document.getElementById('image-preview');
                const icon = document.getElementById('icon-preview');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        icon.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.src = '';
                    preview.classList.add('hidden');
                    icon.classList.remove('hidden');
                }
            });
        </script>

    </section>
</x-layout.layout-admin>
