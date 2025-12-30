<x-layout.layout-profile>
    <section class="md:col-span-3">
        <div class="bg-white text-gray-800 rounded-lg shadow p-6 md:p-8">
            
            <h1 class="text-2xl font-bold mb-6">Register Toko</h1>

            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-center">
                    <div class="flex items-center">
                        <div id="step1Indicator" class="flex items-center justify-center w-10 h-10 rounded-full bg-green-500 text-white font-bold">1</div>
                        <span id="step1Label" class="ml-2 font-medium text-green-600">Data Toko</span>
                    </div>
                    <div class="w-24 h-1 bg-gray-300 mx-4"></div>
                    <div class="flex items-center">
                        <div id="step2Indicator" class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-300 text-gray-600 font-bold">2</div>
                        <span id="step2Label" class="ml-2 font-medium text-gray-400">Verifikasi</span>
                    </div>
                </div>
            </div>

            <!-- Error Messages -->
            @if (session('error'))
                <div class="mb-4 rounded-md bg-red-100 p-4 text-sm font-medium text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <!-- FORM UTAMA -->
            <form id="registerForm" method="POST" action="{{ route('register.toko.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- STEP 1: Data Toko -->
                <div id="step1">
                    <div class="space-y-4">
                        <div>
                            <label for="no_hp_toko" class="block text-sm font-medium text-gray-700">No. Handphone Toko <span class="text-red-500">*</span></label>
                            <input type="text" id="no_hp_toko" name="no_hp_toko" required
                                   placeholder="Contoh: 081234567890"
                                   class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        <div>
                            <label for="email_mahasiswa" class="block text-sm font-medium text-gray-700">Email Mahasiswa <span class="text-red-500">*</span></label>
                            <input type="email" id="email_mahasiswa" name="email_mahasiswa" required
                                   placeholder="Untuk KTM: harus @mhs.dinus.ac.id"
                                   class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            <p class="mt-1 text-xs text-gray-500">Jika menggunakan KTM, email harus berakhiran @mhs.dinus.ac.id</p>
                        </div>

                        <div>
                            <label for="nama_toko" class="block text-sm font-medium text-gray-700">Nama Toko <span class="text-red-500">*</span></label>
                            <input type="text" id="nama_toko" name="nama_toko" required
                                   placeholder="Nama unik untuk toko Anda"
                                   class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        <div>
                            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap Sesuai KTP/KTM <span class="text-red-500">*</span></label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" required
                                   placeholder="Nama lengkap sesuai identitas"
                                   class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            <p class="mt-1 text-xs text-gray-500">Harus sama persis dengan nama di KTP/KTM</p>
                        </div>

                        <div>
                            <label for="nik_nim" class="block text-sm font-medium text-gray-700">NIK/NIM <span class="text-red-500">*</span></label>
                            <input type="text" id="nik_nim" name="nik_nim" required
                                   placeholder="16 digit NIK atau NIM (contoh: A11.2023.15194)"
                                   class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            <p id="nikNimHelper" class="mt-1 text-xs text-gray-500">Format NIM: A11.2023.15194 | Format NIK: 16 digit</p>
                        </div>

                        <div class="pt-4">
                            <button type="button" id="nextBtn" class="bg-green-600 text-white py-2 px-6 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                                Berikutnya →
                            </button>
                        </div>
                    </div>
                </div>

                <!-- STEP 2: Upload & Verifikasi KTP/KTM -->
                <div id="step2" style="display: none;">
                    <div class="space-y-6">
                        
                        <!-- Pilih Jenis Dokumen (Auto-detected, Read-only) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Dokumen <span class="text-red-500">*</span></label>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                <input type="radio" name="jenis_verifikasi" value="ktp" id="radioKTP" class="hidden">
                                <input type="radio" name="jenis_verifikasi" value="ktm" id="radioKTM" class="hidden">
                                <div id="detectedDocType" class="flex items-center text-sm">
                                    <svg class="w-5 h-5 mr-2 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span id="docTypeText" class="text-gray-700">Terdeteksi otomatis berdasarkan NIK/NIM yang Anda masukkan</span>
                                </div>
                            </div>
                        </div>

                        <!-- Contoh Gambar KTP/KTM -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="font-semibold text-sm text-blue-800 mb-3">📸 Contoh Dokumen</h3>
                            
                            <!-- Contoh KTP -->
                            <div id="ktpExample">
                                <div class="bg-white rounded-lg p-3 border border-blue-100">
                                    <img src="{{ asset('img/register-toko/ktp contoh.jpg') }}" alt="Contoh KTP" class="w-full max-w-md mx-auto rounded shadow">
                                    <p class="text-center text-xs text-gray-600 mt-2">Contoh KTP - Pastikan foto jelas dan semua teks terbaca</p>
                                </div>
                            </div>

                            <!-- Contoh KTM -->
                            <div id="ktmExample" style="display: none;">
                                <div class="bg-white rounded-lg p-3 border border-blue-100">
                                    <img src="{{ asset('img/register-toko/ktm udinus orang_11zon.jpg') }}" alt="Contoh KTM" class="w-full max-w-md mx-auto rounded shadow">
                                    <p class="text-center text-xs text-gray-600 mt-2">Contoh KTM - Pastikan foto jelas dan semua teks terbaca</p>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Area -->
                        <div>
                            <label for="foto_verifikasi" class="block text-sm font-medium text-gray-700 mb-2">Upload Foto KTP/KTM <span class="text-red-500">*</span></label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-500 transition-colors">
                                <input type="file" id="foto_verifikasi" name="foto_verifikasi" accept="image/*" required class="hidden">
                                <label for="foto_verifikasi" class="cursor-pointer">
                                    <div id="uploadPlaceholder">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-600">Klik untuk upload foto</p>
                                        <p class="text-xs text-gray-500">JPG, PNG, WEBP (Maks 5MB)</p>
                                    </div>
                                </label>
                                <div id="imagePreview" style="display: none;" class="mt-4">
                                    <img id="previewImg" class="max-h-64 mx-auto rounded-lg shadow">
                                </div>
                            </div>
                        </div>

                        <!-- Status Verifikasi -->
                        <div id="verificationStatus" style="display: none;" class="rounded-lg">
                            
                            <!-- Loading Status -->
                            <div id="loadingStatus" style="display: none;" class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                <div class="flex flex-col items-center">
                                    <div class="relative">
                                        <div class="w-16 h-16 border-4 border-blue-200 rounded-full"></div>
                                        <div class="w-16 h-16 border-4 border-blue-600 border-t-transparent rounded-full animate-spin absolute top-0"></div>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <p class="text-base font-semibold text-blue-900">Memverifikasi Dokumen</p>
                                        <p class="text-sm text-blue-700 mt-2">Sedang memvalidasi data Anda...</p>
                                        <p class="text-xs text-gray-500 mt-3">Proses ini memakan waktu 5-15 detik</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Success Status -->
                            <div id="successStatus" style="display: none;" class="bg-green-50 border-2 border-green-300 rounded-lg p-5">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div class="flex-1">
                                        <h3 class="text-base font-bold text-green-800">Verifikasi Berhasil!</h3>
                                        <p class="text-sm text-green-700 mt-1">Dokumen Anda telah terverifikasi</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Error Status -->
                            <div id="errorStatus" style="display: none;" class="bg-red-50 border-2 border-red-300 rounded-lg p-5">
                                <div class="flex items-start">
                                    <svg class="h-6 w-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div class="flex-1">
                                        <h3 class="text-base font-bold text-red-800">Verifikasi Gagal</h3>
                                        <div id="errorMessage" class="mt-2 text-sm text-red-700"></div>
                                        <button type="button" id="retryBtn" class="mt-3 text-sm text-red-700 hover:text-red-900 font-medium underline">
                                            Coba Upload Ulang
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-4 pt-4">
                            <button type="button" id="backBtn" class="bg-gray-300 text-gray-700 py-2 px-6 rounded-lg font-semibold hover:bg-gray-400 transition-colors">
                                ← Kembali
                            </button>
                            <button type="submit" id="submitBtn" disabled class="bg-gray-400 text-white py-2 px-6 rounded-lg font-semibold cursor-not-allowed">
                                Register Toko
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </section>

    <script>
        (function() {
            'use strict';
            
            let step1Data = {};
            let isDocumentVerified = false;
            let detectedDocType = null;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }

            function init() {
                loadSavedData();
                attachEvents();
            }

            function attachEvents() {
                const nextBtn = document.getElementById('nextBtn');
                const backBtn = document.getElementById('backBtn');
                const retryBtn = document.getElementById('retryBtn');
                const fileInput = document.getElementById('foto_verifikasi');
                const nikNimInput = document.getElementById('nik_nim');
                const form = document.getElementById('registerForm');

                if (nextBtn) nextBtn.onclick = goToStep2;
                if (backBtn) backBtn.onclick = goToStep1;
                if (retryBtn) retryBtn.onclick = resetUpload;
                if (fileInput) fileInput.onchange = handleFileSelect;
                if (form) form.onsubmit = handleSubmit;
                
                // Real-time validation untuk NIK/NIM
                if (nikNimInput) {
                    nikNimInput.oninput = validateNikNim;
                    nikNimInput.onblur = validateNikNim;
                }
            }

            /**
             * Validasi dan deteksi format NIK/NIM
             */
            function validateNikNim() {
                const value = document.getElementById('nik_nim').value.trim();
                const helper = document.getElementById('nikNimHelper');
                
                if (!value) {
                    helper.className = 'mt-1 text-xs text-gray-500';
                    helper.textContent = 'Format NIM: A11.2023.15194 | Format NIK: 16 digit';
                    detectedDocType = null;
                    return;
                }
                
                // Cek format NIM: huruf + angka dengan titik (A11.2023.15194)
                const nimPattern = /^[A-E]\d{2}\.\d{4}\.\d+$/i;
                // Cek format NIK: 16 digit angka
                const nikPattern = /^\d{16}$/;
                
                if (nimPattern.test(value)) {
                    detectedDocType = 'ktm';
                    helper.className = 'mt-1 text-xs text-green-600 font-medium';
                    helper.innerHTML = 'NIM terdeteksi. Dokumen verifikasi: Kartu Tanda Mahasiswa';
                } else if (nikPattern.test(value)) {
                    detectedDocType = 'ktp';
                    helper.className = 'mt-1 text-xs text-green-600 font-medium';
                    helper.innerHTML = 'NIK terdeteksi. Dokumen verifikasi: Kartu Tanda Penduduk';
                } else {
                    detectedDocType = null;
                    helper.className = 'mt-1 text-xs text-red-600 font-medium';
                    helper.innerHTML = 'Format tidak valid. Harap gunakan format NIM (A11.2023.15194) atau NIK (16 digit)';
                }
            }

            function loadSavedData() {
                const saved = localStorage.getItem('registerTokoStep1');
                if (saved) {
                    step1Data = JSON.parse(saved);
                    document.getElementById('no_hp_toko').value = step1Data.no_hp_toko || '';
                    document.getElementById('email_mahasiswa').value = step1Data.email_mahasiswa || '';
                    document.getElementById('nama_toko').value = step1Data.nama_toko || '';
                    document.getElementById('nama_lengkap').value = step1Data.nama_lengkap || '';
                    document.getElementById('nik_nim').value = step1Data.nik_nim || '';
                }
            }

            function goToStep2() {
                const noHp = document.getElementById('no_hp_toko').value.trim();
                const email = document.getElementById('email_mahasiswa').value.trim();
                const namaToko = document.getElementById('nama_toko').value.trim();
                const namaLengkap = document.getElementById('nama_lengkap').value.trim();
                const nikNim = document.getElementById('nik_nim').value.trim();

                if (!noHp || !email || !namaToko || !namaLengkap || !nikNim) {
                    alert('Harap lengkapi semua field!');
                    return;
                }

                // Validasi format NIK/NIM
                if (!detectedDocType) {
                    alert('Format NIK/NIM tidak valid!\n\nGunakan format:\n- NIM: A11.2023.15194\n- NIK: 16 digit angka');
                    return;
                }

                // Validasi email untuk KTM
                if (detectedDocType === 'ktm' && !email.endsWith('@mhs.dinus.ac.id')) {
                    alert('Untuk verifikasi KTM, email harus berformat @mhs.dinus.ac.id');
                    return;
                }

                step1Data = { 
                    no_hp_toko: noHp, 
                    email_mahasiswa: email, 
                    nama_toko: namaToko, 
                    nama_lengkap: namaLengkap, 
                    nik_nim: nikNim 
                };
                localStorage.setItem('registerTokoStep1', JSON.stringify(step1Data));

                // Set jenis dokumen otomatis
                if (detectedDocType === 'ktm') {
                    document.getElementById('radioKTM').checked = true;
                    document.getElementById('docTypeText').innerHTML = 'Jenis Dokumen Verifikasi: <strong>Kartu Tanda Mahasiswa</strong>';
                    document.getElementById('ktpExample').style.display = 'none';
                    document.getElementById('ktmExample').style.display = 'block';
                } else {
                    document.getElementById('radioKTP').checked = true;
                    document.getElementById('docTypeText').innerHTML = 'Jenis Dokumen Verifikasi: <strong>Kartu Tanda Penduduk</strong>';
                    document.getElementById('ktpExample').style.display = 'block';
                    document.getElementById('ktmExample').style.display = 'none';
                }

                document.getElementById('step1').style.display = 'none';
                document.getElementById('step2').style.display = 'block';

                document.getElementById('step1Indicator').className = 'flex items-center justify-center w-10 h-10 rounded-full bg-gray-300 text-gray-600 font-bold';
                document.getElementById('step1Label').className = 'ml-2 font-medium text-gray-400';
                document.getElementById('step2Indicator').className = 'flex items-center justify-center w-10 h-10 rounded-full bg-green-500 text-white font-bold';
                document.getElementById('step2Label').className = 'ml-2 font-medium text-green-600';
            }

            function goToStep1() {
                document.getElementById('step2').style.display = 'none';
                document.getElementById('step1').style.display = 'block';

                document.getElementById('step1Indicator').className = 'flex items-center justify-center w-10 h-10 rounded-full bg-green-500 text-white font-bold';
                document.getElementById('step1Label').className = 'ml-2 font-medium text-green-600';
                document.getElementById('step2Indicator').className = 'flex items-center justify-center w-10 h-10 rounded-full bg-gray-300 text-gray-600 font-bold';
                document.getElementById('step2Label').className = 'ml-2 font-medium text-gray-400';
            }

            function updateDocumentType() {
                const isKTM = document.querySelector('input[name="jenis_verifikasi"]:checked').value === 'ktm';
                document.getElementById('ktpExample').style.display = isKTM ? 'none' : 'block';
                document.getElementById('ktmExample').style.display = isKTM ? 'block' : 'none';
            }

            function handleFileSelect(event) {
                const file = event.target.files[0];
                if (!file) return;

                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    alert('Format file tidak valid! Gunakan JPG, PNG, atau WEBP.');
                    event.target.value = '';
                    return;
                }

                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar! Maksimal 5MB.');
                    event.target.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('uploadPlaceholder').style.display = 'none';
                    document.getElementById('imagePreview').style.display = 'block';
                    verifyDocument(file);
                };
                reader.readAsDataURL(file);
            }

            async function verifyDocument(file) {
                document.getElementById('verificationStatus').style.display = 'block';
                document.getElementById('loadingStatus').style.display = 'block';
                document.getElementById('successStatus').style.display = 'none';
                document.getElementById('errorStatus').style.display = 'none';

                try {
                    const formData = new FormData();
                    formData.append('image', file);
                    formData.append('nik_nim', step1Data.nik_nim);
                    formData.append('nama_lengkap', step1Data.nama_lengkap);
                    formData.append('email_mahasiswa', step1Data.email_mahasiswa);
                    formData.append('jenis_dokumen', document.querySelector('input[name="jenis_verifikasi"]:checked').value);

                    const response = await fetch('{{ route("register.toko.validate") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const result = await response.json();
                    document.getElementById('loadingStatus').style.display = 'none';

                    if (result.success) {
                        document.getElementById('successStatus').style.display = 'block';
                        isDocumentVerified = true;
                        
                        const btn = document.getElementById('submitBtn');
                        btn.disabled = false;
                        btn.className = 'bg-green-600 text-white py-2 px-6 rounded-lg font-semibold hover:bg-green-700 transition-colors cursor-pointer';
                        
                        localStorage.setItem('registerTokoVerified', 'true');
                    } else {
                        // Buat pesan error yang simple
                        let errorMsg = 'Data tidak sesuai: ';
                        let errors = [];
                        
                        if (result.match_details) {
                            if (result.match_details.universitas === false) errors.push('Universitas tidak ditemukan');
                            if (result.match_details.nik === false) errors.push('NIK tidak sesuai');
                            if (result.match_details.nim === false) errors.push('NIM tidak sesuai');
                            if (result.match_details.nama === false) errors.push('Nama tidak sesuai');
                            if (result.match_details.email_nim_match === false) errors.push('Email tidak sesuai dengan NIM');
                        }
                        
                        if (errors.length > 0) {
                            errorMsg += errors.join(', ');
                        } else {
                            errorMsg = result.user_message || result.message || 'Verifikasi gagal';
                        }
                        
                        document.getElementById('errorMessage').innerHTML = `<p>${errorMsg}</p>`;
                        document.getElementById('errorStatus').style.display = 'block';
                        resetUploadButton();
                    }

                } catch (error) {
                    console.error('OCR Error:', error);
                    document.getElementById('loadingStatus').style.display = 'none';
                    document.getElementById('errorMessage').innerHTML = '<p>Tidak dapat menghubungi server. Coba lagi.</p>';
                    document.getElementById('errorStatus').style.display = 'block';
                    resetUploadButton();
                }
            }

            function resetUploadButton() {
                const btn = document.getElementById('submitBtn');
                btn.disabled = true;
                btn.className = 'bg-gray-400 text-white py-2 px-6 rounded-lg font-semibold cursor-not-allowed';
                isDocumentVerified = false;
            }

            function resetUpload() {
                document.getElementById('foto_verifikasi').value = '';
                document.getElementById('uploadPlaceholder').style.display = 'block';
                document.getElementById('imagePreview').style.display = 'none';
                document.getElementById('verificationStatus').style.display = 'none';
                resetUploadButton();
            }

            function handleSubmit(e) {
                if (!isDocumentVerified) {
                    e.preventDefault();
                    alert('Harap upload dan verifikasi dokumen KTP/KTM terlebih dahulu!');
                    return false;
                }
                
                localStorage.removeItem('registerTokoStep1');
                localStorage.removeItem('registerTokoVerified');
                return true;
            }
        })();
    </script>

</x-layout.layout-profile>