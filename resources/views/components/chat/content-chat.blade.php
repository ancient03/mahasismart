<div class="flex flex-col h-full bg-gray-100 border border-gray-300 rounded-xl overflow-hidden">
    <!-- Header -->
    <div class="flex items-center justify-between bg-white p-4 shadow-sm">
        <h2 class="font-semibold text-lg">Wowo</h2>
    </div>

    <!-- Chat Body -->
    <div class="flex-1 overflow-y-auto p-4 space-y-4 scrollbar-hide">
        {{-- isi chat --}}
        <!-- Chat contoh -->
        <x-cardproduk.card-chat />

        <div class="flex justify-start">
            <div class="bg-white border border-gray-300 rounded-xl p-3 max-w-sm shadow-sm">
                <p class="text-gray-800">Halo, Antek antek</p>
                <p class="text-gray-800">Spray yang aku janjikan masih ada?</p>
                <p class="text-xs text-gray-500 mt-1 text-right">09.30</p>
            </div>
        </div>

        <!-- Balasan user -->
        <div class="flex justify-end">
            <div class="bg-[#00795E] text-white rounded-xl p-3 max-w-sm shadow">
                <p>Masih dong 😁</p>
                <p>Ada stok 3 lagi nih, mau sekalian aku kirim hari ini?</p>
                <p class="text-xs text-gray-200 mt-1 text-right">09.31</p>
            </div>
        </div>

        <!-- Balasan kiri -->
        <div class="flex justify-start">
            <div class="bg-white border border-gray-300 rounded-xl p-3 max-w-sm shadow-sm">
                <p class="text-gray-800">Wah, boleh banget!</p>
                <p class="text-gray-800">Bisa kirim ke kosan aku ya?</p>
                <p class="text-xs text-gray-500 mt-1 text-right">09.32</p>
            </div>
        </div>

        <!-- Balasan kanan -->
        <div class="flex justify-end">
            <div class="bg-[#00795E] text-white rounded-xl p-3 max-w-sm shadow">
                <p>Bisa kok, tinggal kirim alamatnya aja ya 😄</p>
                <p class="text-xs text-gray-200 mt-1 text-right">09.33</p>
            </div>
        </div>

        <!-- Tambahan terakhir -->
        <div class="flex justify-start">
            <div class="bg-white border border-gray-300 rounded-xl p-3 max-w-sm shadow-sm">
                <p class="text-gray-800">Oke, nanti aku kirim ya 🙏</p>
                <p class="text-xs text-gray-500 mt-1 text-right">09.34</p>
            </div>
        </div>
    </div>

    <!-- Input -->
    <div class="flex items-center gap-2 p-4 bg-white shadow">
        <button class="py-2 px-4 rounded-full bg-gray-200 hover:bg-gray-300  transition duration-500 cursor-pointer">
            <i class="bi bi-plus-lg"></i>
        </button>
        <input type="text" placeholder="Ketik pesan..." class="flex-1 rounded-full px-4 py-2 focus:outline-none" />
        <button
            class="py-2 px-4 bg-[#00795E] text-white rounded-full hover:bg-[#005744] transition duration-500 cursor-pointer">
            <i class="bi bi-send-fill"></i>
        </button>
    </div>
</div>
