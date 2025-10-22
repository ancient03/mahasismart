<x-layout>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <section class="bg-gray-300 h-64 rounded-lg flex items-center justify-center text-gray-600 font-bold text-xl">
                Banner Info/Iklan/Promo
            </section>

            <section class="bg-white p-5 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-4">Kategori</h2>
                
                <div class="flex overflow-x-auto space-x-4 pb-4">
                    
                    {{-- Untuk Kategori taroh di bawah ini --}}
                    @for ($i = 0; $i < 9; $i++)
                    <div class="flex-shrink-0 w-24">
                        <div class="w-24 h-24 bg-gray-300 rounded-lg">
                            </div>
                        <p class="text-center text-sm mt-2 font-medium">Kategori {{ $i + 1 }}</p>
                    </div>
                    @endfor

                </div>
            </section>

            <section>
                <h2 class="text-xl font-bold mb-4">Produk Pilihan</h2>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    
                    {{-- Komponen Card di panggil di sini--}}
                    <x-card/>
                    <x-card/>
                    <x-card/>
                    <x-card/>
                    <x-card/>
                    <x-card/>
                    <x-card/>
                    <x-card/>

                </div>
            </section>

        </div>
 </x-layout>