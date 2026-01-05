<?php
defined('MOODLE_INTERNAL') || die();

$tasks = [
    [
        'classname' => '\local_customplugin\task\sync_gm_event_status',
        'blocking'  => 0,
        'minute'    => '*/10',   // every 10 minutes (adjust as you like)
        'hour'      => '*',
        'day'       => '*',
        'month'     => '*',
        'dayofweek' => '*',
    ],
];