<x-layout.layout-profile>
            <section class="md:col-span-3">
                <div class="bg-white text-gray-800 lg:rounded-lg shadow p-6 md:p-8 mb-96">
                    
                    <h1 class="text-2xl font-bold mb-6">Alamat Saya</h1>

                    <div class="space-y-6">
                        
                        {{-- Contoh Alamat 1 --}}
                        <div class="border-b border-gray-200 pb-6">
                            <div class="flex items-start space-x-4">
                                <!-- Ikon Pin -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 flex-shrink-0 mt-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <!-- Info Alamat -->
                                <div>
                                    <h3 class="text-lg font-semibold">Alamat 1</h3>
                                    <p class="text-gray-700">
                                        Jl. Siliwangi No.143, Kalibanteng Kulon, Kec. Semarang Barat, Kota Semarang, Jawa Tengah 50145
                                    </p>
                                    {{-- Nanti Anda bisa tambahkan info lain di sini --}}
                                    {{-- <p class="text-sm text-gray-600 mt-1">Nama Penerima | 0812xxxx</p> --}}
                                </div>
                            </div>
                        </div>

                        {{-- Contoh Alamat 2 --}}
                        <div class="border-b border-gray-200 pb-6">
                            <div class="flex items-start space-x-4">
                                <!-- Ikon Pin -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 flex-shrink-0 mt-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <!-- Info Alamat -->
                                <div>
                                    <h3 class="text-lg font-semibold">Alamat 2</h3>
                                    <p class="text-gray-700">
                                        296C+5RX, Jl. Hilir, Kembangarum, Kec. Semarang Barat, Kota Semarang, Jawa Tengah 50146
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Tombol Tambah Alamat -->
                    <div class="mt-8">
                        <a href="#" class="bg-gray-200 text-gray-800 py-2 px-5 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                            Tambah Alamat
                        </a>
                    </div>

                </div>
            </section>

        </div>

</x-layout.layout-profile>