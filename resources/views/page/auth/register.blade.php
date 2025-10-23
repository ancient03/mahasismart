<x-layout.layout-clear>
   <div class="flex flex-col md:flex-row items-center justify-between gap-10 md:gap-20 w=full max-w-6xl">
    <!-- Logo -->
    <div class="hidden md:flex flex-col md:flex-row items-center justify-center md:justify-start gap-4 text-center md:text-left">
     <img src="{{ asset('img/kuning-nobg.png') }}" alt="Logo" class="bg-transparent object-contain w-48 h-48">    
     <p class="text-4xl md:text-5xl text-[#FDBA38] font-semibold">MahasisMart</p>
    </div>

    <!-- Register Form -->
    <div class="lg:bg-white bg-[#2E8BFD] rounded-xl w-full sm:w-[420px] p-6 sm:p-8">
                   <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
                    
                    <p class="mb-6 text-center text-2xl font-semibold text-zinc-950 md:text-3xl">Register</p>

                    @if ($errors->any())
                        <div class="rounded-md bg-red-50 p-4">
                            <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- INPUT YANG DIBUTUHKAN OLEH CONTROLLER --}}
                    
                    <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required
                        class="w-full rounded-md border border-zinc-500 bg-white p-3 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#FDBA38]">

                    <input type="email" name="email" placeholder="Alamat email" value="{{ old('email') }}" required
                        class="w-full rounded-md border border-zinc-500 bg-white p-3 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#FDBA38]">

                    <input type="text" name="no_hp" placeholder="No. Handphone (Opsional)" value="{{ old('no_hp') }}"
                        class="w-full rounded-md border border-zinc-500 bg-white p-3 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#FDBA38]">

                    <input type="password" name="password" placeholder="Password" required
                        class="w-full rounded-md border border-zinc-500 bg-white p-3 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#FDBA38]">

                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required
                        class="w-full rounded-md border border-zinc-500 bg-white p-3 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#FDBA38]">

                    
                    {{-- SISA DESAIN ANDA --}}

                    <button type="submit"
                        class="w-full cursor-pointer rounded-md bg-[#FDBA38] p-3 font-semibold text-zinc-950 transition hover:bg-[#e0a733]">
                        Register
                    </button>

                    <div class="flex items-center justify-center gap-4 pt-4">
                        <div class="flex-1 border-t border-zinc-400"></div>
                        <p class="text-sm font-medium text-zinc-500">Atau</p>
                        <div class="flex-1 border-t border-zinc-400"></div>
                    </div>

                    <button type="button"
                        class="flex w-full cursor-pointer items-center justify-center gap-3 rounded-md border border-zinc-400 bg-white p-3 font-medium text-zinc-800 transition hover:bg-zinc-100">
                        <i class="fa-brands fa-google"></i>
                        Google
                    </button>

                    <p class="pt-4 text-center text-sm text-zinc-600">
                        Sudah Punya Akun?
                        <a href="login" class="font-semibold text-[#FDBA38] hover:underline">Login</a>
                    </p>

                </form>
    </div>
   </div>
</x-layout.layout-clear>