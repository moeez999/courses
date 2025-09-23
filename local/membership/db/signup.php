<?php

/**
 * Local plugin "membership" - Signup file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot.'/user/lib.php');

$username = required_param('username', PARAM_NOTAGS);
$firstname = required_param('firstname', PARAM_NOTAGS);
$lastname = required_param('lastname', PARAM_NOTAGS);
$email = required_param('email', PARAM_EMAIL);
$password = required_param('password', PARAM_NOTAGS);
$gender = optional_param('gender', 'unknown', PARAM_NOTAGS);
$phonenumber = optional_param('phonenumber', null, PARAM_NOTAGS);
$wantsurl = required_param('wantsurl', PARAM_URL);


if ($DB->record_exists('user', ['username' => $username])) {
    redirect(new moodle_url('/local/membership/payment.php', ['error' => 'usernameexists']));
}

if ($DB->record_exists('user', ['email' => $email])) {
    redirect(new moodle_url('/local/membership/payment.php', ['error' => 'emailexists']));
}

$user = create_user_record($username, $password, 'manual');
$user->email = $email;
$user->username = $username;
$user->firstname = $firstname;
$user->lastname = $lastname;
$user->gender = $gender;
$user->phone2 = $phonenumber;
user_update_user($user, false, false);
complete_user_login($user);

redirect(new moodle_url($wantsurl));
?>
