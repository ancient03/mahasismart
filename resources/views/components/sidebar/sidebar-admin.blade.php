<aside class="md:col-span-1">
    <div class="bg-white text-gray-800 lg:rounded-lg shadow-md lg:p-6 p-4">

        {{-- Header Admin --}}
        <div class="flex items-center space-x-4 mb-6">
            <div>
                <span class="font-bold text-lg">Panel Admin</span>
            </div>
        </div>

        {{-- Navigasi Admin --}}
        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}" @class([
                'flex items-center space-x-3 py-2 px-3 rounded-md',
                'bg-green-100 text-green-700 font-semibold' => Route::is('admin.dashboard-admin'),
                'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => !Route::is(
                    'admin.dashboard-admin'),
            ])>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.list-toko') }}" @class([
                'flex items-center space-x-3 py-2 px-3 rounded-md',
                'bg-green-100 text-green-700 font-semibold' => Route::is('admin.list-toko'),
                'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => !Route::is(
                    'admin.list-toko'),
            ])>
                <span>List Toko</span>
            </a>

            <a href="{{ route('admin.list-user') }}" @class([
                'flex items-center space-x-3 py-2 px-3 rounded-md',
                'bg-green-100 text-green-700 font-semibold' => Route::is('admin.list-user'),
                'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => !Route::is(
                    'admin.list-user'),
            ])>
                <span>List User</span>
            </a>

            <a href="{{ route('admin.laporan') }}" @class([
                'flex items-center space-x-3 py-2 px-3 rounded-md',
                'bg-green-100 text-green-700 font-semibold' => Route::is('admin.laporan'),
                'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => !Route::is(
                    'admin.laporan'),
            ])>
                <span>Laporan Masuk</span>
            </a>

            <a href="{{ route('admin.kategori') }}" @class([
                'flex items-center space-x-3 py-2 px-3 rounded-md',
                // aktif kalau di halaman kategori, tambah kategori, atau edit kategori
                'bg-green-100 text-green-700 font-semibold' =>
                    Route::is('admin.kategori') ||
                    Route::is('admin.tambah-kategori') ||
                    Route::is('admin.kategori.edit'),
                'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => !(
                    Route::is('admin.kategori') ||
                    Route::is('admin.tambah-kategori') ||
                    Route::is('admin.kategori.edit')
                ),
            ])>
                <span>Kategori</span>
            </a>

            <a href="{{ route('admin.iklan') }}" @class([
                'flex items-center space-x-3 py-2 px-3 rounded-md',
                // aktif kalau di halaman iklan, tambah iklan, atau edit iklan
                'bg-green-100 text-green-700 font-semibold' =>
                    Route::is('admin.iklan') ||
                    Route::is('admin.tambah-iklan') ||
                    Route::is('admin.edit-iklan'),
                'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => !(
                    Route::is('admin.iklan') ||
                    Route::is('admin.tambah-iklan') ||
                    Route::is('admin.edit-iklan')
                ),
            ])>
                <span>Iklan</span>
            </a>


        </nav>
    </div>
</aside>
