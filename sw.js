// Service Worker for 100% Offline & Online Food Court POS
const CACHE_NAME = 'foodcourt-pos-v6';
const ASSETS_TO_CACHE = [
  './',
  './index.html',
  './favicon.svg',
  './manifest.json',
  'https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js',
  'https://cdn.tailwindcss.com'
];

// Install: Cache core assets for offline usage
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      console.log('[Service Worker] Pre-caching offline assets');
      return cache.addAll(ASSETS_TO_CACHE).catch((err) => {
        console.warn('[Service Worker] Partial cache failure, will fetch on demand:', err);
      });
    }).then(() => self.skipWaiting())
  );
});

// Activate: Clean old caches
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keyList) => {
      return Promise.all(
        keyList.map((key) => {
          if (key !== CACHE_NAME) {
            console.log('[Service Worker] Removing old cache:', key);
            return caches.delete(key);
          }
        })
      );
    }).then(() => self.clients.claim())
  );
});

// Fetch: Stale-While-Revalidate Strategy (Works 100% Offline + Updates when Online)
self.addEventListener('fetch', (event) => {
  // Only handle GET requests and skip APK files
  if (event.request.method !== 'GET' || event.request.url.endsWith('.apk')) return;

  event.respondWith(
    caches.match(event.request).then((cachedResponse) => {
      const fetchPromise = fetch(event.request).then((networkResponse) => {
        if (networkResponse && networkResponse.status === 200) {
          const responseToCache = networkResponse.clone();
          caches.open(CACHE_NAME).then((cache) => {
            cache.put(event.request, responseToCache);
          });
        }
        return networkResponse;
      }).catch(() => {
        // Network failed (device is offline), return cachedResponse
        return cachedResponse;
      });

      return cachedResponse || fetchPromise;
    })
  );
});
