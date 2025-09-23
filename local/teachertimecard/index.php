<?php
/**
 * Local plugin "Teacher Timecard" - Main view file
 * 
 * @package    local_teachertimecard
 * @copyright  2024 Your Name <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__.'/../../config.php');
require_once(__DIR__.'/lib.php');

// Require login and capabilities
require_login();
$context = context_system::instance();

// Set up page
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/teachertimecard/index.php'));
$PAGE->set_title(get_string('pluginname', 'local_teachertimecard'));
$PAGE->set_heading(get_string('pluginname', 'local_teachertimecard'));  

// Add CSS and JS
$PAGE->requires->css(new moodle_url('/local/teachertimecard/css/styles.css?v=' . time()), true);
$PAGE->requires->js(new moodle_url('/local/teachertimecard/js/index.js?v=' . time()), true);
$PAGE->requires->js(new moodle_url('/local/teachertimecard/js/payment.js?v=' . time()), true);

// Get current user info
$userid = $USER->id;
$username = $USER->username;

// Output the page
echo $OUTPUT->header();

// Get all active teachers ordered by ID
$teachers = $DB->get_records_sql(
    "SELECT id, firstname, lastname, email, phone1
     FROM {user} 
     WHERE deleted = 0 AND suspended = 0
     ORDER BY id ASC"
);

// Get current teacher ID from URL or default to first teacher
$teacherid = optional_param('teacherid', null, PARAM_INT);
$startdate_param = optional_param('startdate', null, PARAM_TEXT);
$enddate_param = optional_param('enddate', null, PARAM_TEXT);
$period_param = optional_param('period', null, PARAM_TEXT);

// Convert date strings to timestamps if provided
$start_timestamp = $startdate_param ? strtotime($startdate_param) : strtotime(date("Y-m-01"));
$end_timestamp = $enddate_param ? strtotime($enddate_param) : time();

// Format for display
$display_start = date('j M Y', $start_timestamp);
$display_end = date('j M Y', $end_timestamp);
$display_range = $period_param ? $period_param : "$display_start - $display_end";

// Get sessions with the selected date range
$sessions = get_cohort_meet_activities($teacherid, $start_timestamp, $end_timestamp);

if (!$teacherid && !empty($teachers)) {
    $first_teacher = reset($teachers);
    $teacherid = $first_teacher->id;
}

// Get current teacher and position
$current_teacher = null;
$current_index = null;
$teacher_ids = array_keys($teachers);

if ($teacherid && in_array($teacherid, $teacher_ids)) {
    $current_index = array_search($teacherid, $teacher_ids);
    $current_teacher = $teachers[$teacherid];
} elseif (!empty($teachers)) {
    $current_teacher = reset($teachers);
    $current_index = 0;
    $teacherid = $current_teacher->id;
}

// Determine previous/next teacher IDs
$prev_teacher_id = ($current_index > 0) ? $teacher_ids[$current_index - 1] : null;
$next_teacher_id = ($current_index < count($teacher_ids) - 1) ? $teacher_ids[$current_index + 1] : null;

// Set up navigation URLs
$baseurl = new moodle_url('/local/teachertimecard/index.php');
$prev_url = $prev_teacher_id ? new moodle_url($baseurl, ['teacherid' => $prev_teacher_id]) : null;
$next_url = $next_teacher_id ? new moodle_url($baseurl, ['teacherid' => $next_teacher_id]) : null;

if ($current_teacher) {
    $teacher_picture = new user_picture($current_teacher);
    $teacher_picture->size = 1; // f1
    $teacher_picture_url = $teacher_picture->get_url($PAGE)->out(false);
} else {
    echo $OUTPUT->notification(get_string('noteachersfound', 'local_teachertimecard'), 'notifyproblem');
}

// Get general notes for the current teacher and date range
$general_notes = get_general_notes($teacherid, $start_timestamp, $end_timestamp);
?>

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />

<div class="app local-teachertimecard">
    <main class="main">
        <!-- Sidebar -->
        <div class="sidebar poppins">
            <div class="teacher-profile">
                <img alt="Teacher" class="teacher-img" src="<?php echo $teacher_picture_url; ?>">
                
                <div class="teacher-info">
                    <?php if ($prev_url): ?>
                        <div class="container-arrow">
                            <a href="<?php echo $prev_url; ?>" class="container-arrow nav-arrow" aria-label="<?php echo get_string('previousteacher', 'local_teachertimecard'); ?>">
                                <img src="<?php echo $CFG->wwwroot; ?>/local/teachertimecard/assets/arrow-left.svg" 
                                    alt="<?php echo get_string('previousteacher', 'local_teachertimecard'); ?>"
                                    class="nav-arrow-icon"
                                    onerror="this.onerror=null; this.src='<?php echo $OUTPUT->image_url('t/left', 'core'); ?>'">
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="container-arrow">
                            <img src="<?php echo $CFG->wwwroot; ?>/local/teachertimecard/assets/arrow-left.svg" 
                                alt="<?php echo get_string('previousteacher', 'local_teachertimecard'); ?>"
                                class="nav-arrow-icon"
                                onerror="this.onerror=null; this.src='<?php echo $OUTPUT->image_url('t/left', 'core'); ?>'">
                        </div>
                    <?php endif; ?>
                    
                    <p class="teachername"><?php echo fullname($current_teacher); ?></p>
                    
                    <?php if ($next_url): ?>
                        <div class="container-arrow">
                            <a href="<?php echo $next_url; ?>" class="container-arrow nav-arrow" aria-label="<?php echo get_string('nextteacher', 'local_teachertimecard'); ?>">
                                <img src="<?php echo $CFG->wwwroot; ?>/local/teachertimecard/assets/arrow-right.svg" 
                                    alt="<?php echo get_string('nextteacher', 'local_teachertimecard'); ?>"
                                    class="nav-arrow-icon"
                                    onerror="this.onerror=null; this.src='<?php echo $OUTPUT->image_url('t/right', 'core'); ?>'">
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="container-arrow">
                            <img src="<?php echo $CFG->wwwroot; ?>/local/teachertimecard/assets/arrow-right.svg" 
                                alt="<?php echo get_string('nextteacher', 'local_teachertimecard'); ?>"
                                class="nav-arrow-icon"
                                onerror="this.onerror=null; this.src='<?php echo $OUTPUT->image_url('t/right', 'core'); ?>'">
                        </div>
                    <?php endif; ?>
                </div>
                <p class="teacher-job"><?php echo get_string('englishteacher', 'local_teachertimecard'); ?></p>
            </div>
            <div class="wallet">
                <span class="price"><i class="fa fa-wallet"></i> <?php echo $sessions['totals']['pending_amount'];?>  USD</span>
                <button class="btn-pay" 
                        data-teacherid="<?php echo $teacherid; ?>"
                        data-startdate="<?php echo date('Y-m-d', $start_timestamp); ?>"
                        data-enddate="<?php echo date('Y-m-d', $end_timestamp); ?>"
                        data-teachername="<?php echo fullname($current_teacher); ?>">
                    Pay
                </button>
            </div>
            <div class="period-line">
                <hr>
                <span>During: <strong id="selected-text"><?php echo $display_range;?></strong></span>
            </div>
            
            <div class="hours-stats">
                <div class="stats">
                    <div class="stat" id="total-hours"><strong><?php echo $sessions['totals']['total_taught']+$sessions['totals']['total_covered'];?>:00</strong><?php echo get_string('totalhours', 'local_teachertimecard'); ?></div>
                    <div class="stat"><strong><?php echo $sessions['totals']['paid_amount'];?> USD</strong>Paid amount</div>
                    <div class="stat" id="taught-hours"><strong><?php echo $sessions['totals']['taught'];?>:00</strong><?php echo get_string('taughthours', 'local_teachertimecard'); ?></div>
                    <div class="stat" id="missed-hours"><strong><?php echo $sessions['totals']['covered'];?>:00</strong><?php echo get_string('coveredhours', 'local_teachertimecard'); ?></div>
                    <div class="stat"><strong>00:00</strong>Extra Hours</div>
                    <div class="stat"><strong>00:00</strong>Missed Hours</div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <section class="content">
            <div class="time-period poppins">
                <span><?php echo get_string('timeperiod', 'local_teachertimecard'); ?>: 
                    <strong id="time-period-range"><?php echo $display_range; ?></strong>
                </span>
                <div class="dropdown-container">
                    <button class="btn-calendar" id="calendar-btn">
                        <img src="./assets/calendar.svg" alt=""> 
                    </button>
                    <div class="date-dropdown" id="dropdown">
                        <div class="dropdown-option" data-value="Since last download">Since last download</div>
                        <div class="dropdown-option" data-value="Today" data-days="1">Today</div>
                        <div class="dropdown-option" data-value="Yesterday" data-days="2">Yesterday</div>
                        <div class="dropdown-option" data-value="Past month" data-days="30">Past month</div>
                        <div class="dropdown-option" data-value="Past 3 months" data-days="90">Past 3 months</div>
                        <div class="dropdown-option" data-value="Past 6 months" data-days="180">Past 6 months</div>
                        
                        <div class="date-range">
                            <div class="date-input">
                                <span>From :</span>
                                <input type="date" id="fromDate" value="<?php echo date('Y-m-d', $start_timestamp); ?>">
                            </div>
                            <div class="date-input">
                                <span>To :</span>
                                <input type="date" id="toDate" value="<?php echo date('Y-m-d', $end_timestamp); ?>">
                            </div>
                            <button id="btn-pay" >Apply</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hours-breakdown poppins">
                <div class="breakdown-upper">
                    <div>
                        <h3 class="breakdown-title">
                            <?php echo get_string('hoursbreakdown', 'local_teachertimecard'); ?> 
                            <span id="breakdown-total"><?php echo $sessions['totals']['paid_hours'] + $sessions['totals']['pending_hours']; ?>:00</span>
                        </h3>
                    </div>
                    <div class="breakdown-legend">
                        <span class="legend-item">
                            <span class="dot paid"></span>
                            <span><?php echo get_string('paidhours', 'local_teachertimecard', $sessions['totals']['paid_hours']); ?></span>
                        </span>
                        <span class="legend-item">
                            <span class="dot to-be-paid"></span>
                            <span><?php echo get_string('tobepaidhours', 'local_teachertimecard', $sessions['totals']['pending_hours']); ?> </span>
                        </span>
                    </div>
                </div>
                <div class="progress-bars">
                    <?php
                    $total_hours = $sessions['totals']['paid_hours'] + $sessions['totals']['pending_hours'];
                    $paid_percentage = $total_hours > 0 ? ($sessions['totals']['paid_hours'] / $total_hours) * 100 : 0;
                    $pending_percentage = $total_hours > 0 ? ($sessions['totals']['pending_hours'] / $total_hours) * 100 : 0;
                    ?>
                    <div class="progress" style="width: <?php echo round($paid_percentage, 2); ?>%"></div>
                    <div class="no-progress" style="width: <?php echo round($pending_percentage, 2); ?>%"></div>
                </div>
            </div>

            <div class="tabs">
                <div class="tab-buttons">
                    <button class="tab active" data-target="timecard">
                        <?php echo get_string('timecard', 'local_teachertimecard'); ?>
                    </button>
                    <button class="tab" data-target="timeline">
                        <?php echo get_string('timeline', 'local_teachertimecard'); ?>
                    </button>
                </div>
                <div class="tab-actions">
                    <button class="btn-filter" id="filter-btn">
                        <span><?php echo get_string('filter', 'local_teachertimecard'); ?></span>
                        <img src="<?php echo $OUTPUT->image_url('filter', 'local_teachertimecard'); ?>" alt="">
                    </button>
                    <button class="btn-pay" 
                            data-teacherid="<?php echo $teacherid; ?>"
                            data-startdate="<?php echo date('Y-m-d', $start_timestamp); ?>"
                            data-enddate="<?php echo date('Y-m-d', $end_timestamp); ?>"
                            data-teachername="<?php echo fullname($current_teacher); ?>">
                        <?php echo get_string('pay', 'local_teachertimecard'); ?>
                    </button>
                    <button class="btn-add"><?php echo get_string('addtimeoff', 'local_teachertimecard'); ?></button>
                </div>
            </div>

            <!-- Timecard Table -->
            <div class="timecard-table table active" id="timecard-table">
                <table>
                    <thead>
                        <tr>
                            <th><?php echo get_string('date', 'local_teachertimecard'); ?></th>
                            <th><?php echo get_string('mainsession', 'local_teachertimecard'); ?></th>
                            <th><?php echo get_string('practicesession', 'local_teachertimecard'); ?></th>
                            <th><?php echo get_string('taught', 'local_teachertimecard'); ?></th>
                            <th><?php echo get_string('covered', 'local_teachertimecard'); ?></th>
                            <th><?php echo get_string('missed', 'local_teachertimecard'); ?></th>
                            <th><?php echo get_string('note', 'local_teachertimecard'); ?></th>
                            <th><?php echo get_string('status', 'local_teachertimecard'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="timecard-body">
                        <?php echo display_teacher_sessions_table($sessions, $teacherid,$start_timestamp, $end_timestamp); ?>
                    </tbody>
                </table>
            </div>

            <!-- Timeline Table (hidden by default) -->
            <div class="timeline-table table" id="timeline-table">
                <?php echo display_teacher_sessions_timeline($sessions, $teacherid,$start_timestamp, $end_timestamp); ?>
            </div>

             
            
            <div class="overlay"></div>
        </section>
    </main>
</div>

<!-- General Notes Popup
<div class="general-notes-popup" id="generalNotesPopup" style="display: none;">
    <div class="general-notes-header">
        <div class="general-notes-title"><?php echo get_string('makegeneralnote', 'local_teachertimecard'); ?></div>
        <button class="close-popup" onclick="closeGeneralNotesPopup()">×</button>
    </div>
    
    <div class="general-notes-content">
        <div class="teacher-info">
            <div class="teacher-name">
                <strong><?php echo fullname($current_teacher); ?></strong><br>
                <?php echo get_string('madeby', 'local_teachertimecard'); ?>
            </div>
            <div class="session-date">
                <strong><?php echo date('D, M j'); ?></strong><br>
                <?php echo get_string('sessiondate', 'local_teachertimecard'); ?>
            </div>
        </div>
        
        <div class="notes-input-container">
            <textarea class="notes-input" id="notesInput" placeholder="<?php echo get_string('addnotes', 'local_teachertimecard'); ?>"></textarea>
        </div>
        
        <div class="notes-actions">
            <button class="btn btn-remove" id="removeNotesBtn" onclick="toggleRemoveMode()" style="display: none;">
                <?php echo get_string('removeselected', 'local_teachertimecard'); ?>
            </button>
            <button class="btn btn-cancel" id="cancelRemoveBtn" style="display: none;" onclick="cancelRemove()">
                <?php echo get_string('cancel', 'local_teachertimecard'); ?>
            </button>
            <button class="btn btn-submit" onclick="submitNote()">
                <?php echo get_string('submit', 'local_teachertimecard'); ?>
            </button>
        </div>
        
        <div class="notes-list-popup" id="notesListPopup">
            <?php echo display_general_notes($general_notes, true); ?>
        </div>
    </div>
</div> -->
<!-- Payment Popup -->
<div class="payment-popup" id="paymentPopup" style="display: none;">
    <div class="payment-header">
        <div class="payment-title"><?php echo get_string('processpayment', 'local_teachertimecard'); ?></div>
        <button class="close-popup" onclick="paymentSystem.closePaymentPopup()">×</button>
    </div>
    
    <div class="payment-content">
        <div class="payment-summary">
            <div class="teacher-info-payment">
                <strong id="payment-teacher-name"><?php echo fullname($current_teacher); ?></strong>
                <span id="payment-period"><?php echo get_string('timeperiod', 'local_teachertimecard'); ?>: <?php echo $display_range; ?></span>
            </div>
            
            <div class="amount-summary">
                <div class="amount-item">
                    <span><?php echo get_string('totalhours', 'local_teachertimecard'); ?>:</span>
                    <strong id="payment-total-hours">0</strong>
                </div>
                <div class="amount-item">
                    <span><?php echo get_string('totalamount', 'local_teachertimecard'); ?>:</span>
                    <strong id="payment-total-amount">0 USD</strong>
                </div>
                <!-- <div class="amount-item">
                    <span><?php echo get_string('sessionscount', 'local_teachertimecard'); ?>:</span>
                    <strong id="payment-sessions-count">0</strong>
                </div> -->
            </div>
        </div>
        
        <div class="payment-methods">
            <h4><?php echo get_string('selectpaymentmethod', 'local_teachertimecard'); ?></h4>
            <div class="method-options">
                <label class="method-option">
                    <input type="radio" name="payment_method" value="paypal" checked>
                    <span>PayPal</span>
                </label>
                <label class="method-option">
                    <input type="radio" name="payment_method" value="payoneer">
                    <span>Payoneer</span>
                </label>
                <label class="method-option">
                    <input type="radio" name="payment_method" value="bank_transfer">
                    <span><?php echo get_string('banktransfer', 'local_teachertimecard'); ?></span>
                </label>
            </div>
        </div>
        
        <div class="payment-details" id="paypalDetails">
            <label><?php echo get_string('paypalemail', 'local_teachertimecard'); ?></label>
            <input type="email" id="paypalEmail" placeholder="teacher@example.com">
        </div>
        
        <div class="payment-details" id="payoneerDetails" style="display: none;">
            <label><?php echo get_string('payoneeremail', 'local_teachertimecard'); ?></label>
            <input type="email" id="payoneerEmail" placeholder="teacher@example.com">
        </div>
        
        <div class="payment-details" id="bankDetails" style="display: none;">
            <label><?php echo get_string('bankaccount', 'local_teachertimecard'); ?></label>
            <input type="text" id="bankAccount" placeholder="Account Number">
            <label><?php echo get_string('bankname', 'local_teachertimecard'); ?></label>
            <input type="text" id="bankName" placeholder="Bank Name">
        </div>
        
        <div class="payment-actions">
            <button class="btn btn-cancel" onclick="paymentSystem.closePaymentPopup()">
                <?php echo get_string('cancel', 'local_teachertimecard'); ?>
            </button>
            <button class="btn btn-confirm" onclick="paymentSystem.confirmPayment()">
                <?php echo get_string('confirmpayment', 'local_teachertimecard'); ?>
            </button>
        </div>
        
        <div class="payment-loading" id="paymentLoading" style="display: none;">
            <div class="loading-spinner"></div>
            <span><?php echo get_string('processingpayment', 'local_teachertimecard'); ?></span>
        </div>
    </div>
</div>
<?php
echo $OUTPUT->footer();