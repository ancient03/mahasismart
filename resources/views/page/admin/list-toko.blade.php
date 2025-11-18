{{-- Ganti layout dengan layout admin Anda --}}
<x-layout.layout-admin>
    <section class="md:col-span-3">
        {{-- header --}}
        <div class="py-3 px-5 lg:rounded-md shadow-md bg-white mb-10 flex justify-between items-center">
            <h1 class="lg:text-2xl text-1xl font-semibold">Daftar Toko</h1>
            
             {{-- Pesan Sukses --}}
            @if (session('status'))
                <span class="text-sm text-green-600 bg-green-100 px-3 py-1 rounded-full">{{ session('status') }}</span>
            @endif
        </div>

        {{-- Loop Daftar Toko --}}
        @forelse ($tokoList as $toko)
            <div class="py-3 px-5 mb-4 flex flex-col md:flex-row md:items-center justify-between rounded-md shadow-md bg-white border-l-4 
                {{ $toko->status_toko == 'banned' ? 'border-red-600 bg-red-50' : ($toko->status_toko == 'peringatan' ? 'border-yellow-500 bg-yellow-50' : 'border-green-500') }}">
                
                {{-- Info Toko --}}
                <div class="flex gap-4 items-center mb-4 md:mb-0">
                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center border border-gray-300 overflow-hidden">
                         @if ($toko->logo_toko)
                            <img src="{{ asset('img/logotoko/' . $toko->logo_toko) }}" alt="Logo" class="w-full h-full object-cover">
                        @else
                            <i class="bi bi-shop text-3xl text-gray-400"></i>
                        @endif
                    </div>
                    <div>
                        <p class="font-semibold text-xl">{{ $toko->nama_toko }}</p>
                        <p class="text-sm text-gray-500">Pemilik: {{ $toko->user->username ?? 'Unknown' }}</p>
                        
                        {{-- Badge Status --}}
                        <div class="mt-1">
                            @if ($toko->status_toko == 'aktif')
                                <span class="px-2 py-0.5 rounded text-xs font-bold bg-green-200 text-green-800">Aktif</span>
                            @elseif ($toko->status_toko == 'peringatan')
                                <span class="px-2 py-0.5 rounded text-xs font-bold bg-yellow-200 text-yellow-800">Peringatan</span>
                            @elseif ($toko->status_toko == 'banned')
                                <span class="px-2 py-0.5 rounded text-xs font-bold bg-red-200 text-red-800">Banned</span>
                            @endif
                        </div>
                        @if($toko->catatan_admin)
                            <p class="text-xs text-red-600 mt-1 italic">"{{ $toko->catatan_admin }}"</p>
                        @endif
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-2">
                    
                    {{-- 1. Tombol BANNED (Jika belum dibanned) --}}
                    @if ($toko->status_toko != 'banned')
                        <form action="{{ route('admin.toko.update-status', $toko->id_toko) }}" method="POST" onsubmit="return confirm('Yakin ingin mem-banned toko ini?');">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status_toko" value="banned">
                            <input type="hidden" name="catatan_admin" value="Melanggar ketentuan platform"> {{-- Bisa diganti input text/modal --}}
                            <button type="submit" title="Banned Toko"
                                class="bg-[#CA4343] py-2 px-3 rounded-md shadow-md text-center hover:bg-[#8b0000] transition duration-300 text-white">
                                <i class="bi bi-ban text-lg"></i>
                            </button>
                        </form>
                    @endif

                    {{-- 2. Tombol PERINGATAN (Jika aktif) --}}
                    @if ($toko->status_toko == 'aktif')
                        <form action="{{ route('admin.toko.update-status', $toko->id_toko) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status_toko" value="peringatan">
                            <input type="hidden" name="catatan_admin" value="Toko ini mendapat peringatan pertama">
                            <button type="submit" title="Beri Peringatan"
                                class="bg-[#FFCC00] py-2 px-3 rounded-md shadow-md text-center hover:bg-[#a78500] transition duration-300 text-white">
                                <i class="bi bi-exclamation-diamond text-lg"></i>
                            </button>
                        </form>
                    @endif

                    {{-- 3. Tombol PULIHKAN / AKTIFKAN KEMBALI (Jika dibanned atau peringatan) --}}
                    @if ($toko->status_toko != 'aktif')
                        <form action="{{ route('admin.toko.update-status', $toko->id_toko) }}" method="POST" onsubmit="return confirm('Pulihkan status toko ini menjadi Aktif?');">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status_toko" value="aktif">
                            <input type="hidden" name="catatan_admin" value=""> {{-- Hapus catatan --}}
                            <button type="submit" title="Pulihkan / Aktifkan Kembali"
                                class="bg-[#61BE4A] py-2 px-3 rounded-md shadow-md text-center hover:bg-[#21a700] transition duration-300 text-white">
                                <i class="bi bi-check-circle text-lg"></i>
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-10">Belum ada toko yang terdaftar.</div>
        @endforelse

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $tokoList->links() }}
        </div>

    </section>
</x-layout.layout-admin>