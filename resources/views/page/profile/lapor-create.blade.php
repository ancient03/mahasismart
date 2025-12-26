<x-layout.layout-profile>
    <section class="md:col-span-3">
        <div class="py-3 px-5 lg:rounded-md shadow-md bg-white mb-6 flex justify-between items-center">
            <h1 class="lg:text-2xl text-xl font-semibold">Ajukan Laporan</h1>
            <a href="{{ route('pesanan.show', $transaksi->id_transaksi) }}" class="text-blue-600 hover:underline text-sm">&laquo; Kembali</a>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            {{-- Info Pesanan Singkat --}}
            <div class="bg-gray-50 p-4 rounded-lg mb-6 border border-gray-200">
                <p class="text-sm text-gray-600">No. Invoice:</p>
                <p class="font-bold text-gray-800">{{ $transaksi->nomor_invoice }}</p>
                <p class="text-sm text-gray-600 mt-2">Total Pesanan:</p>
                <p class="font-bold text-[#00795E]">Rp {{ number_format($transaksi->total_harga_keseluruhan, 0, ',', '.') }}</p>
            </div>

            <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="id_transaksi" value="{{ $transaksi->id_transaksi }}">

                {{-- Jenis Masalah --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Apa masalah yang Anda alami? <span class="text-red-600">*</span></label>
                    <select name="jenis_masalah" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500 p-2 border @error('jenis_masalah') border-red-500 @enderror">
                        <option value="" disabled selected>-- Pilih Masalah --</option>
                        <option value="barang_rusak" {{ old('jenis_masalah') == 'barang_rusak' ? 'selected' : '' }}>Barang Rusak / Cacat</option>
                        <option value="tidak_sesuai" {{ old('jenis_masalah') == 'tidak_sesuai' ? 'selected' : '' }}>Barang Tidak Sesuai Pesanan</option>
                        <option value="tidak_sampai" {{ old('jenis_masalah') == 'tidak_sampai' ? 'selected' : '' }}>Pesanan Belum Sampai</option>
                        <option value="lainnya" {{ old('jenis_masalah') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('jenis_masalah')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Detail <span class="text-red-600">*</span></label>
                    <textarea name="deskripsi" rows="4" required placeholder="Ceritakan kronologi masalahnya..." 
                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500 p-2 border @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bukti Foto --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Foto <span class="text-red-600">*</span></label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center @error('bukti_foto') border-red-500 @enderror">
                        <input type="file" name="bukti_foto" id="bukti_foto" accept="image/*" required 
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                        <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                    </div>
                    @error('bukti_foto')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-lg font-bold hover:bg-red-700 transition">
                    Kirim Laporan
                </button>
            </form>
        </div>
    </section>
</x-layout.layout-profile>