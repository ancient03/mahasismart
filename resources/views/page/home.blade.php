<x-layout>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 space-y-8 py-6">

    <!-- Banner -->
    <section
      class="bg-gray-300 h-64 rounded-xl flex items-center justify-center text-gray-700 font-semibold text-xl shadow-inner">
      Banner Info / Iklan / Promo
    </section>

    <!-- Kategori -->
    <section class="bg-white p-5 rounded-xl shadow">
      <h2 class="text-xl font-bold mb-4 text-gray-900">Kategori</h2>

      <div class="flex overflow-x-auto space-x-3 pb-2 scrollbar-thin scrollbar-thumb-gray-300">
        @for ($i = 0; $i < 9; $i++)
          <div class="flex-shrink-0 w-20 text-center">
            <div class="w-16 h-16 bg-gray-200 rounded-full mx-auto mb-2"></div>
            <p class="text-sm font-medium text-gray-700 truncate">Kategori {{ $i + 1 }}</p>
          </div>
        @endfor
      </div>
    </section>

    <!-- Produk Pilihan -->
    <section>
      <h2 class="text-xl font-bold mb-4 text-gray-900">Produk Pilihan</h2>

      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
        {{-- Komponen Card dipanggil di sini --}}
        @for ($i = 0; $i < 10; $i++)
          <x-card />
        @endfor
      </div>
    </section>

  </div>
</x-layout>
