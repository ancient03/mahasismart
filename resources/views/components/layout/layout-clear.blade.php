<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Tailwind + font.css --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/font.css'])

    {{-- Font Awesome (pindahkan ke bawah) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>MahasisMart</title>
</head>
<body class="bg-[#00795E] font-[poppins] flex items-center justify-center min-h-screen px-4">
    <main>
        {{ $slot }}
    </main>
</body>
</html>