@props(['chats'])

<div class="">
    <h2 class="font-semibold py-2 px-4 rounded-md text-lg bg-white sticky top-25 z-10 pb-3 shadow">
        Chat
    </h2>

    @php
        $isSeller = Auth::user()->toko;
    @endphp

    @if($chats->isEmpty())
        <p class="text-center text-gray-500 mt-4">Tidak ada chat.</p>
    @else
        @foreach($chats as $chat)
            @if($isSeller)
                {{-- Penjual melihat daftar user --}}
                <button class="flex items-center gap-3 py-2 px-4 cursor-pointer rounded-md shadow bg-gray-100 hover:bg-[#c4dfd9] mt-4 w-full transition duration-500 chat-item"
                        data-id="{{ $chat->id_user }}" data-type="user">
                    <img src="{{ asset('storage/' . $chat->foto_profil) }}"
                         class="h-14 w-14 rounded-full border border-gray-200" alt="{{ $chat->username }}">
                    <div class="text-start">
                        <h1 class="text-lg font-medium">{{ $chat->username }}</h1>
                        <div class="flex items-center gap-4 justify-between">
                            <p class="truncate w-56 font-medium text-zinc-500">{{ $chat->messages->first()->message ?? '' }}</p>
                        </div>
                    </div>
                </button>
            @else
                {{-- Pembeli melihat daftar toko --}}
                <button class="flex items-center gap-3 py-2 px-4 cursor-pointer rounded-md shadow bg-gray-100 hover:bg-[#c4dfd9] mt-4 w-full transition duration-500 chat-item"
                        data-id="{{ $chat->id_toko }}" data-type="toko">
                    <img src="{{ asset('storage/' . $chat->logo_toko) }}"
                         class="h-14 w-14 rounded-full border border-gray-200" alt="{{ $chat->nama_toko }}">
                    <div class="text-start">
                        <h1 class="text-lg font-medium">{{ $chat->nama_toko }}</h1>
                        <div class="flex items-center gap-4 justify-between">
                            <p class="truncate w-56 font-medium text-zinc-500">{{ $chat->messages->first()->message ?? '' }}</p>
                        </div>
                    </div>
                </button>
            @endif
        @endforeach
    @endif
</div>
