<x-layout.layout-profile>

    {{-- WRAPPER UTAMA: Menggunakan col-span-3 agar mengisi 75% layar (sisa sidebar) --}}
    <section class="md:col-span-3">
        
        {{-- 1. HEADER --}}
        <div class="py-3 px-5 lg:rounded-md shadow-md bg-white mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('toko.retur.index') }}" class="text-gray-500 hover:text-gray-700">
                    <i class="bi bi-arrow-left-circle text-2xl"></i>
                </a>
                <h1 class="lg:text-2xl text-xl font-semibold">Detail Pengajuan Retur</h1>
            </div>
        </div>

        {{-- 2. KONTEN UTAMA --}}
        <div class="lg:rounded-md shadow-md bg-white w-full p-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- Bagian Kiri: Info Barang & Pembeli --}}
                <div>
                    {{-- Info Produk --}}
                    <h3 class="text-lg font-semibold mb-3 text-gray-700 border-b pb-2">Informasi Produk</h3>
                    <div class="flex gap-4 p-4 border rounded-lg bg-gray-50">
                        <img src="{{ $retur->detailTransaksi->barang?->foto_barang ? asset('img/fotobarang/' . $retur->detailTransaksi->barang->foto_barang) : 'https://via.placeholder.com/150' }}" 
                             class="w-20 h-20 object-cover rounded-md border" alt="Produk">
                        <div>
                            <p class="font-bold text-gray-900">{{ $retur->detailTransaksi->barang->nama_barang }}</p>
                            <div class="text-sm text-gray-600 mt-1 space-y-1">
                                <p>Harga: <span class="font-medium">Rp {{ number_format($retur->detailTransaksi->harga_saat_transaksi, 0, ',', '.') }}</span></p>
                                <p>Qty: <span class="font-medium">{{ $retur->detailTransaksi->kuantitas }}</span></p>
                                <p class="font-bold text-gray-800">Total: Rp {{ number_format($retur->detailTransaksi->harga_saat_transaksi * $retur->detailTransaksi->kuantitas, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Info Pembeli --}}
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-3 text-gray-700 border-b pb-2">Data Pembeli</h3>
                        <div class="bg-gray-50 p-4 rounded-lg border space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Nama Pembeli:</span>
                                <span class="font-medium text-gray-900">{{ $retur->detailTransaksi->transaksi->user?->username ?? 'User Dihapus' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">No. Invoice:</span>
                                <a href="{{ route('pesanan-masuk.show', $retur->detailTransaksi->transaksi->id_transaksi) }}" class="font-medium text-blue-600 hover:underline">
                                    {{ $retur->detailTransaksi->transaksi->nomor_invoice }}
                                </a>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Tanggal Transaksi:</span>
                                <span class="font-medium text-gray-900">{{ $retur->detailTransaksi->transaksi->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bagian Kanan: Info Retur & Aksi --}}
                <div>
                    <h3 class="text-lg font-semibold mb-3 text-gray-700 border-b pb-2">Detail Komplain</h3>
                    <div class="space-y-4">
                        
                        {{-- Status Badge --}}
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase block mb-1">Status Pengajuan</label>
                            @if ($retur->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold border border-yellow-200">Menunggu Konfirmasi</span>
                            @elseif ($retur->status == 'disetujui')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold border border-green-200">Disetujui</span>
                            @else
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold border border-red-200">Ditolak</span>
                            @endif
                        </div>

                        {{-- Alasan --}}
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase block mb-1">Alasan Retur</label>
                            <div class="text-gray-800 bg-gray-50 p-3 rounded border border-gray-200 text-sm leading-relaxed">
                                "{{ $retur->alasan }}"
                            </div>
                        </div>

                        {{-- Catatan --}}
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase block mb-1">Catatan Tambahan</label>
                            <div class="text-gray-800 bg-gray-50 p-3 rounded border border-gray-200 text-sm min-h-[60px]">
                                {{ $retur->catatan ?? '-' }}
                            </div>
                        </div>
                    </div>

                    {{-- FORM AKSI (Hanya muncul jika status pending) --}}
                    @if ($retur->status == 'pending')
                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <h4 class="font-semibold mb-3 text-gray-800">Tindakan Toko:</h4>
                            <div class="flex gap-3">
                                {{-- Tombol Tolak --}}
                                <form action="{{ route('toko.retur.update', $retur->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin MENOLAK pengajuan ini?');">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="ditolak">
                                    <button type="submit" class="w-full bg-white border border-red-500 text-red-600 hover:bg-red-50 px-4 py-2.5 rounded-lg font-medium transition duration-200 text-sm">
                                        Tolak Pengajuan
                                    </button>
                                </form>

                                {{-- Tombol Terima --}}
                                <form action="{{ route('toko.retur.update', $retur->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin MENYETUJUI pengajuan ini?');">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="disetujui">
                                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-lg font-medium transition duration-200 text-sm shadow-sm">
                                        Setujui Retur
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </section>
</x-layout.layout-profile>