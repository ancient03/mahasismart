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
                    @forelse ($kategoriList as $kategori)
                        {{-- Link ke halaman pencarian untuk kategori ini (buat rutenya nanti) --}}
                        <a href="{{-- route('search.kategori', $kategori->id_kategori) --}}" 
                           class="flex-shrink-0 w-20 text-center group">
                            
                            {{-- Tampilkan Gambar Kategori --}}
                            <div class="w-16 h-16 bg-gray-200 rounded-full mx-auto mb-2 overflow-hidden border-2 border-transparent group-hover:border-green-500 transition">
                                @if($kategori->gambar)
                                    {{-- Controller Anda menyimpan path lengkap 'img/fotokategori/...' --}}
                                    <img src="{{ asset($kategori->gambar) }}" alt="{{ $kategori->nama_kategori }}" class="w-full h-full object-cover">
                                @else
                                    {{-- Placeholder jika tidak ada gambar --}}
                                    <span class="flex items-center justify-center h-full text-3xl text-gray-400">
                                        <i class="bi bi-tag-fill"></i>
                                    </span>
                                @endif
                            </div>
                            
                            {{-- Tampilkan Nama Kategori --}}
                            <p class="text-sm font-medium text-gray-700 truncate group-hover:text-green-600" title="{{ $kategori->nama_kategori }}">
                                {{ $kategori->nama_kategori }}
                            </p>
                        </a>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada kategori yang tersedia.</p>
                    @endforelse
                </div>
    </section>

            <section>
                <h2 class="text-xl font-bold mb-4">Semua Produk</h2>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                    
                    {{-- Loop data barang dari controller --}}
                    @forelse ($barangList as $barang) 
                        {{-- 
                          👇 PERBAIKAN DI SINI 👇
                          Kirim variabel '$barang' dari loop ke komponen 
                          sebagai properti bernama 'barang'.
                          Gunakan ':' sebelum nama properti.
                          Pastikan nama komponen 'cardproduk.card' sudah benar.
                        --}}
                        <x-cardproduk.card :barang="$barang" /> 
                        
                    @empty
                        {{-- Pesan jika tidak ada produk sama sekali --}}
                        <p class="col-span-full text-center text-gray-500 py-10">
                            Belum ada produk yang tersedia saat ini.
                        </p>
                    @endforelse

                </div>

                 {{-- Tampilkan Link Pagination --}}
                 <div class="mt-8">
                     {{ $barangList->links() }} 
                 </div>

            </section>

  </div>
</x-layout>
