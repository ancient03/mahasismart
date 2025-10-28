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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>MahasisMart - Home</title>
</head>

<body class="font-['Poppins']">
    <x-NavBarsetelahlogin />
    <div class="w-full"></div>

    <main class="">
        {{ $slot }}
    </main>

    <x-navbar.chat />
    <x-nav-mobile />
</body>

</html>
