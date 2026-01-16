/**
 * Centralized Loader/Spinner Utilities
 * 
 * This file contains all loader/spinner functions used across the custom plugin.
 * Import this file in your HTML/PHP files to use these functions.
 * 
 * Usage:
 *   <script src="js/loader_utils.js"></script>
 *   Then use: showGlobalLoader() and hideGlobalLoader()
 */

/**
 * Private state for loader management
 */
(function(global) {
    'use strict';
    
    let _loaderShownAt = 0;
    let _loaderHideTimer = null;
    const MIN_SHOW_MS = 3000; // 3 seconds minimum display time
    
    /**
     * Internal function to set loader display state
     * @param {string} display - 'flex' or 'none'
     * @private
     */
    function _setLoaderDisplay(display) {
        try {
            const el = document.getElementById('loader');
            if (el) {
                el.style.display = display;
                if (display === 'flex') {
                    el.style.zIndex = '99999';
                }
            }
            // Also try jQuery if available
            if (window.$) {
                window.$('#loader').css({
                    'display': display,
                    'z-index': display === 'flex' ? '99999' : 'auto'
                });
            }
        } catch (e) {
            console.warn('_setLoaderDisplay error:', e);
        }
    }
    
    /**
     * Show the global loader
     * Ensures loader is visible for at least MIN_SHOW_MS milliseconds
     * @returns {void}
     */
    function showGlobalLoader() {
        // Cancel any pending hide
        if (_loaderHideTimer) {
            clearTimeout(_loaderHideTimer);
            _loaderHideTimer = null;
        }
        
        _setLoaderDisplay('flex');
        _loaderShownAt = Date.now();
        console.log('Loader shown at:', _loaderShownAt);
    }
    
    /**
     * Hide the global loader
     * Respects minimum display time (MIN_SHOW_MS)
     * @returns {void}
     */
    function hideGlobalLoader() {
        const elapsed = _loaderShownAt
            ? Date.now() - _loaderShownAt
            : MIN_SHOW_MS;
        
        function doHide() {
            _setLoaderDisplay('none');
            _loaderShownAt = 0;
            _loaderHideTimer = null;
            console.log('Loader hidden');
        }
        
        if (elapsed >= MIN_SHOW_MS) {
            doHide();
        } else {
            _loaderHideTimer = setTimeout(doHide, MIN_SHOW_MS - elapsed);
        }
    }
    
    /**
     * Force hide the loader immediately (bypasses minimum time)
     * Use with caution - only when absolutely necessary
     * @returns {void}
     */
    function forceHideGlobalLoader() {
        if (_loaderHideTimer) {
            clearTimeout(_loaderHideTimer);
            _loaderHideTimer = null;
        }
        _setLoaderDisplay('none');
        _loaderShownAt = 0;
        console.log('Loader force hidden');
    }
    
    /**
     * Check if loader is currently visible
     * @returns {boolean} - True if loader is visible
     */
    function isLoaderVisible() {
        try {
            const el = document.getElementById('loader');
            if (el) {
                const style = window.getComputedStyle(el);
                return style.display === 'flex' || style.display === 'block';
            }
            return false;
        } catch (e) {
            return false;
        }
    }
    
    // Export functions to global scope
    if (typeof global !== 'undefined') {
        global.showGlobalLoader = showGlobalLoader;
        global.hideGlobalLoader = hideGlobalLoader;
        global.forceHideGlobalLoader = forceHideGlobalLoader;
        global.isLoaderVisible = isLoaderVisible;
        
        // Create namespace for better organization
        global.LoaderUtils = {
            show: showGlobalLoader,
            hide: hideGlobalLoader,
            forceHide: forceHideGlobalLoader,
            isVisible: isLoaderVisible,
            MIN_SHOW_MS: MIN_SHOW_MS
        };
    }
    
})(typeof window !== 'undefined' ? window : this);

