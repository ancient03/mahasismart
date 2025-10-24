<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  {{-- Tailwind + font.css --}}
  @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/font.css'])

  {{-- CDN Bootstrap Icons --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

  <title>MahasisMart - Checkout</title>
</head>
<body class="font-[poppins] bg-zinc-50">

  {{-- Navbar Checkout --}}
  <x-navbar.nav-checkout />

  <section class="mt-24 lg:px-6 py-4">
    <!-- Judul -->
    <h1 class="text-2xl font-semibold mb-6 px-4 lg:px-0">Checkout</h1>

    <div class="flex flex-col lg:flex-row gap-6">
      <!-- Kiri: Alamat + Daftar Barang -->
      <div class="flex-1 space-y-6">
        
        <!-- Alamat Pengiriman -->
        <div class="p-4 bg-zinc-100 lg:rounded-lg shadow-md flex justify-between items-start">
          <div>
            <h2 class="text-lg font-semibold mb-1">Alamat Pengiriman</h2>
            <p class="text-sm text-zinc-700 flex items-center gap-2">
              <i class="bi bi-geo-alt text-lg"></i>
              UDINUS GEDUNG G
            </p>
          </div>
          <button class="bg-white text-sm border border-zinc-300 px-4 py-1 rounded-md hover:bg-zinc-200 transition">
            Ganti Alamat
          </button>
        </div>

        <!-- Daftar Barang -->
        <div class="p-4 bg-zinc-100 lg:rounded-lg shadow-md space-y-6">
          
          <!-- Toko -->
          <div class="flex items-center gap-3 border-zinc-300">
            <img src="{{ asset('img/kuning.png') }}" alt="Toko" class="h-8 w-8 rounded-full object-cover">
            <h1 class="text-lg font-semibold">Toko Taufan Afandi</h1>
          </div>

          <!-- Barang -->
          <div class="flex items-start gap-4">
            <!-- Gambar Produk -->
            <div class="w-38 h-26 bg-white rounded-md overflow-hidden flex items-center justify-center">
              <img 
                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQssFrYujuBrf5Et_UF5x0IbeDzh4q6qGuFFw&s"
                alt="Produk 1"
                class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
              >
            </div>

            <!-- Info Produk -->
            <div class="flex-1 relative">
              <div>
                <h3 class="font-semibold text-lg">Judul Barang</h3>
                <p class="text-2xl font-semibold text-zinc-800 py-3">Rp 5.000</p>
                <p class="text-md font-medium text-zinc-600">Sisa 1</p>
              </div>

              <!-- Jumlah & Tombol Sampah di kanan bawah -->
              <div class="absolute bottom-0 right-0 flex items-center gap-3">
                <!-- Input Jumlah -->
                <div class="flex items-center border rounded-lg overflow-hidden">
                  <button class="px-3 py-1 hover:bg-zinc-200 transition">-</button>
                  <span class="px-3">1</span>
                  <button class="px-3 py-1 hover:bg-zinc-200 transition">+</button>
                </div>

                <!-- Tombol Sampah -->
                <button class="text-zinc-600 hover:text-red-600 transition">
                  <i class="bi bi-trash text-xl"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Kanan: Ringkasan Pembayaran -->
      <div class="w-full lg:w-1/3 bg-zinc-100 lg:rounded-lg shadow-md p-4 h-fit">
        <h2 class="text-lg font-semibold mb-2">Metode Pembayaran</h2>
        <p class="text-xl font-bold">COD <i class="bi bi-cash-coin"></i></p>

        <div class="mt-4 text-sm text-zinc-700 space-y-2">
          <p class="font-semibold">Ringkasan transaksi</p>
          <div class="flex justify-between"><span>Total Harga (2 Barang)</span><span>Rp. 6.000.000</span></div>
          <div class="flex justify-between"><span>Total Ongkir</span><span>Rp. 67.000</span></div>
          <div class="flex justify-between"><span>Biaya Jasa Aplikasi</span><span>Rp. 2.500</span></div>
        </div>

        <button class="w-full mt-6 text-white bg-[#00795E] py-3 rounded-md font-semibold hover:bg-[#005a47] transition duration-500">
          Beli Sekarang
        </button>
      </div>
    </div>
  </section>

</body>
</html>
