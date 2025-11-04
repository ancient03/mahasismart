<x-layout>
         <div class="container mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <section class="lg:col-span-2 space-y-6">
                    
                    <h1 class="text-3xl font-bold text-gray-900">Keranjang</h1>

                    <!-- Menampilkan pesan Sukses/Status -->
                    @if (session('status'))
                        <div class="mb-4 rounded-md bg-green-100 p-4 text-sm font-medium text-green-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Loop untuk setiap item di keranjang --}}
                    @forelse ($items as $item)
                        {{-- 
                          Memanggil komponen card-chart
                          Mengirim data $item (yang berisi data Keranjang & Barang)
                        --}}
                        <x-cardproduk.card-chart :item="$item" />
                    @empty
                        {{-- Tampilan jika keranjang kosong --}}
                        <div class="bg-white rounded-lg shadow-md p-10 text-center">
                            <i class="bi bi-cart-x text-6xl text-gray-300"></i>
                            <h2 class="mt-4 text-xl font-semibold text-gray-700">Keranjang Anda Kosong</h2>
                            <p class="text-gray-500 mt-2">Sepertinya Anda belum menambahkan barang apapun.</p>
                            <a href="{{ route('home') }}" class="mt-6 inline-block bg-green-600 text-white py-2 px-5 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                                Mulai Belanja
                            </a>
                        </div>
                    @endforelse
                    {{-- Akhir Loop --}}

                </section>

                {{-- Kolom Total Belanja (Dinamis) --}}
                <section class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-28"> {{-- Ubah top-6 jadi top-28 (sesuai tinggi navbar) --}}
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Total</h2>
                        
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Total Harga</span>
                            {{-- Tampilkan total harga dari controller --}}
                            <span class="text-gray-900 font-medium">Rp. {{ number_format($totalHarga, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="border-t border-gray-200 my-4"></div>

                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xl font-bold text-gray-900">Total</span>
                            <span class="text-xl font-bold text-gray-900">Rp. {{ number_format($totalHarga, 0, ',', '.') }}</span>
                        </div>

                        {{-- Tombol Beli (Mengarah ke route checkout) --}}
                            <a href="{{ route('checkout.index') }}" 
                               class="flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white w-full py-3 rounded-lg font-bold text-lg transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                                <span>BELI</span>
                                <i class="bi bi-arrow-right-circle-fill"></i>
                            </a>
                    </div>
                </section>

            </div>
        </div>
</x-layout>