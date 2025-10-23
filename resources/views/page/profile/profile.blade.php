<x-layout.layout-profile>
<section class="md:col-span-3">
                <div class="bg-white text-gray-800 rounded-lg shadow p-6 md:p-8">
                    
                    <h1 class="text-2xl font-bold mb-6">Profil Saya</h1>

                    <!-- Menampilkan pesan Sukses -->
                    @if (session('status'))
                        <div class="mb-4 rounded-md bg-green-100 p-4 text-sm font-medium text-green-700">
                            {{ session('status') }}
                        </div>
                    @endif

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

                        {{-- =================================== --}}
                        {{-- FORM UTAMA (SUDAH DIPERBAIKI) --}}
                        {{-- =================================== --}}
                        <form method="POST" action="{{ route('profile.update') }}" class="lg:col-span-2 space-y-4">
                            @csrf  {{-- Wajib untuk keamanan --}}
                            @method('PATCH') {{-- Method untuk Update --}}

                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700">Username:</label>
                                {{-- Ganti placeholder jadi 'value' dan tambahkan 'name' --}}
                                <input type="text" id="username" name="username" 
                                       value="{{ old('username', Auth::user()->username) }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                                <input type="email" id="email" name="email"
                                       value="{{ old('email', Auth::user()->email) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>
                            
                            <div>
                                <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor Telepon:</label>
                                <input type="text" id="no_hp" name="no_hp"
                                       value="{{ old('no_hp', Auth::user()->no_hp) }}" 
                                       placeholder="Tambahkan nomor HP Anda"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>

                            {{-- Field Password (Opsional) --}}
                            <div class="pt-4 border-t border-gray-200">
                                <p class="text-sm font-medium text-gray-900">Ubah Password</p>
                                <p class="text-sm text-gray-500">Kosongkan jika Anda tidak ingin mengubah password.</p>
                            </div>
                            
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password Baru:</label>
                                <input type="password" id="password" name="password"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>
                            
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru:</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>

                            {{-- 
                              Saya hapus 'Jenis Kelamin' karena tidak ada di Model 'User' Anda.
                              Jika Anda ingin menambahkannya, Anda harus:
                              1. Menambah kolom 'jenis_kelamin' di migration
                              2. Menambahkannya ke '$fillable' di Model 'User.php'
                            --}}

                            <div class="pt-4">
                                <button type="submit" class="bg-gray-700 text-white py-2 px-5 rounded-lg font-semibold hover:bg-gray-800 transition-colors">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                        {{-- =================================== --}}
                        {{-- AKHIR FORM --}}
                        {{-- =================================== --}}


                        <!-- Upload Foto Profil -->
                        <div class="lg:col-span-1 flex flex-col items-center space-y-4 pt-8 lg:pt-0">
                            <div class="w-40 h-40 bg-gray-200 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <button type="button" class="bg-gray-200 text-gray-800 py-2 px-5 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                                Pilih Gambar
                            </button>
                            <p class="text-xs text-gray-500 text-center">Upload foto profil (fitur ini belum diimplementasikan).</p>
                        </div>
                    </div>

                    <!-- Tombol Logout (dipindahkan ke luar <form>) -->
                    <div class="flex justify-end mt-8 border-t border-gray-200 pt-6">
                        {{-- Ini adalah form logout dari navbar, Anda bisa gunakan di sini --}}
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