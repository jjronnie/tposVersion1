self.addEventListener('install', function (e) {
  e.waitUntil(
    caches.open('tpos').then(async function (cache) {
      const files = [
        '/',
        '/offline.html',
        'assets/css/main.css',
        '/assets/js/main.js',
        '/favicon.webp',
        '/assets/img/logo.png'
      ];
      for (let file of files) {
        try {
          await cache.add(file);
        } catch (err) {
          console.warn(`Failed to cache ${file}`, err);
        }
      }
    })
  );
});

// Serve from cache first, then network; if offline, show offline.html
self.addEventListener('fetch', function (e) {
  e.respondWith(
    fetch(e.request)
      .catch(() => {
        return caches.match(e.request).then((response) => {
          if (response) {
            return response;
          }
          // Only fallback to offline.html for navigation requests (pages)
          if (e.request.mode === 'navigate') {
            return caches.match('/offline.html');
          }
        });
      })
  );
});
