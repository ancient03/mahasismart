{{-- Memanggil layout Anda (Pastikan nama ini benar) --}}
<x-layout.layout-profile>

    {{-- Kolom Kanan Konten Form --}}
    <section class="md:col-span-3">

        {{-- FORM UTAMA EDIT BARANG --}}
        {{-- 👇 PERBAIKI NAMA PARAMETER DI SINI ('barang' -> 'produk_saya') 👇 --}}
        <form method="POST" action="{{ route('produk-saya.update', ['produk-saya' => $barang->id_barang]) }}" enctype="multipart/form-data">
            @csrf          
            @method('PUT') 

            <div class="bg-white text-gray-800 rounded-lg shadow p-6 md:p-8">
                
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                   <h1 class="text-2xl font-bold">Edit Produk: {{ $barang->nama_barang }}</h1>
                   {{-- Link kembali ke daftar produk (nama route sudah benar) --}}
                   <a href="{{ route('produk-saya.index') }}" class="text-blue-600 hover:underline text-sm">
                       &laquo; Kembali ke Daftar Produk
                   </a>
                </div>

                <!-- Pesan Sukses/Error -->
                @if (session('status')) <div class="mb-4 rounded-md bg-green-100 p-4 text-sm font-medium text-green-700">{{ session('status') }}</div> @endif
                @if ($errors->any())
                    <div class="mb-4 rounded-md bg-red-100 p-4 text-sm font-medium text-red-700">
                        <strong>Ups! Ada yang salah.</strong>
                        <ul class="mt-2 list-inside list-disc">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- Bagian Kiri Form --}}
                    <div class="lg:col-span-2 space-y-4">
                        {{-- Nama Barang --}}
                        <div>
                            <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang <span class="text-red-500">*</span></label>
                            <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('nama_barang') border-red-500 @enderror" />
                             @error('nama_barang') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Kategori (Dropdown) --}}
                        <div>
                            <label for="id_kategori" class="block text-sm font-medium text-gray-700">Kategori <span class="text-red-500">*</span></label>
                            <select id="id_kategori" name="id_kategori" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('id_kategori') border-red-500 @enderror">
                                <option value="" disabled {{ old('id_kategori', $barang->id_kategori) ? '' : 'selected' }}>-- Pilih Kategori --</option>
                                @foreach($kategoriList as $kategori)
                                    <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori', $barang->id_kategori) == $kategori->id_kategori ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kategori') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Harga --}}
                        <div>
                            <label for="harga" class="block text-sm font-medium text-gray-700">Harga (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" id="harga" name="harga" value="{{ old('harga', $barang->harga) }}" required min="0"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('harga') border-red-500 @enderror">
                             @error('harga') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                    class="bg-blue-600 text-white py-2 px-5 rounded-lg font-semibold hover:bg-blue-700 transition-colors"> 
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                    <!-- Akhir Bagian Kiri -->

                    <!-- Bagian Kanan Form (Logo Toko) -->
                    <div class="lg:col-span-1 flex flex-col items-center space-y-4 pt-8 lg:pt-0">
                       {{-- ... (Kode upload foto tidak berubah) ... --}}
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Barang (Opsional)</label>
                        <div id="fotoPreview" class="w-40 h-40 bg-gray-200 rounded-md flex items-center justify-center border border-gray-300 overflow-hidden">
                            @if ($barang->foto_barang) <img src="{{ asset('img/fotobarang/' . $barang->foto_barang) }}" alt="Foto Barang Saat Ini" class="w-full h-full rounded-md object-cover">
                            @else <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            @endif
                        </div>
                        <input type="file" name="foto_barang" id="foto_barang" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer @error('foto_barang') border border-red-500 rounded-full p-1 @enderror" />
                        <p class="text-xs text-gray-500 text-center">Pilih gambar baru (JPG, PNG, maks 2MB).</p>
                        @error('foto_barang') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        @if ($barang->foto_barang)
                            <div class="flex items-center mt-2">
                                <input id="hapus_foto_barang" name="hapus_foto_barang" type="checkbox" value="1" class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
                                <label for="hapus_foto_barang" class="ml-2 block text-sm text-red-700">Hapus foto saat ini</label>
                            </div>
                        @endif
                    </div>
                    <!-- Akhir Bagian Kanan -->
                </div>
            </div>
        </form>

        <!-- Tombol Logout (TERPISAH DARI FORM EDIT) -->
        {{-- Anda mungkin ingin menghapus tombol logout dari halaman edit ini --}}
        {{-- <div class="bg-white text-gray-800 rounded-lg shadow p-6 md:p-8 mt-6"> ... </div> --}}
    </section>

    {{-- JavaScript untuk Preview Foto --}}
    @push('scripts') 
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoInput = document.getElementById('foto_barang'); // ID input file sudah benar 'foto_barang'
            const logoPreview = document.getElementById('fotoPreview');
            const defaultPreview = logoPreview.innerHTML; 
            const hapusCheckbox = document.getElementById('hapus_foto_barang');

            if (logoInput && logoPreview) { 
                logoInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const validImageTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
                        if (!validImageTypes.includes(file.type)) {
                            alert('Format file tidak valid. Harap pilih JPG, PNG, atau WEBP.');
                            this.value = ''; 
                            logoPreview.innerHTML = defaultPreview; 
                            return;
                        }
                        if (file.size > 2 * 1024 * 1024) { // 2MB
                             alert('Ukuran file terlalu besar. Maksimal 2MB.');
                            this.value = ''; 
                            logoPreview.innerHTML = defaultPreview;
                            return;
                        }
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            logoPreview.innerHTML = `<img src="${e.target.result}" alt="Preview Foto Barang Baru" class="w-full h-full rounded-md object-cover">`;
                            if (hapusCheckbox) {
                                hapusCheckbox.checked = false;
                            }
                        }
                        reader.readAsDataURL(file);
                    } else {
                        logoPreview.innerHTML = defaultPreview; 
                    }
                });
            }

            if (hapusCheckbox && logoInput && logoPreview) {
                hapusCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        fotoInput.value = ''; 
                        fotoPreview.innerHTML = `<div class="w-full h-full bg-gray-200 rounded-md flex items-center justify-center border border-gray-300"><svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg></div>`;
                    } else {
                         fotoPreview.innerHTML = defaultPreview;
                    }
                });
            }

        });
    </script>
    @endpush 

</x-layout.layout-profile>

