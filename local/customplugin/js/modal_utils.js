/**
 * Centralized Modal/Backdrop Management Utilities
 * 
 * This file contains all modal and backdrop management functions used across the custom plugin.
 * Import this file in your HTML/PHP files to use these functions.
 * 
 * Usage:
 *   <script src="js/modal_utils.js"></script>
 *   Then use: ModalUtils.open('modal-id'), ModalUtils.close('modal-id'), etc.
 */

(function(global) {
    'use strict';
    
    /**
     * Private state for modal management
     */
    const _openModals = new Set();
    const _modalConfigs = new Map();
    
    /**
     * Default configuration for modals
     */
    const DEFAULT_CONFIG = {
        fadeDuration: 300,
        preventBodyScroll: true,
        closeOnBackdropClick: true,
        closeOnEscape: true,
        zIndex: 10000
    };
    
    /**
     * Get modal element by ID or selector
     * @param {string} modalId - Modal ID or selector
     * @returns {HTMLElement|null}
     * @private
     */
    function _getModalElement(modalId) {
        if (typeof modalId === 'string') {
            // Try as ID first
            let el = document.getElementById(modalId);
            if (el) return el;
            
            // Try as selector
            el = document.querySelector(modalId);
            if (el) return el;
        }
        return null;
    }
    
    /**
     * Get backdrop element (looks for common backdrop patterns)
     * @param {string} modalId - Modal ID
     * @returns {HTMLElement|null}
     * @private
     */
    function _getBackdropElement(modalId) {
        // Common backdrop patterns
        const patterns = [
            modalId + '_backdrop',
            modalId + 'Backdrop',
            modalId.replace('modal', 'backdrop'),
            modalId.replace('Modal', 'Backdrop')
        ];
        
        for (const pattern of patterns) {
            const el = document.getElementById(pattern);
            if (el) return el;
        }
        
        // Try to find backdrop as parent or sibling
        const modal = _getModalElement(modalId);
        if (modal) {
            // Check if modal has a backdrop parent
            let parent = modal.parentElement;
            while (parent) {
                if (parent.classList.contains('backdrop') || 
                    parent.classList.contains('modal-backdrop') ||
                    parent.id && parent.id.includes('backdrop')) {
                    return parent;
                }
                parent = parent.parentElement;
            }
        }
        
        return null;
    }
    
    /**
     * Lock body scroll
     * @private
     */
    function _lockBodyScroll() {
        if (document.body) {
            document.body.style.overflow = 'hidden';
        }
    }
    
    /**
     * Unlock body scroll
     * @private
     */
    function _unlockBodyScroll() {
        if (_openModals.size === 0 && document.body) {
            document.body.style.overflow = '';
        }
    }
    
    /**
     * Open a modal
     * @param {string} modalId - Modal ID or selector
     * @param {object} options - Configuration options
     * @returns {boolean} - True if modal was opened successfully
     */
    function openModal(modalId, options = {}) {
        const config = { ...DEFAULT_CONFIG, ...options };
        const modal = _getModalElement(modalId);
        const backdrop = _getBackdropElement(modalId);
        
        if (!modal && !backdrop) {
            console.warn('Modal not found:', modalId);
            return false;
        }
        
        // Store config
        _modalConfigs.set(modalId, config);
        
        // Show backdrop
        if (backdrop) {
            if (window.$ && backdrop.id) {
                // Use jQuery fadeIn if available
                $(backdrop).fadeIn(config.fadeDuration);
            } else {
                backdrop.style.display = 'block';
                backdrop.style.opacity = '0';
                setTimeout(() => {
                    backdrop.style.opacity = '1';
                }, 10);
            }
            
            // Add open class
            backdrop.classList.add('is-open');
        }
        
        // Show modal
        if (modal) {
            if (window.$ && modal.id) {
                $(modal).fadeIn(config.fadeDuration);
            } else {
                modal.style.display = 'block';
                modal.style.opacity = '0';
                setTimeout(() => {
                    modal.style.opacity = '1';
                }, 10);
            }
        }
        
        // Lock body scroll
        if (config.preventBodyScroll) {
            _lockBodyScroll();
        }
        
        // Track open modal
        _openModals.add(modalId);
        
        // Set up escape key handler
        if (config.closeOnEscape) {
            const escapeHandler = (e) => {
                if (e.key === 'Escape' && _openModals.has(modalId)) {
                    closeModal(modalId);
                    document.removeEventListener('keydown', escapeHandler);
                }
            };
            document.addEventListener('keydown', escapeHandler);
            config._escapeHandler = escapeHandler;
        }
        
        // Set up backdrop click handler
        if (config.closeOnBackdropClick && backdrop) {
            const backdropClickHandler = (e) => {
                if (e.target === backdrop || e.target.classList.contains('modal-overlay')) {
                    closeModal(modalId);
                    backdrop.removeEventListener('click', backdropClickHandler);
                }
            };
            backdrop.addEventListener('click', backdropClickHandler);
            config._backdropClickHandler = backdropClickHandler;
        }
        
        return true;
    }
    
    /**
     * Close a modal
     * @param {string} modalId - Modal ID or selector
     * @returns {boolean} - True if modal was closed successfully
     */
    function closeModal(modalId) {
        const config = _modalConfigs.get(modalId) || DEFAULT_CONFIG;
        const modal = _getModalElement(modalId);
        const backdrop = _getBackdropElement(modalId);
        
        // Remove escape handler
        if (config._escapeHandler) {
            document.removeEventListener('keydown', config._escapeHandler);
        }
        
        // Remove backdrop click handler
        if (config._backdropClickHandler && backdrop) {
            backdrop.removeEventListener('click', config._backdropClickHandler);
        }
        
        // Hide modal
        if (modal) {
            if (window.$ && modal.id) {
                $(modal).fadeOut(config.fadeDuration);
            } else {
                modal.style.opacity = '0';
                setTimeout(() => {
                    modal.style.display = 'none';
                }, config.fadeDuration);
            }
        }
        
        // Hide backdrop
        if (backdrop) {
            if (window.$ && backdrop.id) {
                $(backdrop).fadeOut(config.fadeDuration, () => {
                    backdrop.classList.remove('is-open');
                });
            } else {
                backdrop.style.opacity = '0';
                setTimeout(() => {
                    backdrop.style.display = 'none';
                    backdrop.classList.remove('is-open');
                }, config.fadeDuration);
            }
        }
        
        // Unlock body scroll
        _openModals.delete(modalId);
        _unlockBodyScroll();
        
        // Clean up config
        _modalConfigs.delete(modalId);
        
        return true;
    }
    
    /**
     * Close all open modals
     * @returns {void}
     */
    function closeAllModals() {
        const modals = Array.from(_openModals);
        modals.forEach(modalId => closeModal(modalId));
    }
    
    /**
     * Toggle modal state
     * @param {string} modalId - Modal ID or selector
     * @param {object} options - Configuration options
     * @returns {boolean} - True if modal is now open, false if closed
     */
    function toggleModal(modalId, options = {}) {
        if (_openModals.has(modalId)) {
            closeModal(modalId);
            return false;
        } else {
            openModal(modalId, options);
            return true;
        }
    }
    
    /**
     * Check if modal is open
     * @param {string} modalId - Modal ID or selector
     * @returns {boolean} - True if modal is open
     */
    function isModalOpen(modalId) {
        return _openModals.has(modalId);
    }
    
    /**
     * Get all open modals
     * @returns {Array<string>} - Array of open modal IDs
     */
    function getOpenModals() {
        return Array.from(_openModals);
    }
    
    // Export functions to global scope
    if (typeof global !== 'undefined') {
        // Create namespace
        global.ModalUtils = {
            open: openModal,
            close: closeModal,
            closeAll: closeAllModals,
            toggle: toggleModal,
            isOpen: isModalOpen,
            getOpen: getOpenModals
        };
        
        // Also expose commonly used functions directly for backward compatibility
        global.openModal = openModal;
        global.closeModal = closeModal;
        global.closeAllModals = closeAllModals;
        global.toggleModal = toggleModal;
    }
    
})(typeof window !== 'undefined' ? window : this);

