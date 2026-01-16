<?php
require_once("../../config.php");
require_once($CFG->dirroot . '/course/lib.php');
echo $OUTPUT->header();
?>
<?php require_once("my_students_details.php"); ?>
<?php
echo $OUTPUT->footer();
?>