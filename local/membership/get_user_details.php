<?php
require_once('../../config.php');
require_login();

header('Content-Type: application/json');

$userid = required_param('userid', PARAM_INT);

$user = $DB->get_record('user', ['id' => $userid], 'id, firstname, lastname, email, phone1');

if (!$user) {
    echo json_encode(['success' => false, 'error' => 'User not found']);
    exit;
}

echo json_encode([
    'success' => true,
    'data' => [
        'firstname' => $user->firstname,
        'lastname' => $user->lastname,
        'email' => $user->email,
        'contactnumber' => $user->phone1 ?? '',
        'password' => ''  // do not expose password for security
    ]
]);