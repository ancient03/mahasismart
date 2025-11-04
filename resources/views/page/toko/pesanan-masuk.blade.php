{{-- Memanggil layout Anda (Pastikan nama ini benar) --}}
<x-layout.layout-profile>

    {{-- Kolom Kanan (Konten Pesanan Masuk) --}}
    <section class="md:col-span-3">
        
        {{-- Header --}}
        <div class="py-3 px-5 lg:rounded-md shadow-md bg-white">
            <h1 class="lg:text-2xl text-1xl font-semibold">Pesanan Masuk</h1>
        </div>

        <!-- Menampilkan pesan Sukses/Status dari Controller -->
        @if (session('status'))
            <div class="mt-6 rounded-md bg-green-100 p-4 text-sm font-medium text-green-700">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mt-6 rounded-md bg-red-100 p-4 text-sm font-medium text-red-700">
                {{ session('error') }}
            </div>
        @endif

        {{-- Loop untuk setiap ITEM PESANAN ($itemList) dari controller --}}
        @forelse ($itemList as $detail)
            {{-- $detail adalah 1 baris dari 'detail_transaksi' --}}
            <div class="p-4 mt-6 lg:rounded-md shadow-md bg-white w-full">
                
                {{-- Info Transaksi Induk: Invoice, Pembeli, Tanggal --}}
                <div class="pb-3 mb-3 border-b flex flex-col sm:flex-row justify-between items-start sm:items-center text-sm gap-2">
                    <div>
                        <span class="font-semibold">Invoice:</span>
                        {{-- Klik invoice untuk melihat detail (jika ada halamannya) --}}
                        <a href="#" class="text-blue-600 hover:underline">{{ $detail->transaksi->nomor_invoice }}</a>
                    </div>
                    <div class="flex items-center gap-2">
                         <i class="bi bi-person-circle"></i>
                        <span class="font-semibold">Pembeli:</span>
                        {{-- Menggunakan nullsafe operator (?) jika user dihapus --}}
                        <span>{{ $detail->transaksi->user?->username ?? 'User Dihapus' }}</span> 
                    </div>
                     <div class="flex items-center gap-2">
                         <i class="bi bi-calendar-event"></i>
                        <span class="font-semibold">Tanggal:</span>
                        <span>{{ $detail->transaksi->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                {{-- Detail barang --}}
                <div class="flex flex-col md:flex-row gap-4">
                    {{-- foto barang --}}
                    <div class="flex-shrink-0">
                        <img src="{{ $detail->barang?->foto_barang ? asset('img/fotobarang/'. $detail->barang->foto_barang) : 'https://via.placeholder.com/150?text=No+Image' }}"
                             alt="{{ $detail->barang?->nama_barang ?? 'Barang Dihapus' }}"
                             class="h-32 w-32 rounded-md object-cover">
                    </div>

                    {{-- detail produk --}}
                    <div class="flex-1">
                        {{-- deskripsi produk --}}
                        <div class="flex items-start justify-between w-full">
                            <div>
                                {{-- nama produk --}}
                                <h1 class="lg:text-xl text-lg font-semibold">{{ $detail->barang?->nama_barang ?? 'Barang Telah Dihapus' }}</h1>
                                {{-- harga saat transaksi & kuantitas --}}
                                <p class="text-sm text-gray-500 mt-1">{{ $detail->kuantitas }} barang x Rp {{ number_format($detail->harga_saat_transaksi, 0, ',', '.') }}</p>
                                {{-- Total harga item ini --}}
                                <p class="text-xl md:text-2xl font-bold text-zinc-800">
                                    Rp {{ number_format($detail->kuantitas * $detail->harga_saat_transaksi, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        {{-- ========================================================== --}}
                        {{-- 👇 LOGIKA STATUS DAN TOMBOL ALUR BARU 👇 --}}
                        {{-- ========================================================== --}}
                        <div class="flex items-center justify-between mt-4">
                            {{-- Tampilkan Status Saat Ini --}}
                            <div>
                                <span class="font-medium">Status: </span>
                                @if ($detail->transaksi->status_pengiriman == 'belum diproses')
                                    <span class="bg-red-200 py-1 px-3 rounded-full text-red-700 font-medium text-xs uppercase">
                                        Belum Diproses
                                    </span>
                                @elseif ($detail->transaksi->status_pengiriman == 'diproses')
                                    <span class="bg-zinc-200 py-1 px-3 rounded-full text-zinc-700 font-medium text-xs uppercase">
                                        Sedang Diproses
                                    </span>
                                @elseif ($detail->transaksi->status_pengiriman == 'dikirim')
                                    <span class="bg-blue-200 py-1 px-3 rounded-full text-blue-700 font-medium text-xs uppercase">
                                        Sudah Dikirim
                                    </span>
                                @elseif ($detail->transaksi->status_pengiriman == 'selesai')
                                    <span class="py-1 px-3 rounded-full text-white font-medium bg-[#00795E] text-xs uppercase">
                                        Selesai
                                    </span>
                                @else
                                     <span class="bg-gray-200 py-1 px-3 rounded-full text-gray-700 font-medium text-xs uppercase">
                                        {{ ucfirst($detail->transaksi->status_pengiriman) }} {{-- Misal: 'dibatalkan' --}}
                                    </span>
                                @endif
                            </div>

                            {{-- Form Tombol Aksi (jika belum selesai/batal) --}}
                            @if (!in_array($detail->transaksi->status_pengiriman, ['selesai', 'dibatalkan']))
                                <form method="POST" action="{{ route('pesanan-masuk.update-status', $detail->transaksi->id_transaksi) }}" class="flex items-center gap-2">
                                    @csrf
                                    
                                    {{-- ALUR TOMBOL BARU --}}

                                    @if ($detail->transaksi->status_pengiriman == 'belum diproses')
                                        {{-- 1. Tampilkan tombol "Terima Pesanan" --}}
                                        <input type="hidden" name="status_pengiriman" value="diproses">
                                        <button type="submit"
                                                class="bg-[#D7D7D7] text-gray-800 py-2 px-6 rounded-md font-medium hover:bg-[#b0b0b0] transition duration-300 text-sm">
                                            Terima Pesanan
                                        </button>
                                    
                                    @elseif ($detail->transaksi->status_pengiriman == 'diproses')
                                        {{-- 2. Tampilkan tombol "Tandai Dikirim" --}}
                                        <input type="hidden" name="status_pengiriman" value="dikirim">
                                        <button type="submit"
                                                class="bg-[#FCB417] text-white py-2 px-6 rounded-md font-medium hover:bg-[#c58700] transition duration-300 text-sm">
                                            Tandai Dikirim
                                        </button>
                                    
                                    @elseif ($detail->transaksi->status_pengiriman == 'dikirim')
                                         {{-- 3. Tampilkan tombol "Tandai Selesai" --}}
                                         <input type="hidden" name="status_pengiriman" value="selesai">
                                        <button type="submit"
                                                class="bg-[#B5F2C9] text-gray-800 py-2 px-6 rounded-md font-medium hover:bg-[#5fd687] transition duration-300 text-sm">
                                            Tandai Selesai
                                        </button>
                                    @endif
                                    {{-- Status "selesai" tidak akan menampilkan tombol apapun --}}
                                </form>
                            @endif
                        </div>
                        {{-- ========================================================== --}}
                        {{-- 👆 AKHIR LOGIKA STATUS DAN TOMBOL BARU 👆 --}}
                        {{-- ========================================================== --}}
                    </div>
                </div>
            </div>
        @empty
            {{-- Tampilan jika tidak ada pesanan masuk --}}
            <div class="p-4 mt-6 lg:rounded-md shadow-md bg-white w-full text-center text-gray-500 py-10">
                <i class="bi bi-box-seam text-6xl text-gray-300"></i>
                <h2 class="mt-4 text-xl font-semibold text-gray-700">Belum Ada Pesanan Masuk</h2>
                <p class="text-gray-500 mt-2">Pesanan yang masuk ke toko Anda akan muncul di sini.</p>
            </div>
        @endforelse
        {{-- Akhir Loop --}}
        
        {{-- Link Pagination --}}
        <div class="mt-8 mb-32">
            {{ $itemList->links() }}
        </div>

    </section>
</x-layout.layout-profile>