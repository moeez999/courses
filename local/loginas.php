<?php
require_once(__DIR__ . '/../config.php');

require_login();
require_sesskey();

global $DB, $CFG;

// Capability check (preferred over admin-only)
require_capability('moodle/user:loginas', context_system::instance());

$userid = required_param('userid', PARAM_INT);

// Validate target user
$user = $DB->get_record('user', [
    'id' => $userid,
    'deleted' => 0,
    'suspended' => 0
], '*', MUST_EXIST);

// 🔐 Moodle 4.x LOGIN-AS (2 args REQUIRED)
\core\session\manager::loginas(
    $user->id,
    context_system::instance()
);

// Redirect after switch
redirect($CFG->wwwroot . '/course/index.php');
