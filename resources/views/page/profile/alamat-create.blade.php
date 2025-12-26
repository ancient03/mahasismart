<x-layout.layout-profile>

    <!-- Konten Form Tambah Alamat -->
    <section class="md:col-span-3">
        <div class="bg-white text-gray-800 rounded-lg shadow p-6 md:p-8">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Tambah Alamat Baru</h1>
                <a href="{{ route('alamat.index') }}" class="text-blue-600 hover:underline text-sm">
                    &laquo; Kembali ke Daftar Alamat
                </a>
            </div>

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

            <form method="POST" action="{{ route('alamat.store') }}" class="space-y-4" id="formAlamat">
                @csrf

                {{-- Label Alamat --}}
                <div>
                    <label for="label" class="block text-sm font-medium text-gray-700">Label Alamat <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="label" name="label" value="{{ old('label') }}" required
                        placeholder="Contoh: Rumah, Kantor"
                        class="px-4 py-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                {{-- Nama Penerima --}}
                <div>
                    <label for="nama_penerima" class="block text-sm font-medium text-gray-700">Nama Penerima <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="nama_penerima" name="nama_penerima" value="{{ old('nama_penerima') }}"
                        required
                        class="px-4 py-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                {{-- No HP Penerima --}}
                <div>
                    <label for="no_hp_penerima" class="block text-sm font-medium text-gray-700">No. Handphone Penerima
                        <span class="text-red-500">*</span></label>
                    <input type="text" id="no_hp_penerima" name="no_hp_penerima" value="{{ old('no_hp_penerima') }}"
                        required
                        class="px-4 py-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                {{-- Provinsi (Dropdown) --}}
                <div>
                    <label for="provinsi" class="block text-sm font-medium text-gray-700">Provinsi <span
                            class="text-red-500">*</span></label>
                    <select id="provinsi" name="provinsi" required
                        class="px-4 py-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="">Pilih Provinsi</option>
                    </select>
                    <input type="hidden" id="provinsi_id" name="province_id">
                </div>

                {{-- Kota/Kabupaten (Dropdown) --}}
                <div>
                    <label for="kota" class="block text-sm font-medium text-gray-700">Kota/Kabupaten <span
                            class="text-red-500">*</span></label>
                    <select id="kota" name="kota" required disabled
                        class="px-4 py-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 disabled:bg-gray-100">
                        <option value="">Pilih Kota/Kabupaten</option>
                    </select>
                    <input type="hidden" id="kota_id" name="city_id">
                </div>

                {{-- Kecamatan (Dropdown) --}}
                <div>
                    <label for="kecamatan" class="block text-sm font-medium text-gray-700">Kecamatan <span
                            class="text-red-500">*</span></label>
                    <select id="kecamatan" name="kecamatan" required disabled
                        class="px-4 py-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 disabled:bg-gray-100">
                        <option value="">Pilih Kecamatan</option>
                    </select>
                    <input type="hidden" id="kecamatan_id" name="district_id">
                </div>

                {{-- Desa (Dropdown) --}}
                <div>
                    <label for="desa" class="block text-sm font-medium text-gray-700">Desa/Kelurahan <span
                            class="text-red-500">*</span></label>
                    <select id="desa" name="desa" required disabled
                        class="px-4 py-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 disabled:bg-gray-100">
                        <option value="">Pilih Desa/Kelurahan</option>
                    </select>
                </div>

                {{-- Kode Pos (Auto-fill) --}}
                <div>
                    <label for="kode_pos" class="block text-sm font-medium text-gray-700">Kode Pos <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="kode_pos" name="kode_pos" value="{{ old('kode_pos') }}" required readonly
                        class="px-4 py-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100">
                </div>

                {{-- Detail Alamat --}}
                <div>
                    <label for="detail_alamat" class="block text-sm font-medium text-gray-700">Detail Alamat <span
                            class="text-red-500">*</span></label>
                    <textarea id="detail_alamat" name="detail_alamat" rows="3" required
                        placeholder="Nama Jalan, Nomor Rumah, RT/RW, Patokan"
                        class="px-4 py-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('detail_alamat') }}</textarea>
                </div>

                {{-- Jadikan Alamat Utama? --}}
                <div class="flex items-center">
                    <input id="is_default" name="is_default" type="checkbox" value="1"
                        {{ old('is_default') ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <label for="is_default" class="ml-2 block text-sm text-gray-900">Jadikan alamat utama</label>
                </div>

                {{-- Tombol Simpan --}}
                <div class="pt-4 flex justify-end">
                    <button type="submit"
                        class="bg-green-600 text-white py-2 px-5 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                        Simpan Alamat
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{-- JavaScript untuk Cascading Dropdown --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const provinsiSelect = document.getElementById('provinsi');
            const kotaSelect = document.getElementById('kota');
            const kecamatanSelect = document.getElementById('kecamatan');
            const desaSelect = document.getElementById('desa');
            const kodePosInput = document.getElementById('kode_pos');

            const provinsiIdInput = document.getElementById('provinsi_id');
            const kotaIdInput = document.getElementById('kota_id');
            const kecamatanIdInput = document.getElementById('kecamatan_id');

            // Konfigurasi cache
            const CACHE_DURATION = 24 * 60 * 60 * 1000; // 24 jam dalam milidetik
            const CACHE_PREFIX = 'rajaongkir_';

            // Menyimpan data untuk filter
            let currentKota = '';
            let currentKecamatan = '';

            // Load Provinsi saat halaman dibuka
            loadProvinsi();

            // Event Listeners
            provinsiSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const provinsiId = selectedOption.dataset.id;

                // PENTING: Set value ke hidden input
                provinsiIdInput.value = provinsiId;

                if (provinsiId) {
                    loadKota(provinsiId);
                    resetDropdown(kecamatanSelect);
                    resetDropdown(desaSelect);
                    kodePosInput.value = '';
                }
            });

            kotaSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const kotaId = selectedOption.dataset.id;
                const kotaName = selectedOption.value;

                // PENTING: Set value ke hidden input
                kotaIdInput.value = kotaId;
                currentKota = kotaName;

                if (kotaId) {
                    loadKecamatan(kotaId);
                    resetDropdown(desaSelect);
                    kodePosInput.value = '';
                }
            });

            kecamatanSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const kecamatanId = selectedOption.dataset.id;
                const kecamatanName = selectedOption.value;

                // PENTING: Set value ke hidden input
                kecamatanIdInput.value = kecamatanId;
                currentKecamatan = kecamatanName;

                if (kecamatanName && currentKota) {
                    loadDesa(currentKota, kecamatanName);
                    kodePosInput.value = '';
                }
            });

            desaSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const kodePos = selectedOption.dataset.kodepos;

                if (kodePos) {
                    kodePosInput.value = kodePos;
                }
            });

            // ========== CACHE FUNCTIONS ==========

            /**
             * Simpan data ke localStorage dengan timestamp
             */
            function setCache(key, data) {
                try {
                    const cacheData = {
                        timestamp: new Date().getTime(),
                        data: data
                    };
                    localStorage.setItem(CACHE_PREFIX + key, JSON.stringify(cacheData));
                    console.log('💾 Cache saved:', key);
                } catch (error) {
                    console.error('❌ Error saving cache:', error);
                }
            }

            /**
             * Ambil data dari localStorage
             * Return null jika tidak ada atau sudah expired
             */
            function getCache(key) {
                try {
                    const cached = localStorage.getItem(CACHE_PREFIX + key);
                    if (!cached) return null;

                    const cacheData = JSON.parse(cached);
                    const now = new Date().getTime();

                    // Cek apakah cache sudah expired (lebih dari 24 jam)
                    if (now - cacheData.timestamp > CACHE_DURATION) {
                        console.log('⏰ Cache expired:', key);
                        localStorage.removeItem(CACHE_PREFIX + key);
                        return null;
                    }

                    console.log('✅ Cache hit:', key);
                    return cacheData.data;
                } catch (error) {
                    console.error('❌ Error reading cache:', error);
                    return null;
                }
            }

            /**
             * Hapus semua cache (opsional, bisa dipanggil manual jika perlu)
             */
            function clearAllCache() {
                Object.keys(localStorage).forEach(key => {
                    if (key.startsWith(CACHE_PREFIX)) {
                        localStorage.removeItem(key);
                    }
                });
                console.log('🗑️ All cache cleared');
            }

            // ========== LOAD FUNCTIONS WITH CACHE ==========

            function loadProvinsi() {
                const cacheKey = 'provinsi';
                const cachedData = getCache(cacheKey);

                if (cachedData) {
                    // Gunakan data dari cache
                    populateProvinsi(cachedData);
                } else {
                    // Fetch dari API
                    fetch('/api/rajaongkir/provinsi')
                        .then(response => response.json())
                        .then(data => {
                            console.log('📍 Data Provinsi dari API:', data);

                            if (data.data && Array.isArray(data.data)) {
                                // Simpan ke cache
                                setCache(cacheKey, data.data);
                                // Populate dropdown
                                populateProvinsi(data.data);
                            }
                        })
                        .catch(error => {
                            console.error('❌ Error loading provinsi:', error);
                            alert('Gagal memuat data provinsi');
                        });
                }
            }

            function populateProvinsi(data) {
                provinsiSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
                data.forEach(provinsi => {
                    const option = document.createElement('option');
                    option.value = provinsi.name;
                    option.textContent = provinsi.name;
                    option.dataset.id = provinsi.id;
                    provinsiSelect.appendChild(option);
                });
            }

            function loadKota(provinsiId) {
                kotaSelect.disabled = true;
                kotaSelect.innerHTML = '<option value="">Loading...</option>';

                const cacheKey = `kota_${provinsiId}`;
                const cachedData = getCache(cacheKey);

                if (cachedData) {
                    // Gunakan data dari cache
                    populateKota(cachedData);
                } else {
                    // Fetch dari API
                    fetch(`/api/rajaongkir/kota/${provinsiId}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log('🏙️ Data Kota dari API:', data);

                            if (data.data && Array.isArray(data.data)) {
                                // Simpan ke cache
                                setCache(cacheKey, data.data);
                                // Populate dropdown
                                populateKota(data.data);
                            }
                        })
                        .catch(error => {
                            console.error('❌ Error loading kota:', error);
                            kotaSelect.innerHTML = '<option value="">Error memuat data</option>';
                        });
                }
            }

            function populateKota(data) {
                kotaSelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                data.forEach(kota => {
                    const option = document.createElement('option');
                    option.value = kota.name;
                    option.textContent = kota.name;
                    option.dataset.id = kota.id;
                    kotaSelect.appendChild(option);
                });
                kotaSelect.disabled = false;
            }

            function loadKecamatan(kotaId) {
                kecamatanSelect.disabled = true;
                kecamatanSelect.innerHTML = '<option value="">Loading...</option>';

                const cacheKey = `kecamatan_${kotaId}`;
                const cachedData = getCache(cacheKey);

                if (cachedData) {
                    // Gunakan data dari cache
                    populateKecamatan(cachedData);
                } else {
                    // Fetch dari API
                    fetch(`/api/rajaongkir/kecamatan/${kotaId}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log('🗺️ Data Kecamatan dari API:', data);

                            if (data.data && Array.isArray(data.data)) {
                                // Simpan ke cache
                                setCache(cacheKey, data.data);
                                // Populate dropdown
                                populateKecamatan(data.data);
                            }
                        })
                        .catch(error => {
                            console.error('❌ Error loading kecamatan:', error);
                            kecamatanSelect.innerHTML = '<option value="">Error memuat data</option>';
                        });
                }
            }

            function populateKecamatan(data) {
                kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                data.forEach(kecamatan => {
                    const option = document.createElement('option');
                    option.value = kecamatan.name;
                    option.textContent = kecamatan.name;
                    option.dataset.id = kecamatan.id;
                    kecamatanSelect.appendChild(option);
                });
                kecamatanSelect.disabled = false;
            }

            function loadDesa(kotaName, kecamatanName) {
                desaSelect.disabled = true;
                desaSelect.innerHTML = '<option value="">Loading...</option>';

                const cacheKey = `desa_${kotaName}`;
                const cachedData = getCache(cacheKey);

                if (cachedData) {
                    // Gunakan data dari cache
                    populateDesa(cachedData, kecamatanName);
                } else {
                    // Fetch dari API
                    fetch(`/api/rajaongkir/desa/${encodeURIComponent(kotaName)}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log('🏘️ Data Desa dari API:', data);

                            if (data.data && Array.isArray(data.data)) {
                                // Simpan ke cache
                                setCache(cacheKey, data.data);
                                // Populate dropdown
                                populateDesa(data.data, kecamatanName);
                            } else {
                                desaSelect.innerHTML = '<option value="">Tidak ada data</option>';
                            }
                        })
                        .catch(error => {
                            console.error('❌ Error loading desa:', error);
                            desaSelect.innerHTML = '<option value="">Error memuat data</option>';
                        });
                }
            }

            function populateDesa(data, kecamatanName) {
                // Filter data berdasarkan kecamatan yang dipilih
                const filteredData = data.filter(item => {
                    return item.district_name &&
                        item.district_name.toLowerCase() === kecamatanName.toLowerCase();
                });

                console.log('🏘️ Filtered Desa:', filteredData);

                if (filteredData.length > 0) {
                    desaSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
                    filteredData.forEach(desa => {
                        const option = document.createElement('option');
                        option.value = desa.subdistrict_name;
                        option.textContent = desa.subdistrict_name;
                        option.dataset.kodepos = desa.zip_code || '';
                        desaSelect.appendChild(option);
                    });
                    desaSelect.disabled = false;
                } else {
                    desaSelect.innerHTML = '<option value="">Tidak ada data desa</option>';
                    console.warn('⚠️ No subdistricts found for:', kecamatanName);
                }
            }

            function resetDropdown(selectElement) {
                selectElement.innerHTML = '<option value="">Pilih...</option>';
                selectElement.disabled = true;
            }

            // Expose clearAllCache ke window untuk debugging (opsional)
            window.clearRajaOngkirCache = clearAllCache;
            console.log('💡 Tip: Ketik clearRajaOngkirCache() di console untuk hapus semua cache');
        });
    </script>

</x-layout.layout-profile>
