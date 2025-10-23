<x-layout.layout-clear>
  <div class="flex flex-col md:flex-row items-center justify-between gap-10 md:gap-20 w-full max-w-6xl">

    {{-- Logo Section --}}
    <div class="hidden md:flex flex-col md:flex-row items-center justify-center md:justify-start gap-4 text-center md:text-left">
      <img src="{{ asset('img/kuning-nobg.png') }}" alt="Logo" class="object-contain w-32 h-32 md:w-48 md:h-48">
      <p class="text-4xl md:text-5xl text-[#FDBA38] font-semibold">MahasisMart</p>
    </div>

    {{-- Login Form --}}
    <div class="lg:bg-white bg-[#2E8BFD] rounded-xl w-full sm:w-[90%] md:w-[420px] lg:w-[450px] p-6 sm:p-8">
                {{-- PERBAIKAN: Form tag harus punya method & action --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf {{-- Wajib ada --}}

                    <p class="text-2xl md:text-3xl font-semibold mb-6 text-zinc-950 text-center">Login</p>

                    <!-- Menampilkan Error Validasi (PENTING) -->
                    @if ($errors->any())
                        <div class="rounded-md bg-red-50 p-4 mb-4">
                            <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Input Username/Email/HP (PERBAIKAN: name="login") --}}
                    <input 
                        type="text" 
                        name="login" {{-- Ini akan dikirim ke controller --}}
                        placeholder="No. Handphone / Username / Email"
                        value="{{ old('login') }}"
                        required autofocus
                        class="w-full border border-zinc-500 bg-white p-3 rounded-md mb-4 focus:outline-none focus:ring-2 focus:ring-[#FDBA38]">

                    {{-- Input Password (PERBAIKAN: name="password") --}}
                    <input 
                        type="password"
                        name="password" {{-- Ini akan dikirim ke controller --}}
                        placeholder="Password"
                        required
                        class="w-full border border-zinc-500 bg-white p-3 rounded-md mb-3 focus:outline-none focus:ring-2 focus:ring-[#FDBA38]">

                    <!-- Remember Me & Lupa Password -->
                    <div class="flex items-center justify-between mt-3 mb-4">
                        <label for="remember" class="flex items-center">
                            <input id="remember" type="checkbox" name="remember" class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500">
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>
                        
                        <a href="#" class="text-sm text-zinc-600 hover:underline hover:text-red-500">
                            Lupa Password
                        </a>
                    </div>


                    {{-- Tombol Login --}}
                    <button 
                        type="submit" 
                        class="bg-[#FDBA38] text-zinc-950 cursor-pointer font-semibold w-full p-3 rounded-md hover:bg-[#e0a733] transition">
                        Login
                    </button>

                    {{-- Garis pemisah "Atau" --}}
                    <div class="flex items-center justify-center gap-4 mt-6">
                        <div class="flex-1 border-t border-zinc-400"></div>
                        <p class="text-sm text-zinc-500 font-medium">Atau</p>
                        <div class="flex-1 border-t border-zinc-400"></div>
                    </div>

                    {{-- Tombol Google --}}
                    <button 
                        type="button" 
                        class="bg-white cursor-pointer text-zinc-800 font-medium w-full p-3 mt-6 rounded-md border border-zinc-400 hover:bg-zinc-100 transition flex items-center justify-center gap-3">
                        <i class="fa-brands fa-google"></i>
                        Google
                    </button>

                    {{-- Link Daftar (PERBAIKAN: href="{{ route('register') }}") --}}
                    <p class="text-center text-sm mt-8 text-zinc-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-[#FDBA38] font-semibold hover:underline">Daftar</a>
                    </p>
                </form>
    </div>

  </div>
</x-layout.layout-clear>