<x-layout>
    <div x-data="{ 
        showAll: false, 
        editMode: null, 
        activeData: { id: '', kategori_id: '', pertanyaan: '', jawaban: '' } 
    }" class="container mx-auto px-4 sm:px-6 lg:px-8">

        {{-- 1. SEARCH BAR --}}
        <div class="w-full max-w-md mx-auto mt-4">
            <div class="flex items-center gap-2 border border-gray-300 rounded-lg px-3 py-2 bg-white shadow-sm">
                <i class="bi bi-search text-gray-500 text-lg"></i>
                <input type="text" placeholder="Cari bantuan..." class="w-full outline-none border-0 focus:ring-0 text-gray-700">
            </div>
        </div>

        {{-- 2. MENU KATEGORI (Ikon Konsisten) --}}
        <div class="flex flex-wrap items-center justify-center gap-4 sm:gap-6 mt-6">
            @foreach($categories as $category)
            <div class="flex flex-col items-center gap-2 w-24 sm:w-32 text-center">
                <div class="border rounded-full bg-[#00795E] text-white flex items-center justify-center h-12 w-12 sm:h-20 sm:w-20 shadow-md">
                    <i class="bi 
                            @if($category->nama_kategori_faq == 'Umum') bi-info-lg 
                            @elseif($category->nama_kategori_faq == 'Akun') bi-person-badge 
                            @elseif($category->nama_kategori_faq == 'Jual Beli') bi-cart-check
                            @elseif($category->nama_kategori_faq == 'Pengiriman') bi-truck
                            @elseif($category->nama_kategori_faq == 'Bantuan & Keamanan') bi-shield-lock
                            @else bi-question-circle 
                            @endif text-xl sm:text-3xl">
                    </i>
                </div>
                <span class="text-[10px] sm:text-sm font-medium leading-tight break-words h-10 flex items-start justify-center">
                    {{ $category->nama_kategori_faq }}
                </span>
            </div>
            @endforeach
        </div>

        {{-- 3. FAQ SECTION --}}
        <div class="mt-6 p-6 rounded-lg bg-zinc-300 shadow-inner">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-semibold text-zinc-800">FAQ</h1>
                <div class="flex gap-3">
                    @if(auth()->check() && auth()->user()->role == 'admin')
                    <button @click="editMode = 'create'; activeData = { id: '', kategori_id: '', pertanyaan: '', jawaban: '' }"
                        class="bg-[#00795E] text-white px-4 py-1 rounded-md text-sm shadow-sm hover:bg-emerald-700 transition">
                        + Tambah FAQ
                    </button>
                    @endif
                    <button @click="showAll = !showAll" class="text-sm font-medium text-zinc-600 hover:text-emerald-700 transition">
                        <span x-show="!showAll">Lihat Semua</span>
                        <span x-show="showAll">Tutup Semua</span>
                    </button>
                </div>
            </div>

            <div class="space-y-8">
                @foreach($categories as $category)
                <div x-show="showAll || '{{ $category->nama_kategori_faq }}' == 'Umum'" x-transition:enter.duration.500ms>

                    {{-- SUB-JUDUL KATEGORI --}}
                    <h2 class="text-lg font-bold mb-3 text-zinc-700 flex items-center gap-2">
                        <span class="w-2 h-6 bg-[#00795E] rounded-full"></span>
                        {{ $category->nama_kategori_faq }}
                    </h2>

                    <div class="bg-white rounded-xl p-5 space-y-4 shadow-sm border border-zinc-200">
                        @forelse($category->faqs as $index => $faq)
                        <div class="group relative border-b last:border-0 border-zinc-100 pb-4 last:pb-0">
                            <div class="flex justify-between items-start gap-4">
                                <div class="flex-1">
                                    <h3 class="font-bold text-zinc-900 leading-snug">
                                        {{ $index + 1 }}. {{ $faq->pertanyaan }}
                                    </h3>
                                    <div class="text-zinc-600 mt-2 ml-5 text-sm leading-relaxed">
                                        {{ $faq->jawaban }}
                                    </div>
                                </div>

                                {{-- TOMBOL EDIT & HAPUS --}}
                                @if(auth()->check() && auth()->user()->role == 'admin')
                                <div class="hidden group-hover:flex gap-2">
                                    <button @click="editMode = 'edit'; activeData = {{ $faq->toJson() }}"
                                        class="p-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 cursor-pointer">
                                        <i class="bi bi-pencil-square pointer-events-none"></i>
                                    </button>
                                    <form action="{{ route('admin.faq.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Hapus FAQ ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                        @empty
                        <p class="text-zinc-400 italic text-sm text-center py-2">Belum ada pertanyaan untuk kategori ini.</p>
                        @endforelse
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- 4. HUBUNGI KAMI --}}
        <div class="mt-6 p-6 bg-zinc-300 rounded-lg mb-10">
            <h1 class="text-2xl font-semibold text-zinc-800">Hubungi Kami</h1>
            <div class="mt-4 space-y-2">
                <a href="#" class="flex items-center gap-2 text-lg hover:text-emerald-700 transition">
                    <i class="bi bi-headset"></i> Chat Mahasismart
                </a>
                <a href="#" class="flex items-center gap-2 text-lg hover:text-emerald-700 transition">
                    <i class="bi bi-telephone-fill"></i> +62 812-3456-7890
                </a>
            </div>
        </div>

        {{-- 5. MODAL POPUP --}}
        <div x-show="editMode"
            class="fixed inset-0 bg-black/50 flex items-center justify-center p-4"
            style="z-index: 9999;"
            x-cloak>
            <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-2xl" @click.away="editMode = null">
                <h2 class="text-xl font-bold mb-4" x-text="editMode === 'create' ? 'Tambah FAQ Baru' : 'Edit FAQ'"></h2>

                <form :action="editMode === 'create' ? '{{ route('admin.faq.store') }}' : '{{ route('admin.faq.update', ['id' => 'PLACEHOLDER']) }}'.replace('PLACEHOLDER', activeData.id)" method="POST">
                    @csrf
                    <template x-if="editMode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="space-y-4">
                        <select name="kategori_id" x-model="activeData.kategori_id" class="w-full border p-2 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nama_kategori_faq }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="pertanyaan" x-model="activeData.pertanyaan" placeholder="Pertanyaan" class="w-full border p-2 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500" required>
                        <textarea name="jawaban" x-model="activeData.jawaban" placeholder="Jawaban" class="w-full border p-2 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500" rows="4" required></textarea>
                    </div>

                    <div class="flex justify-end mt-6 gap-3">
                        <button type="button" @click="editMode = null" class="text-gray-500 font-medium">Batal</button>
                        <button type="submit" class="bg-[#00795E] text-white px-6 py-2 rounded-lg font-bold hover:bg-emerald-700 transition">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>