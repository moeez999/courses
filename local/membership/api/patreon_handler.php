<?php

/**
 * Local plugin "membership" - Patreon handler file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');
require_once($CFG->dirroot . '/local/membership/patreon/lib.php');

global $CFG, $DB, $PAGE, $USER, $SESSION;


require_login();

if (!is_siteadmin()) {
    redirect($CFG->wwwroot.'/local/membership/dashboard.php', 'You dont have access to that zone.');
}
$systemcontext = context_system::instance();
$PAGE->set_context($systemcontext);

$PAGE->set_title("Autorización de Patreon");
$PAGE->set_heading("Autorización de Patreon");

$PAGE->set_url($CFG->wwwroot.'/local/membership/api/patreon_handler.php');

$authorizationCompleted = false;
$userData = false;
$errorMsg = null;

if (isset($_GET['code'])) {
    $authorization_code = $_GET['code'];
    $token_data = $oauth_client->get_tokens($authorization_code, $redirect_uri);
    if (isset($token_data['access_token'])) {
        saveTokens($token_data['access_token'], $token_data['refresh_token']);
    }
} else if(isset($_GET['unlink'])) {
    deleteToken();
} else {
    $savedTokens = getToken();
    if ($savedTokens) {
        $access_token = $savedTokens->accesstoken;
        $refresh_token = $savedTokens->refreshtoken;
        $authorizationCompleted = true;
        $userData = getUserData();

        // Add a check for array structure; handle error messages or unexpected responses
        if (!is_array($userData) || !isset($userData['data']['attributes'])) {
            $errorMsg = 'Patreon API did not return expected data. Raw response: ' . htmlspecialchars(print_r($userData, true));
        }
    }
}
echo $OUTPUT->header();
?>

<div class="row page-content-wrapper" id="custom-payment">
    <?php if ($authorizationCompleted): ?>
        <div class="row">
            <div class="col-12">
                <h3>Token de acceso</h3>
                <p><?= isset($access_token) ? htmlspecialchars($access_token) : '' ?></p>
            </div>
            <div class="col-12">
                <h3>Token actualizado</h3>
                <p><?= isset($refresh_token) ? htmlspecialchars($refresh_token) : '' ?></p>
            </div>

            <?php if (isset($errorMsg)): ?>
                <div class="col-12">
                    <div class="alert alert-warning">
                        <strong>Error de autorización de Patreon:</strong><br>
                        <pre><?= $errorMsg ?></pre>
                    </div>
                </div>
            <?php elseif (is_array($userData) && isset($userData['data']['attributes'])): ?>
                <div class="col-12 mb-5">
                    <div class="card" style="width: 18rem;">
                        <h3>Autorizado como:</h3>
                        <div class="row no-gutters align-items-center">
                            <div class="col-2">
                                <img src="<?= htmlspecialchars($userData['data']['attributes']['image_url']); ?>" class="card-img img-fluid w-100" alt="Avatar">
                            </div>
                            <div class="col-10">
                                <div class="card-body ml-2">
                                    <h5 class="card-title text-dark mb-0"><?= htmlspecialchars($userData['data']['attributes']['full_name']); ?></h5>
                                    <p class="card-text"><small class="text-dark"><?= htmlspecialchars($userData['data']['attributes']['email']); ?></small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-12">
                <a href="<?= $redirect_uri; ?>?unlink" class="btn btn-primary">Desvincular Cliente</a>
            </div>
        </div>
    <?php else: ?>
        <a href="<?= $auth_url; ?>" class="btn btn-primary">Autorizar Cliente</a>
    <?php endif; ?>
</div>

<?php 
echo $OUTPUT->footer();
