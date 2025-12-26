<div class="relative" x-data="notificationDropdown()" x-init="init()">
    {{-- Tombol Notifikasi --}}
    <button @click="toggle" class="text-white hover:text-gray-200 relative" aria-label="Lihat Notifikasi">
        <i class="bi bi-bell text-2xl"></i>
        {{-- Badge Jumlah Notifikasi Belum Dibaca --}}
        <template x-if="unreadCount > 0">
            <span x-text="unreadCount > 99 ? '99+' : unreadCount" class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white border-2 border-[#00795E]"></span>
        </template>
    </button>

    {{-- Dropdown Konten --}}
    <div 
        x-show="isOpen" 
        @click.away="isOpen = false"
        x-transition
        class="absolute right-0 z-50 mt-2 w-80 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5"
        style="display: none;"
    >
        {{-- Header Dropdown --}}
        <div class="flex items-center justify-between px-4 py-2 text-sm text-gray-700">
            <span class="font-semibold">Notifikasi (<span x-text="unreadCount"></span>)</span>
            <form id="mark-all-read-form" action="{{ route('notifications.readall') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('mark-all-read-form').submit();" class="text-blue-500 hover:underline">
                Tandai semua dibaca
            </a>
        </div>
        <hr class="border-gray-200">

        {{-- Daftar Item Notifikasi --}}
        <div id="notification-items" class="max-h-80 overflow-y-auto">
            <template x-if="notifications.length === 0">
                <p class="px-4 py-3 text-center text-gray-500">Tidak ada notifikasi.</p>
            </template>
            <template x-for="notification in notifications" :key="notification.id">
                <div 
                    @click="markAndRedirect(notification)"
                    class="block cursor-pointer px-4 py-3 transition-colors duration-200 hover:bg-gray-100"
                    :class="{ 'bg-gray-50 font-bold': !notification.is_read, 'text-gray-600': notification.is_read }"
                >
                    <p class="text-sm" x-text="notification.title"></p>
                    <p class="text-xs font-normal" x-text="notification.message"></p>
                    <p class="text-xs text-gray-400 font-normal" x-text="timeAgo(notification.created_at)"></p>
                </div>
            </template>
        </div>
        <hr class="border-gray-200">
        {{-- Footer Dropdown --}}
        {{-- <a href="#" class="block py-2 font-bold text-center text-gray-700 bg-gray-50 hover:underline">Lihat semua notifikasi</a> --}}
    </div>
</div>

<script>
    function notificationDropdown() {
        return {
            isOpen: false,
            notifications: [],
            unreadCount: 0,
            
            init() {
                this.fetchNotifications();
                // Refresh notifikasi setiap 30 detik
                setInterval(() => {
                    this.fetchNotifications();
                }, 30000);
            },

            toggle() {
                this.isOpen = !this.isOpen;
                if (this.isOpen) {
                    this.fetchNotifications();
                }
            },

            fetchNotifications() {
                fetch('{{ route('notifications.index') }}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    this.notifications = data.notifications;
                    this.unreadCount = data.unread_count;
                })
                .catch(error => console.error('Error fetching notifications:', error));
            },

            markAndRedirect(notification) {
                // Form untuk POST request
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = `/notifications/${notification.id}/read`;
                
                // Tambahkan CSRF token
                let csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                document.body.appendChild(form);

                // Kirim request dan redirect
                form.submit();
                
                // Redirect ke URL notifikasi jika ada
                if(notification.url) {
                    // Beri sedikit jeda agar request POST terkirim
                    setTimeout(() => {
                        window.location.href = notification.url;
                    }, 100);
                }
            },
            
            timeAgo(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const seconds = Math.floor((now - date) / 1000);

                let interval = seconds / 31536000; // tahun
                if (interval > 1) return Math.floor(interval) + " tahun lalu";
                
                interval = seconds / 2592000; // bulan
                if (interval > 1) return Math.floor(interval) + " bulan lalu";

                interval = seconds / 86400; // hari
                if (interval > 1) return Math.floor(interval) + " hari lalu";

                interval = seconds / 3600; // jam
                if (interval > 1) return Math.floor(interval) + " jam lalu";
                
                interval = seconds / 60; // menit
                if (interval > 1) return Math.floor(interval) + " menit lalu";
                
                if (seconds < 10) return "baru saja";

                return Math.floor(seconds) + " detik lalu";
            }
        }
    }
</script>