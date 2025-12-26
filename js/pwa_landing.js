window.Latingles = typeof window.Latingles === 'undefined' ? {} : window.Latingles;
window.Latingles.PWA = typeof window.Latingles.PWA === 'undefined' ? {} : window.Latingles.PWA;

window.Latingles.PWA.startEnviroment = () => {
	if ('serviceWorker' in navigator) {
		navigator.serviceWorker.register('/sw.js')
		.then(reg => console.log('SW: Registered. Scope: ', reg.scope))
		.catch(err => console.warn('SW: Error while registering. Error: ', err))
	}
	window.Latingles.PWA.controller();
};
window.Latingles.PWA.controller = () => {
	let deferredPrompt;
	let installMsg = document.body.querySelector('#pwa-message');
	let installBtn = document.body.querySelector('#pwa-install');
	const userAgent = window.navigator.userAgent.toLowerCase();
	const ios = /iphone|ipod|ipad/.test(userAgent);
	const safari = /safari/.test(userAgent);
	if (ios) {
		if (safari) {
			installMsg.innerHTML = 'To install our web application tap <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 640 640"><path fill="currentColor" d="M128 320c0-35.2 28.8-64 64-64h256c35.2 0 64 28.8 64 64v256c0 35.2-28.8 64-64 64h-256c-35.2 0-64-28.8-64-64v-256zM192 320v256h256v-256h-64v-64h-128v64h-64zM288 122.56v389.44h64v-389.44l98.24 98.24 45.44-45.12-175.68-175.68-176 176 45.44 44.8 98.56-97.92z"></path></svg> and select <b>Add to Home Screen</b>.';
			installBtn.remove();
		} else {
			installMsg.innerHTML = 'iOS only supports web applications in the Safari browser.';
			installBtn.remove();
		}
	} else {
		installMsg.innerHTML = 'Latingles can be installed as a web application, if you install it you will get a better user experience.';
	}
	if ((window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true)) {
		installMsg.innerHTML = 'The application is already installed.';
	}
	if (installBtn) {
		window.addEventListener('beforeinstallprompt', (e) => {
			deferredPrompt = e;
			installBtn.style.display = 'initial';
		});
		installBtn.addEventListener('click', async () => {
			if (deferredPrompt !== null && deferredPrompt !== 'undefined') {
				deferredPrompt.prompt();
				const { outcome } = await deferredPrompt.userChoice;
				if (outcome === 'accepted') {
					deferredPrompt = null;
					installMsg.innerHTML = 'application successfully installed.';
					installBtn.remove();
				}
			}
		});
		setTimeout(()=>{
			if(deferredPrompt == null || deferredPrompt == 'undefined') {
				installMsg.innerHTML = 'The application is already installed.';
			}
		}, 2000);
	}
};
(function () {
	window.Latingles.PWA.startEnviroment();
})();