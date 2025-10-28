<x-layout>
    <div class="flex container mx-auto px-4 sm:px-6 lg:px-8 gap-4">
        <!-- Sidebar -->
        {{-- <div class="w-1/4 overflow-y-auto h-[calc(100vh-100px)] pr-2"> --}}
            <x-sidebar.sidebar-chat />
        {{-- </div> --}}

        <!-- Chat (Tetap diam / fixed) -->
        <div class="flex-1 sticky top-[100px] h-[calc(100vh-120px)]">
            <x-chat.content-chat />
        </div>
    </div>
</x-layout>
