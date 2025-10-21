# Jangan lupa ("git pull origin main") di terminal SEBELUM MEMULAI NGODING

# setiap view blade yang ada style tailwind wajid di kasih ini di bagian head nya

  {{-- Tailwind + font.css --}}
  @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/font.css'])

  {{-- Font Awesome (pindahkan ke bawah) --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

----------------------------------------------------------------------------------------------------
# untuk memulai project
` php artisan serve `
# setelah memulai project
` npm run dev `

# untuk membuat database di phpmyadmin
` php artisan migrate `

# jika ada edit di database update menggunakan
` php artisan migrate:fresh `

# Untuk membuat component untuk view
` php artisan make: component `
