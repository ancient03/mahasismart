<x-layout.layout-profile>
    <section class="md:col-span-3">
        
        {{-- Header --}}
        <div class="py-3 px-5 lg:rounded-md shadow-md bg-white mb-6">
            <h1 class="lg:text-2xl text-1xl font-semibold">Statistik Penjualan</h1>
            <p class="text-sm text-gray-500">Pantau performa toko Anda di sini.</p>
        </div>

        {{-- Ringkasan Utama --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            {{-- Total Pendapatan --}}
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Total Pendapatan</p>
                        <h2 class="text-3xl font-bold text-gray-800 mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full text-green-600">
                        <i class="bi bi-cash-coin text-2xl"></i>
                    </div>
                </div>
            </div>

            {{-- Total Pesanan --}}
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Total Item Terjual</p>
                        <h2 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalPesanan }}</h2>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                        <i class="bi bi-bag-check text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status Pesanan --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">Status Pesanan Saat Ini</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                {{-- Diproses --}}
                <div class="flex items-center p-4 bg-yellow-50 rounded-lg border border-yellow-100">
                    <div class="p-3 bg-yellow-100 rounded-full text-yellow-600 mr-4">
                        <i class="bi bi-box-seam text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $pesananDiproses }}</p>
                        <p class="text-sm text-gray-600">Perlu Diproses</p>
                    </div>
                </div>

                {{-- Dikirim --}}
                <div class="flex items-center p-4 bg-blue-50 rounded-lg border border-blue-100">
                    <div class="p-3 bg-blue-100 rounded-full text-blue-600 mr-4">
                        <i class="bi bi-truck text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $pesananDikirim }}</p>
                        <p class="text-sm text-gray-600">Sedang Dikirim</p>
                    </div>
                </div>

                {{-- Selesai --}}
                <div class="flex items-center p-4 bg-green-50 rounded-lg border border-green-100">
                    <div class="p-3 bg-green-100 rounded-full text-green-600 mr-4">
                        <i class="bi bi-check-circle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $pesananSelesai }}</p>
                        <p class="text-sm text-gray-600">Selesai</p>
                    </div>
                </div>
            </div>
        </div>

    </section>
</x-layout.layout-profile>