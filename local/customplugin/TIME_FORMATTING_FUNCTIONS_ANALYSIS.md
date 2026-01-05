# Time Formatting Functions Analysis - Custom Plugin

## Summary
This document lists all time formatting functions found in the custom plugin that perform similar/duplicate operations.

---

## 1. **fmt12** - Convert minutes to 12-hour format (HH:MM AM/PM)
**Purpose:** Converts minutes from midnight to 12-hour format string

### Duplicates Found:
1. **`js/calendar_admin_details_calendar_content.js`** (Line 134)
   ```javascript
   function fmt12(min) {
     let h = Math.floor(min / 60), m = min % 60;
     h = h % 24;
     const ap = h >= 12 ? "PM" : "AM";
     const dispH = h % 12 || 12;
     return `${dispH}:${pad2(m)} ${ap}`;
   }
   ```

2. **`calendar_admin_details_agenda_tab.php`** (Line 195)
   ```javascript
   function fmt12(min) {
     let h = Math.floor(min / 60), m = min % 60;
     if (h >= 24) h -= 24;
     const ap = h >= 12 ? 'PM' : 'AM';
     const dispH = h % 12 || 12;
     return `${dispH}:${pad2(m)} ${ap}`;
   }
   ```

3. **`js/calendar_admin_details_calendar_content.js`** (Line 2751) - Inside another function
   ```javascript
   function fmt12(min) {
     let h = Math.floor(min / 60), m = min % 60;
     if (h >= 24) h -= 24;
     const ap = h >= 12 ? "PM" : "AM";
     const dispH = h % 12 || 12;
     return `${dispH}:${pad2(m)} ${ap}`;
   }
   ```

**Total: 3 instances** (2 identical, 1 with slight variation in hour normalization)

---

## 2. **convert12hTo24h / convertTo24Hour / to24Hour** - Convert 12-hour to 24-hour format
**Purpose:** Converts "HH:MM AM/PM" to "HH:MM" (24-hour)

### Duplicates Found:
1. **`calendar_admin_details_create_cohort_manage_class_tab.php`** (Line 1830)
   ```javascript
   function convert12hTo24h(time12h) {
     const [time, period] = time12h.split(' ');
     let [hours, minutes] = time.split(':');
     hours = parseInt(hours);
     if (period === 'PM' && hours < 12) hours += 12;
     if (period === 'AM' && hours === 12) hours = 0;
     return `${String(hours).padStart(2, '0')}:${minutes}`;
   }
   ```

2. **`calendar_admin_details_create_cohort_class_tab.php`** (Line 1941)
   ```javascript
   function convertTo24Hour(time12h) {
     const [time, period] = time12h.split(' ');
     let [hours, minutes] = time.split(':');
     hours = parseInt(hours);
     minutes = parseInt(minutes);
     if (period.toUpperCase() === 'PM' && hours < 12) hours += 12;
     if (period.toUpperCase() === 'AM' && hours === 12) hours = 0;
     return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
   }
   ```

3. **`calendar_admin_details_create_cohort_peertalk_tab.php`** (Line 410)
   ```javascript
   function to24Hour(timeStr) {
     const match = timeStr.match(/^(\d{1,2}):(\d{2})\s*([APMapm]{2})$/);
     let hour = parseInt(match[1], 10);
     const ampm = match[3].toUpperCase();
     if (ampm === 'PM' && hour !== 12) hour += 12;
     if (ampm === 'AM' && hour === 12) hour = 0;
     return String(hour).padStart(2, '0') + ':' + minute;
   }
   ```

4. **`calendar_admin_details_create_cohort_select_date.php`** (Line 1249)
   ```javascript
   function convert12to24(timeStr) {
     const match = timeStr.match(/^(\d{1,2}):(\d{2})(?:\s*(AM|PM))?$/i);
     let h = parseInt(match[1], 10);
     const period = (match[3] || 'AM').toUpperCase();
     if (period === 'PM' && h !== 12) h += 12;
     if (period === 'AM' && h === 12) h = 0;
     return `${String(h).padStart(2, '0')}:${m}`;
   }
   ```

**Total: 4 instances** (similar logic, different implementations)

---

## 3. **convert24hTo12h / to12h / formatTime12h** - Convert 24-hour to 12-hour format
**Purpose:** Converts "HH:MM" (24-hour) to "HH:MM AM/PM"

### Duplicates Found:
1. **`calendar_admin_details_create_cohort_manage_class_tab.php`** (Line 1847)
   ```javascript
   function convert24hTo12h(time24h) {
     const [hours, minutes] = time24h.split(':');
     let hour = parseInt(hours);
     const period = hour >= 12 ? 'PM' : 'AM';
     hour = hour % 12;
     if (hour === 0) hour = 12;
     return `${hour}:${minute} ${period}`;
   }
   ```

2. **`calendar_admin_details_create_cohort_class_tab.php`** (Line 968)
   ```javascript
   function to12h(hhmm) {
     let t = hhmm.trim().toUpperCase();
     if (/AM|PM/.test(t)) {
       // Already 12h format
       let [hm, period] = t.split(/\s+/);
       return {hm: `${h}:${m}`, period};
     } else {
       // 24h -> 12h
       let [h, m] = t.split(':').map(Number);
       let period = h >= 12 ? 'PM' : 'AM';
       h = h % 12; if (h === 0) h = 12;
       return {hm: `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}`, period};
     }
   }
   ```

3. **`calendar_admin_details_create_cohort_select_date.php`** (Line 655)
   ```javascript
   function to12h(hhmm) {
     // IDENTICAL to #2 above
     let t = hhmm.trim().toUpperCase();
     if (/AM|PM/.test(t)) {
       let [hm, period] = t.split(/\s+/);
       let [h, m] = hm.split(':').map(s => s.padStart(2, '0'));
       return {hm: `${h}:${m}`, period};
     } else {
       let [h, m] = t.split(':').map(Number);
       let period = h >= 12 ? 'PM' : 'AM';
       h = h % 12; if (h === 0) h = 12;
       return {hm: `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}`, period};
     }
   }
   ```

4. **`js/calendar_admin_details_calendar_content.js`** (Line 613 & 785) - Two instances
   ```javascript
   function formatTime12h(time24) {
     // Complex function that handles both 12h and 24h input
     // Returns {time: "HH:MM", period: "AM/PM"}
   }
   ```

5. **`calendar_admin_details_lesson_information.php`** (Line 2104)
   ```javascript
   function formatTime(timeStr) {
     const [hours, minutes] = timeStr.split(':').map(Number);
     const ampm = hours >= 12 ? 'PM' : 'AM';
     const displayHours = hours % 12 || 12;
     return `${String(displayHours).padStart(2, '0')}:${String(minutes).padStart(2, '0')} ${ampm}`;
   }
   ```

6. **`calendar_admin_details_reschedule_modals.php`** (Line 2223)
   ```javascript
   function formatTime12h(t) {
     // Handles both string and Date object
     var ampm = h >= 12 ? 'PM' : 'AM';
     var hh = h % 12; if (hh === 0) hh = 12;
     return hh + ':' + String(m).padStart(2, '0') + ' ' + ampm;
   }
   ```

7. **`calendar_admin_details_create_cohort_manage_class_tab.php`** (Line 1952)
   ```javascript
   function formatTime12Hour(date) {
     let hours = date.getHours();
     let minutes = date.getMinutes();
     const ampm = hours >= 12 ? 'PM' : 'AM';
     hours = hours % 12; hours = hours ? hours : 12;
     minutes = minutes < 10 ? '0' + minutes : minutes;
     return `${hours}:${minutes} ${ampm}`;
   }
   ```

8. **`calendar_admin_details_create_cohort_manage_class_tab.php`** (Line 1964)
   ```javascript
   function formatTime12HourFromParts(hours, minutes) {
     const ampm = hours >= 12 ? 'PM' : 'AM';
     hours = hours % 12; hours = hours ? hours : 12;
     minutes = minutes < 10 ? '0' + minutes : minutes;
     return `${hours}:${minutes} ${ampm}`;
   }
   ```

9. **`js/calendar_admin_details_create_cohort.js`** (Line 34)
   ```javascript
   function normalizeTimeTo12h(inputRaw) {
     // Complex function that normalizes various time formats to "HH:MM AM/PM"
   }
   ```

**Total: 9+ instances** (various implementations with similar logic)

---

## 4. **minutes / timeToMinutes** - Convert time string to minutes
**Purpose:** Converts "HH:MM" to minutes from midnight

### Duplicates Found:
1. **`js/calendar_admin_details_calendar_content.js`** (Line 145)
   ```javascript
   function minutes(hhmm) {
     const [h, m] = hhmm.split(":").map(Number);
     return h * 60 + m;
   }
   ```

2. **`calendar_admin_details_agenda_tab.php`** (Line 204)
   ```javascript
   function minutes(hhmm) {
     const [h, m] = hhmm.split(':').map(Number);
     return h * 60 + m;
   }
   ```

3. **`js/calendar_admin_details_calendar_content.js`** (Line 2984)
   ```javascript
   function timeToMinutes(time) {
     // Similar logic
   }
   ```

4. **`calendar_admin_details_agenda_tab.php`** (Line 549)
   ```javascript
   function timeToMinutes(timeStr) {
     // Similar logic
   }
   ```

**Total: 4+ instances**

---

## 5. **formatTime12Hour / formatTime12HourFromParts** - Format time from Date or parts
**Purpose:** Formats time from Date object or hour/minute parts to 12-hour format

### Duplicates Found:
1. **`calendar_admin_details_create_cohort_manage_class_tab.php`** (Line 1952)
   ```javascript
   function formatTime12Hour(date) {
     // Takes Date object
   }
   ```

2. **`calendar_admin_details_create_cohort_manage_class_tab.php`** (Line 1964)
   ```javascript
   function formatTime12HourFromParts(hours, minutes) {
     // Takes hour and minute numbers
   }
   ```

**Note:** These are in the same file and could be consolidated

---

## Recommendations:

1. **Create a centralized time utility file** (e.g., `js/time_utils.js`) with:
   - `fmt12(minutes)` - Convert minutes to 12h format
   - `convert12hTo24h(time12h)` - Convert 12h to 24h
   - `convert24hTo12h(time24h)` - Convert 24h to 12h
   - `timeToMinutes(timeStr)` - Convert time string to minutes
   - `minutesToTime(minutes)` - Convert minutes to time string

2. **Replace all duplicate functions** with imports from the utility file

3. **Standardize function names** across the codebase

4. **Add unit tests** for the centralized functions

---

## Total Count Summary:
- **fmt12**: 3 instances
- **12h to 24h conversion**: 4 instances
- **24h to 12h conversion**: 9+ instances
- **Time to minutes**: 4+ instances
- **Other formatting functions**: 5+ instances

**Grand Total: ~25+ duplicate/similar time formatting functions**

