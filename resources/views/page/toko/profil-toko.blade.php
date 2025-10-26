 <x-layout.layout-profile>
     <section class="md:col-span-3">
         <form method="POST" action="#" enctype="multipart/form-data">
             <div class="bg-white text-gray-800 rounded-lg shadow p-6 md:p-8">
                 <h1 class="text-2xl font-bold mb-6">Profil Toko</h1>

                 <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                     <!-- Bagian Kiri Form -->
                     <div class="lg:col-span-2 space-y-4">
                         <div>
                             <label for="nama_toko" class="block text-sm font-medium text-gray-700">Nama Toko:</label>
                             <input type="text" id="nama_toko" name="nama_toko" placeholder="Masukkan nama toko"
                                 class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" />
                         </div>

                         <div>
                             <label for="email_toko" class="block text-sm font-medium text-gray-700">Email Toko:</label>
                             <input type="email" id="email_toko" name="email_toko" placeholder="Masukkan email toko"
                                 class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" />
                         </div>

                         <div>
                             <label for="no_telp" class="block text-sm font-medium text-gray-700">Nomor
                                 Telepon:</label>
                             <input type="text" id="no_telp" name="no_telp"
                                 placeholder="Masukkan nomor telepon toko"
                                 class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" />
                         </div>

                         <div>
                             <label for="alamat_toko" class="block text-sm font-medium text-gray-700">Alamat
                                 Toko:</label>
                             <textarea id="alamat_toko" name="alamat_toko" placeholder="Masukkan alamat lengkap toko" rows="3"
                                 class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"></textarea>
                         </div>

                         <div>
                             <label for="deskripsi_toko" class="block text-sm font-medium text-gray-700">Deskripsi
                                 Toko:</label>
                             <textarea id="deskripsi_toko" name="deskripsi_toko" placeholder="Tuliskan deskripsi singkat tentang toko Anda"
                                 rows="4"
                                 class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"></textarea>
                         </div>

                         <div class="pt-4">
                             <button type="submit"
                                 class="bg-gray-700 text-white py-2 px-5 rounded-lg font-semibold hover:bg-gray-800 transition-colors">
                                 Simpan Perubahan
                             </button>
                         </div>
                     </div>
                     <!-- Akhir Bagian Kiri -->

                     <!-- Bagian Kanan Form (Logo Toko) -->
                     <div class="lg:col-span-1 flex flex-col items-center space-y-4 pt-8 lg:pt-0">
                         <label class="block text-sm font-medium text-gray-700 mb-2">Logo Toko</label>

                         <div
                             class="w-40 h-40 bg-gray-200 rounded-full flex items-center justify-center border border-gray-300">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-500" viewBox="0 0 20 20"
                                 fill="currentColor">
                                 <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                     clip-rule="evenodd" />
                             </svg>
                         </div>

                         <input type="file" name="logo_toko" id="logo_toko"
                             class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer" />
                         <p class="text-xs text-gray-500 text-center">Pilih gambar baru (JPG, PNG, maks 2MB).</p>
                     </div>
                     <!-- Akhir Bagian Kanan -->
                 </div>
             </div>
         </form>

         <!-- Tombol Logout -->
         <div class="bg-white text-gray-800 rounded-lg shadow p-6 md:p-8 mt-6">
             <div class="flex justify-end border-t border-gray-200 pt-6">
                 <button type="button"
                     class="bg-red-600 text-white py-2 px-5 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                     Logout
                 </button>
             </div>
         </div>
     </section>

 </x-layout.layout-profile>
