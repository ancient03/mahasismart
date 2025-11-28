<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  {{-- Tailwind + font.css --}}
  @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/font.css'])

  {{-- CDN Botstrap Icon --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <title>MahasisMart - Home</title>
</head>
<body>

    {{-- navbar dekstop --}}
    <div class="hidden lg:block">
    <x-navbar.nav-barsetelahlogin/>
    </div>

    {{-- navbar mobile --}}
    <div class="lg:hidden md:hidden">
        <x-navbar.navdetailproduk/>
    </div>

    {{-- nvbar bottom mobile --}}
    <x-navbar.mobiledetailproduk/>
    <main class="py-8">
        {{ $slot }}
    </main>
    
    <x-modal-success /> {{-- Panggil komponen modal --}}
    <x-modal-error />

</body>
</html>