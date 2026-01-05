# API Utils Implementation Summary

## Created Files

### `js/api_utils.js`
Centralized API/fetch utility file containing:
- `apiFetch(url, options)` - Generic fetch with error handling
- `apiPost(url, data, options)` - POST request helper
- `apiPostForm(url, data, options)` - POST with form data
- `apiGet(url, params, options)` - GET request helper
- `fetchJSON(url, options)` - Simple JSON fetch
- `isSuccess(response)` - Check if response is successful
- `getErrorMessage(response)` - Get error message from response

All functions are exposed globally and also under `window.ApiUtils` namespace.

## Updated Files

### 1. `calendar_admin_details.php`
- ✅ Added `<script src="js/api_utils.js"></script>`
- ✅ Ensures API utilities are available before they're used

### 2. `js/calendar_admin_details_calendar_content.js`
- ✅ Updated `fetchJSON()` to use centralized version when available
- ✅ Maintains fallback implementation for backward compatibility

### 3. `calendar_admin_details_create_cohort_manage_class_tab.php`
- ✅ Added `<script src="js/api_utils.js"></script>`
- ✅ Can now use ApiUtils for API calls

### 4. `calendar_admin_details_create_cohort_manage_cohort.php`
- ✅ Added `<script src="js/api_utils.js"></script>`
- ✅ Can now use ApiUtils for API calls

## Implementation Details

### Features:
- **Automatic Session Key** - Adds sesskey to requests automatically
- **Error Handling** - Consistent error handling across all API calls
- **JSON Parsing** - Safe JSON parsing with error handling
- **HTTP Status Checking** - Checks response.ok and HTTP status codes
- **Response Validation** - Checks for `ok: false`, `success: false`, or `error` fields
- **Loader Integration** - Optional loader show/hide support
- **Timeout Support** - Configurable request timeout (default: 30s)
- **Base URL Detection** - Automatically detects Moodle base URL
- **Form Data Support** - Handles both JSON and form-encoded data

### Response Format:
All API functions return a consistent response format:
```javascript
{
    ok: true/false,
    data: {...},      // Response data (if ok)
    error: "...",     // Error message (if not ok)
    status: 200,      // HTTP status code
    type: "network"   // Error type (if applicable)
}
```

### Configuration Options:
- `credentials` (default: 'same-origin') - Fetch credentials
- `headers` (default: JSON headers) - Request headers
- `timeout` (default: 30000ms) - Request timeout
- `showLoader` (default: false) - Show loader before request
- `hideLoader` (default: false) - Hide loader after request

## Usage Examples

### Basic GET Request:
```javascript
const response = await ApiUtils.get('get_events.php', { date: '2025-01-15' });
if (response.ok) {
    console.log('Data:', response.data);
} else {
    console.error('Error:', response.error);
}
```

### POST with JSON:
```javascript
const response = await ApiUtils.post('update_one2one.php', {
    eventId: 123,
    teacherId: 456
}, {
    showLoader: true,
    hideLoader: true
});

if (ApiUtils.isSuccess(response)) {
    showToast('Success!', 'success');
} else {
    showToast(ApiUtils.getErrorMessage(response), 'error');
}
```

### POST with Form Data:
```javascript
const response = await ApiUtils.postForm('create_cohort.php', {
    name: 'Cohort Name',
    idnumber: 'COH001'
});
```

### Simple JSON Fetch:
```javascript
const data = await fetchJSON('ajax/get_data.php');
if (data.ok) {
    // Use data
} else {
    // Handle error
}
```

## Files That Can Be Updated (Gradual Migration)

These files have fetch/ajax calls that can be migrated to use ApiUtils:
- `calendar_admin_details_create_cohort_manage_class_tab.php` - Multiple fetch calls
- `calendar_admin_details_create_cohort_manage_cohort.php` - Fetch calls
- `calendar_admin_details_create_cohort_class_tab.php` - Fetch calls
- `calendar_admin_details_create_cohort_conference_tab.php` - Fetch calls
- `calendar_admin_details_create_cohort_peertalk_tab.php` - Fetch calls
- `calendar_admin_details_lesson_information.php` - Fetch calls
- Other files with fetch/ajax patterns

**Note:** Migration can be done gradually. Existing code continues to work.

## Backward Compatibility

- All existing fetch/ajax code continues to work
- ApiUtils provides a modern alternative without breaking existing code
- `fetchJSON()` in calendar_content.js uses centralized version when available
- Fallback implementations ensure compatibility

## Benefits

1. **Consistency** - Unified API call patterns across the application
2. **Error Handling** - Consistent error handling and response format
3. **Session Management** - Automatic sesskey handling
4. **Loader Integration** - Optional loader management
5. **Type Safety** - Consistent response format makes error handling easier
6. **Maintainability** - Single source of truth for API call logic
7. **Features** - Timeout, form data, automatic base URL detection

## Testing Recommendations

Test API calls in:
- Calendar event fetching
- 1:1 lesson updates
- Cohort management
- Conference creation
- Peer Talk creation
- All areas using fetch/ajax

## Notes

- ApiUtils is designed to work alongside existing fetch/ajax code
- Migration can be done gradually, file by file
- The utility automatically handles Moodle-specific requirements (sesskey, base URL)
- Response format is consistent, making error handling easier
- Loader integration is optional and can be enabled per request

