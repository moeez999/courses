/**
 * Centralized Date Formatting Utilities
 * 
 * This file contains all date formatting and conversion functions used across the custom plugin.
 * Import this file in your HTML/PHP files to use these functions.
 * 
 * Usage:
 *   <script src="js/date_utils.js"></script>
 *   Then use: ymd(new Date()) // Returns "2025-01-15"
 */

/**
 * Pad a number with leading zero if needed (for days/months)
 * @param {number} n - Number to pad
 * @returns {string} - Padded string (e.g., "05" for 5)
 */
function pad2(n) {
    return String(n).padStart(2, '0');
}

/**
 * Convert Date object to YYYY-MM-DD format string
 * @param {Date} d - Date object
 * @returns {string} - Date string in format "YYYY-MM-DD" (e.g., "2025-01-15")
 */
function ymd(d) {
    if (!d || !(d instanceof Date) || isNaN(d.getTime())) {
        console.warn('ymd: Invalid Date object', d);
        return '';
    }
    return `${d.getFullYear()}-${pad2(d.getMonth() + 1)}-${pad2(d.getDate())}`;
}

/**
 * Convert Date object to YYYY-MM-DD format string (alias for ymd)
 * @param {Date} d - Date object
 * @returns {string} - Date string in format "YYYY-MM-DD"
 */
function formatYMD(d) {
    return ymd(d);
}

/**
 * Convert Date object to "MMM DD, YYYY" format string (e.g., "Jan 15, 2025")
 * @param {Date} dateObj - Date object
 * @returns {string} - Formatted date string
 */
function formatDate(dateObj) {
    if (!dateObj || !(dateObj instanceof Date) || isNaN(dateObj.getTime())) {
        console.warn('formatDate: Invalid Date object', dateObj);
        return '';
    }
    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];
    const day = dateObj.getDate().toString().padStart(2, '0');
    return `${months[dateObj.getMonth()]} ${day}, ${dateObj.getFullYear()}`;
}

/**
 * Convert Unix timestamp (seconds) to YYYY-MM-DD format string
 * @param {number} ts - Unix timestamp in seconds
 * @returns {string} - Date string in format "YYYY-MM-DD"
 */
function timestampToDate(ts) {
    if (typeof ts !== 'number' || isNaN(ts)) {
        console.warn('timestampToDate: Invalid timestamp', ts);
        return '';
    }
    const date = new Date(ts * 1000); // Convert seconds to milliseconds
    return ymd(date);
}

/**
 * Parse Unix timestamp (handles both seconds and milliseconds)
 * @param {number|string} timestamp - Unix timestamp in seconds or milliseconds
 * @returns {Date} - Date object
 */
function parseUnixTimestamp(timestamp) {
    if (timestamp === null || timestamp === undefined) {
        console.warn('parseUnixTimestamp: Invalid timestamp', timestamp);
        return new Date();
    }
    const ts = parseInt(timestamp, 10);
    if (isNaN(ts)) {
        console.warn('parseUnixTimestamp: Could not parse timestamp', timestamp);
        return new Date();
    }
    // If timestamp is less than 1e12 (Jan 1, 2001 in seconds), assume it's in seconds
    return new Date(ts < 1e12 ? ts * 1000 : ts);
}

/**
 * Get Monday of the week for a given date
 * @param {Date} date - Date object
 * @returns {Date} - Date object representing Monday of that week
 */
function mondayOf(date) {
    if (!date || !(date instanceof Date) || isNaN(date.getTime())) {
        console.warn('mondayOf: Invalid Date object', date);
        return new Date();
    }
    const d = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    const dow = (d.getDay() + 6) % 7; // Convert Sunday (0) to 6, Monday (1) to 0, etc.
    d.setDate(d.getDate() - dow);
    d.setHours(0, 0, 0, 0);
    return d;
}

/**
 * Get the number of days in a month
 * @param {number} year - Year (e.g., 2025)
 * @param {number} month - Month (0-11, where 0 = January)
 * @returns {number} - Number of days in the month
 */
function daysInMonth(year, month) {
    if (typeof year !== 'number' || typeof month !== 'number' || month < 0 || month > 11) {
        console.warn('daysInMonth: Invalid parameters', { year, month });
        return 31; // Default fallback
    }
    return new Date(year, month + 1, 0).getDate();
}

/**
 * Get the first day of a month
 * @param {number} year - Year (e.g., 2025)
 * @param {number} month - Month (0-11, where 0 = January)
 * @returns {Date} - Date object representing the first day of the month
 */
function getFirstDayOfMonth(year, month) {
    if (typeof year !== 'number' || typeof month !== 'number' || month < 0 || month > 11) {
        console.warn('getFirstDayOfMonth: Invalid parameters', { year, month });
        return new Date();
    }
    return new Date(year, month, 1);
}

/**
 * Check if a year is a leap year
 * @param {number} year - Year to check
 * @returns {boolean} - True if the year is a leap year
 */
function isLeapYear(year) {
    if (typeof year !== 'number') {
        console.warn('isLeapYear: Invalid year', year);
        return false;
    }
    return (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0);
}

/**
 * Get the week number for a date (ISO 8601 week numbering)
 * @param {Date} date - Date object
 * @returns {number} - Week number (1-53)
 */
function getWeekNumber(date) {
    if (!date || !(date instanceof Date) || isNaN(date.getTime())) {
        console.warn('getWeekNumber: Invalid Date object', date);
        return 1;
    }
    const d = new Date(Date.UTC(date.getFullYear(), date.getMonth(), date.getDate()));
    const dayNum = d.getUTCDay() || 7;
    d.setUTCDate(d.getUTCDate() + 4 - dayNum);
    const yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
    return Math.ceil((((d - yearStart) / 86400000) + 1) / 7);
}

/**
 * Get the start of the week (Monday) for a given date
 * @param {Date} date - Date object
 * @returns {Date} - Date object representing Monday of that week
 */
function getWeekStart(date) {
    return mondayOf(date);
}

/**
 * Get the end of the week (Sunday) for a given date
 * @param {Date} date - Date object
 * @returns {Date} - Date object representing Sunday of that week
 */
function getWeekEnd(date) {
    if (!date || !(date instanceof Date) || isNaN(date.getTime())) {
        console.warn('getWeekEnd: Invalid Date object', date);
        return new Date();
    }
    const start = mondayOf(date);
    const end = new Date(start);
    end.setDate(start.getDate() + 6); // Add 6 days to get Sunday
    end.setHours(23, 59, 59, 999); // End of day
    return end;
}

/**
 * Get the start of a month
 * @param {Date} date - Date object
 * @returns {Date} - Date object representing the first day of the month
 */
function startOfMonth(date) {
    if (!date || !(date instanceof Date) || isNaN(date.getTime())) {
        console.warn('startOfMonth: Invalid Date object', date);
        return new Date();
    }
    return new Date(date.getFullYear(), date.getMonth(), 1);
}

/**
 * Get the end of a month
 * @param {Date} date - Date object
 * @returns {Date} - Date object representing the last day of the month
 */
function endOfMonth(date) {
    if (!date || !(date instanceof Date) || isNaN(date.getTime())) {
        console.warn('endOfMonth: Invalid Date object', date);
        return new Date();
    }
    return new Date(date.getFullYear(), date.getMonth() + 1, 0, 23, 59, 59, 999);
}

/**
 * Add days to a date
 * @param {Date} date - Date object
 * @param {number} days - Number of days to add (can be negative)
 * @returns {Date} - New Date object
 */
function addDays(date, days) {
    if (!date || !(date instanceof Date) || isNaN(date.getTime())) {
        console.warn('addDays: Invalid Date object', date);
        return new Date();
    }
    if (typeof days !== 'number') {
        console.warn('addDays: Invalid days parameter', days);
        return new Date(date);
    }
    const result = new Date(date);
    result.setDate(result.getDate() + days);
    return result;
}

/**
 * Add months to a date
 * @param {Date} date - Date object
 * @param {number} months - Number of months to add (can be negative)
 * @returns {Date} - New Date object
 */
function addMonths(date, months) {
    if (!date || !(date instanceof Date) || isNaN(date.getTime())) {
        console.warn('addMonths: Invalid Date object', date);
        return new Date();
    }
    if (typeof months !== 'number') {
        console.warn('addMonths: Invalid months parameter', months);
        return new Date(date);
    }
    const result = new Date(date);
    result.setMonth(result.getMonth() + months);
    return result;
}

/**
 * Add years to a date
 * @param {Date} date - Date object
 * @param {number} years - Number of years to add (can be negative)
 * @returns {Date} - New Date object
 */
function addYears(date, years) {
    if (!date || !(date instanceof Date) || isNaN(date.getTime())) {
        console.warn('addYears: Invalid Date object', date);
        return new Date();
    }
    if (typeof years !== 'number') {
        console.warn('addYears: Invalid years parameter', years);
        return new Date(date);
    }
    const result = new Date(date);
    result.setFullYear(result.getFullYear() + years);
    return result;
}

/**
 * Get the difference in days between two dates
 * @param {Date} date1 - First date
 * @param {Date} date2 - Second date
 * @returns {number} - Number of days difference (positive if date1 > date2)
 */
function diffDays(date1, date2) {
    if (!date1 || !(date1 instanceof Date) || isNaN(date1.getTime()) ||
        !date2 || !(date2 instanceof Date) || isNaN(date2.getTime())) {
        console.warn('diffDays: Invalid Date objects', { date1, date2 });
        return 0;
    }
    const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
    return Math.round((date1 - date2) / oneDay);
}

/**
 * Check if two dates are the same day
 * @param {Date} date1 - First date
 * @param {Date} date2 - Second date
 * @returns {boolean} - True if both dates are the same day
 */
function isSameDay(date1, date2) {
    if (!date1 || !(date1 instanceof Date) || isNaN(date1.getTime()) ||
        !date2 || !(date2 instanceof Date) || isNaN(date2.getTime())) {
        return false;
    }
    return date1.getFullYear() === date2.getFullYear() &&
           date1.getMonth() === date2.getMonth() &&
           date1.getDate() === date2.getDate();
}

/**
 * Check if a date is today
 * @param {Date} date - Date to check
 * @returns {boolean} - True if the date is today
 */
function isToday(date) {
    if (!date || !(date instanceof Date) || isNaN(date.getTime())) {
        return false;
    }
    return isSameDay(date, new Date());
}

/**
 * Check if a date is in the past
 * @param {Date} date - Date to check
 * @returns {boolean} - True if the date is in the past
 */
function isPast(date) {
    if (!date || !(date instanceof Date) || isNaN(date.getTime())) {
        return false;
    }
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const checkDate = new Date(date);
    checkDate.setHours(0, 0, 0, 0);
    return checkDate < today;
}

/**
 * Check if a date is in the future
 * @param {Date} date - Date to check
 * @returns {boolean} - True if the date is in the future
 */
function isFuture(date) {
    if (!date || !(date instanceof Date) || isNaN(date.getTime())) {
        return false;
    }
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const checkDate = new Date(date);
    checkDate.setHours(0, 0, 0, 0);
    return checkDate > today;
}

/**
 * Format date in short format (e.g., "Mon, Jan15")
 * @param {Date} date - Date object
 * @param {Array<string>} dayNames - Array of day names (default: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'])
 * @param {Array<string>} monthNames - Array of month names (default: ['Jan', 'Feb', 'Mar', ...])
 * @returns {string} - Formatted date string
 */
function formatDateShort(date, dayNames, monthNames) {
    if (!date || !(date instanceof Date) || isNaN(date.getTime())) {
        console.warn('formatDateShort: Invalid Date object', date);
        return '';
    }
    const defaultDayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    const defaultMonthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
    const days = dayNames || defaultDayNames;
    const months = monthNames || defaultMonthNames;
    
    return `${days[date.getDay()]}, ${months[date.getMonth()]}${date.getDate()}`;
}

/**
 * Format date in long format (e.g., "January 15, 2025")
 * @param {Date} date - Date object
 * @param {Array<string>} monthNames - Array of full month names (default: ['January', 'February', ...])
 * @returns {string} - Formatted date string
 */
function formatDateLong(date, monthNames) {
    if (!date || !(date instanceof Date) || isNaN(date.getTime())) {
        console.warn('formatDateLong: Invalid Date object', date);
        return '';
    }
    const defaultMonthNames = ['January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'];
    
    const months = monthNames || defaultMonthNames;
    
    return `${months[date.getMonth()]} ${date.getDate().toString().padStart(2, '0')}, ${date.getFullYear()}`;
}

/**
 * Convert Date object to ISO date string (YYYY-MM-DD) using UTC
 * Useful for avoiding timezone issues
 * @param {Date} date - Date object
 * @returns {string} - Date string in format "YYYY-MM-DD"
 */
function formatDateUTC(date) {
    if (!date || !(date instanceof Date) || isNaN(date.getTime())) {
        console.warn('formatDateUTC: Invalid Date object', date);
        return '';
    }
    const yyyy = date.getUTCFullYear();
    const mm = pad2(date.getUTCMonth() + 1);
    const dd = pad2(date.getUTCDate());
    return `${yyyy}-${mm}-${dd}`;
}

/**
 * Parse date string in various formats to Date object
 * Handles: YYYY-MM-DD, MMM DD YYYY, etc.
 * @param {string} dateStr - Date string
 * @returns {Date|null} - Date object or null if parsing fails
 */
function parseDate(dateStr) {
    if (!dateStr || typeof dateStr !== 'string') {
        console.warn('parseDate: Invalid input', dateStr);
        return null;
    }
    
    const trimmed = dateStr.trim();
    
    // Handle ISO format YYYY-MM-DD
    if (/^\d{4}-\d{2}-\d{2}$/.test(trimmed)) {
        const parts = trimmed.split('-');
        const year = parseInt(parts[0], 10);
        const month = parseInt(parts[1], 10) - 1; // Month is 0-indexed
        const day = parseInt(parts[2], 10);
        // Create date at noon in local timezone to avoid timezone shifts
        return new Date(year, month, day, 12, 0, 0);
    }
    
    // Try Date.parse directly
    const parsed = Date.parse(trimmed);
    if (!isNaN(parsed)) {
        return new Date(parsed);
    }
    
    // Try parsing with cleaned string (remove commas, weekday names)
    let cleaned = trimmed
        .replace(/,/g, '')
        .replace(/^\w{3,9}\s+/, '')
        .trim();
    cleaned = cleaned.replace(/([A-Za-z])(?=\d)/g, '$1 ');
    const hasYear = /\d{4}/.test(cleaned);
    const tryStr = hasYear ? cleaned : `${cleaned} ${new Date().getFullYear()}`;
    const parsed2 = Date.parse(tryStr);
    if (!isNaN(parsed2)) {
        return new Date(parsed2);
    }
    
    console.warn('parseDate: Could not parse date string', dateStr);
    return null;
}

// Export functions to global scope for backward compatibility
if (typeof window !== 'undefined') {
    window.ymd = ymd;
    window.formatYMD = formatYMD;
    window.formatDate = formatDate;
    window.timestampToDate = timestampToDate;
    window.parseUnixTimestamp = parseUnixTimestamp;
    window.mondayOf = mondayOf;
    window.formatDateShort = formatDateShort;
    window.formatDateLong = formatDateLong;
    window.formatDateUTC = formatDateUTC;
    window.parseDate = parseDate;
    window.pad2 = pad2; // Also export pad2 for date formatting
    
    // Create namespace for better organization
    window.DateUtils = {
        ymd,
        formatYMD,
        formatDate,
        timestampToDate,
        parseUnixTimestamp,
        mondayOf,
        formatDateShort,
        formatDateLong,
        formatDateUTC,
        parseDate,
        pad2
    };
}

