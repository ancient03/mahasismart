<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#2E8BFD] font-[poppins] flex items-center justify-center min-h-screen px-4">
   <div class="flex flex-col md:flex-row items-center justify-between gap-10 md:gap-20 w=full max-w-6xl">
    <!-- Logo -->
    <div class="hidden md:flex flex-col md:flex-row items-center justify-center md:justify-start gap-4 text-center md:text-left">
     <img src="" alt="Logo" class="bg-transparent object-contain w-48 h-48">    
     <p class="text-4xl md:text-5xl text-[#FDBA38] font-semibold">MahasisMart</p>
    </div>

    <!-- Register Form -->
    <div class="lg:bg-white bg-[#2E8BFD] rounded-xl w-full sm:w-[420px] p-6 sm:p-8">
        <form actions="">
            <p class="text-2xl md:text-3xl font-semibold mb-8 text-zinc-950 text-center">Register</p>

            <!-- Input no. Hp -->
            <input 
            type="text"
            placeholder="No. Handphone"
            class="w-full border border-zinc-500 bg-zinc-200 lg:bg-white p-3 rounded-md mb-4 focus:outline-none focus-ring-2 focus:ring-[#FDBA38]">

            <!-- Tombol register -->
             <button
             type="submit"
             class="bg-[#FDBA38] text-zinc-950 lg:text-zinc-500 cursor-pointer font-semibold w-full p-3 rounded-md hover:bg-[#e0a733] transition">
                Register
            </button>

           <!-- Garis Pemisah "Atau" -->
            <div class="flex items-center justify-center gap-4 mt=10">
            <div class="flex-1 border-t border-zinc-400"></div>
            <p class="text-sm lg:text-zinc-500 text-zinc-950 font-medium">Atau</p>
            <div class="flex-1 border-t border-zinc-400"></div>    
            </div>

            <!-- Tombil google -->
             <button
             type="button"
             class="bg-white cursor-pointer text-zinc-800 font-medium w-full p-3 mt-6 rounded-md border border-zinc-400
            hover:bg-zinc-100 transition flex items-center justify-center gap-3">
             <i class="fa-brands fa-google text-[#FDBA38]"></i>   
             Google
             </button>

             <!-- Punya Akun = Login -->
              <p class="text-center text-sm mt-8 text-zinc-600">
                Sudah Punya Akun? 
                <a href="/login" class="text-[#FDBA38] font-semibold hover:underline">Login</a>
              </p>

        </form>
    </div>
   </div>
</body>
</html>