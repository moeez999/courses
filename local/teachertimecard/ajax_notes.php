<?php
/**
 * Local plugin "Teacher Timecard" - AJAX endpoint for notes
 */

require_once(__DIR__.'/../../config.php');
require_once(__DIR__.'/lib.php');

// Require login and capabilities
require_login();
$context = context_system::instance();

// Get action parameter
$action = required_param('action', PARAM_TEXT);

// Handle different actions
switch ($action) {
    case 'save_note':
        $teacherid = required_param('teacherid', PARAM_INT);
        $date = required_param('date', PARAM_TEXT);
        $note = required_param('note', PARAM_TEXT);
        
        $result = save_general_note($teacherid, $date, $note, $USER->id);
        
        echo json_encode(['success' => (bool)$result, 'message' => $result ? 'Note saved successfully' : 'Error saving note']);
        break;
        
    case 'delete_notes':
        $note_ids = required_param('note_ids', PARAM_TEXT);
        $note_ids = json_decode($note_ids);
        
        $result = delete_general_notes($note_ids);
        
        echo json_encode(['success' => (bool)$result, 'message' => $result ? 'Notes deleted successfully' : 'Error deleting notes']);
        break;
        
    case 'get_notes':
        $teacherid = required_param('teacherid', PARAM_INT);
        $startdate = required_param('startdate', PARAM_TEXT);
        $enddate = required_param('enddate', PARAM_TEXT);
        
        $start_timestamp = strtotime($startdate);
        $end_timestamp = strtotime($enddate);
        
        $notes = get_general_notes($teacherid, $start_timestamp, $end_timestamp);
        $html = display_general_notes($notes, true);
        
        echo json_encode(['success' => true, 'html' => $html]);
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}

exit;