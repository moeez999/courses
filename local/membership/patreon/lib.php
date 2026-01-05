<?php

/**
 * Local plugin "membership" - Patreon lib file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($CFG->dirroot.'/local/membership/patreon/API.php');
require_once($CFG->dirroot.'/local/membership/patreon/OAuth.php');

use Patreon\API;
use Patreon\OAuth;

$client_id = 'kd9LOtlQ5dmBji3VGCyc5xCMc_ggDx9-6zHE5yVXW5lQDCGEQoTmkDAS0FwnPmmh';
$client_secret = 'fJVQeEl8EkhmvgM-u8CtKhQOcED09nd3kRkKi3Qt2aRfNTOZ4mXa_PPgGe4kLQV6';
$redirect_uri = 'https://courses.latingles.com/local/membership/api/patreon_handler.php';

$scope_param = urlencode('identity identity[email] identity.memberships campaigns campaigns.members campaigns.members[email] campaigns.members.address campaigns.posts');

$oauth_client = new OAuth($client_id, $client_secret);

$authorize_url = 'https://www.patreon.com/oauth2/authorize';
$token_url = 'https://www.patreon.com/api/oauth2/token';

$auth_url = "$authorize_url?response_type=code&client_id=$client_id&redirect_uri=$redirect_uri&scope=$scope_param";


$api_client = false;
$apiTokens = getToken();
if ($apiTokens) {
	$api_client = new API($apiTokens->accesstoken);
	return $api_client;
}

function getApi() {
	global $api_client;

	return $api_client;
}

function getToken() {
	global $DB;

	$monthAgo = time() - (30 * 24 * 60 * 60);
	$tokens = $DB->get_records_select('patreon_oauth2_tokens', 'timestamp >= :month', ['month' => $monthAgo]);
	return !empty($tokens) ? reset($tokens) : false;
}

function saveTokens($access_token, $refresh_token) {
	global $DB, $redirect_uri;

	$record = new stdClass();
	$record->accesstoken = $access_token;
	$record->refreshtoken = $refresh_token;
	$record->timestamp = time();

	$DB->insert_record('patreon_oauth2_tokens', $record);
	redirect($redirect_uri);
}

function deleteToken() {
	global $DB, $redirect_uri;

	$DB->delete_records('patreon_oauth2_tokens');
	redirect($redirect_uri);
}

function getUserData() {
	$api_client = getApi();
	if ($api_client) {
		$current_member = $api_client->fetch_user();
		return $current_member;
	}
	return false;
}

function getCampaign() {
	$api_client = getApi();
	if ($api_client) {
		$campaigns = $api_client->fetch_campaigns();
		if (isset($campaigns['data']) && count($campaigns['data']) > 0) {
			$campaignId = $campaigns['data'][0]['id'];
			return $campaignId;
		}
	}
	return false;
}

function formatSubscriptionData($memberData, $included) {
    global $DB;

    // Get the attributes from member data
    $attributes = $memberData['attributes'];

    // Get user details based on the user ID
    $user = getUserDetails($included, 'user', $memberData['relationships']['user']['data']['id']);
    
    
   // Get the user by email
$userr = $DB->get_record('user', ['email' => $attributes['email']], '*', IGNORE_MISSING);

$cohortshortnames = '';
$cohortId = null;
$cohortObject = null;

if ($userr) {
    $sql = "SELECT c.*
              FROM {cohort_members} cm
              JOIN {cohort} c ON c.id = cm.cohortid
             WHERE cm.userid = :userid
             LIMIT 1";

    $cohort = $DB->get_record_sql($sql, ['userid' => $userr->id]);

    if ($cohort) {
        $cohortId = $cohort->id;
        $cohortObject = $cohort;
        $cohortshortnames = $cohort->shortname;
    }
}



   // If still no cohort from email, try finding user by SubID profile field
if (empty($cohortshortnames)) {
    // Get profile field ID for 'SubID'
    $subidField = $DB->get_record('user_info_field', ['shortname' => 'SubID']);
    if ($subidField) {
        // Find user who has this subscription_id as their SubID value
        $subidUser = $DB->get_record('user_info_data', [
            'fieldid' => $subidField->id,
            'data' => isset($memberData['subscriber_id']) ? $memberData['subscriber_id'] : null
        ]);

        if ($subidUser) {
            $userFromSubId = $DB->get_record('user', ['id' => $subidUser->userid], '*', IGNORE_MISSING);
            if ($userFromSubId) {
                // Try to get their cohort from membership
                $sql = "SELECT c.*
                          FROM {cohort_members} cm
                          JOIN {cohort} c ON c.id = cm.cohortid
                         WHERE cm.userid = :userid
                         LIMIT 1";

                $cohort = $DB->get_record_sql($sql, ['userid' => $userFromSubId->id]);

                if ($cohort) {
                    $cohortId = $cohort->id;
                    $cohortObject = $cohort;
                    $cohortshortnames = $cohort->shortname;
                }else{
                    // // Fall back: Get the value from custom profile field 'cohort'
                    // $field = $DB->get_record('user_info_field', ['shortname' => 'cohort'], '*', IGNORE_MISSING);
                    // if ($field) {
                    //     $data = $DB->get_record('user_info_data', [
                    //         'userid' => $userFromSubId->id,
                    //         'fieldid' => $field->id
                    //     ], '*', IGNORE_MISSING);

                    //     if ($data && !empty($data->data)) {
                    //         $cohortValue = trim($data->data); // This is the full name of the cohort

                    //         $cohort = $DB->get_record('cohort', ['name' => $cohortValue], '*', IGNORE_MISSING);
                    //         if ($cohort) {
                    //             $cohortId = $cohort->id;
                    //             $cohortObject = $cohort;
                    //             $cohortshortnames = $cohort->shortname;
                    //         }
                    //     }
                    // }
                }
            }
        }
    }
}
    
    

    // Fetch existing subscription record from the database
    $record = $DB->get_record('local_subscriptions', ['sub_reference' => $memberData['id']]);

    $cohortIds = null;
    $cohortNames = null;

    if ($record) {
        // Get cohort names based on cohort IDs
        $subCohorts = get_cohort_names_by_ids($record->sub_cohorts);
        $cohortIds = !empty($record->sub_cohorts) ? $record->sub_cohorts : null;
        $cohortNames = !empty($subCohorts) ? $subCohorts : null;
        $cohortNames = $subCohorts ? $subCohorts : null;
    }

    // Return an array including the subscriber_id and other details
    return [
        'id' => $memberData['id'], // Member ID
        'subscriber_id' => isset($memberData['subscriber_id']) ? $memberData['subscriber_id'] : null, // Add subscriber_id here
        'name' => $user['attributes']['full_name'], // Full name of the user
        'email' => $attributes['email'], // User's email
        'method' => 'patreon', // Payment method (Patreon in this case)
        'planId' => $memberData['relationships']['campaign']['data']['id'], // Plan ID
        'status' => !empty($attributes['patron_status']) ? strtolower($attributes['patron_status']) : 'unknown', // Patron status
        'price' => $attributes['currently_entitled_amount_cents'] / 100, // Price in dollars
        'discount' => 0, // Discount (set to 0 for now)
        'startDate' => (new DateTime($attributes['pledge_relationship_start']))->format('Y-m-d'), // Start date of the pledge
        'endDate' => isset($attributes['last_charge_date']) ? (new DateTime($attributes['last_charge_date']))->format('Y-m-d') : null, // End date (last charge date)
        'billingFrequency' => $attributes['pledge_cadence'], // Billing frequency
        'cohortColumn' => $cohortshortnames, // Placeholder for cohort column
        'cohortIds' => $cohortId, // Cohort IDs (if any)
        'cohort' => $cohortObject, // Cohort names (if any)
        'action' => $cohortIds // Action is also the cohort IDs (as it seems from the original code)
    ];
}

function getUserDetails($included, $type, $id) {
	foreach ($included as $item) {
		if ($item['type'] === $type && $item['id'] === $id) {
			return $item;
		}
	}
	return null;
}

function getMembersData() {
	$api_client = getApi();
	if ($api_client) {
		$campaigns = $api_client->fetch_campaigns();
		if (isset($campaigns['data']) && count($campaigns['data']) > 0) {
			$campaignId = $campaigns['data'][0]['id'];
			$membersData = [];
			$total_members = 0;

			$base_url = "campaigns/{$campaignId}/members";
			$fields = [
				"fields[member]" => implode(",", [
					"campaign_lifetime_support_cents",
					"currently_entitled_amount_cents",
					"last_charge_date",
					"last_charge_status",
					"lifetime_support_cents",
					"note",
					"patron_status",
					"pledge_cadence",
					"pledge_relationship_start",
					"email"
				]),
				"fields[user]" => implode(",", [
					"thumb_url",
					"image_url",
					"full_name"
				]),
				"fields[address]" => implode(",", [
					"city",
					"state",
					"line_1",
					"line_2",
					"addressee",
					"postal_code",
					"phone_number"
				]),
				"include" => implode(",", [
					"address",
					"campaign",
					"user",
					"currently_entitled_tiers"
				])
			];
			$query = http_build_query($fields, '', '&');

			$url = "{$base_url}?page%5Bsize%5D=1000&{$query}";
			$has_more_pages = true;

			while ($has_more_pages) {
				$response = $api_client->get_data($url);

				if (isset($response['data'])) {
					foreach ($response['data'] as $memberData) {
					    // Extract the subscriber_id (user.id) from the response
                        $subscriber_id = isset($memberData['relationships']['user']['data']['id']) ? $memberData['relationships']['user']['data']['id'] : null;

                        // Add the subscriber_id to memberData if it exists
                        if ($subscriber_id) {
                            $memberData['subscriber_id'] = $subscriber_id;
                        }
					    
						$membersData[] = formatSubscriptionData($memberData, $response['included']);
					}
				}

				if (isset($response['meta']['pagination']['cursors']['next'])) {
					$next_cursor = $response['meta']['pagination']['cursors']['next'];
					$url = "{$base_url}?page%5Bcursor%5D={$next_cursor}&page%5Bsize%5D=1000&{$query}";
				} else {
					$has_more_pages = false;
				}

				if (isset($response['meta']['pagination']['total'])) {
					$total_members = $response['meta']['pagination']['total'];
				}
			}

			return [
				'total' => $total_members,
				'data' => $membersData,
			];
		}
	}
	return false;
}



?>