<x-layout>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Judul Pencarian Dinamis (Tambahan) --}}
            <div class="mb-4">
                @if(isset($query) && $query)
                    <h2 class="text-2xl font-semibold text-gray-900">
                        Hasil pencarian untuk: <span class="font-bold text-green-700">"{{ $query }}"</span>
                    </h2>
                @else
                    <h2 class="text-2xl font-semibold text-gray-900">
                        Menampilkan semua produk.
                    </h2>
                @endif
            </div>

            {{-- Template Tab "Produk" dan "Toko" Anda --}}
            <div class="flex items-center space-x-2 mb-6">
                <button class="bg-green-700 text-white font-semibold py-2 px-6 rounded-lg"> {{-- Dibuat aktif --}}
                    Produk
                </button>
                <button class="bg-gray-200 text-gray-700 hover:bg-gray-300 font-semibold py-2 px-6 rounded-lg transition-colors">
                    Toko
                </button>
            </div>
            
            {{-- Template Section Anda --}}
            <section>
                {{-- Template Grid Anda --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                    
                    {{-- 
                      MENGGANTI KOMENTAR DENGAN LOOP DINAMIS
                      Looping data '$barangList' yang dikirim dari SearchController 
                    --}}
                    @forelse ($barangList as $barang)
                        
                        {{-- KODE CARD ANDA DIMULAI DI SINI --}}
                        <x-cardproduk.card :barang="$barang" /> 
                        {{-- KODE CARD ANDA BERAKHIR DI SINI --}}

                    @empty
                        {{-- Tampilan jika tidak ada hasil --}}
                        <div class="col-span-full text-center text-gray-500 py-10">
                            <i class="bi bi-search text-4xl mb-2"></i>
                            <p>Produk tidak ditemukan untuk <span class="font-semibold">"{{ $query ?? '' }}"</span>.</p>
                        </div>
                    @endforelse
                    {{-- Akhir Loop --}}

                </div>
            </section>

             {{-- Link Pagination (Penting untuk search) --}}
             <div class="mt-8">
                 {{ $barangList->appends(request()->query())->links() }} 
             </div>

        </div>
</x-layout> 