<?php

/**
 * Local plugin "membership" - Dashboard file
 *
 * @package    membership
 * @copyright  2024 Fabian (Neivalhein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once(__DIR__ . '/lib.php');

global $CFG, $DB, $PAGE, $USER;

$PAGE->set_context(context_system::instance());
$PAGE->set_title("Membership Dashboard");
$PAGE->set_heading("Membership Dashboard");
$PAGE->set_url($CFG->wwwroot.'/local/membership/dashboard.php');

$PAGE->requires->css(new moodle_url('/local/membership/css/style.css?v=' . time()), true);

$cssfilename = '/local/membership/css/owl.carousel.css';
$PAGE->requires->css($cssfilename);
$cssfilename = '/local/membership/css/bootstrap.css';
$PAGE->requires->css($cssfilename);

$PAGE->requires->css(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css'));
$PAGE->requires->css(new moodle_url('https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/cr-2.0.3/date-1.5.2/fc-5.0.1/fh-4.0.1/kt-2.12.1/r-3.0.2/sc-2.4.3/sb-1.7.1/sp-2.3.1/sl-2.0.3/sr-1.4.1/datatables.min.css'));
$PAGE->requires->css(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css'));

$PAGE->requires->jquery();
$PAGE->requires->js(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'), true);
$PAGE->requires->js(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/tempus-dominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js'), true);
$PAGE->requires->js(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js'), true);
$PAGE->requires->js(new moodle_url('https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/cr-2.0.3/date-1.5.2/fc-5.0.1/fh-4.0.1/kt-2.12.1/r-3.0.2/sc-2.4.3/sb-1.7.1/sp-2.3.1/sl-2.0.3/sr-1.4.1/datatables.min.js'), true);
$PAGE->requires->js(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js'), true);
$PAGE->requires->js(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js'), true);
$PAGE->requires->js(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js'), true);
$PAGE->requires->js(new moodle_url('https://cdn.jsdelivr.net/npm/sweetalert2@11'), true);

require_login();
// if (!is_siteadmin()) {
//     echo '<script>
//         alert("🚫 You do not have access to this page.");
//         window.location.href = "' . $CFG->wwwroot . '/course/index.php";
//     </script>';
//     exit;
// }

ob_start();

global $USER, $DB, $CFG;

// Check if user is Admin
$isadmin = is_siteadmin($USER);

// Check if user has Manager role (roleid = 1)
$context = context_system::instance();
$hasmanagerrole = user_has_role_assignment($USER->id, 1, $context->id); // 1 = Manager role

if (!$isadmin && !$hasmanagerrole) {
    echo '<script>
        alert("🚫 You do not have access to this page.");
        window.location.href = "' . $CFG->wwwroot . '/course/index.php";
    </script>';
    exit;
}
echo $OUTPUT->header();

?>

<style>
  .page-item:not(:first-child) .page-link {
    margin-left: 0 !important;
  }
  .dt-paging-button.page-item {
    margin: 2px;
  }
  .btn-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 2px;
  }
  .btn-container .btn {
    margin: 2px;
  }
</style>
<?php
$subscriptionDetails = get_braintree_subscriptions_data(is_siteadmin(), $USER->id);
if (!is_array($subscriptionDetails)) {
    $subscriptionDetails = [];
}
?>
<div class="row">
  <div class="col-xl-7 col-md-12 col-sm-12">
    <div class="">
      <h3>Sales Report</h3>
      <script type="text/javascript" src="<?= $CFG->wwwroot.'/local/membership/js/loader.js'; ?>"></script>
      <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
          let data = google.visualization.arrayToDataTable([
            ["Membership Name", "Total Braintree Subscriptions"],
            <?php for ($key = 1; $key <= get_config('local_membership', 'noofmembershipplans'); $key++):
              $keycount = 0;
              foreach ($subscriptionDetails as $value) {
                if (is_array($value) && isset($value['planKey']) && $value['planKey'] == $key) {
                  $keycount++;
                }
              } ?>
              ["<?= get_config('local_membership', 'membershipname'.$key); ?>", <?= $keycount; ?>],
            <?php endfor; ?>
            ]);
          let options = {
            width: "100%",
            height: "450px",
          };
          let chart = new google.visualization.PieChart(document.getElementById("piechart"));
          chart.draw(data, options);
        }
      </script>
      <div id="chart_wrap">
        <div id="piechart"></div>
      </div>
    </div>
  </div>
  <div class="col-xl-5 col-md-12 col-sm-12">
    <div class="transaction-details">
      <h3>Transaction Details</h3>
      <div class="clearfix"></div>
      <div class="transaction-details-content-part">
        <?php if (empty($subscriptionDetails)): ?>
          <div class="cart-add-part">
            <div class="cart-add-quantity">
              <h4>Transactions details is empty.</h4>
            </div>
          </div>
        <?php else:
          foreach ($subscriptionDetails as $value):
            if (is_array($value) && isset($value['price']) && $value['price'] > 0): ?>
              <div class="transaction-details-in-con-part">
                <h4>
                  <p><?= isset($value['startDate']) ? $value['startDate'] : ''; ?></p>
                  <span><?= isset($value['method']) ? $value['method'] : ''; ?></span>
                </h4>
                <span><?= $value['price']; ?></span>
              </div>
            <?php endif;
          endforeach;
        endif; ?>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>

  <div class="col-xl-12 col-md-12 col-sm-12 adandonedcart-table">
    <div class="adandoned-cart-section">
      <h3>Membership(s) Status </h3>

      <div class="row mb-5">
        <div class="col-md-6 col-xl-6 col-sm-12 mt-2">
          <?php if (is_siteadmin()): ?>
            <a href="<?= $CFG->wwwroot . '/local/membership/api/patreon_handler.php'; ?>" class="btn btn-secondary w-100">Patreon Auth</a>
          <?php endif; ?>
        </div>
        <div class="col-md-6 col-xl-6 col-sm-12 mt-2">
          <div id="columnToggleDropdown" class="dropdown">
            <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="toggleColumnsButton" data-bs-toggle="dropdown" aria-expanded="false">
              Toggle Columns
            </button>
            <ul class="dropdown-menu" aria-labelledby="toggleColumnsButton">
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


      <div class="table-responsive">
        <table id="subscriptionsTable" class="table table-striped table-bordered" style="width:100%">
          <thead>
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
    </div>
  </div>
</div>

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

if(!$isadmin)
{
// Determine if user has manager role (check by role assignment)
$context = context_system::instance();
$roles = get_user_roles($context, $USER->id);
//$ismanager = false;
foreach ($roles as $role) {
    if ($role->shortname === 'manager') {
        $ismanager = true;
        break;
    }
}
}

if($ismanager || $isadmin)
{
require_once("membership_withdraw.php");
}

if($ismanager || $isadmin)
{
require_once("membership_withdraw.php");
require_once("membership_manual_subscription.php");
}


?>


<script type="text/javascript">

  const isAdmin = <?= $isadmin ? 'true' : 'false' ?>;
  const isManager = <?= $ismanager ? 'true' : 'false' ?>;
  let $jq = jQuery.noConflict();
  
  $jq(document).ready(function() {
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

    let cohorts = [];

    loadCohorts().done(function(data) {
      cohorts = data;

      let table = $jq('#subscriptionsTable').DataTable({
        "paging": true,

        "ajax": "<?= $CFG->wwwroot . '/local/membership/api/table_handler.php'; ?>",
        "columns": [
        { "data": "name" },
        { "data": "email" },
        { "data": "method" },
        { "data": "status" },
        { "data": "price" },
        { "data": "startDate" },
        { "data": "endDate" },
        { "data": "billingFrequency" },
        { "data": "cohortColumn" },
        { "data": "cohortIds", "visible": false },
        { "data": "cohort", "visible": false },
        {
          "data": "action",
          "render": function(data, type, row, meta) {
            let buttons = '<button type="button" data-id="' + row.id + '" class="btn btn-primary edit-btn"><i class="glyphicon glyphicon-edit"></i></button>';
            if (row.method === 'braintree' && row.status !== '0') {
              // buttons += '<button type="button" data-id="' + row.id + '" class="btn btn-primary confirm-cancel-action"><i class="glyphicon glyphicon-remove-circle"></i></button>';
              // buttons += '<a href="<?= $CFG->wwwroot.'/local/membership/unsub.php?id=' ?>' + row.id + '" class="btn btn-primary confirm-cancel-action"><i class="glyphicon glyphicon-remove-circle"></i></a>';

    //           if (isAdmin) {
    //   buttons += '<a href="<?= $CFG->wwwroot.'/local/membership/unsub.php?id=' ?>' + row.id + '" class="btn btn-primary confirm-cancel-action"><i class="glyphicon glyphicon-remove-circle"></i></a>';
    // } else if (isManager) {
    //   buttons += '<button type="button" data-id="' + row.id + '" class="btn btn-primary confirm-cancel-action"><i class="glyphicon glyphicon-remove-circle"></i></button>';
    // }
    
          if (isAdmin || isManager) {
       //buttons += '<a href="<?= $CFG->wwwroot.'/local/membership/unsub.php?id=' ?>' + row.id + '" class="btn btn-primary confirm-cancel-action"><i class="glyphicon glyphicon-remove-circle"></i></a>';
       buttons += '<button type="button" data-id="' + row.id + '" class="btn btn-primary confirm-cancel-action"><i class="glyphicon glyphicon-remove-circle"></i></button>';
    }
            }
            return `
            <td style="color: #ec5a5b; text-decoration: none;">
            <div class="btn-container">
            ${buttons}
            </div>
            </td>`;
          }
        }
        ],
        "buttons": [
        'copy', 'excel', 'pdf', 'print', 'searchBuilder',
          {
            text: 'Create Subscription',
            className: 'btn btn-primary',   
            action: function (e, dt, node, config) {
                          
              $('#subscriptionModalBackdrop').addClass('active');
              $('body').css('overflow', 'hidden');
            }
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
        "initComplete": function() {
                
                // Ubicar el contenedor de búsqueda
          const searchContainer = document.querySelector('#subscriptionsTable_filter .dt-search');
          if (searchContainer) {
            const label = searchContainer.querySelector('label');

            // Crear botón
            const btn = document.createElement('button');
            btn.id = 'miCustomBtn';
            btn.className = 'btn btn-success ml-2';
            btn.textContent = 'Create Subscription';

            // Insertar antes del label
            searchContainer.insertBefore(btn, label);

            // Evento del botón
            btn.addEventListener('click', function () {
              alert('Crear nueva suscripción');
              // aquí puedes redirigir o abrir modal
            });
          }
        }
      });


      let unsubscribeId = null; // Global var to store ID

$jq('#subscriptionsTable tbody').on('click', '.confirm-cancel-action', function () {
  debugger
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
              debugger
                if (data.status === 'ok') {
                    $jq('#membership_withdraw_backdrop, #membership_withdraw_modal').fadeIn(200);
                    $jq('.membership_withdraw_code_input').val('').first().focus();
                } else {
                    Swal.fire('Error', 'Failed to generate verification code.', 'error');
                }
            })
            .catch(error => {
              debugger
                console.error('Error:', error);
                Swal.fire('Error', 'An error occurred while generating code.', 'error');
            });

  // Show your custom modal
  // $jq('#membership_withdraw_backdrop, #membership_withdraw_modal').fadeIn(200);
  // $jq('.membership_withdraw_code_input').first().focus();
});

// Close modal
$jq('.membership_withdraw_close, #membership_withdraw_backdrop').on('click', function () {
  $jq('#membership_withdraw_backdrop, #membership_withdraw_modal').fadeOut(200);
});

      $jq('#membership_withdraw_proceed_btn').on('click', function () {
        debugger
        const code = $jq('.membership_withdraw_code_input').map(function () {
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
          debugger
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
      $('#membership_withdraw_request_btn').on('click', function() {
        alert('Requesting a new code...');
        debugger
        // TODO: Your AJAX code here
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
            debugger
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
            debugger
              console.error('Error:', error);
              Swal.fire('Error', 'An error occurred while generating code.', 'error');
          });
      });


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

      $jq('input.toggle-column').on('change', function (e) {
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

      $jq('#closeHeader').on('click', function() {
        $jq('#editCohortModal').modal('hide');
      });

      $jq('#closeFooter').on('click', function() {
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

        console.log({
          action: 'updateCohorts',
          subCohorts: selectedCohortIds,
          subReference: subReference,
          subPlatform: subPlatform,
          subEmail: subEmail,
          subCron: subCron
        });

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
            debugger
            console.log(response);
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
            Swal.fire('Saved', 'Subscription updated', 'success');
            // table.cell(rowIndex, 8).data(originalCohortNames).draw();
            // table.cell(rowIndex, 9).data(originalCohortIds).draw();
          }
        });

        $jq('#editCohortModal').modal('hide');
      });
    });



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
document.body.querySelectorAll('a.confirm-cancel-action').forEach(link => {
  link.addEventListener('click', showConfirmAction);
});




});



</script>

<?php

echo $OUTPUT->footer();