<?php
// Get cohort history for the user
try {
    // Get cohort history - only using existing columns
    $sql = "SELECT c.id, c.name, c.idnumber, cm.timeadded
            FROM {cohort} c
            JOIN {cohort_members} cm ON cm.cohortid = c.id
            WHERE cm.userid = ?
            ORDER BY cm.timeadded DESC";
    
    $params = [$user->id];
    $cohorts = $DB->get_records_sql($sql, $params);

    echo '
    <div class="row">
        <div class="col-lg-5 col-md-12">
            <section class="profile-card">
                <h2>' . get_string('historycohorts', 'core_user') . '</h2>
                <div class="cohort-list">';

    if (!empty($cohorts)) {
        $current_cohorts = cohort_get_user_cohorts($user->id);
        $current_cohort_ids = array_keys($current_cohorts);
        $badge_colors = ['purple', 'olive'];
        $color_index = 0;
        
        foreach ($cohorts as $cohort) {
            $is_current = in_array($cohort->id, $current_cohort_ids);
            $badge_class = $badge_colors[$color_index % count($badge_colors)];
            $color_index++;
            
            // Format display
            $cohort_name = format_string($cohort->name);
            $cohort_parts = explode(' ', $cohort_name);
            $level = isset($cohort_parts[0]) ? $cohort_parts[0] : '--';
            
            echo '
                <div class="cohort-item">
                    <div class="cohort-info">
                        <div class="cohort-level-badge ' . $badge_class . '">
                            <span class="level-main">' . s(substr($level, 0, 2)) . '</span>
                            <span class="level-sub">Lvl-' . s(substr($level, 2, 1)) . '</span>
                        </div>
                        <span>' . s($cohort_name) . '</span>
                    </div>
                    <span class="cohort-date ' . ($is_current ? 'present' : '') . '">
                        ' . userdate($cohort->timeadded, get_string('strftimedateshort')) . ' - ' .
                        ($is_current ? get_string('present', 'core_user') : '') . '
                    </span>
                </div>';
        }
    } else {
        echo '<div class="no-cohorts">' . get_string('nohistorycohorts', 'core_cohort') . '</div>';
    }

    echo '
                </div>
            </section>
        </div>';

} catch (Exception $e) {
    echo '<div class="alert alert-danger">Error loading cohort data</div>';
    debugging($e->getMessage(), DEBUG_DEVELOPER);
}
?>