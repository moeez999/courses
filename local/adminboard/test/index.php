<?php  
global $CFG, $DB, $PAGE, $USER;

  // Get the current user
$user = $USER;

// Check if the user is logged in and is not a guest
if (isloggedin() && !isguestuser()) {
// Fetch teachers with role ID 3 (e.g., teacher role)
$teachers = $DB->get_records_sql("SELECT id FROM {user} WHERE id IN (SELECT DISTINCT(userid) FROM {role_assignments} WHERE roleid = ?)", array(3));

// Check if the current user is a teacher (role ID 3)
$is_teacher = false;
foreach ($teachers as $teacher) {
    if ($teacher->id == $user->id) {
        $is_teacher = true;
        break; // Exit the loop once the user is found
    }
}



if ($is_teacher) {
          // Query to fetch cohorts where the cohortmainteacher is the teacher's ID
          //$cohorts = $DB->get_records('cohort', array('cohortmainteacher' => $user->id));

         $sql = "
    SELECT *
      FROM {cohort}
     WHERE (cohortmainteacher = :mainid OR cohortguideteacher = :guideid)
       AND visible = :visible
";

$params = [
    'mainid'  => $user->id,
    'guideid' => $user->id,
    'visible' => 1,
];

        $cohorts = $DB->get_records_sql($sql, $params);
          // Loop through each cohort
        foreach ($cohorts as $cohort) {
          $cohort_day_found_tutor = false;
          $cohort_day_found = false;
        $cohort_id = (int) trim($cohort->id);

        // if( $cohort_id != 129){
        //  continue;
        // }


        // Fetch cohort details
        $record = $DB->get_record('cohort', ['id' => $cohort_id]);

        if($cohort->cohortmainteacher === $user->id)
        {

          // Get the cohort's hour and minute
        $hour = !empty($record->cohorthours) ? (int)$record->cohorthours : 0;
        $minute = !empty($record->cohortminutes) ? $record->cohortminutes : 0;

        // Define the days the cohort is scheduled for
        $M = !empty($record->cohortmonday) ? $record->cohortmonday : 0;
        $T = !empty($record->cohorttuesday) ? $record->cohorttuesday : 0;
        $W = !empty($record->cohortwednesday) ? $record->cohortwednesday : 0;
        $TH = !empty($record->cohortthursday) ? $record->cohortthursday : 0;
        $F = !empty($record->cohortfriday) ? $record->cohortfriday : 0;

        // Get today's day of the week (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
        $today_day_of_week = date('w'); // This will give you a number from 0 (Sunday) to 6 (Saturday)

        // Define an array to map days of the week
        $week_days = ['0' => 'Sun', '1' => 'Mon', '2' => 'Tue', '3' => 'Wed', '4' => 'Thu', '5' => 'Fri', '6' => 'Sat'];
        $today_day = $week_days[$today_day_of_week];

        // Determine the cohort days (M, T, W, TH, F)
        $days_red = [];
        if ($M == 1) $days_red[] = 'Mon';
        if ($T == 1) $days_red[] = 'Tue';
        if ($W == 1) $days_red[] = 'Wed';
        if ($TH == 1) $days_red[] = 'Thu';
        if ($F == 1) $days_red[] = 'Fri';

        // If today is one of the cohort days, set the time for today
        $cohort_day_found = false;
        // $today_day = 'Fri';
        foreach ($days_red as $day) {
            if ($today_day === $day) {
                $cohort_day_found = true;
                break;
            }
        }

        }else{
 // Get the cohort's hour and minute
        $hourtutor = !empty($record->cohorttutorhours) ? (int)$record->cohorttutorhours : 0;
        $minute_tutor = !empty($record->cohorttutorminutes) ? $record->cohorttutorminutes : 0;

        // Define the days the cohort is scheduled for
        $M_tutor = !empty($record->cohorttutormonday) ? $record->cohorttutormonday : 0;
        $T_tutor = !empty($record->cohorttutortuesday) ? $record->cohorttutortuesday : 0;
        $W_tutor = !empty($record->cohorttutorwednesday) ? $record->cohorttutorwednesday : 0;
        $TH_tutor = !empty($record->cohorttutorthursday) ? $record->cohorttutorthursday : 0;
        $F_tutor = !empty($record->cohorttutorfriday) ? $record->cohorttutorfriday : 0;

        // Get today's day of the week (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
        $today_day_of_week_tutor = date('w'); // This will give you a number from 0 (Sunday) to 6 (Saturday)

        // Define an array to map days of the week
        $week_days_tutor = ['0' => 'Sun', '1' => 'Mon', '2' => 'Tue', '3' => 'Wed', '4' => 'Thu', '5' => 'Fri', '6' => 'Sat'];
        $today_day_tutor = $week_days_tutor[$today_day_of_week_tutor];

        // Determine the cohort days (M, T, W, TH, F)
        $days_red_tutor = [];
        if ($M_tutor == 1) $days_red_tutor[] = 'Mon';
        if ($T_tutor == 1) $days_red_tutor[] = 'Tue';
        if ($W_tutor == 1) $days_red_tutor[] = 'Wed';
        if ($TH_tutor == 1) $days_red_tutor[] = 'Thu';
        if ($F_tutor == 1) $days_red_tutor[] = 'Fri';

        // If today is one of the cohort days, set the time for today
        $cohort_day_found_tutor = false;
        // $today_day = 'Fri';
        foreach ($days_red_tutor as $day_tutor) {
            if ($today_day_tutor === $day_tutor) {
                $cohort_day_found_tutor = true;
                break;
            }
        }
        }




        

        // Set the target cohort timestamp based on the selected cohort day (today or previous day)
        if ((isset($cohort_day_found) && $cohort_day_found) || (isset($cohort_day_found_tutor) && $cohort_day_found_tutor)) {


          // Use today's date if it's a cohort day
          $today = date('Y-m-d');
           

           if($cohort_day_found_tutor)
          {
            // Convert the cohort's time (today's date) to a timestamp
          $cohort_timestamp = strtotime("$today $hourtutor:$minute_tutor");

          }else{
            // Convert the cohort's time (today's date) to a timestamp
          $cohort_timestamp = strtotime("$today $hour:$minute");
            
          }

          

          // Add 1 hour and 15 minutes to the cohort's time
          $target_timestamp = strtotime('+1 hour 15 minutes', $cohort_timestamp);

          // Get the current time
          $current_timestamp = time();

          // Allow for a 5-minute tolerance (i.e., check if the current time is between 1 hour 15 minutes and 1 hour 20 minutes later)
          if ($current_timestamp >= $target_timestamp && $current_timestamp <= ($target_timestamp + 36000)) {
              
                        // Get the start and end timestamps for today
                        $startOfDay = strtotime("today midnight");
                        $endOfDay = strtotime("tomorrow midnight") - 1;
            
                       // Check if a record exists for today with alert_status = 0 and matching cohortid
                      $recordExists = $DB->record_exists_select(
                        'popup_alert',
                        'user_id = :userid AND alert_status = :status AND cohortid = :cohortid AND timestamp BETWEEN :start AND :end',
                        [
                            'userid' => $user->id,
                            'status' => 0,
                            'cohortid' => $cohort->id, // Add cohort ID to the conditions
                            'start' => $startOfDay,
                            'end' => $endOfDay,
                        ]
                      );

                        if (!$recordExists) {

                           //Delete the record where user_id matches
                            // $DB->delete_records('popup_alert', [
                            //                       'user_id'   => $user->id,
                            //                       'cohortid'  => $cohort->id
                            //                   ]);

                                        

            $cohortshortname = $cohort->shortname;
            $today = date('F j');

            // Ensure these are available before the JS block
            $userid = $user->id;
            $cohortid = $cohort_id;
            


             require_once('schedule_session.php');
             // echo "The current time is between 1 hour 15 minutes and 1 hour 20 minutes later than the cohort's time.";

                        }
          }
        }
}

}

//ob_end_clean(); // Clear any output generated by config.php
    
?>

<!--<div class="nav-mobile">-->
    
<!--</div>-->

<?php
}
