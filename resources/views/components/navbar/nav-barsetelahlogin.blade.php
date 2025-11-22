{{-- Navbar Fixed di Atas --}}
<nav 
  class="fixed top-0 left-0 right-0 z-50 rounded-b-xl bg-[#00795E] shadow-md" 
  x-data="{ open: false, notifOpen: false }"
>
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
    <form action="{{ route('search') }}" method="GET">
        <input 
          type="text" 
          name="q" {{-- 1. Tambah name="q" --}}
          class="w-full bg-white rounded-xl py-2 pl-4 pr-10 ..."
          placeholder="Cari..."
          aria-label="Search"
          value="{{ request('q') ?? '' }}" {{-- 2. Tampilkan query pencarian --}}
        >
        <button type="submit" class="absolute top-0 right-0 ...">
            <i class=""></i>
        </button>
    </form>
    </div>


    <!-- Tombol (Kanan) -->
    <div class="flex-shrink-0 flex items-center space-x-6"> 
      @auth
        <!-- Grup Ikon (Keranjang, Notifikasi, Faq) -->
        <div class="flex items-center space-x-6">

          {{-- Keranjang --}}
          <a href="/keranjang" class="text-white hover:text-gray-200" aria-label="Lihat Keranjang">
            <i class="bi bi-cart3 text-2xl"></i>
          </a>

          {{-- Dropdown Notifikasi --}}
          <div class="relative">
            <button @click="notifOpen = !notifOpen" class="relative text-white hover:text-gray-200 focus:outline-none">
              <i class="bi bi-bell text-2xl"></i>
              <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs text-white">4</span>
            </button>

            <div 
              x-show="notifOpen" 
              @click.away="notifOpen = false" 
              x-transition
              class="absolute right-0 z-50 mt-2 w-72 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5"
              style="display: none;"
            >
              <div class="py-1">
                <div class="px-4 py-2 text-sm font-semibold text-gray-700 border-b">Notifikasi</div>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  Pesanan #12345 telah dikirim.
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  Ada pesan baru dari Toko ABC.
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  Promo spesial untuk Anda!
                </a>
                <div class="border-t mt-1">
                  <a href="#" class="block px-4 py-2 text-center text-sm text-blue-600 hover:bg-gray-100">
                    Lihat semua notifikasi
                  </a>
                </div>
              </div>
            </div>
          </div>

          {{-- FAQ --}}
          <a href="/faq" class="text-white hover:text-gray-200" aria-label="Lihat FAQ">
            <i class="bi bi-question-circle text-2xl"></i>
          </a>
        </div>

        <!-- Garis Vertikal -->
        <div class="h-8 border-l border-gray-400 opacity-50"></div>

        <!-- Dropdown Profil -->
        <div class="relative">
          <button @click="open = !open" class="flex items-center space-x-2 rounded-full p-1 transition-colors duration-200 hover:bg-gray-800 focus:outline-none">
            <p class="text-white font-medium text-sm hover:text-gray-200" title="Pergi ke Profil">
              Hi, {{ Auth::user()->username }}
            </p>
            @if (Auth::user()->foto_profil)
              <img src="{{ asset('img/fotoprofile/' . Auth::user()->foto_profil) }}" alt="Foto Profil" class="rounded-full w-8 h-8 object-cover">
            @else
              <img src="{{ asset('img/images.jpeg') }}" alt="Profile Picture" class="rounded-full w-8 h-8 object-cover">
            @endif
          </button>

          <div 
            x-show="open" 
            @click.away="open = false" 
            x-transition
            class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5"
            style="display: none;"
          >
            <a href="{{ route('profile') }}" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100">
              Profil Saya
            </a>

            <a href="{{ route('admin.dashboard') }}">
              @if(Auth::user()->role == 'admin')
                <span class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100">Admin Panel</span>
              @endif
            </a>

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
        {{-- Jika Belum Login --}}
        <a href="{{ route('login') }}" class="bg-white text-black text-sm font-semibold px-5 py-2 rounded-xl hover:bg-gray-100 transition-colors">
          Masuk
        </a>
        <a href="{{ route('register') }}" class="bg-white text-black text-sm font-semibold px-5 py-2 rounded-xl hover:bg-gray-100 transition-colors">
          Daftar
        </a>
      @endauth
    </div>
  </div>

  <!-- NAVBAR MOBILE -->
  <div class="md:hidden bg-[#00795E] p-3 rounded-b-xl shadow-md">
    <div class="flex items-center space-x-2">
      <input 
        type="text" 
        class="flex-grow w-full bg-white rounded-xl py-2 px-4 text-gray-900 placeholder-gray-500 focus:outline-none"
        placeholder="Cari..."
      >
      @auth
        <a href="{{ route('profile') }}" class="flex-shrink-0 text-black bg-white p-2 rounded-full hover:bg-gray-100 transition-colors">
          @if(Auth::user()->foto_profil)
            <img src="{{ asset('img/fotoprofile/' . Auth::user()->foto_profil) }}" alt="Foto Profil" class="w-6 h-6 rounded-full object-cover">
          @else
            <i class="bi bi-person-circle text-xl"></i>
          @endif
        </a>
      @else
        <a href="{{ route('login') }}" class="flex-shrink-0 text-black bg-white p-2 rounded-full hover:bg-gray-100 transition-colors">
          <i class="bi bi-person-circle text-xl"></i>
        </a>
      @endauth
    </div>
  </div>
</nav>

<!-- Spacer agar konten tidak tertutup navbar -->
<div class="h-[90px] md:h-[100px]"></div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
