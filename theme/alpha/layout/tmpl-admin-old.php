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
 * Admin Template.
 *
 * @package   theme_alpha
 * @copyright 2022 - 2023 Marcin Czaja (https://rosea.io)
 * @license   Commercial https://themeforest.net/licenses
 */

defined('MOODLE_INTERNAL') || die();
user_preference_allow_ajax_update('drawer-open-nav', PARAM_ALPHA);
user_preference_allow_ajax_update('sidepre-open', PARAM_ALPHA);
user_preference_allow_ajax_update('darkmode-on', PARAM_ALPHA);
user_preference_allow_ajax_update('drawer-open-index', PARAM_BOOL);
user_preference_allow_ajax_update('drawer-open-block', PARAM_BOOL);

require_once($CFG->libdir . '/behat/lib.php');
require_once($CFG->dirroot . '/course/lib.php');

$draweropenright = false;
$extraclasses = [];

// Moodle 4.x. - Add block button in editing mode.
$addblockbutton = $OUTPUT->addblockbutton();
if (isloggedin()) {
    $blockdraweropen = (get_user_preferences('drawer-open-block') == true);
} else {
    $blockdraweropen = false;
}

if (defined('BEHAT_SITE_RUNNING')) {
    $blockdraweropen = true;
}

$extraclasses = ['uses-drawers'];
// End.

// Display Admin button on the top bar.
if (theme_alpha_get_setting('topbaradminbtn') == '1') {
    $topbaradminbtn = true;
} else {
    $topbaradminbtn = false;
}
// End.

// Hidden sidebar.
if (theme_alpha_get_setting('turnoffsidebaradmin') == '1') {
    $hiddensidebar = true;
    $navdraweropen = false;
    // Display Admin button on the top bar when nav drawer is disabled.
    $topbaradminbtn = true;
    $extraclasses[] = 'hidden-sidebar';
} else {
    $hiddensidebar = false;
}
// End.

// Dark mode.
if (isloggedin()) {
    $navdraweropen = (get_user_preferences('drawer-open-nav', 'true') == 'true');
    $draweropenright = (get_user_preferences('sidepre-open', 'true') == 'true');

    if (theme_alpha_get_setting('darkmodetheme') == '1') {
        $darkmodeon = (get_user_preferences('darkmode-on', 'false') == 'true');
        if ($darkmodeon) {
            $extraclasses[] = 'theme-dark';
        }
        $darkmodetheme = true;
    } else {
        $darkmodeon = false;
    }
} else {
    $navdraweropen = false;
}

if (theme_alpha_get_setting('darkmodefirst') == '1') {
    $extraclasses[] = 'theme-dark';
    $darkmodetheme = false;
}

if ($navdraweropen && !$hiddensidebar) {
    $extraclasses[] = 'drawer-open-left';
}

$siteurl = $CFG->wwwroot;

$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks = strpos($blockshtml, 'data-block=') !== false;
$sidecourseblocks = $OUTPUT->blocks('sidecourseblocks');
$hassidecourseblocks = strpos($sidecourseblocks, 'data-block=') !== false;

$blockstopsidebar = $OUTPUT->blocks('sidebartb');
$blocksbottomsidebar = $OUTPUT->blocks('sidebarbb');



if ($PAGE->course->enablecompletion == '1') {
    $extraclasses[] = 'rui-course--enablecompletion';
}

if ($PAGE->course->showactivitydates == '1') {
    $extraclasses[] = 'rui-course--showactivitydates';
}

if ($PAGE->course->visible == '1') {
    $extraclasses[] = 'rui-course--visible';
}

$forceblockdraweropen = $OUTPUT->firstview_fakeblocks();

// Moodle 4.x.
$hasblocks = (strpos($blockshtml, 'data-block=') !== false || !empty($addblockbutton));
if (!$hasblocks) {
    $blockdraweropen = false;
}

$renderer = $PAGE->get_renderer('core');

$header = $PAGE->activityheader;
$headercontent = $header->export_for_template($renderer);

// Don't display new moodle 4.0 secondary menu if old settings region is available.
$secondarynavigation = false;
$overflow = '';

if ($PAGE->has_secondary_navigation()) {
    $tablistnav = $PAGE->has_tablist_secondary_navigation();
    $moremenu = new \core\navigation\output\more_menu($PAGE->secondarynav, 'nav-tabs', true, $tablistnav);
    $secondarynavigation = $moremenu->export_for_template($OUTPUT);
    $overflowdata = $PAGE->secondarynav->get_overflow_menu_data();
    if (!is_null($overflowdata)) {
        $overflow = $overflowdata->export_for_template($OUTPUT);
    }
}

$primary = new core\navigation\output\primary($PAGE);
$renderer = $PAGE->get_renderer('core');
$primarymenu = $primary->export_for_template($renderer);

// End.

// Default moodle setting menu.
$buildregionmainsettings = !$PAGE->include_region_main_settings_in_header_actions() && !$PAGE->has_secondary_navigation();
// If the settings menu will be included in the header then don't add it here.
$regionmainsettingsmenu = $buildregionmainsettings ? $OUTPUT->region_main_settings_menu() : false;
$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes,
    'darkmodeon' => !empty($darkmodeon),
    'darkmodetheme' => !empty($darkmodetheme),
    'siteurl' => $siteurl,
    'sidepreblocks' => $blockshtml,
    'hasblocks' => $hasblocks,
    'sidebartb' => $blockstopsidebar,
    'sidebarbb' => $blocksbottomsidebar,
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
    'hiddensidebar' => $hiddensidebar,
    'topbaradminbtn' => $topbaradminbtn,
    'navdraweropen' => $navdraweropen,
    'draweropenright' => $draweropenright,
    // Moodle 4.x.
    'blockdraweropen' => $blockdraweropen,
    'primarymoremenu' => $primarymenu['moremenu'],
    'secondarymoremenu' => $secondarynavigation ?: false,
    'headercontent' => $headercontent,
    'overflow' => $overflow,
    'addblockbutton' => $addblockbutton
];

// Get and use the course page information banners HTML code, if any course page hints are configured.
$coursepageinformationbannershtml = theme_alpha_get_course_information_banners();
if ($coursepageinformationbannershtml) {
    $templatecontext['coursepageinformationbanners'] = $coursepageinformationbannershtml;
}
// End.

// Load theme settings.
$themesettings = new \theme_alpha\util\theme_settings();

$templatecontext = array_merge($templatecontext, $themesettings->global_settings());
$templatecontext = array_merge($templatecontext, $themesettings->footer_settings());

$PAGE->requires->js_call_amd('theme_alpha/rui', 'init');
echo $OUTPUT->render_from_template('theme_alpha/tmpl-admin', $templatecontext);

?>

<div class="rightSide">
    <div class="options">
        <div id="subscribeModal" class="subscribe subscribe-modal-open">
            <p>Subscribe</p>

            <!-- Subscribe modal -->
            <div class="subscribe-modal">
                <div class="content">
                    <div class="row">
                        <h1 class="heading">Continue learning</h1>

                        <div class="cards">
                            <div class="card">
                                <div class="left">
                                    <div class="profileImage">
                                        <img src="./images/2.png" alt="" />
                                    </div>

                                    <div class="shortDetail">
                                        <div class="top">
                                            <h1>Wade Warren</h1>
                                            <div class="dot"></div>
                                            <p>English</p>
                                        </div>
                                        <p>Trial lesson completed</p>
                                    </div>
                                </div>
                                <a href="">Subscribe</a>
                            </div>
                            <div class="card">
                                <div class="left">
                                    <div class="profileImage">
                                        <img src="./images/3.png" alt="" />
                                    </div>

                                    <div class="shortDetail">
                                        <div class="top">
                                            <h1>Camila</h1>
                                            <div class="dot"></div>
                                            <p>English</p>
                                        </div>
                                        <p>Trial lesson completed</p>
                                    </div>
                                </div>
                                <a href="">Subscribe</a>
                            </div>
                            <div class="card">
                                <div class="left">
                                    <div class="profileImage">
                                        <img src="./images/9.png" alt="" />
                                    </div>

                                    <div class="shortDetail">
                                        <div class="top">
                                            <h1>Karen</h1>
                                            <div class="dot"></div>
                                            <p>English</p>
                                        </div>
                                        <p>Subscription cancelled</p>
                                    </div>
                                </div>
                                <a href="">Subscribe</a>
                            </div>
                            <div class="card">
                                <div class="left">
                                    <div class="profileImage">
                                        <img src="./images/10.png" alt="" />
                                    </div>

                                    <div class="shortDetail">
                                        <div class="top">
                                            <h1>Marbe B.</h1>
                                            <div class="dot"></div>
                                            <p>English</p>
                                        </div>
                                        <p>Trial lesson completed</p>
                                    </div>
                                </div>
                                <a href="">Book trial lesson</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h1 class="heading">Try a first lesson</h1>

                        <div class="cards">
                            <div class="card">
                                <div class="left">
                                    <div class="profileImage">
                                        <img src="./images/11.png" alt="" />
                                    </div>

                                    <div class="shortDetail">
                                        <div class="top">
                                            <h1>Anne S.</h1>
                                            <div class="dot"></div>
                                            <p>English</p>
                                        </div>
                                        <p>You've viewed their profile</p>
                                    </div>
                                </div>
                                <a href="">Book trial lesson</a>
                            </div>
                            <div class="card">
                                <div class="left">
                                    <div class="profileImage">
                                        <img src="./images/12.png" alt="" />
                                    </div>

                                    <div class="shortDetail">
                                        <div class="top">
                                            <h1>Anne S.</h1>
                                            <div class="dot"></div>
                                            <p>English</p>
                                        </div>
                                        <p>You've viewed their profile</p>
                                    </div>
                                </div>
                                <a href="">Book trial lesson</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="transfer-balance-or-subscription-modol-open transferLessonsBTN">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M3.99988 14H15.9999V12H3.99988L6.29288 9.70697L4.87888 8.29297L0.171875 13L4.87888 17.707L6.29288 16.293L3.99988 14ZM15.9999 5.99997H3.99988V3.99997H15.9999L13.7069 1.70697L15.1209 0.292969L19.8279 4.99997L15.1209 9.70697L13.7069 8.29297L15.9999 5.99997Z"
                                fill="#121117" />
                        </svg>
                        <span>Transfer balance or subscription</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="balance subscribe balance-modal-open">
            <p>Balance : 0</p>

            <div class="balance-modal">
                <div class="topPart">
                    <div class="active teacherBox">
                        <div class="imageContainer">
                            <img src="./images/1.png" alt="" />
                        </div>
                        <p>Dinela : 11</p>
                    </div>
                    <div class="teacherBox">
                        <div class="imageContainer">
                            <img src="./images/2.png" alt="" />
                        </div>
                        <p>Wade Warren : 1</p>
                    </div>
                    <div class="teacherBox">
                        <div class="imageContainer">
                            <img src="./images/13.png" alt="" />
                        </div>
                        <p>Albert : 1</p>
                    </div>
                    <div class="teacherBox">
                        <div class="imageContainer">
                            <img src="./images/19.png" alt="" />
                        </div>
                        <p>Daniela : 0</p>
                    </div>
                    <div class="teacherBox">
                        <div class="imageContainer">
                            <img src="./images/9.png" alt="" />
                        </div>
                        <p>Karen : 0</p>
                    </div>
                </div>
                <div class="bottomPart">
                    <div class="active box01">
                        <div class="lesson">
                            <h1>5 lessons</h1>
                            <p>to schedule</p>
                        </div>

                        <div class="progress">
                            <div class="colorBlock"></div>
                            <div class="colorBlock"></div>
                            <div class="colorBlock"></div>
                            <div class="colorBlock"></div>
                            <div class="colorBlock"></div>
                            <div class="colorBlock"></div>
                            <div class="colorBlock"></div>
                            <div class="outlineBlock"></div>
                            <div class="outlineBlock"></div>
                            <div class="outlineBlock"></div>
                            <div class="outlineBlock"></div>
                            <div class="outlineBlock"></div>
                        </div>

                        <div class="btns">
                            <a href="">Shedule Lesson</a>
                            <button class="transfer-balance-or-subscription-modol-open outline-button">
                                Transfer lessons or subscription
                            </button>
                        </div>

                        <div class="bottomDetail">
                            <div class="left">
                                <p>Your plan: <span>12 lessons / 4 weeks</span></p>
                                <p>Renews on: <span>December 10</span></p>
                            </div>

                            <a href="">Manage</a>
                        </div>
                    </div>

                    <div class="box01">
                        <div class="lesson">
                            <h1>12 lessons</h1>
                            <p>to schedule</p>
                        </div>

                        <div class="fullBlank progress">
                            <div class="colorBlock"></div>
                            <div class="colorBlock"></div>
                            <div class="colorBlock"></div>
                            <div class="colorBlock"></div>
                            <div class="colorBlock"></div>
                            <div class="colorBlock"></div>
                            <div class="colorBlock"></div>
                            <div class="outlineBlock"></div>
                            <div class="outlineBlock"></div>
                            <div class="outlineBlock"></div>
                            <div class="outlineBlock"></div>
                            <div class="outlineBlock"></div>
                        </div>

                        <div class="btns">
                            <a href="">Shedule Lesson</a>
                            <button class="transfer-balance-or-subscription-modol-open outline-button">
                                Transfer lessons or subscription
                            </button>
                        </div>

                        <div class="bottomDetail">
                            <div class="left">
                                <p>Your plan: <span>0 lessons / 2 weeks</span></p>
                                <p>Renews on: <span>January 20</span></p>
                            </div>

                            <a href="">Manage</a>
                        </div>
                    </div>

                    <div class="box01">
                        <div class="lesson">
                            <h1>1 trial lessons</h1>
                            <p>to schedule</p>
                        </div>

                        <div class="btns">
                            <a href="">Shedule Lesson</a>
                            <button class="outline-button">
                                Try Another Teacher
                            </button>
                        </div>
                    </div>

                    <div class="box01">
                        <div class="lesson">
                            <h1>0 lessons</h1>
                            <p>to schedule</p>
                        </div>

                        <div class="btns">
                            <button class="outline-button">Add Extra Lessons</button>
                        </div>
                    </div>

                    <div class="box01">
                        <div class="lesson">
                            <h1>0 lessons</h1>
                            <p>to schedule</p>
                        </div>

                        <div class="btns">
                            <div class="warning-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M9 16C9.91925 16 10.8295 15.8189 11.6788 15.4672C12.5281 15.1154 13.2997 14.5998 13.9497 13.9497C14.5998 13.2997 15.1154 12.5281 15.4672 11.6788C15.8189 10.8295 16 9.91925 16 9C16 8.08075 15.8189 7.17049 15.4672 6.32122C15.1154 5.47194 14.5998 4.70026 13.9497 4.05025C13.2997 3.40024 12.5281 2.88463 11.6788 2.53284C10.8295 2.18106 9.91925 2 9 2C7.14348 2 5.36301 2.7375 4.05025 4.05025C2.7375 5.36301 2 7.14348 2 9C2 10.8565 2.7375 12.637 4.05025 13.9497C5.36301 15.2625 7.14348 16 9 16ZM18 9C18 7.8181 17.7672 6.64778 17.3149 5.55585C16.8626 4.46392 16.1997 3.47177 15.364 2.63604C14.5282 1.80031 13.5361 1.13738 12.4442 0.685084C11.3522 0.232792 10.1819 0 9 0C7.8181 0 6.64778 0.232792 5.55585 0.685084C4.46392 1.13738 3.47177 1.80031 2.63604 2.63604C1.80031 3.47177 1.13737 4.46392 0.685083 5.55585C0.232792 6.64778 0 7.8181 0 9C0 11.3869 0.948212 13.6761 2.63604 15.364C4.32387 17.0518 6.61305 18 9 18C11.3869 18 13.6761 17.0518 15.364 15.364C17.0518 13.6761 18 11.3869 18 9ZM9.938 7V13H8.066V7H9.938ZM9.746 5.92C9.53 6.128 9.282 6.232 9.002 6.232C8.714 6.232 8.466 6.128 8.258 5.92C8.05 5.704 7.946 5.456 7.946 5.176C7.94348 5.03712 7.96992 4.89924 8.02364 4.77114C8.07736 4.64304 8.15718 4.52754 8.258 4.432C8.35428 4.33214 8.46992 4.25296 8.59784 4.19932C8.72577 4.14567 8.86329 4.11868 9.002 4.12C9.282 4.12 9.53 4.224 9.746 4.432C9.84683 4.52754 9.92664 4.64304 9.98036 4.77114C10.0341 4.89924 10.0605 5.03712 10.058 5.176C10.058 5.456 9.954 5.704 9.746 5.92Z"
                                        fill="#121117" />
                                </svg>
                                <p>Subscription Cancelled</p>
                            </div>
                            <button class="red-button resubscribe-lesson-modal-open">
                                Resubscribe
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="" class="referAFriend subscribe">
            <p>Refer a friend</p>
        </a>
    </div>

    <div class="language_dropdown language-and-currency-modal-open">
        <p>
            <span class="language_value">English</span>,
            <span class="currency_value">EUR</span>
        </p>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M17.976 9.22C17.8735 9.09176 17.7467 8.98496 17.603 8.9057C17.4592 8.82644 17.3012 8.77628 17.1381 8.75808C16.9749 8.73988 16.8098 8.75399 16.6521 8.79962C16.4944 8.84525 16.3472 8.9215 16.219 9.024L12 12.399L7.77998 9.024C7.65251 8.91544 7.50452 8.83359 7.34481 8.78331C7.1851 8.73304 7.01691 8.71536 6.85024 8.73133C6.68356 8.7473 6.5218 8.7966 6.37454 8.87629C6.22728 8.95599 6.09754 9.06445 5.99301 9.19525C5.88847 9.32605 5.81128 9.47652 5.76602 9.63772C5.72076 9.79893 5.70834 9.96758 5.72951 10.1337C5.75068 10.2998 5.80501 10.4599 5.88926 10.6046C5.97351 10.7493 6.08598 10.8756 6.21998 10.976L11.22 14.976C11.4415 15.1529 11.7165 15.2492 12 15.2492C12.2834 15.2492 12.5585 15.1529 12.78 14.976L17.78 10.976C17.9082 10.8735 18.015 10.7468 18.0943 10.603C18.1735 10.4592 18.2237 10.3013 18.2419 10.1381C18.2601 9.97494 18.246 9.8098 18.2004 9.6521C18.1547 9.4944 18.0785 9.34723 17.976 9.219V9.22Z"
                fill="#121117" />
        </svg>

        <div class="language-and-currency-modal">
            <div class="language">
                <p>Language</p>
                <div class="dropdown">
                    <p class="selectedLanguage">English</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M17.976 9.21999C17.8735 9.09174 17.7467 8.98494 17.603 8.90568C17.4592 8.82643 17.3012 8.77626 17.1381 8.75806C16.9749 8.73986 16.8098 8.75398 16.6521 8.79961C16.4944 8.84523 16.3472 8.92148 16.219 9.02399L12 12.399L7.77998 9.02399C7.65251 8.91542 7.50452 8.83357 7.34481 8.7833C7.1851 8.73302 7.01691 8.71534 6.85024 8.73132C6.68356 8.74729 6.5218 8.79658 6.37454 8.87628C6.22728 8.95597 6.09754 9.06444 5.99301 9.19524C5.88847 9.32604 5.81128 9.4765 5.76602 9.63771C5.72076 9.79891 5.70834 9.96757 5.72951 10.1337C5.75068 10.2998 5.80501 10.4599 5.88926 10.6046C5.97351 10.7493 6.08598 10.8756 6.21998 10.976L11.22 14.976C11.4415 15.1529 11.7165 15.2492 12 15.2492C12.2834 15.2492 12.5585 15.1529 12.78 14.976L17.78 10.976C17.9082 10.8735 18.015 10.7468 18.0943 10.603C18.1735 10.4592 18.2237 10.3012 18.2419 10.1381C18.2601 9.97493 18.246 9.80979 18.2004 9.65209C18.1547 9.49439 18.0785 9.34722 17.976 9.21899V9.21999Z"
                            fill="#121117" />
                    </svg>

                    <ul class="custom_dropdown">
                        <li class="active">English</li>
                        <li>Spanish</li>
                        <li>Hindi</li>
                        <li>Urdu</li>
                        <li>Dutch</li>
                    </ul>
                </div>
            </div>
            <div class="currency language">
                <p>Currency</p>
                <div class="dropdown">
                    <p class="selectedLanguage">EUR</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M17.976 9.21999C17.8735 9.09174 17.7467 8.98494 17.603 8.90568C17.4592 8.82643 17.3012 8.77626 17.1381 8.75806C16.9749 8.73986 16.8098 8.75398 16.6521 8.79961C16.4944 8.84523 16.3472 8.92148 16.219 9.02399L12 12.399L7.77998 9.02399C7.65251 8.91542 7.50452 8.83357 7.34481 8.7833C7.1851 8.73302 7.01691 8.71534 6.85024 8.73132C6.68356 8.74729 6.5218 8.79658 6.37454 8.87628C6.22728 8.95597 6.09754 9.06444 5.99301 9.19524C5.88847 9.32604 5.81128 9.4765 5.76602 9.63771C5.72076 9.79891 5.70834 9.96757 5.72951 10.1337C5.75068 10.2998 5.80501 10.4599 5.88926 10.6046C5.97351 10.7493 6.08598 10.8756 6.21998 10.976L11.22 14.976C11.4415 15.1529 11.7165 15.2492 12 15.2492C12.2834 15.2492 12.5585 15.1529 12.78 14.976L17.78 10.976C17.9082 10.8735 18.015 10.7468 18.0943 10.603C18.1735 10.4592 18.2237 10.3012 18.2419 10.1381C18.2601 9.97493 18.246 9.80979 18.2004 9.65209C18.1547 9.49439 18.0785 9.34722 17.976 9.21899V9.21999Z"
                            fill="#121117" />
                    </svg>

                    <ul class="custom_dropdown">
                        <li class="active">EUR</li>
                        <li>USD</li>
                        <li>INR</li>
                        <li>TAKA</li>
                        <li>PKR</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="message_love_notification">
        <div class="message message-modal-open">
            <div class="totalCount">4</div>

            <img src="./images/icons/message.png" alt="" />

            <div class="messages-modal">
                <div class="message_topArea">
                    <div class="top">
                        <h1>Messages</h1>

                        <div class="rightSide">
                            <div class="largeScreen">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M14.2166 2.33326H10.0258V0.281982H17.7181V7.97429H15.6668V3.78352L11.2638 8.1866L9.81351 6.73634L14.2166 2.33326ZM3.78377 15.6666H7.97453V17.7179H0.282227V10.0256H2.33351V14.2163L6.73659 9.81326L8.18684 11.2635L3.78377 15.6666Z"
                                        fill="#121117" />
                                </svg>
                            </div>

                            <div class="closeIcon backdrop-level-1-close">
                                <svg width="13" height="13" viewBox="0 0 13 13" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                                        fill="#121117"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <ul class="labels">
                        <li class="active">All</li>
                        <li>Unread</li>
                        <li>Archived</li>
                    </ul>
                </div>

                <div class="message-bottom-area">
                    <div class="all">
                        <div class="card">
                            <div class="left_side">
                                <div class="imageContainer">
                                    <img src="./images/1.png" alt="" />
                                </div>

                                <div class="shortDetail">
                                    <h1>Dinela</h1>
                                    <p>
                                        But I must explain to you how all this mistaken idea
                                        of denouncing of a pleasure and praising pain was
                                        born and I will give you a complete account of the
                                        system, and expound the actual teachings of the
                                        great explorer of the truth, the master-builder of
                                        human happiness.
                                    </p>
                                </div>
                            </div>

                            <div class="right_side">
                                <p>Sat</p>

                                <div class="archive-tutor-open">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="4" viewBox="0 0 18 4"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0 0H4V4H0V0ZM7 0H11V4H7V0ZM18 0H14V4H18V0Z" fill="#121117" />
                                    </svg>

                                    <div class="archive-tutor">
                                        <img src="./images/icons/Bookmark.png" />

                                        <p>Archive Tutor</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="left_side">
                                <div class="imageContainer">
                                    <img src="./images/2.png" alt="" />
                                </div>

                                <div class="shortDetail">
                                    <h1>Wade Warren</h1>
                                    <p>
                                        But I must explain to you how all this mistaken idea
                                        of denouncing of a pleasure and praising pain was
                                        born and I will give you a complete account of the
                                        system, and expound the actual teachings of the
                                        great explorer of the truth, the master-builder of
                                        human happiness.
                                    </p>
                                </div>
                            </div>

                            <div class="right_side">
                                <p>Fri</p>

                                <div class="archive-tutor-open">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="4" viewBox="0 0 18 4"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0 0H4V4H0V0ZM7 0H11V4H7V0ZM18 0H14V4H18V0Z" fill="#121117" />
                                    </svg>

                                    <div class="archive-tutor">
                                        <img src="./images/icons/Bookmark.png" />

                                        <p>Archive Tutor</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="left_side">
                                <div class="imageContainer">
                                    <img src="./images/3.png" alt="" />
                                </div>

                                <div class="shortDetail">
                                    <h1>Camila</h1>
                                    <p>
                                        But I must explain to you how all this mistaken idea
                                        of denouncing of a pleasure and praising pain was
                                        born and I will give you a complete account of the
                                        system, and expound the actual teachings of the
                                        great explorer of the truth, the master-builder of
                                        human happiness.
                                    </p>
                                </div>
                            </div>

                            <div class="right_side">
                                <p>Mon</p>

                                <div class="archive-tutor-open">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="4" viewBox="0 0 18 4"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0 0H4V4H0V0ZM7 0H11V4H7V0ZM18 0H14V4H18V0Z" fill="#121117" />
                                    </svg>

                                    <div class="archive-tutor">
                                        <img src="./images/icons/Bookmark.png" />

                                        <p>Archive Tutor</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="left_side">
                                <div class="imageContainer">
                                    <img src="./images/4.png" alt="" />
                                </div>

                                <div class="shortDetail">
                                    <h1>Karen</h1>
                                    <p>
                                        But I must explain to you how all this mistaken idea
                                        of denouncing of a pleasure and praising pain was
                                        born and I will give you a complete account of the
                                        system, and expound the actual teachings of the
                                        great explorer of the truth, the master-builder of
                                        human happiness.
                                    </p>
                                </div>
                            </div>

                            <div class="right_side">
                                <p>4/4/18</p>

                                <div class="archive-tutor-open">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="4" viewBox="0 0 18 4"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0 0H4V4H0V0ZM7 0H11V4H7V0ZM18 0H14V4H18V0Z" fill="#121117" />
                                    </svg>

                                    <div class="archive-tutor">
                                        <img src="./images/icons/Bookmark.png" />

                                        <p>Archive Tutor</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="left_side">
                                <div class="imageContainer">
                                    <img src="./images/5.png" alt="" />
                                </div>

                                <div class="shortDetail">
                                    <h1>Marbe B.</h1>
                                    <p>
                                        But I must explain to you how all this mistaken idea
                                        of denouncing of a pleasure and praising pain was
                                        born and I will give you a complete account of the
                                        system, and expound the actual teachings of the
                                        great explorer of the truth, the master-builder of
                                        human happiness.
                                    </p>
                                </div>
                            </div>

                            <div class="right_side">
                                <p>1/28/17</p>

                                <div class="archive-tutor-open">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="4" viewBox="0 0 18 4"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0 0H4V4H0V0ZM7 0H11V4H7V0ZM18 0H14V4H18V0Z" fill="#121117" />
                                    </svg>

                                    <div class="archive-tutor">
                                        <img src="./images/icons/Bookmark.png" />

                                        <p>Archive Tutor</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="left_side">
                                <div class="imageContainer">
                                    <img src="./images/1.png" alt="" />
                                </div>

                                <div class="shortDetail">
                                    <h1>Dinela</h1>
                                    <p>
                                        But I must explain to you how all this mistaken idea
                                        of denouncing of a pleasure and praising pain was
                                        born and I will give you a complete account of the
                                        system, and expound the actual teachings of the
                                        great explorer of the truth, the master-builder of
                                        human happiness.
                                    </p>
                                </div>
                            </div>

                            <div class="right_side">
                                <p>Sat</p>

                                <div class="archive-tutor-open">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="4" viewBox="0 0 18 4"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0 0H4V4H0V0ZM7 0H11V4H7V0ZM18 0H14V4H18V0Z" fill="#121117" />
                                    </svg>

                                    <div class="archive-tutor">
                                        <img src="./images/icons/Bookmark.png" />

                                        <p>Archive Tutor</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="left_side">
                                <div class="imageContainer">
                                    <img src="./images/2.png" alt="" />
                                </div>

                                <div class="shortDetail">
                                    <h1>Wade Warren</h1>
                                    <p>
                                        But I must explain to you how all this mistaken idea
                                        of denouncing of a pleasure and praising pain was
                                        born and I will give you a complete account of the
                                        system, and expound the actual teachings of the
                                        great explorer of the truth, the master-builder of
                                        human happiness.
                                    </p>
                                </div>
                            </div>

                            <div class="right_side">
                                <p>Fri</p>

                                <div class="archive-tutor-open">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="4" viewBox="0 0 18 4"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0 0H4V4H0V0ZM7 0H11V4H7V0ZM18 0H14V4H18V0Z" fill="#121117" />
                                    </svg>

                                    <div class="archive-tutor">
                                        <img src="./images/icons/Bookmark.png" />

                                        <p>Archive Tutor</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Message BOX -->
            <div class="message-box">
                <div class="row_01">
                    <div class="left">
                        <div class="goBack">
                            <img src="./images/icons/Goback.png" alt="" />
                        </div>
                        <div class="profileImageAndName">
                            <img src="./images/1.png" alt="" />
                            <h1>Dinela</h1>
                        </div>
                    </div>

                    <div class="folderAndCloseIcon">
                        <div class="folder">
                            <img src="./images/icons/folder.png" alt="" />
                        </div>

                        <div class="closeIcon backdrop-level-1-close">
                            <img src="./images/icons/closeIcon.png" alt="" />
                        </div>
                    </div>
                </div>
                <a href="" class="active scheduleLessons">
                    <img src="./images/icons/calander.png" alt="" />
                    <span>Schedule Lessons</span>
                </a>
                <a href="" class="bookTrialLesson scheduleLessons">
                    <img src="./images/icons/energy.png" alt="" />
                    <span>Book Trial Lesson</span>
                </a>
                <div class="row_02">
                    <div class="tag">
                        <p>Yesterday</p>
                    </div>
                    <div class="sender">
                        <img src="./images/1.png" alt="" />
                        <div class="content">
                            <div class="top">
                                <h2>Dinela</h2>
                                <p class="time">09:34</p>
                            </div>

                            <p class="message_text">
                                Good morning, I want to confirm our meeting today and
                                ask if the meeting will take place within the preply
                                virtual classroom or will you provide the information?
                            </p>
                        </div>
                    </div>
                    <div class="receiver sender">
                        <img src="./images/17.png" alt="" />
                        <div class="content">
                            <div class="top">
                                <h2>Latingles</h2>
                                <p class="time">11:06</p>
                            </div>

                            <p class="message_text">
                                I'm already in, is anyone joining
                            </p>
                        </div>
                    </div>
                    <div class="receiver sender">
                        <img src="./images/17.png" alt="" />
                        <div class="content">
                            <div class="top">
                                <h2>Latingles</h2>
                                <p class="time">11:06</p>
                            </div>

                            <p class="message_text">
                                Yes Please wait for me! Thank you
                            </p>
                        </div>
                    </div>
                    <div class="tag">
                        <p>Today</p>
                    </div>
                    <div class="sender">
                        <img src="./images/1.png" alt="" />
                        <div class="content">
                            <div class="top">
                                <h2>Dinela</h2>
                                <p class="time">09:34</p>
                            </div>

                            <p class="message_text">
                                Good morning, I want to confirm our meeting today and
                                ask if the meeting will take place within the preply
                                virtual classroom or will you provide the information?
                            </p>
                        </div>
                    </div>
                    <div class="receiver sender">
                        <img src="./images/17.png" alt="" />
                        <div class="content">
                            <div class="top">
                                <h2>Latingles</h2>
                                <p class="time">11:06</p>
                            </div>

                            <p class="message_text">
                                I'm already in, is anyone joining
                            </p>
                        </div>
                    </div>
                    <div class="receiver sender">
                        <img src="./images/17.png" alt="" />
                        <div class="content">
                            <div class="top">
                                <h2>Latingles</h2>
                                <p class="time">11:06</p>
                            </div>

                            <p class="message_text">
                                Yes Please wait for me! Thank you
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row_03">
                    <p class="messageTypingArea" contenteditable="true">
                        Your message
                    </p>

                    <div class="message_options">
                        <div class="left">
                            <img src="./images/icons/attachment.png" alt="" />
                            <img src="./images/icons/emoji.png" alt="" />
                        </div>

                        <img src="./images/icons/audio.png" alt="" />
                    </div>
                </div>
            </div>
        </div>
        <div class="love message">
            <div class="totalCount">2</div>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18" fill="none">
                <path
                    d="M10 17.6487C9.89883 17.6487 9.7977 17.6225 9.70707 17.5702C9.60864 17.5134 7.26993 16.1555 4.89767 14.1095C3.49166 12.8969 2.36931 11.6942 1.56189 10.5348C0.517053 9.03456 -0.0083756 7.59151 0.000100941 6.2457C0.0100228 4.67968 0.57092 3.20695 1.57959 2.09875C2.60529 0.971879 3.97412 0.351334 5.434 0.351334C7.30497 0.351334 9.01555 1.39938 10 3.05961C10.9845 1.39942 12.6951 0.351334 14.5661 0.351334C15.9453 0.351334 17.2612 0.911254 18.2715 1.92797C19.3803 3.04371 20.0102 4.62019 19.9999 6.25312C19.9914 7.59659 19.4561 9.03745 18.409 10.5356C17.599 11.6944 16.4783 12.8966 15.0778 14.1088C12.7142 16.1547 10.3923 17.5125 10.2946 17.5693C10.2051 17.6213 10.1035 17.6487 10 17.6487Z"
                    fill="black" />
            </svg>
        </div>
        <div class="message notification notification-modal-open">
            <div class="totalCount">2</div>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="22" viewBox="0 0 20 22" fill="none">
                <path
                    d="M10.0008 21.6875C11.2821 21.6875 12.3855 20.9135 12.8697 19.8088H7.13192C7.61608 20.9135 8.71952 21.6875 10.0008 21.6875ZM16.4718 10.6603V9.28833C16.4718 6.3734 14.5342 3.90279 11.8795 3.09584V2.19116C11.8795 1.15527 11.0367 0.3125 10.0008 0.3125C8.96491 0.3125 8.12215 1.15527 8.12215 2.19116V3.09584C5.46739 3.90279 3.52986 6.37336 3.52986 9.28833V10.6603C3.52986 13.2207 2.55387 15.6486 0.781712 17.4967C0.696741 17.5853 0.639678 17.6969 0.617618 17.8177C0.595558 17.9384 0.609473 18.063 0.657634 18.1759C0.705795 18.2888 0.786077 18.3851 0.8885 18.4527C0.990924 18.5204 1.11097 18.5564 1.23372 18.5564H18.7679C18.8906 18.5564 19.0107 18.5203 19.1131 18.4527C19.2155 18.385 19.2958 18.2888 19.3439 18.1759C19.3921 18.063 19.406 17.9384 19.3839 17.8177C19.3619 17.6969 19.3049 17.5853 19.2199 17.4967C17.4477 15.6486 16.4718 13.2207 16.4718 10.6603ZM10.627 2.84778C10.4209 2.8279 10.2121 2.81738 10.0008 2.81738C9.78956 2.81738 9.5807 2.8279 9.37459 2.84778V2.19116C9.37459 1.84586 9.65551 1.56494 10.0008 1.56494C10.3461 1.56494 10.627 1.84586 10.627 2.19116V2.84778ZM18.1417 9.28833C18.1417 9.63417 18.4221 9.91455 18.7679 9.91455C19.1137 9.91455 19.3941 9.63417 19.3941 9.28833C19.3941 6.77927 18.417 4.42038 16.6429 2.64622C16.3984 2.4017 16.0018 2.40166 15.7573 2.64622C15.5127 2.89078 15.5127 3.28726 15.7573 3.53182C17.2949 5.06944 18.1417 7.1138 18.1417 9.28833ZM1.23372 9.91455C1.57956 9.91455 1.85994 9.63417 1.85994 9.28833C1.85994 7.11384 2.70676 5.06948 4.24434 3.53186C4.4889 3.2873 4.4889 2.89082 4.24434 2.64626C3.99982 2.4017 3.6033 2.4017 3.35874 2.64626C1.58457 4.42042 0.607497 6.77927 0.607497 9.28833C0.607497 9.63417 0.887877 9.91455 1.23372 9.91455Z"
                    fill="black" />
            </svg>

            <div class="notification-modal">
                <div class="topPart">
                    <h1>Notifications</h1>

                    <div class="closeIcon backdrop-level-1-close">
                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                                fill="#121117" />
                        </svg>
                    </div>
                </div>

                <div class="bottom">
                    <div class="card">
                        <img src="./images/icons/gift.png" alt="" />

                        <div class="content">
                            <p>
                                <span>Refer a friend and learn for less!</span> Like
                                your lessons? Share the joy of learning languages
                            </p>
                            <p class="date">Feb 16</p>

                            <a href="">Invite friends</a>
                        </div>
                    </div>

                    <div class="card">
                        <img src="./images/icons/batch.png" alt="" />

                        <div class="content">
                            <p>
                                <span>Congrats! You have earned a new arabic
                                    certificate.</span>
                                Download your 20 hours certificate now and celebrateyour
                                progress
                            </p>
                            <p>Feb 06</p>

                            <a href="">Get certificate</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="profileImage profile-setting-modal-open">
        <img src="./images/profile-01.jpg" alt="" />

        <ul class="profile-setting-modal">
            <li><a href="">Home</a></li>
            <li><a href="">Messages</a></li>
            <li><a href="">My lessons</a></li>
            <li><a href="">Learn</a></li>
            <li><a href="">Saved Tutors</a></li>
            <li><a href="">Refer a friend</a></li>
            <li><a href="">Settings</a></li>
            <li><a href="">Log Out</a></li>
        </ul>
    </div>
</div>


<style>
.subscribe-modal {
    position: absolute;
    top: 108%;
    right: 0;
    width: 583px;
    height: 417px;
    border-radius: 8px;
    border: 1px solid rgba(244, 244, 248, 1);
    background: rgba(255, 255, 255, 1);
    box-shadow: 0px 8px 32px 0px rgba(18, 17, 23, 0.15),
        0px 16px 48px 0px rgba(18, 17, 23, 0.15);
    padding: 32px 37px 16px 38px;
    display: flex;
    gap: 16px;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 4;
    cursor: auto;
    visibility: hidden;
    opacity: 0;
    pointer-events: none;
}

.subscribe-modal.active {
    visibility: visible;
    opacity: 1;
    pointer-events: unset;
}

.subscribe-modal .content {
    width: 100%;
    height: 305px;
    overflow: auto;
    display: flex;
    gap: 24px;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    border-bottom: 1px solid rgba(220, 220, 229, 1);
}

.subscribe-modal .content .row {
    width: 100%;
    display: flex;
    gap: 17px;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
}

.subscribe-modal .content .row h1.heading {
    font-weight: 500;
    font-size: 18px;
    line-height: 24px;
    color: rgba(77, 76, 92, 1);
}

.subscribe-modal .content .row .cards {
    width: 100%;
    display: flex;
    gap: 16px;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
}

.subscribe-modal .content .row .cards .card {
    width: 100%;
    display: flex;
    gap: 10px;
    justify-content: space-between;
    align-items: center;
}

.subscribe-modal .content .row .cards .card .left {
    display: flex;
    gap: 16px;
    justify-content: flex-start;
    align-items: center;
}

.subscribe-modal .content .row .cards .card .left .profileImage {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    border: unset;
}

.subscribe-modal .content .row .cards .card .left .profileImage img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.subscribe-modal .content .row .cards .card .left .shortDetail {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
}

.subscribe-modal .content .row .cards .card .left .shortDetail .top {
    display: flex;
    gap: 8px;
    justify-content: center;
    align-items: center;
}

.subscribe-modal .content .row .cards .card .left .shortDetail .top h1 {
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;
    color: rgba(18, 17, 23, 1);
}

.subscribe-modal .content .row .cards .card .left .shortDetail .top .dot {
    width: 3px;
    height: 3px;
    border-radius: 50%;
    background-color: rgba(18, 17, 23, 1);
}

.subscribe-modal .content .row .cards .card .left .shortDetail .top p {
    font-weight: 300;
    font-size: 16px;
    line-height: 24px;
    color: rgba(18, 17, 23, 1);
}

.subscribe-modal .content .row .cards .card .left .shortDetail p {
    font-family: "Figtree", sans-serif;
    font-weight: 400;
    font-size: 14px;
    line-height: 20px;
    color: rgba(106, 105, 124, 1);
}

.subscribe-modal .content .row .cards .card a {
    border-radius: 8px;
    padding: 9px 22.51px;
    border: 2px solid rgba(18, 17, 23, 1);
    font-weight: 500;
    font-size: 14px;
    line-height: 25.71px;
    letter-spacing: 0.09px;
    color: rgba(18, 17, 23, 1);
}

.subscribe-modal .content .row .cards .card a:hover {
    background: rgba(0, 0, 0, 0.03);
}

.subscribe-modal .transferLessonsBTN button {
    padding: 11px 20px;
    outline: unset;
    border: unset;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
    background: transparent;
    cursor: pointer;
    border-radius: 10px;
}

.subscribe-modal .transferLessonsBTN button:hover {
    background: rgba(0, 0, 0, 0.03);
}

.subscribe-modal .transferLessonsBTN button span {
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 18px;
    line-height: 25.71px;
    text-decoration: underline;
    color: rgba(18, 17, 23, 1);
}

.balance-modal {
    position: absolute;
    top: 114%;
    right: 0;
    width: 390px;
    min-height: 324px;
    border-radius: 8px;
    border: 1px solid rgba(244, 244, 248, 1);
    box-shadow: 0px 8px 32px 0px rgba(18, 17, 23, 0.15),
        0px 16px 48px 0px rgba(18, 17, 23, 0.15);
    background: rgba(255, 255, 255, 1);
    padding: 24px 0 0;
    z-index: 4;
    cursor: auto;
    visibility: hidden;
    opacity: 0;
    pointer-events: none;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: stretch;
}

.balance-modal.active {
    visibility: visible;
    opacity: 1;
    pointer-events: unset;
}

.balance-modal .topPart {
    width: 100%;
    overflow: auto;
    padding: 0 20px;
    display: flex;
    gap: 8px;
    justify-content: flex-start;
    align-items: center;
}

.balance-modal .topPart::-webkit-scrollbar {
    height: 0;
}

.balance-modal .topPart .teacherBox {
    border-radius: 8.93px;
    background: rgba(255, 255, 255, 1);
    border: 2px solid rgba(0, 0, 0, 0.12);
    padding: 6px;
    display: flex;
    gap: 6px;
    justify-content: center;
    align-items: center;
    flex-shrink: 0;
    cursor: pointer;
}

.balance-modal .topPart .teacherBox:hover {
    background: rgba(0, 0, 0, 0.03);
}

.balance-modal .topPart .teacherBox.active {
    border: 2px solid rgba(0, 0, 0, 1);
}

.balance-modal .topPart .teacherBox .imageContainer {
    width: 32px;
    height: 32px;
    border-radius: 85px;
    border: 1px solid rgba(18, 17, 23, 0.06);
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.balance-modal .topPart .teacherBox .imageContainer img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.balance-modal .topPart .teacherBox p {
    font-weight: 600 !important;
    font-size: 12px !important;
    line-height: 24px !important;
    color: rgba(18, 17, 23, 0.5) !important;
}

.balance-modal .topPart .teacherBox.active p {
    color: rgba(18, 17, 23, 1) !important;
}

.balance-modal .bottomPart {
    padding: 20px 21px 24px 24px;
    position: relative;
    width: 100%;
    display: flex;
    gap: 10px;
    flex-direction: column;
    justify-content: stretch;
    align-items: flex-start;
    flex: 1;
}

.balance-modal .bottomPart .box01 {
    width: 100%;
    display: flex;
    gap: 20px;
    flex-direction: column;
    justify-content: space-between;
    align-items: flex-start;
    display: none;
    flex: 1;
}

.balance-modal .bottomPart .box01.active {
    display: flex;
}

.balance-modal .bottomPart .box01 .lesson {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
}

.balance-modal .bottomPart .box01 .lesson h1 {
    font-weight: 600;
    font-size: 28.25px;
    line-height: 42.38px;
    color: rgba(18, 17, 23, 1);
    text-transform: capitalize;
}

.balance-modal .bottomPart .box01 .lesson p {
    font-weight: 500;
    font-size: 16px;
    line-height: 24px;
    color: rgba(77, 76, 92, 1);
}

.balance-modal .bottomPart .box01 .progress {
    width: 100%;
    display: flex;
    gap: 2.55px;
    justify-content: center;
    align-items: center;
}

.balance-modal .bottomPart .box01 .progress.fullBlank {
    gap: 0;
    border: 1px solid rgba(6, 117, 96, 1);
}

.balance-modal .bottomPart .box01 .progress.fullBlank .colorBlock {
    background: transparent;
}

.balance-modal .bottomPart .box01 .progress.fullBlank .outlineBlock {
    border: unset;
}

.balance-modal .bottomPart .box01 .progress .colorBlock {
    width: 27px;
    height: 8px;
    background: rgba(6, 117, 96, 1);
}

.balance-modal .bottomPart .box01 .progress .outlineBlock {
    width: 27px;
    height: 8px;
    border: 1px solid rgba(6, 117, 96, 1);
}

.balance-modal .bottomPart .box01 .btns {
    width: 100%;
    display: flex;
    gap: 12.71px;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-top: 12px;
}

.balance-modal .bottomPart .box01 .btns a,
.outline-button {
    width: 100%;
    padding: 9.14px;
    border-radius: 8px;
    border: 2px solid rgba(18, 17, 23, 1);
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 14px;
    line-height: 25.71px;
    letter-spacing: 0.09px;
    color: rgba(18, 17, 23, 1);
    outline: unset;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    background: transparent;
}

.balance-modal .bottomPart .box01 .btns a:hover,
.outline-button:hover {
    background: rgba(0, 0, 0, 0.03);
}

.balance-modal .bottomPart .box01 .btns .red-button {
    font-size: 14px;
}

.balance-modal .bottomPart .bottomDetail {
    width: 100%;
    display: flex;
    gap: 10px;
    justify-content: space-between;
    align-items: center;
    margin-top: 12.71px;
    border-top: 1px dashed rgba(77, 76, 92, 1);
    padding: 16px 0 1px;
}

.balance-modal .bottomPart .bottomDetail .left {
    display: flex;
    gap: 4px;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
}

.balance-modal .bottomPart .bottomDetail .left p {
    font-weight: 600;
    font-size: 14px;
    line-height: 24px;
    color: rgba(18, 17, 23, 1);
}

.balance-modal .bottomPart .bottomDetail .left p span {
    font-weight: 300;
}

.balance-modal .bottomPart .bottomDetail a {
    font-weight: 500;
    font-size: 16px;
    line-height: 24px;
    text-decoration: underline;
    color: rgba(18, 17, 23, 1);
}

.balance-modal .bottomPart .bottomDetail a:hover {
    color: rgba(255, 37, 0, 1);
}

nav .rightSide .options .subscribe:hover {
    background-color: rgb(0 0 0 / 5%);
}

nav .rightSide .options .subscribe p {
    font-weight: 500;
    font-size: 14px;
    line-height: 21px;
    color: rgba(0, 0, 0, 1);
}
</style>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery Script -->
<script>
$(document).ready(function() {
    debugger
    $('#openModal').click(function() {
        debugger
        $('#subscribeModal').fadeToggle();
    });

    $(document).mouseup(function(e) {
        const modal = $("#subscribeModal");
        if (!modal.is(e.target) && modal.has(e.target).length === 0) {
            modal.fadeOut();
        }
    });
});
</script>