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
                                   placeholder="16 digit NIK atau NIM"
                                   class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
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
                        
                        <!-- Pilih Jenis Dokumen -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Dokumen <span class="text-red-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="flex items-center">
                                    <input type="radio" name="jenis_verifikasi" value="ktp" checked class="mr-2">
                                    <span>KTP</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="jenis_verifikasi" value="ktm" class="mr-2">
                                    <span>KTM</span>
                                </label>
                            </div>
                        </div>

                        <!-- Contoh Dokumen -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="font-semibold text-sm text-blue-800 mb-2">📸 Contoh Dokumen Yang Benar:</h3>
                            <div id="ktpExample" class="text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Foto KTP harus jelas dan tidak blur</li>
                                    <li>Pastikan tulisan "KARTU TANDA PENDUDUK" terlihat</li>
                                    <li>NIK dan nama lengkap harus terbaca dengan jelas</li>
                                    <li>Pencahayaan yang baik, tidak gelap</li>
                                    <li>Format: JPG, PNG, atau WEBP (Maks 5MB)</li>
                                </ul>
                            </div>
                            <div id="ktmExample" style="display: none;" class="text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Foto KTM harus jelas dan tidak blur</li>
                                    <li>Pastikan tulisan "KARTU TANDA MAHASISWA" terlihat</li>
                                    <li>NIM dan nama lengkap harus terbaca jelas</li>
                                    <li>Pencahayaan yang baik, tidak gelap</li>
                                    <li>Format: JPG, PNG, atau WEBP (Maks 5MB)</li>
                                </ul>
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
                        <div id="verificationStatus" style="display: none;" class="rounded-lg p-4">
                            <div id="loadingStatus" style="display: none;" class="text-center">
                                <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-blue-500 border-t-transparent"></div>
                                <p class="mt-2 text-sm text-gray-600">Memverifikasi dokumen dengan OCR...</p>
                                <p class="text-xs text-gray-500 mt-1">Ini mungkin memakan waktu beberapa detik</p>
                            </div>
                            <div id="successStatus" style="display: none;" class="bg-green-100 text-green-800 p-3 rounded">
                                <!-- Will be populated by JavaScript -->
                            </div>
                            <div id="errorStatus" style="display: none;" class="bg-red-100 text-red-800 p-3 rounded">
                                <p class="font-semibold">✗ Verifikasi Gagal!</p>
                                <p id="errorMessage" class="text-sm mt-1"></p>
                                <p class="text-xs mt-2 text-gray-600">Pastikan foto jelas, terang, dan tidak blur</p>
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
            
            console.log('=== SCRIPT STARTED ===');
            
            let step1Data = {};
            let isDocumentVerified = false;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }

            function init() {
                console.log('=== INITIALIZING ===');
                loadSavedData();
                attachEvents();
                console.log('=== READY ===');
            }

            function attachEvents() {
                const nextBtn = document.getElementById('nextBtn');
                const backBtn = document.getElementById('backBtn');
                const fileInput = document.getElementById('foto_verifikasi');
                const radioButtons = document.querySelectorAll('input[name="jenis_verifikasi"]');
                const form = document.getElementById('registerForm');

                if (nextBtn) {
                    nextBtn.onclick = goToStep2;
                    console.log('✓ Next button attached');
                }

                if (backBtn) {
                    backBtn.onclick = goToStep1;
                    console.log('✓ Back button attached');
                }

                if (fileInput) {
                    fileInput.onchange = handleFileSelect;
                    console.log('✓ File input attached');
                }

                radioButtons.forEach(radio => {
                    radio.onchange = updateDocumentType;
                });

                if (form) {
                    form.onsubmit = handleSubmit;
                    console.log('✓ Form submit attached');
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
                console.log('=== GO TO STEP 2 ===');
                
                const noHp = document.getElementById('no_hp_toko').value.trim();
                const email = document.getElementById('email_mahasiswa').value.trim();
                const namaToko = document.getElementById('nama_toko').value.trim();
                const namaLengkap = document.getElementById('nama_lengkap').value.trim();
                const nikNim = document.getElementById('nik_nim').value.trim();

                if (!noHp || !email || !namaToko || !namaLengkap || !nikNim) {
                    alert('Harap lengkapi semua field!');
                    return;
                }

                step1Data = { no_hp_toko: noHp, email_mahasiswa: email, nama_toko: namaToko, nama_lengkap: namaLengkap, nik_nim: nikNim };
                localStorage.setItem('registerTokoStep1', JSON.stringify(step1Data));

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
                console.log('File selected');
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
                console.log('Starting OCR verification...');
                
                document.getElementById('verificationStatus').style.display = 'block';
                document.getElementById('loadingStatus').style.display = 'block';
                document.getElementById('successStatus').style.display = 'none';
                document.getElementById('errorStatus').style.display = 'none';

                try {
                    const formData = new FormData();
                    formData.append('image', file);
                    formData.append('nik_nim', step1Data.nik_nim);
                    formData.append('nama_lengkap', step1Data.nama_lengkap);
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
                    console.log('OCR Result:', result);

                    document.getElementById('loadingStatus').style.display = 'none';

                    if (result.success) {
                        // ✅ SIMPAN HASIL OCR KE LOCALSTORAGE
                        const ocrData = {
                            extracted_text: result.extracted_text,
                            detected_type: result.detected_type,
                            match_details: result.match_details,
                            verified_at: new Date().toISOString()
                        };
                        localStorage.setItem('registerTokoOCR', JSON.stringify(ocrData));
                        console.log('✓ OCR data saved to localStorage:', ocrData);
                        
                        // Update success message dengan info detected type
                        const successMsg = document.getElementById('successStatus');
                        successMsg.style.display = 'block';
                        
                        let detectedTypeText = '';
                        if (result.detected_type === 'ktm') {
                            detectedTypeText = '<p class="text-xs mt-2">✓ Terdeteksi: Kartu Tanda Mahasiswa (KTM)</p>';
                        } else if (result.detected_type === 'ktp') {
                            detectedTypeText = '<p class="text-xs mt-2">✓ Terdeteksi: Kartu Tanda Penduduk (KTP)</p>';
                        }
                        
                        successMsg.innerHTML = `
                            <p class="font-semibold">✓ Verifikasi Berhasil!</p>
                            <p class="text-sm mt-1">${result.message}</p>
                            ${detectedTypeText}
                        `;
                        
                        isDocumentVerified = true;
                        
                        const btn = document.getElementById('submitBtn');
                        btn.disabled = false;
                        btn.className = 'bg-green-600 text-white py-2 px-6 rounded-lg font-semibold hover:bg-green-700 transition-colors cursor-pointer';
                        
                        localStorage.setItem('registerTokoVerified', 'true');
                    } else {
                        document.getElementById('errorStatus').style.display = 'block';
                        
                        let errorDetails = result.message;
                        if (result.match_details) {
                            errorDetails += '<div class="text-xs mt-2 space-y-1">';
                            if (result.match_details.universitas !== undefined) {
                                errorDetails += `<div>Universitas: ${result.match_details.universitas ? '✓' : '✗'}</div>`;
                            }
                            if (result.match_details.nik !== undefined) {
                                errorDetails += `<div>NIK: ${result.match_details.nik ? '✓' : '✗'}</div>`;
                            }
                            if (result.match_details.nim !== undefined) {
                                errorDetails += `<div>NIM: ${result.match_details.nim ? '✓' : '✗'}</div>`;
                            }
                            if (result.match_details.matched_words) {
                                errorDetails += `<div>Nama cocok: ${result.match_details.matched_words}</div>`;
                            }
                            errorDetails += '</div>';
                        }
                        
                        document.getElementById('errorMessage').innerHTML = errorDetails;
                        
                        if (result.debug) {
                            console.log('Extracted text:', result.debug);
                        }
                        
                        // Simpan hasil gagal juga untuk debugging
                        const ocrData = {
                            extracted_text: result.extracted_text || result.debug || '',
                            detected_type: result.detected_type || 'unknown',
                            match_details: result.match_details,
                            verified_at: new Date().toISOString(),
                            success: false
                        };
                        localStorage.setItem('registerTokoOCR', JSON.stringify(ocrData));
                        console.log('✗ OCR failed, data saved for debugging:', ocrData);
                        
                        resetUpload();
                    }

                } catch (error) {
                    console.error('OCR Error:', error);
                    document.getElementById('loadingStatus').style.display = 'none';
                    document.getElementById('errorStatus').style.display = 'block';
                    document.getElementById('errorMessage').textContent = 'Gagal menghubungi server. Coba lagi.';
                    resetUpload();
                }
            }

            function resetUpload() {
                document.getElementById('foto_verifikasi').value = '';
                document.getElementById('uploadPlaceholder').style.display = 'block';
                document.getElementById('imagePreview').style.display = 'none';
                isDocumentVerified = false;
            }

            function handleSubmit(e) {
                if (!isDocumentVerified) {
                    e.preventDefault();
                    alert('Harap upload dan verifikasi dokumen KTP/KTM terlebih dahulu!');
                    return false;
                }

                // Log data yang akan dikirim untuk debugging
                const ocrData = JSON.parse(localStorage.getItem('registerTokoOCR') || '{}');
                console.log('=== SUBMIT FORM ===');
                console.log('Step 1 Data:', step1Data);
                console.log('OCR Data:', ocrData);
                console.log('Jenis Verifikasi:', document.querySelector('input[name="jenis_verifikasi"]:checked').value);
                
                // Clear localStorage setelah submit
                localStorage.removeItem('registerTokoStep1');
                localStorage.removeItem('registerTokoVerified');
                localStorage.removeItem('registerTokoOCR');
                
                return true;
            }

            // Fungsi untuk melihat data localStorage (debugging)
            window.debugRegisterToko = function() {
                console.log('=== DEBUG REGISTER TOKO ===');
                console.log('Step 1 Data:', JSON.parse(localStorage.getItem('registerTokoStep1') || '{}'));
                console.log('OCR Data:', JSON.parse(localStorage.getItem('registerTokoOCR') || '{}'));
                console.log('Verified:', localStorage.getItem('registerTokoVerified'));
            };
            
            // Fungsi untuk test detection manual
            window.testDetection = function(text) {
                const normalized = text.toLowerCase().replace(/[\n\r]/g, ' ').replace(/\s+/g, ' ');
                console.log('=== TEST DETECTION ===');
                console.log('Original text:', text.substring(0, 100));
                console.log('Normalized:', normalized.substring(0, 100));
                console.log('Has "kartu tanda mahasiswa"?', normalized.includes('kartu tanda mahasiswa'));
                console.log('Has "kartu tanda penduduk"?', normalized.includes('kartu tanda penduduk'));
                
                if (normalized.includes('kartu tanda mahasiswa')) {
                    console.log('✓ RESULT: KTM');
                    return 'ktm';
                } else if (normalized.includes('kartu tanda penduduk')) {
                    console.log('✓ RESULT: KTP');
                    return 'ktp';
                } else {
                    console.log('⚠️ RESULT: UNKNOWN');
                    return 'unknown';
                }
            };
            
            console.log('💡 Debug commands:');
            console.log('  - debugRegisterToko() : Lihat data localStorage');
            console.log('  - testDetection(text) : Test detection logic');
        })();
    </script>

</x-layout.layout-profile>