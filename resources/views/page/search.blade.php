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
            <div class="flex items-center space-x-2 mb-6">
                <button class="bg-gray-200 text-gray-900 font-semibold py-2 px-6 rounded-lg">
                    Produk
                </button>
                <button class="bg-gray-700 text-gray-300 hover:bg-gray-600 font-semibold py-2 px-6 rounded-lg transition-colors">
                    Toko
                </button>
            </div>
            
            <section>
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