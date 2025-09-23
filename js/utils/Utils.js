/**
 * Utility Functions
 * 
 * Common helper functions used throughout the application
 */

import AppConfig from '../config/AppConfig.js';

const Utils = {
  /**
   * Debounce function to limit function calls
   * @param {Function} func - Function to debounce
   * @param {number} delay - Delay in milliseconds
   * @returns {Function} Debounced function
   */
  debounce(func, delay = AppConfig.ui.debounceDelay) {
    let timeoutId;
    return function (...args) {
      clearTimeout(timeoutId);
      timeoutId = setTimeout(() => func.apply(this, args), delay);
    };
  },

  /**
   * Throttle function to limit function calls
   * @param {Function} func - Function to throttle
   * @param {number} limit - Limit in milliseconds
   * @returns {Function} Throttled function
   */
  throttle(func, limit = 100) {
    let inThrottle;
    return function (...args) {
      if (!inThrottle) {
        func.apply(this, args);
        inThrottle = true;
        setTimeout(() => (inThrottle = false), limit);
      }
    };
  },

  /**
   * Format card number with spaces
   * @param {string} value - Card number
   * @returns {string} Formatted card number
   */
  formatCardNumber(value) {
    return value
      .replace(/\s+/g, '')
      .replace(/[^0-9]/gi, '')
      .substr(0, AppConfig.validation.cardNumberLength)
      .replace(/(.{4})/g, '$1 ')
      .trim();
  },

  /**
   * Format expiry date
   * @param {string} value - Expiry date
   * @returns {string} Formatted expiry date
   */
  formatExpiryDate(value) {
    return value
      .replace(/\D/g, '')
      .replace(/(\d{2})(\d)/, '$1/$2')
      .substr(0, 5);
  },

  /**
   * Validate email format
   * @param {string} email - Email to validate
   * @returns {boolean} True if valid email
   */
  validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  },

  /**
   * Generate unique ID
   * @returns {string} Unique identifier
   */
  generateId() {
    return Date.now().toString(36) + Math.random().toString(36).substr(2);
  },

  /**
   * Copy text to clipboard
   * @param {string} text - Text to copy
   * @returns {Promise<boolean>} Success status
   */
  async copyToClipboard(text) {
    try {
      if (navigator.clipboard) {
        await navigator.clipboard.writeText(text);
        return true;
      } else {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        return true;
      }
    } catch (error) {
      console.error('Failed to copy text:', error);
      return false;
    }
  },

  /**
   * Show notification/toast message
   * @param {string} message - Message to show
   * @param {string} type - Type of message ('success', 'error', 'warning', 'info')
   * @param {number} duration - Duration in milliseconds
   */
  showNotification(message, type = 'info', duration = 3000) {
    const toaster = elements.toaster;
    const toasterText = elements.toasterText;
    
    if (toaster && toasterText) {
      toasterText.textContent = message;
      toaster.className = `toaster ${type} active`;
      
      setTimeout(() => {
        toaster.classList.remove('active');
      }, duration);
    }
  },

  /**
   * Format currency
   * @param {number} amount - Amount to format
   * @param {string} currency - Currency code
   * @returns {string} Formatted currency
   */
  formatCurrency(amount, currency = AppConfig.defaults.currency) {
    return new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: currency,
      minimumFractionDigits: 2
    }).format(amount);
  },

  /**
   * Sanitize HTML to prevent XSS
   * @param {string} str - String to sanitize
   * @returns {string} Sanitized string
   */
  sanitizeHTML(str) {
    const temp = document.createElement('div');
    temp.textContent = str;
    return temp.innerHTML;
  },

  /**
   * Check if element is in viewport
   * @param {HTMLElement} element - Element to check
   * @returns {boolean} True if in viewport
   */
  isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
      rect.top >= 0 &&
      rect.left >= 0 &&
      rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  },

  /**
   * Log messages based on configuration
   * @param {string} level - Log level ('info', 'warn', 'error')
   * @param {string} message - Message to log
   * @param {any} data - Additional data to log
   */
  log(level, message, data = null) {
    if (!AppConfig.debug.enabled) return;

    const logLevels = { info: 0, warn: 1, error: 2 };
    const configLevel = logLevels[AppConfig.debug.logLevel];
    const currentLevel = logLevels[level];

    if (currentLevel >= configLevel) {
      const timestamp = new Date().toISOString();
      const logMessage = `[${timestamp}] [${level.toUpperCase()}] ${message}`;
      
      console[level](logMessage, data || '');
    }
  }
};

export default Utils;

