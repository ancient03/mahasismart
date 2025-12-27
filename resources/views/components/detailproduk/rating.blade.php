@props(['avgRating' => 0, 'totalRating' => 0])

<div>
    {{-- Judul --}}
    <h1 class="text-xl lg:text-2xl font-semibold">Penilaian Produk</h1>

    {{-- Jumlah dan Filter --}}
    <div class="p-6 bg-zinc-100 rounded-lg flex flex-col lg:flex-row lg:items-center mt-6 gap-8">

        {{-- Bagian Rating + Dropdown (mobile) --}}
        <div class="w-full flex justify-between items-center lg:block lg:w-auto">
            {{-- Rating (Dinamis) --}}
            <div class="text-center">
                <h1 class="text-2xl lg:text-4xl font-bold">
                    <span>{{ number_format($avgRating, 1) }}</span>
                    <span class="text-base lg:text-xl font-normal">dari</span>
                    <span>5</span>
                </h1>
                <div class="flex items-center justify-center gap-1 lg:gap-3 mt-1 lg:mt-2 text-yellow-400">
                    {{-- Logika Bintang (Penuh, Setengah, Kosong) --}}
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($avgRating >= $i)
                            <i class="bi bi-star-fill text-xl lg:text-3xl"></i>
                        @elseif ($avgRating >= $i - 0.5)
                            <i class="bi bi-star-half text-xl lg:text-3xl"></i>
                        @else
                            <i class="bi bi-star text-xl lg:text-3xl text-gray-400"></i>
                        @endif
                    @endfor
                </div>
                <p class="text-sm text-gray-500 mt-2">{{ $totalRating }} Ulasan</p>
            </div>

            {{-- Dropdown (mobile) --}}
            <div class="block lg:hidden w-1/2">
                <select id="rating-filter-mobile"
                    class="w-full p-2 rounded-md bg-zinc-200 border border-zinc-300 cursor-pointer text-sm focus:ring-2 focus:ring-[#00795E] focus:outline-none">
                    <option value="all">Semua</option>
                    <option value="5">5 Bintang</option>
                    <option value="4">4 Bintang</option>
                    <option value="3">3 Bintang</option>
                    <option value="2">2 Bintang</option>
                    <option value="1">1 Bintang</option>
                    <option value="with-image">Dengan Gambar</option>
                    <option value="with-comment">Dengan Komentar</option>
                </select>
            </div>
        </div>

        {{-- Tombol Filter (desktop) --}}
        <div id="rating-filter-desktop" class="hidden lg:flex flex-wrap gap-4 p-2 justify-start">
            <button data-filter="all"
                class="py-2 px-4 bg-white border border-green-600 text-green-700 shadow rounded-lg transition cursor-pointer font-medium filter-btn">Semua</button>
            <button data-filter="5"
                class="py-2 px-4 bg-white border border-gray-300 shadow rounded-lg hover:bg-gray-50 transition cursor-pointer filter-btn">5
                Bintang</button>
            <button data-filter="4"
                class="py-2 px-4 bg-white border border-gray-300 shadow rounded-lg hover:bg-gray-50 transition cursor-pointer filter-btn">4
                Bintang</button>
            <button data-filter="3"
                class="py-2 px-4 bg-white border border-gray-300 shadow rounded-lg hover:bg-gray-50 transition cursor-pointer filter-btn">3
                Bintang</button>
            <button data-filter="2"
                class="py-2 px-4 bg-white border border-gray-300 shadow rounded-lg hover:bg-gray-50 transition cursor-pointer filter-btn">2
                Bintang</button>
            <button data-filter="1"
                class="py-2 px-4 bg-white border border-gray-300 shadow rounded-lg hover:bg-gray-50 transition cursor-pointer filter-btn">1
                Bintang</button>
            <button data-filter="with-image"
                class="py-2 px-4 bg-white border border-gray-300 shadow rounded-lg hover:bg-gray-50 transition cursor-pointer filter-btn">Dengan
                Gambar</button>
            <button data-filter="with-comment"
                class="py-2 px-4 bg-white border border-gray-300 shadow rounded-lg hover:bg-gray-50 transition cursor-pointer filter-btn">Dengan
                Komentar</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const desktopFilters = document.getElementById('rating-filter-desktop');
        const mobileFilter = document.getElementById('rating-filter-mobile');
        
        // The list of reviews is now expected to be outside this component
        const reviewList = document.getElementById('review-list');

        // If there's no review list on the page, this script doesn't need to run.
        if (!reviewList) return;

        const getReviewItems = () => Array.from(reviewList.querySelectorAll('.review-item'));

        function filterReviews(filter) {
            const reviewItems = getReviewItems();
            let hasVisibleReviews = false;

            reviewItems.forEach(item => {
                const rating = item.dataset.rating;
                const hasImage = item.dataset.hasImage === 'true';
                const hasComment = item.dataset.hasComment === 'true';

                let show = false;
                if (filter === 'all') {
                    show = true;
                } else if (filter === 'with-image') {
                    if (hasImage) show = true;
                } else if (filter === 'with-comment') {
                    if (hasComment) show = true;
                } else {
                    if (rating === filter) show = true;
                }

                if (show) {
                    item.style.display = 'flex';
                    hasVisibleReviews = true;
                } else {
                    item.style.display = 'none';
                }
            });

            // Handle "No reviews found" message
            let noResultEl = reviewList.querySelector('.no-results');
            if (!hasVisibleReviews) {
                if (!noResultEl) {
                    noResultEl = document.createElement('div');
                    noResultEl.className = 'no-results text-center py-10 text-gray-500';
                    noResultEl.textContent = 'Tidak ada ulasan yang cocok dengan filter ini.';
                    reviewList.appendChild(noResultEl);
                }
            } else {
                if (noResultEl) {
                    noResultEl.remove();
                }
            }
        }

        if (desktopFilters) {
            desktopFilters.addEventListener('click', function(e) {
const targetButton = e.target.closest('.filter-btn');
                if (targetButton) {
                    const filter = targetButton.getAttribute('data-filter');
                    filterReviews(filter);

                    // Sync mobile dropdown
                    if (mobileFilter) mobileFilter.value = filter;

                    // Update active button style
                    desktopFilters.querySelectorAll('.filter-btn').forEach(btn => {
                        btn.classList.remove('border-green-600', 'text-green-700',
                            'font-medium');
                        btn.classList.add('border-gray-300', 'hover:bg-gray-50');
                    });
                    targetButton.classList.add('border-green-600', 'text-green-700',
                        'font-medium');
                    targetButton.classList.remove('border-gray-300', 'hover:bg-gray-50');
                }
            });
        }

        if (mobileFilter) {
            mobileFilter.addEventListener('change', function(e) {
                const filter = e.target.value;
                filterReviews(filter);

                // Sync desktop buttons
                if (desktopFilters) {
                    desktopFilters.querySelectorAll('.filter-btn').forEach(btn => {
                        btn.classList.remove('border-green-600', 'text-green-700',
                            'font-medium');
                        btn.classList.add('border-gray-300', 'hover:bg-gray-50');

                        if (btn.getAttribute('data-filter') === filter) {
                            btn.classList.add('border-green-600', 'text-green-700',
                                'font-medium');
                            btn.classList.remove('border-gray-300', 'hover:bg-gray-50');
                        }
                    });
                }
            });
        }
    });
</script>