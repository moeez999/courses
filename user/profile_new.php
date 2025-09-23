<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Public Profile -- a user's public profile page
 *
 * @package    core_user
 * @copyright  2010 Remote-Learner.net
 * @author     Hubert Chathi <hubert@remote-learner.net>
 * @author     Olav Jordan <olav.jordan@remote-learner.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../config.php');
require_once($CFG->dirroot . '/my/lib.php');
require_once($CFG->dirroot . '/user/profile/lib.php');
require_once($CFG->dirroot . '/user/lib.php');
require_once($CFG->libdir.'/filelib.php');
global $COURSE;
$userid = optional_param('id', 0, PARAM_INT);
$edit = optional_param('edit', null, PARAM_BOOL);
$reset = optional_param('reset', null, PARAM_BOOL);

$userid = $userid ?: $USER->id;
$PAGE->set_url('/user/profile_new', ['id' => $userid]);

if (!empty($CFG->forceloginforprofiles)) {
    require_login();
    if (isguestuser()) {
        $PAGE->set_context(context_system::instance());
        echo $OUTPUT->header();
        echo $OUTPUT->confirm(get_string('guestcantaccessprofiles', 'error'),
                              get_login_url(),
                              $CFG->wwwroot);
        echo $OUTPUT->footer();
        die;
    }
} else if (!empty($CFG->forcelogin)) {
    require_login();
}

if ((!$user = $DB->get_record('user', array('id' => $userid))) || ($user->deleted)) {
    $PAGE->set_context(context_system::instance());
    echo $OUTPUT->header();
    if (!$user) {
        echo $OUTPUT->notification(get_string('invaliduser', 'error'));
    } else {
        echo $OUTPUT->notification(get_string('userdeleted'));
    }
    echo $OUTPUT->footer();
    die;
}

$currentuser = ($user->id == $USER->id);
$context = $usercontext = context_user::instance($userid, MUST_EXIST);

if (!user_can_view_profile($user, null, $context)) {
    $struser = get_string('user');
    $PAGE->set_context(context_system::instance());
    $PAGE->set_title($struser);
    $PAGE->set_heading($struser);
    $PAGE->set_pagelayout('mypublic');
    $PAGE->add_body_class('limitedwidth');
    $PAGE->set_url('/user/profile.php', array('id' => $userid));
    $PAGE->navbar->add($struser);
    echo $OUTPUT->header();
    echo $OUTPUT->notification(get_string('usernotavailable', 'error'));
    echo $OUTPUT->footer();
    exit;
}

if (!$currentpage = my_get_page($userid, MY_PAGE_PUBLIC)) {
    throw new \moodle_exception('mymoodlesetup');
}

$PAGE->set_context($context);
$PAGE->set_pagelayout('mypublic');
$PAGE->add_body_class('limitedwidth');
$PAGE->set_pagetype('user-profile');

if (isguestuser()) {
    $USER->editing = $edit = 0;
    $PAGE->set_blocks_editing_capability('moodle/my:configsyspages');
} else {
    if ($currentuser) {
        $PAGE->set_blocks_editing_capability('moodle/user:manageownblocks');
    } else {
        $PAGE->set_blocks_editing_capability('moodle/user:manageblocks');
    }
}

// Start setting up the page
$strpublicprofile = get_string('publicprofile');

$PAGE->blocks->add_region('content');
$PAGE->set_subpage($currentpage->id);
$PAGE->set_title(fullname($user).": $strpublicprofile");
$PAGE->set_heading(fullname($user));

if (!$currentuser) {
    $PAGE->navigation->extend_for_user($user);
    if ($node = $PAGE->settingsnav->get('userviewingsettings'.$user->id)) {
        $node->forceopen = true;
    }
} else if ($node = $PAGE->settingsnav->get('dashboard', navigation_node::TYPE_CONTAINER)) {
    $node->forceopen = true;
}
if ($node = $PAGE->settingsnav->get('root')) {
    $node->forceopen = false;
}

// Toggle the editing state and switches
if ($PAGE->user_allowed_editing()) {
    if ($reset !== null) {
        if (!is_null($userid)) {
            if (!$currentpage = my_reset_page($userid, MY_PAGE_PUBLIC, 'user-profile')) {
                throw new \moodle_exception('reseterror', 'my');
            }
            redirect(new moodle_url('/user/profile.php', array('id' => $userid)));
        }
    } else if ($edit !== null) {
        $USER->editing = $edit;
    } else {
        if ($currentpage->userid) {
            if (!empty($USER->editing)) {
                $edit = 1;
            } else {
                $edit = 0;
            }
        } else {
            if (!$currentpage = my_copy_page($userid, MY_PAGE_PUBLIC, 'user-profile')) {
                throw new \moodle_exception('mymoodlesetup');
            }
            $PAGE->set_context($usercontext);
            $PAGE->set_subpage($currentpage->id);
            $USER->editing = $edit = 0;
        }
    }

    $params = array('edit' => !$edit, 'id' => $userid);
    $resetbutton = '';
    $resetstring = get_string('resetpage', 'my');
    $reseturl = new moodle_url("$CFG->wwwroot/user/profile.php", array('edit' => 1, 'reset' => 1, 'id' => $userid));

    if (!$currentpage->userid) {
        $editstring = get_string('updatemymoodleon');
        $params['edit'] = 1;
    } else if (empty($edit)) {
        $editstring = get_string('updatemymoodleon');
        $resetbutton = $OUTPUT->single_button($reseturl, $resetstring);
    } else {
        $editstring = get_string('updatemymoodleoff');
        $resetbutton = $OUTPUT->single_button($reseturl, $resetstring);
    }

    $url = new moodle_url("$CFG->wwwroot/user/profile.php", $params);
    $button = '';
    if (!$PAGE->theme->haseditswitch) {
        $button = $OUTPUT->single_button($url, $editstring);
    }
    $PAGE->set_button($resetbutton . $button);
} else {
    $USER->editing = $edit = 0;
}

profile_view($user, $usercontext);

// Start output with new modern design
echo $OUTPUT->header();
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php
// Add custom CSS for the modern design
echo '
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

';
// Include custom CSS
require_once(__DIR__.'/profile_styles.php');

echo '<div class="user-profile-modern">';

// Header Navigation Bar
echo '
<header class="page-header">
  <div class="header-container">
    <div class="header-left">
       
      <nav class="main-nav">
        <ul>
          <li><a href="#">'.get_string('home', 'core_user').'</a></li>
          <li><a href="#">'.get_string('groups', 'core_user').'</a></li>
          <li><a href="#">'.get_string('attendance', 'core_user').'</a></li>
          <li><a href="#">'.get_string('calendar', 'core_user').'</a></li>
          <li><a href="#" class="active">'.get_string('dashboard', 'core_user').'</a></li>
          <li><a href="#">'.get_string('settings', 'core_user').'</a></li>
        </ul>
      </nav>
    </div>
      
  </div>
</header>
';

?>
<?php 
echo '<div class="container-fluid mt-3">
      <div class="row g-3">
        <div class="col-lg-8 col-md-12">';
      
require_once(__DIR__.'/profile_attendance.php');
?>  
<div class="row g-3">
    <div class="col-lg-12 col-md-12">
        <?php
        // Description section
        $hiddenfields = [];
        if (!has_capability('moodle/user:viewhiddendetails', $usercontext)) {
            $hiddenfields = array_flip(explode(',', $CFG->hiddenuserfields));
        }
        if ($user->description && !isset($hiddenfields['description'])) {
            echo '<section class="profile-card">';
            echo '<div class="profile-card-header">';
            echo '<h2>'.get_string('aboutme', 'core_user').'</h2>';
            echo '</div>';
            
            echo '<div class="profile-description">';
            if (!empty($CFG->profilesforenrolledusersonly) && !$currentuser &&
                !$DB->record_exists('role_assignments', array('userid' => $user->id))) {
                echo '<p>'.get_string('profilenotshown', 'moodle').'</p>';
            } else {
                $user->description = file_rewrite_pluginfile_urls($user->description, 'pluginfile.php', $usercontext->id, 'user',
                                                                'profile', null);
                echo format_text($user->description, $user->descriptionformat);
            }
            echo '</div>';
            echo '</section>';
        }

        // Custom blocks region
        echo $OUTPUT->custom_block_region('content');

        // Get all graded items for the current user in current course 
        require_once(__DIR__.'/profile_results.php');

        echo '</div>
            </div>
        </section>
    </div>';

        // Payment history section
        require_once(__DIR__.'/profile_payments.php');

        echo '</div>
            </section> 
        </div> 
    </div>';

        // Cohort history section
        require_once(__DIR__.'/profile_cohorts.php');

        $renderer = $PAGE->get_renderer('core_user', 'myprofile');
        $tree = core_user\output\myprofile\manager::build_tree($user, $currentuser);

        // Use reflection to access and modify the categories
        $reflection = new ReflectionClass($tree);
        $categoriesProperty = $reflection->getProperty('categories');
        $categoriesProperty->setAccessible(true);

        $categories = $categoriesProperty->getValue($tree);
        $allowedCategories = ['miscellaneous', 'reports', 'administration'];

        // Filter categories
        $filteredCategories = array_filter($categories, function($category) use ($allowedCategories) {
            return in_array($category->name, $allowedCategories);
        });

        // Re-index the array
        $filteredCategories = array_values($filteredCategories);

        // Set the filtered categories back
        $categoriesProperty->setValue($tree, $filteredCategories);
        // Start output with tab container
        echo '<div class="col-lg-7 col-md-12">';
        echo '<div class="modern-tab-wrapper">';

        // Create tab navigation
        echo '<div class="modern-tab-nav">';
        echo '<button class="modern-tab-btn active" data-tab="miscellaneous">'.get_string('miscellaneous').'</button>';
        echo '<button class="modern-tab-btn" data-tab="reports">'.get_string('reports').'</button>';
        echo '<button class="modern-tab-btn" data-tab="administration">'.get_string('administration').'</button>';
        echo '</div>';

        // Create tab content container
        echo '<div class="modern-tab-content">';

        // Render each category as a tab panel
        foreach ($filteredCategories as $index => $category) {
            $active = $index === 0 ? 'active' : '';
            echo '<div class="modern-tab-panel '.$active.'" id="tab-'.$category->name.'">';
            echo $renderer->render($category);
            echo '</div>';
        }

        // Close containers
        echo '</div>'; // .modern-tab-content
        echo '</div>'; // .modern-tab-wrapper
        echo '</div>'; // .col-lg-7
        echo '</div>'; // .col-lg-7
        ?>
    </div>
    
    <?php 
    // Feedback sections
    require_once(__DIR__.'/profile_feedback.php');
    ?>   

</div>
</div>
<div class="col-lg-4 col-md-12">
    <div class="column">
        <?php
        // Profile card
        require_once(__DIR__.'/profile_card.php');

        // Contact Information
        require_once(__DIR__.'/profile_contact.php');
        
        // Login activity
        require_once(__DIR__.'/profile_activity.php');
        ?>
    </div>
</div>
</div>
</div>

<?php
require_once(__DIR__.'/profile_scripts.php');
echo $OUTPUT->footer();