<x-layout.layout-profile>
  <main class="container mx-auto p-4 md:p-8 min-h-screen">
        <section class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
            
            <h1 class="text-2xl font-bold mb-6 border-b pb-4">Beri Ulasan Produk</h1>

            {{-- Info Produk yg Diulas --}}
            <div class="flex gap-4 mb-6 bg-gray-50 p-4 rounded-lg">
                <img src="{{ $barang->foto_barang ? asset('img/fotobarang/' . $barang->foto_barang) : asset('img/placeholder.jpg') }}" 
                     class="w-16 h-16 object-cover rounded-md">
                <div>
                    <h3 class="font-semibold">{{ $barang->nama_barang }}</h3>
                    <p class="text-sm text-gray-500">Invoice: {{ $transaksi->nomor_invoice }}</p>
                </div>
            </div>

            <form action="{{ route('ulasan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="id_transaksi" value="{{ $transaksi->id_transaksi }}">
                <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">

                {{-- 1. Rating Bintang (CSS Only Trick) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Berikan Rating</label>
                    <div class="flex flex-row-reverse justify-end gap-1">
                        @for($i=5; $i>=1; $i--)
                            <input type="radio" id="star{{$i}}" name="rating" value="{{$i}}" class="peer hidden" required />
                            <label for="star{{$i}}" class="cursor-pointer text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 text-3xl">
                                <i class="bi bi-star-fill"></i>
                            </label>
                        @endfor
                    </div>
                </div>

                {{-- 2. Komentar --}}
                <div>
                    <label for="komentar" class="block text-sm font-medium text-gray-700 mb-2">Tulis Ulasan Anda</label>
                    <textarea name="komentar" id="komentar" rows="4" 
                              placeholder="Bagaimana kualitas produk ini? Apakah sesuai pesanan?"
                              class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none"></textarea>
                </div>

                {{-- 3. Upload Foto --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tambahkan Foto (Opsional)</label>
                    <input type="file" name="foto_ulasan[]" multiple accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    <p class="text-xs text-gray-500 mt-1">Bisa pilih lebih dari satu foto.</p>
                </div>

                {{-- Tombol Submit --}}
                <div class="pt-4">
                    <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700 transition-colors">
                        Kirim Ulasan
                    </button>
                </div>
            </form>

        </section>
    </main>
</x-layout.layout-profile>