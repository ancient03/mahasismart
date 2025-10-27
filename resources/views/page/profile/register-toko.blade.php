{{-- Ganti ini dengan layout utama Anda yg benar --}}
<x-layout.layout-profile>

    {{-- Kolom Kanan Konten Profil --}}
    <section class="md:col-span-3">

        {{-- FORM UTAMA REGISTER TOKO --}}
        <form method="POST" action="{{ route('register.toko') }}">
            @csrf

            {{-- Card Putih Pembungkus --}}
            <div class="bg-white text-gray-800 rounded-lg shadow p-6 md:p-8">
                
                <h1 class="text-2xl font-bold mb-6">Register Toko</h1>

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

                    {{-- Bagian Kiri Form (Data Toko) --}}
                    <div class="lg:col-span-2 space-y-4">
                        {{-- No. Handphone --}}
                        <div>
                            <label for="no_hp" class="block text-sm font-medium text-gray-700">No. Handphone:</label>
                            <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" 
                                   placeholder="Masukkan nomor handphone"
                                   class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>
                        
                        {{-- Email Mahasiswa --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Mahasiswa:</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="Masukkan email mahasiswa"
                                   class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>
                        
                        {{-- Nama Toko --}}
                        <div>
                            <label for="nama_toko" class="block text-sm font-medium text-gray-700">Nama Toko:</label>
                            <input type="text" id="nama_toko" name="nama_toko" value="{{ old('nama_toko') }}" 
                                   placeholder="Masukkan nama toko"
                                   class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>
                        
                        {{-- Password --}}
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                            <div class="relative mt-1">
                                <input type="password" id="password" name="password" 
                                       placeholder="Buat password"
                                       class="px-4 py-2 pr-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <button type="button" 
                                        id="togglePasswordBtn"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                                    <i id="togglePasswordIcon" class="bi bi-eye-slash text-gray-500 hover:text-gray-700"></i>
                                </button>
                            </div>
                        </div>
                        
                        {{-- Konfirmasi Password --}}
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password:</label>
                            <div class="relative mt-1">
                                <input type="password" id="password_confirmation" name="password_confirmation" 
                                       placeholder="Konfirmasi password"
                                       class="px-4 py-2 pr-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <button type="button" 
                                        id="togglePasswordConfirmBtn"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                                    <i id="togglePasswordConfirmIcon" class="bi bi-eye-slash text-gray-500 hover:text-gray-700"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Tombol Register --}}
                        <div class="pt-4">
                            <button type="submit" class="bg-gray-700 text-white py-2 px-5 rounded-lg font-semibold hover:bg-gray-800 transition-colors">
                                Register Toko
                            </button>
                        </div>
                    </div> 
                    {{-- Akhir Bagian Kiri Form --}}

                    {{-- Bagian Kanan Form (Logo Toko) --}}
                    <div class="lg:col-span-1 flex flex-col items-center space-y-4 pt-8 lg:pt-0">
                        
                        <label class="block text-sm font-medium text-gray-700 mb-2">Logo Toko</label>
                        
                        {{-- Preview Logo Toko --}}
                        <div id="logoPreview" class="w-40 h-40 bg-gray-200 rounded-full flex items-center justify-center border border-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        
                        {{-- Input File untuk Upload Logo --}}
                        <input type="file" name="logo_toko" id="logo_toko" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer">
                        <p class="text-xs text-gray-500 text-center">Pilih logo toko (JPG, PNG, maks 2MB).</p>
                        
                    </div> 
                    {{-- Akhir Bagian Kanan Form --}}

                </div> {{-- Akhir Grid Internal --}}

            </div> {{-- Akhir Card Putih --}}
            
        </form> {{-- AKHIR FORM UTAMA --}}

    </section>

    {{-- JavaScript untuk Toggle Password dan Preview Logo --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle Password
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');
            const togglePasswordIcon = document.getElementById('togglePasswordIcon');
            
            if (togglePasswordBtn) {
                togglePasswordBtn.addEventListener('click', function() {
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        togglePasswordIcon.classList.remove('bi-eye-slash');
                        togglePasswordIcon.classList.add('bi-eye');
                    } else {
                        passwordInput.type = 'password';
                        togglePasswordIcon.classList.remove('bi-eye');
                        togglePasswordIcon.classList.add('bi-eye-slash');
                    }
                });
            }
            
            // Toggle Konfirmasi Password
            const togglePasswordConfirmBtn = document.getElementById('togglePasswordConfirmBtn');
            const passwordConfirmInput = document.getElementById('password_confirmation');
            const togglePasswordConfirmIcon = document.getElementById('togglePasswordConfirmIcon');
            
            if (togglePasswordConfirmBtn) {
                togglePasswordConfirmBtn.addEventListener('click', function() {
                    if (passwordConfirmInput.type === 'password') {
                        passwordConfirmInput.type = 'text';
                        togglePasswordConfirmIcon.classList.remove('bi-eye-slash');
                        togglePasswordConfirmIcon.classList.add('bi-eye');
                    } else {
                        passwordConfirmInput.type = 'password';
                        togglePasswordConfirmIcon.classList.remove('bi-eye');
                        togglePasswordConfirmIcon.classList.add('bi-eye-slash');
                    }
                });
            }

            // Preview Logo Toko
            const logoInput = document.getElementById('logo_toko');
            const logoPreview = document.getElementById('logoPreview');
            
            if (logoInput) {
                logoInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            logoPreview.innerHTML = `<img src="${e.target.result}" alt="Preview Logo" class="w-full h-full rounded-full object-cover">`;
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>

</x-layout.layout-profile>