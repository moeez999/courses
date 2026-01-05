<?php

/**
 * Local plugin "membership" - Check Cron Cohorts file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_membership\task;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/membership/lib.php');

class check_cron_cohorts extends \core\task\scheduled_task {

	public function get_name() {
		return get_string('check_cron_cohorts', 'local_membership');
	}

	public function execute() {
		global $DB;

		$currentTimestamp = time();
		error_log('EJECUTADO, TIMESTAMP: ' . $currentTimestamp);

		$records = $DB->get_records_select('local_subscriptions', 'sub_cron <= ?', [$currentTimestamp]);

		foreach ($records as $record) {
			error_log('Procesando suscripción: ' . $record->sub_reference);

			$updateSuccess = updateCohorts($record->sub_user, $record->sub_new_cohorts, $record->sub_reference, $record->sub_platform, $record->sub_email);

			if ($updateSuccess) {
				error_log("Cohorts actualizados para: " . $record->sub_reference);

				$updateFields = new \stdClass();
				$updateFields->id = $record->id;
				$updateFields->sub_cron = null;
				$updateFields->sub_new_cohorts = null;

				$updateSuccessPost = $DB->update_record('local_subscriptions', $updateFields);

				if ($updateSuccessPost) {
					error_log("Record updated successfully for sub_reference: " . $record->sub_reference);
				} else {
					error_log("Failed to update sub_cron and sub_new_cohorts for sub_reference: " . $record->sub_reference);
				}
			} else {
				error_log("Failed to update cohorts for sub_reference: " . $record->sub_reference);
			}
		}
	}
}
