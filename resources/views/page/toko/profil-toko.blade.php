{{-- Memanggil layout Anda (Pastikan nama ini benar) --}}
<x-layout.layout-profile>

    {{-- Kolom Kanan Konten Form --}}
    <section class="md:col-span-3">

        {{-- FORM UTAMA EDIT TOKO --}}
        {{-- Perbaiki: action, method, enctype --}}
        {{-- Gunakan route('toko.update', $toko->id_toko) --}}
        <form method="POST" action="{{ route('toko.update', $toko->id_toko) }}" enctype="multipart/form-data">
            @csrf          {{-- Token Keamanan --}}
            @method('PUT') {{-- Method untuk Update (sesuaikan dengan route jika pakai PATCH) --}}

            <div class="bg-white text-gray-800 rounded-lg shadow p-6 md:p-8">
                <h1 class="text-2xl font-bold mb-6">Profil Toko</h1>
                <!-- Pesan Sukses -->
                @if (session('status'))
                    <div class="mb-4 rounded-md bg-green-100 p-4 text-sm font-medium text-green-700">
                        {{ session('status') }}
                    </div>
                @endif
                <!-- Pesan Error Validasi -->
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
                        <div>
                            <label for="nama_toko" class="block text-sm font-medium text-gray-700">Nama Toko <span class="text-red-500">*</span></label>
                            {{-- Tampilkan value lama --}}
                            <input type="text" id="nama_toko" name="nama_toko" value="{{ old('nama_toko', $toko->nama_toko) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('nama_toko') border-red-500 @enderror" />
                             @error('nama_toko') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Input Email Toko (Tidak ada di DB/Controller saat ini) --}}
                        {{-- <div>
                            <label for="email_toko" class="block text-sm font-medium text-gray-700">Email Toko:</label>
                            <input type="email" id="email_toko" name="email_toko" value="{{ old('email_toko', $toko->email_toko ?? '') }}" 
                                   placeholder="Masukkan email toko"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" />
                            @error('email_toko') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div> --}}

                        <div>
                            <label for="no_hp_toko" class="block text-sm font-medium text-gray-700">Nomor Telepon Toko <span class="text-red-500">*</span></label>
                            {{-- Perbaiki name & value --}}
                            <input type="text" id="no_hp_toko" name="no_hp_toko" value="{{ old('no_hp_toko', $toko->no_hp_toko) }}" required
                                   placeholder="Masukkan nomor telepon toko"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('no_hp_toko') border-red-500 @enderror" />
                             @error('no_hp_toko') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        
                        {{-- Input No Rekening --}}
                        <div>
                            <label for="no_rek" class="block text-sm font-medium text-gray-700">Nomor Rekening (Opsional)</label>
                            <input type="text" id="no_rek" name="no_rek" value="{{ old('no_rek', $toko->no_rek) }}" 
                                   placeholder="Untuk keperluan transaksi/pembayaran"
                                   class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('no_rek') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500">Misal: BCA 1234567890 a/n Nama Anda</p>
                            @error('no_rek') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Input Alamat Toko (Tidak ada di DB/Controller saat ini) --}}
                        {{-- <div>
                            <label for="alamat_toko" class="block text-sm font-medium text-gray-700">Alamat Toko:</label>
                            <textarea id="alamat_toko" name="alamat_toko" placeholder="Masukkan alamat lengkap toko" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('alamat_toko', $toko->alamat_toko ?? '') }}</textarea>
                             @error('alamat_toko') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div> --}}

                        {{-- Input Deskripsi Toko (Tidak ada di DB/Controller saat ini) --}}
                        {{-- <div>
                            <label for="deskripsi_toko" class="block text-sm font-medium text-gray-700">Deskripsi Toko:</label>
                            <textarea id="deskripsi_toko" name="deskripsi_toko" placeholder="Tuliskan deskripsi singkat tentang toko Anda" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('deskripsi_toko', $toko->deskripsi_toko ?? '') }}</textarea>
                            @error('deskripsi_toko') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div> --}}

                        <div class="pt-4">
                            <button type="submit"
                                    class="bg-blue-600 text-white py-2 px-5 rounded-lg font-semibold hover:bg-blue-700 transition-colors"> {{-- Ganti warna tombol --}}
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                    <!-- Akhir Bagian Kiri -->

                    <!-- Bagian Kanan Form (Logo Toko) -->
                    <div class="lg:col-span-1 flex flex-col items-center space-y-4 pt-8 lg:pt-0">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Logo Toko (Opsional)</label>

                        {{-- Preview Logo Toko --}}
                        <div id="logoPreview" class="w-40 h-40 bg-gray-200 rounded-full flex items-center justify-center border border-gray-300 overflow-hidden">
                             @if ($toko->logo_toko)
                                <img src="{{ asset('img/logotoko/' . $toko->logo_toko) }}" alt="Logo Toko" class="w-full h-full rounded-full object-cover">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                            @endif
                        </div>

                        <input type="file" name="logo_toko" id="logo_toko" accept="image/*"
                               class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer @error('logo_toko') border border-red-500 rounded-full p-1 @enderror" />
                        <p class="text-xs text-gray-500 text-center">Pilih gambar baru (JPG, PNG, maks 2MB).</p>
                        @error('logo_toko') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <!-- Akhir Bagian Kanan -->

                    <!-- Banner Toko -->
                    <div class="col-span-full space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Banner Toko (Opsional)</label>
                        
                        <!-- Preview Banner -->
                        <div id="bannerPreview" class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center border border-gray-300 overflow-hidden">
                            @if ($toko->banner_toko)
                                <img src="{{ asset('img/bannertoko/' . $toko->banner_toko) }}" alt="Banner Toko" class="w-full h-full object-cover">
                            @else
                                <span class="text-gray-500">Preview Banner</span>
                            @endif
                        </div>

                        <input type="file" name="banner_toko" id="banner_toko" accept="image/*"
                               class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer @error('banner_toko') border border-red-500 rounded-lg p-1 @enderror" />
                        <p class="text-xs text-gray-500">Pilih gambar baru (JPG, PNG, maks 2MB). Rekomendasi rasio 3:1.</p>
                        @error('banner_toko') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </form>
    </section>

    {{-- JavaScript untuk Preview Logo & Banner --}}
    @push('scripts') 
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Logo Preview Logic
            const logoInput = document.getElementById('logo_toko');
            const logoPreview = document.getElementById('logoPreview');
            const defaultLogoPreview = logoPreview.innerHTML; 

            if (logoInput && logoPreview) { 
                logoInput.addEventListener('change', function() {
                    handlePreview(this, logoPreview, defaultLogoPreview, true);
                });
            }

            // Banner Preview Logic
            const bannerInput = document.getElementById('banner_toko');
            const bannerPreview = document.getElementById('bannerPreview');
            const defaultBannerPreview = bannerPreview.innerHTML;

            if (bannerInput && bannerPreview) {
                bannerInput.addEventListener('change', function() {
                    handlePreview(this, bannerPreview, defaultBannerPreview, false);
                });
            }

            function handlePreview(input, previewElement, defaultPreviewHTML, isCircle) {
                const file = input.files[0];
                if (file) {
                    const validImageTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
                    if (!validImageTypes.includes(file.type)) {
                        alert('Format file tidak valid. Harap pilih JPG, PNG, atau WEBP.');
                        input.value = ''; 
                        previewElement.innerHTML = defaultPreviewHTML;
                        return;
                    }
                    if (file.size > 2 * 1024 * 1024) { // 2MB
                        alert('Ukuran file terlalu besar. Maksimal 2MB.');
                        input.value = ''; 
                        previewElement.innerHTML = defaultPreviewHTML;
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const circleClass = isCircle ? 'rounded-full' : '';
                        previewElement.innerHTML = `<img src="${e.target.result}" alt="Preview Baru" class="w-full h-full ${circleClass} object-cover">`;
                    }
                    reader.readAsDataURL(file);
                } else {
                    previewElement.innerHTML = defaultPreviewHTML;
                }
            }
        });
    </script>
    @endpush 

</x-layout.layout-profile>