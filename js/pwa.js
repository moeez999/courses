window.Latingles = typeof window.Latingles === 'undefined' ? {} : window.Latingles;
window.Latingles.PWA = typeof window.Latingles.PWA === 'undefined' ? {} : window.Latingles.PWA;

window.Latingles.PWA.startEnviroment = () => {
    // 🚫 PWA temporarily deactivated
    console.log('PWA temporarily deactivated');
    return;
    // The original activation code (kept here for easy reactivation)
    /*
	if ('serviceWorker' in navigator) {
		navigator.serviceWorker.register('/sw.js')
		.then(reg => console.log('SW: Registered. Scope: ', reg.scope))
		.catch(err => console.warn('SW: Error while registering. Error: ', err))
	}
	window.Latingles.PWA.controller();
	 */
};
window.Latingles.PWA.controller = () => {
	let deferredPrompt;
	let html;
	let customPWABanner = document.getElementById('pwa-banner');
	if (!customPWABanner) {
		html =  `
		<div class="pwa pwa-install-banner-wrapper" id="pwa-banner">
		<div class="pwa pwa-install-banner">
		<span id="pwa-dismiss">X</span>
		<img src="/img/pwa/logo.png"/>
		<h4 class="pwa-label text-dark">Latingles</h4>
		<button class="pwa-btn" id="pwa-install">Install</button>
		</div>
		</div>
		`;
	}
	html += `
	<div id="pwa-popup" class="overlay">
	<span class="popup-close" title="Back" onclick="window.Latingles.PWA.linkHandler(event);"></span>
	<div class="popup small-popup">
	<span class="small-close" title="Back" id="pwa-dismiss-popup"></span>
	<div class="popup-header">
	<img width="45px" height="45px" src="/img/pwa/logo.png"/>
	<h4>Latingles</h4>
	</div>
	<div class="popup-body">
	<p id="pwa-message"></p>
	<button class="pwa-btn" id="pwa-install-popup">Install</button>
	</div>
	</div>
	</div>`;
	let pwaHTML = document.createElement('div');
	pwaHTML.classList.add('pwa');
	pwaHTML.innerHTML = html;
	document.body.appendChild(pwaHTML);
	let installIndicator = document.body.querySelector('#pwa-btn');
	let installBanner = document.body.querySelector('#pwa-banner');
	let installPopup = document.body.querySelector('#pwa-popup');
	let installMsg = document.body.querySelector('#pwa-message');
	let installBtn = document.body.querySelector('#pwa-install');
	let dismissBtn = document.body.querySelector('#pwa-dismiss');
	let installPopupBtn = document.body.querySelector('#pwa-install-popup');
	let dismissPopupBtn = document.body.querySelector('#pwa-dismiss-popup');

	const userAgent = window.navigator.userAgent.toLowerCase();
	const ios = /iphone|ipod|ipad/.test(userAgent);
	const android = /android/.test(userAgent);
	const safari = /safari/.test(userAgent);
	const opera = /opr|opera/.test(userAgent);
	if (ios) {
		if (installIndicator) {
			installIndicator.style.display = 'block';
		}
		installPopup.style.display = 'block';
		const hideInstallButton = () => {
			if ((window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) && installIndicator) {
				installIndicator.style.display = 'none';
				clearInterval(intervaliOS);
			}
		};
		hideInstallButton();
		let intervaliOS = setInterval(hideInstallButton, 2000);
		if (safari) {
			installMsg.innerHTML = `
			Latingles can be installed as a web application, if you install it you will get a better user experience.
			<p>1. Tap
			<svg height="20px" style="vertical-align: sub;" viewBox="0 0 16 21" fill="none" xmlns="http://www.w3.org/2000/svg" class="ios-installation-popup__icon"><path d="M7.86 13.562c.381 0 .709-.32.709-.692v-9.1l-.053-1.33.593.63 1.347 1.435a.633.633 0 00.479.213c.363 0 .647-.266.647-.63 0-.185-.08-.327-.213-.46L8.374.74C8.197.562 8.046.5 7.86.5c-.177 0-.328.062-.514.24L4.351 3.627a.618.618 0 00-.204.46c0 .364.266.63.638.63.168 0 .363-.07.487-.213L6.611 3.07l.602-.63-.053 1.33v9.1c0 .373.319.692.7.692zM2.782 20.5h10.164c1.852 0 2.783-.922 2.783-2.747V8.909c0-1.825-.93-2.747-2.783-2.747h-2.472V7.59h2.446c.877 0 1.382.479 1.382 1.4v8.684c0 .922-.505 1.4-1.382 1.4H2.8c-.886 0-1.373-.478-1.373-1.4V8.99c0-.921.487-1.4 1.373-1.4h2.455V6.162H2.782C.93 6.162 0 7.084 0 8.91v8.844C0 19.578.93 20.5 2.782 20.5z" fill="#007AFF"></path></svg>
			</p>
			<img class="img-fluid" src="/img/src/share-iphone.png"></img>
			<p>2. Select <b>Add to Home Screen</b>.</p>
			<img class="img-fluid" src="/img/src/add-home-screen-iphone.png"></img>
			`;
			installPopupBtn.remove();
		} else {
			installMsg.innerHTML = 'iOS only supports web applications in the Safari browser.';
			installPopupBtn.remove();
		}
		if (!window.navigator.standalone && !window.matchMedia('(display-mode: standalone)').matches) {
			if (localStorage.getItem("disablePWAPrompt") === null) {
				window.Latingles.PWA.linkHandler(new Event('click'), 'show');
			}
		}
	} else {
		installMsg.innerHTML = 'Latingles can be installed as a web application, if you install it you will get a better user experience.';
	}
	if (installIndicator) {
		installIndicator.onclick = (event) => {
			window.Latingles.PWA.linkHandler(event, 'show');
		};
	}
	dismissBtn.onclick = (event) => {
		window.Latingles.PWA.linkHandler(event, 'dismiss');
	};
	dismissPopupBtn.onclick = (event) => {
		window.Latingles.PWA.linkHandler(event, 'dismiss');
	};
	if (installBtn) {
		window.addEventListener('beforeinstallprompt', (e) => {
			if (!opera) {
				deferredPrompt = e;
				if (installIndicator) {
					installIndicator.style.display = 'block';
				}
				if (localStorage.getItem("disablePWAPrompt") === null) {
					installBanner.style.display = 'flex';
					window.Latingles.PWA.linkHandler(new Event('click'), 'show');
				}
				installPopup.style.display = 'block';
				installBtn.style.display = 'initial';
				installPopupBtn.style.display = 'initial';
			}
		});


		async function handleInstallButtonClick() {
			if (deferredPrompt !== null && typeof deferredPrompt !== 'undefined') {
				deferredPrompt.prompt();
				const { outcome } = await deferredPrompt.userChoice;
				if (outcome === 'accepted') {
					deferredPrompt = null;
					installMsg.innerHTML = 'application successfully installed.';
					if (installIndicator) {
						installIndicator.style.display = 'none';
					}
					installBanner.style.display = 'none';
					installBtn.remove();
					installPopupBtn.remove();
				}
			}
		}
		installBtn.addEventListener('click', handleInstallButtonClick);
		installPopupBtn.addEventListener('click', handleInstallButtonClick);
	}
};
window.Latingles.PWA.linkHandler = (e, linkAction) => {
	e.preventDefault();
	e.stopImmediatePropagation();
	let banner = document.getElementById('pwa-banner');
	let popup = document.getElementById('pwa-popup');
	if (linkAction == 'show') {
		popup.classList.add('popup-show');
	} else if (linkAction == 'dismiss') {
		banner.style.display = 'none';
		popup.classList.remove('popup-show');
		localStorage.setItem("disablePWAPrompt", true);
	} else {
		popup.classList.remove('popup-show');
	}
};
(function () {
	window.Latingles.PWA.startEnviroment();
})();