<x-layout.layout-clear>
  <div class="flex min-h-screen items-center justify-center px-4 py-12">
    
    <div class="flex flex-col md:flex-row items-center justify-between gap-10 md:gap-20 w-full max-w-6xl">

      {{-- Logo --}}
      <div class="hidden md:flex flex-col md:flex-row items-center justify-center md:justify-start gap-4 text-center md:text-left">
        <img src="{{ asset('img/kuning-nobg.png') }}" alt="Logo" class="object-contain w-32 h-32 md:w-48 md:h-48">
        <p class="text-4xl md:text-5xl text-[#FDBA38] font-semibold">MahasisMart</p>
      </div>

      {{-- Login Form --}}
      <div class="lg:bg-white rounded-xl w-full sm:w-[420px] p-6 sm:p-8 shadow-lg">
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
          @csrf

          <p class="text-2xl md:text-3xl font-semibold text-center mb-6 text-zinc-950">Login</p>

          @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
          <strong class="font-bold">Peringatan!</strong>
          <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif
          {{-- Error Validasi Form (Misal: field kosong) - Tetap ditampilkan inline agar user tahu field mana yang salah --}}
          @if ($errors->any())
            <div class="rounded-md bg-red-50 p-4 border border-red-200">
              <ul class="list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          {{-- Username / Email / HP --}}
          <input 
            type="text" 
            name="login"
            placeholder="No. Handphone / Username / Email"
            value="{{ old('login') }}"
            required 
            autofocus
            class="w-full border border-zinc-500 bg-white p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#FDBA38]">

          {{-- Password --}}
          <div class="relative">
            <input 
              type="password"
              id="loginPassword"
              name="password"
              placeholder="Password"
              required
              class="w-full border border-zinc-500 bg-white p-3 pr-10 rounded-md focus:outline-none focus:ring-2 focus:ring-[#FDBA38]">
            <button 
              type="button" 
              id="toggleLoginPassword"
              class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-gray-500 hover:text-gray-700">
              <i id="toggleLoginPasswordIcon" class="bi bi-eye-slash"></i>
            </button>
          </div>

          {{-- Remember Me & Forgot --}}
          <div class="flex items-center justify-between mt-3 mb-4">
            <label for="remember" class="flex items-center cursor-pointer">
              <input id="remember" type="checkbox" name="remember" class="rounded border-gray-300 text-[#FDBA38] shadow-sm focus:ring-[#FDBA38]">
              <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
            </label>
            <a href="#" class="text-sm text-zinc-600 hover:underline hover:text-red-500">Lupa Password</a>
          </div>

          {{-- Button --}}
          <button 
            type="submit" 
            class="bg-[#FDBA38] text-zinc-950 cursor-pointer font-semibold w-full p-3 rounded-md hover:bg-[#e0a733] transition shadow-md">
            Login
          </button>

          {{-- Divider --}}
          <div class="flex items-center justify-center gap-4 mt-6">
            <div class="flex-1 border-t border-zinc-300"></div>
            <p class="text-sm text-zinc-500 font-medium">Atau</p>
            <div class="flex-1 border-t border-zinc-300"></div>
          </div>

          {{-- Google --}}
          <button 
            type="button" 
            class="bg-white cursor-pointer text-zinc-800 font-medium w-full p-3 rounded-md border border-zinc-400 hover:bg-zinc-50 transition flex items-center justify-center gap-3 shadow-sm">
            <i class="bi bi-google"></i> Google
          </button>

          {{-- Register Link --}}
          <p class="text-center text-sm mt-8 text-zinc-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-[#FDBA38] font-bold hover:underline">Daftar</a>
          </p>
        </form>
      </div>

    </div>
    
    {{-- JS Toggle Password --}}
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('toggleLoginPassword');
        const input = document.getElementById('loginPassword');
        const icon = document.getElementById('toggleLoginPasswordIcon');
        
        if (toggle) {
          toggle.addEventListener('click', function() {
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
          });
        }
      });
    </script>

    {{-- Pastikan Alpine.js dimuat (jika belum ada di layout-clear) --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  </div>
</x-layout.layout-clear>