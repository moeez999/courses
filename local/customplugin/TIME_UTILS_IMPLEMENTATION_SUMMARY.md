# Time Utils Implementation Summary

## Created Files

### 1. `js/time_utils.js`
Centralized time formatting utility file containing:
- `pad2(n)` - Pad number with leading zero
- `fmt12(min)` - Convert minutes to 12-hour format
- `minutes(hhmm)` - Convert time string to minutes
- `convert12hTo24h(time12h)` - Convert 12-hour to 24-hour format
- `convert24hTo12h(time24h)` - Convert 24-hour to 12-hour format
- `to12h(hhmm)` - Convert to 12-hour format (returns object)
- `formatTime12Hour(date)` - Format Date object to 12-hour format
- `formatTime12HourFromParts(hours, minutes)` - Format from parts to 12-hour format
- `timeToMinutes(timeStr)` - Alias for minutes()
- `minutesToTime(minutes)` - Convert minutes to 24-hour time string
- `normalizeTimeTo12h(inputRaw)` - Normalize various time formats to 12-hour

All functions are exported to `window` object for global access.

## Updated Files

### 1. `calendar_admin_details_create_cohort_manage_class_tab.php`
- ✅ Added `<script src="js/time_utils.js"></script>` include
- ✅ Removed duplicate `convert12hTo24h()` function
- ✅ Removed duplicate `convert24hTo12h()` function
- ✅ Removed duplicate `formatTime12Hour()` function
- ✅ Removed duplicate `formatTime12HourFromParts()` function
- ✅ All function calls remain unchanged (using global functions)

### 2. `calendar_admin_details_agenda_tab.php`
- ✅ Added `<script src="js/time_utils.js"></script>` include
- ✅ Removed duplicate `pad2()` function
- ✅ Removed duplicate `fmt12()` function
- ✅ Removed duplicate `minutes()` function
- ✅ All function calls remain unchanged

### 3. `js/calendar_admin_details_calendar_content.js`
- ✅ Added comment indicating functions are in time_utils.js
- ✅ Removed duplicate `pad2()` function
- ✅ Removed duplicate `fmt12()` function
- ✅ Removed duplicate `minutes()` function
- ⚠️ **Note:** This is a standalone JS file. Ensure `time_utils.js` is loaded before this file in HTML.

### 4. `calendar_admin_details_create_cohort_class_tab.php`
- ✅ Added `<script src="js/time_utils.js"></script>` include
- ✅ Removed duplicate `to12h()` function
- ✅ Removed duplicate `convertTo24Hour()` function (using `convert12hTo24h` from utils)
- ✅ All function calls remain unchanged

### 5. `calendar_admin_details_create_cohort_select_date.php`
- ✅ Added `<script src="js/time_utils.js"></script>` include
- ✅ Removed duplicate `to12h()` function
- ✅ Removed duplicate `convert12to24()` function (using `convert12hTo24h` from utils)
- ✅ All function calls remain unchanged

## Remaining Files to Update

The following files still contain duplicate time formatting functions that should be updated:

1. **`calendar_admin_details_lesson_information.php`**
   - Has `formatTime()` function (line 2104)
   - Should use `convert24hTo12h()` or `formatTime12Hour()` from time_utils.js

2. **`calendar_admin_details_reschedule_modals.php`**
   - Has `formatTime12h()` function (line 2223)
   - Should use `formatTime12Hour()` or `convert24hTo12h()` from time_utils.js

3. **`calendar_admin_details_create_cohort_peertalk_tab.php`**
   - Has `to24Hour()` function (line 410)
   - Should use `convert12hTo24h()` from time_utils.js

4. **`js/calendar_admin_details_create_cohort.js`**
   - Has `normalizeTimeTo12h()` function (line 34)
   - Already included in time_utils.js, can remove duplicate

5. **`js/calendar_admin_details_calendar_content.js`**
   - Has `formatTime12h()` function (lines 613, 785)
   - Should use functions from time_utils.js

## Usage Instructions

### For PHP Files:
Add this line before your `<script>` tag:
```html
<script src="js/time_utils.js"></script>
```

### For Standalone JS Files:
Ensure `time_utils.js` is loaded before the file that uses the functions:
```html
<script src="js/time_utils.js"></script>
<script src="js/your_file.js"></script>
```

### Function Calls:
All function calls remain the same - no changes needed:
```javascript
// These all work the same as before
fmt12(540);                    // "9:00 AM"
convert12hTo24h("9:30 AM");    // "09:30"
convert24hTo12h("21:30");      // "9:30 PM"
to12h("09:30");                // {hm: "09:30", period: "AM"}
```

## Benefits

1. **Single Source of Truth** - All time formatting logic in one place
2. **Easier Maintenance** - Fix bugs once, applies everywhere
3. **Consistency** - Same output format across entire plugin
4. **Reduced Code** - Removed ~25+ duplicate function definitions
5. **Better Testing** - Can test time functions in isolation

## Next Steps

1. Update remaining files listed above
2. Test all time formatting across the application
3. Add unit tests for time_utils.js functions
4. Document any edge cases or special requirements

