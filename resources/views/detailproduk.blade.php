<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  {{-- tailwindcss + font --}}
  @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/font.css'])

  {{-- icon --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

  <title>Detail - Produk</title>
</head>
<body class="poppins">
  {{-- navbar --}}
  <x-nav-bar/>

  {{-- produk --}}
  <x-detailproduk.produk/>

  {{-- toko --}}
  <x-detailproduk.toko/>



</body>
</html>