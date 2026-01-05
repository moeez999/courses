<?php

/**
 * Local plugin "membership" - Unsub file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once(__DIR__ . '/lib.php');

global $CFG, $DB, $PAGE, $USER;

require_login();

$PAGE->set_context(context_system::instance());
$PAGE->set_title('Membership Subscription Cancel');
$PAGE->set_heading('Membership Subscription Cancel');
$PAGE->set_url($CFG->wwwroot.'/local/membership/unsub.php');


$subId = required_param('id', PARAM_RAW);

if (empty($subId)) {
    redirect($CFG->wwwroot.'/local/membership/dashboard.php');
}

$cancelled = cancel_braintree_subscription($subId);

$subscription = $DB->get_record('local_subscriptions', array('sub_reference' => $subId));

if (empty($subscription)) {
    redirect($CFG->wwwroot.'/local/membership/dashboard.php', 'Subscription cancellation failed');
}
$oldmembershipcohorts = array();
$oldmembershipcohorts = explode(',', $subscription->sub_cohorts);

foreach ($oldmembershipcohorts as $cohortid) {
    $cohort = $DB->get_record('cohort', array('id' => $cohortid), '*', MUST_EXIST);
    
    if (!empty($cohort)) {
        $cohort_members = $DB->get_records('cohort_members', array('cohortid' => $cohortid, 'userid' => $subscription->sub_user));
        
        if (!empty($cohort_members)) {
            foreach ($cohort_members as $cohort_member) {
                $DB->delete_records('cohort_members', array('id' => $cohort_member->id));
            }
        }
    }
}


$DB->execute("UPDATE {local_subscriptions} SET sub_status = 0 WHERE id = '{$subscription->id}' AND sub_id = '{$subscription->sub_id}'");
if ($cancelled) {
    redirect($CFG->wwwroot.'/local/membership/dashboard.php', 'Subscription successfully canceled');
}

redirect($CFG->wwwroot.'/local/membership/dashboard.php', 'Subscription cancelation failed');