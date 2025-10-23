<nav class="rounded-b-xl bg-[#00795E] shadow-md" x-data="{ open: false }">
    
    <!-- NAVBAR DESKTOP -->
    <div class="hidden md:flex bg-[#00795E] items-center justify-between container mx-auto px-6 py-5">
      
        <!-- Logo (Kiri) -->
        <div class="flex-shrink-0">
            <a href="/" class="text-yellow-500 text-3xl font-bold flex items-center space-x-2">
                <img src="{{ asset('img/kuning-nobg.png') }}" alt="Logo MahasisMart" class="h-10 w-auto">
                <span class="text-2xl font-bold">MahasisMart</span>
            </a>
        </div>

        <!-- Search Bar (Tengah) -->
        <div class="flex-grow max-w-xl mx-4">
            <input 
              type="text" 
              class="w-full bg-white rounded-xl py-2 px-4 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-300"
              aria-label="Search"
              placeholder="Cari..."
            >
        </div>

        <!-- Tombol (Kanan) -->
        <div class="flex-shrink-0 flex items-center space-x-6"> {{-- Mengubah space-x-10 menjadi 6 agar lebih rapi --}}
        
            @auth
              {{-- ====================================================== --}}
              {{-- JIKA SUDAH LOGIN: TAMPILKAN IKON & DROPDOWN PROFIL --}}
              {{-- ====================================================== --}}
              
              <!-- Grup Ikon (Keranjang, Chat, Notifikasi) -->
              <div class="flex items-center space-x-6">
                <a href="/keranjang" class="text-white hover:text-gray-200" aria-label="Lihat Keranjang">
                    <i class="bi bi-cart3 text-2xl"></i>
                </a>
                <a href="/message" class="text-white hover:text-gray-200" aria-label="Lihat Pesan" >
                    <i class="bi bi-chat-dots text-2xl"></i>
                </a>
                <a href="#" class="text-white hover:text-gray-200" aria-label="Lihat Notifikasi">
                    <i class="bi bi-bell text-2xl"></i>
                </a>
              </div>

              <!-- Garis Pemisah Vertikal -->
              <div class="h-8 border-l border-gray-400 opacity-50"></div>

              <!-- Dropdown Profil (Gabungan dari kode Anda dan saya) -->
              <div class="relative">
                
                <!-- Tombol Trigger (Sapaan + Foto Profil Anda) -->
                <button @click="open = !open" class="flex items-center space-x-2 rounded-full p-1 transition-colors duration-200 hover:bg-gray-800 focus:outline-none">
                  <p class="text-white font-medium text-sm hover:text-gray-200" title="Pergi ke Profil">
                    Hi, {{ Auth::user()->username }}
                  </p>
                  <img src="{{ asset('img/jokowikaget.jpg') }}" alt="Profile Picture" class="rounded-full w-8 h-8 object-cover">
                </button>

                <!-- Menu Dropdown -->
                <div 
                  x-show="open" 
                  @click.away="open = false" 
                  x-transition:enter="transition ease-out duration-100"
                  x-transition:enter-start="transform opacity-0 scale-95"
                  x-transition:enter-end="transform opacity-100 scale-100"
                  x-transition:leave="transition ease-in duration-75"
                  x-transition:leave-start="transform opacity-100 scale-100"
                  x-transition:leave-end="transform opacity-0 scale-95"
                  class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                  style="display: none;" {{-- Sembunyikan by default --}}
                >
                  <!-- Link Profil -->
                  <a href="profile" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100">
                    Profil Saya
                  </a>
                  
                  <!-- Form Logout (Sudah di-uncomment dan diperbaiki) -->
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" 
                       class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-gray-100"
                       onclick="event.preventDefault(); this.closest('form').submit();">
                      Logout
                    </a>
                  </form>
                </div>
              </div>

            @else
              {{-- =================================== --}}
              {{-- JIKA BELUM LOGIN (TAMU) --}}
              {{-- =================================== --}}
              <a href="{{ route('login') }}" class="bg-white text-black text-sm font-semibold px-5 py-2 rounded-xl hover:bg-gray-100 transition-colors">
                Masuk
              </a>
              <a href="{{ route('register') }}" class="bg-white text-black text-sm font-semibold px-5 py-2 rounded-xl hover:bg-gray-100 transition-colors">
                Daftar
              </a>
            @endguest
        
        </div>
    </div>

    <!-- 
      NAVBAR MOBILE (Sudah diperbarui dengan link dinamis)
    -->
    <div class="rounded-b-xl md:hidden bg-gradient-to-r from-orange-400 to-yellow-500 p-3">
        <div class="flex items-center space-x-2">
            
            <input 
              type="text" 
              class="flex-grow w-full bg-white rounded-xl py-2 px-4 text-gray-900 placeholder-gray-500 focus:outline-none"
              aria-label="Search"
              placeholder="Cari..."
            >

            {{-- Ikon Profil Mobile (Linknya sekarang dinamis) --}}
            @auth
              {{-- Jika login, pergi ke profil --}}
              <a href="" class="flex-shrink-0 text-black bg-white p-2 rounded-full hover:bg-gray-100 transition-colors" aria-label="Profil Pengguna">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0
 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
              </a>
            @else
              {{-- Jika tamu, pergi ke login --}}
              <a href="{{ route('login') }}" class="flex-shrink-0 text-black bg-white p-2 rounded-full hover:bg-gray-100 transition-colors" aria-label="Login">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
              </a>
            @endguest
            
        </div>
    </div>
</nav>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    