<?php

/**
 * Local plugin "membership" - Token handler file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require("../../../config.php");
require_once($CFG->dirroot . '/local/membership/lib.php');
$gateway = get_braintree_gateway();

$customer = null;
try {
	$customer = $gateway->customer()->search([
		Braintree\CustomerSearch::email()->is($USER->email)
	]);
	$customer = $customer->firstItem();

} catch (Exception $e) {
	$customer = false;
}
if (!$customer) {
	$clientToken = $gateway->clientToken()->generate();
} else {
	$clientToken = $gateway->clientToken()->generate([
		"customerId" => $customer->id
	]);

}
echo $clientToken;
exit;

?>