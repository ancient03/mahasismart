{{-- Memanggil layout Anda (Pastikan nama ini benar) --}}
<x-layout.layout-profile>

    {{-- Kolom Kanan Konten Form (Ini akan masuk ke $slot layout Anda) --}}
    <section class="md:col-span-3">
        
        {{-- FORM UTAMA TAMBAH BARANG --}}
        <form method="POST" action="{{ route('produk-saya.store') }}" enctype="multipart/form-data">
            @csrf {{-- Token Keamanan --}}

            <div class="bg-white text-gray-800 rounded-lg shadow p-6 md:p-8">
                
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                   <h1 class="text-2xl font-bold">Tambah Produk Baru</h1>
                   {{-- Link kembali ke daftar produk --}}
                   <a href="{{ route('produk-saya.index') }}" class="text-blue-600 hover:underline text-sm">
                       &laquo; Kembali ke Daftar Produk
                   </a>
                </div>

                <!-- Menampilkan pesan Error Validasi -->
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

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- Bagian Kiri Form --}}
                    <div class="lg:col-span-2 space-y-4">
                        
                        {{-- Nama Barang --}}
                        <div>
                            <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang <span class="text-red-500">*</span></label>
                            <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" required
                                   placeholder="Masukkan nama produk Anda"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('nama_barang') border-red-500 @enderror">
                            @error('nama_barang') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Kategori (Dropdown) --}}
                        <div>
                            <label for="id_kategori" class="block text-sm font-medium text-gray-700">Kategori <span class="text-red-500">*</span></label>
                            <select id="id_kategori" name="id_kategori" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('id_kategori') border-red-500 @enderror">
                                <option value="" disabled {{ old('id_kategori') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                                {{-- Loop kategori dari controller ($kategoriList) --}}
                                @foreach($kategoriList as $kategori)
                                    <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kategori') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        
                        {{-- Harga --}}
                        <div>
                            <label for="harga" class="block text-sm font-medium text-gray-700">Harga (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" id="harga" name="harga" value="{{ old('harga') }}" required min="0"
                                   placeholder="Masukkan harga produk (angka saja)"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('harga') border-red-500 @enderror">
                             @error('harga') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="pt-4">
                            <button type="submit" class="bg-green-600 text-white py-2 px-5 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                                Simpan Produk
                            </button>
                        </div>
                    </div> 
                    {{-- Akhir Bagian Kiri Form --}}

                    {{-- Bagian Kanan Form (Foto Barang) --}}
                    <div class="lg:col-span-1 flex flex-col items-center space-y-4 pt-8 lg:pt-0">
                        
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Barang (Opsional)</label>
                        
                        {{-- Preview Foto --}}
                        <div id="fotoPreview" class="w-40 h-40 bg-gray-200 rounded-md flex items-center justify-center border border-gray-300 overflow-hidden">
                            {{-- Placeholder Awal --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        
                        {{-- Input File --}}
                        <input type="file" name="foto_barang" id="foto_barang" accept="image/*" 
                               class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer @error('foto_barang') border border-red-500 rounded-full p-1 @enderror">
                        <p class="text-xs text-gray-500 text-center">Pilih foto produk (JPG, PNG, maks 2MB).</p>
                         @error('foto_barang') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        
                    </div> 
                    {{-- Akhir Bagian Kanan Form --}}

                </div> {{-- Akhir Grid Internal --}}

            </div> {{-- Akhir Card Putih --}}
            
        </form> {{-- AKHIR FORM UTAMA --}}

    </section>

    {{-- JavaScript untuk Preview Foto (pastikan layout utama punya @stack('scripts')) --}}
    @push('scripts') 
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fotoInput = document.getElementById('foto_barang');
            const fotoPreview = document.getElementById('fotoPreview');
            const defaultPlaceholder = fotoPreview.innerHTML; // Simpan placeholder awal

            if (fotoInput && fotoPreview) { 
                fotoInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        // Validasi sisi klien (opsional tapi bagus)
                        const validImageTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
                        if (!validImageTypes.includes(file.type)) {
                            alert('Format file tidak valid. Harap pilih JPG, PNG, atau WEBP.');
                            this.value = ''; // Reset input file
                            fotoPreview.innerHTML = defaultPlaceholder; // Kembalikan placeholder
                            return;
                        }
                        if (file.size > 2 * 1024 * 1024) { // 2MB
                             alert('Ukuran file terlalu besar. Maksimal 2MB.');
                            this.value = ''; 
                            fotoPreview.innerHTML = defaultPlaceholder;
                            return;
                        }
                        
                        // Tampilkan preview
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            fotoPreview.innerHTML = `<img src="${e.target.result}" alt="Preview Foto Barang" class="w-full h-full rounded-md object-cover">`;
                        }
                        reader.readAsDataURL(file);
                    } else {
                        // Kembalikan ke placeholder jika tidak ada file dipilih
                        fotoPreview.innerHTML = defaultPlaceholder; 
                    }
                });
            }
        });
    </script>
    @endpush 

</x-layout.layout-profile>

