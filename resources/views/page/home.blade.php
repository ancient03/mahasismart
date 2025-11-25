<x-layout>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 space-y-8 py-6">

        <!-- Banner -->
        <section class="w-full mb-8 relative">
            @if ($iklanAktif->count() > 0)
                <div id="iklanCarousel" class="relative w-full overflow-hidden rounded-lg shadow-lg">

                    <!-- Wrapper semua slide -->
                    <div class="flex transition-transform duration-700 ease-in-out" id="carouselSlides">
                        @foreach ($iklanAktif as $iklan)
                            <a href="" class="min-w-full relative block">
                                <!-- Gambar -->
                                <img src="{{ asset($iklan->gambar) }}" alt="{{ $iklan->nama_iklan }}"
                                    class="w-full h-64 md:h-96 object-cover rounded-lg">

                                <!-- Overlay bawah -->
                                <div
                                    class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 via-black/40 to-transparent p-6 rounded-b-lg">
                                    <h2 class="text-white text-2xl font-semibold">{{ $iklan->nama_iklan }}</h2>
                                    <p class="text-gray-200 italic text-sm">{{ $iklan->slogan }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Tombol Navigasi -->
                    <button id="prevSlide"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 bg-black/30 backdrop-blur-lg hover:bg-black text-white py-1 px-2 rounded-full transition">
                        <i class="bi bi-chevron-left text-xl"></i>
                    </button>

                    <button id="nextSlide"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-black/30 backdrop-blur-lg hover:bg-black text-white py-1 px-2 rounded-full transition">
                        <i class="bi bi-chevron-right text-xl"></i>
                    </button>
                </div>
            @else
                <div class="w-full h-64 flex items-center justify-center bg-gray-100 rounded-lg border border-gray-200">
                    <p class="text-gray-500 text-lg">Belum ada iklan aktif saat ini.</p>
                </div>
            @endif
        </section>

        <!-- Script Carousel -->
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const slides = document.getElementById("carouselSlides");
                const totalSlides = slides.children.length;
                const prev = document.getElementById("prevSlide");
                const next = document.getElementById("nextSlide");
                let index = 0;

                // Fungsi ganti slide
                const updateSlide = () => {
                    slides.style.transform = `translateX(-${index * 100}%)`;
                };

                // Tombol next
                next.addEventListener("click", () => {
                    index = (index + 1) % totalSlides;
                    updateSlide();
                });

                // Tombol prev
                prev.addEventListener("click", () => {
                    index = (index - 1 + totalSlides) % totalSlides;
                    updateSlide();
                });

                // Auto slide tiap 5 detik
                setInterval(() => {
                    index = (index + 1) % totalSlides;
                    updateSlide();
                }, 5000);
            });
        </script>



        <!-- Kategori -->
        <section class="bg-white p-5 rounded-xl shadow">
            <h2 class="text-xl font-bold mb-4 text-gray-900">Kategori</h2>

            <div class="flex overflow-x-auto space-x-3 pb-2 scrollbar-thin scrollbar-thumb-gray-300">
                @forelse ($kategoriList as $kategori)
                    {{-- Link ke halaman pencarian untuk kategori ini (buat rutenya nanti) --}}
                    <a href="{{-- route('search.kategori', $kategori->id_kategori) --}}" class="flex-shrink-0 w-20 text-center group">

                        {{-- Tampilkan Gambar Kategori --}}
                        <div
                            class="w-16 h-16 bg-gray-200 rounded-full mx-auto mb-2 overflow-hidden border-2 border-transparent group-hover:border-green-500 transition">
                            @if ($kategori->gambar)
                                {{-- Controller Anda menyimpan path lengkap 'img/fotokategori/...' --}}
                                <img src="{{ asset($kategori->gambar) }}" alt="{{ $kategori->nama_kategori }}"
                                    class="w-full h-full object-cover">
                            @else
                                {{-- Placeholder jika tidak ada gambar --}}
                                <span class="flex items-center justify-center h-full text-3xl text-gray-400">
                                    <i class="bi bi-tag-fill"></i>
                                </span>
                            @endif
                        </div>

                        {{-- Tampilkan Nama Kategori --}}
                        <p class="text-sm font-medium text-gray-700 truncate group-hover:text-green-600"
                            title="{{ $kategori->nama_kategori }}">
                            {{ $kategori->nama_kategori }}
                        </p>
                    </a>
                @empty
                    <p class="text-sm text-gray-500">Belum ada kategori yang tersedia.</p>
                @endforelse
            </div>
        </section>

        <section>
            <h2 class="text-xl font-bold mb-4">Semua Produk</h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">

                {{-- Loop data barang dari controller --}}
                @forelse ($barangList as $barang)
                    {{-- 
                          👇 PERBAIKAN DI SINI 👇
                          Kirim variabel '$barang' dari loop ke komponen 
                          sebagai properti bernama 'barang'.
                          Gunakan ':' sebelum nama properti.
                          Pastikan nama komponen 'cardproduk.card' sudah benar.
                        --}}
                    <x-cardproduk.card :barang="$barang" />

                @empty
                    {{-- Pesan jika tidak ada produk sama sekali --}}
                    <p class="col-span-full text-center text-gray-500 py-10">
                        Belum ada produk yang tersedia saat ini.
                    </p>
                @endforelse

            </div>

            {{-- Tampilkan Link Pagination --}}
            <div class="mt-8">
                {{ $barangList->links() }}
            </div>

        </section>

    </div>
</x-layout>
