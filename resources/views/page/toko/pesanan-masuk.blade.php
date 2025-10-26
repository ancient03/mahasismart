 <x-layout.layout-profile>
     <section class="md:col-span-3">
         {{-- Header --}}
         <div class="py-3 px-5 lg:rounded-md shadow-md bg-white">
             <h1 class="lg:text-2xl text-1xl font-semibold">Pesanan Masuk</h1>
         </div>

         {{-- Produk 1 --}}
         <div class="p-4 mt-6 lg:rounded-md shadow-md bg-white w-full">
             <div class="flex flex-col md:flex-row gap-4">
                 {{-- Foto Barang --}}
                 <div class="flex-shrink-0">
                     <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQssFrYujuBrf5Et_UF5x0IbeDzh4q6qGuFFw&s"
                         alt="Foto Produk" class="h-32 w-auto rounded-md object-cover">
                 </div>

                 {{-- Detail Produk --}}
                 <div class="flex-1">
                     <div>
                         <h1 class="lg:text-2xl text-lg font-semibold">Pocari Sweet</h1>
                         <p class="text-2xl md:text-3xl font-bold text-zinc-800">Rp 5.000</p>
                     </div>

                     <div class="flex items-center justify-end mt-4">
                         <a href="#"
                             class="bg-[#D7D7D7] text-white py-2 px-6 rounded-md font-medium hover:bg-[#9e9e9e] transition duration-500">
                             Proses
                         </a>
                     </div>
                 </div>
             </div>
         </div>

         {{-- Produk 2 --}}
         <div class="p-4 mt-6 lg:rounded-md shadow-md bg-white w-full">
             <div class="flex flex-col md:flex-row gap-4">
                 {{-- Foto Barang --}}
                 <div class="flex-shrink-0">
                     <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR4-hUIvm49HqHRd0HQwKU5ZS-1q62KIhL5Eg&s"
                         alt="Foto Produk" class="h-32 w-auto rounded-md object-cover">
                 </div>

                 {{-- Detail Produk --}}
                 <div class="flex-1">
                     <div>
                         <h1 class="lg:text-2xl text-lg font-semibold">Teh Botol Sosro</h1>
                         <p class="text-2xl md:text-3xl font-bold text-zinc-800">Rp 4.000</p>
                     </div>

                     <div class="flex items-center justify-end mt-4">
                         <a href="#"
                             class="bg-[#FCB417] text-white py-2 px-6 rounded-md font-medium hover:bg-[#c58700] transition duration-500">
                             Proses
                         </a>
                     </div>
                 </div>
             </div>
         </div>

         {{-- Produk 3 --}}
         <div class="p-4 mt-6 lg:rounded-md shadow-md bg-white w-full mb-96">
             <div class="flex flex-col md:flex-row gap-4">
                 {{-- Foto Barang --}}
                 <div class="flex-shrink-0">
                     <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR4-hUIvm49HqHRd0HQwKU5ZS-1q62KIhL5Eg&s"
                         alt="Foto Produk" class="h-32 w-auto rounded-md object-cover">
                 </div>

                 {{-- Detail Produk --}}
                 <div class="flex-1">
                     <div>
                         <h1 class="lg:text-2xl text-lg font-semibold">Teh Botol Sosro</h1>
                         <p class="text-2xl md:text-3xl font-bold text-zinc-800">Rp 4.000</p>
                     </div>

                     <div class="flex items-center justify-end mt-4">
                         <a href="#"
                             class="bg-[#B5F2C9] text-white py-2 px-6 rounded-md font-medium hover:bg-[#5fd687] transition duration-500">
                             Selesai
                         </a>
                     </div>
                 </div>
             </div>
         </div>
     </section>
 </x-layout.layout-profile>
