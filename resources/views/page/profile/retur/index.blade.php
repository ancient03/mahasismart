<x-layout.layout-profile>
    <section class="md:col-span-3">
        <div class="py-3 px-5 lg:rounded-md shadow-md bg-white">
            <h1 class="lg:text-2xl text-1xl font-semibold">Riwayat Retur Barang</h1>
        </div>

        @if (session('success'))
            <div class="mt-6 rounded-md bg-green-100 p-4 text-sm font-medium text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @forelse ($returs as $retur)
            <div class="mt-6 lg:rounded-md shadow-md bg-white w-full">
                <div class="p-4 border-b flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                    <div>
                        <span class="font-semibold text-gray-800">No. Retur: #{{ $retur->id }}</span>
                        <p class="text-sm text-gray-500">Tanggal Pengajuan: {{ $retur->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    {{-- Status Retur --}}
                    @if ($retur->status == 'disetujui')
                        <div class="bg-green-200 py-2 px-6 rounded-md text-green-800 font-medium text-sm">
                            Disetujui
                        </div>
                    @elseif ($retur->status == 'ditolak')
                        <div class="bg-red-200 py-2 px-6 rounded-md text-red-800 font-medium text-sm">
                            Ditolak
                        </div>
                    @else
                        <div class="bg-yellow-200 py-2 px-6 rounded-md text-yellow-800 font-medium text-sm">
                            Pending
                        </div>
                    @endif
                </div>

                <div class="p-4 flex flex-col md:flex-row gap-4">
                    <div class="flex-shrink-0">
                        <img src="{{ $retur->detailTransaksi->barang?->foto_barang ? asset('img/fotobarang/' . $retur->detailTransaksi->barang->foto_barang) : 'https://via.placeholder.com/150?text=No+Image' }}"
                             alt="{{ $retur->detailTransaksi->barang?->nama_barang ?? 'Barang Dihapus' }}"
                             class="h-24 w-24 rounded-md object-cover">
                    </div>
                    <div class="flex-1">
                        <h2 class="text-lg font-semibold">{{ $retur->detailTransaksi->barang->nama_barang }}</h2>
                        <p class="text-sm text-gray-600">Alasan: {{ $retur->alasan }}</p>
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('retur.show', $retur->id) }}" class="bg-blue-600 text-white py-2 px-6 rounded-md font-medium hover:bg-blue-700 transition duration-300 text-sm">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-4 mt-6 lg:rounded-md shadow-md bg-white w-full text-center text-gray-500 py-10">
                <i class="bi bi-box-seam text-6xl text-gray-300"></i>
                <h2 class="mt-4 text-xl font-semibold text-gray-700">Anda Belum Pernah Mengajukan Retur</h2>
                <p class="text-gray-500 mt-2">Semua riwayat retur Anda akan muncul di sini.</p>
            </div>
        @endforelse
    </section>
</x-layout.layout-profile>
