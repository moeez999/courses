<?php

/**
 * Local plugin "membership" - Discount handler file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require("../../../config.php");

$code = $_POST['code'];
$key = $_POST['key'];

if (empty($code) || empty($key)) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

$numberOfCodes = get_config('local_membership', 'noofmembershippromotioncodes' . $key);

if ($numberOfCodes === false) {
    echo json_encode(['success' => false, 'message' => 'plan_without_discounts']);
    exit;
}

$found = false;
$discount = 0;

for ($fkey = 1; $fkey <= $numberOfCodes; $fkey++) {
    $promoCode = get_config('local_membership', 'membershippromotioncodestext' . $key . $fkey);
    $promoDiscount = get_config('local_membership', 'membershippromotioncodesdiscount' . $key . $fkey);

    if ($promoCode === false || $promoDiscount === false) {
        continue;
    }

    if (!is_numeric($promoDiscount)) {
        continue;
    }

    if ($code === $promoCode) {
        $found = true;
        $discount = (float)$promoDiscount;
        break;
    }
}

if ($found) {
    echo json_encode([
        'success' => true,
        'discount' => $discount,
    ]);
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'discount_not_found']);
    exit;
}

?>