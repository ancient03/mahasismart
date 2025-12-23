<x-layout.layout-profile>
    <section class="md:col-span-3">
        <div class="py-3 px-5 lg:rounded-md shadow-md bg-white mb-6">
            <h1 class="lg:text-2xl text-xl font-semibold">Riwayat Laporan Saya</h1>
        </div>

        @if(session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        @forelse($laporan as $item)
            <div class="bg-white rounded-lg shadow-md p-5 mb-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-600">No. Invoice:</p>
                        <p class="font-bold">{{ $item->transaksi->nomor_invoice ?? '-' }}</p>
                        
                        <p class="text-sm text-gray-600 mt-3">Jenis Masalah:</p>
                        <p class="font-semibold text-gray-800">
                            {{ ucwords(str_replace('_', ' ', $item->jenis_masalah)) }}
                        </p>

                        <p class="text-sm text-gray-600 mt-3">Deskripsi:</p>
                        <p class="text-sm text-gray-700">{{ $item->deskripsi }}</p>
                    </div>

                    <div class="text-right">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'diproses' => 'bg-blue-100 text-blue-800',
                                'selesai' => 'bg-green-100 text-green-800',
                                'ditolak' => 'bg-red-100 text-red-800',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$item->status_laporan] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($item->status_laporan) }}
                        </span>
                        <p class="text-xs text-gray-500 mt-2">{{ $item->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                @if($item->bukti_foto)
                    <div class="mt-4">
                        <p class="text-xs text-gray-600 mb-2">Bukti Foto:</p>
                        @php
                            $imagePath = public_path('img/buktilaporan/' . $item->bukti_foto);
                            $imageExists = file_exists($imagePath);
                        @endphp
                        
                        @if($imageExists)
                            <a href="{{ asset('img/buktilaporan/' . $item->bukti_foto) }}" target="_blank">
                                <img src="{{ asset('img/buktilaporan/' . $item->bukti_foto) }}" 
                                     alt="Bukti Laporan" 
                                     class="w-40 h-40 object-cover rounded border hover:opacity-80 transition cursor-pointer">
                            </a>
                        @else
                            <div class="w-40 h-40 bg-gray-200 rounded border flex items-center justify-center">
                                <p class="text-xs text-gray-500">Foto tidak ditemukan</p>
                            </div>
                            <p class="text-xs text-red-500 mt-1">Path: {{ $item->bukti_foto }}</p>
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white rounded-lg shadow p-10 text-center text-gray-500">
                <i class="bi bi-inbox text-5xl mb-3"></i>
                <p>Belum ada laporan yang dibuat.</p>
            </div>
        @endforelse

        <div class="mt-4">
            {{ $laporan->links() }}
        </div>
    </section>
</x-layout.layout-profile>