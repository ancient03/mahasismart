<x-layout.layout-profile>
    {{-- header pesanan --}}
    <section class="md:col-span-3">
        {{-- Header (sesuai template Anda) --}}
        <div class="py-3 px-5 lg:rounded-md shadow-md bg-white">
            <h1 class="lg:text-2xl text-1xl font-semibold">Pesanan Saya</h1>
        </div>

        <!-- Menampilkan pesan Sukses (misal: setelah checkout) -->
        @if (session('status'))
            <div class="mt-6 rounded-md bg-green-100 p-4 text-sm font-medium text-green-700">
                {{ session('status') }}
            </div>
        @endif

        {{-- Loop untuk setiap TRANSAKSI (pesanan) --}}
        @forelse ($transaksiList as $transaksi)
            {{--
              Ini adalah grup untuk satu pesanan, yang bisa berisi banyak barang.
              Kita akan loop item barang di dalam sini.
            --}}
            <div class="mt-6 lg:rounded-md shadow-md bg-white w-full">

                {{-- Header Transaksi: Invoice, Tanggal, Status --}}
                <div class="p-4 border-b flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                    <div>
                        <span class="font-semibold text-gray-800">No. Invoice: {{ $transaksi->nomor_invoice }}</span>
                        <p class="text-sm text-gray-500">Tanggal Pesanan: {{ $transaksi->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    {{-- Status Pembayaran --}}
                    @if ($transaksi->status_pembayaran == 'paid')
                        <div class="bg-green-200 py-2 px-6 rounded-md text-green-800 font-medium text-sm">
                            Dibayar
                        </div>
                    @else
                        <div class="bg-yellow-200 py-2 px-6 rounded-md text-yellow-800 font-medium text-sm">
                            Menunggu Pembayaran
                        </div>
                    @endif

                    {{-- Status Pengiriman (Dinamis) --}}
                    @if ($transaksi->status_pengiriman == 'diproses')
                        <div class="bg-zinc-200 py-2 px-6 rounded-md text-zinc-700 font-medium text-sm">
                            {{ ucfirst($transaksi->status_pengiriman) }}
                        </div>
                    @elseif ($transaksi->status_pengiriman == 'selesai')
                        <div class="py-2 px-6 rounded-md text-white font-medium bg-[#00795E] text-sm">
                            Selesai
                        </div>
                    @elseif ($transaksi->status_pengiriman == 'dibatalkan')
                         <div class="py-2 px-6 rounded-md text-white font-medium bg-red-600 text-sm">
                            Dibatalkan
                        </div>
                    @else
                         <div class="bg-gray-200 py-2 px-6 rounded-md text-gray-800 font-medium text-sm">
                            {{ ucfirst($transaksi->status_pengiriman) }}
                        </div>
                    @endif
                </div>

                {{-- Loop untuk setiap ITEM BARANG di dalam transaksi ini --}}
                @foreach ($transaksi->detailTransaksi as $detail)
                    {{-- Ini adalah layout kartu per barang yang Anda berikan --}}
                    <div class="p-4 flex flex-col md:flex-row gap-4 {{ !$loop->last ? 'border-b' : '' }}"> {{-- Beri border-b jika bukan item terakhir --}}

                        {{-- foto barang --}}
                        <div class="flex-shrink-0">
                            {{-- Tampilkan foto barang atau placeholder --}}
                            <img src="{{ $detail->barang?->foto_barang ? asset('img/fotobarang/' . $detail->barang->foto_barang) : 'https://via.placeholder.com/150?text=No+Image' }}"
                                 alt="{{ $detail->barang?->nama_barang ?? 'Barang Dihapus' }}"
                                 class="h-32 w-32 md:w-24 md:h-24 rounded-md object-cover">
                        </div>

                        {{-- detail produk --}}
                        <div class="flex-1">
                            {{-- toko (dari relasi detail->barang->toko) --}}
                            <div class="flex items-center gap-2 mb-2">
                                <img src="{{ $detail->barang?->toko?->logo_toko ? asset('img/logotoko/' . $detail->barang->toko->logo_toko) : asset('img/kuning.png') }}"
                                     alt="Logo Toko" class="h-6 w-6 rounded-full object-cover">
                                <span class="text-sm font-semibold">{{ $detail->barang?->toko?->nama_toko ?? 'Toko Tidak Tersedia' }}</span>
                            </div>

                            {{-- deskripsi produk --}}
                            <div class="flex items-start justify-between w-full">
                                <div class="border-2 border-transparent">
                                    {{-- nama produk --}}
                                    <h1 class="lg:text-xl text-lg font-semibold">{{ $detail->barang?->nama_barang ?? 'Barang Telah Dihapus' }}</h1>
                                    {{-- kuantitas x harga --}}
                                    <p class="text-sm text-gray-600 mt-1">{{ $detail->kuantitas }} barang x Rp {{ number_format($detail->harga_saat_transaksi, 0, ',', '.') }}</p>
                                    {{-- harga subtotal --}}
                                    <p class="text-md md:text-lg font-bold text-zinc-800">
                                        Rp {{ number_format($detail->kuantitas * $detail->harga_saat_transaksi, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div class="text-right flex items-center gap-2">
                                    {{-- total produk (kuantitas) --}}
                                    <p class="font-medium text-zinc-700">Total: {{ $detail->kuantitas }}</p>
                                    <span>|</span>
                                    {{-- metode pembayaran (dari transaksi induk) --}}
                                    <p class="font-medium text-zinc-700">{{ $transaksi->metodePembayaran->nama_metode ?? 'N/A' }}</p> {{-- Asumsi ada kolom metode_pembayaran --}}
                                </div>
                            </div>

                            {{-- Tombol Aksi di Kanan Bawah (sesuai template Anda) --}}
                            <div class="flex items-center justify-end mt-4 gap-3">
                                {{-- Logika tombol berdasarkan status pengiriman --}}
                                @if ($transaksi->status_pembayaran == 'pending')
                                <button data-transaksi-id="{{ $transaksi->id_transaksi }}"
                                    class="pay-now bg-green-600 text-white py-2 px-6 rounded-md font-medium hover:bg-green-700 transition duration-300 text-sm flex items-center gap-2">
                                    Bayar Sekarang
                                </button>
                                @endif

                                {{-- Jika status selesai, tampilkan tombol Ulasan --}}
                                @if ($transaksi->status_pengiriman == 'selesai')
                                    <a href="{{ route('ulasan.create', ['id_transaksi' => $transaksi->id_transaksi, 'id_barang' => $detail->id_barang]) }}"
                                        class="bg-zinc-200 py-2 px-6 rounded-md text-zinc-700 font-medium cursor-pointer hover:bg-zinc-300 transition duration-500 text-sm">
                                            Beri Ulasan
                                    </a>
                                {{-- Jika masih diproses --}}
                                @elseif ($transaksi->status_pengiriman == 'diproses')
                                    <a href="#" class="bg-white py-2 px-6 rounded-md font-medium cursor-pointer border-2 border-[#00795E] text-[#00795E] hover:bg-[#00795E] hover:text-white transition duration-500 text-sm">
                                        Hubungi Penjual
                                    </a>
                                @endif
                                {{-- 👇 TOMBOL DETAIL PESANAN (DI SINI) 👇 --}}
                                <a href="{{ route('pesanan.show', $transaksi->id_transaksi) }}"
                                    class="bg-blue-600 text-white py-2 px-6 rounded-md font-medium hover:bg-blue-700 transition duration-300 text-sm flex items-center gap-2">
                                    <i class="bi bi-eye"></i> Detail Pesanan
                                </a>
                                {{-- 👆 ----------------------------- 👆 --}}

                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- Akhir loop item barang --}}

                {{-- Footer Transaksi: Total Harga Keseluruhan --}}
                <div class="p-4 bg-gray-50 rounded-b-md flex flex-col sm:flex-row justify-end items-center gap-4">
                    <div class="text-right">
                        <span class="text-gray-600">Total Pesanan:</span>
                        <span class="font-bold text-xl text-gray-900 ml-2">Rp {{ number_format($transaksi->total_harga_keseluruhan, 0, ',', '.') }}</span>
                    </div>
                </div>

            </div>
        @empty
            {{-- Tampilan jika TIDAK ADA transaksi sama sekali --}}
            <div class="p-4 mt-6 lg:rounded-md shadow-md bg-white w-full text-center text-gray-500 py-10">
                <i class="bi bi-bag-x text-6xl text-gray-300"></i>
                <h2 class="mt-4 text-xl font-semibold text-gray-700">Anda Belum Memiliki Pesanan</h2>
                <p class="text-gray-500 mt-2">Semua riwayat pesanan Anda akan muncul di sini.</p>
                <a href="{{ route('home') }}" class="mt-6 inline-block bg-green-600 text-white py-2 px-5 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                    Mulai Belanja
                </a>
            </div>
        @endforelse
        {{-- Akhir loop transaksi --}}

        {{-- Link Pagination --}}
        <div class="mt-8 mb-32"> {{-- Tambah mb-32 agar tidak tertutup chat melayang --}}
            {{ $transaksiList->links() }}
        </div>

        <x-profil.barang/>
    </section>

    @push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        document.querySelectorAll('.pay-now').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const currentButton = this;
                const originalText = currentButton.innerHTML;
                const transaksiId = this.dataset.transaksiId;

                // Disable button and show loading state
                currentButton.disabled = true;
                currentButton.innerHTML = 'Memuat...';

                fetch(`/checkout/retry/${transaksiId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                .then(res => {
                    if (!res.ok) {
                        // If response is not OK, parse the error message from the server
                        return res.json().then(err => { throw new Error(err.error || 'Terjadi kesalahan server.'); });
                    }
                    return res.json();
                })
                .then(data => {
                    // Re-enable button before showing Midtrans popup
                    currentButton.disabled = false;
                    currentButton.innerHTML = originalText;

                    if (data.snap_token) {
                        snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                window.location.reload();
                            },
                            onPending: function(result) {
                                window.location.reload();
                            },
                            onError: function(result) {
                                alert('Pembayaran gagal.');
                                window.location.reload();
                            },
                            onClose: function() {
                               // Optional: feedback that payment was not completed
                               // alert('Anda menutup popup tanpa menyelesaikan pembayaran.');
                            }
                        });
                    } else {
                        alert(data.error || 'Gagal mendapatkan token pembayaran. Silakan muat ulang halaman dan coba lagi.');
                    }
                })
                .catch(err => {
                    // Re-enable button on error
                    currentButton.disabled = false;
                    currentButton.innerHTML = originalText;
                    console.error('Fetch Error:', err);
                    alert('Terjadi kesalahan: ' + err.message);
                });
            });
        });
    </script>
    @endpush
</x-layout.layout-profile>
