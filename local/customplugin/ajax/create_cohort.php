<?php
// /local/adminboard/ajax/create_cohort.php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_login();


@header('Content-Type: application/json; charset=utf-8');

try {
    // Resolve context
    $contextid = optional_param('contextid', 0, PARAM_INT);
    if (!$contextid) {
        // Fallback: try to parse from returnurl=?contextid=#
        $returnurl = optional_param('returnurl', '', PARAM_URL);
        if (!empty($returnurl)) {
            $parts = parse_url($returnurl);
            if (!empty($parts['query'])) {
                parse_str($parts['query'], $q);
                if (!empty($q['contextid'])) {
                    $contextid = (int)$q['contextid'];
                }
            }
        }
    }
    $context = $contextid ? context::instance_by_id($contextid, MUST_EXIST) : context_system::instance();

    // Require capability to create/manage cohorts
    require_capability('moodle/cohort:manage', $context);

    // Build cohort object from request
    $now = time();
    $cohort = new stdClass();

    // Mandatory core fields (fallbacks if some are not posted)
    $cohort->contextid = $context->id;

    // Common fields you may pass from the UI
    $cohort->name        = optional_param('name', '', PARAM_TEXT) ? optional_param('name', '', PARAM_TEXT) : 'Alaska 12' ;
    $cohort->shortname   = optional_param('shortname', '', PARAM_TEXT) ? optional_param('shortname', '', PARAM_TEXT) : 'AK12';
    $cohort->idnumber    = optional_param('idnumber', '', PARAM_TEXT) ? optional_param('idnumber', '', PARAM_TEXT) : 'AK12-08092025-012';


    // Defaults (enabled/visible/component/timestamps)
    $cohort->enabled      = "1";
    $cohort->visible      = "1";

    $cohort->descriptionformat      = "1";
    $cohort->description      = "";

    $cohort->id      = 0;
    
    $cohort->submitbutton ="Save changes";
    
    $cohort->returnurl ="/local/customplugin/calendar_admin.php";

    $cohort->description_editor = [
  'text'   => '',
  'format' => 1,
  'itemid' => 937264460, // draft id (ignored in this simple test)
];
    

    // Optional styling / theme
    $cohort->theme       = optional_param('theme', null, PARAM_TEXT);
    $cohort->cohortcolor = trim(optional_param('cohortcolor', '', PARAM_RAW_TRIMMED));
    if ($cohort->cohortcolor === '') {
        $cohort->cohortcolor = 'blue';
    }

     // Main-days + time (Mon–Fri + hours/minutes)
    $cohort->cohortmonday    = optional_param('cohortmonday', 0, PARAM_INT);
    $cohort->cohorttuesday   = optional_param('cohorttuesday', 0, PARAM_INT);
    $cohort->cohortwednesday = optional_param('cohortwednesday', 0, PARAM_INT);
    $cohort->cohortthursday  = optional_param('cohortthursday', 0, PARAM_INT);
    $cohort->cohortfriday    = optional_param('cohortfriday', 0, PARAM_INT);
    $cohort->cohorthours     = optional_param('cohorthours', 0, PARAM_INT);
    $cohort->cohortminutes   = optional_param('cohortminutes', 0, PARAM_INT);

  // Tutor-days + time (Mon–Fri + hours/minutes)
    $cohort->cohorttutormonday    = optional_param('cohorttutormonday', 0, PARAM_INT);
    $cohort->cohorttutortuesday   = optional_param('cohorttutortuesday', 0, PARAM_INT);
    $cohort->cohorttutorwednesday = optional_param('cohorttutorwednesday', 0, PARAM_INT);
    $cohort->cohorttutorthursday  = optional_param('cohorttutorthursday', 0, PARAM_INT);
    $cohort->cohorttutorfriday    = optional_param('cohorttutorfriday', 0, PARAM_INT);
    $cohort->cohorttutorhours     = optional_param('cohorttutorhours', 0, PARAM_INT);
    $cohort->cohorttutorminutes   = optional_param('cohorttutorminutes', 0, PARAM_INT);

    // Teacher ids (custom columns you added)
    $cohort->cohortmainteacher  = optional_param('cohortmainteacher', null, PARAM_INT);
    $cohort->cohortguideteacher = optional_param('cohortguideteacher', null, PARAM_INT);


    // Dates (UNIX seconds)
    $startdate = optional_param('startdate', 0, PARAM_INT);
    $enddate   = optional_param('enddate', 0, PARAM_INT);
    $cohort->startdate = $startdate ?: 1757304000;
    $cohort->enddate   = $enddate   ?: 1788926400;

    if (!empty($cohort->startdate) && !empty($cohort->enddate) && $cohort->enddate < $cohort->startdate) {
        throw new moodle_exception('invaliddata', 'error', '', 'enddate cannot be earlier than startdate');
    }


    // Create cohort
    require_once($CFG->dirroot . '/cohort/lib.php');

    $cohortid = cohort_add_cohort($cohort); // returns new id

    // Optional redirect target from UI
    $redirect = optional_param('returnurl', '', PARAM_URL);

    echo json_encode([
        'success'  => true,
        'cohortid' => (int)$cohortid,
        'message'  => 'Cohort created successfully.',
        'redirect' => $redirect ?: null
    ]);
    exit;

} catch (moodle_exception $ex) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error'   => $ex->errorcode ?? 'moodle_exception',
        'message' => $ex->getMessage()
    ]);
    exit;

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => 'server_error',
        'message' => $e->getMessage()
    ]);
    exit;
}