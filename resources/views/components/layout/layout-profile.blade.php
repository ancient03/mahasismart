<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  {{-- Tailwind + font.css --}}
  @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/font.css'])

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  {{-- Font Awesome (pindahkan ke bawah) --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>MahasisMart - Home</title>
</head>

<body class="font-['Poppins'] bg-zinc-50">
    <x-NavBarsetelahlogin />
    <div class="container mx-auto lg:px-6 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            
            <div>
            <x-sidebar.sidebar-profile/>
            <x-sidebar.sidebar-toko/>
            </div>
                {{ $slot }}

        </div>
    </div>
    <x-nav-mobile/>
    <x-modal-success /> {{-- Panggil komponen modal --}}
    <x-modal-error />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>