<nav class="rounded-b-xl bg-[#00795E] shadow-md">
    
    <div class="hidden md:flex bg-[#00795E] items-center justify-between container mx-auto px-6 py-5">
      
        <div class="flex-shrink-0">
            <a href="/" class="text-yellow-500 text-3xl font-bold flex items-center space-x-2">
                <img src="{{ asset('img/kuning-nobg.png') }}" alt="Logo MahasisMart" class="h-10 w-auto">
    
                <span class="text-2xl font-bold">MahasisMart</span>
            </a>
        </div>

      <div class="flex-grow max-w-xl mx-4">
        <input 
          type="text" 
          class="w-full bg-white rounded-xl py-2 px-4 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-300"
          aria-label="Search"
          placeholder="Cari..."
        >
      </div>

      <div class="flex-shrink-0 flex items-center space-x-4">
        
        <a href="/cart" class="text-white hover:text-gray-200" aria-label="Lihat Keranjang">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c.51 0 .96-.341 1.087-.835l1.833-6.143a.62.62 0 0 0-.58-.835H5.438M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75v-.008Zm7.5 0a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" />
          </svg>
        </a>

        <a href="/login" class="bg-white text-black text-sm font-semibold px-5 py-2 rounded-xl hover:bg-gray-100 transition-colors">
          Masuk
        </a>

        <a href="/register" class="bg-white text-black text-sm font-semibold px-5 py-2 rounded-xl hover:bg-gray-100 transition-colors">
          Daftar
        </a>
        
      </div>
    </div>

    <div class="rounded-b-xl md:hidden bg-gradient-to-r from-orange-400 to-yellow-500 p-3">
        <div class="flex items-center space-x-2">
            
            <input 
              type="text" 
              class="flex-grow w-full bg-white rounded-xl py-2 px-4 text-gray-900 placeholder-gray-500 focus:outline-none"
              aria-label="Search"
              placeholder="Cari..."
            >

            <a href="/profile" class="flex-shrink-0 text-black bg-white p-2 rounded-full hover:bg-gray-100 transition-colors" aria-label="Profil Pengguna">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
              </svg>
            </a>
            
        </div>
    </div>

</nav>