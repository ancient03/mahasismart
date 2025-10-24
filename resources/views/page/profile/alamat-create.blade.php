 <x-layout.layout-profile>



            <!-- Konten Form Tambah Alamat -->
            <section class="md:col-span-3">
                <div class="bg-white text-gray-800 rounded-lg shadow p-6 md:p-8">
                    
                    <div class="flex justify-between items-center mb-6">
                       <h1 class="text-2xl font-bold">Tambah Alamat Baru</h1>
                       {{-- Link kembali ke daftar alamat --}}
                       <a href="{{ route('alamat.index') }}" class="text-blue-600 hover:underline text-sm">
                           &laquo; Kembali ke Daftar Alamat
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

                    {{-- Form ini mengirim data ke AlamatController@store --}}
                    <form method="POST" action="{{ route('alamat.store') }}" class="space-y-4">
                        @csrf

                        {{-- Label Alamat --}}
                        <div>
                            <label for="label" class="block text-sm font-medium text-gray-700">Label Alamat <span class="text-red-500">*</span></label>
                            <input type="text" id="label" name="label" value="{{ old('label') }}" required 
                                   placeholder="Contoh: Rumah, Kantor"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        {{-- Nama Penerima --}}
                        <div>
                            <label for="nama_penerima" class="block text-sm font-medium text-gray-700">Nama Penerima <span class="text-red-500">*</span></label>
                            <input type="text" id="nama_penerima" name="nama_penerima" value="{{ old('nama_penerima') }}" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        {{-- No HP Penerima --}}
                        <div>
                            <label for="no_hp_penerima" class="block text-sm font-medium text-gray-700">No. Handphone Penerima <span class="text-red-500">*</span></label>
                            <input type="text" id="no_hp_penerima" name="no_hp_penerima" value="{{ old('no_hp_penerima') }}" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>
                        
                        {{-- Provinsi --}}
                        <div>
                            <label for="provinsi" class="block text-sm font-medium text-gray-700">Provinsi <span class="text-red-500">*</span></label>
                            <input type="text" id="provinsi" name="provinsi" value="{{ old('provinsi') }}" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        {{-- Kota/Kabupaten --}}
                        <div>
                            <label for="kota" class="block text-sm font-medium text-gray-700">Kota/Kabupaten <span class="text-red-500">*</span></label>
                            <input type="text" id="kota" name="kota" value="{{ old('kota') }}" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        {{-- Kecamatan --}}
                        <div>
                            <label for="kecamatan" class="block text-sm font-medium text-gray-700">Kecamatan <span class="text-red-500">*</span></label>
                            <input type="text" id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        {{-- Kode Pos --}}
                        <div>
                            <label for="kode_pos" class="block text-sm font-medium text-gray-700">Kode Pos <span class="text-red-500">*</span></label>
                            <input type="text" id="kode_pos" name="kode_pos" value="{{ old('kode_pos') }}" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        {{-- Detail Alamat --}}
                        <div>
                            <label for="detail_alamat" class="block text-sm font-medium text-gray-700">Detail Alamat <span class="text-red-500">*</span></label>
                            <textarea id="detail_alamat" name="detail_alamat" rows="3" required 
                                      placeholder="Nama Jalan, Nomor Rumah, RT/RW, Kelurahan, Patokan"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('detail_alamat') }}</textarea>
                        </div>

                        {{-- Jadikan Alamat Utama? (Checkbox) --}}
                        <div class="flex items-center">
                            <input id="is_default" name="is_default" type="checkbox" value="1" {{ old('is_default') ? 'checked' : '' }}
                                   class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <label for="is_default" class="ml-2 block text-sm text-gray-900">Jadikan alamat utama</label>
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="bg-green-600 text-white py-2 px-5 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                                Simpan Alamat
                            </button>
                        </div>
                    </form>
                </div>
            </section>

</x-layout.layout-profile>