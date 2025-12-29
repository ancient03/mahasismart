<x-layout.layout-profile>

    {{-- Kolom Kanan (Konten Utama) --}}
    {{-- Menggunakan col-span-3 agar pas dengan sidebar (total 4 kolom) --}}
    <section class="md:col-span-3">
        
        {{-- Header --}}
        <div class="py-3 px-5 lg:rounded-md shadow-md bg-white">
            <h1 class="lg:text-2xl text-1xl font-semibold">Daftar Pengajuan Retur</h1>
        </div>

        {{-- Alert Sukses --}}
        @if(session('success'))
            <div class="mt-6 rounded-md bg-green-100 p-4 text-sm font-medium text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Wrapper Konten Utama (Tabel) --}}
        <div class="mt-6 lg:rounded-md shadow-md bg-white w-full p-6">
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-6 py-3">Tgl</th>
                            <th class="px-6 py-3">Pembeli</th>
                            <th class="px-6 py-3">Barang</th>
                            <th class="px-6 py-3">Alasan</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($returs as $retur)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                {{-- Tanggal --}}
                                <td class="px-6 py-4">
                                    {{ $retur->created_at->format('d/m/Y') }}
                                </td>
                                
                                {{-- Pembeli --}}
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $retur->detailTransaksi->transaksi->user?->username ?? 'User Dihapus' }}
                                </td>
                                
                                {{-- Barang --}}
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $retur->detailTransaksi->barang->nama_barang }}</div>
                                    <div class="text-xs text-gray-400">Qty: {{ $retur->detailTransaksi->kuantitas }}</div>
                                </td>
                                
                                {{-- Alasan --}}
                                <td class="px-6 py-4">
                                    <div class="truncate max-w-[150px]" title="{{ $retur->alasan }}">
                                        {{ Str::limit($retur->alasan, 20) }}
                                    </div>
                                </td>
                                
                                {{-- Status --}}
                                <td class="px-6 py-4">
                                    @if ($retur->status == 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded border border-yellow-200">
                                            Pending
                                        </span>
                                    @elseif ($retur->status == 'disetujui')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-200">
                                            Disetujui
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-200">
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                                
                                {{-- Aksi --}}
                                <td class="px-6 py-4">
                                    <a href="{{ route('toko.retur.show', $retur->id) }}" 
                                       class="text-blue-600 hover:text-blue-800 font-medium text-sm border border-blue-600 px-3 py-1.5 rounded-md hover:bg-blue-50 transition duration-300 flex items-center gap-1 w-fit">
                                        Proses
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="bi bi-inbox text-4xl text-gray-300 mb-2"></i>
                                        <p>Tidak ada pengajuan retur saat ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="mt-4">
                {{ $returs->links() }}
            </div>

        </div>

    </section>
</x-layout.layout-profile>