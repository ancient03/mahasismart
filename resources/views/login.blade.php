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
  <title>Login Page</title>
</head>
<body class="bg-[#2E8BFD] font-[poppins] flex items-center justify-center min-h-screen px-4">
  <div class="flex flex-col md:flex-row items-center justify-between gap-10 md:gap-20 w-full max-w-6xl">

    {{-- Logo Section --}}
    <div class="hidden md:flex flex-col md:flex-row items-center justify-center md:justify-start gap-4 text-center md:text-left">
      <img src="{{ asset('img/kuning-nobg.png') }}" alt="Logo" class="object-contain w-32 h-32 md:w-48 md:h-48">
      <p class="text-4xl md:text-5xl text-[#FDBA38] font-semibold">MahasisMart</p>
    </div>

    {{-- Login Form --}}
    <div class="lg:bg-white bg-[#2E8BFD] rounded-xl w-full sm:w-[90%] md:w-[420px] lg:w-[450px] p-6 sm:p-8">
      <form action="">
        <p class="text-2xl md:text-3xl font-semibold mb-8 text-zinc-950 text-center">Login</p>

        {{-- Input Username --}}
        <input 
          type="text" 
          placeholder="No. Handphone / Username / Email"
          class="w-full border border-zinc-500 bg-zinc-200 lg:bg-white p-3 rounded-md mb-4 focus:outline-none focus:ring-2 focus:ring-[#FDBA38]">

        {{-- Input Password --}}
        <input 
          type="password" 
          placeholder="Password"
          class="w-full border border-zinc-500 bg-zinc-200 lg:bg-white p-3 rounded-md mb-3 focus:outline-none focus:ring-2 focus:ring-[#FDBA38]">

        {{-- Tombol Login --}}
        <button 
          type="submit" 
          class="bg-[#FDBA38] text-zinc-950 lg:text-zinc-500 cursor-pointer font-semibold w-full p-3 rounded-md hover:bg-[#e0a733] transition">
          Login
        </button>

        {{-- Lupa Password --}}
        <a href="/login" class="text-sm lg:text-zinc-500 text-zinc-950 hover:underline block mt-3 hover:text-red-500 ">Lupa Password</a>

        {{-- Garis pemisah "Atau" --}}
        <div class="flex items-center justify-center gap-4 mt-10">
          <div class="flex-1 border-t border-zinc-400"></div>
          <p class="text-sm lg:text-zinc-500 text-zinc-950 font-medium">Atau</p>
          <div class="flex-1 border-t border-zinc-400"></div>
        </div>

        {{-- Tombol Google --}}
        <button 
          type="button" 
          class="bg-white cursor-pointer text-zinc-800 font-medium w-full p-3 mt-6 rounded-md border border-zinc-400 hover:bg-zinc-100 transition flex items-center justify-center gap-3">
          <i class="fa-brands fa-google"></i>
          Google
        </button>

        {{-- Link Daftar --}}
        <p class="text-center text-sm mt-8 text-zinc-600">
          Belum punya akun?
          <a href="/register" class="text-[#FDBA38] font-semibold hover:underline">Daftar</a>
        </p>
      </form>
    </div>

  </div>
</body>
</html>