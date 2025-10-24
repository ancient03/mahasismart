<x-layout>
     <div class="container mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <section class="lg:col-span-2 space-y-6">
                
                <h1 class="text-3xl font-bold text-gray-900">Keranjang</h1>

                {{-- produk --}}
                <x-cardproduk.card-chart />
                <x-cardproduk.card-chart />
                <x-cardproduk.card-chart />
                <x-cardproduk.card-chart />
                <x-cardproduk.card-chart />
                <x-cardproduk.card-chart />
                <x-cardproduk.card-chart />
                <x-cardproduk.card-chart />
                <x-cardproduk.card-chart />
                <x-cardproduk.card-chart />
                <x-cardproduk.card-chart />
                <x-cardproduk.card-chart />


            </section>

            <section class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Total</h2>
                    
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-600">Harga</span>
                        <span class="text-gray-900 font-medium">Rp. 60.000</span> {{-- Contoh total --}}
                    </div>
                    
                    <div class="border-t border-gray-200 my-4"></div>

                    <div class="flex justify-between items-center mb-4">
                        <span class="text-xl font-bold text-gray-900">Total</span>
                        <span class="text-xl font-bold text-gray-900">Rp. 60.000</span>
                    </div>

                    <button class="bg-yellow-500 hover:bg-yellow-600 text-black w-full py-3 rounded-lg font-bold text-lg transition-colors">
                        BELI
                    </button>
                </div>
            </section>

        </div>
        </div>
</x-layout>