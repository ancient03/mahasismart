@if (!Route::is('page.chat'))
<<<<<<< HEAD
    <a href=""
=======
    <a href="{{ route('page.chat') }}"
>>>>>>> 441768e18805edb3d840ea4992a0dc7e75bba5f4
        class="fixed bottom-6 right-6 z-50 bg-[#00795E] hover:bg-green-700 text-white p-4 rounded-2xl shadow-lg transition-colors duration-200"
        aria-label="Mulai Chat">
        <i class="bi bi-chat-right-text-fill text-2xl"></i>
    </a>
@endif
