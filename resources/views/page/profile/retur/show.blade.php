<x-layout.layout-profile>
    <section class="md:col-span-3">
        <div class="py-3 px-5 lg:rounded-md shadow-md bg-white">
            <div class="flex items-center gap-4">
<a href="{{ route('pesanan.show', $retur->detailTransaksi->transaksi->id_transaksi) }}" class="text-gray-500 hover:text-gray-700">
    <i class="bi bi-arrow-left-circle text-2xl"></i>
</a>
                <h1 class="lg:text-2xl text-1xl font-semibold">Detail Retur Barang</h1>
            </div>
        </div>

        <div class="mt-6 lg:rounded-md shadow-md bg-white w-full p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-lg font-semibold border-b pb-2">Informasi Retur</h2>
                    <div class="mt-4 space-y-2">
                        <p><strong>No. Retur:</strong> #{{ $retur->id }}</p>
                        <p><strong>Tanggal Pengajuan:</strong> {{ $retur->created_at->format('d M Y, H:i') }}</p>
                        <p><strong>Status:</strong>
                            @if ($retur->status == 'disetujui')
                                <span class="bg-green-200 py-1 px-3 rounded-md text-green-800 font-medium text-sm">Disetujui</span>
                            @elseif ($retur->status == 'ditolak')
                                <span class="bg-red-200 py-1 px-3 rounded-md text-red-800 font-medium text-sm">Ditolak</span>
                            @else
                                <span class="bg-yellow-200 py-1 px-3 rounded-md text-yellow-800 font-medium text-sm">Pending</span>
                            @endif
                        </p>
                        <p><strong>Alasan:</strong> {{ $retur->alasan }}</p>
                        <p><strong>Catatan:</strong> {{ $retur->catatan ?? '-' }}</p>
                    </div>
                </div>
                <div>
                    <h2 class="text-lg font-semibold border-b pb-2">Informasi Barang</h2>
                    <div class="mt-4 flex gap-4">
                        <img src="{{ $retur->detailTransaksi->barang?->foto_barang ? asset('img/fotobarang/' . $retur->detailTransaksi->barang->foto_barang) : 'https://via.placeholder.com/150?text=No+Image' }}"
                            alt="{{ $retur->detailTransaksi->barang?->nama_barang ?? 'Barang Dihapus' }}"
                            class="h-24 w-24 rounded-md object-cover">
                        <div>
                            <p class="font-semibold">{{ $retur->detailTransaksi->barang->nama_barang }}</p>
                            <p class="text-sm text-gray-600">{{ $retur->detailTransaksi->kuantitas }} barang x Rp {{ number_format($retur->detailTransaksi->harga_saat_transaksi, 0, ',', '.') }}</p>
                             <p class="text-sm text-gray-500">Invoice: {{ $retur->detailTransaksi->transaksi->nomor_invoice }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout.layout-profile>
