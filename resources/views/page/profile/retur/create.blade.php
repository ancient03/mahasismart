<x-layout.layout-profile>
    <section class="md:col-span-3">
        <div class="py-3 px-5 lg:rounded-md shadow-md bg-white">
            <h1 class="lg:text-2xl text-1xl font-semibold">Ajukan Retur Barang</h1>
        </div>

        <div class="mt-6 lg:rounded-md shadow-md bg-white w-full p-6">
            <div class="border-b pb-4 mb-4">
                <h2 class="text-lg font-semibold">Detail Barang</h2>
                <div class="mt-4 flex gap-4">
                    <img src="{{ $detail_transaksi->barang?->foto_barang ? asset('img/fotobarang/' . $detail_transaksi->barang->foto_barang) : 'https://via.placeholder.com/150?text=No+Image' }}"
                         alt="{{ $detail_transaksi->barang?->nama_barang ?? 'Barang Dihapus' }}"
                         class="h-24 w-24 rounded-md object-cover">
                    <div>
                        <p class="font-semibold">{{ $detail_transaksi->barang->nama_barang }}</p>
                        <p class="text-sm text-gray-600">{{ $detail_transaksi->kuantitas }} barang x Rp {{ number_format($detail_transaksi->harga_saat_transaksi, 0, ',', '.') }}</p>
                        <p class="font-bold">Total: Rp {{ number_format($detail_transaksi->kuantitas * $detail_transaksi->harga_saat_transaksi, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('retur.store') }}" method="POST">
                @csrf
                <{{-- PERBAIKAN: Gunakan id_detail_transaksi, BUKAN id --}}
<input type="hidden" name="detail_transaksi_id" value="{{ $detail_transaksi->id_detail_transaksi }}">

{{-- TAMBAHAN: Tampilkan error jika hidden input bermasalah agar ketahuan --}}
@error('detail_transaksi_id')
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ $message }}</span>
    </div>
@enderror

                <div class="mb-4">
                    <label for="alasan" class="block text-sm font-medium text-gray-700 mb-1">Alasan Retur</label>
                    <input type="text" name="alasan" id="alasan" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="{{ old('alasan') }}" required>
                    @error('alasan')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                    <textarea name="catatan" id="catatan" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('catatan') }}</textarea>
                    @error('catatan')
                         <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 mt-6">
                    <a href="{{ route('pesanan.show', $detail_transaksi->id_transaksi) }}" class="bg-zinc-200 py-2 px-6 rounded-md text-zinc-700 font-medium cursor-pointer hover:bg-zinc-300 transition duration-500 text-sm">Batal</a>
                    <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-md font-medium hover:bg-blue-700 transition duration-300 text-sm">Ajukan Retur</button>
                </div>
            </form>
        </div>
    </section>
</x-layout.layout-profile>
