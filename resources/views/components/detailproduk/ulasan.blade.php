<div class="flex gap-3 py-6 border-b lg:border-b-4 border-zinc-100">
  {{-- profil --}}
  <div class="shrink-0">
    <div class="h-12 w-12 aspect-square overflow-hidden rounded-full">
      <img 
        src="{{ asset('img/jokowikaget.jpg') }}" 
        alt="Jokowi" 
        class="w-full h-full object-cover"
      >
    </div>
  </div>

  {{-- nama/bintang/tanggal/ulasan/foto ulasan --}}
  <div>
    <h1 class="font-semibold text-lg">J**o D***o</h1>

    <div class="flex gap-2 items-center">
      <i class="bi bi-star-fill text-yellow-400"></i>
      <i class="bi bi-star-fill text-yellow-400"></i>
      <i class="bi bi-star-fill text-yellow-400"></i>
      <i class="bi bi-star-fill text-yellow-400"></i>
      <i class="bi bi-star-fill text-yellow-400"></i>
    </div>

    <div class="flex items-center gap-2 my-2 text-sm text-zinc-600">
      <p>23/10/2025 10.00 WIB</p>
      <span>|</span>
      <p>Variasi: Besar</p>
    </div>

    <p class="text-lg font-medium line-clamp-1">
      Yo ndak tau tanya ko tanya saya Yo ndak tau tanya ko tanya saya Yo ndak tau tanya ko tanya saya
    </p>

    <div class="flex gap-3 items-center mt-2">
      <img src="{{ asset('img/jokowikaget.jpg') }}" alt="ulasan1" class="lg:h-24 lg:w-24 h-16 w-16 object-cover rounded-md">
      <img src="{{ asset('img/jokowikaget.jpg') }}" alt="ulasan2" class="lg:h-24 lg:w-24 h-16 w-16 object-cover rounded-md">
      <img src="{{ asset('img/jokowikaget.jpg') }}" alt="ulasan3" class="lg:h-24 lg:w-24 h-16 w-16 object-cover rounded-md">
    </div>
  </div>
</div>
