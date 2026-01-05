<?php
/**
 * Local plugin "calendars" - Lib file
 *
 * @package    local_calendarcontrolplugin
 * @copyright  2024 Deiker, Venezuela <deiker21004@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

ob_start(); // prevent any accidental output

global $CFG, $DB, $PAGE, $USER;

// These should be passed from the parent script
$cohortshortname = $cohortshortname ?? 'FL1';
$today = $today ?? 'November 11';
$userid = $user->id ?? null;   // Ensure $user is initialized before using it
$cohortid = $cohort_id ?? null; // Ensure $cohort_id is passed or initialized

// Load CSS (with cache-busting versioning)
$PAGE->requires->css(new moodle_url('/local/adminboard/test/css/schedule_session.css?v=' . time()), true);
$PAGE->requires->css(new moodle_url('/local/adminboard/test/css/schedule_session_part2.css?v=' . time()), true);
$PAGE->requires->css(new moodle_url('/local/adminboard/test/css/schedule_session_part3.css?v=' . time()), true);

// Include parts 2 and 3 (ensure they have access to global variables)
?>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Modal Overlay -->
<div class="modal-backdrop"></div>

<!-- MODAL 1 -->
<div class="custom-modal" id="sessionModal">
  <div class="modal-header">
   <h2 style="white-space: normal; word-break: break-word;">
  Did you teach your session with <?php echo htmlspecialchars(strtoupper($cohortshortname)); ?> on <?php echo htmlspecialchars($today); ?>?
</h2>
  </div>
  <div class="modal-body">
    <p>
      Please confirm whether you conducted your scheduled session with <?php echo htmlspecialchars(strtoupper($cohortshortname)); ?> on <?php echo htmlspecialchars($today); ?>.
      Your response helps ensure accurate attendance and lesson tracking.
    </p>
  </div>
  <div class="modal-actions">
    <button class="modal-btn yes">Yes</button>
    <button class="modal-btn no" id="btn_no">No</button>
  </div>
</div>

<!-- JS-accessible variables -->
<script>
  const cohortShortName = "<?php echo addslashes(strtoupper($cohortshortname)); ?>";
  const today = "<?php echo addslashes($today); ?>";

  const cohort_id = "<?php echo addslashes($cohortid); ?>";
  const user_id = "<?php echo addslashes($userid); ?>";
</script>




<script>
  $(document).ready(function() {
    $('.modal-btn').click(function() {
      debugger
        const action = $(this).hasClass('yes') ? 'yes' : 'no';

        $('#sessionModal').fadeOut();
$('.modal-backdrop').fadeOut();

if (action === 'yes') {
    // Show or inject modal 2 directly
    $('#topicModal').fadeIn();

     // Insert record only when "yes" is clicked
    fetch('<?php echo $CFG->wwwroot; ?>/local/adminboard/test/store_alert_yes.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `userid=${user_id}&cohortid=${cohort_id}&action=true`
    });
} else {

   // Show or inject modal 2 directly
    $('#absenceModal').fadeIn();

     // Insert record only when "yes" is clicked
    fetch('<?php echo $CFG->wwwroot; ?>/local/adminboard/test/store_alert_yes.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `userid=${user_id}&cohortid=${cohort_id}&action=false`
    });
}
    });
});
  </script>


<?php


// $cohortid is passed in (int).
$cohortid = (int)$cohortid;

$sql = "
    SELECT tcd.*,
           cs.name AS sectionname,
           CASE
             WHEN tcd.timemodified IS NOT NULL AND tcd.timemodified > 0
                  THEN tcd.timemodified
             ELSE tcd.timecreated
           END AS lastts
      FROM {cohorts_topics_completion_data} tcd
 LEFT JOIN {course_sections} cs ON cs.id = tcd.sectionid
     WHERE tcd.cohortid = :cohortid
  ORDER BY lastts DESC, tcd.id DESC
";
$params = ['cohortid' => $cohortid];

// Fetch the single most-recent record.
$rows = $DB->get_records_sql($sql, $params, 0, 1);
$latest = $rows ? reset($rows) : null;


?>




<!-- MODAL 2 -->
<div class="custom-modal" id="topicModal" style="display:none;">
  <div class="modal2-content">
    <span class="supercal-close" id="topic_modal_close">&times;</span>
    
    <form style="margin-top:25px;">
      <div class="modal-row">

        <div class="modal-col" style="flex:2;">
          <!-- Topic Dropdown -->

          <div class="custom-dropdown-wrapper" id="topicDropdownWrapper">

          
          <?php
// $cohortid already set above; you ran the SQL and have $rows and $latest.
$haslatest = !empty($rows) && !empty($latest);
$defaultname = $haslatest
    ? (!empty($latest->sectionname) ? $latest->sectionname : ('Topic ' . (int)$latest->sectionid))
    : 'Select Topic';
?>

<div class="custom-dropdown-selected"
     tabindex="0"
     id="topicDropdownSelected"
     <?php if ($haslatest) { ?>
       section_id="<?php echo (int)$latest->sectionid; ?>"
       course_id="<?php echo (int)$latest->courseid; ?>"
     <?php } ?>
>
  <span id="topicDropdownText"><?php echo s($defaultname); ?></span>
  <span class="dropdown-arrow">&#9662;</span>
</div>
            <div class="custom-dropdown-list" id="topicDropdownList">
              <div class="dropdown-create-row">
                <input type="text" class="dropdown-create-input" placeholder="Create a new topic if not listed" id="newTopicInput">
                <button type="button" class="dropdown-create-btn" id="createTopicBtn">&#10003;</button>
              </div>

               <?php

             // Step 1: Fetch all courses for the given cohort excluding course ID 2
              $sql_courses = "
                SELECT c.id, c.fullname, c.shortname
                FROM {course} c
                JOIN {context} ctx ON ctx.instanceid = c.id AND ctx.contextlevel = 50
                WHERE c.id <> 2
                AND EXISTS (
                    SELECT 1
                    FROM {role_assignments} ra
                    JOIN {cohort_members} cm ON ra.userid = cm.userid
                    WHERE cm.cohortid = :cohortid
                    AND ra.contextid = ctx.id
                )
            ";

            $courses = $DB->get_records_sql($sql_courses, [
                'cohortid' => $cohortid
            ]);


              // Step 1: Init result
$course_sections = [];

if ($courses) {
    // Step 2: Sort courses by "Level N" in fullname (desc)
    usort($courses, function($a, $b) {
        preg_match('/Level (\d+)/i', $a->fullname, $ma);
        preg_match('/Level (\d+)/i', $b->fullname, $mb);
        $la = isset($ma[1]) ? (int)$ma[1] : 0;
        $lb = isset($mb[1]) ? (int)$mb[1] : 0;
        return $lb <=> $la;
    });

    // Cross-DB safe cast for format option "level"
    $castlevel = $DB->sql_cast_char2int('fo.value');

    foreach ($courses as $course) {
        // Optional: ensure the course uses Multitopic
        $format = $DB->get_field('course', 'format', ['id' => $course->id]);
        if ($format !== 'multitopic') {
            $course_sections[$course->id] = ['course' => $course, 'sections' => []];
            continue;
        }

        // Main topics = level 0 (skip section 0 = General)
        $sql = "
            SELECT cs.id, cs.name, cs.section, cs.sequence, cs.visible
            FROM {course_sections} cs
            LEFT JOIN {course_format_options} fo
                   ON fo.sectionid = cs.id
                  AND fo.format    = 'multitopic'
                  AND fo.name      = 'level'
            WHERE cs.course = :courseid
              AND COALESCE($castlevel, 0) = 0
              AND cs.visible = 1
            ORDER BY cs.section
        ";

        $sections = array_values($DB->get_records_sql($sql, ['courseid' => $course->id]));

        // Store per course
        $course_sections[$course->id] = [
            'course'   => $course,
            'sections' => $sections
        ];
    }
}
               // Reverse the entire course_sections array after all data has been added
    $course_sections = array_reverse($course_sections);  // Reverse the full array


              ?>

<?php
    // Loop through courses and generate the dropdown
    foreach ($course_sections as $course_id => $data) {
        $course = $data['course'];
        $sections = $data['sections'];

        ?>

              <div class="dropdown-group">
                <div class="dropdown-group-label accordion-toggle" data-acc="<?php echo $course_id; ?>">
                  <span><?php echo htmlspecialchars($course->fullname); ?></span>
                  <span class="accordion-arrow">&#9662;</span>
                </div>
                <div class="dropdown-items" data-acc="<?php echo $course_id; ?>">
                  <?php
                // Loop through sections for the course and create dropdown items
                foreach ($sections as $section) {
                  $perc = get_section_percentage((int)$cohortid, (int)$data['course']->id, (int)$section->id);
                   $disable = ($perc === 100);
                    ?>
                  <div class="dropdown-item" 
                  data-section-id="<?php echo $section->id; ?>" 
                 data-section-courseid="<?php echo (int)$course->id; ?>"
                 disable="<?php echo $disable ? 'true' : 'false'; ?>">
                  <?php echo htmlspecialchars($section->name); ?>
                  </div>

                   <?php
                }
                ?>
                </div>
              </div>

    <?php
    }
    ?>
            </div>
          </div>
        </div>
        <div class="modal-col" style="flex:1.1;">
          <div class="readonly-box">Target Sessions : 3</div>
        </div>
      </div>
      <div class="modal-row">
        <div class="modal-col" style="flex:2;">


















          <!-- Assignment Dropdown -->
          <div class="custom-dropdown-wrapper" id="assignmentDropdownWrapper">
            <div class="custom-dropdown-selected" tabindex="0" id="assignmentDropdownSelected">
              <span id="assignmentDropdownText">Assignment</span>
              <span class="dropdown-arrow">&#9662;</span>
            </div>


            <div class="custom-dropdown-list" id="assignmentDropdownList">
    <!-- Dynamic subsections will be added here -->
  </div>
          </div>


          <?php
/**
 * Get the latest completion percentage for a cohort+course+section.
 *
 * @return int Percentage 0..100 (0 if no record).
 */
function get_section_percentage(int $cohortid, int $courseid, int $sectionid): int {
    global $DB;

    $sql = "
        SELECT tcd.percentage,
               CASE
                 WHEN tcd.timemodified IS NOT NULL AND tcd.timemodified > 0
                      THEN tcd.timemodified
                 ELSE tcd.timecreated
               END AS lastts
          FROM {cohorts_topics_completion_data} tcd
         WHERE tcd.cohortid = :cohortid
           AND tcd.courseid = :courseid
           AND tcd.sectionid = :sectionid
      ORDER BY lastts DESC, tcd.id DESC
    ";

    $params = [
        'cohortid'  => $cohortid,
        'courseid'  => $courseid,
        'sectionid' => $sectionid,
    ];

    // Cross-DB safe: use get_records_sql with limit=1.
    $rows = $DB->get_records_sql($sql, $params, 0, 1);
    $row  = $rows ? reset($rows) : null;

    return $row ? (int)$row->percentage : 0;
}
?>



<script>
document.addEventListener('DOMContentLoaded', function () {
  const sel = document.getElementById('topicDropdownSelected');
  if (!sel) return;

  const sid = sel.getAttribute('section_id');
  const cid = sel.getAttribute('course_id');
  if (!sid || !cid) return; // no default -> keep "Select Topic"

  // Fire after your other DOMContentLoaded handlers bind their click listeners
  const fire = () => {
    const item = document.querySelector(
      `#topicDropdownList .dropdown-item[data-section-id="${sid}"][data-section-courseid="${cid}"]`
    );
    if (item) {
      item.click(); // triggers the same handler you use on manual click
    }
  };

  // queue it to run just after bindings
  requestAnimationFrame(fire);
  setTimeout(fire, 0);
});
</script>
















  </div>


<?php
$today = date('j M, Y');      // e.g., "10 Aug, 2025"
$monthyear = date('F Y');     // e.g., "August 2025"
?>



                <!-- START DATE INPUT -->
                <div class="modal-col" style="flex:1.1; position:relative;">
                  <input class="custom-input" id="startcal-open-btn" style="padding-right:22px; cursor:pointer;" readonly value="<?php echo $today?>">
                  <span class="icon-btn" style="right:20px; top:25px; font-size:1.28rem; pointer-events:none;">
                    <!-- icon -->
                  </span>
                  <div style="position:absolute; top:3px; left:16px; font-size:12px; color:#bababa; pointer-events:none;">Start Date</div>
                </div>



                <!-- DUE ON INPUT -->
                <div class="modal-col" style="flex:1.1; position:relative;">
                  <input class="custom-input" id="duecal-open-btn" style="padding-right:22px; cursor:pointer;" readonly value="<?php echo $today?>">
                  <span class="icon-btn" style="right:20px; top:25px; font-size:1.28rem; pointer-events:none;">
                    <!-- icon -->
                  </span>
                  <div style="position:absolute; top:3px; left:16px; font-size:12px; color:#bababa; pointer-events:none;">Due Date</div>
                </div>
                  <div id="dueon-chip-container" style="margin-top:8px;"></div>


  
  
      </div>


        <!-- Selected Assignment Chip -->
        <div id="selectedAssignmentChipList" style="margin-top:10px;"></div>

        <div class="selected-assignment-chip" id="selectedAssignmentChip" style="display:none;">
        <span class="chip-title" id="selectedAssignmentLabel"></span>
        <span class="chip-detail" id="selectedAssignmentDetail"></span>
        <span class="chip-remove" id="removeAssignmentChip" title="Remove">&#10005;</span>
      </div>



      <div class="note-link" tabindex="0">Make a note for student or group <span class="dropdown-arrow">&#9660;</span></div>
      <div class="note-area">

          <!-- Student/Group Dropdown -->
          <div class="custom-dropdown-wrapper" id="noteDropdownWrapper" style="display:none; margin-bottom:12px;">
            <div class="custom-dropdown-selected" tabindex="0" id="noteDropdownSelected">
              <span id="noteDropdownText">Select Student or Group</span>
              <span class="dropdown-arrow">&#9662;</span>
            </div>
            <div class="custom-dropdown-list" id="noteDropdownList">
              <div style="padding: 12px;">
                <input type="text" class="custom-input" id="noteDropdownSearch" placeholder="Search for student or group" style="font-size:1.03rem; background: #fafbfc;">
              </div>

               <div class="dropdown-group" id="noteDropdownItems">
            <!-- Dynamic student/group items will be populated here -->
        </div>
            </div>
          </div>


               <div id="noteChipsList" style="margin-bottom:15px;"></div>



                <!-- Selected Student/Group "note for" UI -->
              <div id="noteForStudentSection" style="display:none; margin-bottom:22px;">
                <div style="display:flex;align-items:center;gap:11px;margin-bottom:7px;">
                  <img id="noteForAvatar" src="" class="note-avatar" style="width:39px;height:39px;">
                  <span id="noteForName" style="font-weight:600;font-size:1.12rem;"></span>
                </div>
                <div style="font-size:1.05rem;margin-bottom:7px;">
                  Write a note for <span id="noteForNameLabel" style="font-weight:500;"></span>
                </div>
                <textarea class="note-textarea" placeholder="First name" id="noteTextarea"></textarea>
                <button type="button" id="noteSubmitBtn" style="width:25%;margin-top:18px;padding:10px 0 10px 0;background:#fff;color:#232323;font-size:1rem;font-weight:500;border:2px solid #232323;border-radius:10px;cursor:pointer;transition:.14s;">Submit</button>
              </div>






      </div>




<script>
document.addEventListener('DOMContentLoaded', function() {
  const submitButton = document.getElementById('noteSubmitBtn');

  if (submitButton) {
    submitButton.addEventListener('click', function(event) {
      event.preventDefault();  // Prevent default form submission

      // Get the cohortid from PHP (this should be passed as PHP variable)
      const cohortid = "<?php echo $cohortid; ?>";  // Ensure this is a string

      // Get the selected section ID and course ID from topic dropdown
      const topicDropdownSelected = document.getElementById('topicDropdownSelected');
      const sectionid = topicDropdownSelected ? topicDropdownSelected.getAttribute('section_id') : null;
      const courseid = topicDropdownSelected ? topicDropdownSelected.getAttribute('course_id') : null;

      // Get the progress percentage from the progress bar
      const progressBar = document.querySelector('.subscription_modal_progress_bar_completed');
      const progressPercentage = (progressBar.offsetWidth / progressBar.parentElement.offsetWidth) * 100;

      // Get the whole number part of the percentage (before the decimal point)
      // Always round UP to the next integer:
const roundedProgress = Math.min(100, Math.max(0, Math.ceil(progressPercentage)));
// 12.01 -> 13, 23.001 -> 24

      // Get the note value
      const noteTextarea = document.getElementById('noteTextarea');
      const noteText = noteTextarea ? noteTextarea.value : '';

      // Get the assignment (this can be passed from dropdown)
      const selectedAssignmentLabel = document.getElementById('selectedAssignmentLabel');
      const selectedAssignmentDetail = document.getElementById('selectedAssignmentDetail');
      const assignmentName = selectedAssignmentLabel ? selectedAssignmentLabel.textContent : '';
      const assignmentDetail = selectedAssignmentDetail ? selectedAssignmentDetail.textContent : '';

      // Create an alert to show the values
      alert(`Form Submitted with the following details:
        Cohort ID: ${cohortid}
        Section ID: ${sectionid}
        Course ID: ${courseid}
        Progress: ${roundedProgress}%
        Assignment: ${assignmentName} - ${assignmentDetail}
        Note: ${noteText}
      `);

      // Get the selected user id from noteForStudentSection (after user selects)
      const userId = document.getElementById('noteForStudentSection').getAttribute('data-user-id'); // Get the user id from the attribute
      const activityid = 10;

      debugger

      fetch('../local/adminboard/test/store_students_notes.php', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded'
  },
  body: `activityid=${encodeURIComponent(activityid)}&userid=${encodeURIComponent(userId)}&sectionid=${encodeURIComponent(sectionid)}&courseid=${encodeURIComponent(courseid)}&cohortid=${encodeURIComponent(cohortid)}&note=${encodeURIComponent(noteText)}`
})
.then(response => response.text())  // Get raw text response
.then(text => {
  console.log("Raw response:", text);  // Log the response
  try {
    const data = JSON.parse(text);  // Try parsing as JSON
    if (data.status === 'success') {
      console.log('Successfully inserted data');
    } else {
      console.error('Error inserting data: ' + data.message);
    }
  } catch (error) {
    console.error('Failed to parse JSON:', error);
  }
})
.catch(error => {
  console.error('Error during the fetch request: ' + error);
});
    });
  }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  debugger
  const noteDropdownWrapper = document.getElementById('noteDropdownWrapper');
  const noteDropdownItems = document.getElementById('noteDropdownItems');

  // Get the cohortid from a global JavaScript variable or from the page itself
  const cohortid = "<?php echo $cohortid; ?>";  // This is the cohort ID passed from PHP

  // Fetch cohort members from the new PHP file
  fetch('../local/adminboard/test/get_cohort_members.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `cohortid=${encodeURIComponent(cohortid)}`
  })
  .then(response => response.json())
  .then(members => {
    // Dynamically populate the dropdown with cohort members
    members.forEach(member => {
      debugger
      const dropdownItem = document.createElement('div');
      dropdownItem.classList.add('dropdown-item');
      
      // Set the attribute 'data-user-id' to the member's id
      dropdownItem.setAttribute('data-user-id', member.id); // Set the attribute here

      const noteAvatar = document.createElement('span');
      noteAvatar.classList.add('note-avatar');
      
      // Check if user has a picture
      if (member.picture) {
          const img = document.createElement('img');
          img.classList.add('note-avatar');
          img.src = member.picture;  // Use the fetched picture URL
          dropdownItem.appendChild(img);
      } else {
          noteAvatar.style.backgroundColor = '#1743e3'; // If no picture, use initials or default color
          noteAvatar.textContent = member.firstname[0] + member.lastname[0]; // First initials
          dropdownItem.appendChild(noteAvatar);
      }

      const memberName = document.createElement('span');
      memberName.textContent = `${member.firstname} ${member.lastname}`;
      dropdownItem.appendChild(memberName);

      // Append the dropdown item to the list
      noteDropdownItems.appendChild(dropdownItem);
    });
  })
  .catch(error => {
    console.error('Error fetching cohort members:', error);
  });
});
</script>


<script>

document.addEventListener('DOMContentLoaded', function() {
  const noteDropdownItems = document.getElementById('noteDropdownItems');

  // Add event listener to all dropdown items (sections) in the noteDropdownItems container
  noteDropdownItems.addEventListener('click', function(event) {
    debugger
    // Use closest to find the closest .dropdown-item
    const dropdownItem = event.target.closest('.dropdown-item');

  //    if (dropdownItem.getAttribute('disable') === 'true') {
  //   e.preventDefault();
  //   e.stopPropagation();
  //   return; // ignore disabled
  // }
    
    // Ensure the clicked target is a valid .dropdown-item
    if (dropdownItem) {
      const selectedUserId = dropdownItem.getAttribute('data-user-id'); // Get the user ID from the data attribute

      // Set the selected user ID in the noteForStudentSection
      const noteForStudentSection = document.getElementById('noteForStudentSection');
      noteForStudentSection.setAttribute('data-user-id', selectedUserId); // Store the user ID in the section

      // Optionally, log the selected user ID for debugging
      console.log("Selected User ID: ", selectedUserId);
    }
  });
});
  </script>


<script>
  document.addEventListener('click', function(event) {
  const clickedItem = event.target.closest('#assignmentDropdownList .dropdown-item');
  if (clickedItem) {
    debugger
    const moduleId = clickedItem.getAttribute('data-module-id');
    const moduleName = clickedItem.textContent.trim();

    // Set module name as visible text
    const assignmentText = document.getElementById('assignmentDropdownText');
    if (assignmentText) {
      assignmentText.textContent = moduleName;
    }

    // Set the same data attribute to the selected display
    const assignmentSelected = document.getElementById('assignmentDropdownSelected');
    if (assignmentSelected) {
      assignmentSelected.setAttribute('data-module-id', moduleId);
    }
  }
});
  </script>




      <script>
document.addEventListener('DOMContentLoaded', function() {
  // Add event listener to all dropdown items (sections) in the topic dropdown
  const dropdownItems = document.querySelectorAll('.dropdown-item');

  dropdownItems.forEach(item => {
    item.addEventListener('click', function() {
      // Get the section ID and course ID from the clicked item
      const sectionId = this.getAttribute('data-section-id');
      const courseId = this.getAttribute('data-section-courseid');
      
      // Set the section_id and course_id as new attributes for the selected dropdown item
      const topicDropdownSelected = document.getElementById('topicDropdownSelected');
      if (topicDropdownSelected) {
        topicDropdownSelected.setAttribute('section_id', sectionId);  // Set section_id attribute
        topicDropdownSelected.setAttribute('course_id', courseId);    // Set course_id attribute
      }

      // Update the text of the selected topic dropdown
      const topicDropdownText = document.getElementById('topicDropdownText');
      if (topicDropdownText) {
        topicDropdownText.textContent = `Selected Section ID: ${sectionId} - Course ID: ${courseId}`;
      }

      //alert('Selected Section ID: ' + sectionId);  // Show the alert with section ID

      fetch('../local/adminboard/test/get_subsections_data.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `sectionid=${encodeURIComponent(sectionId)}&courseID=${courseId}`
      })
      .then(response => response.json())  // Parse the JSON response
      .then(data => {
        console.log("Subsections Data:", data);  // Check the response in the console

        // Get the main dropdown container
        const assignmentDropdownList = document.getElementById('assignmentDropdownList');

        // Ensure the dropdown exists
        if (assignmentDropdownList) {
          // Clear existing dropdowns before adding new ones
          assignmentDropdownList.innerHTML = '';

          // Check if there are subsections
          if (data.subsections && data.subsections.length > 0) {
            // Loop through subsections and add them to the dropdown list
            data.subsections.forEach(subsection => {
              // Create a dropdown group for the section
              const dropdownGroup = document.createElement('div');
              dropdownGroup.classList.add('dropdown-group');
              
              // Create the label for the section (e.g., Quizzes, Assignments)
              const dropdownGroupLabel = document.createElement('div');
              dropdownGroupLabel.classList.add('dropdown-group-label', 'accordion-toggle');
              dropdownGroupLabel.setAttribute('data-acc', subsection.id);
              dropdownGroupLabel.innerHTML = `<span>${subsection.name}</span><span class="accordion-arrow">&#9662;</span>`;
              
              // Create the container for the modules (activities) under the section
              const dropdownItemsContainer = document.createElement('div');
              dropdownItemsContainer.classList.add('dropdown-items');
              dropdownItemsContainer.setAttribute('data-acc', subsection.id);
              dropdownItemsContainer.style.display = 'none';
              
              // Loop through modules (activities) for the current subsection
              if (subsection.modules && subsection.modules.length > 0) {
                subsection.modules.forEach(module => {
                  const dropdownItem = document.createElement('div');
                  dropdownItem.classList.add('dropdown-item');
                  dropdownItem.textContent = module.name;  
                  dropdownItem.setAttribute('data-module-id', module.id);  // Set the module ID for each module

                  dropdownItemsContainer.appendChild(dropdownItem);
                });
              }

              // Append the label and items container to the dropdown group
              dropdownGroup.appendChild(dropdownGroupLabel);
              dropdownGroup.appendChild(dropdownItemsContainer);

              // Append the dropdown group to the main assignment dropdown list
              assignmentDropdownList.appendChild(dropdownGroup);
            });
          } else {
            const noSubsectionsMessage = document.createElement('p');
            noSubsectionsMessage.textContent = 'No subsections available.';
            assignmentDropdownList.appendChild(noSubsectionsMessage);
          }
        } else {
          console.error('Assignment dropdown list not found.');
        }
      })
      .catch(error => {
        console.error('Error fetching subsections:', error);
      });
    });
  });
});



</script>



<script>
document.addEventListener('DOMContentLoaded', function() {
  // Add event listener to the submit button
   // Add event listener to the submit button
  const submitButton = document.querySelector('.modal-submit-btn');
  
 if (submitButton) {
  debugger
    submitButton.addEventListener('click', function(event) {
      event.preventDefault();  // Prevent form submission, if any

      // Use PHP values correctly within JavaScript
      const userid = "<?php echo htmlspecialchars($userid, ENT_QUOTES, 'UTF-8'); ?>";  // Ensure this is a string
      const cohortid = "<?php echo htmlspecialchars($cohortid, ENT_QUOTES, 'UTF-8'); ?>";  // Ensure this is a string

      // Get the section_id and course_id from the selected topic dropdown
      const topicDropdownSelected = document.getElementById('topicDropdownSelected');
      const sectionid = topicDropdownSelected.getAttribute('section_id');
      const courseid = topicDropdownSelected.getAttribute('course_id');
      debugger

      // Get the progress percentage from the progress bar
      const progressBar = document.querySelector('.subscription_modal_progress_bar_completed');
      const progressPercentage = (progressBar.offsetWidth / progressBar.parentElement.offsetWidth) * 100;

      // Get the whole number part of the percentage (before the decimal point) without rounding
      // Always round UP to the next integer:
const roundedProgress = Math.min(100, Math.max(0, Math.ceil(progressPercentage)));
// 12.01 -> 13, 23.001 -> 24

      // Check if section_id, course_id, and progressPercentage are selected
      if (!sectionid || !courseid || !roundedProgress) {
        alert('Please select a section, course, and ensure the progress is set first!');
        return;
      }

      // Display the collected values in an alert
      alert(`Form submitted successfully!\nUserID: ${userid}\nCohortID: ${cohortid}\nCourseID: ${courseid}\nSectionID: ${sectionid}\nProgress: ${roundedProgress}%`);


      debugger
    
  const topicDropdown = document.getElementById('topicDropdownSelected');

  console.log("Chip count:", $('#selectedAssignmentChipList .assignment-chip').length);
 
  
 const assignments = [];

$('#selectedAssignmentChipList .assignment-chip').each(function () {
  const moduleid = $(this).attr('data-module-id');
  const startdate = $(this).attr('data-startdate');
  const duedate = $(this).attr('data-duedate');

  if (moduleid && startdate && duedate) {
    assignments.push({
      moduleid,
      startdate,
      duedate
    });
  }
});

console.log("Assignments:", assignments);

debugger
assignments.forEach(assignment => {
  const body = 
    `moduleid=${encodeURIComponent(assignment.moduleid)}` +
    `&cohortid=${encodeURIComponent(cohortid)}` +
    `&startdate=${encodeURIComponent(assignment.startdate)}` +
    `&duedate=${encodeURIComponent(assignment.duedate)}`;

  fetch('../local/adminboard/test/apply_restrictions.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: body
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === 'success') {
      console.log(`Restriction applied to module ${assignment.moduleid}`);
    } else {
      console.error(`Failed to apply restriction: ${data.message}`);
    }
  })
  .catch(error => {
    console.error('Error applying restriction:', error);
  });
});

  debugger

       // Make the fetch call with the relevant data
      fetch('../local/adminboard/test/update_popup_info.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `userid=${encodeURIComponent(userid)}&selected_topic_id=${encodeURIComponent(sectionid)}&course_id=${encodeURIComponent(courseid)}&completion_percentage=${encodeURIComponent(roundedProgress)}&cohort_id=${encodeURIComponent(cohortid)}`
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
   console.log('Successfully updated popup info');

// Fade out the topic modal first
$('#topicModal').fadeOut('fast', function() {
  // Now inject the modal into the DOM after fade out completes
  const modalHTML = `
    <div id="congratsModalBackdrop" style="display:block; position:fixed; top:0; left:0; width:100%; height:100%; background:#00000055; z-index:9998;"></div>
    <div id="congratsModal" style="display:block; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); background:#fff; padding:30px; border-radius:12px; z-index:9999; text-align:center;">
      <div class="congrats-content">
        <img src="https://cdn-icons-png.flaticon.com/512/3159/3159066.png" alt="Celebration" style="width:80px; margin-bottom:20px;" />
        <h2>Congratulations!</h2>
        <p>You’ve successfully completed ${roundedProgress}% of the session.<br>Great job guiding your students!</p>
        <button type="button" id="congratsOkayBtn" style="margin-top:20px; padding:8px 18px; background:#ff2500; color:#fff; border:none; border-radius:6px; cursor:pointer;">Okay, thanks!</button>
      </div>
    </div>
  `;
  document.body.insertAdjacentHTML('beforeend', modalHTML);

  // Attach the event to close modal on button click
  document.getElementById('congratsOkayBtn').addEventListener('click', () => {
    $('#congratsModal, #congratsModalBackdrop').fadeOut(300, function () {
      $('#congratsModal, #congratsModalBackdrop').remove();
    });
  });
});
  } else {
          console.error('Failed to update popup info');
          // Handle failure (show an error message, etc.)
        }
      })
      .catch(error => {
        console.error('Error updating popup info:', error);
        // Handle network errors
      });

      
    });
  }
});

  </script>


<script>
document.addEventListener('DOMContentLoaded', function() {
  const congratsBtn = document.getElementById('congratsOkayBtn');
  if (congratsBtn) {
    congratsBtn.addEventListener('click', function() {
      document.getElementById('congratsModal').style.display = 'none';
      document.getElementById('congratsModalBackdrop').style.display = 'none';
    });
  }
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
  const dropdownItems = document.querySelectorAll('.dropdown-item');

  dropdownItems.forEach(item => {
    item.addEventListener('click', function () {
      const sectionId = this.getAttribute('data-section-id');
      const courseId = this.getAttribute('data-section-courseid');
      const cohortid = "<?php echo $cohortid; ?>"; // This is the cohort ID passed from PHP

      const topicDropdownSelected = document.getElementById('topicDropdownSelected');
      if (topicDropdownSelected) {
        topicDropdownSelected.setAttribute('section_id', sectionId); // Set section_id attribute
        topicDropdownSelected.setAttribute('course_id', courseId); // Set course_id attribute
      }

      const topicDropdownText = document.getElementById('topicDropdownText');
      if (topicDropdownText) {
        topicDropdownText.textContent = `Selected Section ID: ${sectionId} - Course ID: ${courseId}`;
      }

      // Fetch the progress percentages from the new PHP file
      fetch('../local/adminboard/test/get_progress_percentage.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `subsection_id=${encodeURIComponent(sectionId)}&cohort_id=${encodeURIComponent(cohortid)}`
      })
        .then(response => response.json())
        .then(data => {
          const pointsContainer = document.querySelector('.subscription_modal_progress_bar_progressShow');
          const progressBarCompleted = document.querySelector('.subscription_modal_progress_bar_completed');
          const draggablePercentageText = document.querySelector('.subscription_modal_progress_bar_draggable_percentage_value');
          const draggable = document.querySelector('.subscription_modal_progress_bar_draggable');


          debugger

          
           // Reset progress points (set them to 0)
          const progressPoints = pointsContainer.querySelectorAll('.subscription_modal_progress_bar_point_01');
          progressPoints.forEach(progressPoint => {
            progressPoint.remove(); // Remove existing progress points
          });

        // Reset the draggable pointer position to 0%
           if (draggable) {
            draggable.style.left = '0%'; // Set the position to 0%
             // Set the width of the completed progress bar to 0%
            const completedDiv = document.querySelector('.subscription_modal_progress_bar_completed');
            if (completedDiv) {
              completedDiv.style.width = '0%'; // Set the width to 0% to reset the progress bar
              completedDiv.style.setProperty('--progressComplete', '0%'); // If using CSS variable for progress
            }
            const percentageValueDiv = draggable.querySelector('.subscription_modal_progress_bar_draggable_percentage_value');
            if (percentageValueDiv) {
              percentageValueDiv.textContent = '0%'; // Set the text to 0%
            }
          }


          // Create the container and static elements (0% and 100% markers)
          const progressContainer = document.createElement('div');
          progressContainer.classList.add('subscription_modal_progress_bar_container');
          const progressBar = document.createElement('div');
          progressBar.classList.add('subscription_modal_progress_bar_progress', 'subscription_modal_progress_bar_progressShow');
          progressContainer.appendChild(progressBar);

          // Add dynamic progress points using Object.entries to loop over the object
          Object.entries(data.percentages).forEach(([key, percentage], index) => {
            const progressPoint = document.createElement('div');
            progressPoint.classList.add('subscription_modal_progress_bar_point_01');
            progressPoint.style.left = `calc(${percentage}% - 14px)`;  // Set the position based on the percentage

            // Create the pointer for the progress point
            const progressPointer = document.createElement('div');
            progressPointer.classList.add('subscription_modal_progress_bar_pointer');
            progressPointer.innerHTML = `<span>${parseInt(index) + 1}</span>`; // Using `key` here to dynamically set the number (1, 2, 3, ...)
            progressPoint.appendChild(progressPointer);

            debugger

            // Create the SVG for the pointer
            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svg.setAttribute('width', '10');
            svg.setAttribute('height', '10');
            svg.setAttribute('viewBox', '0 0 10 10');
            svg.setAttribute('fill', 'none');
            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            path.setAttribute('d', 'M6.29904 8.75C5.72169 9.75 4.27831 9.75 3.70096 8.75L0.236859 2.75C-0.340491 1.75 0.381197 0.500001 1.5359 0.500001L8.4641 0.5C9.6188 0.5 10.3405 1.75 9.76314 2.75L6.29904 8.75Z');
            path.setAttribute('fill', '#FF2500');
            svg.appendChild(path);
            progressPoint.appendChild(svg);

            // Create the paragraph to display the percentage next to the pointer
            const percentageText = document.createElement('p');
            percentageText.textContent = `${percentage}%`;  // Set the percentage text
            if(percentage !== "100")
            {
             progressPoint.appendChild(percentageText);
            }

            // Compare as numbers, and hide only for 95–99.99%
          const pct = Number(percentage);

          if (pct >= 95 && pct < 100) {
            const p = document.querySelector('.subscription_modal_progress_bar_end_point p');
            if (p) p.style.display = 'none';
          }
            

            // Append the progress point to the container
            pointsContainer.appendChild(progressPoint);
          });

          // Add draggable pointer and 100% marker after the loop
            const lastPercentage = Object.values(data.percentages)[Object.values(data.percentages).length - 1];

            // Update the existing draggable pointer's position and value
            const draggableDiv = document.querySelector('.subscription_modal_progress_bar_draggable');
            if (draggableDiv) {
              draggableDiv.style.left = `calc(${lastPercentage}% - 14px)`; // Update position based on the last percentage

               // Update the width of the completed progress bar based on the last percentage
  const completedDiv = document.querySelector('.subscription_modal_progress_bar_completed');
  if (completedDiv) {
    completedDiv.style.width = `${lastPercentage}%`; // Set width to match the percentage
    completedDiv.style.setProperty('--progressComplete', `${lastPercentage}%`); // For any CSS variable usage
  }

              const percentageValueDiv = draggableDiv.querySelector('.subscription_modal_progress_bar_draggable_percentage_value');
              if (percentageValueDiv) {
                percentageValueDiv.textContent = `${lastPercentage}%`; // Update the percentage text
              }
            }

            // Update the progress bar width (completed part) based on the last percentage
            const completedDiv = document.querySelector('.subscription_modal_progress_bar_completed');
            if (completedDiv) {
              completedDiv.style.setProperty('--progressComplete', `${lastPercentage}%`); // Update --progressComplete CSS property
            }
         
        })
        .catch(error => {
          console.error('Error fetching progress percentages:', error);
        });
    });
  });
});
</script>








<style>
.subscription_modal_progress_bar_container {
  width: 100%;
  max-width: 500px;
  margin: 32px auto;
  height: 81px;
  border-radius: 128px;
  background: #fff;
  border: 1px solid #d1d5db;
  box-shadow: 0 39px 39px 0 rgba(0, 0, 0, 0.03), 0 9px 22px 0 rgba(0, 0, 0, 0.03);
  padding: 6px 28px;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}

.subscription_modal_progress_bar_progress {
  width: 100%;
  height: 8px;
  border-radius: 4px;
  background: #eaecf0;
  position: relative;
}

.subscription_modal_progress_bar_completed {
  width: var(--progressComplete, 65%);
  height: 8px;
  border-radius: 4px;
  background: #ff2500;
  position: absolute;
  top: 0;
  left: 0;
}

.subscription_modal_progress_bar_start_point,
.subscription_modal_progress_bar_end_point {
  position: absolute;
  top: 90%;
  display: flex;
  flex-direction: column;
  align-items: center;
  font-size: 12px;
  color: #0008;
  font-weight: 600;
}

.subscription_modal_progress_bar_start_point {
  left: -5px;
}
.subscription_modal_progress_bar_end_point {
  right: -13px;
}

.subscription_modal_progress_bar_point_01 {
  display: flex;
  flex-direction: column;
  align-items: center;
  position: absolute;
  top: -24px;
  width: 30px;
}
.subscription_modal_progress_bar_pointer {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background: #ff2500;
  display: flex;
  align-items: center;
  justify-content: center;
}
.subscription_modal_progress_bar_pointer span {
  color: #fff;
  font-weight: 600;
  font-size: 12px;
}
.subscription_modal_progress_bar_point_01 svg {
  margin-top: 7px;
}
.subscription_modal_progress_bar_point_01 p {
  font-size: 12px;
  color: #0008;
  font-weight: 600;
}

.subscription_modal_progress_bar_draggable {
  top: -8px;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  position: absolute;
  transform: translateX(-2px);
  z-index: 2;
  width: 30px;
}
.subscription_modal_progress_bar_draggable_pointer {
  width: 23px;
  height: 23px;
  border-radius: 50%;
  border: 1px solid #ff2500;
  background: #fff;
  box-shadow: 0 4px 8px -2px rgba(16,24,40,0.1),
    0 2px 4px -2px rgba(16,24,40,0.06);
}
.subscription_modal_progress_bar_draggable p {
  font-weight: 600;
  font-size: 12px;
  color: #000;
  visibility: hidden;
  opacity: 0;
  transition: 0.3s;
  margin-top: 2px;
}
.subscription_modal_progress_bar_draggable p.active {
  visibility: visible;
  opacity: 1;
}
</style>

<div class="subscription_modal_progress_bar_container">
  <div class="subscription_modal_progress_bar_progress subscription_modal_progress_bar_progressShow">
     <!-- The dynamic progress bar width (completed part) will be updated -->
  <div class="subscription_modal_progress_bar_completed" style="--progressComplete: 0%"></div>

    <!-- 0% boundary marker (always visible) -->
    <div class="subscription_modal_progress_bar_start_point">
      <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
        <path d="M6.29904 8.75C5.72169 9.75 4.27831 9.75 3.70096 8.75L0.236859 2.75C-0.340491 1.75 0.381197 0.500001 1.5359 0.500001L8.4641 0.5C9.6188 0.5 10.3405 1.75 9.76314 2.75L6.29904 8.75Z" fill="#FF2500"/>
      </svg>
      <p>0%</p>
    </div>

    <!-- 100% boundary marker (always visible) -->
    <div class="subscription_modal_progress_bar_end_point">
      <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
        <path d="M6.29904 8.75C5.72169 9.75 4.27831 9.75 3.70096 8.75L0.236859 2.75C-0.340491 1.75 0.381197 0.500001 1.5359 0.500001L8.4641 0.5C9.6188 0.5 10.3405 1.75 9.76314 2.75L6.29904 8.75Z" fill="#eaecf0"/>
      </svg>
      <p>100%</p>
    </div>

    <!-- Dynamic progress points will be added here -->
    <div class="subscription_modal_progress_bar_progressShow"></div>

    <!-- Draggable pointer for updating progress -->
    <div class="subscription_modal_progress_bar_draggable" style="left: 0%">
      <div class="subscription_modal_progress_bar_draggable_pointer"></div>
      <p class="subscription_modal_progress_bar_draggable_percentage_value">0%</p>
    </div>
  </div>
</div>






  </form>



  </div>

   <div class="modal-footer">
    <button type="submit" class="modal-submit-btn">Submit</button>
  </div>


</div>






<!-- START DATE MODAL -->
<div class="supercal-backdrop" id="startcal-backdrop" style="display:none;"></div>
<div class="supercal-modal" id="startcal-modal" style="display:none;">
  <span class="supercal-close" id="startcal-close-btn">&times;</span>
  <div class="supercal-header" style="margin-top:35px;">
    <button type="button" class="supercal-arrow" id="startcal-prev-month">&#8592;</button>
    <span class="supercal-title" id="startcal-monthyear"><?php echo $monthyear?></span>
    <button type="button" class="supercal-arrow" id="startcal-next-month">&#8594;</button>
  </div>
  <div class="supercal-days">
    <span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span><span>Su</span>
  </div>
  <div class="supercal-dates" id="startcal-dates"></div>
  <div class="supercal-time-row">
    <select id="startcal-hour" class="supercal-time-select"></select>
    <span class="supercal-time-colon">:</span>
    <select id="startcal-minute" class="supercal-time-select"></select>
    <select id="startcal-ampm" class="supercal-time-select"></select>
  </div>
  <button type="button" class="supercal-confirm" id="startcal-done-btn">Done</button>
</div>









<!-- DUE ON MODAL -->
<div class="supercal-backdrop" id="duecal-backdrop" style="display:none;"></div>
<div class="supercal-modal" id="duecal-modal" style="display:none;">
  <span class="supercal-close" id="duecal-close-btn">&times;</span>
  <div class="supercal-header" style="margin-top:35px;">
    <button type="button" class="supercal-arrow" id="duecal-prev-month">&#8592;</button>
    <span class="supercal-title" id="duecal-monthyear"><?php echo $monthyear?></span>
    <button type="button" class="supercal-arrow" id="duecal-next-month">&#8594;</button>
  </div>
  <div class="supercal-days">
    <span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span><span>Su</span>
  </div>
  <div class="supercal-dates" id="duecal-dates"></div>
  <div class="supercal-time-row">
    <select id="duecal-hour" class="supercal-time-select"></select>
    <span class="supercal-time-colon">:</span>
    <select id="duecal-minute" class="supercal-time-select"></select>
    <select id="duecal-ampm" class="supercal-time-select"></select>
  </div>
  <button type="button" class="supercal-confirm" id="duecal-done-btn">Done</button>
</div>











<!-- CHIP HTML: Place this after your assignment and date fields -->
<div class="selected-assignment-chip" id="selectedAssignmentChip" style="display:none; margin-top:10px;">
  <span class="chip-title" id="selectedAssignmentLabel"></span>
  <span class="chip-detail" id="selectedAssignmentDetail"></span>
  <span class="chip-remove" id="removeAssignmentChip" title="Remove" style="cursor:pointer;">&#10005;</span>
</div>

























<!-- Session Absence Modal (for NO flow) -->
<div id="absenceModal" class="custom-modal-overlay" style="display:none;">
  <div class="absence-modal-content">
    <button class="absence-back-btn" id="absenceBackBtn">&#8592;</button>
    <button class="absence-close-btn" id="absenceCloseBtn">&times;</button>
    <div class="absence-title">Session Absence</div>
    <div class="absence-desc">
      It seems you haven’t joined this session. Please select a reason for your absence.
    </div>
    <div class="absence-label">Please choose a reason for cancel lesson</div>



            <div class="absence-select-wrapper">
            <div class="custom-select-selected" tabindex="0" id="absenceSelectTrigger">
                <span class="custom-select-placeholder">Select Reason</span>
                <span class="custom-select-arrow">&#9662;</span>
            </div>
            <div class="custom-select-list" id="absenceCustomList">
                <div class="custom-select-option" data-value="health">The timing isn’t working out today.</div>
                <div class="custom-select-option" data-value="tech">There are some tech issues, so we can't run the class.</div>
                <div class="custom-select-option" data-value="teacher">The teacher isn’t available right now.</div>
                <div class="custom-select-option" data-value="personal">He’s not able to make it today.</div>
                <div class="custom-select-option" data-value="students">Not enough students showed up, so we’ll skip this one.</div>
            </div>
            <input type="hidden" id="absenceReason" class="absence-select" value="" />
            <input type="hidden" id="absenceReasonText" value="" />
            </div>




    
    <textarea class="absence-textarea" id="absenceExplain" placeholder="explain the reason..."></textarea>
    <button class="absence-submit-btn">Submit</button>
  </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function () {
  debugger
  const absenceSubmitBtn = document.querySelector('.absence-submit-btn');
  
  if (absenceSubmitBtn) {
    debugger
    absenceSubmitBtn.addEventListener('click', function (event) {
      debugger
      event.preventDefault();

      // Get selected reason value from hidden input
    const selectedReason = document.getElementById('absenceReasonText')?.value || '';

      // Get explanation text
      const explanation = document.getElementById('absenceExplain')?.value || '';

      // Get user and cohort from PHP
      const userid = "<?php echo (int)$userid; ?>";
      const cohortid = "<?php echo (int)$cohortid; ?>";

      // Validate input
      if (!selectedReason) {
        alert('Please select a reason for absence.');
        return;
      }

      // Optional: validate explanation if required
      if (!explanation.trim()) {
        alert('Please explain the reason.');
        return;
      }

      // Send data to backend
      fetch('<?php echo $CFG->wwwroot; ?>/local/adminboard/test/store_absence_reason.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `userid=${encodeURIComponent(userid)}&cohort_id=${encodeURIComponent(cohortid)}&reason=${encodeURIComponent(selectedReason)}&explanation=${encodeURIComponent(explanation)}`
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          alert('Absence recorded successfully!');
          document.getElementById('absenceModal').style.display = 'none';
        } else {
          alert('Failed to submit absence. ' + (data.message || ''));
        }
      })
      .catch(error => {
        debugger
        console.error('Error:', error);
        alert('An error occurred while submitting.');
      });
    });
  }
});
</script>



<script>
document.addEventListener('DOMContentLoaded', function () {
  debugger
  const reasonOptions = document.querySelectorAll('#absenceCustomList .custom-select-option');
  const reasonInput = document.getElementById('absenceReason');
  const trigger = document.getElementById('absenceSelectTrigger');

  reasonOptions.forEach(option => {
    option.addEventListener('click', function () {

      debugger
      const selectedValue = this.getAttribute('data-value');
      const selectedText = this.textContent.trim();

      if (reasonInput) reasonInput.value = selectedValue;

const reasonTextInput = document.getElementById('absenceReasonText');
if (reasonTextInput) reasonTextInput.value = selectedText;
      if (trigger) trigger.querySelector('.custom-select-placeholder').textContent = selectedText;

      // Optionally close the dropdown (if you have toggle logic)
      document.getElementById('absenceCustomList').style.display = 'none';
    });
  });

  trigger.addEventListener('click', function () {
    const list = document.getElementById('absenceCustomList');
    list.style.display = (list.style.display === 'block') ? 'none' : 'block';
  });
});
</script>


<!-- Correct JS Includes -->
<script src="<?php echo $CFG->wwwroot; ?>/local/adminboard/test/js/schedule_session.js?v=<?php echo time(); ?>"></script>
<script src="<?php echo $CFG->wwwroot; ?>/local/adminboard/test/js/schedule_session_part2.js?v=<?php echo time(); ?>"></script>
<script src="<?php echo $CFG->wwwroot; ?>/local/adminboard/test/js/schedule_session_part3.js?v=<?php echo time(); ?>"></script>






















