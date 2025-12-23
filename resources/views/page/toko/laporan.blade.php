<x-layout.layout-profile>
    <section class="md:col-span-3">
        <div class="py-3 px-5 lg:rounded-md shadow-md bg-white mb-6">
            <h1 class="lg:text-2xl text-1xl font-semibold">Komplain / Laporan Pembeli</h1>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3">Invoice</th>
                            <th class="px-6 py-3">Pembeli</th>
                            <th class="px-6 py-3">Masalah</th>
                            <th class="px-6 py-3">Bukti</th>
                            <th class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporanList as $laporan)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium">{{ $laporan->transaksi->nomor_invoice }}</td>
                                <td class="px-6 py-4">{{ $laporan->user->username }}</td>
                                <td class="px-6 py-4">
                                    <span class="font-bold block">{{ ucfirst(str_replace('_', ' ', $laporan->jenis_masalah)) }}</span>
                                    <span class="text-xs text-gray-500">{{ Str::limit($laporan->deskripsi, 50) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($laporan->bukti_foto)
                                        <a href="{{ asset('img/buktilaporan/' . $laporan->bukti_foto) }}" target="_blank" class="text-blue-600 underline">Lihat Foto</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($laporan->status_laporan == 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Menunggu Admin</span>
                                    @elseif($laporan->status_laporan == 'selesai')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Selesai (Disetujui)</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada laporan masuk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4">{{ $laporanList->links() }}</div>
        </div>
    </section>
</x-layout.layout-profile>