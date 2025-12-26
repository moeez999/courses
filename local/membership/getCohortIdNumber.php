<?php
// File: local/membership/getCohortIdNumber.php
require(__DIR__ . '/../../config.php');

require_login(); // Block anonymous access.

// Optional sesskey hardening (include sesskey in the request if you enable this).
if (optional_param('sesskey', '', PARAM_RAW) !== '' && !confirm_sesskey()) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(403);
    echo json_encode(['ok' => false, 'error' => 'invalid_sesskey']);
    exit;
}

header('Content-Type: application/json; charset=utf-8');

global $DB;

// You pass cohort *shortname* in 'cohortid' (kept for backward compatibility)
$cohortinput = optional_param('cohortid', '', PARAM_RAW_TRIMMED);

// New: email (to lookup phone)
$email = optional_param('email', '', PARAM_RAW_TRIMMED);

// --------------------
// Resolve cohort idnumber
// --------------------
$idnumber = null;
if ($cohortinput !== '') {
    // 1) Treat input as shortname.
    if ($DB->record_exists('cohort', ['shortname' => $cohortinput])) {
        $idnumber = $DB->get_field('cohort', 'idnumber', ['shortname' => $cohortinput]);
    }
    // 2) If numeric, try by id.
    if ($idnumber === null && ctype_digit($cohortinput)) {
        $idnumber = $DB->get_field('cohort', 'idnumber', ['id' => (int)$cohortinput]);
    }
    // 3) If already an idnumber.
    if ($idnumber === null && $DB->record_exists('cohort', ['idnumber' => $cohortinput])) {
        $idnumber = $cohortinput;
    }
}

// --------------------
// Resolve phone by email (phone1 -> phone2 -> profile field fallbacks)
// --------------------
$phone = '';
if ($email !== '') {
    // quick sanity: allow only plausible emails
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Try core user table
        $user = $DB->get_record('user', ['email' => $email], 'id,phone1,phone2', IGNORE_MISSING);
        if ($user) {
            if (!empty($user->phone1)) {
                $phone = $user->phone1;
            } else if (!empty($user->phone2)) {
                $phone = $user->phone2;
            }
        }

        // Fallbacks: check custom profile fields if core is empty
        if ($phone === '') {
            // common shortnames you might have used
            $candidates = ['phone', 'mobile', 'contactnumber'];
            list($inSql, $params) = $DB->get_in_or_equal($candidates, SQL_PARAMS_NAMED);
            $fields = $DB->get_records_select_menu('user_info_field', "shortname {$inSql}", $params, '',
                'id, shortname');

            if ($fields && $user) {
                foreach ($fields as $fid => $shortname) {
                    $val = $DB->get_field('user_info_data', 'data',
                        ['userid' => $user->id, 'fieldid' => $fid], IGNORE_MISSING);
                    if (!empty($val)) { $phone = $val; break; }
                }
            }
        }
    }
}

// If you want to require cohort resolution to succeed, keep the old behavior.
// Otherwise, we can return ok=true if either idnumber or phone is available.
$ok = ($idnumber !== null && $idnumber !== '') || ($phone !== '');

echo json_encode([
    'ok'       => $ok,
    'idnumber' => $idnumber ?? '',
    'phone'    => $phone
]);