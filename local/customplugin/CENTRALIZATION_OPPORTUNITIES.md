# Calendar Admin - Centralization Opportunities

This document identifies functionality that can be centralized across the calendar admin plugin.

## ✅ Already Centralized

1. **Time Formatting** - `js/time_utils.js`
2. **Date Formatting** - `js/date_utils.js`

## 🔍 Opportunities for Centralization

### 1. Toast/Notification Functions (HIGH PRIORITY)

**Current State:**
- `showToastManage()` in `calendar_admin_details_create_cohort_manage_class_tab.php` (line 1707)
- `showToastCreateClass()` in `calendar_admin_details_create_cohort_class_tab.php` (line 1376)
- `showToast()` in `calendar_admin_details_lesson_information.php` (line 2077)
- Inline toast implementations in multiple files
- Various toast styles and implementations

**Recommendation:**
Create `js/toast_utils.js` with:
- `showToast(message, type, duration)` - Unified toast function
- `hideToast()` - Hide toast
- Support for success, error, warning, info types
- Consistent styling and positioning

**Files Affected:** ~8-10 files

---

### 2. Loader/Spinner Functions (MEDIUM PRIORITY)

**Current State:**
- `showGlobalLoader()` / `hideGlobalLoader()` in `js/calendar_admin_details_calendar_content.js` (lines 4230, 4240)
- Duplicate `showGlobalLoader()` / `hideGlobalLoader()` in `calendar_admin_details_reschedule_modals.php` (lines 799, 809)
- Inline loader show/hide code in various files
- Different implementations with same purpose

**Recommendation:**
Create `js/loader_utils.js` with:
- `showGlobalLoader()` - Show loader with minimum display time
- `hideGlobalLoader()` - Hide loader (respects minimum time)
- `setLoaderDisplay(display)` - Internal helper
- Consistent 3-second minimum display logic

**Files Affected:** ~5-7 files

---

### 3. Modal/Backdrop Management (MEDIUM PRIORITY)

**Current State:**
- `openBackdrop()`, `closeAll()` in `calendar_admin_details_lesson_information.php`
- Various modal open/close functions across files
- Backdrop fade in/out patterns repeated
- Body overflow management duplicated

**Recommendation:**
Create `js/modal_utils.js` with:
- `openModal(modalId, options)` - Open modal with backdrop
- `closeModal(modalId)` - Close modal
- `closeAllModals()` - Close all open modals
- `toggleModal(modalId)` - Toggle modal state
- Automatic backdrop management
- Body overflow handling

**Files Affected:** ~10-12 files

---

### 4. Form Validation Helpers (MEDIUM PRIORITY)

**Current State:**
- `validateForm()`, `validateTeacherSelection()`, `validateStudentSelection()` in multiple files
- Field error highlighting patterns repeated
- Required field checking logic duplicated
- Date validation patterns repeated

**Recommendation:**
Create `js/validation_utils.js` with:
- `validateRequired(field, message)` - Check required fields
- `highlightField(field, isValid)` - Add/remove error styling
- `validateDate(field, options)` - Date validation
- `validateTime(field, options)` - Time validation
- `clearFieldErrors(form)` - Clear all errors
- `getFormErrors(form)` - Collect all validation errors

**Files Affected:** ~8-10 files

---

### 5. API/Fetch Helpers (LOW PRIORITY)

**Current State:**
- `fetchJSON()` in `js/calendar_admin_details_calendar_content.js` (line 4180)
- Various fetch/ajax patterns with similar error handling
- Different error handling approaches

**Recommendation:**
Create `js/api_utils.js` with:
- `apiFetch(url, options)` - Unified fetch with error handling
- `apiPost(url, data)` - POST request helper
- `apiGet(url, params)` - GET request helper
- Consistent error handling and response parsing
- Automatic loader management option

**Files Affected:** ~15-20 files

---

### 6. Calendar Utility Functions (LOW PRIORITY)

**Current State:**
- `daysInMonth()` in `calendar_admin_reschedule_calendar_modal.php` (line 166)
- `daysInMonth()` in `js/calendar_admin_details_create_cohort_merge_tab.js` (line 55)
- Calendar rendering logic patterns

**Recommendation:**
Add to `js/date_utils.js`:
- `daysInMonth(year, month)` - Get days in month
- `getFirstDayOfMonth(year, month)` - Get first day of month
- `isLeapYear(year)` - Check leap year
- `getWeekNumber(date)` - Get week number

**Files Affected:** ~3-5 files

---

### 7. Widget Rendering Functions (LOW PRIORITY)

**Current State:**
- `renderWidgetTime()` in `calendar_admin_details_create_cohort_class_tab.php` (line 975)
- `renderWidgetTimeManage()` in `calendar_admin_details_create_cohort_manage_class_tab.php` (line 1846)
- `renderWidgetTime()` in `calendar_admin_details_create_cohort_select_date.php` (line 660)
- Similar functionality with slight variations

**Recommendation:**
Create `js/widget_utils.js` with:
- `renderTimeWidget(key, start, end, options)` - Unified time widget renderer
- `renderDayWidget(day, options)` - Day widget renderer
- Configurable styling and behavior

**Files Affected:** ~3-4 files

---

### 8. Debounce/Throttle Functions (LOW PRIORITY)

**Current State:**
- Inline debounce implementations in `js/calendar_admin_details_calendar_content.js`
- `setTimeout` patterns for debouncing
- No centralized debounce/throttle utility

**Recommendation:**
Create `js/debounce_utils.js` with:
- `debounce(func, delay)` - Debounce function calls
- `throttle(func, delay)` - Throttle function calls
- Reusable for search inputs, scroll handlers, etc.

**Files Affected:** ~5-8 files

---

## 📊 Priority Summary

### High Priority (Immediate Impact)
1. **Toast/Notification Functions** - Most duplicated, high visibility
2. **Loader Functions** - Already partially centralized, needs completion

### Medium Priority (Good ROI)
3. **Modal/Backdrop Management** - Reduces code duplication significantly
4. **Form Validation Helpers** - Improves consistency and maintainability

### Low Priority (Nice to Have)
5. **API/Fetch Helpers** - Would improve consistency but lower impact
6. **Calendar Utility Functions** - Small functions, easy to add
7. **Widget Rendering Functions** - Specialized, may have valid differences
8. **Debounce/Throttle Functions** - Useful but not critical

## 🎯 Recommended Implementation Order

1. **Toast Utils** - Quick win, high visibility
2. **Loader Utils** - Complete existing partial centralization
3. **Modal Utils** - Reduces significant duplication
4. **Validation Utils** - Improves code quality
5. **API Utils** - Long-term consistency improvement
6. **Calendar Utils** - Add to existing date_utils.js
7. **Widget Utils** - If variations can be unified
8. **Debounce Utils** - General utility improvement

## 📝 Notes

- Some functions may have valid differences (e.g., widget rendering might need different options)
- Consider backward compatibility when centralizing
- Test thoroughly after each centralization
- Document function parameters and usage clearly

