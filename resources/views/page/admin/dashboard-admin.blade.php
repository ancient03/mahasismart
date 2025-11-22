<x-layout.layout-admin>
    <section class="md:col-span-3">

        <div class="py-10 px-6 shadow-xl rounded-lg border border-zinc-200 hover:shadow-2xl transition duration-300 flex flex-col items-center text-center gap-4">
                <h2 class="text-2xl font-bold mb-2 text-gray-800">Selamat Datang, Atmin</h2>
        
                    <img src="{{ asset('img/admindatang.jpeg') }}" 
                         alt="" 
                         class=""> {{-- Sedikit diperbesar (w-24) --}}

                <p class="text-gray-600 text-base max-w-md mx-auto">
                    Di sini Anda dapat mengelola toko, pengguna, iklan, dan laporan yang masuk.
                </p>

    </section>

</x-layout.layout-admin>