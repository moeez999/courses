<?php
require_once(__DIR__.'/../../config.php');
require_once($CFG->libdir.'/filelib.php');

global $DB, $USER;
require_login();

// Only allow admins or managers (optional)
if (!is_siteadmin() && !has_capability('moodle/cohort:view', context_system::instance())) {
    header('HTTP/1.1 403 Forbidden');
    exit;
}

// Get all visible cohorts
$cohorts = $DB->get_records('cohort', ['visible' => 1]);

$studentIds = [];
foreach ($cohorts as $cohort) {
    $members = $DB->get_records('cohort_members', ['cohortid' => $cohort->id]);
    foreach ($members as $member) {
        $studentIds[$member->userid] = true;
    }
}

$students = [];
if (!empty($studentIds)) {
    list($inSql, $params) = $DB->get_in_or_equal(array_keys($studentIds));
    $userRecords = $DB->get_records_select('user', "id $inSql", $params, 'firstname ASC', 'id, firstname, lastname, email, picture');

    foreach ($userRecords as $user) {
        $userPicture = new user_picture($user);
        $userPicture->size = 1;
        $avatarUrl = $userPicture->get_url($PAGE)->out(false);

        $students[] = [
            'id' => $user->id,
            'name' => fullname($user),
            'avatar' => $avatarUrl
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($students);
exit;