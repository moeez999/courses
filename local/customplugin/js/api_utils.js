/**
 * Centralized API/Fetch Utilities
 * 
 * This file contains all API and fetch helper functions used across the custom plugin.
 * Import this file in your HTML/PHP files to use these functions.
 * 
 * Usage:
 *   <script src="js/api_utils.js"></script>
 *   Then use: ApiUtils.fetch(), ApiUtils.post(), ApiUtils.get(), etc.
 */

(function(global) {
    'use strict';
    
    /**
     * Default configuration for API calls
     */
    const DEFAULT_CONFIG = {
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json'
        },
        timeout: 30000, // 30 seconds
        showLoader: false,
        hideLoader: false
    };
    
    /**
     * Get base URL for API calls
     * @returns {string} - Base URL
     * @private
     */
    function _getBaseUrl() {
        if (window.M && window.M.cfg && window.M.cfg.wwwroot) {
            return window.M.cfg.wwwroot + '/local/customplugin/ajax/';
        }
        return 'ajax/';
    }
    
    /**
     * Get session key for API calls
     * @returns {string} - Session key
     * @private
     */
    function _getSesskey() {
        if (window.M && window.M.cfg && window.M.cfg.sesskey) {
            return window.M.cfg.sesskey;
        }
        return '';
    }
    
    /**
     * Show loader if configured
     * @param {boolean} show - Whether to show loader
     * @private
     */
    function _handleLoader(show) {
        if (show && window.showGlobalLoader) {
            window.showGlobalLoader();
        }
    }
    
    /**
     * Hide loader if configured
     * @param {boolean} hide - Whether to hide loader
     * @private
     */
    function _hideLoader(hide) {
        if (hide && window.hideGlobalLoader) {
            window.hideGlobalLoader();
        }
    }
    
    /**
     * Parse response as JSON with error handling
     * @param {Response} response - Fetch response object
     * @returns {Promise<object>} - Parsed JSON data
     * @private
     */
    async function _parseJSON(response) {
        try {
            const text = await response.text();
            if (!text) {
                return { ok: false, error: 'Empty response' };
            }
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('JSON parse error:', e, 'Response text:', text);
                return { ok: false, error: 'Invalid JSON response', raw: text };
            }
        } catch (e) {
            console.error('Response parse error:', e);
            return { ok: false, error: 'Failed to parse response' };
        }
    }
    
    /**
     * Handle API response with error checking
     * @param {Response} response - Fetch response object
     * @param {object} options - Configuration options
     * @returns {Promise<object>} - Response data
     * @private
     */
    async function _handleResponse(response, options = {}) {
        const data = await _parseJSON(response);
        
        // Check HTTP status
        if (!response.ok) {
            return {
                ok: false,
                error: data.error || `HTTP ${response.status}: ${response.statusText}`,
                status: response.status,
                data: data
            };
        }
        
        // Check if response indicates error
        if (data.ok === false || data.success === false || data.error) {
            return {
                ok: false,
                error: data.error || data.message || 'Unknown error',
                data: data
            };
        }
        
        return {
            ok: true,
            data: data,
            response: response
        };
    }
    
    /**
     * Generic fetch function with error handling
     * @param {string} url - API endpoint URL
     * @param {object} options - Fetch options and custom config
     * @returns {Promise<object>} - Response object with {ok, data, error}
     */
    async function apiFetch(url, options = {}) {
        const config = { ...DEFAULT_CONFIG, ...options };
        const { showLoader, hideLoader, timeout, ...fetchOptions } = config;
        
        // Show loader if configured
        _handleLoader(showLoader);
        
        try {
            // Add session key to URL if not present
            if (!url.includes('sesskey=') && _getSesskey()) {
                const separator = url.includes('?') ? '&' : '?';
                url = url + separator + 'sesskey=' + encodeURIComponent(_getSesskey());
            }
            
            // Create timeout promise
            const timeoutPromise = new Promise((_, reject) => {
                setTimeout(() => reject(new Error('Request timeout')), timeout);
            });
            
            // Make fetch request
            const fetchPromise = fetch(url, fetchOptions);
            const response = await Promise.race([fetchPromise, timeoutPromise]);
            
            // Handle response
            const result = await _handleResponse(response, config);
            
            // Hide loader if configured
            _hideLoader(hideLoader);
            
            return result;
        } catch (error) {
            console.error('API fetch error:', error);
            
            // Hide loader if configured
            _hideLoader(hideLoader);
            
            return {
                ok: false,
                error: error.message || 'Network error',
                type: 'network'
            };
        }
    }
    
    /**
     * POST request helper
     * @param {string} url - API endpoint URL
     * @param {object} data - Data to send
     * @param {object} options - Additional options
     * @returns {Promise<object>} - Response object
     */
    async function apiPost(url, data = {}, options = {}) {
        const body = typeof data === 'string' 
            ? data 
            : JSON.stringify(data);
        
        return apiFetch(url, {
            method: 'POST',
            body: body,
            ...options
        });
    }
    
    /**
     * POST request with form data
     * @param {string} url - API endpoint URL
     * @param {object|FormData} data - Form data to send
     * @param {object} options - Additional options
     * @returns {Promise<object>} - Response object
     */
    async function apiPostForm(url, data = {}, options = {}) {
        let body;
        let contentType = 'application/x-www-form-urlencoded';
        
        if (data instanceof FormData) {
            body = data;
            contentType = null; // Let browser set Content-Type for FormData
        } else {
            // Convert object to URL-encoded string
            const params = new URLSearchParams();
            Object.keys(data).forEach(key => {
                if (data[key] !== null && data[key] !== undefined) {
                    params.append(key, data[key]);
                }
            });
            body = params.toString();
        }
        
        const headers = { ...options.headers };
        if (contentType) {
            headers['Content-Type'] = contentType;
        }
        
        return apiFetch(url, {
            method: 'POST',
            body: body,
            headers: headers,
            ...options
        });
    }
    
    /**
     * GET request helper
     * @param {string} url - API endpoint URL
     * @param {object} params - Query parameters
     * @param {object} options - Additional options
     * @returns {Promise<object>} - Response object
     */
    async function apiGet(url, params = {}, options = {}) {
        // Add query parameters to URL
        if (Object.keys(params).length > 0) {
            const queryString = new URLSearchParams(params).toString();
            url += (url.includes('?') ? '&' : '?') + queryString;
        }
        
        return apiFetch(url, {
            method: 'GET',
            ...options
        });
    }
    
    /**
     * Fetch JSON from URL (simpler interface)
     * @param {string} url - URL to fetch
     * @param {object} options - Fetch options
     * @returns {Promise<object>} - Response data or {ok: false} on error
     */
    async function fetchJSON(url, options = {}) {
        try {
            const res = await fetch(url, {
                credentials: 'same-origin',
                ...options
            });
            
            if (!res.ok) {
                console.error('Request failed:', url, res.status);
                return { ok: false, status: res.status };
            }
            
            return await res.json();
        } catch (e) {
            console.error('Request error:', url, e);
            return { ok: false, error: e.message };
        }
    }
    
    /**
     * Check if response is successful
     * @param {object} response - Response object from API call
     * @returns {boolean} - True if response is successful
     */
    function isSuccess(response) {
        return response && response.ok === true;
    }
    
    /**
     * Get error message from response
     * @param {object} response - Response object from API call
     * @returns {string} - Error message or 'Unknown error'
     */
    function getErrorMessage(response) {
        if (!response) return 'Unknown error';
        return response.error || response.message || 'Unknown error';
    }
    
    // Export functions to global scope
    if (typeof global !== 'undefined') {
        // Create namespace
        global.ApiUtils = {
            fetch: apiFetch,
            post: apiPost,
            postForm: apiPostForm,
            get: apiGet,
            fetchJSON: fetchJSON,
            isSuccess: isSuccess,
            getErrorMessage: getErrorMessage
        };
        
        // Also expose commonly used functions directly for backward compatibility
        global.apiFetch = apiFetch;
        global.apiPost = apiPost;
        global.apiGet = apiGet;
        global.fetchJSON = fetchJSON;
    }
    
})(typeof window !== 'undefined' ? window : this);

