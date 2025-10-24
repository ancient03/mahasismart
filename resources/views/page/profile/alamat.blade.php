<x-layout.layout-profile>
    <section class="md:col-span-3">
        <div class="bg-white text-gray-800 rounded-lg shadow p-6 md:p-8">
            
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Alamat Saya</h1>
                {{-- Tombol Tambah Alamat Baru --}}
                <a href="{{ route('alamat.create') }}" class="bg-green-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-green-700 transition-colors text-sm">
                    <i class="bi bi-plus-lg mr-1"></i> Tambah Alamat Baru
                </a>
            </div>

            <!-- Pesan Sukses/Status -->
            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-100 p-4 text-sm font-medium text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="space-y-6">
                
                {{-- Loop Alamat --}}
                @forelse ($alamatList as $itemAlamat)
                <div class="border rounded-lg p-4 {{ $itemAlamat->is_default ? 'border-green-500 bg-green-50' : 'border-gray-200' }}">
                    <div class="flex items-start space-x-4">
                        <i class="bi bi-geo-alt-fill text-gray-500 text-xl flex-shrink-0 mt-1"></i>
                        <div class="flex-grow">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="text-lg font-semibold">
                                    {{ $itemAlamat->label }}
                                    @if($itemAlamat->is_default)
                                        <span class="ml-2 text-xs font-medium bg-green-200 text-green-800 px-2 py-0.5 rounded-full">Utama</span>
                                    @endif
                                </h3>
                                <div class="flex space-x-3">
                                    <a href="{{ route('alamat.edit', $itemAlamat->id_alamat) }}" class="text-blue-600 hover:text-blue-800" title="Edit Alamat">
                                        <i class="bi bi-pencil-square text-lg"></i>
                                    </a>
                                    <form action="{{ route('alamat.destroy', $itemAlamat->id_alamat) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alamat ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus Alamat">
                                            <i class="bi bi-trash3 text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <p class="font-medium text-gray-800">{{ $itemAlamat->nama_penerima }}</p>
                            <p class="text-sm text-gray-600">{{ $itemAlamat->no_hp_penerima }}</p>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $itemAlamat->detail_alamat }}, {{ $itemAlamat->kecamatan }}, {{ $itemAlamat->kota }}, {{ $itemAlamat->provinsi }}, {{ $itemAlamat->kode_pos }}
                            </p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-gray-500 py-10 border border-dashed rounded-lg">
                   <i class="bi bi-info-circle text-4xl mb-2"></i>
                   <p>Anda belum menambahkan alamat pengiriman.</p>
                   <a href="{{ route('alamat.create') }}" class="mt-4 inline-block bg-green-100 text-green-700 py-2 px-4 rounded-lg font-semibold hover:bg-green-200 transition-colors text-sm">
                       Tambah Alamat Pertama Anda
                   </a>
                </div>
                @endforelse
                {{-- Akhir Loop --}}

            </div>

        </div>
    </section>
</x-layout.layout-profile>