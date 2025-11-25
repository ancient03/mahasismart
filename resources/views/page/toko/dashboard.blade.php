<x-layout.layout-profile>
    <section class="md:col-span-3">

        {{-- 1. Header Sambutan --}}
        <div class="bg-white rounded-lg shadow-md p-6 mb-6 border-l-4 border-[#00795E]">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Dashboard Toko</h1>
                    <p class="text-gray-600 mt-1">Selamat datang kembali, <span class="font-semibold text-[#00795E]">{{ $toko->nama_toko }}</span>!</p>
                </div>
            </div>
        </div>

        {{-- 2. Kartu Statistik Ringkas (Cards) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <!-- Card 1: Pendapatan -->
            <div class="bg-white p-5 rounded-lg shadow hover:shadow-md transition border border-gray-100">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Pendapatan</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                    </div>
                    <div class="p-2 bg-green-100 text-green-600 rounded-lg">
                        <i class="bi bi-cash-stack text-xl"></i>
                    </div>
                </div>
                <a href="{{ route('statistik-penjualan') }}" class="text-xs text-green-600 hover:underline mt-4 block">Lihat detail keuangan &rarr;</a>
            </div>

            <!-- Card 2: Pesanan Perlu Dikirim -->
            <div class="bg-white p-5 rounded-lg shadow hover:shadow-md transition border border-gray-100">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Perlu Dikirim</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $pesananPerluDikirim }}</h3>
                    </div>
                    <div class="p-2 bg-red-100 text-red-600 rounded-lg">
                        <i class="bi bi-box-seam text-xl"></i>
                    </div>
                </div>
                <a href="{{ route('pesanan-masuk') }}" class="text-xs text-red-600 hover:underline mt-4 block">Proses pesanan sekarang &rarr;</a>
            </div>

            <!-- Card 3: Total Produk -->
            <div class="bg-white p-5 rounded-lg shadow hover:shadow-md transition border border-gray-100">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Produk</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalProduk }}</h3>
                    </div>
                    <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                        <i class="bi bi-tags text-xl"></i>
                    </div>
                </div>
                <a href="{{ route('produk-saya.index') }}" class="text-xs text-blue-600 hover:underline mt-4 block">Kelola produk &rarr;</a>
            </div>
        </div>

        {{-- 3. Tabel Pesanan Terbaru --}}
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-gray-800">Pesanan Terbaru</h3>
                <a href="{{ route('pesanan-masuk') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3">Produk</th>
                            <th class="px-6 py-3">Pembeli</th>
                            <th class="px-6 py-3">Harga</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pesananTerbaru as $item)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $item->barang->nama_barang ?? 'Item Dihapus' }}
                                    <span class="text-gray-500 text-xs block">x{{ $item->kuantitas }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->transaksi->user->username ?? 'User Dihapus' }}
                                </td>
                                <td class="px-6 py-4">
                                    Rp {{ number_format($item->harga_saat_transaksi * $item->kuantitas, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    @php $status = $item->transaksi->status_pengiriman; @endphp
                                    @if ($status == 'diproses')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Diproses</span>
                                    @elseif ($status == 'dikirim')
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Dikirim</span>
                                    @elseif ($status == 'selesai')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Selesai</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ ucfirst($status) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('pesanan-masuk') }}" class="font-medium text-blue-600 hover:underline">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada pesanan masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</x-layout.layout-profile>