<?php
echo '<section class="profile-card">
                <h2>'.get_string('loginactivity', 'core_user').'</h2>
                <div class="info-list">
                    <div class="info-item">
                        <span class="info-label">'.get_string('firstaccess').'</span>
                        <span class="info-value">';
                        if ($user->firstaccess) {
                            $format = get_string('strftimedaydatehourminuteshort', 'langconfig');
                            echo userdate($user->firstaccess, '%A, %d %B %Y, %I:%M %p').' ('.format_time(time() - $user->firstaccess).')';
                        } else {
                            echo get_string('never');
                        }
                        echo '</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">'.get_string('lastaccess').'</span>
                                    <span class="info-value">';
                        if ($user->lastaccess) {
                            echo userdate($user->lastaccess, '%A, %d %B %Y, %I:%M %p').' ('.format_time(time() - $user->lastaccess).')';
                        } else {
                            echo get_string('never');
                        }
                        echo '</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">'.get_string('lastip').'</span>
                                    <span class="info-value">';
                        if (!empty($user->lastip)) {
                            echo $user->lastip;
                        } else {
                            echo get_string('none');
                        }
                        echo '</span>
                    </div>
                </div>
            </section>
            ';
?>