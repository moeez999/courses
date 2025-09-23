<?php
// This script is called via fetch when user clicks "Yes" in the modal

require_once(__DIR__ . '/../../../config.php');
require_login(); // Ensure the user is logged in

// Set proper header for JSON response
header('Content-Type: application/json');

// Sanitize incoming POST parameters
$userid = required_param('userid', PARAM_INT);
$cohortid = required_param('cohortid', PARAM_INT);
$action = required_param('action', PARAM_TEXT);



// Initialize database record
global $DB;

$record = new stdClass();
$record->alert_status = 1;
$record->user_id = $userid;
$record->timestamp = time();
$record->cohortid = $cohortid;

if($action == 'true')
{
$record->feedback = 1;
}else{
 $record->feedback = 0;  
}


// Insert the record
try {
    $DB->insert_record('popup_alert', $record);
    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}