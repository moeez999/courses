<?php

/**
 * Local plugin "membership" - Paypal lib file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    define('PAYPAL_CLIENT_ID', 'AY_8t-UHcwMkwPwFtc1ibcFtSkFuhD41w-NhhXVzK_MxAldktPIuaNsNyMzybL3E6QMTJea74dfMPUnn');
    define('PAYPAL_CLIENT_SECRET', 'EECihXkGbI9fOfybO0Qu8FNc_PpZ2Pd-BankWiBaCNrK_XyjaO4fVKkBNuGqkeC5ntLBFQFRtwDySK5P');
    // define('PAYPAL_CLIENT_ID', 'Adrxu6AE5PG4nxq9yu0HitfPBI-XhdIqGTTkGO9m5wnfzFOywj9MZPqqKTLu23O_OlqhY6tuYCRcCAQh');
    // define('PAYPAL_CLIENT_SECRET', 'EIVfqnIf6GRuGuwWrwA9bE1wH29G4sXbWVr2iyQ7ONKUCM_EGtG3OuCHF3H3ztUbnsZiWGLkE1MoH0FT');
// define('PAYPAL_CLIENT_ID', 'AeoB54iVs6_A1mnkqKgZbsNH2xBRSZE_Q-6i5oeEaEjIucY-oQ-EkBaAV9LEp9v_usAzKqVzkqLJh95m');
// define('PAYPAL_CLIENT_SECRET', 'EPuWrxzv0PI2Es3HVFmKXubiRwtKxhJo6Kz5DLUa3NeZ4XAxw6_EW0eAU63nQwwSJu4IDHzNKSzHO8Jg');
define('PAYPAL_IS_SANDBOX', true);
define('PAYPAL_API_URL', PAYPAL_IS_SANDBOX ? 'https://api-m.sandbox.paypal.com' : 'https://api-m.paypal.com');

function getPaypalAccessToken() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, PAYPAL_API_URL . '/v1/oauth2/token');
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, PAYPAL_CLIENT_ID . ':' . PAYPAL_CLIENT_SECRET);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }

    if (empty($response)) {
        throw new Exception("Error: No response from PayPal.");
    }

    $json = json_decode($response);
    curl_close($ch);

    if (isset($json->access_token)) {
        return $json->access_token;
    } else {
        throw new Exception("Error: Unable to get access token from PayPal.");
    }
}

function getPayPalSubscriptions($accessToken) {
    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer $accessToken"
    ];

    $url = PAYPAL_API_URL . '/v2/billing/subscriptions';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }

    curl_close($ch);

    if (!$response) {
        echo "Error: No response from PayPal";
        return null;
    }

    $jsonResponse = json_decode($response, true);
    print_r($jsonResponse);
    return $jsonResponse;
}

// $accessToken = getPaypalAccessToken();
// $subscriptions = getPayPalSubscriptions($accessToken);

?>
