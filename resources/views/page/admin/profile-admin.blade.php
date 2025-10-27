<x-layout.layout-admin>

  <section class="md:col-span-3">
    <form method="POST" action="#" enctype="multipart/form-data">
      <div class="bg-white text-gray-800 rounded-lg shadow p-6 md:p-8">
        <h1 class="text-2xl font-bold mb-6">Profil Admin</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

          <!-- Bagian Kiri Form -->
          <div class="lg:col-span-2 space-y-4">

            <div>
              <label class="block text-sm font-medium text-gray-700">Username:</label>
              <input type="text" value="Admin MahasisMart"
                class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 bg-gray-50">
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">Email:</label>
              <input type="email" value="admin@mahasismart.com"
                class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 bg-gray-50">
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">Nomor Telepon:</label>
              <input type="text" value="0812-3456-7890"
                class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 bg-gray-50">
            </div>

            <!-- Jenis Kelamin -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Jenis Kelamin:</label>
              <select
                class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 bg-gray-50">
                <option value="laki-laki">Laki-laki</option>
                <option value="perempuan">Perempuan</option>
                <option value="rahasia">Tidak ingin memberi tahu</option>
              </select>
            </div>

            <!-- Ganti Password -->
            <div class="pt-4 border-t border-gray-200">
              <p class="text-sm font-medium text-gray-900">Ubah Password</p>
              <p class="text-sm text-gray-500">Kosongkan jika tidak ingin mengubah.</p>
            </div>

            <!-- Password Baru -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Password Baru:</label>
              <div class="relative mt-1">
                <input type="password" id="password"
                  class="px-4 py-2 pr-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                <button type="button" id="togglePasswordBtn"
                  class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                  <i id="togglePasswordIcon" class="bi bi-eye-slash text-gray-500 hover:text-gray-700"></i>
                </button>
              </div>
            </div>

            <!-- Konfirmasi Password -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru:</label>
              <div class="relative mt-1">
                <input type="password" id="password_confirmation"
                  class="px-4 py-2 pr-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                <button type="button" id="togglePasswordConfirmBtn"
                  class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                  <i id="togglePasswordConfirmIcon" class="bi bi-eye-slash text-gray-500 hover:text-gray-700"></i>
                </button>
              </div>
            </div>

            <!-- Save Changes -->
            <div class="pt-4">
              <button type="submit"
                class="bg-gray-700 text-white py-2 px-5 rounded-lg font-semibold hover:bg-gray-800 transition-colors">
                Save Changes
              </button>
            </div>

          </div>

          <!-- Bagian Kanan Upload Foto -->
          <div class="lg:col-span-1 flex flex-col items-center space-y-4 pt-8 lg:pt-0">
            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>

            <div class="w-40 h-40 bg-gray-200 rounded-full flex items-center justify-center border border-gray-300">
              <i class="bi bi-person-circle text-8xl text-gray-400"></i>
            </div>

            <input type="file" name="foto_profil" accept="image/*"
              class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer">

            <p class="text-xs text-gray-500 text-center">Pilih gambar baru (JPG, PNG, maks 2MB).</p>
          </div>

        </div>
      </div>
    </form>

    <!-- Tombol Logout -->
    <div class="bg-white text-gray-800 rounded-lg shadow p-6 md:p-8 mt-6">
      <div class="flex justify-end border-t border-gray-200 pt-6">
        <a href="#"
          class="bg-red-600 text-white py-2 px-5 rounded-lg font-semibold hover:bg-red-700 transition-colors">
          Logout
        </a>
      </div>
    </div>

  </section>

  <!-- Script Show/Hide Password -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const togglePasswordBtn = document.getElementById('togglePasswordBtn');
      const passwordInput = document.getElementById('password');
      const togglePasswordIcon = document.getElementById('togglePasswordIcon');

      togglePasswordBtn.addEventListener('click', function () {
        if (passwordInput.type === 'password') {
          passwordInput.type = 'text';
          togglePasswordIcon.classList.replace('bi-eye-slash', 'bi-eye');
        } else {
          passwordInput.type = 'password';
          togglePasswordIcon.classList.replace('bi-eye', 'bi-eye-slash');
        }
      });

      const togglePasswordConfirmBtn = document.getElementById('togglePasswordConfirmBtn');
      const passwordConfirmInput = document.getElementById('password_confirmation');
      const togglePasswordConfirmIcon = document.getElementById('togglePasswordConfirmIcon');

      togglePasswordConfirmBtn.addEventListener('click', function () {
        if (passwordConfirmInput.type === 'password') {
          passwordConfirmInput.type = 'text';
          togglePasswordConfirmIcon.classList.replace('bi-eye-slash', 'bi-eye');
        } else {
          passwordConfirmInput.type = 'password';
          togglePasswordConfirmIcon.classList.replace('bi-eye', 'bi-eye-slash');
        }
      });
    });
  </script>

</x-layout.layout-admin>
