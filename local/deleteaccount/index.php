<?php
require_once('../../config.php');
require_once($CFG->libdir . '/moodlelib.php');

require_login(); // Ensure user is logged in
global $DB, $USER, $PAGE, $OUTPUT;

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/deleteaccount/index.php'));
$PAGE->set_title('Delete Account');
$PAGE->set_heading('Delete Account');
$PAGE->set_pagelayout('standard');

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && confirm_sesskey()) {
    $email = required_param('email', PARAM_EMAIL);

    if ($email === $USER->email) {
        // Delete user and logout
        $DB->delete_records('user', ['id' => $USER->id]);  // Deletes user from database
        require_logout();

        // Show success message and redirect after 3 seconds
        echo $OUTPUT->header();
        echo '<div style="text-align: center; padding: 20px;">';
        echo '<h2>Account Deleted Successfully</h2>';
        echo '<p>Your account has been deleted. You will be redirected shortly...</p>';
        echo '</div>';
        echo $OUTPUT->footer();

        echo '<script>
                setTimeout(function() {
                    window.location.href = "' . $CFG->wwwroot . '";
                }, 3000);
              </script>';
        exit();
    } else {
        echo $OUTPUT->header();
        echo $OUTPUT->notification('Error: Email does not match the logged-in user.', 'error');
        echo $OUTPUT->footer();
        exit();
    }
}

echo $OUTPUT->header();
?>

<!-- Page Content -->
<div style="text-align: center; padding: 20px;">
    <h2>Delete Account</h2>
    <p>Deleting your account is permanent and all your account information will be deleted along with it.  
    If you're sure you want to proceed, enter your email address below.</p>

    <form method="post" action="">
        <input type="hidden" name="sesskey" value="<?php echo sesskey(); ?>">
        <label for="email"><?php echo get_string('email', 'local_deleteaccount'); ?>:</label><br>
        <input type="email" name="email" id="email" required><br><br>
        <button type="submit"><?php echo get_string('deletebutton', 'local_deleteaccount'); ?></button>
    </form>
</div>

<?php
echo $OUTPUT->footer();
?>