<?php

/**
 * Local plugin "membership" - Dashboard file
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once(__DIR__ . '/lib.php');

global $CFG, $DB, $PAGE, $USER, $OUTPUT;

$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('membership', 'local_membership'));
$PAGE->set_heading(get_string('membershipdashboard', 'local_membership'));
$PAGE->set_url($CFG->wwwroot . '/local/membership/dashboard_new.php');
$PAGE->add_body_class('local-membership-dashboard');

// Load CSS
$PAGE->requires->css('/local/membership/css/style.css');
$PAGE->requires->css('/local/membership/css/global.css');
$PAGE->requires->css(new moodle_url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Inter:wght@400;500&family=Outfit:wght@300;400&display=swap'));

$cssfilename = '/local/membership/css/bootstrap.css';
$PAGE->requires->css($cssfilename);

$PAGE->requires->css(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css'));
$PAGE->requires->css(new moodle_url('https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/cr-2.0.3/date-1.5.2/fc-5.0.1/fh-4.0.1/kt-2.12.1/r-3.0.2/sc-2.4.3/sb-1.7.1/sp-2.3.1/sl-2.0.3/sr-1.4.1/datatables.min.css'));
$PAGE->requires->css(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css'));
$PAGE->requires->css(new moodle_url('/local/attendance/css/index.css?v=' . time()), true);
$PAGE->requires->jquery();

$PAGE->requires->js(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'), true);
$PAGE->requires->js(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/tempus-dominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js'), true);
$PAGE->requires->js(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js'), true);
$PAGE->requires->js(new moodle_url('https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/cr-2.0.3/date-1.5.2/fc-5.0.1/fh-4.0.1/kt-2.12.1/r-3.0.2/sc-2.4.3/sb-1.7.1/sp-2.3.1/sl-2.0.3/sr-1.4.1/datatables.min.js'), true);
$PAGE->requires->js(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js'), true);
$PAGE->requires->js(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js'), true);
$PAGE->requires->js(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js'), true);
$PAGE->requires->js(new moodle_url('https://cdn.jsdelivr.net/npm/sweetalert2@11'), true);
$PAGE->requires->js(new moodle_url('https://cdn.jsdelivr.net/npm/chart.js'), true);
$PAGE->requires->js('/local/membership/js/global.js');

require_login();
$startdate = optional_param('startdate', strtotime('first day of this month'), PARAM_INT);
$enddate = optional_param('enddate', strtotime('last day of this month'), PARAM_INT);

// Get statistics from database
$dbstats = local_membership_get_stats($startdate, $enddate);
echo $OUTPUT->header();
require_once('membership_new_css.php');

?>

<!--<header class="site-header">-->

<!--  <nav class="main-nav">-->
<!--    <ul>-->
<!--      <li><a href="#"><?php //echo get_string('home', 'local_membership'); 
                          ?></a></li>-->
<!--      <li><a href="#"><?php //echo get_string('groups', 'local_membership'); 
                          ?></a></li>-->
<!--      <li><a href="#"><?php //echo get_string('attendance', 'local_membership'); 
                          ?></a></li>-->
<!--      <li><a href="#"><?php //echo get_string('calendar', 'local_membership'); 
                          ?></a></li>-->
<!--      <li><a href="#"><?php //echo get_string('timesheet', 'local_membership'); 
                          ?></a></li>-->
<!--      <li><a href="#" class="active"><?php //echo get_string('dashboard', 'local_membership'); 
                                          ?></a></li>-->
<!--      <li><a href="#"><?php //echo get_string('settings', 'local_membership'); 
                          ?></a></li>-->
<!--    </ul>-->
<!--  </nav>-->
<!--</header>-->

<main class="dashboard-content page-container">
  <h1 class="dashboard-title"><?php echo get_string('membershipdashboard', 'local_membership'); ?></h1>
  <?php
  require_once('membership_container.php');
  ?>

  <!-- Stats Section -->
  <section id="stats" class="stats-section">
    <div class="stats-filters">
      <div class="dropdown-wrapper">
        <div id="dropdownToggle" class="dropdown-input">
          Select Date Range
        </div>
        <div id="dropdownMenu" class="date-dropdown-menu">
          <!-- <div class="dropdown-option">Since last download</div> -->
          <div class="dropdown-option">Today</div>
          <div class="dropdown-option">Yesterday</div>
          <div class="dropdown-option">Past month</div>
          <div class="dropdown-option">Past 3 months</div>
          <div class="dropdown-option">Past 6 months</div>

          <div class="date-range">
            <div class="date-input">
              <span>From :</span>
              <input type="date" id="fromDate">
            </div>
            <div class="date-input">
              <span>To :</span>
              <input type="date" id="toDate">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Stats Grid Container -->
    <div class="stats-grid" id="statsGrid">
      <!-- Stats will be dynamically loaded here -->
    </div>
  </section>


  <section id="graph" class="graph-section">
    <div class="graph-header">
      <h2 class="graph-title"><?php echo get_string('overallstudentsgraph', 'local_membership'); ?></h2>
      <button class="toggle-button">
        <i class="fa fa-chevron-up"></i>
      </button>
    </div>
    <div class="graph-legends">
      <div class="legend-item"><span class="dot" style="background-color: #c084fc;"></span><?php echo get_string('activestudents', 'local_membership'); ?></div>
      <div class="legend-item"><span class="dot" style="background-color: #2563eb;"></span><?php echo get_string('dropoutstudent', 'local_membership'); ?></div>
      <div class="legend-item"><span class="dot" style="background-color: #fb923c;"></span><?php echo get_string('pausedstudents', 'local_membership'); ?></div>
      <div class="legend-item"><span class="dot" style="background-color: #22c55e;"></span><?php echo get_string('declinedstudents', 'local_membership'); ?></div>
      <div class="legend-item"><span class="dot" style="background-color: #464646;"></span><?php echo get_string('retention', 'local_membership'); ?></div>
    </div>
    <div class="graph-body">
      <!-- THE CANVAS ELEMENT MUST BE HERE -->
      <canvas id="membershipChart" width="100%" height="400"></canvas>
    </div>
  </section>
  <script>
    // Global variable to store chart data
    let graphData = null;
    let membershipChart = null;

    document.addEventListener('DOMContentLoaded', function() {
      const toggle = document.getElementById('dropdownToggle');
      const menu = document.getElementById('dropdownMenu');
      const options = menu.querySelectorAll('.dropdown-option');
      const fromDate = document.getElementById('fromDate');
      const toDate = document.getElementById('toDate');
      const statsGrid = document.getElementById('statsGrid');

      initializeDateRange();

      function initializeDateRange() {
        const today = new Date();
        const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);

        fromDate.valueAsDate = firstDayOfMonth;
        toDate.valueAsDate = today;

        // Format the display text
        const fromText = firstDayOfMonth.toLocaleDateString();
        const toText = today.toLocaleDateString();
        toggle.innerText = `${fromText} - ${toText}`;

        // Load initial stats
        loadStats(firstDayOfMonth, today, "7"); // "7" for custom range
      }

      toggle.addEventListener('click', () => {
        menu.classList.toggle('active');
      });

      document.addEventListener('click', (e) => {
        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
          menu.classList.remove('active');
        }
      });

      options.forEach(option => {
        option.addEventListener('click', () => {
          options.forEach(o => o.classList.remove('selected'));
          option.classList.add('selected');
          toggle.innerText = option.innerText;
          menu.classList.remove('active');
          
          // Calculate dates based on selection
          let startDate, endDate = new Date();
          let p;
          switch (option.innerText) {
            case 'Since last download':
              startDate = new Date(0); // Beginning of time
              p = 1;
              break;
            case 'Today':
              startDate = new Date();
              startDate.setHours(0, 0, 0, 0);
              endDate = new Date();
              endDate.setHours(23, 59, 59, 999);
              p = 2;
              break;
            case 'Yesterday':
              startDate = new Date();
              startDate.setDate(startDate.getDate() - 1);
              startDate.setHours(0, 0, 0, 0);
              endDate = new Date(startDate);
              endDate.setHours(23, 59, 59, 999);
              p = 3;
              break;
            case 'Past month':
              startDate = new Date();
              startDate.setMonth(startDate.getMonth() - 1);
              startDate.setHours(0, 0, 0, 0);
              endDate = new Date();
              endDate.setHours(23, 59, 59, 999);
              p = 4;
              break;
            case 'Past 3 months':
              startDate = new Date();
              startDate.setMonth(startDate.getMonth() - 3);
              startDate.setHours(0, 0, 0, 0);
              endDate = new Date();
              endDate.setHours(23, 59, 59, 999);
              p = 5;
              break;
            case 'Past 6 months':
              startDate = new Date();
              startDate.setMonth(startDate.getMonth() - 6);
              startDate.setHours(0, 0, 0, 0);
              endDate = new Date();
              endDate.setHours(23, 59, 59, 999);
              p = 6;
              break;
          }

          // Update date pickers to match the selected range
          fromDate.valueAsDate = startDate;
          toDate.valueAsDate = endDate;

          // Load stats with the new date range
          loadStats(startDate, endDate, p);
        });
      });

      // When date range is selected manually
      fromDate.addEventListener('change', updateCustomDateLabel);
      toDate.addEventListener('change', updateCustomDateLabel);

      function updateCustomDateLabel() {
        if (fromDate.value && toDate.value) {
          const from = new Date(fromDate.value).toLocaleDateString();
          const to = new Date(toDate.value).toLocaleDateString();
          toggle.innerText = `${from} - ${to}`;

          // Deselect any predefined options
          options.forEach(o => o.classList.remove('selected'));

          // Load stats with the custom date range
          loadStats(new Date(fromDate.value), new Date(toDate.value), "7");
        }
      }

      function loadStats(startDate, endDate, p) {
        // Format dates for the API call
        const startTimestamp = Math.floor(startDate.getTime() / 1000);
        const endTimestamp = Math.floor(endDate.getTime() / 1000);

        // Fetch stats data
        fetch(`${M.cfg.wwwroot}/local/membership/api/get_stats.php?startdate=${startTimestamp}&enddate=${endTimestamp}&p=${p}`)
          .then(response => response.json())
          .then(data => updateStatsGrid(data))
          .catch(error => console.error('Error loading stats:', error));

        // Fetch graph data
        fetch(`${M.cfg.wwwroot}/local/membership/api/graph_data.php?startdate=${startTimestamp}&enddate=${endTimestamp}`)
          .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
          })
          .then(data => {
            graphData = data;
            renderChart();
          })
          .catch(error => {
            console.error('Error fetching graph data:', error);
          });
      }

      function updateStatsGrid(data) {
        const stats = [{
            label: 'activestudents',
            ...data.stats.activestudents
          },
          {
            label: 'newstudents',
            ...data.stats.newstudents
          },
          {
            label: 'pausedstudents',
            ...data.stats.pausedstudents
          },
          {
            label: 'declinedstudents',
            ...data.stats.declinedstudents
          },
          {
            label: 'dropoutstudent',
            ...data.stats.dropoutstudent
          },
          {
            label: 'retention',
            ...data.stats.retention
          },
        ];

        let html = '';
        stats.forEach(stat => {
          html += `
        <div class="stat-item">
          <h3 class="stat-title"><span class="dot" style="background-color: ${stat.color}"></span>
            ${stat.label.charAt(0).toUpperCase() + stat.label.slice(1)}
          </h3>
          <p class="stat-value">${stat.value}</p>
          <p class="stat-comparison ${stat.trend}">
            <i class="fa fa-arrow-${stat.trend === 'positive' ? 'up' : 
              (stat.trend === 'negative' ? 'down' : 'right')}"></i>
            <span>vs ${data.period}</span>
          </p>
        </div>
      `;
        });

        statsGrid.innerHTML = html;
      }

      function renderChart() {
        const canvas = document.getElementById('membershipChart');
        if (!canvas) {
          console.error('Chart canvas not found');
          return;
        }

        if (!graphData || !graphData.success) {
          console.error('No valid graph data available');
          return;
        }

        // Destroy previous chart if it exists
        if (membershipChart) {
          membershipChart.destroy();
        }

        const ctx = canvas.getContext('2d');
        membershipChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: graphData.data.labels,
            datasets: [{
                label: 'Active Students',
                data: graphData.data.activestudents,
                borderColor: '#c084fc',
                backgroundColor: 'rgba(192, 132, 252, 0.1)',
                tension: 0.3,
                fill: true
              },
              {
                label: 'Dropout Students',
                data: graphData.data.dropoutstudent,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                tension: 0.3,
                fill: true
              },
              {
                label: 'Paused Students',
                data: graphData.data.pausedstudents,
                borderColor: '#fb923c',
                backgroundColor: 'rgba(251, 146, 60, 0.1)',
                tension: 0.3,
                fill: true
              },
              {
                label: 'Declined Students',
                data: graphData.data.declinedstudents,
                borderColor: '#22c55e',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                tension: 0.3,
                fill: true
              },
              {
                label: 'Retention Rate',
                data: graphData.data.retention,
                borderColor: '#464646',
                backgroundColor: 'rgba(70, 70, 70, 0.1)',
                tension: 0.3,
                fill: true
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: false
              }
            }
          }
        });
      }
    });
  </script>



  <!-- Table Section -->
  <section id="student-table" class="table-section">
    <div class="table-controls-container">
      <div class="table-controls">
        <div class="search-filter-group">
          <div class="search-input">
            <img src="<?= $CFG->wwwroot . '/local/membership/img/membership_images/search.svg'; ?>" alt="search icon">
            <input type="text" id="customSearchInput" placeholder="search by name, email, phone number">
          </div>
          <button class="control-button filter-button">
            <span>Filter</span>
            <img src="<?= $CFG->wwwroot . '/local/membership/img/membership_images/filter.svg'; ?>" alt="filter icon">
          </button>
          <div class="filter-gap"></div>
        </div>
        <div class="action-buttons-group">
          <?php if (is_siteadmin()): ?>
            <a href="<?= $CFG->wwwroot . '/local/membership/api/patreon_handler.php'; ?>" class="control-button" id="patreonAuthBtn">
              <img src="<?= $CFG->wwwroot . '/local/membership/img/membership_images/patrean_auth.svg'; ?>" alt="patreon icon">
              <span>Patreon Auth</span>
            </a>
          <?php endif; ?>
          <button class="control-button" id="copyBtn">
            <img src="<?= $CFG->wwwroot . '/local/membership/img/membership_images/copy.svg'; ?>" alt="copy icon">
            <span>Copy</span>
          </button>
          <div class="dropdown download-dropdown">
            <button class="control-button" id="downloadBtn">
              <img src="<?= $CFG->wwwroot . '/local/membership/img/membership_images/download.svg'; ?>" alt="download icon">
              <span>Download</span>

            </button>
            <ul class="dropdown-menu" id="downloadBtnMenu">
              <li>
                <button class="dropdown-item" id="excelBtn">
                  <i class="fa fa-file-excel dropdown-icon"></i>
                  <span>Excel</span>
                </button>
              </li>
              <li>
                <button class="dropdown-item" id="pdfBtn">
                  <i class="fa fa-file-pdf dropdown-icon"></i>
                  <span>PDF</span>
                </button>
              </li>
              <li>
                <button class="dropdown-item" id="printBtn">
                  <i class="fa fa-print dropdown-icon"></i>
                  <span>Print</span>
                </button>
              </li>
            </ul>
          </div>
          <button class="control-button" id="createBtn">
            <img src="<?= $CFG->wwwroot . '/local/membership/img/membership_images/create.svg'; ?>" alt="create icon">
            <span>Create</span>
          </button>
          <div class="dropdown columns-dropdown">
            <button class="control-button" id="toggleColumnsBtn">
              <img src="<?= $CFG->wwwroot . '/local/membership/img/membership_images/toggle_column.svg'; ?>" alt="toggle icon">
              <span>Toggle Columns</span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="toggleColumnsButton" id="toggleColumnsBtnMenu">
              <li><label class="dropdown-item cursor-pointer"><input type="checkbox" class="toggle-column mr-2" data-column="0" checked>Name</label></li>
              <li><label class="dropdown-item cursor-pointer"><input type="checkbox" class="toggle-column mr-2" data-column="1" checked>Email</label></li>
              <li><label class="dropdown-item cursor-pointer"><input type="checkbox" class="toggle-column mr-2" data-column="2" checked>Method</label></li>
              <li><label class="dropdown-item cursor-pointer"><input type="checkbox" class="toggle-column mr-2" data-column="3" checked>Status</label></li>
              <li><label class="dropdown-item cursor-pointer"><input type="checkbox" class="toggle-column mr-2" data-column="4" checked>Price</label></li>
              <li><label class="dropdown-item cursor-pointer"><input type="checkbox" class="toggle-column mr-2" data-column="5" checked>Start</label></li>
              <li><label class="dropdown-item cursor-pointer"><input type="checkbox" class="toggle-column mr-2" data-column="6" checked>End</label></li>
              <li><label class="dropdown-item cursor-pointer"><input type="checkbox" class="toggle-column mr-2" data-column="7" checked>Interval</label></li>
              <li><label class="dropdown-item cursor-pointer"><input type="checkbox" class="toggle-column mr-2" data-column="8" checked>Cohorts</label></li>
              <li><label class="dropdown-item cursor-pointer"><input type="checkbox" class="toggle-column mr-2" data-column="10" checked>Action</label></li>
            </ul>
          </div>
        </div>
      </div>
    </div>




    <div class="table-responsive">
      <table id="subscriptionsTable" class="table table-striped table-bordered " style="width:100%">
        <thead class="custom-datatable-header">
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Method</th>
            <th>Status</th>
            <th>Price</th>
            <th>Start</th>
            <th>End</th>
            <th>Interval</th>
            <th>Cohort</th>
            <th>Cohort</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </section>
  <div class="modal fade" id="editCohortModal" tabindex="-1" role="dialog" aria-labelledby="editCohortModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editCohortModalLabel">Edit Cohorts</h5>
          <button type="button" class="close" id="closeHeader" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editCohortForm">
            <div class="form-group">
              <label for="cohortSelect">Select Cohorts</label>
              <select multiple class="form-control" id="cohortSelect"></select>
            </div>
            <div class="form-group">
              <label for="instantToggle">Instant</label>
              <input type="checkbox" id="instantToggle" checked="">
            </div>

            <div class="form-group">
              <label>Date</label>
              <div class="input-group date" id="datepicker">
                <input class="form-control" placeholder="MM/DD/YYYY" disabled=""><span class="input-group-append input-group-addon"><span class="input-group-text"><i class="fa fa-calendar"></i></span></span>
              </div>
            </div>

            <input type="hidden" id="rowIndex">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="saveCohorts">Save</button>
          <button type="button" class="btn btn-secondary" id="closeFooter" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <?php
  // Determine if current user is admin
  $isadmin = is_siteadmin($USER);

  $ismanager = false;

  if (!$isadmin) {
    // Determine if user has manager role (check by role assignment)
    $context = context_system::instance();
    $roles = get_user_roles($context, $USER->id);
    foreach ($roles as $role) {
      if ($role->shortname === 'manager') {
        $ismanager = true;
        break;
      }
    }
  }

  if ($ismanager || $isadmin) {
    require_once("membership_withdraw.php");
  }
  ?>

  <script type="text/javascript">
    const isAdmin = <?= $isadmin ? 'true' : 'false' ?>;
    const isManager = <?= $ismanager ? 'true' : 'false' ?>;
    let $jq = jQuery.noConflict();

    // Helper functions
    function showConfirmAction(event) {
      event.preventDefault();
      Swal.fire({
        title: 'Confirm Action',
        text: 'Are you sure that you want to cancel this subscription?',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        animation: 'slide-from-top',
        showClass: {
          popup: `
        animate__animated
        animate__fadeInUp
        animate__faster
        `
        },
        hideClass: {
          popup: `
        animate__animated
        animate__fadeOutDown
        animate__faster
        `
        }
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = event.target.href;
        }
      });
    }

    function loadCohorts() {
      return $jq.ajax({
        url: "<?= $CFG->wwwroot . '/local/membership/api/cohort_handler.php'; ?>",
        method: 'POST',
        dataType: 'json',
        data: {
          action: 'getCohorts'
        }
      });
    }

    // Document ready
    $jq(document).ready(function() {
      let cohorts = [];
      let unsubscribeId = null; // Global var to store ID for unsubscribe actions

      // Initialize confirm action for all cancel links
      document.body.querySelectorAll('a.confirm-cancel-action').forEach(link => {
        link.addEventListener('click', showConfirmAction);
      });

      // Load cohorts and initialize DataTable
      loadCohorts().done(function(data) {
        cohorts = data;
        
        let table = $jq('#subscriptionsTable').DataTable({
          "paging": true,
          "ajax": "<?= $CFG->wwwroot . '/local/membership/api/table_handler.php'; ?>",
          "columns": [{
              "data": "name",
              "render": function(data, type, row) {
                return `
              <div class="td-name">
                    <img src="${row.avatar}" alt="${data}" 
                         onerror="this.src='${M.cfg.wwwroot}/theme/image.php/boost/u/f1'">
                    <span>${data}</span>
                </div>`;
              }
            },
            {
              "data": "email",
              "render": function(data, type, row) {
                return `
              <div class="td-contact">
                  <div>
                      <img src="${M.cfg.wwwroot}/local/membership/img/membership_images/email_icon.svg" alt="email">
                      <span>${data}</span>
                  </div>
                  <div>
                      <img src="${M.cfg.wwwroot}/local/membership/img/membership_images/phone_icon.svg" alt="phone">
                      <span>${row.phone || 'N/A'}</span>
                  </div>
              </div>`;
              }
            },
            {
              "data": "method"
            },
            {
              "data": "status",
              "render": function(data, type, row) {
                const statusClass = data.toLowerCase() === 'active' ? 'active' : 'inactive';
                return `<span class="status-badge ${statusClass}" 
                              onclick="openMenu( 
                                        '${row.name}', 
                                        '${row.status}', 
                                        '${row.email}', 
                                        '${row.phone || 'N/A'}', 
                                        '${row.billingFrequency}', 
                                        '${row.avatar}',
                                        '${row.id}')">${data}</span>`; //openMenu(name, status, email, number, activeTime, imgUrl, uid) 
              }
            },
            {
              "data": "price"
            },
            {
              "data": "startDate"
            },
            {
              "data": "endDate"
            },
            {
              "data": "billingFrequency"
            },
            {
              "data": "cohortColumn"
            },
            {
              "data": "cohortIds",
              "visible": false
            },
            {
              "data": "cohort",
              "visible": false
            },

            {
              "data": "action",
              "render": function(data, type, row) {
                return `
                <div class="subscription-actions-container edit-button" data-id="${row.id}">
                    <button class="subscription-actions-trigger">
                        <img src="${M.cfg.wwwroot}/local/membership/img/membership_images/circle.svg" alt="cancel background">
                        <img src="${M.cfg.wwwroot}/local/membership/img/membership_images/edit.svg" alt="cancel">
                    </button>
                    <div class="subscription-actions-menu">
                        <button class="subscription-action-item" 
                                onclick="viewUserProfile(${row.id || 0})">
                            <i class="fa fa-user"></i> View Profile
                        </button>
                        <button class="subscription-action-item" 
                                onclick="viewUserAttendance(${row.id || 0})">
                            <i class="fa fa-calendar-check"></i> View Attendance
                        </button>
                        <button class="subscription-action-item" 
                                onclick="editUserCohort(0)">
                            <i class="fa fa-users"></i> Edit Cohort
                        </button>
                        <button class="subscription-action-item" 
                                onclick="editUserSubscription(${row.id || 0})">
                            <i class="fa fa-edit"></i> Edit Subscription
                        </button>
                    </div>
                </div>`;
              }
            }
          ],
          "buttons": [{
              extend: 'colvis',
              text: '',
              className: 'd-none',
              collectionLayout: 'fixed',
              postfixButtons: ['colvisRestore']
            },
            {
              extend: 'copy',
              text: '',
              className: 'd-none'
            },
            {
              extend: 'excel',
              text: '',
              className: 'd-none'
            },
            {
              extend: 'pdf',
              text: '',
              className: 'd-none'
            },
            {
              extend: 'print',
              text: '',
              className: 'd-none'
            }
          ],
          "order": [],
          "dom": 'Blfrtip',
          "fixedHeader": true,
          "colReorder": true,
          "rowReorder": true,
          "responsive": true,
          "searchBuilder": true,
          "searchPanes": true,
          "select": true,
          "dom": 'rtip',
          "language": {
            "info": "",
            "lengthMenu": ""
          },
          "initComplete": function() {
            // Connect custom buttons
            $jq('#toggleColumnsBtn').on('click', function(e) {
              e.stopPropagation();
              $jq('.download-dropdown .dropdown-menu').hide();

              // Toggle columns dropdown
              const columnsDropdown = $jq('.columns-dropdown .dropdown-menu');
              columnsDropdown.toggle();

              // Position dropdown right below the button
              const button = $jq(this).closest('.control-button');
              const dropdown = $jq(this).closest('.dropdown').find('.dropdown-menu');

              dropdown.css({
                'display': 'block',
                'position': 'absolute',
                'top': button.outerHeight() + 'px',
                'right': '0',
                'min-width': button.outerWidth() + 'px'
              });
            });

            // Handle column toggling
            $jq(document).on('change', '.toggle-column', function() {
              const columnIndex = parseInt($jq(this).attr('data-column'));
              table.column(columnIndex).visible(this.checked);
            });

            // Initialize column visibility based on checkboxes
            $jq('.toggle-column').each(function() {
              const columnIndex = parseInt($jq(this).attr('data-column'));
              const isVisible = table.column(columnIndex).visible();
              $jq(this).prop('checked', isVisible);
            });

            $jq('#copyBtn').on('click', function() {
              table.button('.buttons-copy').trigger();
            });

            $jq('#excelBtn').on('click', function() {
              table.button('.buttons-excel').trigger();
              $jq('.dropdown-menu').hide();
            });

            $jq('#pdfBtn').on('click', function() {
              table.button('.buttons-pdf').trigger();
              $jq('.dropdown-menu').hide();
            });

            $jq('#printBtn').on('click', function() {
              table.button('.buttons-print').trigger();
              $jq('.dropdown-menu').hide();
            });

            // Hide default elements
            $jq('.dataTables_filter, .dataTables_length').hide();
          }
        });

        // Custom search
        $jq('#customSearchInput').on('keyup', function() {
          table.search(this.value).draw();
        });

        // Download dropdown toggle
        $jq('#downloadBtn').on('click', function(e) {
          e.stopPropagation();
          $jq('.columns-dropdown .dropdown-menu').hide();
          $jq(this).closest('.dropdown').find('.dropdown-menu').toggle();
        });

        // Close dropdowns when clicking outside
        $jq(document).on('click', function() {
          $jq('#toggleColumnsBtnMenu').hide();
          $jq('#downloadBtnMenu').hide();
        });

        // Style the column visibility dropdown
        $jq(document).on('mouseover', '.dt-button-collection', function() {
          $jq(this).addClass('custom-column-dropdown');
        });

        // Cancel subscription flow
        $jq('#subscriptionsTable tbody').on('click', '.confirm-cancel-action', function() {
          unsubscribeId = $jq(this).data('id');

          fetch('code_handler.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
              },
              body: `action=generate&subscriptionid=${encodeURIComponent(unsubscribeId)}`
            })
            .then(response => response.json())
            .then(data => {
              if (data.status === 'ok') {
                $jq('#membership_withdraw_backdrop, #membership_withdraw_modal').fadeIn(200);
                $jq('.membership_withdraw_code_input').val('').first().focus();
              } else {
                Swal.fire('Error', 'Failed to generate verification code.', 'error');
              }
            })
            .catch(error => {
              console.error('Error:', error);
              Swal.fire('Error', 'An error occurred while generating code.', 'error');
            });
        });

        // Close modal
        $jq('.membership_withdraw_close, #membership_withdraw_backdrop').on('click', function() {
          $jq('#membership_withdraw_backdrop, #membership_withdraw_modal').fadeOut(200);
        });

        // Verify code and proceed with unsubscribe
        $jq('#membership_withdraw_proceed_btn').on('click', function() {
          const code = $jq('.membership_withdraw_code_input').map(function() {
            return $jq(this).val();
          }).get().join('');

          if (code.length !== 6) {
            Swal.fire('Invalid Code', 'Please enter the 6-digit verification code.', 'error');
            return;
          }

          // Call backend to verify the code
          fetch('code_handler.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
              },
              body: `action=verify&subscriptionid=${encodeURIComponent(unsubscribeId)}&code=${encodeURIComponent(code)}`
            })
            .then(response => response.json())
            .then(data => {
              if (data.status === 'ok') {
                // Hide modal
                $jq('#membership_withdraw_backdrop, #membership_withdraw_modal').fadeOut(200);
                // Redirect to unsubscribe
                window.location.href = "<?= $CFG->wwwroot . '/local/membership/unsub.php?id=' ?>" + unsubscribeId;
              } else {
                Swal.fire('Invalid Code', 'Verification failed. Please enter the correct code.', 'error').then(() => {
                  $jq('.membership_withdraw_code_input').val('');
                  $jq('.membership_withdraw_code_input').first().focus();
                });
              }
            })
            .catch(error => {
              console.error('Verification error:', error);
              Swal.fire('Error', 'Something went wrong while verifying the code.', 'error');
            });
        });

        // Request new code button
        $jq('#membership_withdraw_request_btn').on('click', function() {
          if (!unsubscribeId) {
            Swal.fire('Error', 'Subscription ID missing.', 'error');
            return;
          }

          fetch('code_handler.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
              },
              body: `action=generate&subscriptionid=${encodeURIComponent(unsubscribeId)}`
            })
            .then(response => response.json())
            .then(data => {
              if (data.status === 'ok') {
                Swal.fire('Success', 'Successfully sent new code to Admin.', 'success').then(() => {
                  $jq('#membership_withdraw_backdrop, #membership_withdraw_modal').fadeIn(200);
                  $jq('.membership_withdraw_code_input').val('').first().focus();
                });
              } else {
                Swal.fire('Error', 'Failed to generate verification code.', 'error');
              }
            })
            .catch(error => {
              console.error('Error:', error);
              Swal.fire('Error', 'An error occurred while generating code.', 'error');
            });
        });

        // Cohort management
        $jq('#instantToggle').on('change', function() {
          if ($jq(this).is(':checked')) {
            $jq('#datepicker input').prop('disabled', true);
          } else {
            $jq('#datepicker input').prop('disabled', false);
          }
        });

        $jq('#datepicker').datetimepicker({
          format: 'YYYY-MM-DD',
          minDate: moment().add(1, 'days'),
        });

        $jq('input.toggle-column').on('change', function(e) {
          e.preventDefault();
          let column = table.column($jq(this).attr('data-column'));
          column.visible(!column.visible());
        });

        $jq('#subscriptionsTable tbody').on('click', '.edit-btn', function() {
          let tr = $jq(this).closest('tr');
          let row = table.row(tr);
          let rowData = row.data();
          $jq('#rowIndex').val(row.index());

          $jq('#cohortSelect').empty();
          $.each(cohorts, function(index, cohort) {
            $jq('#cohortSelect').append(new Option(cohort.name, cohort.id));
          });
          if (rowData.cohortIds) {
            let selectedCohorts = rowData.cohortIds.split(',');
            $jq('#cohortSelect').val(selectedCohorts);
          }

          $jq('#instantToggle').prop('checked', true);

          $jq('#editCohortModal').modal('show');
        });

        $jq('#closeHeader, #closeFooter').on('click', function() {
          $jq('#editCohortModal').modal('hide');
        });

        $jq('#saveCohorts').on('click', function() {
          if (!$jq('#instantToggle').is(':checked') && !$jq('#datepicker input').val()) {
            Swal.fire('Missing Date', 'You need to select a date first', 'error');
            return;
          }

          let rowIndex = $jq('#rowIndex').val();
          let selectedCohorts = $jq('#cohortSelect').val();
          let cohortNames = $jq('#cohortSelect option:selected').map(function() {
            return $jq(this).text();
          }).get().join(', ');

          let originalCohortNames = table.cell(rowIndex, 8).data();
          let originalCohortIds = table.cell(rowIndex, 9).data();

          let selectedCohortIds = selectedCohorts.join(',');
          let subReference = table.row(rowIndex).data().id;
          let subPlatform = table.row(rowIndex).data().method;
          let subEmail = table.row(rowIndex).data().email;
          let subCron = $jq('#instantToggle').is(':checked') ? '' : Math.floor(new Date($jq('#datepicker input').val()).getTime() / 1000);

          if ($jq('#instantToggle').is(':checked')) {
            table.cell(rowIndex, 8).data(cohortNames).draw();
            table.cell(rowIndex, 9).data(selectedCohortIds).draw();
          } else {
            let scheduleDate = new Date($jq('#datepicker input').val());
            let currentDate = new Date();
            let timeDiff = scheduleDate - currentDate;
            let daysRemaining = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));

            let daysRemainingText = daysRemaining <= 0 ? 'today' : `${daysRemaining} days`;
            let cleanedOriginalNames = originalCohortNames.replace(/, scheduled to:.*/, '');
            let newCohortInfo = `${cleanedOriginalNames}, scheduled to: ${cohortNames} in ${daysRemainingText}`;

            table.cell(rowIndex, 8).data(newCohortInfo).draw();
            table.cell(rowIndex, 9).data(selectedCohortIds).draw();
          }

          $jq.ajax({
            url: "<?= $CFG->wwwroot . '/local/membership/api/cohort_handler.php'; ?>",
            type: 'POST',
            dataType: 'json',
            data: {
              action: 'updateCohorts',
              subCohorts: selectedCohortIds,
              subReference: subReference,
              subPlatform: subPlatform,
              subEmail: subEmail,
              subCron: subCron
            },
            success: function(response) {
              if (response.success) {
                if (!$jq('#instantToggle').is(':checked') && $jq('#datepicker input').val()) {
                  Swal.fire('Scheduled', 'Subscription Scheduled', 'success');
                } else {
                  Swal.fire('Saved', 'Subscription updated', 'success');
                }
              } else {
                Swal.fire('Error', 'Update failed', 'error');
                table.cell(rowIndex, 8).data(originalCohortNames).draw();
                table.cell(rowIndex, 9).data(originalCohortIds).draw();
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log('AJAX error:', textStatus, errorThrown);
              Swal.fire('Error', 'Update failed', 'error');
              table.cell(rowIndex, 8).data(originalCohortNames).draw();
              table.cell(rowIndex, 9).data(originalCohortIds).draw();
            }
          });

          $jq('#editCohortModal').modal('hide');
        });
      });
    });
  </script>
  <script>
    function openMenu(name, status, email, number, activeTime, imgUrl, uid) {
      //alert(name+status+ email+ number+ activeTime+ imgUrl+ uid);
      Swal.fire({
        position: "center-end",
        showConfirmButton: false,
        html: `

                <div style="height:100%;" id="asideMenu">
                    <div class="containerMenuItem">
                        <div style="display:flex; justify-content:start;align-items:center;gap:15px;">
                            <img src="${imgUrl}" style="height:48px;width:auto;border-radius:100%" alt="img"/>
                            <div 
    ${uid !== 0 ? `onclick="window.location.href='<?= $CFG->wwwroot ?>/user/profile.php?id=${uid}'"` : ''} 
    style="display:flex; flex-direction:column; align-items: flex-start; ${uid !== 0 ? 'cursor: pointer;' : ''}">
    
    <b style="font-size: 16px;
              line-height: 19.36px;
              font-weight: 600;
              font-family: 'Inter', sans-serif;
              color: #000000;">${name}</b>
    <span style="font-size: 12px;
                 line-height: 18px;
                 font-weight: 400;
                 font-family: 'Poppins', sans-serif;
                 color: #000000;">Paid Member</span>  
</div>
                        </div>
                        <div style="display:flex; width:100%;justify-content:space-around;align-items:center;gap:10px">
                            <button class="buttonMenu buttonMenu--positive"><i class="fa fa-paper-plane" aria-hidden="true"></i>Message</button>
                            <button class="buttonMenu buttonMenu--negative"><i class="fa fa-ellipsis-h" aria-hidden="true"></i>More</button>
                        </div>

                    </div>

                    <h4 style="text-align:left">Contact Information</h4>
                    <div class="containerItemModal">
                        <div >
                            <h3>Email</h3>
                            <span>${email}</span>
                        </div>
                        <div>
                            <h3>Whatsapp Number</h3>
                            <span>${number}</span>
                        </div>
                        <div>
                            <h3>Active Time</h3>
                            <span>${activeTime}</span>
                        </div>
                        <div>
                            <h3>Membership</h3>
                            <span>${status}</span>
                        </div>
                    </div>

                    

                    <h4 style="text-align:left;margin-top:20px">Notes</h4>
                    
                    <form action="" style="display:flex; justify-content:start;align-items:center">
                        <textarea style="resize: none; width:100%;background: none;color: black;border: none;border: 0.9px solid #00000033;border-radius: 10px;padding: 10px;font-size: 0.8em;height: 100px;" name="" id=""></textarea>
                    
                    </form>

                    <h4 style="text-align:left;margin-top:20px">Payment History</h4>

                    <ul class="paymentContainer">
                        <li class="paymentItem"><div class="leftSide"><img style="height: 30px;width:auto;" src=${imgUrl} alt=""> <p>August 08, 2023</p></div><div class="rightSide">$3 <div class="dot"></div> <span class="goodSpan">Succes</span></div></li>
                        <li class="paymentItem"><div class="leftSide"><img style="height: 30px;width:auto;" src=${imgUrl} alt=""> <p>August 08, 2023</p></div><div class="rightSide">$3 <div class="dot"></div> <span class="goodSpan">Succes</span></div></li>
                        <li class="paymentItem"><div class="leftSide"><img style="height: 30px;width:auto;" src=${imgUrl} alt=""> <p>August 08, 2023</p></div><div class="rightSide">$3 <div class="dot"></div> <span class="goodSpan">Succes</span></div></li>
                    </ul>
                    <h4 style="text-align:left;margin-top:20px">Active Time</h4>

                    <ul class="paymentContainer">
                        <li class="paymentItem"><div class="dataCourseItem"><div class="tittleCourse"><b>A1</b><span>Lvl</span></div><div class="contentCohortLi">KY2 - 6544<span class="goodSpan">00/00/0000</span></div></div><div><span style="font-size: 14px;">Test</span></div></li>
                        <li class="paymentItem"><div class="dataCourseItem"><div class="tittleCourse"><b>A1</b><span>Lvl</span></div><div class="contentCohortLi">KY2 - 6544<span class="goodSpan">00/00/0000</span></div></div><div><span style="font-size: 14px;">Test</span></div></li>
                        <li class="paymentItem"><div class="dataCourseItem"><div class="tittleCourse"><b>A1</b><span>Lvl</span></div><div class="contentCohortLi">KY2 - 6544<span class="goodSpan">00/00/0000</span></div></div><div><span style="font-size: 14px;">Test</span></div></li>
                    </ul>
                </div>
            `,
        showClass: {
          popup: `
                animate__animated
                animate__fadeInRight
                animate__faster
                `
        },
        hideClass: {
          popup: `
                animate__animated
                animate__fadeOutRight
                animate__faster
                `
        },
        customClass: {
          popup: 'menu-swal'
        }
      });
    }

    function openModal(event, name, status, email, number, activeTime, imgUrl) {
      debugger
      let mouseX = event.clientX;
      let mouseY = event.clientY;

      Swal.fire({
        title: `<img src="${imgUrl}" style="height:50px;width:auto;border-radius:100%" alt="img"/> ${name}`,
        html: `
                <div class="containerItemModal">
                    <div>
                        <h3>Email</h3>
                        <span>${email}</span>
                    </div>
                    <div>
                        <h3>Whatsapp Number</h3>
                        <span>${number}</span>
                    </div>
                    <div>
                        <h3>Active Time</h3>
                        <span>${activeTime} Moth</span>
                    </div>
                    <div>
                        <h3>Membership</h3>
                        <span>${status}</span>
                    </div>
                </div>
            `,

        customClass: {
          title: 'titleModal'
        },
        showCloseButton: true,
        showConfirmButton: false,
        background: '#fff',
        willOpen: () => {
          const swalPopup = document.querySelector('.swal2-popup');
          if (swalPopup) {
            swalPopup.style.left = mouseX + 'px';
            swalPopup.style.top = (mouseY + 20) + 'px';
          }
        }
      });
    }
    // Handle dropdown toggle
    document.addEventListener('click', function(e) {
      const trigger = e.target.closest('.subscription-actions-trigger');
      if (trigger) {
        e.preventDefault();
        const container = trigger.closest('.subscription-actions-container');
        container.classList.toggle('active');

        // Close other open menus
        document.querySelectorAll('.subscription-actions-container.active').forEach(el => {
          if (el !== container) el.classList.remove('active');
        });
      } else {
        // Close all menus when clicking elsewhere
        document.querySelectorAll('.subscription-actions-container.active').forEach(el => {
          el.classList.remove('active');
        });
      }
    });

    // Action functions
    function viewUserProfile(userId) {
      window.location.href = `${M.cfg.wwwroot}/user/profile.php?id=${userId}`;
    }

    function viewUserAttendance(userId) {
      console.log('View attendance for user:', userId);
      // Implement attendance view
    }

    function editUserCohort(userId) {
      //console.log('Edit cohort for user:', userId);
      $jq('#editCohortModal').modal('show');
      // Implement cohort editing
    }

    function editUserSubscription(userId) {
      console.log('Edit subscription for user:', userId);
      // Implement subscription editing
    }
  </script>
  <?php
  echo $OUTPUT->footer();
