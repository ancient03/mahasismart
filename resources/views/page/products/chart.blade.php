<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  {{-- Tailwind + font.css --}}
  @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/font.css'])

  {{-- Font Awesome (pindahkan ke bawah) --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>MahasisMart - Home</title>
</head>

<body class="font-['Poppins']">
    <x-NavBar />


<main class="container mx-auto p-4 md:p-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <section class="lg:col-span-2 space-y-6">
                
                <h1 class="text-3xl font-bold text-gray-900">Keranjang</h1>

                {{-- LOOPING ITEM KERANJANG (Contoh 3x) --}}
                @for ($i = 0; $i < 3; $i++)
                <div class="bg-white rounded-lg shadow-md p-4 flex space-x-4">
                    
                    <div class="flex-shrink-0 w-24 h-24 md:w-32 md:h-32 bg-gray-300 rounded-lg">
                        </div>

                    <div class="flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-sm text-gray-600">Harga</span>
                            <h3 class="font-bold text-lg md:text-xl text-gray-900">Judul Barang</h3>
                            <span class="text-sm text-gray-600">Toko</span>
                        </div>
                    </div>

                    <div class="flex-shrink-0 flex flex-col justify-between items-end">
                        <span class="text-sm font-semibold text-green-600">Sisa 1</span>
                        
                        <div class="flex items-center space-x-2 mt-4">
                            <button class="text-gray-500 hover:text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>

                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button class="w-8 h-8 flex items-center justify-center text-gray-700 hover:bg-gray-100 rounded-l-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <input type="text" value="1" class="w-12 h-8 text-center border-l border-r border-gray-300 focus:outline-none">
                                <button class="w-8 h-8 flex items-center justify-center text-gray-700 hover:bg-gray-100 rounded-r-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
                {{-- AKHIR LOOP --}}

            </section>

            <section class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-28">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Total</h2>
                    
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-600">Harga</span>
                        <span class="text-gray-900 font-medium">Rp. 60.000</span> {{-- Contoh total --}}
                    </div>
                    
                    <div class="border-t border-gray-200 my-4"></div>

                    <div class="flex justify-between items-center mb-4">
                        <span class="text-xl font-bold text-gray-900">Total</span>
                        <span class="text-xl font-bold text-gray-900">Rp. 60.000</span>
                    </div>

                    <button class="bg-yellow-500 hover:bg-yellow-600 text-black w-full py-3 rounded-lg font-bold text-lg transition-colors">
                        BELI
                    </button>
                </div>
            </section>

        </div>
    </main>

    <x-nav-mobile/>

</body>
</html>