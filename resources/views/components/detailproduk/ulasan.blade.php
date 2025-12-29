<<<<<<< HEAD
{{-- 
  Menerima variabel $ulasan dari loop di view utama.
  Props 'ulasan' adalah opsional, jika tidak ada, tampilkan statis.
--}}
@props(['ulasan' => null])

<div class="flex gap-3 py-6 border-b lg:border-b-4 border-zinc-100">
=======
@props(['ulasan' => null])

<div class="review-item flex gap-3 py-6 border-b lg:border-b-4 border-zinc-100"
    @if($ulasan)
        data-rating="{{ $ulasan->rating }}"
        data-has-image="{{ $ulasan->fotoUlasan->isNotEmpty() ? 'true' : 'false' }}"
        data-has-comment="{{ !empty($ulasan->komentar) ? 'true' : 'false' }}"
    @endif
>
>>>>>>> 6a1b16350758c633bc8c49039f49731dfe82a1c7
    {{-- profil --}}
    <div class="shrink-0">
        <div class="h-12 w-12 aspect-square overflow-hidden rounded-full border border-gray-200">
            @if($ulasan && $ulasan->user && $ulasan->user->foto_profil)
                {{-- Tampilkan foto profil user jika ada --}}
                <img 
                    src="{{ asset('img/fotoprofile/' . $ulasan->user->foto_profil) }}" 
                    alt="{{ $ulasan->user->username }}" 
                    class="w-full h-full object-cover"
                >
            @else
                {{-- Placeholder jika tidak ada foto --}}
                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                    <i class="bi bi-person-fill text-2xl"></i>
                </div>
            @endif
        </div>
    </div>

    {{-- nama/bintang/tanggal/ulasan/foto ulasan --}}
    <div>
        {{-- Nama User --}}
        <h1 class="font-semibold text-lg">
            {{ $ulasan ? ($ulasan->user->username ?? 'Pengguna Dihapus') : 'J**o D***o' }}
        </h1>

        {{-- Bintang Rating --}}
        <div class="flex gap-2 items-center mt-1 text-sm">
            @if($ulasan)
                {{-- Loop bintang dinamis --}}
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $ulasan->rating)
                        <i class="bi bi-star-fill text-yellow-400"></i>
                    @else
                        <i class="bi bi-star-fill text-gray-300"></i>
                    @endif
                @endfor
            @else
                {{-- Contoh statis 5 bintang --}}
                <i class="bi bi-star-fill text-yellow-400"></i>
                <i class="bi bi-star-fill text-yellow-400"></i>
                <i class="bi bi-star-fill text-yellow-400"></i>
                <i class="bi bi-star-fill text-yellow-400"></i>
                <i class="bi bi-star-fill text-yellow-400"></i>
            @endif
        </div>

        {{-- Tanggal & Variasi --}}
        <div class="flex items-center gap-2 my-2 text-sm text-zinc-600">
            <p>
                {{ $ulasan ? $ulasan->created_at->format('d/m/Y H:i') : '23/10/2025 10.00 WIB' }}
            </p>
            {{-- <span>|</span>
            <p>Variasi: Besar</p> --}}
        </div>

        {{-- Komentar Teks --}}
        <p class="text-lg font-medium line-clamp-3 leading-relaxed text-gray-800">
            {{ $ulasan ? ($ulasan->komentar ?? 'Tidak ada komentar.') : 'Yo ndak tau tanya ko tanya saya Yo ndak tau tanya ko tanya saya Yo ndak tau tanya ko tanya saya' }}
        </p>

        {{-- Foto-foto Ulasan --}}
        @if($ulasan && $ulasan->fotoUlasan && $ulasan->fotoUlasan->isNotEmpty())
            <div class="flex gap-3 items-center mt-2 flex-wrap">
                @foreach($ulasan->fotoUlasan as $foto)
                    <div class="lg:h-24 lg:w-24 h-16 w-16 rounded-md overflow-hidden border border-gray-200 cursor-pointer hover:opacity-90 transition">
                        <img 
                            src="{{ asset('img/fotoulasan/' . $foto->path_foto) }}" 
                            alt="Foto Ulasan" 
                            class="w-full h-full object-cover"
                            onclick="window.open(this.src, '_blank');"
                        >
                    </div>
                @endforeach
            </div>
        @elseif(!$ulasan) 
            {{-- Contoh statis foto --}}
            <div class="flex gap-3 items-center mt-2">
                <img src="{{ asset('img/jokowikaget.jpg') }}" alt="ulasan1" class="lg:h-24 lg:w-24 h-16 w-16 object-cover rounded-md">
                <img src="{{ asset('img/jokowikaget.jpg') }}" alt="ulasan2" class="lg:h-24 lg:w-24 h-16 w-16 object-cover rounded-md">
                <img src="{{ asset('img/jokowikaget.jpg') }}" alt="ulasan3" class="lg:h-24 lg:w-24 h-16 w-16 object-cover rounded-md">
            </div>
        @endif
    </div>
</div>