<x-layout>
    <div x-data="{ showAll: false }" class="container mx-auto px-4 sm:px-6 lg:px-8">

        {{-- search --}}
        <div class="w-full max-w-md mx-auto mt-4">
            <div class="flex items-center gap-2 border border-gray-300 rounded-lg px-3 py-2 bg-white shadow-sm">
                <i class="bi bi-search text-gray-500 text-lg"></i>
                <input type="text" placeholder="Cari sesuatu..."
                    class="w-full outline-none border-0 focus:ring-0 text-gray-700">
            </div>
        </div>

        {{-- menu kategori --}}
        <div class="flex flex-wrap items-center justify-center gap-4 sm:gap-6 mt-6">

            <template
                x-for="item in [
                    { icon: 'bi-info-lg', name: 'Umum' },
                    { icon: 'bi-person', name: 'Akun Pengguna' },
                    { icon: 'bi-basket', name: 'Jual Beli' },
                    { icon: 'bi-truck', name: 'Pengiriman' },
                    { icon: 'bi-question-circle', name: 'Bantuan' },
                ]">

                <div class="flex flex-col items-center gap-2">

                    {{-- Icon Bulat Responsif --}}
                    <div
                        class="border rounded-full bg-[#00795E] text-white flex items-center justify-center
                        py-2 px-3 sm:py-4 sm:px-5">
                        <i :class="'bi ' + item.icon + ' text-2xl sm:text-4xl'"></i>
                    </div>

                    {{-- Nama kategori --}}
                    <a href="#" class="text-xs sm:text-sm font-medium" x-text="item.name"></a>
                </div>
            </template>

        </div>

        {{-- FAQ --}}
        <div class="mt-6 p-6 rounded-lg bg-zinc-300">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold">FAQ</h1>

                {{-- Tombol lihat semua --}}
                <button @click="showAll = !showAll" class="hover:underline transition duration-300 cursor-pointer">
                    <span x-show="!showAll">Lihat Semua</span>
                    <span x-show="showAll">Tutup Semua</span>
                </button>
            </div>

            {{-- FAQ Umum --}}
            <h2 class="text-lg font-medium mt-4">Umum</h2>
            <ol class="list-decimal pl-6 space-y-3 p-4 mt-2 bg-white text-black rounded-lg">
                <li>Apa itu Mahasismart? <br> Mahasismart adalah platform e-commerce khusus mahasiswa yang memudahkan jual beli kebutuhan kampus.</li>
                <li>Siapa saja yang bisa menggunakan Mahasismart? <br> Mahasismart dapat digunakan oleh mahasiswa, dosen, dan seluruh civitas akademika.</li>
                <li>Apakah Mahasismart hanya untuk kampus? <br> Ya. Platform ini fokus pada transaksi aman antar mahasiswa di lingkungan kampus.</li>
            </ol>

            {{-- FAQ kategori lain --}}
            <div x-show="showAll" x-transition>

                {{-- Akun Pengguna --}}
                <h2 class="text-lg font-medium mt-6">Akun Pengguna</h2>
                <ol class="list-decimal pl-6 space-y-3 p-4 mt-2 bg-white text-black rounded-lg">
                    <li>Cara membuat akun? <br> Daftar menggunakan email kampus, isi data diri lengkap, lalu buat password akun.</li>
                    <li>Cara verifikasi email? <br> Setelah mendaftar, sistem akan mengirimkan email verifikasi. Klik tombol “Verifikasi Email” pada pesan tersebut.</li>
                </ol>

                {{-- Jual Beli --}}
                <h2 class="text-lg font-medium mt-6">Jual Beli</h2>
                <ol class="list-decimal pl-6 space-y-3 p-4 mt-2 bg-white text-black rounded-lg">
                    <li>Cara upload produk? <br> Buka menu “Jual Produk”, isi nama produk, harga, deskripsi, dan unggah foto produk, lalu klik “Posting”.</li>
                    <li>Apakah ada biaya admin? <br> Tidak. Mahasismart saat ini tidak mengenakan biaya admin.</li>
                </ol>

                {{-- Pengiriman --}}
                <h2 class="text-lg font-medium mt-6">Pengiriman</h2>
                <ol class="list-decimal pl-6 space-y-3 p-4 mt-2 bg-white text-black rounded-lg">
                    <li>Bagaimana pengiriman dalam kampus? <br> Pengiriman umumnya dilakukan dengan sistem COD (temu langsung) di titik lokasi yang disepakati dalam area kampus.</li>
                    <li>Apakah bisa COD? <br> Ya, sebagian besar transaksi menggunakan metode COD antara pembeli dan penjual.</li>
                </ol>

                {{-- Bantuan --}}
                <h2 class="text-lg font-medium mt-6">Bantuan</h2>
                <ol class="list-decimal pl-6 space-y-3 p-4 mt-2 bg-white text-black rounded-lg">
                    <li>Bagaimana menghubungi admin? <br> Anda dapat menghubungi admin melalui menu “Chat Mahasismart” atau nomor WhatsApp yang tersedia.</li>
                </ol>

            </div>
        </div>

        {{-- lainnya --}}
        <div class="mt-6 p-6 bg-zinc-300 rounded-lg mb-10">
            <h1 class="text-2xl font-semibold">Hubungi Kami</h1>

            <a href="#" class="flex mt-2 items-center gap-2 text-lg">
                <i class="bi bi-headset"></i> Chat Mahasismart
            </a>

            <a href="#" class="flex mt-2 items-center gap-2 text-lg">
                <i class="bi bi-telephone-fill"></i> +62 812-3456-7890
            </a>
        </div>

    </div>
</x-layout>
