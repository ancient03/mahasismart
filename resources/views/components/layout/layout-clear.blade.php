<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Tailwind + font.css --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/font.css'])

    {{-- CDN Botstrap Icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>MahasisMart</title>
</head>
<body class="bg-[#00795E] font-[poppins] flex items-center justify-center min-h-screen px-4">
    <main>
        {{ $slot }}
    </main>
    <x-modal-success /> {{-- Panggil komponen modal --}}
</body>
</html>