# Date Utils Implementation Summary

## Created Files

### `js/date_utils.js`
Centralized date formatting and conversion utilities containing:
- `ymd(d)` / `formatYMD(d)` - Date to YYYY-MM-DD format
- `formatDate(dateObj)` - Date to "MMM DD, YYYY" format
- `timestampToDate(ts)` - Timestamp to YYYY-MM-DD format
- `parseUnixTimestamp(timestamp)` - Parse Unix timestamp (seconds/milliseconds)
- `mondayOf(date)` - Get Monday of the week for a date
- `formatDateShort(date)` - Short date format (e.g., "Mon, Jan15")
- `formatDateLong(date)` - Long date format (e.g., "January 15, 2025")
- `formatDateUTC(date)` - Date to YYYY-MM-DD using UTC (avoids timezone issues)
- `parseDate(dateStr)` - Parse various date string formats to Date object
- `pad2(n)` - Pad number with leading zero

All functions are exposed globally and also under `window.DateUtils` namespace.

## Files to Update

### Priority 1: Core Calendar Files
1. **`js/calendar_admin_details_calendar_content.js`**
   - Remove: `ymd()` (line 134), `formatYMD()` (line 6023), inline `timestampToDate()` (line 510)
   - Add: `<script src="js/date_utils.js"></script>` or import statement
   - Replace: All calls with `window.DateUtils` or global functions

2. **`calendar_admin_details_agenda_tab.php`**
   - Remove: `ymd()` (line 196), `mondayOf()` (line 200)
   - Add: `<script src="js/date_utils.js"></script>`
   - Replace: All calls with `window.DateUtils` or global functions

### Priority 2: Manage Class Tab
3. **`calendar_admin_details_create_cohort_manage_class_tab.php`**
   - Remove: `formatDate()` (line 1930), `parseUnixTimestamp()` (line 2401)
   - Remove: All inline YYYY-MM-DD formatting code (~10 instances)
   - Add: `<script src="js/date_utils.js"></script>`
   - Replace: All calls with `window.DateUtils` or global functions

### Priority 3: Class Tab Files
4. **`calendar_admin_details_create_cohort_class_tab.php`**
   - Remove: `formatDate()` (lines 1002, 1212 - duplicate!), `formatDateShort()` (line 1365), `formatDateLong()` (line 1369)
   - Add: `<script src="js/date_utils.js"></script>`
   - Replace: All calls with `window.DateUtils` or global functions

5. **`calendar_admin_details_create_cohort_select_date.php`**
   - Remove: `formatDate()` (line 689)
   - Add: `<script src="js/date_utils.js"></script>`
   - Replace: All calls with `window.DateUtils` or global functions

## Implementation Steps

1. ✅ Create `js/date_utils.js` with all consolidated functions
2. ⏳ Update `js/calendar_admin_details_calendar_content.js`
3. ⏳ Update `calendar_admin_details_agenda_tab.php`
4. ⏳ Update `calendar_admin_details_create_cohort_manage_class_tab.php`
5. ⏳ Update `calendar_admin_details_create_cohort_class_tab.php`
6. ⏳ Update `calendar_admin_details_create_cohort_select_date.php`
7. ⏳ Test all date formatting across the application

## Notes

- All functions include error handling and validation
- Functions are backward compatible (exposed globally)
- `pad2` is included in both `time_utils.js` and `date_utils.js` for independence
- Functions handle edge cases (null, undefined, invalid dates)
- UTC variants available for timezone-sensitive operations

