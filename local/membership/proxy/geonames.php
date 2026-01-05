<?php

/**
 * Local plugin "membership" - Geonames proxy file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

header('Content-Type: application/json');

if (isset($_GET['endpoint'])) {
	$endpoint = $_GET['endpoint'];
	$username = 'neilatingles';
	$base_url = 'http://api.geonames.org/' . $endpoint;

	if (strpos($base_url, '?') === false) {
		$base_url .= '?username=' . $username;
	} else {
		$base_url .= '&username=' . $username;
	}

	foreach ($_GET as $key => $value) {
		if ($key != 'endpoint') {
			$base_url .= '&' . urlencode($key) . '=' . urlencode($value);
		}
	}

	$response = file_get_contents($base_url);
	if ($response !== false) {
		echo $response;
	} else {
		echo json_encode(['error' => 'Error fetching data from GeoNames']);
	}
} else {
	echo json_encode(['error' => 'No endpoint specified']);
}
exit;

?>
