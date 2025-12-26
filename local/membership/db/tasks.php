<?php

/**
 * Local plugin "membership" - Tasks file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$tasks = [
    [
        'classname' => 'local_membership\task\check_cron_cohorts',
        'blocking' => 0,
        'minute' => '*/1',
        'hour' => '*',
        'day' => '*',
        'dayofweek' => '*',
        'month' => '*'
    ],
    [
    'classname' => 'local_membership\task\fetch_paypal_subscriptions',
    'blocking' => 0,
    'minute' => '0',
    'hour'  => '*/2',
    'day' => '*',
    'dayofweek' => '*',
    'month' => '*'
],
[
    'classname' => 'local_membership\task\sync_paypal_subscriptions',
    'blocking' => 0,
    'minute' => '0',
    'hour'  => '*/2',
    'day' => '*',
    'dayofweek' => '*',
    'month' => '*'
],
[
    'classname' => 'local_membership\task\sync_braintree_subscriptions',
    'blocking' => 0,
    'minute' => '0',
    'hour'  => '*/2',
    'day' => '*',
    'dayofweek' => '*',
    'month' => '*'
],
[
    'classname' => 'local_membership\task\sync_patreon_members',
    'blocking' => 0,
    'minute' => '0',
    'hour'  => '*/2',
    'day' => '*',
    'dayofweek' => '*',
    'month' => '*'
]
];

