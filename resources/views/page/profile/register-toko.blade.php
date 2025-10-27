{{-- Memanggil layout profil Anda --}}
<x-layout.layout-profile>

    {{-- Kolom Kanan Konten Form (Ini akan masuk ke $slot layout Anda) --}}
    <section class="md:col-span-3">

        {{-- FORM UTAMA REGISTER TOKO --}}
        {{-- Perbaiki: action, tambahkan method="POST", enctype --}}
        <form method="POST" action="{{ route('register.toko.create') }}" enctype="multipart/form-data"> 
            @csrf {{-- Token Keamanan --}}

            {{-- Card Putih Pembungkus (Struktur Anda) --}}
            <div class="bg-white text-gray-800 rounded-lg shadow p-6 md:p-8">
                
                <h1 class="text-2xl font-bold mb-6">Register Toko</h1>

                <!-- Pesan Sukses -->
                @if (session('status'))
                    <div class="mb-4 rounded-md bg-green-100 p-4 text-sm font-medium text-green-700">
                        {{ session('status') }}
                    </div>
                @endif
                <!-- Pesan Error Khusus -->
                 @if (session('error')) 
                    <div class="mb-4 rounded-md bg-red-100 p-4 text-sm font-medium text-red-700">
                        {{ session('error') }}
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

                    {{-- Bagian Kiri Form (Data Toko) --}}
                    <div class="lg:col-span-5 space-y-4">
                        {{-- No. Handphone Toko (Perbaiki name) --}}
                        <div>
                            <label for="no_hp_toko" class="block text-sm font-medium text-gray-700">No. Handphone Toko <span class="text-red-500">*</span></label>
                            <input type="text" id="no_hp_toko" name="no_hp_toko" value="{{ old('no_hp_toko') }}" required
                                   placeholder="Masukkan nomor handphone toko"
                                   class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('no_hp_toko') border-red-500 @enderror">
                            @error('no_hp_toko') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                                    <label for="email_mahasiswa" class="block text-sm font-medium text-gray-700">Email Mahasiswa <span class="text-red-500">*</span></label>
                                    <input type="email" id="email_mahasiswa" name="email_mahasiswa" value="{{ old('email_mahasiswa', Auth::user()->email_mahasiswa) }}" required {{-- Tampilkan email lama jika sudah ada --}}
                                           placeholder="Masukkan email kampus Anda (jika ada)"
                                           class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('email_mahasiswa') border-red-500 @enderror">
                                    <p class="mt-1 text-xs text-gray-500">Email ini akan disimpan di profil Anda.</p>
                                    @error('email_mahasiswa') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        
                        {{-- Nama Toko (name sudah benar) --}}
                        <div>
                            <label for="nama_toko" class="block text-sm font-medium text-gray-700">Nama Toko <span class="text-red-500">*</span></label>
                            <input type="text" id="nama_toko" name="nama_toko" value="{{ old('nama_toko') }}" required
                                   placeholder="Masukkan nama toko unik"
                                   class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('nama_toko') border-red-500 @enderror">
                             @error('nama_toko') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        
                        {{-- Hapus Input Password --}}
                        {{-- <div> ... Password ... </div> --}}
                        
                        {{-- Hapus Input Konfirmasi Password --}}
                        {{-- <div> ... Konfirmasi Password ... </div> --}}

                        {{-- Tombol Register --}}
                        <div class="pt-4">
                            <button type="submit" class="bg-gray-700 text-white py-2 px-5 rounded-lg font-semibold hover:bg-gray-800 transition-colors">
                                Register Toko
                            </button>
                        </div>
                    </div> 
                    {{-- Akhir Bagian Kiri Form --}}


                </div> {{-- Akhir Grid Internal --}}

            </div> {{-- Akhir Card Putih --}}
            
        </form> {{-- AKHIR FORM UTAMA --}}

    </section>

    {{-- JavaScript (Taruh sebelum </body> di layout utama jika belum ada) --}}
    @push('scripts') 
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hapus JS Toggle Password karena inputnya dihapus

            // Preview Logo Toko
            const logoInput = document.getElementById('logo_toko');
            const logoPreview = document.getElementById('logoPreview');
            const defaultSvg = `<svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>`;

            if (logoInput && logoPreview) { 
                logoInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const validImageTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
                        if (!validImageTypes.includes(file.type)) {
                            alert('Format file tidak valid. Harap pilih JPG, PNG, atau WEBP.');
                            this.value = ''; 
                            logoPreview.innerHTML = defaultSvg; 
                            return;
                        }
                        if (file.size > 2 * 1024 * 1024) { // 2MB
                             alert('Ukuran file terlalu besar. Maksimal 2MB.');
                            this.value = ''; 
                            logoPreview.innerHTML = defaultSvg; 
                            return;
                        }
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            logoPreview.innerHTML = `<img src="${e.target.result}" alt="Preview Logo" class="w-full h-full rounded-full object-cover">`;
                        }
                        reader.readAsDataURL(file);
                    } else {
                        logoPreview.innerHTML = defaultSvg; 
                    }
                });
            }
        });
    </script>
    @endpush 

</x-layout.layout-profile>

