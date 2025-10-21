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
<div class="w-full h-1.5"></div>

    <main class="py-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <section class="bg-gray-300 h-64 rounded-lg flex items-center justify-center text-gray-600 font-bold text-xl">
                Banner Info/Iklan/Promo
            </section>

            <section class="bg-white p-5 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-4">Kategori</h2>
                
                <div class="flex overflow-x-auto space-x-4 pb-4">
                    
                    {{-- Untuk Kategori taroh di bawah ini --}}
                    @for ($i = 0; $i < 9; $i++)
                    <div class="flex-shrink-0 w-24">
                        <div class="w-24 h-24 bg-gray-300 rounded-lg">
                            </div>
                        <p class="text-center text-sm mt-2 font-medium">Kategori {{ $i + 1 }}</p>
                    </div>
                    @endfor

                </div>
            </section>

            <section>
                <h2 class="text-xl font-bold mb-4">Produk Pilihan</h2>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    
                    {{-- Komponen Card di panggil di sini--}}
                    <x-card/>
                    <x-card/>
                    <x-card/>
                    <x-card/>
                    <x-card/>
                    <x-card/>
                    <x-card/>
                    <x-card/>

                </div>
            </section>

        </div>
    </main>

    <x-nav-mobile/>
</body>
</html>