<x-layout.layout-admin>
    <section class="md:col-span-3">

        {{-- Header --}}
        <div class="py-3 px-5 flex justify-between items-center lg:rounded-md shadow-md bg-white mb-6">
            <h1 class="lg:text-2xl text-1xl font-semibold">Daftar Iklan</h1>
            <a href="{{ route('admin.tambah-iklan') }}"
                class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 transition">
                + Tambah Iklan
            </a>
        </div>

        {{-- Loop data iklan --}}
        @forelse ($iklan as $item)
            <div
                class="relative py-4 px-4 shadow-xl rounded-lg border border-zinc-200 hover:shadow-2xl transition duration-300 mb-6">

                {{-- 🔹 STATUS --}}
                @if ($item->status === 'aktif')
                    <div
                        class="absolute bg-green-600 text-white font-semibold right-5 top-0 py-2 px-6 rounded-b-lg shadow-md">
                        Aktif
                    </div>
                @else
                    <div
                        class="absolute bg-red-600 text-white font-semibold right-5 top-0 py-2 px-6 rounded-b-lg shadow-md">
                        Tidak Aktif
                    </div>
                @endif

                <div class="flex gap-6">
                    {{-- Gambar --}}
                    <div class="relative flex-shrink-0">
                        {{-- Tombol edit --}}
                        <a href="{{ route('admin.edit-iklan', $item->id) }}"
                            class="absolute top-3 left-3 flex items-center justify-center bg-white rounded-full py-2 px-3 shadow-md border border-zinc-300 hover:bg-blue-600 hover:text-white transition duration-300">
                            <i class="bi bi-pencil-square text-base"></i>
                        </a>

                        {{-- Tombol hapus --}}
                        <form action="{{ route('admin.hapus-iklan', $item->id) }}" method="POST"
                            class="absolute top-3 left-14">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus iklan ini?')"
                                class="flex items-center justify-center bg-white rounded-full py-2 px-3 shadow-md border border-zinc-300 hover:bg-red-600 hover:text-white transition duration-300">
                                <i class="bi bi-trash text-base"></i>
                            </button>
                        </form>

                        {{-- Gambar Iklan --}}
                        <img src="{{ asset($item->gambar) }}" alt="{{ $item->nama_iklan }}"
                            class="h-[150px] w-96 object-cover rounded-lg shadow-md border border-zinc-100">
                    </div>

                    {{-- Konten --}}
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-800">{{ $item->nama_iklan }}</h1>
                            <h3 class="font-medium text-zinc-500 mt-1">{{ $item->slogan }}</h3>
                            <p class="mt-2 text-gray-700 line-clamp-2">
                                {{ $item->deskripsi }}
                            </p>
                        </div>

                        <div class="mt-4 flex gap-2 text-sm text-gray-500">
                            <div class="flex items-center gap-1">
                                <i class="bi bi-calendar4"></i>
                                <p>{{ \Carbon\Carbon::parse($item->dimulai)->format('d/m/Y') }}</p>
                            </div>

                            <span>-</span>

                            <div class="flex items-center gap-1">
                                <i class="bi bi-calendar-check"></i>
                                <p>{{ \Carbon\Carbon::parse($item->berakhir)->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-10 text-gray-500">
                <i class="bi bi-exclamation-circle text-2xl"></i>
                <p class="mt-2">Belum ada iklan yang ditambahkan.</p>
            </div>
        @endforelse


    </section>
</x-layout.layout-admin>
