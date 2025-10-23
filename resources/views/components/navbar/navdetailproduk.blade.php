<nav class="fixed top-0 left-0 w-full z-50 bg-transparent px-6 py-4">
  <div class="flex items-center justify-between">
    
    {{-- tombol kembali --}}
    <button class="cursor-pointer">
      <i class="bi bi-arrow-left text-2xl text-[#00795E]"></i>
    </button>

    {{-- ikon keranjang dengan notifikasi --}}
    <button class="cursor-pointer relative">
      <i class="bi bi-cart text-2xl text-[#00795E]"></i>

      {{-- badge notifikasi --}}
      <span class="absolute -top-1 -right-2 bg-red-500 text-white text-[10px] font-semibold rounded-full px-1.5 py-0.5 leading-none">
        10
      </span>
    </button>

  </div>
</nav>
