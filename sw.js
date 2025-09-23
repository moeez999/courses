let CACHE_VERSION = `1`;
let CACHE_NAME = `Latingles-pwa-v-${CACHE_VERSION}`;
let urlsToCache = [
    `/offline.html?v=${CACHE_VERSION}`,
    `/css/pwa.css?v=${CACHE_VERSION}`,
    `/js/pwa.js?v=${CACHE_VERSION}`,
    `/manifest.json?v=${CACHE_VERSION}`,
    `/img/pwa/192.png?v=${CACHE_VERSION}`,
    `/img/pwa/512.png?v=${CACHE_VERSION}`,
    `/img/pwa/maskable_icon.png?v=${CACHE_VERSION}`
    ];
self.addEventListener('install', function(event) {
    self.skipWaiting();
    event.waitUntil(
        caches.open(CACHE_NAME)
        .then(function(cache) {
            return cache.addAll(urlsToCache, {cache: 'reload'});
        })
        );
});
self.addEventListener('activate', event => {
    let cacheKeeplist = [CACHE_NAME];
    self.clients.claim();
    event.waitUntil(
        caches.keys().then((keyList) => {
            return Promise.all(keyList.map((key) => {
                if (cacheKeeplist.indexOf(key) === -1) {
                    console.log('SW: Updated.');
                    return caches.delete(key);
                }
            }));
        })

        );
});
self.addEventListener('fetch', (event) => {
 if (event.request.mode === 'navigate' && event.request.method != 'POST' && !event.request.url.includes('/wp-admin/') && !event.request.url.includes(':2083')) {
   event.respondWith(
    (async () => {
        try {
            const networkResponse = await fetch(event.request);
            return networkResponse;
        } catch (error) {
            const fallbackResponse = await caches.match(`/offline.html?v=${CACHE_VERSION}`);
            if (fallbackResponse) {
                return fallbackResponse;
            }
        }
    })()
    );
}
});