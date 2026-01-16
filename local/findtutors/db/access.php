<?php

defined('MOODLE_INTERNAL') || die();

$capabilities = [
    'local/findtutors:view' => [
        'riskbitmask' => RISK_PERSONAL,
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => [
            'guest' => CAP_PREVENT,
            'user'  => CAP_ALLOW,
            'manager' => CAP_ALLOW,
        ],
    ],
    'local/findtutors:manage' => [
        'riskbitmask' => RISK_CONFIG,
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => [
            'manager' => CAP_ALLOW,
        ],
    ],
];

