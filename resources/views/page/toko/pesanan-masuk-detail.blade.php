<x-layout.layout-profile>
    <section class="md:col-span-3">
        
        <div class="py-3 px-5 lg:rounded-md shadow-md bg-white mb-6 flex justify-between items-center">
            <h1 class="lg:text-2xl text-1xl font-semibold">Detail Pesanan</h1>
            <a href="{{ route('toko.pesanan-masuk') }}" class="text-blue-600 hover:underline text-sm">&laquo; Kembali</a>
        </div>

        {{-- Card Info Utama --}}
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="font-bold text-lg text-gray-800 mb-3">Informasi Pesanan</h2>
                    <p class="text-sm text-gray-600 mb-1">Nama Pembeli: <span class="font-semibold text-gray-900">{{ $transaksi->user->username }}</span></p>
                    <p class="text-sm text-gray-600 mb-1">No. Invoice: <span class="font-semibold text-gray-900">{{ $transaksi->nomor_invoice }}</span></p>
                    <p class="text-sm text-gray-600 mb-1">Tanggal: <span class="font-semibold text-gray-900">{{ $transaksi->created_at->format('d M Y H:i') }}</span></p>
                    <p class="text-sm text-gray-600 mb-1">Metode Bayar: <span class="font-semibold text-gray-900">{{ $transaksi->metodePembayaran->nama_metode ?? 'N/A' }}</span></p>
                    <div class="mt-2">
                         <span class="font-medium text-sm text-gray-600">Status: </span>
                         @if ($transaksi->status_pengiriman == 'diproses')
                            <span class="bg-zinc-200 px-2 py-1 rounded text-zinc-700 text-xs font-bold">Perlu Diproses</span>
                        @elseif ($transaksi->status_pengiriman == 'dikirim')
                            <span class="bg-blue-100 px-2 py-1 rounded text-blue-700 text-xs font-bold">Sedang Dikirim</span>
                        @elseif ($transaksi->status_pengiriman == 'selesai')
                            <span class="bg-green-100 px-2 py-1 rounded text-green-700 text-xs font-bold">Selesai</span>
                        @else
                            <span class="bg-gray-100 px-2 py-1 rounded text-gray-700 text-xs font-bold">{{ ucfirst($transaksi->status_pengiriman) }}</span>
                        @endif
                    </div>
                </div>
                
                <div>
                    <h2 class="font-bold text-lg text-gray-800 mb-3">Alamat Pengiriman</h2>
                    <p class="font-medium text-gray-900">{{ $transaksi->user->username }}</p>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ $transaksi->alamat->detail_alamat }} <br>
                        {{ $transaksi->alamat->kecamatan }}, {{ $transaksi->alamat->kota }} <br>
                        {{ $transaksi->alamat->provinsi }} - {{ $transaksi->alamat->kode_pos }}
                    </p>
                    <p class="text-sm text-gray-600 mt-2">No. HP: {{ $transaksi->alamat->no_hp_penerima }}</p>
                </div>
            </div>
        </div>

        {{-- Daftar Barang --}}
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h3 class="font-bold text-gray-800">Daftar Barang</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($detailMilikToko as $detail)
                <div class="p-4 flex flex-col sm:flex-row gap-4 items-center sm:items-start">
                    <div class="flex-shrink-0">
                        <img src="{{ $detail->barang?->foto_barang ? asset('img/fotobarang/' . $detail->barang->foto_barang) : 'https://via.placeholder.com/100' }}" 
                             class="w-20 h-20 object-cover rounded-md border">
                    </div>
                    <div class="flex-grow text-center sm:text-left">
                        <h4 class="font-semibold text-gray-900">{{ $detail->barang->nama_barang ?? 'Barang Dihapus' }}</h4>
                        <p class="text-sm text-gray-500">{{ $detail->kuantitas }} x Rp {{ number_format($detail->harga_saat_transaksi, 0, ',', '.') }}</p>
                    </div>
                    <div class="flex-shrink-0 font-bold text-gray-800">
                        Rp {{ number_format($detail->kuantitas * $detail->harga_saat_transaksi, 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
            </div>
            <div class="px-6 py-4 bg-gray-50 flex justify-between items-center border-t">
                <span class="font-bold text-gray-700">Total Pendapatan (Pesanan Ini)</span>
                <span class="font-bold text-xl text-[#00795E]">Rp {{ number_format($subtotalToko, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Aksi --}}
        <div class="bg-white rounded-lg shadow-md p-6 flex justify-end">
             @if ($transaksi->status_pengiriman != 'selesai' && $transaksi->status_pengiriman != 'dibatalkan')
                <form method="POST" action="{{ route('pesanan-masuk.update-status', $transaksi->id_transaksi) }}">
                    @csrf
                    @if ($transaksi->status_pengiriman == 'diproses')
                        <input type="hidden" name="status_pengiriman" value="dikirim">
                        <button type="submit" class="bg-[#FCB417] text-white py-2 px-6 rounded-md font-medium hover:bg-[#c58700] transition">
                            Kirim Pesanan Sekarang
                        </button>
                    @elseif ($transaksi->status_pengiriman == 'dikirim')
                         <input type="hidden" name="status_pengiriman" value="selesai">
                        <button type="submit" class="bg-[#B5F2C9] text-gray-800 py-2 px-6 rounded-md font-medium hover:bg-[#5fd687] transition">
                            Tandai Selesai
                        </button>
                    @elseif ($transaksi->status_pengiriman == 'belum diproses')
                        <input type="hidden" name="status_pengiriman" value="diproses">
                        <button type="submit" class="bg-[#D7D7D7] text-gray-800 py-2 px-6 rounded-md font-medium hover:bg-[#b0b0b0] transition">
                            Terima Pesanan
                        </button>
                    @endif
                </form>
            @else
                <p class="text-gray-500 italic">Pesanan ini telah selesai atau dibatalkan.</p>
            @endif
        </div>

    </section>
</x-layout.layout-profile>
{{-- Ganti ini --}}
{{-- <a href="#" class="text-blue-600 hover:underline">{{ $detail->transaksi->nomor_invoice }}</a> --}}

{{-- Menjadi ini --}}
