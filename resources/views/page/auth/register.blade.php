<x-layout.layout-clear>
  <div class="flex flex-col md:flex-row items-center justify-between gap-10 md:gap-20 w-full max-w-6xl">

    {{-- Logo --}}
    <div class="hidden md:flex flex-col md:flex-row items-center justify-center md:justify-start gap-4 text-center md:text-left">
      <img src="{{ asset('img/kuning-nobg.png') }}" alt="Logo" class="object-contain w-32 h-32 md:w-48 md:h-48">
      <p class="text-4xl md:text-5xl text-[#FDBA38] font-semibold">MahasisMart</p>
    </div>

    {{-- Register Form --}}
    <div class="lg:bg-white rounded-xl w-full sm:w-[420px] p-6 sm:p-8">
      <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <p class="text-2xl md:text-3xl font-semibold text-center mb-6 lg:text-zinc-950 text-white">Register</p>

        {{-- Error Message --}}
        @if ($errors->any())
          <div class="rounded-md bg-red-50 p-4">
            <ul class="list-disc list-inside text-sm text-red-600">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        {{-- Username --}}
        <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required
          class="w-full border border-zinc-500 bg-white p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#FDBA38]">

        {{-- Email --}}
        <input type="email" name="email" placeholder="Alamat Email" value="{{ old('email') }}" required
          class="w-full border border-zinc-500 bg-white p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#FDBA38]">

        {{-- No HP --}}
        <input type="text" name="no_hp" placeholder="No. Handphone (Opsional)" value="{{ old('no_hp') }}"
          class="w-full border border-zinc-500 bg-white p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#FDBA38]">

        {{-- Password --}}
        <div class="relative">
          <input type="password" id="registerPassword" name="password" placeholder="Password" required
            class="w-full border border-zinc-500 bg-white p-3 pr-10 rounded-md focus:outline-none focus:ring-2 focus:ring-[#FDBA38]">
          <button type="button" id="toggleRegisterPassword"
            class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
            <i id="toggleRegisterPasswordIcon" class="bi bi-eye-slash text-gray-500 hover:text-gray-700"></i>
          </button>
        </div>

        {{-- Confirm Password --}}
        <div class="relative">
          <input type="password" id="registerPasswordConfirm" name="password_confirmation" placeholder="Konfirmasi Password" required
            class="w-full border border-zinc-500 bg-white p-3 pr-10 rounded-md focus:outline-none focus:ring-2 focus:ring-[#FDBA38]">
          <button type="button" id="toggleRegisterPasswordConfirm"
            class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
            <i id="toggleRegisterPasswordConfirmIcon" class="bi bi-eye-slash text-gray-500 hover:text-gray-700"></i>
          </button>
        </div>

        {{-- Register Button --}}
        <button 
          type="submit"
          class="bg-[#FDBA38] text-zinc-950 cursor-pointer font-semibold w-full p-3 rounded-md hover:bg-[#e0a733] transition">
          Register
        </button>

        {{-- Divider --}}
        <div class="flex items-center justify-center gap-4 mt-6">
          <div class="flex-1 border-t lg:border-zinc-400 border-zinc-200"></div>
          <p class="text-sm lg:text-zinc-500 text-white font-medium">Atau</p>
          <div class="flex-1 border-t lg:border-zinc-400 border-zinc-200"></div>
        </div>

        {{-- Google --}}
        <button 
          type="button"
          class="bg-white cursor-pointer text-zinc-800 font-medium w-full p-3 rounded-md border border-zinc-400 hover:bg-zinc-100 transition flex items-center justify-center gap-3">
          <i class="fa-brands fa-google"></i> Google
        </button>

        {{-- Login Link --}}
        <p class="text-center text-sm mt-8 lg:text-zinc-600 text-white">
          Sudah punya akun?
          <a href="{{ route('login') }}" class="text-[#FDBA38] font-semibold hover:underline">Login</a>
        </p>
      </form>
    </div>

  </div>

  {{-- JS Toggle Password --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const pairs = [
        ['toggleRegisterPassword', 'registerPassword', 'toggleRegisterPasswordIcon'],
        ['toggleRegisterPasswordConfirm', 'registerPasswordConfirm', 'toggleRegisterPasswordConfirmIcon']
      ];
      pairs.forEach(([btnId, inputId, iconId]) => {
        const btn = document.getElementById(btnId);
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (btn) {
          btn.addEventListener('click', () => {
            input.type = input.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
          });
        }
      });
    });
  </script>
</x-layout.layout-clear>
