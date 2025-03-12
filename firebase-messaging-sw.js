self.addEventListener('push', function(event) {
    var options = {
        body: event.data.text(),
        icon: '/wp-content/uploads/your-icon.png', // Replace with your notification icon
        vibrate: [200, 100, 200],
        data: { url: '/' } // Opens site when clicked
    };

    event.waitUntil(
        self.registration.showNotification('New Forum Activity!', options)
    );
});

self.addEventListener('notificationclick', function(event) {
    event.notification.close();
    event.waitUntil(
        clients.openWindow(event.notification.data.url)
    );
});
