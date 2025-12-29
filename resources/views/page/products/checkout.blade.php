
<x-layout>
    {{-- Form ini mengirimkan 'id_alamat' dan 'id_metode_pembayaran' yang DIPILIH --}}
    <form id="checkout-form" method="POST" action="{{ route('checkout.store') }}">
        @csrf
        <main class="py-8 bg-gray-100 min-h-screen">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Padding Top untuk Navbar Fixed --}}
                <div class="pt-[90px] md:pt-[100px]"></div>

                {{-- Judul --}}
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
                </div>

                {{-- Tampilkan error validasi (jika ada) --}}
                @if ($errors->any())
                    <div class="mb-4 rounded-md bg-red-100 p-4 text-sm font-medium text-red-700">
                        <strong>Harap perbaiki error berikut:</strong>
                        <ul class="mt-2 list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Grid Utama (2 kolom di desktop) --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- =================================== --}}
                    {{-- KOLOM KIRI (Alamat & Daftar Barang) --}}
                    {{-- =================================== --}}
                    <section class="lg:col-span-2 space-y-6">

                        <!-- 1. Pilihan Alamat Pengiriman -->
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Pilih Alamat Pengiriman <span class="text-red-500">*</span></h2>

                            @if ($alamatList->isEmpty())
                                {{-- Tampilan jika user tidak punya alamat --}}
                                <div class="text-center text-gray-500 py-6 border border-dashed rounded-lg">
                                    <i class="bi bi-geo-alt text-4xl mb-2"></i>
                                    <p>Anda belum memiliki alamat tersimpan.</p>
                                    <a href="{{ route('alamat.create', ['redirect' => 'checkout.index']) }}" {{-- Redirect kembali ke checkout --}}
                                       class="mt-4 inline-block bg-green-100 text-green-700 py-2 px-4 rounded-lg font-semibold hover:bg-green-200 transition-colors text-sm">
                                        + Tambah Alamat Baru
                                    </a>
                                </div>
                            @else
                                {{-- Loop untuk menampilkan semua alamat user --}}
                                <div class="space-y-4">
                                    @foreach ($alamatList as $alamat)
                                        <label for="alamat-{{ $alamat->id_alamat }}"
                                               class="flex items-start space-x-4 border rounded-lg p-4 cursor-pointer hover:bg-gray-50 has-[:checked]:bg-green-50 has-[:checked]:border-green-500 {{ $alamat->is_default ? 'border-green-500 bg-green-50' : 'border-gray-200' }}">
                                            {{-- Radio Button --}}
                                            <input type="radio"
                                                   name="id_alamat"
                                                   id="alamat-{{ $alamat->id_alamat }}"
                                                   value="{{ $alamat->id_alamat }}"
                                                   class="mt-1 text-green-600 focus:ring-green-500"
                                                   {{-- Cek jika ini adalah alamat default ATAU alamat yang dipilih sebelumnya --}}
                                                   {{ (old('id_alamat') == $alamat->id_alamat) || (!$errors->any() && $alamat->is_default) ? 'checked' : '' }}
                                                   required>

                                            {{-- Info Alamat --}}
                                            <div class="flex-grow">
                                                <div class="flex justify-between items-center mb-1">
                                                    <h3 class="text-lg font-semibold">
                                                        {{ $alamat->label }}
                                                        @if($alamat->is_default)
                                                            <span class="ml-2 text-xs font-medium bg-green-200 text-green-800 px-2 py-0.5 rounded-full">Utama</span>
                                                        @endif
                                                    </h3>
                                                </div>
                                                <p class="font-medium text-gray-800">{{ $alamat->nama_penerima }}</p>
                                                <p class="text-sm text-gray-600">{{ $alamat->no_hp_penerima }}</p>
                                                <p class="text-sm text-gray-600 mt-1">
                                                    {{ $alamat->detail_alamat }}, {{ $alamat->kecamatan }}, {{ $alamat->kota }}, {{ $alamat->provinsi }}, {{ $alamat->kode_pos }}
                                                </p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                 <a href="{{ route('alamat.create', ['redirect' => 'checkout.index']) }}"
                                    class="mt-4 inline-block text-sm text-blue-600 hover:underline">
                                    + Tambah alamat baru lainnya
                                  </a>
                            @endif
                        </div>

                        <!-- 2. Ringkasan Barang yang Dipesan -->
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Ringkasan Barang</h2>
                            <div class="space-y-4">
                                @forelse ($items as $item)
                                    <div class="flex space-x-4 border-b pb-4 last:border-b-0 last:pb-0">
                                        <!-- Gambar -->
                                        <div class="flex-shrink-0 w-20 h-20 bg-gray-200 rounded-lg">
                                            @if ($item->foto_barang)
                                                <img src="{{ asset('img/fotobarang/' . $item->foto_barang) }}" alt="{{ $item->nama_barang }}" class="w-full h-full object-cover rounded-lg">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="bi bi-image"></i></div>
                                            @endif
                                        </div>
                                        <!-- Info -->
                                        <div class="flex-grow">
                                            <h3 class="font-semibold text-gray-900">{{ $item->nama_barang }}</h3>
                                            <p class="text-sm text-gray-600">dari {{ $item->toko?->nama_toko ?? 'Toko Dihapus' }}</p>
                                            <p class="text-sm text-gray-500">{{ $item->pivot->kuantitas }} x Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                        </div>
                                        <!-- Subtotal -->
                                        <div class="flex-shrink-0 text-right">
                                            <span class="font-semibold text-gray-900">Rp {{ number_format($item->harga * $item->pivot->kuantitas, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500">Keranjang Anda kosong.</p>
                                @endforelse
                            </div>
                        </div>

                    </section>

                    {{-- =================================== --}}
                    {{-- KOLOM KANAN (Total & Tombol Bayar) --}}
                    {{-- =================================== --}}
                    <section class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md p-6 sticky top-28">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Ringkasan Belanja</h2>

                            {{-- Cek jika semua data siap untuk checkout --}}
                            @if ($items->isNotEmpty() && $alamatList->isNotEmpty())
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-600">Total Harga ({{ $items->sum('pivot.kuantitas') }} barang)</span>
                                    <span class="text-gray-900 font-medium">Rp. {{ number_format($totalHarga, 0, ',', '.') }}</span>
                                </div>

                                <div class="border-t border-gray-200 my-4"></div>

                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-xl font-bold text-gray-900">Total</span>
                                    <span class="text-xl font-bold text-gray-900">Rp. {{ number_format($totalHarga, 0, ',', '.') }}</span>
                                </div>

                                {{-- Tombol "Bayar" (Submit Form) --}}
                                <button type="submit" id="pay-button"
                                        class="bg-green-600 hover:bg-green-700 text-white w-full py-3 rounded-lg font-bold text-lg transition-colors">
                                    Buat Pesanan
                                </button>
                            @else
                                {{-- Tampilan jika ada data yang kurang --}}
                                <p class="text-sm text-gray-500 mb-4">
                                    @if($items->isEmpty())
                                        Keranjang Anda kosong.
                                    @elseif($alamatList->isEmpty())
                                        Anda belum memiliki alamat.
                                    @endif
                                </p>
                                <button type="button"
                                        class="bg-gray-300 text-gray-500 w-full py-3 rounded-lg font-bold text-lg cursor-not-allowed"
                                        disabled>
                                    Buat Pesanan
                                </button>
                            @endif
                        </div>
                    </section>

                </div>
            </div>
        </main>
    </form> {{-- Akhir Form --}}

    @push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(event) {
            event.preventDefault();
            var form = document.getElementById('checkout-form');
            var formData = new FormData(form);

            fetch("{{ route('checkout.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: formData
            }).then(res => res.json())
            .then(data => {
                if (data.snap_token) {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            /* You may add your own implementation here */
                            // alert("payment success!");
                            window.location.href = '/pesanan';
                        },
                        onPending: function(result) {
                            /* You may add your own implementation here */
                            // alert("wating your payment!");
                             window.location.href = '/pesanan';
                        },
                        onError: function(result) {
                            /* You may add your own implementation here */
                            // alert("payment failed!");
                             window.location.href = '/pesanan';
                        },
                        onClose: function() {
                            /* Redirect to orders page on close */
                             window.location.href = '/pesanan';
                        }
                    });
                } else {
                    // Handle error, including Laravel validation errors
                    let errorMessage = data.error; // Standard error from controller's catch block
                    if (!errorMessage && data.message) { // Error from Laravel's validation
                        errorMessage = data.message;
                        if (data.errors) {
                            const errorDetails = Object.values(data.errors).map(e => e[0]).join('\n');
                            errorMessage += '\n\n- ' + errorDetails;
                        }
                    }
                    alert(errorMessage || 'Terjadi kesalahan yang tidak diketahui. Silakan coba lagi.');
                }
            }).catch(err => {
                // Handle network errors
                console.error(err);
                alert('Tidak dapat terhubung ke server. Periksa koneksi internet Anda.');
            });
        };
    </script>
    @endpush
</x-layout>

