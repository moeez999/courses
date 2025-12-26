<?php
 echo '
            <section class="profile-card">
            <h2>'.get_string('contactinfo', 'core_user').'</h2>
            <div class="info-list">
                <div class="info-item">
                <span class="info-label">'.get_string('email').'</span>
                <span class="info-value">'.$user->email.'</span>
                </div>';
                echo '<div class="info-item">
                <span class="info-label">'.get_string('phone').'</span>
                <span class="info-value">'.$user->phone1.'</span>
                </div>';
            if (!isset($hiddenfields['country']) && $user->country) {
                echo '<div class="info-item">
                <span class="info-label">'.get_string('country').'</span>
                <span class="info-value">'.get_string($user->country, 'countries').'</span>
                </div>';
            }

            if (!isset($hiddenfields['city']) && $user->city) {
                echo '<div class="info-item">
                <span class="info-label">'.get_string('city').'</span>
                <span class="info-value">'.$user->city.'</span>
                </div>';
            }
            if (!isset($hiddenfields['timezone'])) {
                $timezone_value = $user->timezone;
                
                if ($timezone_value == '99') {
                    // Display "Server default" + the actual timezone in parentheses
                    $display_timezone =   core_date::get_server_timezone();
                } else {
                    // Display the user's selected timezone
                    $timezone_list = core_date::get_list_of_timezones();
                    $display_timezone = $timezone_list[$timezone_value] ?? $timezone_value;
                }

                echo '<div class="info-item">
                    <span class="info-label">'.get_string('timezone').'</span>
                    <span class="info-value">'.$display_timezone.'</span>
                    </div>';
            }
            if (!isset($hiddenfields['cohort'])) {
                // Get all cohorts the user belongs to
                $cohorts = $DB->get_records_sql("
                    SELECT c.id, c.name, c.idnumber, c.description
                    FROM {cohort} c
                    JOIN {cohort_members} cm ON cm.cohortid = c.id
                    WHERE cm.userid = :userid
                    ORDER BY c.name
                ", ['userid' => $user->id]);

                if (!empty($cohorts)) {
                    echo '<div class="info-item">
                        <span class="info-label">'.get_string('currentcohort', 'core_user').'</span>
                        <span class="info-value">';
                    
                    $cohortnames = [];
                    foreach ($cohorts as $cohort) {
                        $cohortnames[] = format_string($cohort->name);
                    }
                    echo implode(', ', $cohortnames);
                    
                    echo '</span></div>';
                }
            }

// Add other contact fields as needed
echo '</div></section>';
?>