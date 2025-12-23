<x-layout.layout-admin>
    <section class="md:col-span-3">
        <div class="py-3 px-5 lg:rounded-md shadow-md bg-white mb-6">
            <h1 class="lg:text-2xl text-1xl font-semibold">Kelola Laporan & Komplain</h1>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                        <tr>
                            <th class="px-4 py-3">Pelapor & Invoice</th>
                            <th class="px-4 py-3">Masalah</th>
                            <th class="px-4 py-3">Bukti</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporanList as $laporan)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-4 py-4">
                                    <p class="font-bold">{{ $laporan->user->username }}</p>
                                    <p class="text-xs text-blue-600">{{ $laporan->transaksi->nomor_invoice }}</p>
                                    <p class="text-xs text-gray-500">{{ $laporan->created_at->format('d M Y') }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="font-bold text-red-600 block mb-1">{{ ucfirst(str_replace('_', ' ', $laporan->jenis_masalah)) }}</span>
                                    <p class="text-gray-600 text-xs">{{ $laporan->deskripsi }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    @if($laporan->bukti_foto)
                                        <a href="{{ asset('img/buktilaporan/' . $laporan->bukti_foto) }}" target="_blank">
                                            <img src="{{ asset('img/buktilaporan/' . $laporan->bukti_foto) }}" class="h-16 w-16 object-cover rounded border">
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                     @if($laporan->status_laporan == 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Pending</span>
                                    @elseif($laporan->status_laporan == 'selesai')
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Diterima</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Ditolak</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-right">
                                    @if($laporan->status_laporan == 'pending')
                                        <div class="flex flex-col gap-2 items-end">
                                            {{-- Tombol Terima (Selesai) --}}
                                            <form action="{{ route('admin.laporan.update', $laporan->id_laporan) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status_laporan" value="selesai">
                                                <button onclick="return confirm('Terima laporan ini? (Misal: Refund user)')" class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700 w-24">
                                                    Terima
                                                </button>
                                            </form>

                                            {{-- Tombol Tolak --}}
                                            <form action="{{ route('admin.laporan.update', $laporan->id_laporan) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status_laporan" value="ditolak">
                                                <button onclick="return confirm('Tolak laporan ini?')" class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700 w-24">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs">Sudah diproses</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada laporan masuk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4">{{ $laporanList->links() }}</div>
        </div>
    </section>
</x-layout.layout-admin>