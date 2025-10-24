{{-- Ganti ini dengan layout utama Anda yg benar --}}
<x-layout.layout-profile>

    {{-- Kolom Kanan Konten Profil --}}
    <section class="md:col-span-3">

        {{-- 
          FORM UTAMA DIMULAI DI SINI
          Tambahkan: method, action, enctype 
        --}}
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            {{-- Card Putih Pembungkus --}}
            <div class="bg-white text-gray-800 rounded-lg shadow p-6 md:p-8">
                
                <h1 class="text-2xl font-bold mb-6">Profil Saya</h1>

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

                    {{-- Bagian Kiri Form (Info Teks) --}}
                    <div class="lg:col-span-2 space-y-4">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700">Username:</label>
                            {{-- Tambahkan: name="username", value="..." --}}
                            <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                            {{-- Tambahkan: name="email", value="..." --}}
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>
                        <div>
                            <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor Telepon:</label>
                            {{-- Tambahkan: name="no_hp", value="..." --}}
                            <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" 
                                   placeholder="Tambahkan nomor HP Anda"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>
                        
                        {{-- Ubah Password --}}
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-sm font-medium text-gray-900">Ubah Password</p>
                            <p class="text-sm text-gray-500">Kosongkan jika tidak ingin mengubah.</p>
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password Baru:</label>
                            {{-- Tambahkan: name="password" --}}
                            <input type="password" id="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru:</label>
                            {{-- Tambahkan: name="password_confirmation" --}}
                            <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        {{-- Tombol Save Changes --}}
                        <div class="pt-4">
                            <button type="submit" class="bg-gray-700 text-white py-2 px-5 rounded-lg font-semibold hover:bg-gray-800 transition-colors">
                                Save Changes
                            </button>
                        </div>
                    </div> 
                    {{-- Akhir Bagian Kiri Form --}}

                    {{-- Bagian Kanan Form (Upload Foto) --}}
                    <div class="lg:col-span-1 flex flex-col items-center space-y-4 pt-8 lg:pt-0">
                        
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                        
                        <!-- Menampilkan Foto Saat Ini -->
                        @if ($user->foto_profil)
                            <img src="{{ asset('img/fotoprofile/' . $user->foto_profil) }}" alt="Foto Profil" class="w-40 h-40 rounded-full object-cover border border-gray-300">
                        @else
                            {{-- Placeholder jika tidak ada foto --}}
                            <div class="w-40 h-40 bg-gray-200 rounded-full flex items-center justify-center border border-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif
                        
                        {{-- Input File untuk Upload (Tambahkan name="foto_profil") --}}
                        <input type="file" name="foto_profil" id="foto_profil" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer">
                        <p class="text-xs text-gray-500 text-center">Pilih gambar baru (JPG, PNG, maks 2MB).</p>
                        
                        {{-- Tombol "Pilih Gambar" lama tidak diperlukan --}}
                    </div> 
                    {{-- Akhir Bagian Kanan Form --}}

                </div> {{-- Akhir Grid Internal --}}

            </div> {{-- Akhir Card Putih --}}
            
        </form> {{-- AKHIR FORM UTAMA --}}

        <!-- Tombol Logout (Tetap terpisah) -->
        <div class="bg-white text-gray-800 rounded-lg shadow p-6 md:p-8 mt-6"> 
            <div class="flex justify-end border-t border-gray-200 pt-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="bg-red-600 text-white py-2 px-5 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                        Logout
                    </a>
                </form>
            </div>
        </div>

    </section>
</x-layout.layout-profile>