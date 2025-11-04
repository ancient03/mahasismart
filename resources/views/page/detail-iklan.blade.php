<x-layout.layout>
    <section class="max-w-5xl mx-auto py-10">
        <img src="{{ asset($iklan->gambar) }}" 
             alt="{{ $iklan->nama_iklan }}" 
             class="w-full h-96 object-cover rounded-lg mb-6 shadow-md">

        <h1 class="text-3xl font-bold mb-2">{{ $iklan->nama_iklan }}</h1>
        <p class="text-lg italic text-gray-600 mb-4">{{ $iklan->slogan }}</p>

        <div class="text-gray-700 leading-relaxed">
            {{ $iklan->deskripsi }}
        </div>
    </section>
</x-layout.layout>
