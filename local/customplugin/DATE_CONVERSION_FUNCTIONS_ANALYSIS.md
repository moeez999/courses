# Date Conversion Functions Analysis

This document lists all date conversion functions found in the custom plugin that perform similar functionality and produce the same output.

## 1. Date to YYYY-MM-DD Format Functions

### Function: `ymd(d)` or `formatYMD(d)`
**Purpose:** Convert Date object to "YYYY-MM-DD" string format

**Locations:**
1. **`js/calendar_admin_details_calendar_content.js`** (line 134)
   ```javascript
   function ymd(d) {
     return `${d.getFullYear()}-${pad2(d.getMonth() + 1)}-${pad2(d.getDate())}`;
   }
   ```

2. **`calendar_admin_details_agenda_tab.php`** (line 196)
   ```javascript
   function ymd(d) {
       return `${d.getFullYear()}-${pad2(d.getMonth() + 1)}-${pad2(d.getDate())}`;
   }
   ```

3. **`js/calendar_admin_details_calendar_content.js`** (line 6023) - Different name, same functionality
   ```javascript
   function formatYMD(d) {
     const y = d.getFullYear();
     const m = String(d.getMonth() + 1).padStart(2, "0");
     const day = String(d.getDate()).padStart(2, "0");
     return `${y}-${m}-${day}`;
   }
   ```

4. **Inline YYYY-MM-DD formatting code** (duplicated in multiple places):
   - `calendar_admin_details_create_cohort_manage_class_tab.php` (lines 2394-2398)
     ```javascript
     const yyyy = resultDate.getUTCFullYear();
     const mm = String(resultDate.getUTCMonth() + 1).padStart(2, '0');
     const dd = String(resultDate.getUTCDate()).padStart(2, '0');
     return `${yyyy}-${mm}-${dd}`;
     ```
   
   - `calendar_admin_details_create_cohort_manage_class_tab.php` (lines 2458-2460)
     ```javascript
     const yyyy = endDate.getFullYear();
     const mm = String(endDate.getMonth() + 1).padStart(2, '0');
     const dd = String(endDate.getDate()).padStart(2, '0');
     ```
   
   - `calendar_admin_details_create_cohort_manage_class_tab.php` (lines 2618-2621)
     ```javascript
     const yyyy = date.getFullYear();
     const mm = String(date.getMonth() + 1).padStart(2, '0');
     const dd = String(date.getDate()).padStart(2, '0');
     dateElement.dataset.fullDate = `${yyyy}-${mm}-${dd}`;
     ```
   
   - `calendar_admin_details_create_cohort_manage_class_tab.php` (lines 3462-3464, 3472-3474, 3565-3567, 3576-3578, 3841-3843, 4106-4109)
     ```javascript
     const yyyy = [dateObj].getFullYear();
     const mm = String([dateObj].getMonth() + 1).padStart(2, '0');
     const dd = String([dateObj].getDate()).padStart(2, '0');
     ```
   
   - `js/calendar_admin_details_calendar_content.js` (line 5657) - inline function
     ```javascript
     const formatYMD = (d) => {
       const y = d.getFullYear();
       const m = String(d.getMonth() + 1).padStart(2, "0");
       const day = String(d.getDate()).padStart(2, "0");
       return `${y}-${m}-${day}`;
     };
     ```

**Total duplicates:** 3 named functions + ~10 inline implementations

---

## 2. Date to "MMM DD, YYYY" Format Functions

### Function: `formatDate(dateObj)`
**Purpose:** Convert Date object to "MMM DD, YYYY" format (e.g., "Jan 15, 2025")

**Locations:**
1. **`calendar_admin_details_create_cohort_manage_class_tab.php`** (line 1930)
   ```javascript
   function formatDate(dateObj) {
       const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
           "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
       ];
       const day = dateObj.getDate().toString().padStart(2, '0');
       return `${months[dateObj.getMonth()]} ${day}, ${dateObj.getFullYear()}`;
   }
   ```

2. **`calendar_admin_details_create_cohort_class_tab.php`** (line 1002)
   ```javascript
   function formatDate(dateObj) {
       const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
       const day = dateObj.getDate().toString().padStart(2, '0');
       return `${months[dateObj.getMonth()]} ${day}, ${dateObj.getFullYear()}`;
   }
   ```

3. **`calendar_admin_details_create_cohort_class_tab.php`** (line 1212) - **DUPLICATE IN SAME FILE**
   ```javascript
   function formatDate(dateObj) {
       const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
       const day = dateObj.getDate().toString().padStart(2, '0');
       return `${months[dateObj.getMonth()]} ${day}, ${dateObj.getFullYear()}`;
   }
   ```

4. **`calendar_admin_details_create_cohort_select_date.php`** (line 689)
   ```javascript
   function formatDate(dateObj) {
       const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
       return `${months[dateObj.getMonth()]} ${pad(dateObj.getDate())},${dateObj.getFullYear()}`;
   }
   ```
   Note: Slight variation - uses `pad()` instead of `padStart(2, '0')` and no space before year

**Total duplicates:** 4 functions (3 identical, 1 with minor variation)

---

## 3. Timestamp to YYYY-MM-DD Format Functions

### Function: `timestampToDate(ts)`
**Purpose:** Convert Unix timestamp (seconds) to "YYYY-MM-DD" string

**Locations:**
1. **`js/calendar_admin_details_calendar_content.js`** (line 510) - inline function
   ```javascript
   function timestampToDate(ts) {
     if (!ts) return "";
     const date = new Date(ts * 1000);
     const year = date.getFullYear();
     const month = String(date.getMonth() + 1).padStart(2, "0");
     const day = String(date.getDate()).padStart(2, "0");
     return `${year}-${month}-${day}`;
   }
   ```

**Note:** This function is only defined once but could be consolidated with `ymd()` if we convert timestamp to Date first.

---

## 4. Timestamp Parsing Functions

### Function: `parseUnixTimestamp(timestamp)`
**Purpose:** Parse Unix timestamp (handles both seconds and milliseconds)

**Locations:**
1. **`calendar_admin_details_create_cohort_manage_class_tab.php`** (line 2401)
   ```javascript
   function parseUnixTimestamp(timestamp) {
       // Handle both seconds and milliseconds timestamps
       const ts = parseInt(timestamp, 10);
       return new Date(ts < 1e12 ? ts * 1000 : ts);
   }
   ```

**Total duplicates:** 1 function (unique, but could be useful in utils)

---

## 5. Other Date Formatting Functions

### Function: `formatDateShort(date)` and `formatDateLong(date)`
**Purpose:** Format dates in different display formats

**Locations:**
1. **`calendar_admin_details_create_cohort_class_tab.php`** (lines 1365, 1369)
   ```javascript
   function formatDateShort(date) {
       return `${dayNames[date.getDay()]}, ${monthNames[date.getMonth()]}${date.getDate()}`;
   }
   
   function formatDateLong(date) {
       return `${monthNames[date.getMonth()]} ${date.getDate().toString().padStart(2, '0')}, ${date.getFullYear()}`;
   }
   ```

**Total duplicates:** 2 unique functions (not duplicated elsewhere)

---

## Summary

### Functions to Consolidate:

1. **YYYY-MM-DD conversion:**
   - `ymd()` - 2 duplicates
   - `formatYMD()` - 1 duplicate
   - Inline YYYY-MM-DD code - ~10 instances
   - **Total: ~13 duplicates**

2. **MMM DD, YYYY conversion:**
   - `formatDate()` - 4 duplicates (3 identical, 1 with minor variation)
   - **Total: 4 duplicates**

3. **Timestamp to Date:**
   - `timestampToDate()` - 1 instance (inline)
   - `parseUnixTimestamp()` - 1 instance (unique)

### Recommended Consolidation:

Create a `date_utils.js` file similar to `time_utils.js` with:
- `ymd(date)` or `formatYMD(date)` - Date to YYYY-MM-DD
- `formatDate(date)` - Date to "MMM DD, YYYY"
- `timestampToDate(ts)` - Timestamp to YYYY-MM-DD
- `parseUnixTimestamp(ts)` - Parse timestamp (seconds/milliseconds)
- `formatDateShort(date)` - Short format (if needed globally)
- `formatDateLong(date)` - Long format (if needed globally)

**Total duplicate functions found: ~17 instances**

