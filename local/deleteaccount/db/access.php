<?php
defined('MOODLE_INTERNAL') || die();

$capabilities = [
    'local/deleteaccount:deleteownaccount' => [
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => [
            'student' => CAP_ALLOW,
            'user' => CAP_ALLOW
        ]
    ]
];