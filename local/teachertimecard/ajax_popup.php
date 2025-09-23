<?php
/**
 * Local plugin "Teacher Timecard" - AJAX endpoint for popup data
 * 
 * @package    local_teachertimecard
 * @copyright  2024 Your Name <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__.'/../../config.php');
require_once(__DIR__.'/lib.php');

// Require login and capabilities
require_login();
$context = context_system::instance();

// Get parameters
$date = required_param('date', PARAM_TEXT);
$teacherid = required_param('teacherid', PARAM_INT);

// Get teacher rates
$rates = get_teacher_rates($teacherid);

// Get paid session IDs for this teacher and date
$paid_session_ids = $DB->get_fieldset_sql("
    SELECT ps.session_id 
    FROM {local_teachertimecard_paid_sessions} ps
    JOIN {local_teachertimecard_payments} p ON ps.payment_id = p.id
    WHERE p.teacherid = :teacherid 
    AND p.status = 'completed'
    AND ps.session_date = :session_date
", [
    'teacherid' => $teacherid,
    'session_date' => $date
]);

// Check if this is a save operation for removed sessions
$save_removed = optional_param('save_removed', 0, PARAM_INT);
if ($save_removed) {
    $removed_sessions = optional_param('removed_sessions', '', PARAM_TEXT);
    $removed_session_data = optional_param('removed_session_data', '', PARAM_TEXT);
    save_removed_sessions($teacherid, $date, $removed_sessions, $removed_session_data);
    echo json_encode(['success' => true, 'message' => 'Removed sessions saved successfully']);
    exit;
}

// Get sessions for the specific date
$start_date = strtotime($date);
$end_date = strtotime($date . ' +1 day') - 1; // End of the day

$sessions = get_cohort_meet_activities($teacherid, $start_date, $end_date);
$day_data = $sessions['days'][$date] ?? null;

if (!$day_data) {
    echo json_encode(['error' => 'No data found for this date']);
    exit;
}

// Get already removed sessions from database
$removed_sessions_data = get_removed_sessions($teacherid, $date);

// Get participant counts for all sessions in bulk WITH DATE FILTERING
$session_participant_counts = [];
$all_sessions = array_merge($day_data['main_sessions'], $day_data['practice_sessions']); 

if (!empty($all_sessions)) {
    $meeting_codes = [];
    
    foreach ($all_sessions as $session) {
        $meeting_codes[] = $session->meeting_code;
    }
    
    // Remove duplicates
    $meeting_codes = array_unique($meeting_codes);
    
    // Get participant counts in a single query WITH DATE FILTER
    list($meeting_sql, $meeting_params) = $DB->get_in_or_equal($meeting_codes);
    
    $participant_sql = "SELECT meeting_code, COUNT(DISTINCT identifier) as participant_count
                    FROM {google_meet_activities}
                    WHERE meeting_code $meeting_sql
                    AND DATE(activity_time) = ?
                    AND identifier != organizer_email
                    GROUP BY meeting_code ";

    $participant_params = array_merge($meeting_params, [$date]);
    $participant_results = $DB->get_records_sql($participant_sql, $participant_params);
    
    // Create a lookup map
    foreach ($participant_results as $result) {
        $key = $result->meeting_code;
        $session_participant_counts[$key] = $result->participant_count;
    }
}

// Get cohort student counts in bulk
$cohort_student_counts = [];
$cohort_idnumbers = [];

// Collect cohort ID numbers from sessions
foreach ($all_sessions as $session) {
    $meeting_parts = explode('-', $session->meeting_type);
    if (count($meeting_parts) >= 2) {
        $cohort_idnumber = $meeting_parts[0] . '-' . $meeting_parts[1];
        if (!in_array($cohort_idnumber, $cohort_idnumbers)) {
            $cohort_idnumbers[] = $cohort_idnumber;
        }
    }
}

if (!empty($cohort_idnumbers)) {
    // Create LIKE conditions for each cohort idnumber
    $like_conditions = [];
    $params = [];
    
    foreach ($cohort_idnumbers as $idnumber) {
        $like_conditions[] = "c.idnumber LIKE ?";
        $params[] = $idnumber . '%';
    }
    
    $like_sql = implode(' OR ', $like_conditions);
    
    $student_sql = "SELECT c.idnumber, COUNT(DISTINCT cm.userid) as student_count
                    FROM {cohort} c
                    JOIN {cohort_members} cm ON c.id = cm.cohortid
                    WHERE ($like_sql)
                    GROUP BY c.idnumber";
    
    $cohort_results = $DB->get_records_sql($student_sql, $params);
    
    // Create lookup array by cohort idnumber
    foreach ($cohort_results as $result) {
        $cohort_idnumber_parts = explode('-', $result->idnumber);
        $tcohort_idnumber = $cohort_idnumber_parts[0] . '-' . $cohort_idnumber_parts[1];
        $cohort_student_counts[$tcohort_idnumber] = $result->student_count;
    }
}

// Format the date for display
$date_obj = new DateTime($date);
$day_name = $date_obj->format('D');
$day_num = $date_obj->format('j');
$month_name = $date_obj->format('M');
$year = $date_obj->format('Y');
$ordinal_suffix = get_ordinal_suffix($day_num);
$popup_date = "{$day_num}{$ordinal_suffix} {$month_name} {$year}";

// Generate popup rows
$popup_rows = '';
$removed_rows = '';

// Process main sessions
foreach ($day_data['main_sessions'] as $session) {
    $session_id = "session_" . $session->id;
    $is_removed = isset($removed_sessions_data[$session_id]);
    $is_paid = in_array($session->id, $paid_session_ids);
    
    // Get participant count from our pre-loaded data
    $participant_key = $session->meeting_code;
    $participant_count = $session_participant_counts[$participant_key] ?? 0;
    
    // Get cohort idnumber and student count
    $meeting_parts = explode('-', $session->meeting_type);
    $cohort_idnumber = '';
    $student_count = 0;
    if (count($meeting_parts) >= 2) {
        $cohort_idnumber = $meeting_parts[0] . '-' . $meeting_parts[1];
        $student_count = $cohort_student_counts[$cohort_idnumber] ?? 0;
    }
    
    $duration_mins = round($session->duration_seconds / 60);
    $duration_hours = $session->duration_seconds / 3600;
    $prefix = count($meeting_parts) > 0 ? strtoupper($meeting_parts[0]) : '';
    $time = date('H:i', $session->start_timestamp);
    
    // Calculate amount based on session type and rate
    $amount = round($duration_hours) * $rates['group_rate'];
    $formatted_amount = number_format($amount, 2);
    
    if ($is_removed) {
        // Use stored data for removed sessions
        $stored_data = $removed_sessions_data[$session_id];
        $duration_mins = $stored_data['duration'];
        $participant_count = $stored_data['attendance'];
        $student_count = $stored_data['student_count'];
        $payable = $stored_data['payable'];
        $amount = $stored_data['amount'];
        
        $removed_rows .= "
        <tr>
            <td></td>
            <td><div class='table-popup-dot'>$prefix</div></td>
            <td>{$duration_mins} min</td>
            <td>{$participant_count}/{$student_count}</td>
            <td>{$payable}</td>
            <td>\$ {$amount}</td>
            <td class='popup-note'>
                <div class='popup-note-container'>
                    <img src='./assets/note.svg' alt='note' class='popup-note-icon' />
                </div>
            </td>
        </tr>";
    } else {
        // Determine payable status and amount display
        $payable_display = $is_paid ? 'Paid' : 'Yes';
        $amount_display = $is_paid ? "\$ {$formatted_amount}" : "\$ -";
        $paid_class = $is_paid ? ' paid-session' : '';
        
        $popup_rows .= "
        <tr class='{$paid_class}'>
            <td>
                " . (!$is_paid ? "<input type='checkbox' class='session-checkbox remove-checkbox' name='remove_sessions[]' value='{$session_id}' data-session-id='{$session_id}' style='display:none'>" : "") . "
            </td>
            <td><div class='table-popup-dot'>$prefix" . ($is_paid ? " ✓" : "") . "</div></td>
            <td>{$duration_mins} min</td>
            <td>{$participant_count}/{$student_count}</td>
            <td>{$payable_display}</td>
            <td>{$amount_display}</td>
            <td class='popup-note'>
                <div class='popup-note-container'>
                    <img src='./assets/note.svg' alt='note' class='popup-note-icon' />
                </div>
            </td>
        </tr>";
    }
}

// Process practice sessions
foreach ($day_data['practice_sessions'] as $session) {
    $session_id = "session_" . $session->id;
    $is_removed = isset($removed_sessions_data[$session_id]);
    $is_paid = in_array($session->id, $paid_session_ids);
    
    // Get participant count from our pre-loaded data
    $participant_key = $session->meeting_code;
    $participant_count = $session_participant_counts[$participant_key] ?? 0;
    
    // Get cohort idnumber and student count
    $meeting_parts = explode('-', $session->meeting_type);
    $cohort_idnumber = '';
    $student_count = 0;
    if (count($meeting_parts) >= 2) {
        $cohort_idnumber = $meeting_parts[0] . '-' . $meeting_parts[1];
        $student_count = $cohort_student_counts[$cohort_idnumber] ?? 0;
    }
    
    $duration_mins = round($session->duration_seconds / 60);
    $duration_hours = $session->duration_seconds / 3600;
    $prefix = count($meeting_parts) > 0 ? strtoupper($meeting_parts[0]) : '';
    $time = date('H:i', $session->start_timestamp);
    
    // Calculate amount based on session type and rate
    $amount = round($duration_hours) * $rates['group_rate'];
    $formatted_amount = number_format($amount, 2);
    
    if ($is_removed) {
        // Use stored data for removed sessions
        $stored_data = $removed_sessions_data[$session_id];
        $duration_mins = $stored_data['duration'];
        $participant_count = $stored_data['attendance'];
        $student_count = $stored_data['student_count'];
        $payable = $stored_data['payable'];
        $amount = $stored_data['amount'];
        
        $removed_rows .= "
        <tr>
            <td></td>
            <td><div class='table-popup-dot practice-dot'>$prefix</div></td>
            <td>{$duration_mins} min</td>
            <td>{$participant_count}/{$student_count}</td>
            <td>{$payable}</td>
            <td>\$ {$amount}</td>
            <td class='popup-note'>
                <div class='popup-note-container'>
                    <img src='./assets/note.svg' alt='note' class='popup-note-icon' />
                </div>
            </td>
        </tr>";
    } else {
        // Determine payable status and amount display
        $payable_display = $is_paid ? 'Paid' : 'Yes';
        $amount_display = $is_paid ? "\$ {$formatted_amount}" : "\$ -";
        $paid_class = $is_paid ? ' paid-session' : '';
        
        $popup_rows .= "
        <tr class='{$paid_class}'>
            <td>
                " . (!$is_paid ? "<input type='checkbox' class='session-checkbox remove-checkbox' name='remove_sessions[]' value='{$session_id}' data-session-id='{$session_id}' style='display:none'>" : "") . "
            </td>
            <td><div class='table-popup-dot practice-dot'>$prefix" . ($is_paid ? " ✓" : "") . "</div></td>
            <td>{$duration_mins} min</td>
            <td>{$participant_count}/{$student_count}</td>
            <td>{$payable_display}</td>
            <td>{$amount_display}</td>
            <td class='popup-note'>
                <div class='popup-note-container'>
                    <img src='./assets/note.svg' alt='note' class='popup-note-icon' />
                </div>
            </td>
        </tr>";
    }
}

// Calculate total hours and minutes (only for non-removed and non-paid sessions)
$total_minutes = 0;
$total_amount = 0;

foreach ($day_data['main_sessions'] as $session) {
    $session_id = "session_" . $session->id;
    $is_paid = in_array($session->id, $paid_session_ids);
    
    if (!isset($removed_sessions_data[$session_id]) && !$is_paid) {
        $total_minutes += round($session->duration_seconds / 60);
        $total_amount += round($session->duration_seconds / 3600) * $rates['group_rate'];
    }
}

foreach ($day_data['practice_sessions'] as $session) {
    $session_id = "session_" . $session->id;
    $is_paid = in_array($session->id, $paid_session_ids);
    
    if (!isset($removed_sessions_data[$session_id]) && !$is_paid) {
        $total_minutes += round($session->duration_seconds / 60);
        $total_amount += round($session->duration_seconds / 3600) * $rates['group_rate'];
    }
}

$hours = floor($total_minutes / 60);
$minutes = $total_minutes % 60;
$formatted_time = sprintf("%d:%02d", $hours, $minutes);
$formatted_total_amount = number_format($total_amount, 2);

// Determine overall payment status for the day
$all_sessions = array_merge($day_data['main_sessions'], $day_data['practice_sessions']);
$all_paid = true;
$some_paid = false;

foreach ($all_sessions as $session) {
    if (in_array($session->id, $paid_session_ids)) {
        $some_paid = true;
    } else if (!isset($removed_sessions_data["session_" . $session->id])) {
        $all_paid = false;
    }
}

$payment_status = '';
if ($all_paid && count($all_sessions) > 0) {
    $payment_status = 'Paid';
} elseif ($some_paid) {
    $payment_status = 'Partial Paid';
} else {
    $payment_status = 'To be paid';
}

// Return JSON response
echo json_encode([
    'success' => true,
    'html' => "
    <div class='edit-popup'>
        <div class='edit-popup-title-container'>
            <p class='edit-popup-title'>Edit Manual Time</p>
            <button class='close-edit-popup'>
                <img src='./assets/close.svg' alt='close' />
            </button>
        </div>
        <div class='edit-popup-calendar'>
            <div class='edit-popup-calendar-item'>
                <div class='edit-popup-calendar-icon'>
                    <img src='./assets/calendar-popup.svg' alt='' />
                </div>
                <div class='edit-popup-calendar-date'>
                    <p class='edit-popup-calendar-day'>{$day_name}</p>
                    <p class='edit-popup-calendar-datelong'>{$popup_date}</p>
                </div>
            </div>
            <div class='edit-popup-calendar-status'>
                <div class='edit-popup-calendar-check'>
                    <img src='./assets/check.svg' alt='' />
                </div>
                <div class='edit-popup-calendar-label-paid'>{$payment_status}</div>
            </div>
        </div>
        <div class='edit-popup-control session-controls'>
            <button class='select-all-btn' style='display:none'>Select All</button>
            <button class='remove-sessions-btn'>Remove</button>
            <button class='cancel-remove-btn' style='display:none'>Cancel Remove</button>
        </div>
        <div class='table-popup'>
            <table>
                <thead>
                    <th></th>
                    <th>Group</th>
                    <th>Duration</th>
                    <th>Attendance</th>
                    <th>Payable</th>
                    <th>Amount</th>
                    <th>Notes</th>
                </thead>
                <tbody>
                    {$popup_rows}
                </tbody>
            </table>
            <p class='removed-title'>Removed Sessions</p>
            <table class='removed-sessions'>
                <thead>
                    <th></th>
                    <th>Group</th>
                    <th>Duration</th>
                    <th>Attendance</th>
                    <th>Payable</th>
                    <th>Amount</th>
                    <th>Notes</th>
                </thead>
                <tbody>
                    " . ($removed_rows ? $removed_rows : "<tr><td colspan='7'>No removed sessions</td></tr>") . "
                </tbody>
            </table>
        </div>
        
        <!-- General Notes Section in Popup -->
        <div class='general-notes-popup-section'>
            <div class='general-notes-header'>
                <p>General Notes</p>
                <div class='edit-popup-control'>
                    <button class='add-general-note-btn' data-teacherid='{$teacherid}' data-date='{$date}'>Add</button>
                    |
                    <button class='remove-general-note-btn'>Remove</button>
                </div>
            </div>
            <div class='general-notes-list' id='generalNotesList'>
                " . get_general_notes_html($teacherid, $date) . "
            </div>
        </div>
        
        <!-- General Notes Add Form (initially hidden) -->
        <div class='general-notes-add-form' id='generalNotesAddForm' style='display: none;'>
            <div class='general-notes-form-header'>
                <p>Make a General Note</p>
                <button class='close-add-note-form' id='closeAddNoteForm'>×</button>
            </div>
            <div class='general-notes-form-content'>
                <div class='teacher-info'>
                    <div class='teacher-name'>
                        <strong>" . fullname($USER) . "</strong> 
                        <span>Made by</span>
                    </div>
                    <div class='session-date'>
                        <strong>" . date('D, M j') . "</strong> 
                        <span>Session Date</span>
                    </div>
                </div>
                <div class='notes-input-container'>
                    <textarea class='notes-input' id='generalNoteInput' placeholder='Add Notes'></textarea>
                </div>
                <div class='notes-form-actions'>
                    
                    <button class='btn-submit-note' id='submitNoteBtn' data-teacherid='{$teacherid}' data-date='{$date}'>Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class='hours-bottom'>
        <div class='work-hours'>
            <p>Work hours</p>
            <div class='work-hours-item'>
                <img src='./assets/clock.svg' alt='' />
                <p>{$formatted_time}</p>
            </div>
        </div>
        <div class='total-amount'>
            <p>Total Amount</p>
            <div class='amount-item'>
                <p>\$ {$formatted_total_amount}</p>
            </div>
        </div>
        <div class='hours-buttons'>
            <button class='hours-cancel'>Cancel</button>
            <button class='hours-save' data-teacherid='{$teacherid}' data-date='{$date}'>Save</button>
        </div>
    </div>
    "
]);

// Helper function to get ordinal suffix
function get_ordinal_suffix($day) {
    if ($day > 3 && $day < 21) return 'th';
    switch ($day % 10) {
        case 1: return 'st';
        case 2: return 'nd';
        case 3: return 'rd';
        default: return 'th';
    }
}

// Function to get removed sessions from database
function get_removed_sessions($teacherid, $date) {
    global $DB;
    
    // Check if the table exists, create it if not
    $dbman = $DB->get_manager();
    $table = new xmldb_table('local_teachertimecard_rm');
    
    if (!$dbman->table_exists($table)) {
        // Create the table with additional fields for session data
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('teacherid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('session_id', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $table->add_field('date', XMLDB_TYPE_CHAR, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('duration', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('attendance', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('student_count', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('payable', XMLDB_TYPE_CHAR, '10', null, XMLDB_NOTNULL, null, 'Yes');
        $table->add_field('amount', XMLDB_TYPE_CHAR, '10', null, XMLDB_NOTNULL, null, '-');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        
        // Adding keys
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        
        // Create table
        $dbman->create_table($table);
    }
    
    $records = $DB->get_records('local_teachertimecard_rm', [
        'teacherid' => $teacherid,
        'date' => $date
    ]);
    
    $removed_sessions = [];
    foreach ($records as $record) {
        $removed_sessions[$record->session_id] = [
            'duration' => $record->duration,
            'attendance' => $record->attendance,
            'student_count' => $record->student_count,
            'payable' => $record->payable,
            'amount' => $record->amount
        ];
    }
    
    return $removed_sessions;
}

// Function to save removed sessions to database
function save_removed_sessions($teacherid, $date, $removed_sessions_json, $removed_session_data_json) {
    global $DB;
    
    // Decode the JSON data
    $removed_sessions = json_decode($removed_sessions_json);
    $removed_session_data = json_decode($removed_session_data_json, true);
    
    // First, delete all existing records for this teacher and date
    $DB->delete_records('local_teachertimecard_rm', [
        'teacherid' => $teacherid,
        'date' => $date
    ]);
    
    // Then insert the new removed sessions with their data
    foreach ($removed_sessions as $session_id) {
        if (isset($removed_session_data[$session_id])) {
            $data = $removed_session_data[$session_id];
            
            $record = new stdClass();
            $record->teacherid = $teacherid;
            $record->session_id = $session_id;
            $record->date = $date;
            $record->duration = $data['duration'];
            $record->attendance = $data['attendance'];
            $record->student_count = $data['student_count'];
            $record->payable = $data['payable'];
            $record->amount = $data['amount'];
            $record->timecreated = time();
            
            $DB->insert_record('local_teachertimecard_rm', $record);
        }
    }
    
    return true;
}