/**
 * Centralized Toast Notification Utilities
 * 
 * This file contains all toast notification functions used across the custom plugin.
 * Import this file in your HTML/PHP files to use these functions.
 * 
 * Usage:
 *   <script src="js/toast_utils.js"></script>
 *   Then use: showToast('Success message', 'success', 5000)
 */

/**
 * Show a toast notification
 * @param {string|object} message - Message to display, or object with {line2, line3, title}
 * @param {string} type - Toast type: 'success', 'error', 'warning', 'info' (default: 'success')
 * @param {number} duration - Duration in milliseconds (default: 5000)
 * @param {string} toastId - Optional: specific toast element ID to use
 * @returns {void}
 */
function showToast(message, type = 'success', duration = 5000, toastId = null) {
    // Handle different toast implementations
    // 1. Check for lesson information toast (multi-line format)
    if (typeof message === 'object' && message.line2 !== undefined) {
        return showLessonInfoToast(message.line2, message.line3, message.title || 'Lesson Rescheduled');
    }
    
    // 2. Try to find toast element
    let toast = null;
    
    // If specific toast ID provided, use it
    if (toastId) {
        toast = document.getElementById(toastId);
    }
    
    // Otherwise, try common toast IDs in order of preference
    if (!toast) {
        const commonIds = [
            'toastNotificationForManageClass',
            'toastNotificationFor1:1Class',
            'toastNotificationForCreateCohort',
            'toastNotificationForManageCohort',
            'calendar_admin_toast',
            'toastNotification'
        ];
        
        for (const id of commonIds) {
            toast = document.getElementById(id);
            if (toast) break;
        }
    }
    
    // If still no toast found, create a temporary one
    if (!toast) {
        toast = createTemporaryToast();
    }
    
    if (!toast) {
        console.warn('Toast element not found and could not create one');
        return;
    }
    
    // Set message
    if (toast.querySelector && toast.querySelector('.calendar_admin_toast_text')) {
        // Multi-line toast format (lesson information)
        const line2 = toast.querySelector('#calendar_admin_toast_line2');
        const line3 = toast.querySelector('#calendar_admin_toast_line3');
        const title = toast.querySelector('.calendar_admin_toast_title');
        if (line2) line2.textContent = message || '';
        if (line3) line3.textContent = '';
        if (title) title.textContent = 'Notification';
    } else {
        // Simple toast format
        toast.textContent = message || '';
    }
    
    // Set styling based on type
    const colors = {
        success: { bg: '#28a745', color: '#fff' },
        error: { bg: '#dc3545', color: '#fff' },
        warning: { bg: '#ffc107', color: '#212529' },
        info: { bg: '#17a2b8', color: '#fff' }
    };
    
    const style = colors[type] || colors.success;
    
    // Apply styles (only if not using CSS classes)
    if (toast.style) {
        toast.style.background = style.bg;
        toast.style.color = style.color;
        toast.style.display = 'block';
        toast.style.zIndex = '999999';
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(20px)';
        toast.style.transition = 'opacity 0.3s, transform 0.3s';
    }
    
    // Animate in
    setTimeout(() => {
        if (toast.style) {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        } else if (window.$ && $(toast).fadeIn) {
            $(toast).stop(true, true).fadeIn(140);
        }
    }, 10);
    
    // Auto hide
    const timeoutId = setTimeout(() => {
        hideToast(toast);
    }, duration);
    
    // Store timeout ID for potential cancellation
    if (toast) {
        toast._toastTimeout = timeoutId;
    }
}

/**
 * Show lesson information toast (multi-line format)
 * @param {string} line2 - Second line of message
 * @param {string} line3 - Third line of message
 * @param {string} title - Toast title (default: 'Lesson Rescheduled')
 * @returns {void}
 */
function showLessonInfoToast(line2, line3, title = 'Lesson Rescheduled') {
    const $toast = window.$ ? window.$('#calendar_admin_toast') : null;
    const line2El = document.getElementById('calendar_admin_toast_line2');
    const line3El = document.getElementById('calendar_admin_toast_line3');
    const titleEl = document.querySelector('.calendar_admin_toast_title');
    
    if ($toast && $toast.length) {
        if (line2El) line2El.textContent = line2 || '';
        if (line3El) line3El.textContent = line3 || '';
        if (titleEl) titleEl.textContent = title || 'Lesson Rescheduled';
        $toast.stop(true, true).fadeIn(140);
        
        // Auto hide after 4.5 seconds
        clearTimeout(window._lessonToastTimer);
        window._lessonToastTimer = setTimeout(() => {
            hideLessonInfoToast();
        }, 4500);
    } else {
        // Fallback to simple toast
        showToast(`${title}: ${line2} ${line3}`, 'success', 5000);
    }
}

/**
 * Hide toast notification
 * @param {HTMLElement} toastElement - Optional: specific toast element to hide
 * @returns {void}
 */
function hideToast(toastElement = null) {
    let toast = toastElement;
    
    if (!toast) {
        // Try to find any visible toast
        const commonIds = [
            'toastNotificationForManageClass',
            'toastNotificationFor1:1Class',
            'toastNotificationForCreateCohort',
            'toastNotificationForManageCohort',
            'calendar_admin_toast',
            'toastNotification'
        ];
        
        for (const id of commonIds) {
            const el = document.getElementById(id);
            if (el && (el.style.display === 'block' || window.getComputedStyle(el).display !== 'none')) {
                toast = el;
                break;
            }
        }
    }
    
    if (!toast) return;
    
    // Clear timeout if exists
    if (toast._toastTimeout) {
        clearTimeout(toast._toastTimeout);
        toast._toastTimeout = null;
    }
    
    // Animate out
    if (toast.style) {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(20px)';
        setTimeout(() => {
            toast.style.display = 'none';
        }, 300);
    } else if (window.$ && $(toast).fadeOut) {
        $(toast).fadeOut(180);
    } else {
        toast.style.display = 'none';
    }
}

/**
 * Hide lesson information toast
 * @returns {void}
 */
function hideLessonInfoToast() {
    const $toast = window.$ ? window.$('#calendar_admin_toast') : null;
    if ($toast && $toast.length) {
        $toast.fadeOut(180);
    }
    clearTimeout(window._lessonToastTimer);
    window._lessonToastTimer = null;
}

/**
 * Create a temporary toast element if none exists
 * @returns {HTMLElement|null}
 */
function createTemporaryToast() {
    const toast = document.createElement('div');
    toast.id = 'temp-toast-notification';
    toast.style.cssText = `
        display: none;
        position: fixed;
        top: 30px;
        right: 30px;
        background: #28a745;
        color: #fff;
        padding: 16px 24px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 999999;
        max-width: 400px;
        word-wrap: break-word;
        font-size: 14px;
        line-height: 1.5;
    `;
    document.body.appendChild(toast);
    return toast;
}

// Export functions to global scope for backward compatibility
if (typeof window !== 'undefined') {
    window.showToast = showToast;
    window.hideToast = hideToast;
    window.showLessonInfoToast = showLessonInfoToast;
    window.hideLessonInfoToast = hideLessonInfoToast;
    
    // Create namespace for better organization
    window.ToastUtils = {
        show: showToast,
        hide: hideToast,
        showLessonInfo: showLessonInfoToast,
        hideLessonInfo: hideLessonInfoToast
    };
}

