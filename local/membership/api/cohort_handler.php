<?php

/**
 * Local plugin "membership" - Cohort handler file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

header('Content-Type: application/json');

require_once('../../../config.php');
require_once($CFG->dirroot . '/local/membership/lib.php');

global $DB, $USER;

$action = $_POST['action'] ?? '';

if (!empty($action)) {
	if ($action == 'getCohorts') {
		$cohorts = getCohorts();
		echo json_encode($cohorts);
		exit;
	} else if ($action == 'updateCohorts') {
		$userId = $USER->id;

		$subCohorts = $_POST['subCohorts'] ?? '';
		$subReference = $_POST['subReference'] ?? '';
		$subPlatform = $_POST['subPlatform'] ?? '';
		$subEmail = $_POST['subEmail'] ?? '';
		$subCron = $_POST['subCron'] ?? '';

		if ($userId && $subCohorts && $subReference && $subPlatform && $subEmail) {
			$success = false;
			if ($subCron) {
				$success = updateCohortsTask($userId, $subCohorts, $subReference, $subPlatform, $subEmail, $subCron);
			} else {
				$success = updateCohorts($userId, $subCohorts, $subReference, $subPlatform, $subEmail);
			}
			ob_start();  // Start output buffering
header('Content-Type: application/json');  // Set correct content type
echo json_encode(['success' => $success]);  // Send JSON response
ob_end_flush();  // Send the buffered output
exit;
		} else {
			echo json_encode([
				'errors' => 'missing_parameters'
			]);
			exit;
		}
	}
} else {
	echo json_encode([
		'errors' => 'invalid_action'
	]);
	exit;
}

?>