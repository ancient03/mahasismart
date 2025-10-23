<x-layout.layoutdetailproduk>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
    {{-- produk --}}
    <x-detailproduk.produk/>

    {{-- toko --}}
    <x-detailproduk.toko/>

    {{-- rating --}}
    <x-detailproduk.rating/>

    {{-- ulasan --}}
    <x-detailproduk.ulasan/>

    {{-- produk --}}
    <h1 class="lg:text-2xl text-1xl font-semibold">Rekomendasi Produk</h1>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">        
        <x-card/>
        <x-card/>
        <x-card/>
        <x-card/>
        <x-card/>
        <x-card/>
        <x-card/>
        <x-card/>
    </div>
  </div>
</x-layout.layoutdetailproduk>