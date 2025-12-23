import './bootstrap';

window.notificationDropdown = function () {
    return {
        isOpen: false,
        unreadCount: 0,
        notifications: [],
        toggle() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.fetchNotifications();
            }
        },
        fetchNotifications() {
            fetch('/notifications', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
                .then(response => response.json())
                .then(data => {
                    this.notifications = data.notifications.map(n => {
                        n.created_at_human = this.timeAgo(new Date(n.created_at));
                        return n;
                    });
                    this.unreadCount = data.count;
                })
                .catch(error => console.error('Error fetching notifications:', error));
        },
        timeAgo(date) {
            const seconds = Math.floor((new Date() - date) / 1000);
            let interval = seconds / 31536000;
            if (interval > 1) return Math.floor(interval) + " tahun lalu";
            interval = seconds / 2592000;
            if (interval > 1) return Math.floor(interval) + " bulan lalu";
            interval = seconds / 86400;
            if (interval > 1) return Math.floor(interval) + " hari lalu";
            interval = seconds / 3600;
            if (interval > 1) return Math.floor(interval) + " jam lalu";
            interval = seconds / 60;
            if (interval > 1) return Math.floor(interval) + " menit lalu";
            return Math.floor(seconds) + " detik lalu";
        },
        init() {
            this.fetchNotifications();
            setInterval(() => {
                this.fetchNotifications();
            }, 60000); // Refresh every 60 seconds
        }
    };
};
