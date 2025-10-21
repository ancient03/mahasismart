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

<body class="">
    
    {{-- 1. NAVBAR --}}
    <x-NavBar />

    {{-- 2. KONTEN UTAMA PROFIL --}}
    <main class="container mx-auto p-4 md:p-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <aside class="md:col-span-1">
                <div class="bg-white text-gray-800 rounded-lg shadow p-6">
                    
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-bold text-lg">Username</span>
                            <a href="#" class="text-sm text-blue-600 hover:underline">Edit Profil</a>
                        </div>
                    </div>

                    <nav class="space-y-2">
                        <a href="#" class="flex items-center space-x-3 py-2 px-3 rounded-md font-semibold bg-green-100 text-green-700">
                            <span>Profil</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 py-2 px-3 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                            <span>Alamat</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 py-2 px-3 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                            <span>Pesanan Saya</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 py-2 px-3 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                            <span>Toko Saya</span>
                        </a>
                    </nav>
                </div>
            </aside>

            <section class="md:col-span-3">
                <div class="bg-white text-gray-800 rounded-lg shadow p-6 md:p-8">
                    
                    <h1 class="text-2xl font-bold mb-6">Profil Saya</h1>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        <form class="lg:col-span-2 space-y-4">
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700">Username:</label>
                                <input type="text" id="username" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama:</label>
                                <input type="text" id="nama" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                                <input type="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>
                            <div>
                                <label for="telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon:</label>
                                <input type="text" id="telepon" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                                <input type="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin:</label>
                                <div class="mt-2 flex items-center space-x-6">
                                    <label for="laki" class="flex items-center">
                                        <input type="radio" id="laki" name="jenis_kelamin" class="text-green-600 focus:ring-green-500" checked>
                                        <span class="ml-2">Laki-Laki</span>
                                    </label>
                                    <label for="perempuan" class="flex items-center">
                                        <input type="radio" id="perempuan" name="jenis_kelamin" class="text-green-600 focus:ring-green-500">
                                        <span class="ml-2">Perempuan</span>
                                    </label>
                                    <label for="rahasia" class="flex items-center">
                                        <input type="radio" id="rahasia" name="jenis_kelamin" class="text-green-600 focus:ring-green-500">
                                        <span class="ml-2">Tidak ingin memberitahu</span>
                                    </label>
                                </div>
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="bg-gray-700 text-white py-2 px-5 rounded-lg font-semibold hover:bg-gray-800 transition-colors">
                                    Save Changes
                                </button>
                            </div>
                        </form>

                        <div class="lg:col-span-1 flex flex-col items-center space-y-4 pt-8 lg:pt-0">
                            <div class="w-40 h-40 bg-gray-200 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <button type="button" class="bg-gray-200 text-gray-800 py-2 px-5 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                                Pilih Gambar
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8 border-t border-gray-200 pt-6">
                        <a href="#" class="bg-red-600 text-white py-2 px-5 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                            Logout
                        </a>
                    </div>

                </div>
            </section>

        </div>
    </main>

</body>
</html>