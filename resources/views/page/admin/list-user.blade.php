<x-layout.layout-admin>
    <section class="md:col-span-3">
        
        {{-- Header --}}
        <div class="py-3 px-5 lg:rounded-md shadow-md bg-white mb-10 flex justify-between items-center">
            <h1 class="lg:text-2xl text-1xl font-semibold">Daftar User</h1>
            
            {{-- Notifikasi Sukses/Error --}}
            <div class="flex flex-col items-end gap-1">
                @if (session('status'))
                    <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-bold">{{ session('status') }}</span>
                @endif
                @if (session('error'))
                    <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-bold">{{ session('error') }}</span>
                @endif
            </div>
        </div>

        {{-- LOOP DATA USER --}}
        @forelse ($userList as $user)
            <div class="py-3 px-5 mb-4 flex flex-col md:flex-row md:items-center justify-between rounded-md shadow-md bg-white border-l-4 
                {{-- Warna border kiri berdasarkan status --}}
                {{ $user->status_user == 'banned' ? 'border-red-600 bg-red-50' : 'border-green-500' }}">
                
                <div class="flex gap-4 items-center mb-4 md:mb-0">
                    {{-- Foto Profil --}}
                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center border border-gray-300 overflow-hidden shrink-0">
                         @if ($user->foto_profil)
                            <img src="{{ asset('img/fotoprofile/' . $user->foto_profil) }}" class="w-full h-full object-cover">
                        @else
                            <i class="bi bi-person-fill text-4xl text-gray-400"></i>
                        @endif
                    </div>

                    {{-- Info User --}}
                    <div>
                        <div class="flex items-center gap-2">
                            <p class="font-semibold text-xl">{{ $user->username }}</p>
                            
                            {{-- Badge Role --}}
                            @if($user->role == 'admin')
                                <span class="bg-purple-100 text-purple-800 text-[10px] font-bold px-2 py-0.5 rounded border border-purple-200">ADMIN</span>
                            @else
                                <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2 py-0.5 rounded border border-gray-200">USER</span>
                            @endif
                        </div>

                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        
                        {{-- Status Badge --}}
                        <div class="mt-1">
                            @if ($user->status_user == 'aktif')
                                <span class="px-2 py-0.5 rounded text-xs font-bold bg-green-200 text-green-800">Aktif</span>
                            @elseif ($user->status_user == 'banned')
                                <span class="px-2 py-0.5 rounded text-xs font-bold bg-red-200 text-red-800">Banned</span>
                            @endif
                        </div>
                        
                        {{-- Alasan Banned (jika ada) --}}
                        @if($user->catatan_admin)
                            <p class="text-xs text-red-600 mt-1 italic">Note: {{ $user->catatan_admin }}</p>
                        @endif
                    </div>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="flex flex-col items-end gap-2">
                    
                    <div class="flex items-center gap-2">
                        {{-- ========================================== --}}
                        {{-- 1. Tombol BANNED (Merah) - Muncul jika user AKTIF --}}
                        {{-- ========================================== --}}
                        @if ($user->status_user == 'aktif')
                            {{-- Jangan tampilkan tombol Banned untuk diri sendiri --}}
                            @if(Auth::id() !== $user->id_user)
                                <form action="{{ route('admin.user.update-status', $user->id_user) }}" method="POST" onsubmit="return confirm('Yakin ingin mem-banned user ini?');">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status_user" value="banned">
                                    <input type="hidden" name="catatan_admin" value="Melanggar ketentuan komunitas"> {{-- Default reason --}}
                                    <button type="submit" title="Banned User"
                                        class="bg-[#CA4343] w-10 h-10 rounded-md shadow-md hover:bg-[#8b0000] transition duration-300 text-white flex items-center justify-center">
                                        <i class="bi bi-ban text-lg"></i>
                                    </button>
                                </form>
                            @endif
                        @endif

                        {{-- ========================================== --}}
                        {{-- 2. Tombol PULIHKAN (Hijau) - Muncul jika user BANNED --}}
                        {{-- ========================================== --}}
                        @if ($user->status_user == 'banned')
                            <form action="{{ route('admin.user.update-status', $user->id_user) }}" method="POST" onsubmit="return confirm('Pulihkan akses user ini?');">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status_user" value="aktif">
                                <input type="hidden" name="catatan_admin" value=""> 
                                <button type="submit" title="Pulihkan User"
                                    class="bg-[#61BE4A] w-10 h-10 rounded-md shadow-md hover:bg-[#21a700] transition duration-300 text-white flex items-center justify-center">
                                    <i class="bi bi-check-circle text-lg"></i>
                                </button>
                            </form>
                        @endif

                        {{-- ========================================== --}}
                        {{-- 3. Tombol UBAH ROLE (Ungu/Abu)           --}}
                        {{-- ========================================== --}}
                        @if(Auth::id() !== $user->id_user) {{-- Tidak bisa ubah role diri sendiri --}}
                            @if($user->role == 'user')
                                <form action="{{ route('admin.user.update-status', $user->id_user) }}" method="POST" onsubmit="return confirm('Jadikan user ini ADMIN?');">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="role" value="admin">
                                    <button type="submit" title="Jadikan Admin"
                                        class="bg-purple-600 w-10 h-10 rounded-md shadow-md hover:bg-purple-800 transition duration-300 text-white flex items-center justify-center">
                                        <i class="bi bi-shield-lock text-lg"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.user.update-status', $user->id_user) }}" method="POST" onsubmit="return confirm('Turunkan user ini jadi User Biasa?');">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="role" value="user">
                                    <button type="submit" title="Jadikan User Biasa"
                                        class="bg-gray-500 w-10 h-10 rounded-md shadow-md hover:bg-gray-700 transition duration-300 text-white flex items-center justify-center">
                                        <i class="bi bi-person text-lg"></i>
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>

                </div>
            </div>
        @empty
            <div class="text-center py-10 text-gray-500">Belum ada user terdaftar.</div>
        @endforelse

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $userList->links() }}
        </div>

    </section>
</x-layout.layout-admin>