<x-layout>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="flex items-center space-x-2 mb-6">
                <button class="bg-gray-200 text-gray-900 font-semibold py-2 px-6 rounded-lg">
                    Produk
                </button>
                <button class="bg-gray-700 text-gray-300 hover:bg-gray-600 font-semibold py-2 px-6 rounded-lg transition-colors">
                    Toko
                </button>
            </div>
            
            <section>
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