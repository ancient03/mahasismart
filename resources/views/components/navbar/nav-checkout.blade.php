<nav class="fixed top-0 left-0 right-0 bg-[#00795E] text-white flex items-center justify-between px-6 py-4 rounded-b-2xl shadow-md z-50">
    <!-- Tombol kiri (Back) -->
    <button class="text-white hover:opacity-80 transition duration-300">
        <i class="bi bi-arrow-left-circle text-3xl"></i>
    </button>

    <!-- Logo di tengah -->
    <div class="absolute left-1/2 transform -translate-x-1/2 flex items-center gap-3">
        <img src="{{ asset('img/kuning-nobg.png') }}" alt="Logo" class="h-10 w-auto">
        <h1 class="text-2xl font-bold text-[#FDBA38]">Mahasismart</h1>
    </div>

    <!-- Tombol kanan (Profil) -->
    <a href="#" class="hover:opacity-80 transition duration-300">
        <img src="https://miro.medium.com/1*GI-td9gs8D5OKZd19mAOqA.png" alt="Profil" class="h-10 w-10 rounded-full object-cover border-2 border-white">
    </a>
</nav>
