<x-layout.layout-profile>
    <section class="md:col-span-3">
        
        {{-- Header & Tombol Kembali --}}
        <div class="py-3 px-5 lg:rounded-md shadow-md bg-white mb-6 flex justify-between items-center">
            <h1 class="lg:text-2xl text-1xl font-semibold">Detail Pesanan Saya</h1>
            <a href="{{ route('pesanan') }}" class="text-blue-600 hover:underline text-sm">&laquo; Kembali ke Daftar</a>
        </div>

        {{-- Card Info Utama --}}
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="font-bold text-lg text-gray-800 mb-3">Informasi Pesanan</h2>
                    <p class="text-sm text-gray-600 mb-1">No. Invoice: <span class="font-semibold text-gray-900">{{ $transaksi->nomor_invoice }}</span></p>
                    <p class="text-sm text-gray-600 mb-1">Tanggal: <span class="font-semibold text-gray-900">{{ $transaksi->created_at->format('d M Y H:i') }}</span></p>
                    <p class="text-sm text-gray-600 mb-1">Metode Bayar: <span class="font-semibold text-gray-900">{{ $transaksi->metodePembayaran->nama_metode ?? 'N/A' }}</span></p>
                    
                    <div class="mt-2">
                         <span class="font-medium text-sm text-gray-600">Status: </span>
                         @if ($transaksi->status_pengiriman == 'diproses')
                            <span class="bg-zinc-200 px-2 py-1 rounded text-zinc-700 text-xs font-bold">Sedang Diproses</span>
                        @elseif ($transaksi->status_pengiriman == 'dikirim')
                            <span class="bg-blue-100 px-2 py-1 rounded text-blue-700 text-xs font-bold">Sedang Dikirim</span>
                        @elseif ($transaksi->status_pengiriman == 'selesai')
                            <span class="bg-green-100 px-2 py-1 rounded text-green-700 text-xs font-bold">Selesai</span>
                        @elseif ($transaksi->status_pengiriman == 'belum diproses')
                             <span class="bg-red-100 px-2 py-1 rounded text-red-700 text-xs font-bold">Belum Diproses</span>
                        @else
                            <span class="bg-gray-100 px-2 py-1 rounded text-gray-700 text-xs font-bold">{{ ucfirst($transaksi->status_pengiriman) }}</span>
                        @endif
                    </div>
                </div>
                
                <div>
                    <h2 class="font-bold text-lg text-gray-800 mb-3">Alamat Pengiriman</h2>
                    <p class="font-medium text-gray-900">{{ $transaksi->alamat->nama_penerima }}</p>
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
                <h3 class="font-bold text-gray-800">Barang yang Dibeli</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($transaksi->detailTransaksi as $detail)
                <div class="p-4 flex flex-col sm:flex-row gap-4 items-center sm:items-start">
                    {{-- Foto --}}
                    <div class="flex-shrink-0">
                        <img src="{{ $detail->barang?->foto_barang ? asset('img/fotobarang/' . $detail->barang->foto_barang) : 'https://via.placeholder.com/100' }}" 
                             class="w-20 h-20 object-cover rounded-md border">
                    </div>
                    
                    {{-- Info Barang --}}
                    <div class="flex-grow text-center sm:text-left">
                        <h4 class="font-semibold text-gray-900">{{ $detail->barang->nama_barang ?? 'Barang Dihapus' }}</h4>
                        <p class="text-xs text-gray-500 mb-1">Toko: {{ $detail->barang->toko->nama_toko ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">{{ $detail->kuantitas }} x Rp {{ number_format($detail->harga_saat_transaksi, 0, ',', '.') }}</p>
                    </div>
                    
                    {{-- Subtotal & Aksi per Barang --}}
                    <div class="flex-shrink-0 flex flex-col items-end gap-2">
                        <span class="font-bold text-gray-800">
                            Rp {{ number_format($detail->kuantitas * $detail->harga_saat_transaksi, 0, ',', '.') }}
                        </span>

                        {{-- Tombol Beri Ulasan (Jika Selesai) --}}
                        @if ($transaksi->status_pengiriman == 'selesai')
                             <a href="{{ route('ulasan.create', ['id_transaksi' => $transaksi->id_transaksi, 'id_barang' => $detail->id_barang]) }}" 
                                class="text-xs bg-zinc-200 px-3 py-1.5 rounded hover:bg-zinc-300 transition text-zinc-700 font-medium">
                                 Beri Ulasan
                             </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            
            {{-- Total Akhir --}}
            <div class="px-6 py-4 bg-gray-50 flex justify-between items-center border-t">
                <span class="font-bold text-gray-700">Total Pembayaran</span>
                <span class="font-bold text-xl text-[#00795E]">Rp {{ number_format($transaksi->total_harga_keseluruhan, 0, ',', '.') }}</span>
            </div>
        </div>

                {{-- 
             TOMBOL LAPORKAN PESANAN (BARU DITAMBAHKAN)
             Akan muncul jika pesanan sudah dikirim atau selesai.
        --}}
        @if(in_array($transaksi->status_pengiriman, ['dikirim', 'selesai']))
            <div class="flex justify-end mt-4 mb-10">
                <a href="{{ route('laporan.create', $transaksi->id_transaksi) }}" 
                   class="flex items-center gap-2 text-red-600 hover:text-red-700 font-medium text-sm px-4 py-2 border border-red-200 rounded-lg hover:bg-red-50 transition">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    Laporkan Masalah Pesanan Ini
                </a>
            </div>
        @endif
    </section>
</x-layout.layout-profile>