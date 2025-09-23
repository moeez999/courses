<?php
require_once('../../config.php'); // Moodle config file for database connection.
require_once(__DIR__ . '/lib.php');
// Include the necessary files (if not already included)
require_once($CFG->libdir . '/oauthlib.php');

global $DB;

if (isset($_POST['cohortid']) && isset($_POST['dates'])) {
    $cohortid = intval($_POST['cohortid']);
     // Get the dates array from POST data and decode the JSON string
     $dates = json_decode($_POST['dates']);
     $converted_dates = convert_dates($dates);
     

    // Get cohort details
    $cohort = $DB->get_record('cohort', ['id' => $cohortid]);
    if (!$cohort) {
        echo json_encode(['error' => 'Cohort not found']);
        exit;
    }

    $courseid = 2;
    $urls = get_meet_urls($courseid, $cohortid, $cohort->shortname);

      // Get cohort members
      $members = $DB->get_records('cohort_members', ['cohortid' => $cohortid]);
    
      //$member_details = [];
      $teacher_details = [];

      $member_details = []; // Use an associative array with user ID or email as the key

      $all_member_details = [ // Initialize the final array to store all attendance
        'email_based_attendance' => [],
        'display_name_based_attendance' => [],
        'former_students_attendance' => [],
        'teachers_attendance' => []
    ];
    
    $member_details_send = [ // Use this for temporary storage for each iteration
        'email_based_attendance' => [],
        'display_name_based_attendance' => [],
        'former_students_attendance' => [],
        'teachers_attendance' => []
    ];

    // Initialize the start and end dates
// $startDate = '2025-01-19';
// $endDate = '2025-01-25';

// // Create an array to store the dates
// $converted_dates = [];

// // Loop through the range of dates
// $currentDate = $startDate;
// while ($currentDate <= $endDate) {
//     $converted_dates[] = $currentDate; // Add the current date to the array
//     $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day')); // Increment by 1 day
// }
    
foreach ($converted_dates as $date) {
    //$date = '2025-01-22';
    foreach ($urls as $url) {
        //$code = 'tqbmtfvepd';
       $meeting_details = get_data_per_url($url, $date);

       // Skip iteration if both 'emails' and 'display_names' are empty
        if (empty($meeting_details['emails']) && empty($meeting_details['display_names']) && empty($meeting_details['teachers'])) {
            continue; // Move to the next URL
        }

        // Convert the date to "Dec-11" format
        $formatted_date = date('M-d', strtotime($date));

        // Collect members' details
        foreach ($members as $member) {
            $user = $DB->get_record('user', ['id' => $member->userid], 'id, firstname, lastname, email, phone1');
            $full_name = $user ? ($user->firstname . ' ' . $user->lastname) : $member->displayname;

            $record_added_to_email_based = false;

             // Extract email values from $emails array
            $emailList = array_column($meeting_details['emails'], 'email');

            // Generate profile picture URL
            require_once($CFG->libdir . '/filelib.php');
            // $user_picture_url = moodle_url::make_pluginfile_url(
            //     context_user::instance($user->id)->id,
            //     'user',
            //     'icon',
            //     null,
            //     '/',
            //     'f1'
            // )->out(false);


            $user_picture = new user_picture($user);
    $user_picture->size = 1; // f1
    $user_picture_url = $user_picture->get_url($PAGE)->out(false);


$email = strtolower(trim($user->email));
$userSubscriptionStatus = 'NA';

// 1️⃣ Check PayPal subscriptions by email
$paypalSubs = $DB->get_records_sql("
    SELECT status FROM {paypal_subscriptions}
    WHERE LOWER(email) = :email
    ORDER BY id DESC
", ['email' => $email]);

foreach ($paypalSubs as $sub) {
    $status = strtolower($sub->status);
    if ($status === 'active') {
        $userSubscriptionStatus = 'active';
        break;
    } elseif ($status === 'suspended') {
        $userSubscriptionStatus = 'Suspended';
    } elseif ($status === 'cancelled') {
        $userSubscriptionStatus = 'Canceled';
    }
}

// 2️⃣ Check local subscriptions
if ($userSubscriptionStatus === 'NA') {
    $localSub = $DB->get_record_sql("
        SELECT sub_status FROM {local_subscriptions}
        WHERE LOWER(sub_email) = :email AND sub_status = 1
        ORDER BY id DESC
        LIMIT 1
    ", ['email' => $email]);

    if ($localSub) {
        $userSubscriptionStatus = 'active';
    }
}

// 3️⃣ Check Patreon subscriptions
if ($userSubscriptionStatus === 'NA') {
    $patreonSubs = $DB->get_records_sql("
        SELECT status FROM {membership_patreon_subscriptions}
        WHERE LOWER(email) = :email
        ORDER BY id DESC
    ", ['email' => $email]);

    foreach ($patreonSubs as $sub) {
        $status = strtolower($sub->status);
        if ($status === 'active_patron') {
            $userSubscriptionStatus = 'active';
            break;
        } elseif ($status === 'declined_patron') {
            $userSubscriptionStatus = 'Declined';
        } elseif ($status === 'former_patron') {
            $userSubscriptionStatus = 'Inactive';
        }
    }
}

// Final fallback if matched but not active
if ($userSubscriptionStatus === 'NA' &&
   (!empty($paypalSubs) || !empty($localSub) || !empty($patreonSubs))) {
    $userSubscriptionStatus = 'Inactive';
}

if ($userSubscriptionStatus === 'NA') {
    // 4️⃣ Get custom profile field value for SubID
    $subIDField = $DB->get_record('user_info_data', [
        'userid' => $user->id,
        'fieldid' => $DB->get_field('user_info_field', 'id', ['shortname' => 'SubID'])
    ]);

    if ($subIDField && !empty($subIDField->data)) {
        $subscriberId = trim($subIDField->data);

         if ($subscriberId === 'Exclusive') {
            $userSubscriptionStatus = 'Exclusive';  // Set to 'Exclusive' and skip further checks
        }elseif(preg_match('/^Exclusive(\d+)$/', $subscriberId, $matches)){
            // Handle dynamic Exclusive values like Exclusive1, Exclusive2, etc.
                $userSubscriptionStatus = 'Exclusive' . $matches[1];  // Append dynamic number to "Exclusive"
        } else {

        // Check PayPal subscriptions
        $paypalSubsById = $DB->get_records_sql("
            SELECT status FROM {paypal_subscriptions}
            WHERE subscription_id = :subid
            ORDER BY id DESC
        ", ['subid' => $subscriberId]);

        foreach ($paypalSubsById as $sub) {
            $status = strtolower($sub->status);
            if ($status === 'active') {
                $userSubscriptionStatus = 'active';
                break;
            } elseif ($status === 'suspended') {
                $userSubscriptionStatus = 'Suspended';
            } elseif ($status === 'cancelled') {
                $userSubscriptionStatus = 'Canceled';
            }
        }

        // Check local subscriptions
        if ($userSubscriptionStatus === 'NA') {
            $localSubById = $DB->get_record_sql("
                SELECT sub_status FROM {local_subscriptions}
                WHERE sub_reference = :sub_reference AND sub_status = 1
                ORDER BY id DESC
                LIMIT 1
            ", ['sub_reference' => $subscriberId]);

            if ($localSubById) {
                $userSubscriptionStatus = 'active';
            }

            if($userSubscriptionStatus === 'NA')
            {
               $localSubByIdd = $DB->get_record_sql("
                SELECT sub_status FROM {local_subscriptions}
                WHERE sub_reference = :sub_reference AND sub_status = 0
                ORDER BY id DESC
                LIMIT 1
            ", ['sub_reference' => $subscriberId]);

            if ($localSubByIdd) {
                $userSubscriptionStatus = 'canceled';
            }
  
            }

        }

        //Check Patreon subscriptions
        if ($userSubscriptionStatus === 'NA') {
            $patreonSubsById = $DB->get_records_sql("
                SELECT status FROM {membership_patreon_subscriptions}
                WHERE subscriber_id = :subid
                ORDER BY id DESC
            ", ['subid' => $subscriberId]);

            foreach ($patreonSubsById as $sub) {
                $status = strtolower($sub->status);
                if ($status === 'active_patron') {
                    $userSubscriptionStatus = 'active';
                    break;
                } elseif ($status === 'declined_patron') {
                    $userSubscriptionStatus = 'Declined';
                } elseif ($status === 'former_patron') {
                    $userSubscriptionStatus = 'Inactive';
                }
            }
        }

        // Final fallback after SubID checks
        if ($userSubscriptionStatus === 'NA' &&
           (!empty($paypalSubsById) || !empty($localSubById) || !empty($patreonSubsById))) {
            $userSubscriptionStatus = 'Inactive';
        }
    }
    }
}

// ✅ Now check manual_user_registrations if still NA
if ($userSubscriptionStatus === 'NA') {
    $manualSubs = $DB->get_records_sql("
        SELECT start_date, end_date, status
        FROM {manual_user_registrations}
        WHERE userid = ?
        ORDER BY id DESC
    ", [$user->id]);

    $now = time();

    foreach ($manualSubs as $sub) {
        $start = (int)$sub->start_date;
        $end = (int)$sub->end_date;
        $status = strtolower($sub->status);

        if ($status === 'active') {
            if ($start <= $now && $now <= $end) {
                $userSubscriptionStatus = 'active';
                break;
            } elseif ($end < $now) {
                $userSubscriptionStatus = 'Expired';

                // 🔧 Optionally mark it inactive in DB
                $DB->execute("UPDATE {manual_user_registrations} SET status = 'inactive' WHERE userid = ? AND status = 'active'", [$user->id]);
            } elseif ($start > $now) {
                $userSubscriptionStatus = 'Upcoming';
            }
        }
    }
}

            // Email-based attendance
            if ($user && !empty($meeting_details['emails'])) {
                if (in_array($user->email, $emailList)) {

                     // Find the matching record for the user
                    $userMeetingDetails = null;

                    // Loop through each meeting detail and find the record for the matching email
                    foreach ($meeting_details['emails'] as $details) {
                        if ($details['email'] === $user->email) {
                            $userMeetingDetails = $details; // Store the matched record
                            break; // Exit the loop once the user record is found
                        }
                    }
                    
                    $attendance_entry_email = [
                        'id' => $user->id,
                        'firstname' => $user->firstname,
                        'lastname' => $user->lastname,
                        'email' => $user->email,
                        'phone' => $user->phone1,
                        'date' => $formatted_date,
                        'attendance' => 'P',
                        'start' => $userMeetingDetails['start'],
                        'left' => $userMeetingDetails['left'],
                        'duration' => $userMeetingDetails['duration'],
                        'profile_picture' => $user_picture_url,
                        'status' => ucwords($userSubscriptionStatus)

                    ];
                    $member_details_send['email_based_attendance'][] = $attendance_entry_email;
                    $record_added_to_email_based = true;

                    // Remove the email from the meeting details
                    $email_key = array_search($user->email, $emailList);
                    if ($email_key !== false) {
                        unset($meeting_details['emails'][$email_key]);
                        // Reindex the array
                    $meeting_details['emails'] = array_values($meeting_details['emails']);
                    }
                }else{
                    $attendance_entry_email = [
                        'id' => $user->id,
                        'firstname' => $user->firstname,
                        'lastname' => $user->lastname,
                        'email' => $user->email,
                        'phone' => $user->phone1,
                        'date' => $formatted_date,
                        'attendance' => 'A',
                        'start' => 'NA',
                        'left' => 'NA',
                        'duration' => 'NA',
                        'profile_picture' => $user_picture_url,
                        'status' => ucwords($userSubscriptionStatus)

                        
                    ];
                    $member_details_send['email_based_attendance'][] = $attendance_entry_email;
                    $record_added_to_email_based = true;  
                }
            }
        }


                        // Step 1: Get the custom field's ID for 'cohort'
            $field = $DB->get_record('user_info_field', ['shortname' => 'cohort'], 'id');

            if ($field) {
                $fieldid = $field->id;

                // Step 2: Query to fetch user records
                $sql = "SELECT u.id, u.email, u.firstname, u.lastname, u.username, u.city, u.country
                        FROM {user} u
                        JOIN {user_info_data} uid ON u.id = uid.userid
                        WHERE uid.fieldid = :fieldid AND uid.data = :cohortid";

                $params = [
                    'fieldid' => $fieldid,
                    'cohortid' => $cohortid
                ];

                $userRecords = $DB->get_records_sql($sql, $params);

                // Step 3: Build a quick lookup array for user emails
                $userEmails = [];
                foreach ($userRecords as $record) {
                    $userEmails[] = $record->email;
                }

                // Step 4: Non-student attendance
                if (!empty($meeting_details['emails'])) {
                    // Extract email values from $emails array
            $emailListt = array_column($meeting_details['emails'], 'email');
                    foreach ($meeting_details['emails'] as $detail) {
                        // Extract email and display name from the detail
                        $email = $detail['email'] ?? null;
                        $display_name = $detail['display_name'] ?? '';

                        // Proceed only if the email is in the userEmails array
                        if ($email && in_array($email, $userEmails)) {
                            $userr = $DB->get_record('user', ['email' => $email], 'id, firstname, lastname, email, phone1');

$email = strtolower(trim($userr->email));
$userSubscriptionStatus = 'NA';

// 1️⃣ Check PayPal subscriptions by email
$paypalSubs = $DB->get_records_sql("
    SELECT status FROM {paypal_subscriptions}
    WHERE LOWER(email) = :email
    ORDER BY id DESC
", ['email' => $email]);

foreach ($paypalSubs as $sub) {
    $status = strtolower($sub->status);
    if ($status === 'active') {
        $userSubscriptionStatus = 'active';
        break;
    } elseif ($status === 'suspended') {
        $userSubscriptionStatus = 'Suspended';
    } elseif ($status === 'cancelled') {
        $userSubscriptionStatus = 'Canceled';
    }
}

// 2️⃣ Check local subscriptions
if ($userSubscriptionStatus === 'NA') {
    $localSub = $DB->get_record_sql("
        SELECT sub_status FROM {local_subscriptions}
        WHERE LOWER(sub_email) = :email AND sub_status = 1
        ORDER BY id DESC
        LIMIT 1
    ", ['email' => $email]);

    if ($localSub) {
        $userSubscriptionStatus = 'active';
    }
}

// 3️⃣ Check Patreon subscriptions
if ($userSubscriptionStatus === 'NA') {
    $patreonSubs = $DB->get_records_sql("
        SELECT status FROM {membership_patreon_subscriptions}
        WHERE LOWER(email) = :email
        ORDER BY id DESC
    ", ['email' => $email]);

    foreach ($patreonSubs as $sub) {
        $status = strtolower($sub->status);
        if ($status === 'active_patron') {
            $userSubscriptionStatus = 'active';
            break;
        } elseif ($status === 'declined_patron') {
            $userSubscriptionStatus = 'Declined';
        } elseif ($status === 'former_patron') {
            $userSubscriptionStatus = 'Inactive';
        }
    }
}

// Final fallback if matched but not active
if ($userSubscriptionStatus === 'NA' &&
   (!empty($paypalSubs) || !empty($localSub) || !empty($patreonSubs))) {
    $userSubscriptionStatus = 'Inactive';
}

if ($userSubscriptionStatus === 'NA') {
    // 4️⃣ Get custom profile field value for SubID
    $subIDField = $DB->get_record('user_info_data', [
        'userid' => $userr->id,
        'fieldid' => $DB->get_field('user_info_field', 'id', ['shortname' => 'SubID'])
    ]);

    if ($subIDField && !empty($subIDField->data)) {
        $subscriberId = trim($subIDField->data);

         if ($subscriberId === 'Exclusive') {
            $userSubscriptionStatus = 'Exclusive';  // Set to 'Exclusive' and skip further checks
        }elseif(preg_match('/^Exclusive(\d+)$/', $subscriberId, $matches)){
            // Handle dynamic Exclusive values like Exclusive1, Exclusive2, etc.
                $userSubscriptionStatus = 'Exclusive' . $matches[1];  // Append dynamic number to "Exclusive"
        } else {

        // Check PayPal subscriptions
        $paypalSubsById = $DB->get_records_sql("
            SELECT status FROM {paypal_subscriptions}
            WHERE subscription_id = :subid
            ORDER BY id DESC
        ", ['subid' => $subscriberId]);

        foreach ($paypalSubsById as $sub) {
            $status = strtolower($sub->status);
            if ($status === 'active') {
                $userSubscriptionStatus = 'active';
                break;
            } elseif ($status === 'suspended') {
                $userSubscriptionStatus = 'Suspended';
            } elseif ($status === 'cancelled') {
                $userSubscriptionStatus = 'Canceled';
            }
        }

        // Check local subscriptions
        if ($userSubscriptionStatus === 'NA') {
            $localSubById = $DB->get_record_sql("
                SELECT sub_status FROM {local_subscriptions}
                WHERE sub_reference = :sub_reference AND sub_status = 1
                ORDER BY id DESC
                LIMIT 1
            ", ['sub_reference' => $subscriberId]);

            if ($localSubById) {
                $userSubscriptionStatus = 'active';
            }

            if($userSubscriptionStatus === 'NA')
            {
               $localSubByIdd = $DB->get_record_sql("
                SELECT sub_status FROM {local_subscriptions}
                WHERE sub_reference = :sub_reference AND sub_status = 0
                ORDER BY id DESC
                LIMIT 1
            ", ['sub_reference' => $subscriberId]);

            if ($localSubByIdd) {
                $userSubscriptionStatus = 'canceled';
            }
  
            }

        }

        //Check Patreon subscriptions
        if ($userSubscriptionStatus === 'NA') {
            $patreonSubsById = $DB->get_records_sql("
                SELECT status FROM {membership_patreon_subscriptions}
                WHERE subscriber_id = :subid
                ORDER BY id DESC
            ", ['subid' => $subscriberId]);

            foreach ($patreonSubsById as $sub) {
                $status = strtolower($sub->status);
                if ($status === 'active_patron') {
                    $userSubscriptionStatus = 'active';
                    break;
                } elseif ($status === 'declined_patron') {
                    $userSubscriptionStatus = 'Declined';
                } elseif ($status === 'former_patron') {
                    $userSubscriptionStatus = 'Inactive';
                }
            }
        }

        // Final fallback after SubID checks
        if ($userSubscriptionStatus === 'NA' &&
           (!empty($paypalSubsById) || !empty($localSubById) || !empty($patreonSubsById))) {
            $userSubscriptionStatus = 'Inactive';
        }
    }
    }
}

// ✅ Now check manual_user_registrations if still NA
if ($userSubscriptionStatus === 'NA') {
    $manualSubs = $DB->get_records_sql("
        SELECT start_date, end_date, status
        FROM {manual_user_registrations}
        WHERE userid = ?
        ORDER BY id DESC
    ", [$userr->id]);

    $now = time();

    foreach ($manualSubs as $sub) {
        $start = (int)$sub->start_date;
        $end = (int)$sub->end_date;
        $status = strtolower($sub->status);

        if ($status === 'active') {
            if ($start <= $now && $now <= $end) {
                $userSubscriptionStatus = 'active';
                break;
            } elseif ($end < $now) {
                $userSubscriptionStatus = 'Expired';

                // 🔧 Optionally mark it inactive in DB
                $DB->execute("UPDATE {manual_user_registrations} SET status = 'inactive' WHERE userid = ? AND status = 'active'", [$user->id]);
            } elseif ($start > $now) {
                $userSubscriptionStatus = 'Upcoming';
            }
        }
    }
}


                            // Generate profile picture URL
                            require_once($CFG->libdir . '/filelib.php');
                            // $user_picture_url = moodle_url::make_pluginfile_url(
                            //     context_user::instance($userr->id)->id,
                            //     'user',
                            //     'icon',
                            //     null,
                            //     '/',
                            //     'f1'
                            // )->out(false);

                            $user_picture = new user_picture($userr);
                            $user_picture->size = 1; // f1
                            $user_picture_url = $user_picture->get_url($PAGE)->out(false);
                            // Create attendance entry
                            $attendance_entry_former_students = [
                                'id' => $userr->id,
                                'firstname' => $userr->firstname,
                                'lastname' => $userr->lastname,
                                'email' => $userr->email,
                                'phone' => $userr->phone1,
                                'date' => $formatted_date,
                                'attendance' => 'P',
                                'start' => $detail['start'],
                                'left' => $detail['left'],
                                'duration' => $detail['duration'],
                                'profile_picture' => $user_picture_url,
                                'status' => ucwords($userSubscriptionStatus)
                            ];

                            // Add the attendance entry to the email-based attendance array
                            $member_details_send['former_students_attendance'][] = $attendance_entry_former_students;
                              // Remove the email from the meeting details
                                $email_key = array_search($email, $emailListt);
                                if ($email_key !== false) {
                                    unset($meeting_details['emails'][$email_key]);
                                    // Reindex the array
                                $meeting_details['emails'] = array_values($meeting_details['emails']);
                                }

                                                    // Remove the email from the userEmails array
                                $userEmailKey = array_search($email, $userEmails);
                                if ($userEmailKey !== false) {
                                    unset($userEmails[$userEmailKey]);
                                    // Reindex the userEmails array
                                    $userEmails = array_values($userEmails);
                                }
                        }
                    }
                }


                // Step 5: Non-student attendance (Absent)
                if (!empty($userEmails)) {
                    foreach ($userEmails as $absentEmail) {
                        $userr = $DB->get_record('user', ['email' => $absentEmail], 'id, firstname, lastname, email, phone1');

$email = strtolower(trim($userr->email));
$userSubscriptionStatus = 'NA';

// 1️⃣ Check PayPal subscriptions by email
$paypalSubs = $DB->get_records_sql("
    SELECT status FROM {paypal_subscriptions}
    WHERE LOWER(email) = :email
    ORDER BY id DESC
", ['email' => $email]);

foreach ($paypalSubs as $sub) {
    $status = strtolower($sub->status);
    if ($status === 'active') {
        $userSubscriptionStatus = 'active';
        break;
    } elseif ($status === 'suspended') {
        $userSubscriptionStatus = 'Suspended';
    } elseif ($status === 'cancelled') {
        $userSubscriptionStatus = 'Canceled';
    }
}

// 2️⃣ Check local subscriptions
if ($userSubscriptionStatus === 'NA') {
    $localSub = $DB->get_record_sql("
        SELECT sub_status FROM {local_subscriptions}
        WHERE LOWER(sub_email) = :email AND sub_status = 1
        ORDER BY id DESC
        LIMIT 1
    ", ['email' => $email]);

    if ($localSub) {
        $userSubscriptionStatus = 'active';
    }
}

// 3️⃣ Check Patreon subscriptions
if ($userSubscriptionStatus === 'NA') {
    $patreonSubs = $DB->get_records_sql("
        SELECT status FROM {membership_patreon_subscriptions}
        WHERE LOWER(email) = :email
        ORDER BY id DESC
    ", ['email' => $email]);

    foreach ($patreonSubs as $sub) {
        $status = strtolower($sub->status);
        if ($status === 'active_patron') {
            $userSubscriptionStatus = 'active';
            break;
        } elseif ($status === 'declined_patron') {
            $userSubscriptionStatus = 'Declined';
        } elseif ($status === 'former_patron') {
            $userSubscriptionStatus = 'Inactive';
        }
    }
}

// Final fallback if matched but not active
if ($userSubscriptionStatus === 'NA' &&
   (!empty($paypalSubs) || !empty($localSub) || !empty($patreonSubs))) {
    $userSubscriptionStatus = 'Inactive';
}

if ($userSubscriptionStatus === 'NA') {
    // 4️⃣ Get custom profile field value for SubID
    $subIDField = $DB->get_record('user_info_data', [
        'userid' => $userr->id,
        'fieldid' => $DB->get_field('user_info_field', 'id', ['shortname' => 'SubID'])
    ]);

    if ($subIDField && !empty($subIDField->data)) {
        $subscriberId = trim($subIDField->data);

         if ($subscriberId === 'Exclusive') {
            $userSubscriptionStatus = 'Exclusive';  // Set to 'Exclusive' and skip further checks
        }elseif(preg_match('/^Exclusive(\d+)$/', $subscriberId, $matches)){
            // Handle dynamic Exclusive values like Exclusive1, Exclusive2, etc.
                $userSubscriptionStatus = 'Exclusive' . $matches[1];  // Append dynamic number to "Exclusive"
        } else {

        // Check PayPal subscriptions
        $paypalSubsById = $DB->get_records_sql("
            SELECT status FROM {paypal_subscriptions}
            WHERE subscription_id = :subid
            ORDER BY id DESC
        ", ['subid' => $subscriberId]);

        foreach ($paypalSubsById as $sub) {
            $status = strtolower($sub->status);
            if ($status === 'active') {
                $userSubscriptionStatus = 'active';
                break;
            } elseif ($status === 'suspended') {
                $userSubscriptionStatus = 'Suspended';
            } elseif ($status === 'cancelled') {
                $userSubscriptionStatus = 'Canceled';
            }
        }

        // Check local subscriptions
        if ($userSubscriptionStatus === 'NA') {
            $localSubById = $DB->get_record_sql("
                SELECT sub_status FROM {local_subscriptions}
                WHERE sub_reference = :sub_reference AND sub_status = 1
                ORDER BY id DESC
                LIMIT 1
            ", ['sub_reference' => $subscriberId]);

            if ($localSubById) {
                $userSubscriptionStatus = 'active';
            }

            if($userSubscriptionStatus === 'NA')
            {
               $localSubByIdd = $DB->get_record_sql("
                SELECT sub_status FROM {local_subscriptions}
                WHERE sub_reference = :sub_reference AND sub_status = 0
                ORDER BY id DESC
                LIMIT 1
            ", ['sub_reference' => $subscriberId]);

            if ($localSubByIdd) {
                $userSubscriptionStatus = 'canceled';
            }
  
            }

        }

        //Check Patreon subscriptions
        if ($userSubscriptionStatus === 'NA') {
            $patreonSubsById = $DB->get_records_sql("
                SELECT status FROM {membership_patreon_subscriptions}
                WHERE subscriber_id = :subid
                ORDER BY id DESC
            ", ['subid' => $subscriberId]);

            foreach ($patreonSubsById as $sub) {
                $status = strtolower($sub->status);
                if ($status === 'active_patron') {
                    $userSubscriptionStatus = 'active';
                    break;
                } elseif ($status === 'declined_patron') {
                    $userSubscriptionStatus = 'Declined';
                } elseif ($status === 'former_patron') {
                    $userSubscriptionStatus = 'Inactive';
                }
            }
        }

        // Final fallback after SubID checks
        if ($userSubscriptionStatus === 'NA' &&
           (!empty($paypalSubsById) || !empty($localSubById) || !empty($patreonSubsById))) {
            $userSubscriptionStatus = 'Inactive';
        }
    }
    }
}

// ✅ Now check manual_user_registrations if still NA
if ($userSubscriptionStatus === 'NA') {
    $manualSubs = $DB->get_records_sql("
        SELECT start_date, end_date, status
        FROM {manual_user_registrations}
        WHERE userid = ?
        ORDER BY id DESC
    ", [$userr->id]);

    $now = time();

    foreach ($manualSubs as $sub) {
        $start = (int)$sub->start_date;
        $end = (int)$sub->end_date;
        $status = strtolower($sub->status);

        if ($status === 'active') {
            if ($start <= $now && $now <= $end) {
                $userSubscriptionStatus = 'active';
                break;
            } elseif ($end < $now) {
                $userSubscriptionStatus = 'Expired';

                // 🔧 Optionally mark it inactive in DB
                $DB->execute("UPDATE {manual_user_registrations} SET status = 'inactive' WHERE userid = ? AND status = 'active'", [$user->id]);
            } elseif ($start > $now) {
                $userSubscriptionStatus = 'Upcoming';
            }
        }
    }
}

                        // Generate profile picture URL
                        require_once($CFG->libdir . '/filelib.php');
                        // $user_picture_url = moodle_url::make_pluginfile_url(
                        //     context_user::instance($userr->id)->id,
                        //     'user',
                        //     'icon',
                        //     null,
                        //     '/',
                        //     'f1'
                        // )->out(false);
                        $user_picture = new user_picture($userr);
                        $user_picture->size = 1; // f1
                        $user_picture_url = $user_picture->get_url($PAGE)->out(false);
                        // Create attendance entry
                        $attendance_entry_absent_students = [
                            'id' => $userr->id,
                            'firstname' => $userr->firstname,
                            'lastname' => $userr->lastname,
                            'email' => $userr->email,
                            'phone' => $userr->phone1,
                            'date' => $formatted_date,
                            'attendance' => 'A',
                            'start' => 'NA',
                            'left' => 'NA',
                            'duration' => 'NA',
                            'profile_picture' => $user_picture_url,
                            'status' => ucwords($userSubscriptionStatus)
                        ];

                        // Add the attendance entry to the attendance array
                        $member_details_send['former_students_attendance'][] = $attendance_entry_absent_students;
                    }
                }
            } 


       // Non-student attendance
    if (!empty($meeting_details['emails'])) {
        foreach ($meeting_details['emails'] as $detail) {
            // Extract email and display name from the detail
            $email = $detail['email'] ?? null;
            $display_name = $detail['display_name'] ?? '';

            // Split the display name into first and last name parts
            $name_parts = explode(' ', $display_name);

            // Create attendance entry
            $attendance_entry_display_name = [
                'id' => null, // No user ID associated
                'firstname' => $name_parts[0] ?? '', // First part of the name
                'lastname' => $name_parts[1] ?? '',  // Second part of the name, if available
                'email' => $email, // Associated email
                'phone' => null, // No phone associated
                'date' => $formatted_date, // Formatted date
                'attendance' => 'P', // Mark as present
                'start' => $detail['start'],
                'left' => $detail['left'],
                'duration' => $detail['duration']
            ];

            // Add the attendance entry to the email-based attendance array
            $member_details_send['display_name_based_attendance'][] = $attendance_entry_display_name;
        }
    }


       // Display-name-based attendance
        if (!empty($meeting_details['display_names'])) {
            foreach ($meeting_details['display_names'] as $display_name) {
                if (is_string($display_name)) {
                    // If it's a string, proceed with explode
                    $name_parts = explode(' ', $display_name);
                } elseif (is_array($display_name)) {
                    // Convert array to string and then proceed
                    $display_name_string = implode(' ', $display_name); // Join array elements with a space
                    $name_parts = explode(' ', $display_name_string);
                }
                $attendance_entry_display_name = [
                    'id' => null, // No user ID associated
                    'firstname' => $name_parts[0] ?? '', // First part of the name
                    'lastname' => $name_parts[1] ?? '',  // Second part of the name, if available
                    'email' => null, // No email associated
                    'phone' => null, // No phone associated
                    'date' => $formatted_date, // Formatted date
                    'attendance' => 'P',
                    'start' => $display_name['start'],
                    'left' => $display_name['left'],
                    'duration' => $display_name['duration']
                ];
                $member_details_send['display_name_based_attendance'][] = $attendance_entry_display_name;
            }
        }

        $main_teacherr = $DB->get_record('user', ['id' => $cohort->cohortmainteacher], 'id, firstname, lastname, email, phone1');
        $guide_teacherr = $DB->get_record('user', ['id' => $cohort->cohortguideteacher], 'id, firstname, lastname, email, phone1');

        $flag = 0;

        if($main_teacherr == $guide_teacherr)
        {
            $$flag = 1;

            // Main teacher details
            if (!empty($cohort->cohortmainteacher)) {
                // $date = '2025-01-22';
                 // Convert the date to a timestamp and get the day of the week (0 = Sunday, 1 = Monday, etc.)
                $dayOfWeek = date('N', strtotime($date));  // N gives us the day as a number (1 for Monday, 7 for Sunday)
                $main_teacher = $DB->get_record('user', ['id' => $cohort->cohortmainteacher], 'id, firstname, lastname, email, phone1');
                $M = !empty($cohort->cohortmonday) ? $cohort->cohortmonday : 0;
                $T = !empty($cohort->cohorttuesday) ? $cohort->cohorttuesday : 0;
                $W = !empty($cohort->cohortwednesday) ? $cohort->cohortwednesday : 0;
                $TH = !empty($cohort->cohortthursday) ? $cohort->cohortthursday : 0;
                $F = !empty($cohort->cohortfriday) ? $cohort->cohortfriday : 0;

                // Compare the day of the week with the cohort's values
                    $matchFound = false;

                    switch ($dayOfWeek) {
                        case 1:  // Monday
                            if ($M) {
                                $matchFound = true;
                            }
                            break;
                        case 2:  // Tuesday
                            if ($T) {
                                $matchFound = true;
                            }
                            break;
                        case 3:  // Wednesday
                            if ($W) {
                                $matchFound = true;
                            }
                            break;
                        case 4:  // Thursday
                            if ($TH) {
                                $matchFound = true;
                            }
                            break;
                        case 5:  // Friday
                            if ($F) {
                                $matchFound = true;
                            }
                            break;
                    }

                    // Output if a match was found
                    if ($matchFound) {
                        foreach ($meeting_details['teachers'] as $teach) {
                            // Extract email and display name from the detail
                        $email = $teach['email'] ?? null;
                        $display_name = $teach['display_name'] ?? '';
            
                        // Split the display name into first and last name parts
                        $name_parts = explode(' ', $display_name);

                        $user_picture = new user_picture($main_teacher);
                        $user_picture->size = 1; // f1
                        $user_picture_url = $user_picture->get_url($PAGE)->out(false);
            
                        // Create attendance entry
                        $attendance_teachers = [
                            'id' => null, // No user ID associated
                            'firstname' => $main_teacher->firstname, // First part of the name
                            'lastname' => $main_teacher->lastname,  // Second part of the name, if available
                            'email' => $email, // Associated email
                            'phone' => $main_teacher->phone1, // No phone associated
                            'date' => $formatted_date, // Formatted date
                            'attendance' => 'P', // Mark as present
                            'start' => $teach['start'],
                            'left' => $teach['left'],
                            'duration' => $teach['duration'],
                            'profile_picture' => $user_picture_url
                        ];
            
                        // Add the attendance entry to the email-based attendance array
                        $member_details_send['teachers_attendance'][] = $attendance_teachers;
                        }
                    } else {
                       // Guide teacher details
            if (!empty($cohort->cohortguideteacher)) {
                $guide_teacher = $DB->get_record('user', ['id' => $cohort->cohortguideteacher], 'id, firstname, lastname, email, phone1');
                // Convert the date to a timestamp and get the day of the week (0 = Sunday, 1 = Monday, etc.)
                $dayOfWeekk = date('N', strtotime($date));  // N gives us the day as a number (1 for Monday, 7 for Sunday)

                $MM = !empty($cohort->cohorttutormonday) ? $cohort->cohorttutormonday : 0;
                $TT = !empty($cohort->cohorttutortuesday) ? $cohort->cohorttutortuesday : 0;
                $WW = !empty($cohort->cohorttutorwednesday) ? $cohort->cohorttutorwednesday : 0;
                $THH = !empty($cohort->cohorttutorthursday) ? $cohort->cohorttutorthursday : 0;
                $FF = !empty($cohort->cohorttutorfriday) ? $cohort->cohorttutorfriday : 0;

                // Compare the day of the week with the cohort's values
                $matchFoundd = false;

                switch ($dayOfWeekk) {
                    case 1:  // Monday
                        if ($MM) {
                            $matchFoundd = true;
                        }
                        break;
                    case 2:  // Tuesday
                        if ($TT) {
                            $matchFoundd = true;
                        }
                        break;
                    case 3:  // Wednesday
                        if ($WW) {
                            $matchFoundd = true;
                        }
                        break;
                    case 4:  // Thursday
                        if ($THH) {
                            $matchFoundd = true;
                        }
                        break;
                    case 5:  // Friday
                        if ($FF) {
                            $matchFoundd = true;
                        }
                        break;
                }

                // Output if a match was found
                if ($matchFoundd) {
                    foreach ($meeting_details['teachers'] as $teach) {
                        // Extract email and display name from the detail
                    $email = $teach['email'] ?? null;
                    $display_name = $teach['display_name'] ?? '';
        
                    // Split the display name into first and last name parts
                    $name_parts = explode(' ', $display_name);
                    $user_picture = new user_picture($guide_teacher);
                    $user_picture->size = 1; // f1
                    $user_picture_url = $user_picture->get_url($PAGE)->out(false);
        
                    // Create attendance entry
                    $attendance_teachers = [
                        'id' => null, // No user ID associated
                        'firstname' => $guide_teacher->firstname, // First part of the name
                        'lastname' => $guide_teacher->lastname,  // Second part of the name, if available
                        'email' => $email, // Associated email
                        'phone' => $guide_teacher->phone1, // No phone associated
                        'date' => $formatted_date, // Formatted date
                        'attendance' => 'P', // Mark as present
                        'start' => $teach['start'],
                        'left' => $teach['left'],
                        'duration' => $teach['duration'],
                        'profile_picture' => $user_picture_url
                    ];
        
                    // Add the attendance entry to the email-based attendance array
                    $member_details_send['teachers_attendance'][] = $attendance_teachers;
                    }
                } 

            }
                    }
            }
        }else{


        if (!empty($meeting_details['teachers'])) {
        if ($cohort) {
            // Main teacher details
            if (!empty($cohort->cohortmainteacher)) {
                // $date = '2025-01-22';
                 // Convert the date to a timestamp and get the day of the week (0 = Sunday, 1 = Monday, etc.)
                $dayOfWeek = date('N', strtotime($date));  // N gives us the day as a number (1 for Monday, 7 for Sunday)
                $main_teacher = $DB->get_record('user', ['id' => $cohort->cohortmainteacher], 'id, firstname, lastname, email, phone1');
                $M = !empty($cohort->cohortmonday) ? $cohort->cohortmonday : 0;
                $T = !empty($cohort->cohorttuesday) ? $cohort->cohorttuesday : 0;
                $W = !empty($cohort->cohortwednesday) ? $cohort->cohortwednesday : 0;
                $TH = !empty($cohort->cohortthursday) ? $cohort->cohortthursday : 0;
                $F = !empty($cohort->cohortfriday) ? $cohort->cohortfriday : 0;

                // Compare the day of the week with the cohort's values
                    $matchFound = false;

                    switch ($dayOfWeek) {
                        case 1:  // Monday
                            if ($M) {
                                $matchFound = true;
                            }
                            break;
                        case 2:  // Tuesday
                            if ($T) {
                                $matchFound = true;
                            }
                            break;
                        case 3:  // Wednesday
                            if ($W) {
                                $matchFound = true;
                            }
                            break;
                        case 4:  // Thursday
                            if ($TH) {
                                $matchFound = true;
                            }
                            break;
                        case 5:  // Friday
                            if ($F) {
                                $matchFound = true;
                            }
                            break;
                    }

                    // Output if a match was found
                    if ($matchFound) {
                        foreach ($meeting_details['teachers'] as $teach) {
                            // Extract email and display name from the detail
                        $email = $teach['email'] ?? null;
                        $display_name = $teach['display_name'] ?? '';
            
                        // Split the display name into first and last name parts
                        $name_parts = explode(' ', $display_name);

                        $user_picture = new user_picture($main_teacher);
                        $user_picture->size = 1; // f1
                        $user_picture_url = $user_picture->get_url($PAGE)->out(false);
            
                        // Create attendance entry
                        $attendance_teachers = [
                            'id' => null, // No user ID associated
                            'firstname' => $main_teacher->firstname, // First part of the name
                            'lastname' => $main_teacher->lastname,  // Second part of the name, if available
                            'email' => $email, // Associated email
                            'phone' => $main_teacher->phone1, // No phone associated
                            'date' => $formatted_date, // Formatted date
                            'attendance' => 'P', // Mark as present
                            'start' => $teach['start'],
                            'left' => $teach['left'],
                            'duration' => $teach['duration'],
                            'profile_picture' => $user_picture_url
                        ];
            
                        // Add the attendance entry to the email-based attendance array
                        $member_details_send['teachers_attendance'][] = $attendance_teachers;
                        }
                    } else {
                        foreach ($meeting_details['teachers'] as $teach) {
                            // Extract email and display name from the detail
                        $email = $teach['email'] ?? null;
                        $display_name = $teach['display_name'] ?? '';
            
                        // Split the display name into first and last name parts
                        $name_parts = explode(' ', $display_name);
                        $user_picture = new user_picture($main_teacher);
                        $user_picture->size = 1; // f1
                        $user_picture_url = $user_picture->get_url($PAGE)->out(false);
            
                        // Create attendance entry
                        $attendance_teachers = [
                            'id' => null, // No user ID associated
                            'firstname' => $main_teacher->firstname, // First part of the name
                            'lastname' => $main_teacher->lastname,  // Second part of the name, if available
                            'email' => $email, // Associated email
                            'phone' => $main_teacher->phone1, // No phone associated
                            'date' => $formatted_date, // Formatted date
                            'attendance' => 'NA', // Mark as present
                            'start' => $teach['start'],
                            'left' => $teach['left'],
                            'duration' => $teach['duration'],
                            'profile_picture' => $user_picture_url
                        ];
            
                        // Add the attendance entry to the email-based attendance array
                        $member_details_send['teachers_attendance'][] = $attendance_teachers;
                        }
                    }
            }

            // Guide teacher details
            if (!empty($cohort->cohortguideteacher)) {
                $guide_teacher = $DB->get_record('user', ['id' => $cohort->cohortguideteacher], 'id, firstname, lastname, email, phone1');
                // Convert the date to a timestamp and get the day of the week (0 = Sunday, 1 = Monday, etc.)
                $dayOfWeekk = date('N', strtotime($date));  // N gives us the day as a number (1 for Monday, 7 for Sunday)

                $MM = !empty($cohort->cohorttutormonday) ? $cohort->cohorttutormonday : 0;
                $TT = !empty($cohort->cohorttutortuesday) ? $cohort->cohorttutortuesday : 0;
                $WW = !empty($cohort->cohorttutorwednesday) ? $cohort->cohorttutorwednesday : 0;
                $THH = !empty($cohort->cohorttutorthursday) ? $cohort->cohorttutorthursday : 0;
                $FF = !empty($cohort->cohorttutorfriday) ? $cohort->cohorttutorfriday : 0;

                // Compare the day of the week with the cohort's values
                $matchFoundd = false;

                switch ($dayOfWeekk) {
                    case 1:  // Monday
                        if ($MM) {
                            $matchFoundd = true;
                        }
                        break;
                    case 2:  // Tuesday
                        if ($TT) {
                            $matchFoundd = true;
                        }
                        break;
                    case 3:  // Wednesday
                        if ($WW) {
                            $matchFoundd = true;
                        }
                        break;
                    case 4:  // Thursday
                        if ($THH) {
                            $matchFoundd = true;
                        }
                        break;
                    case 5:  // Friday
                        if ($FF) {
                            $matchFoundd = true;
                        }
                        break;
                }

                // Output if a match was found
                if ($matchFoundd) {
                    foreach ($meeting_details['teachers'] as $teach) {
                        // Extract email and display name from the detail
                    $email = $teach['email'] ?? null;
                    $display_name = $teach['display_name'] ?? '';
        
                    // Split the display name into first and last name parts
                    $name_parts = explode(' ', $display_name);
                    $user_picture = new user_picture($guide_teacher);
                    $user_picture->size = 1; // f1
                    $user_picture_url = $user_picture->get_url($PAGE)->out(false);
        
                    // Create attendance entry
                    $attendance_teachers = [
                        'id' => null, // No user ID associated
                        'firstname' => $guide_teacher->firstname, // First part of the name
                        'lastname' => $guide_teacher->lastname,  // Second part of the name, if available
                        'email' => $email, // Associated email
                        'phone' => $guide_teacher->phone1, // No phone associated
                        'date' => $formatted_date, // Formatted date
                        'attendance' => 'P', // Mark as present
                        'start' => $teach['start'],
                        'left' => $teach['left'],
                        'duration' => $teach['duration'],
                        'profile_picture' => $user_picture_url
                    ];
        
                    // Add the attendance entry to the email-based attendance array
                    $member_details_send['teachers_attendance'][] = $attendance_teachers;
                    }
                } else {
                    foreach ($meeting_details['teachers'] as $teach) {
                        // Extract email and display name from the detail
                    $email = $teach['email'] ?? null;
                    $display_name = $teach['display_name'] ?? '';
        
                    // Split the display name into first and last name parts
                    $name_parts = explode(' ', $display_name);

                    $user_picture = new user_picture($guide_teacher);
                    $user_picture->size = 1; // f1
                    $user_picture_url = $user_picture->get_url($PAGE)->out(false);
        
                    // Create attendance entry
                    $attendance_teachers = [
                        'id' => null, // No user ID associated
                        'firstname' => $guide_teacher->firstname, // First part of the name
                        'lastname' => $guide_teacher->lastname,  // Second part of the name, if available
                        'email' => $email, // Associated email
                        'phone' => $guide_teacher->phone1, // No phone associated
                        'date' => $formatted_date, // Formatted date
                        'attendance' => 'NA', // Mark as present
                        'start' => $teach['start'],
                        'left' => $teach['left'],
                        'duration' => $teach['duration'],
                        'profile_picture' => $user_picture_url
                    ];
        
                    // Add the attendance entry to the email-based attendance array
                    $member_details_send['teachers_attendance'][] = $attendance_teachers;
                    }
                }

            }

        }
    }
}

        // Append attendance data to the existing record arrays
        $all_member_details['email_based_attendance'] = array_merge(
            $all_member_details['email_based_attendance'],
            $member_details_send['email_based_attendance']
        );

        $all_member_details['display_name_based_attendance'] = array_merge(
            $all_member_details['display_name_based_attendance'],
            $member_details_send['display_name_based_attendance']
        );

        $all_member_details['former_students_attendance'] = array_merge(
            $all_member_details['former_students_attendance'],
            $member_details_send['former_students_attendance']
        );

        $all_member_details['teachers_attendance'] = array_merge(
            $all_member_details['teachers_attendance'],
            $member_details_send['teachers_attendance']
        );

        // Reset $member_details_send for the next URL
        $member_details_send = [
            'email_based_attendance' => [],
            'display_name_based_attendance' => [],
            'former_students_attendance' => [],
            'teachers_attendance' => []
        ];
  }
}


// Collect teacher details
if ($cohort) {
    // Main teacher details
    if (!empty($cohort->cohortmainteacher)) {
        $main_teacher = $DB->get_record('user', ['id' => $cohort->cohortmainteacher], 'id, firstname, lastname, email');
        $M = !empty($cohort->cohortmonday) ? $cohort->cohortmonday : 0;
        $T = !empty($cohort->cohorttuesday) ? $cohort->cohorttuesday : 0;
        $W = !empty($cohort->cohortwednesday) ? $cohort->cohortwednesday : 0;
        $TH = !empty($cohort->cohortthursday) ? $cohort->cohortthursday : 0;
        $F = !empty($cohort->cohortfriday) ? $cohort->cohortfriday : 0;
    
        if ($main_teacher) {
            // Initialize an empty array to store days
            $days = [];
    
            // Check each day and add its name if the value is 1
            if ($M == 1) $days[] = 'M';
            if ($T == 1) $days[] = 'T';
            if ($W == 1) $days[] = 'W';
            if ($TH == 1) $days[] = 'Th';
            if ($F == 1) $days[] = 'F';
    
            // Join the days array into a comma-separated string
            $days_string = implode(', ', $days);

            // Convert to 12-hour format and add AM/PM
            $hour = !empty($cohort->cohorthours) ? (int)$cohort->cohorthours : 0; // Get the hour part
            $minute = !empty($cohort->cohortminutes) ? $cohort->cohortminutes : 0; // Get the minutes part

            // Determine AM or PM
            $am_pm = ($hour >= 12) ? 'PM' : 'AM';

            // Convert to 12-hour format
            if ($hour > 12) {
                $hour -= 12;
            } elseif ($hour == 0) {
                $hour = 12; // Handle midnight (00:00)
            }

            // Format session time
            $sessionTime = $hour . ':' . str_pad($minute, 2, '0', STR_PAD_LEFT) . ' ' . $am_pm;


             // Generate profile picture URL
             require_once($CFG->libdir . '/filelib.php');
             $main_teacher_picture_url = moodle_url::make_pluginfile_url(
                 context_user::instance($main_teacher->id)->id,
                 'user',
                 'icon',
                 null,
                 '/',
                 'f1'
             )->out(false);
 
             // Populate teacher details with profile picture
             $teacher_details[] = [
                 'cohortid' => $cohort->idnumber,
                 'role' => 'Main Teacher',
                 'firstname' => $main_teacher->firstname,
                 'lastname' => $main_teacher->lastname,
                 'days' => $days_string,
                 'sessiontiming' => $sessionTime,
                 'profile_picture' => $main_teacher_picture_url
             ];
        }
    } else {
        $teacher_details[] = [
            'role' => 'Main Teacher',
            'firstname' => '',
            'lastname' => '',
            'days' => '',
            'sessiontiming' => '',
            'profile_picture' => ''
        ];
    }

    // Guide teacher details
    if (!empty($cohort->cohortguideteacher)) {
        $guide_teacher = $DB->get_record('user', ['id' => $cohort->cohortguideteacher], 'id, firstname, lastname, email');
        $MM = !empty($cohort->cohorttutormonday) ? $cohort->cohorttutormonday : 0;
        $TT = !empty($cohort->cohorttutortuesday) ? $cohort->cohorttutortuesday : 0;
        $WW = !empty($cohort->cohorttutorwednesday) ? $cohort->cohorttutorwednesday : 0;
        $THH = !empty($cohort->cohorttutorthursday) ? $cohort->cohorttutorthursday : 0;
        $FF = !empty($cohort->cohorttutorfriday) ? $cohort->cohorttutorfriday : 0;
        
        if ($guide_teacher) {
            // Initialize an empty array to store days
            $days_guide = [];
    
            // Check each day and add its name if the value is 1
            if ($MM == 1) $days_guide[] = 'M';
            if ($TT == 1) $days_guide[] = 'T';
            if ($WW == 1) $days_guide[] = 'W';
            if ($THH == 1) $days_guide[] = 'Th';
            if ($FF == 1) $days_guide[] = 'F';

            // Convert to 12-hour format and add AM/PM
            $hourg = !empty($cohort->cohorttutorhours) ? (int)$cohort->cohorttutorhours : 0; // Get the hour part
            $minuteg = !empty($cohort->cohorttutorminutes) ? $cohort->cohorttutorminutes : 0; // Get the minutes part

            // Determine AM or PM
            $am_pmg = ($hourg >= 12) ? 'PM' : 'AM';

            // Convert to 12-hour format
            if ($hourg > 12) {
                $hourg -= 12;
            } elseif ($hourg == 0) {
                $hourg = 12; // Handle midnight (00:00)
            }

            // Format session time
            $sessionTimeg = $hourg . ':' . str_pad($minuteg, 2, '0', STR_PAD_LEFT) . ' ' . $am_pmg;
     
            // Join the days array into a comma-separated string
            $days_string_guide = implode(', ', $days_guide);

            // Generate profile picture URL
            require_once($CFG->libdir . '/filelib.php');
            $guide_teacher_picture_url = moodle_url::make_pluginfile_url(
                context_user::instance($guide_teacher->id)->id,
                'user',
                'icon',
                null,
                '/',
                'f1'
            )->out(false);


            $teacher_details[] = [
                'cohortid' => $cohort->idnumber,
                'role' => 'Guide Teacher',
                'firstname' => $guide_teacher->firstname,
                'lastname' => $guide_teacher->lastname,
                'days' => $days_string_guide,
                'sessiontiming' => $sessionTimeg,
                'profile_picture' => $guide_teacher_picture_url
            ];
        }
    } else {
        // If no guide teacher, provide empty details
        $teacher_details[] = [
            'role' => 'Guide Teacher',
            'firstname' => '',
            'lastname' => '',
            'days' => '',
            'sessiontiming' => '',
            'profile_picture' => ''
        ];
    }
}


//Rebuilding Based on Firstname and lastname

$rebuilt_display_attendance = [];

foreach ($all_member_details['email_based_attendance'] as &$emailEntry) {
    $fname = strtolower(trim($emailEntry['firstname']));
    $lname = strtolower(trim($emailEntry['lastname']));
    $date = $emailEntry['date'];

    foreach ($all_member_details['display_name_based_attendance'] as $key => $displayEntry) {
        $dfname = strtolower(trim($displayEntry['firstname']));
        $dlname = strtolower(trim($displayEntry['lastname']));
        $ddate = $displayEntry['date'];

        // Match firstname + lastname + date, and check if marked present
        if ($fname === $dfname && $lname === $dlname && $date === $ddate && $displayEntry['attendance'] === 'P') {
            // Update attendance to 'P'
            $emailEntry['attendance'] = 'P';
            $emailEntry['start'] = $displayEntry['start'];
            $emailEntry['left'] = $displayEntry['left'];
            $emailEntry['duration'] = $displayEntry['duration'];

            // Mark for removal
            $rebuilt_display_attendance[] = $key;

            // Break after 1 match per date
            break;
        }
    }
}
unset($emailEntry); // Good practice when using reference in foreach

// Remove used display name entries
$rebuilt_display_attendance = array_unique($rebuilt_display_attendance);
foreach ($rebuilt_display_attendance as $index) {
    unset($all_member_details['display_name_based_attendance'][$index]);
}
// Reindex array
$all_member_details['display_name_based_attendance'] = array_values($all_member_details['display_name_based_attendance']);




//Firstname

$rebuilt_display_attendance_firstname = [];

foreach ($all_member_details['email_based_attendance'] as &$emailEntry) {
    $fname = strtolower(trim($emailEntry['firstname']));
    $date = $emailEntry['date'];

    foreach ($all_member_details['display_name_based_attendance'] as $key => $displayEntry) {
        $dfname = strtolower(trim($displayEntry['firstname']));
        $ddate = $displayEntry['date'];

        // Match only firstname + date, and check if marked present
        $elname = strtolower(trim($emailEntry['lastname']));
$dlname = strtolower(trim($displayEntry['lastname']));

// Extra check: if both have simple first+last names and lastnames differ, skip
if (
    $fname === $dfname && $date === $ddate && $displayEntry['attendance'] === 'P' &&
    !(str_word_count($emailEntry['firstname']) === 1 &&
      str_word_count($emailEntry['lastname']) === 1 &&
      str_word_count($displayEntry['firstname']) === 1 &&
      str_word_count($displayEntry['lastname']) === 1 &&
      $elname !== $dlname)
) {

            // Update attendance to 'P'
            $emailEntry['attendance'] = 'P';
            $emailEntry['start'] = $displayEntry['start'];
            $emailEntry['left'] = $displayEntry['left'];
            $emailEntry['duration'] = $displayEntry['duration'];

            // Mark for removal
            $rebuilt_display_attendance_firstname[] = $key;

            // Break after 1 match per date
            break;
        }
    }
}
unset($emailEntry); // Clear reference

// Remove used display name entries (firstname-only matches)
$rebuilt_display_attendance_firstname = array_unique($rebuilt_display_attendance_firstname);
foreach ($rebuilt_display_attendance_firstname as $index) {
    unset($all_member_details['display_name_based_attendance'][$index]);
}
// Reindex array
$all_member_details['display_name_based_attendance'] = array_values($all_member_details['display_name_based_attendance']);



//Half First name 

$rebuilt_display_attendance_partial_firstname = [];

foreach ($all_member_details['email_based_attendance'] as &$emailEntry) {
    $fname_full = strtolower(trim($emailEntry['firstname'])); // "edwin alexis"
    $date = $emailEntry['date'];

    foreach ($all_member_details['display_name_based_attendance'] as $key => $displayEntry) {
        $dfname = strtolower(trim($displayEntry['firstname'])); // "edwin"
        $ddate = $displayEntry['date'];

        // Match partial firstname + same date + marked present
        $elname = strtolower(trim($emailEntry['lastname']));
$dlname = strtolower(trim($displayEntry['lastname']));

if (
    !empty($dfname) &&
    str_starts_with($fname_full, $dfname) &&
    $date === $ddate &&
    $displayEntry['attendance'] === 'P' &&
    !(str_word_count($emailEntry['firstname']) === 1 &&
      str_word_count($emailEntry['lastname']) === 1 &&
      str_word_count($displayEntry['firstname']) === 1 &&
      str_word_count($displayEntry['lastname']) === 1 &&
      $elname !== $dlname)
) {
            // Update attendance to 'P'
            $emailEntry['attendance'] = 'P';
            $emailEntry['start'] = $displayEntry['start'];
            $emailEntry['left'] = $displayEntry['left'];
            $emailEntry['duration'] = $displayEntry['duration'];

            // Mark for removal
            $rebuilt_display_attendance_partial_firstname[] = $key;

            break;
        }
    }
}
unset($emailEntry);

// Remove matched display name entries
$rebuilt_display_attendance_partial_firstname = array_unique($rebuilt_display_attendance_partial_firstname);
foreach ($rebuilt_display_attendance_partial_firstname as $index) {
    unset($all_member_details['display_name_based_attendance'][$index]);
}
$all_member_details['display_name_based_attendance'] = array_values($all_member_details['display_name_based_attendance']);







$rebuilt_display_attendance_unique_lastname = [];

// Build a count map of lastnames in email_based_attendance
//$target_date = 'Jun-23'; // or whichever date format you're using
$lastnameCounts = [];
$seenIds = [];

foreach ($all_member_details['email_based_attendance'] as $emailEntry) {
    if ($emailEntry['date'] !== $date) {
        continue;
    }

    $userid = $emailEntry['id'];
    $lname = strtolower(trim($emailEntry['lastname']));

    // Skip if already counted this user for this date
    $uniqueKey = $userid . '|' . $date;
    if (isset($seenIds[$uniqueKey]) || empty($lname)) {
        continue;
    }

    // Count this user
    $lastnameCounts[$lname] = isset($lastnameCounts[$lname])
        ? $lastnameCounts[$lname] + 1
        : 1;

    // Mark user/date as seen
    $seenIds[$uniqueKey] = true;
}

// Now match entries in display_name_based_attendance
foreach ($all_member_details['display_name_based_attendance'] as $key => $displayEntry) {
    $dlname = strtolower(trim($displayEntry['lastname']));
    $dfname = strtolower(trim($displayEntry['firstname']));
    $ddate = $displayEntry['date'];

    // Check if lastname exists only once in email_based
    if (!empty($dlname) && isset($lastnameCounts[$dlname]) && $lastnameCounts[$dlname] === 1) {
        // Find the corresponding email-based entry
        foreach ($all_member_details['email_based_attendance'] as &$emailEntry) {
            $elname = strtolower(trim($emailEntry['lastname']));
            $edate = $emailEntry['date'];

            if ($dlname === $elname && $ddate === $edate) {
                // Update email-based attendance
                $emailEntry['attendance'] = 'P';
                $emailEntry['start'] = $displayEntry['start'];
                $emailEntry['left'] = $displayEntry['left'];
                $emailEntry['duration'] = $displayEntry['duration'];

                // Mark for removal
                $rebuilt_display_attendance_unique_lastname[] = $key;
                break;
            }
        }
        unset($emailEntry);
    }
}

// Remove used display_name entries
$rebuilt_display_attendance_unique_lastname = array_unique($rebuilt_display_attendance_unique_lastname);
foreach ($rebuilt_display_attendance_unique_lastname as $index) {
    unset($all_member_details['display_name_based_attendance'][$index]);
}
$all_member_details['display_name_based_attendance'] = array_values($all_member_details['display_name_based_attendance']);









$rebuilt_display_attendance_unique_firstname = [];

// Build a count map of firstnames per date in email_based_attendance
$firstnameDateCounts = [];
foreach ($all_member_details['email_based_attendance'] as $emailEntry) {
    $fname = strtolower(trim($emailEntry['firstname']));
    $date = $emailEntry['date'];
    if (!empty($fname)) {
        $key = $fname . '|' . $date;
        $firstnameDateCounts[$key] = isset($firstnameDateCounts[$key])
            ? $firstnameDateCounts[$key] + 1
            : 1;
    }
}

// Now match entries in display_name_based_attendance
foreach ($all_member_details['display_name_based_attendance'] as $key => $displayEntry) {
    $dfname = strtolower(trim($displayEntry['firstname']));
    $ddate = $displayEntry['date'];
    $fnameKey = $dfname . '|' . $ddate;

    // Check if firstname appears only once on that date
    if (!empty($dfname) && isset($firstnameDateCounts[$fnameKey]) && $firstnameDateCounts[$fnameKey] === 1) {
        foreach ($all_member_details['email_based_attendance'] as &$emailEntry) {
            $efname = strtolower(trim($emailEntry['firstname']));
            $edate = $emailEntry['date'];

            if ($dfname === $efname && $ddate === $edate) {
                // Update attendance
                $emailEntry['attendance'] = 'P';
                $emailEntry['start'] = $displayEntry['start'];
                $emailEntry['left'] = $displayEntry['left'];
                $emailEntry['duration'] = $displayEntry['duration'];

                $rebuilt_display_attendance_unique_firstname[] = $key;
                break;
            }
        }
        unset($emailEntry);
    }
}

// Remove used display_name entries
$rebuilt_display_attendance_unique_firstname = array_unique($rebuilt_display_attendance_unique_firstname);
foreach ($rebuilt_display_attendance_unique_firstname as $index) {
    unset($all_member_details['display_name_based_attendance'][$index]);
}
$all_member_details['display_name_based_attendance'] = array_values($all_member_details['display_name_based_attendance']);













$rebuilt_display_attendance_merged = [];

// Step 1: Group display name records by firstname+date
$displayNameGroups = [];

foreach ($all_member_details['display_name_based_attendance'] as $key => $entry) {
    $fname = strtolower(trim($entry['firstname']));
    $date = $entry['date'];

    if (empty($fname)) continue;

    $groupKey = $fname . '|' . $date;

    if (!isset($displayNameGroups[$groupKey])) {
        $displayNameGroups[$groupKey] = [];
    }

    $displayNameGroups[$groupKey][] = array_merge($entry, ['_original_key' => $key]);
}

// Step 2: Count email-based firstnames per date
$emailFirstNameDateCounts = [];
foreach ($all_member_details['email_based_attendance'] as $entry) {
    $fname = strtolower(trim($entry['firstname']));
    $date = $entry['date'];

    if (empty($fname)) continue;

    $key = $fname . '|' . $date;

    $emailFirstNameDateCounts[$key] = isset($emailFirstNameDateCounts[$key])
        ? $emailFirstNameDateCounts[$key] + 1
        : 1;
}

// Step 3: For each group, if firstname appears only once in email-based, merge and apply
foreach ($displayNameGroups as $groupKey => $groupRecords) {
    list($fname, $date) = explode('|', $groupKey);

    // If count is not 1, skip update to email-based — but still remove display-based if count is 0
if (!isset($emailFirstNameDateCounts[$groupKey])) {
    // Check if same firstname exists on any other date
    $foundElsewhere = false;
  $foundElsewhere = false;
foreach ($emailFirstNameDateCounts as $otherKey => $count) {
    list($otherFname, $otherDate) = explode('|', $otherKey);

    // Only count if it's the same firstname but on another date
    if (
    $otherDate !== $date &&
    (
        str_contains($fname, $otherFname) || str_contains($otherFname, $fname)
    )
) {
    $foundElsewhere = true;
    break;
}
}

    // If firstname exists on another date, allow merge and remove
    if ($foundElsewhere) {
    $earliestStart = null;
    $latestLeft = null;

    foreach ($groupRecords as $record) {
        $startTime = strtotime($record['start']);
        $leftTime = strtotime($record['left']);

        if ($earliestStart === null || $startTime < $earliestStart) {
            $earliestStart = $startTime;
        }

        if ($latestLeft === null || $leftTime > $latestLeft) {
            $latestLeft = $leftTime;
        }
    }

$mergedStart = date('g:i A', $earliestStart);
$mergedLeft = date('g:i A', $latestLeft);
$mergedMinutes = round(($latestLeft - $earliestStart) / 60);

// Format mergedDuration
if ($mergedMinutes >= 60) {
    $hrs = floor($mergedMinutes / 60);
    $mins = $mergedMinutes % 60;
    if ($mins > 0) {
        $mergedDuration = $hrs . ' hr' . ($hrs > 1 ? 's' : '') . ' ' . $mins . ' min' . ($mins > 1 ? 's' : '');
    } else {
        $mergedDuration = $hrs . ' hr' . ($hrs > 1 ? 's' : '');
    }
} else {
    $mergedDuration = $mergedMinutes . ' min' . ($mergedMinutes > 1 ? 's' : '');
}

    // Find existing email-based record that matched on similar firstname from another date
$sourceEmailRecord = null;
foreach ($all_member_details['email_based_attendance'] as $existing) {
    $otherFname = strtolower(trim($existing['firstname']));
    $otherDate = $existing['date'];

    if (
        $otherDate !== $date &&
        (
            str_contains($fname, $otherFname) || str_contains($otherFname, $fname)
        )
    ) {
        $sourceEmailRecord = $existing;
        break;
    }
}

// Only proceed if we found a source record
if ($sourceEmailRecord) {
    $foundExisting = false;

    foreach ($all_member_details['email_based_attendance'] as &$entry) {
    // Match by lowercase firstname and same date
    $matchFirstName = strtolower(trim($entry['firstname'])) === strtolower(trim($sourceEmailRecord['firstname']));

     if ($matchFirstName && $entry['date'] === $date) {
        // Convert existing and new times to timestamps
        $existingStart = strtotime($entry['start']);
        $existingLeft = strtotime($entry['left']);
        $newStart = strtotime($mergedStart);
        $newLeft = strtotime($mergedLeft);

        // Get the earliest start and latest left
        $finalStart = min($existingStart, $newStart);
        $finalLeft = max($existingLeft, $newLeft);
        $minutes = round(($finalLeft - $finalStart) / 60);

        // Format duration as "X hrs Y mins"
        if ($minutes >= 60) {
            $hrs = floor($minutes / 60);
            $mins = $minutes % 60;
            if ($mins > 0) {
                $durationStr = $hrs . ' hr' . ($hrs > 1 ? 's' : '') . ' ' . $mins . ' min' . ($mins > 1 ? 's' : '');
            } else {
                $durationStr = $hrs . ' hr' . ($hrs > 1 ? 's' : '');
            }
        } else {
            $durationStr = $minutes . ' min' . ($minutes > 1 ? 's' : '');
        }

        // Update values
        $entry['attendance'] = 'P';
        $entry['start'] = date('g:i A', $finalStart);
        $entry['left'] = date('g:i A', $finalLeft);
        $entry['duration'] = $durationStr;

        $foundExisting = true;
        break;
    }
}
    unset($entry); // Best practice

    // If not found, add a new record
    if (!$foundExisting) {
        $all_member_details['email_based_attendance'][] = [
            'id' => $sourceEmailRecord['id'] ?? null,
            'firstname' => $sourceEmailRecord['firstname'],
            'lastname' => $sourceEmailRecord['lastname'],
            'email' => $sourceEmailRecord['email'] ?? '',
            'phone' => $sourceEmailRecord['phone'] ?? '',
            'profile_picture' => $sourceEmailRecord['profile_picture'] ?? '',
            'date' => $date,
            'attendance' => 'P',
            'start' => $mergedStart,
            'left' => $mergedLeft,
            'duration' => $mergedDuration,
        ];
    }
}

    foreach ($groupRecords as $r) {
        $rebuilt_display_attendance_merged[] = $r['_original_key'];
    }
}

    // Skip updating email-based since no exact match
    continue;
}

if ($emailFirstNameDateCounts[$groupKey] !== 1) {
    continue;
}

    $earliestStart = null;
    $latestLeft = null;

    foreach ($groupRecords as $record) {
        $startTime = strtotime($record['start']);
        $leftTime = strtotime($record['left']);

        if ($earliestStart === null || $startTime < $earliestStart) {
            $earliestStart = $startTime;
        }

        if ($latestLeft === null || $leftTime > $latestLeft) {
            $latestLeft = $leftTime;
        }
    }

    // Format back to PM/AM
    $mergedStart = date('g:i A', $earliestStart);
    $mergedLeft = date('g:i A', $latestLeft);
    $mergedDuration = round(($latestLeft - $earliestStart) / 60); // duration in minutes

    // Find the matching email-based record
    foreach ($all_member_details['email_based_attendance'] as &$emailEntry) {
        $efname = strtolower(trim($emailEntry['firstname']));
        $edate = $emailEntry['date'];

        if ($efname === $fname && $edate === $date) {
            $emailEntry['attendance'] = 'P';
            $emailEntry['start'] = $mergedStart;
            $emailEntry['left'] = $mergedLeft;
            $emailEntry['duration'] = $mergedDuration . ' mins';

            // Remove all display records from this group
            foreach ($groupRecords as $r) {
                $rebuilt_display_attendance_merged[] = $r['_original_key'];
            }

            break;
        }
    }
    unset($emailEntry);
}

// Step 4: Remove the merged entries from display_name_based_attendance
$rebuilt_display_attendance_merged = array_unique($rebuilt_display_attendance_merged);
foreach ($rebuilt_display_attendance_merged as $index) {
    unset($all_member_details['display_name_based_attendance'][$index]);
}
$all_member_details['display_name_based_attendance'] = array_values($all_member_details['display_name_based_attendance']);








//Speacial case
$rebuilt_display_attendance_special_merge = [];

// Step 1: Build full name list from email-based for a specific date
$emailFullNames = []; // key = index in email_based_attendance
foreach ($all_member_details['email_based_attendance'] as $index => $entry) {
    if ($entry['date'] !== $date) {
        continue;
    }

    $fname = strtolower(trim($entry['firstname']));
    $lname = strtolower(trim($entry['lastname']));
    $fullname = trim($fname . ' ' . $lname);

    if (!empty($fullname)) {
        $emailFullNames[$index] = $fullname;
    }
}

// Step 2: Group display records by firstname
$displayGroups = [];
foreach ($all_member_details['display_name_based_attendance'] as $key => $entry) {
    $dfname = strtolower(trim($entry['firstname']));
    if (empty($dfname)) continue;

    if (!isset($displayGroups[$dfname])) {
        $displayGroups[$dfname] = [];
    }
    $displayGroups[$dfname][] = array_merge($entry, ['_original_key' => $key]);
}

// Step 3: For each grouped firstname in display-based, check if it appears in only one email fullname
foreach ($displayGroups as $dfname => $records) {
    $matchedEmailIndexes = [];

    foreach ($emailFullNames as $index => $fullName) {
        if (str_contains($fullName, $dfname)) {
            $matchedEmailIndexes[] = $index;
        }
    }

    // If matched to more than one person, skip
    if (count($matchedEmailIndexes) !== 1) {
        continue;
    }

    $emailIndex = $matchedEmailIndexes[0];
    $emailPerson = $all_member_details['email_based_attendance'][$emailIndex];

    // Merge all display-based records for this firstname
   $datesToUpdate = [];
$rebuilt_display_attendance_special_merge = [];

// Group records by date
$recordsByDate = [];
foreach ($records as $r) {
    $date = $r['date'];
    $recordsByDate[$date][] = $r;
    $datesToUpdate[$date] = true;
    $rebuilt_display_attendance_special_merge[] = $r['_original_key'];
}

$mergedSessionsByDate = [];

foreach ($recordsByDate as $date => $dateRecords) {
    $earliestStart = null;
    $latestLeft = null;

    foreach ($dateRecords as $r) {
        $startTime = strtotime($r['start']);
        $leftTime = strtotime($r['left']);

        if ($earliestStart === null || $startTime < $earliestStart) {
            $earliestStart = $startTime;
        }

        if ($latestLeft === null || $leftTime > $latestLeft) {
            $latestLeft = $leftTime;
        }
    }

    $mergedStart = date('g:i A', $earliestStart);
    $mergedLeft = date('g:i A', $latestLeft);
    $totalMinutes = round(($latestLeft - $earliestStart) / 60);

    // Format duration
    if ($totalMinutes >= 60) {
        $hrs = floor($totalMinutes / 60);
        $mins = $totalMinutes % 60;
        $mergedDuration = $hrs . ' hr' . ($hrs > 1 ? 's' : '') . ($mins > 0 ? ' ' . $mins . ' min' . ($mins > 1 ? 's' : '') : '');
    } else {
        $mergedDuration = $totalMinutes . ' min' . ($totalMinutes > 1 ? 's' : '');
    }

    // Store result per date
    $mergedSessionsByDate[$date] = [
        'start' => $mergedStart,
        'left' => $mergedLeft,
        'duration' => $mergedDuration
    ];
}

    // Now update or insert into email-based for each date
foreach (array_keys($datesToUpdate) as $date) {
    $updated = false;

    // Fetch merged values for this date
    if (!isset($mergedSessionsByDate[$date])) {
        continue; // just in case
    }

    $mergedStart = $mergedSessionsByDate[$date]['start'];
    $mergedLeft = $mergedSessionsByDate[$date]['left'];
    $mergedDuration = $mergedSessionsByDate[$date]['duration'];

    foreach ($all_member_details['email_based_attendance'] as &$entry) {
        if (
            strtolower(trim($entry['firstname'])) === strtolower(trim($emailPerson['firstname'])) &&
            $entry['date'] === $date
        ) {
            $existingStart = strtotime($entry['start']);
            $existingLeft = strtotime($entry['left']);
            $newStart = strtotime($mergedStart);
            $newLeft = strtotime($mergedLeft);

            if($existingStart)
            {
              $finalStart = min($existingStart, $newStart);  
            }else{
                $finalStart = $newStart;
            }

            if($existingLeft)
            {
              $finalLeft = max($existingLeft, $newLeft); 
            }else{
               $finalLeft = $newLeft;
            }
            
            
            $total = round(($finalLeft - $finalStart) / 60);

            // Format new duration
            if ($total >= 60) {
                $h = floor($total / 60);
                $m = $total % 60;
                $duration = $h . ' hr' . ($h > 1 ? 's' : '') . ($m > 0 ? ' ' . $m . ' min' . ($m > 1 ? 's' : '') : '');
            } else {
                $duration = $total . ' min' . ($total > 1 ? 's' : '');
            }

            $entry['attendance'] = 'P';
            $entry['start'] = date('g:i A', $finalStart);
            $entry['left'] = date('g:i A', $finalLeft);
            $entry['duration'] = $duration;

            $updated = true;
            break;
        }
    }
    unset($entry);

    if (!$updated) {
        $all_member_details['email_based_attendance'][] = [
            'id' => $emailPerson['id'] ?? null,
            'firstname' => $emailPerson['firstname'],
            'lastname' => $emailPerson['lastname'],
            'email' => $emailPerson['email'] ?? '',
            'phone' => $emailPerson['phone'] ?? '',
            'profile_picture' => $emailPerson['profile_picture'] ?? '',
            'date' => $date,
            'attendance' => 'P',
            'start' => $mergedStart,
            'left' => $mergedLeft,
            'duration' => $mergedDuration,
        ];
    }
}
}

// Step 4: Remove used display-based entries
$rebuilt_display_attendance_special_merge = array_unique($rebuilt_display_attendance_special_merge);
foreach ($rebuilt_display_attendance_special_merge as $idx) {
    unset($all_member_details['display_name_based_attendance'][$idx]);
}
$all_member_details['display_name_based_attendance'] = array_values($all_member_details['display_name_based_attendance']);




ob_end_clean(); // Discard any previous output
    // Set JSON header
    header('Content-Type: application/json');

// Return JSON response
echo json_encode(['members' => $all_member_details, 'teachers' => $teacher_details]);
exit;
} else {
echo json_encode(['error' => 'Invalid request']);
exit;
}

function get_data_per_url($code, $dateInput)
{
    

   // Define the return URL (where the user will be redirected after authentication)
    $returnurl = new moodle_url('/mod/googlemeet/callback.php');
    $returnurl->param('callback', 'yes');
    $returnurl->param('sesskey', sesskey());
    
    // Define the scopes (adjust as needed for your OAuth2 integration)
    define('SCOPES', 'https://www.googleapis.com/auth/drive https://www.googleapis.com/auth/calendar.events https://www.googleapis.com/auth/admin.reports.audit.readonly https://www.googleapis.com/auth/admin.reports.usage.readonly');
    
    
// Get the issuer object from the service
$issuer = \core\oauth2\api::get_issuer(get_config('googlemeet', 'issuerid'));

// Get the OAuth client from Moodle's API
$client = \core\oauth2\api::get_user_oauth_client(
    $issuer,    // Pass the issuer object
    $returnurl,  // Callback URL
    SCOPES,      // OAuth2 Scopes
    true         // Use cached client if available
);

if ($client->is_logged_in()) {
    $authToken = $client->get_accesstoken()->token;
    //$code = 'kxzrwpdyvx';
    //$dateInput = '2024-12-11'; // Data in Y-m-d Format
    $starttimeInput = "00:00:00"; // Start time
    $endtimeInput = "23:59:00"; // End Time

     $localTz = new DateTimeZone('America/New_York'); // US Eastern

    $dateStart = new DateTime($dateInput . " " . $starttimeInput, $localTz);
    $dateStart->setTimezone(new DateTimeZone('UTC'));
    $startISO = $dateStart->format("Y-m-d\TH:i:s.000\Z");

    $dateEnd = new DateTime($dateInput . " " . $endtimeInput, $localTz);
    $dateEnd->setTimezone(new DateTimeZone('UTC'));
    $endISO = $dateEnd->format("Y-m-d\TH:i:s.000\Z");
        // Perform some action for each URL (for example, print it)
        echo 'Processing Google Meet URL: ' . $url . '<br>';

        $participants = getGoogleMeetParticipants($authToken, $code, $startISO, $endISO);

        $fields = [];
        $emails = []; // Array to store email addresses
        $teachers = []; // Array to store email addresses
        $processedEmails = []; // Array to track processed emails
        
        if ($participants) {
            foreach ($participants['items'] as $item) {
                foreach ($item['events'] as $events) {
                    // Temporary variables to track whether email or display_name has been added in this record
                    $eventEmails = [];
                    $eventDisplayNames = [];
                    $organizerEmail = null;
                    $startUnix = null;
                    $duration = null;
        
                    // First, loop through the parameters to collect emails and display names
                    foreach ($events['parameters'] as $v) {
                        // If identifier (email) exists, store it
                        if ($v['name'] == 'identifier') {
                            $eventEmails[] = $v['value']; // Collect the email
                        }

                          // If organizer_email exists, store it
                        if ($v['name'] == 'organizer_email') {
                            $organizerEmail = $v['value']; // Collect the organizer email
                        }
        
                        // If display_name exists, store it
                        if ($v['name'] == 'display_name') {
                            $eventDisplayNames[] = $v['value']; // Collect the display name
                        }

                        // Collect start time in UNIX format
                        if ($v['name'] == 'start_timestamp_seconds') {
                            $startUnix = $v['intValue'];
                        }

                        // Collect duration in UNIX format
                        if ($v['name'] == 'duration_seconds') {
                            $duration = $v['intValue'];
                        }
                    }

                      // Check if identifier and organizer_email are the same
                    if (!empty($eventEmails) && $organizerEmail !== null) {
                        foreach ($eventEmails as $email) {
                            if ($email === $organizerEmail) {
                                // Skip this iteration as the condition is met
                                //continue 2; // Skip to the next $item

                                foreach ($eventEmails as $index => $email) {
                                    if (!in_array($email, $processedEmails)) {
                                        // Calculate 'start', 'left', and 'duration' fields
                                        $startTime = $startUnix ? date('g:i A', $startUnix) : null; // Convert start time to readable format
                                        $leftUnix = $startUnix + $duration; // Calculate left time in UNIX
                                        $leftTime = $leftUnix ? date('g:i A', $leftUnix) : null; // Convert left time to readable format
            
                                        // Calculate duration in hours and minutes
                                        $durationHours = floor($duration / 3600);
                                        $durationMinutes = floor(($duration % 3600) / 60);
                                        $formattedDuration = ($durationHours ? "{$durationHours} h " : "") . ($durationMinutes ? "{$durationMinutes} min" : "");
                                        // If a corresponding display name exists, add it; otherwise, set display name as null
                                        $displayName = $eventDisplayNames[$index] ?? null;
            
                                         // Store email, display name, start, left, and duration as an associative array
                                        $teachers[] = [
                                            'email' => $email,
                                            'display_name' => $displayName,
                                            'start' => $startTime,
                                            'left' => $leftTime,
                                            'duration' => $formattedDuration
                                        ];
            
                                        // Mark this email as processed
                                        $processedEmails[] = $email;
                                    }
                                }

                                 continue 2; // Skip to the next $item
                            }
                        }
                    }
        
                                // Now, process the emails and display names
                    foreach ($eventEmails as $index => $email) {
                        if (!in_array($email, $processedEmails)) {
                            // Calculate 'start', 'left', and 'duration' fields
                            $startTime = $startUnix ? date('g:i A', $startUnix) : null; // Convert start time to readable format
                            $leftUnix = $startUnix + $duration; // Calculate left time in UNIX
                            $leftTime = $leftUnix ? date('g:i A', $leftUnix) : null; // Convert left time to readable format

                            // Calculate duration in hours and minutes
                            $durationHours = floor($duration / 3600);
                            $durationMinutes = floor(($duration % 3600) / 60);
                            $formattedDuration = ($durationHours ? "{$durationHours} h " : "") . ($durationMinutes ? "{$durationMinutes} min" : "");
                            // If a corresponding display name exists, add it; otherwise, set display name as null
                            $displayName = $eventDisplayNames[$index] ?? null;

                             // Store email, display name, start, left, and duration as an associative array
                            $emails[] = [
                                'email' => $email,
                                'display_name' => $displayName,
                                'start' => $startTime,
                                'left' => $leftTime,
                                'duration' => $formattedDuration
                            ];

                            // Mark this email as processed
                            $processedEmails[] = $email;
                        }
                    }
        
                    // Store the display names only if no email was found for this record
                    if (empty($eventEmails)) {
                        foreach ($eventDisplayNames as $displayName) {
                           // Calculate 'start', 'left', and 'duration' fields
                        $startTime = $startUnix ? date('g:i A', $startUnix) : null; // Convert start time to readable format
                        $leftUnix = $startUnix + $duration; // Calculate left time in UNIX
                        $leftTime = $leftUnix ? date('g:i A', $leftUnix) : null; // Convert left time to readable format

                        // Calculate duration in hours and minutes
                        $durationHours = floor($duration / 3600);
                        $durationMinutes = floor(($duration % 3600) / 60);
                        $formattedDuration = ($durationHours ? "{$durationHours} h " : "") . ($durationMinutes ? "{$durationMinutes} min" : "");

                        // Store display name along with start, left, and duration
                        $fields[] = [
                            'display_name' => $displayName,
                            'start' => $startTime,
                            'left' => $leftTime,
                            'duration' => $formattedDuration
                        ];
                        }
                    }
                }
            }
        
        

            // Remove duplicate entries
            // $fields = array_unique($fields);
            // $emails = array_unique($emails);

            return ['display_names' => $fields,
            'emails' => $emails, 'teachers' => $teachers ];

            // Debug: Print the participants' names and emails
            echo "<pre class='my-debug'>".__FILE__."(".(1+intval(__LINE__)).")<br/>";
            echo "Participant Names: ";
            print_r($fields);
            echo "<br/>Participant Emails: ";
            print_r($emails);
            exit("</pre>");
        } else {
            echo "<pre class='my-debug'>".__FILE__."(".(1+intval(__LINE__)).")<br/>";
            echo "No participants found or no data retrieved.\n";
            exit("</pre>");
        }
    
} else {
    echo 'Try after some time because client is logged out';
}

}

function get_meet_urls($courseid, $cohortid, $cohort_shortname)
{
global $DB;
// Parameters
$courseid = 2;  // Replace with your actual course ID
//$cohortid = 151; // Replace with your actual cohort ID

// Step 1: Fetch the section ID restricted to the cohort
$sql_sections = "
    SELECT 
        cs.id AS section_id, 
        cs.name AS section_name 
    FROM {course_sections} cs
    WHERE cs.course = :courseid
    AND cs.availability LIKE CONCAT('%', '\"type\":\"cohort\"', '%')
    AND cs.availability LIKE CONCAT('%', '\"id\":', :cohortid, '%')
";

$sections = $DB->get_records_sql($sql_sections, ['courseid' => $courseid, 'cohortid' => $cohortid]);

// Check if a section was found
if (empty($sections)) {
    echo 'No sections found for the specified cohort and course.';
    return;
}

foreach($sections as $section)
{
    if($section->section_name == $cohort_shortname)
    {
       $filtered_section = $section;
    }
}


// Step 2: Fetch Google Meet activities in the found section
//$sectionid = reset($filtered_section)->section_id;
$sectionid = $filtered_section->section_id;

$sql_activities = "
    SELECT 
        gm.name AS activity_name,
        gm.url AS google_meet_url
    FROM {course_modules} cm
    JOIN {modules} m ON cm.module = m.id
    JOIN {googlemeet} gm ON cm.instance = gm.id
    WHERE cm.section = :sectionid
    AND m.name = 'googlemeet'
";

$activities = $DB->get_records_sql($sql_activities, ['sectionid' => $sectionid]);

// Prepare an array to store the transformed URLs
$transformed_urls = [];

// Loop through the activities and transform the URLs
foreach ($activities as $activity) {
    // Extract the last part of the URL (meeting ID)
    $meeting_id = basename($activity->google_meet_url);  // Get the part after the last '/'
    
    // Remove hyphens from the meeting ID
    $transformed_meeting_id = str_replace('-', '', $meeting_id);
    
    // Store the transformed meeting ID in the array
    $transformed_urls[] = $transformed_meeting_id;

    // Output for debugging
    echo 'Original URL: ' . $activity->google_meet_url . '<br>';
    echo 'Transformed URL: ' . $transformed_meeting_id . '<br><br>';
}

return $transformed_urls;

// Example: Output the transformed URLs array
print_r($transformed_urls);
}

function convert_dates($dates)
{
   // Convert the dates to the format "YYYY-MM-DD"
   $converted_dates = [];
   $current_year = date("Y"); // Get the current year
   
   // Define a mapping for month abbreviations to month numbers
   $month_map = [
       'Jan' => '01',
       'Feb' => '02',
       'Mar' => '03',
       'Apr' => '04',
       'May' => '05',
       'Jun' => '06',
       'Jul' => '07',
       'Aug' => '08',
       'Sep' => '09',
       'Oct' => '10',
       'Nov' => '11',
       'Dec' => '12'
   ];

   foreach ($dates as $date) {
       // Split the date string into month and day parts
       list($month, $day) = explode('-', $date);
       
       // Get the numeric month from the abbreviation
       $month_number = isset($month_map[$month]) ? $month_map[$month] : '01'; // Default to Jan if not found
       
       // Format the date as "YYYY-MM-DD" (current year, month, and day)
       $formatted_date = $current_year . '-' . $month_number . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
       
       // Add the formatted date to the result array
       $converted_dates[] = $formatted_date;
   }
   return  $converted_dates;
}
?>
