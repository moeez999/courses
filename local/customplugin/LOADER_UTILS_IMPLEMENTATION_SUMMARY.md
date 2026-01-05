# Loader Utils Implementation Summary

## Created Files

### `js/loader_utils.js`
Centralized loader/spinner utility file containing:
- `showGlobalLoader()` - Show loader with minimum display time (3 seconds)
- `hideGlobalLoader()` - Hide loader (respects minimum time)
- `forceHideGlobalLoader()` - Force hide loader immediately (bypasses minimum time)
- `isLoaderVisible()` - Check if loader is currently visible

All functions are exposed globally and also under `window.LoaderUtils` namespace.

## Updated Files

### 1. `calendar_admin_details_reschedule_modals.php`
- ✅ Added `<script src="js/loader_utils.js"></script>`
- ✅ Removed duplicate `showGlobalLoader()` and `hideGlobalLoader()` functions
- ✅ Now uses centralized loader functions

### 2. `js/calendar_admin_details_calendar_content.js`
- ✅ Updated to use centralized loader from `loader_utils.js`
- ✅ Added fallback implementation if `loader_utils.js` is not loaded
- ✅ Maintains backward compatibility

### 3. `calendar_admin_details.php`
- ✅ Added `<script src="js/loader_utils.js"></script>` before `calendar_admin_details_calendar_content.js`
- ✅ Ensures loader utilities are available before they're used

## Files Using Global Loader Functions (No Changes Needed)

These files already use the global `showGlobalLoader()` and `hideGlobalLoader()` functions and will automatically use the centralized version:
- `calendar_admin_details_lesson_information.php` - Uses `window.showGlobalLoader()` and `window.hideGlobalLoader()`
- All other files that call these functions

## Files with Inline Loader Code (Not Changed - Different Context)

These files have inline loader code but use different loader elements or contexts:
- `calendar_admin_details_create_cohort_manage_class_tab.php` - Uses `#loaderOverlay` (different element)
- `calendar_admin_details_create_cohort_manage_cohort.php` - Uses local `loader` variable
- `calendar_admin_details_setup_availablity_details.php` - Uses local `loader` variable
- `calendar_admin_details_create_cohort.php` - Uses local `loader` variable
- `calendar_admin_details_create_cohort_class_tab.php` - Uses local `loader` variable

**Note:** These files use different loader elements or local variables, so they don't need to be updated to use the global loader. They can continue using their local implementations.

## Implementation Details

### Loader Element:
- Element ID: `#loader`
- Default display: `flex`
- Z-index: `99999` when visible
- Minimum display time: 3000ms (3 seconds)

### Features:
- Automatic minimum display time enforcement
- Smooth show/hide transitions
- jQuery and vanilla JS support
- Fallback implementation in calendar_content.js
- Force hide capability for emergency cases
- Visibility check function

## Backward Compatibility

All existing function calls continue to work:
- `showGlobalLoader()` → uses centralized version
- `hideGlobalLoader()` → uses centralized version
- Files with local loader implementations continue to work independently

## Benefits

1. **Consistency** - All global loader usage now has consistent behavior
2. **Maintainability** - Single source of truth for loader functionality
3. **Minimum Display Time** - Ensures loader is visible long enough to be seen
4. **Error Handling** - Better error handling and fallbacks
5. **Code Reduction** - Removed duplicate loader code from reschedule_modals.php

## Testing Recommendations

Test loader functionality in:
- Calendar event fetching
- Reschedule modals
- Lesson information updates
- All areas using `showGlobalLoader()` and `hideGlobalLoader()`

## Notes

- The loader has a minimum display time of 3 seconds to ensure users see it
- If `loader_utils.js` is not loaded, `calendar_admin_details_calendar_content.js` has a fallback
- Files with local loader variables (different contexts) are intentionally left unchanged
- The centralized loader only manages the global `#loader` element

