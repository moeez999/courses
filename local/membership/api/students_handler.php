<?php

/**
 * Local plugin "membership" - Upload CSV file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');
require_once($CFG->dirroot . '/local/membership/lib.php');

global $CFG, $DB, $PAGE, $USER;

$PAGE->set_context(context_system::instance());
$PAGE->set_title("Platform Students");
$PAGE->set_heading("Platform Students");
$PAGE->set_url($CFG->wwwroot.'/local/membership/api/students_handler.php');



$cssfilename = '/local/membership/css/style.css';
$PAGE->requires->css($cssfilename);
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

echo $OUTPUT->header();

$logfile = __DIR__ . '/duplicate_entries.log';

if (isset($_POST['delete_all'])) {
	$DB->delete_records('moodle_studentsv3');
	echo $OUTPUT->notification('All entries deleted successfully.', 'notifysuccess');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
	$csvFile = $_FILES['csv_file'];

	if ($csvFile['name']) {
		$allowedExtensions = ['csv'];
		$fileExtension = pathinfo($csvFile['name'], PATHINFO_EXTENSION);

		if (in_array($fileExtension, $allowedExtensions)) {
			if (($handle = fopen($csvFile['tmp_name'], 'r')) !== false) {
				fgetcsv($handle);
				while (($data = fgetcsv($handle, 1000, ",")) !== false) {
					$user_id = $data[0];
					$student_name = $data[1];
					$payment_status = $data[2];
					$wa_number = $data[3];
					$student_email = $data[4];
					$payer_email_verified = $data[5];
					$last_day_of_access = !empty($data[6]) ? date('Y-m-d', strtotime(str_replace('/', '-', $data[6]))) : null;
					$current_cohort = $data[7];
					$first_cohort = $data[8];
					$second_cohort = $data[9];
					$third_cohort = $data[10];
					$fourth_cohort = $data[11];
					if (empty($data[12])) {
						$fifth_cohort = '';  // o un valor predeterminado
					}else{
						$fifth_cohort = $data[12];  // o un valor predeterminado

					}
					
					if (empty($data[13])) {
						$sixth_cohort = '';  // o un valor predeterminado
					}else{
						$sixth_cohort = $data[13];  // o un valor predeterminado
					}
					if (preg_match('/[A-Z]/i', $user_id)) {
						$platform = 'paypal';
					} else {
						$platform = 'patreon';
					}

					$student_first_name = null;
					$student_last_name = null;
					if (!empty($student_name)) {
						$name_parts = explode(',', $student_name);
						$student_first_name = trim($name_parts[0]);
						if (isset($name_parts[1])) {
							$student_last_name = trim($name_parts[1]);
						}
					}

					if ($DB->record_exists('moodle_studentsv3', ['user_id' => $user_id])) {
						file_put_contents($logfile, "Duplicate entry: $user_id\n", FILE_APPEND);
						continue;
					}

					try {
						$record_id = $DB->insert_record('moodle_studentsv3', (object)[
							'user_id' => $user_id,
							'platform' => $platform,
							'student_first_name' => $student_first_name,
							'student_last_name' => $student_last_name,
							'payment_status' => $payment_status,
							'wa_number' => $wa_number,
							'student_email' => $student_email,
							'payer_email_verified' => $payer_email_verified,
							'last_day_of_access' => $last_day_of_access,
							'current_cohort' => $current_cohort,
							'first_cohort' => $first_cohort,
							'second_cohort' => $second_cohort,
							'third_cohort' => $third_cohort,
							'fourth_cohort' => $fourth_cohort,
							'fifth_cohort' => $fifth_cohort,
							'sixth_cohort' => $sixth_cohort
						], true);

						if ($record_id === false) {
							throw new Exception('Error inserting record into moodle_studentsv3 table.');
						}
					} catch (dml_write_exception $e) {
						echo $OUTPUT->notification('Error writing to database: ' . $e->getMessage(), 'notifyproblem');
					} catch (Exception $e) {
						echo $OUTPUT->notification('General error: ' . $e->getMessage(), 'notifyproblem');
					}
				}

				fclose($handle);
				echo $OUTPUT->notification('CSV file uploaded and data inserted successfully.', 'notifysuccess');
			} else {
				echo $OUTPUT->notification('Error opening the file.', 'notifyproblem');
			}
		} else {
			echo $OUTPUT->notification('Invalid file type. Please upload a CSV file.', 'notifyproblem');
		}
	} else {
		echo $OUTPUT->notification('Please select a file to upload.', 'notifyproblem');
	}
}

if (isset($_POST['createUser'])) {
    $password = 'Latingles1@'; // La contraseña que deseas hashear

    // Hashear la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $datosStudent = $DB->get_records('moodle_studentsv3');
    $datosCohort = $DB->get_records('cohort');

    foreach ($datosStudent as $student) {
        $control = false;
        $existingUser = $DB->get_record('user', ['username' => $student->student_email]);

        if (!$existingUser) {
			 
            $userCreate = $DB->insert_record('user', (object)[
                'auth' => 'manual',
                'confirmed' => 1,
                'policyagreed' => 0,
                'deleted' => 0,
                'suspended' => 0,
                'mnethostid' => 1,
                'username' => $student->student_email,
                'password' => $hashedPassword,
                'idnumber' => 'S-'.uniqid(),
                'firstname' => $student->student_first_name,
                'lastname' => $student->student_last_name ? $student->student_last_name : '',
                'email' => $student->student_email,
                'emailstop' => 0,
                'phone1' => $student->wa_number ? $student->wa_number : '',
                'phone2' => '',
                'institution' => '',
                'department' => '',
                'address' => '',
                'city' => '',
                'country' => '',
                'lang' => 'en',
                'calendartype' => 'gregorian',
                'theme' => '',
                'timezone' => 99,
                'firstaccess' => 0,
                'lastaccess' => 0,
                'lastlogin' => 0,
                'currentlogin' => 0,
                'lastip' => 0,
                'secret' => '',
                'picture' => 0,
                'description' => '',
                'descriptionformat' => 1,
                'mailformat' => 1,
                'maildigest' => 0,
                'maildisplay' => 2,
                'autosubscribe' => 1,
                'trackforums' => 0,
                'timecreated' => time(),
                'timemodified' => time(),
                'trustbitmask' => 0,
                'imagealt' => '',
                'lastnamephonetic' => '',
                'firstnamephonetic' => '',
                'middlename' => '',
                'alternatename' => '',
                'gender' => 'unknown',
                'moodlenetprofile' => null,
            ], true);

            // Verifica si la creación fue exitosa
            if (!$userCreate) {
                error_log('Error creando usuario: ' . print_r($student, true));
                continue; // Salta al siguiente estudiante
            }
			$createHistory = $DB->insert_record('history_cohort2',(object)[
				'idUser' => $userCreate, // Usa el ID correcto
				'oneCohort' => $student->first_cohort,
				'twoCohort' => $student->second_cohort,
				'threeCohort' => $student->third_cohort,
				'fouthCohort' => $student->fourth_cohort,
				'fifthCohort' => $student->fifth_cohort,
				'sixthCohort' => $student->sixth_cohort,
			]);
			$createPayment = $DB->insert_record('user_info_data', (object)[
				'fieldid' => 1,
				'userid' => $userCreate, // Usa el ID correcto
				'data' => $student->user_id,
				'dataformat'=> 0
			], true);
            foreach ($datosCohort as $cohort) {
                if ($student->current_cohort == $cohort->idnumber) {
                    $control = true; // Cambia el control a true si se cumple la condición
                    $asignedCohort = $DB->insert_record('cohort_members', (object)[
                        'cohortid' => $cohort->id,
                        'userid' => $userCreate, // Usa el ID correcto
                        'middlename' => '',
                    ], true);
                    break; // Detiene el bucle interno
                }
            }

            if (!$control) {
                $existingCohort = $DB->get_record('cohort', ['idnumber' => $student->current_cohort]);
                if (!$existingCohort) {
					$abreviacion =  substr($student->current_cohort, 0, 2); // Cambia este valor para probar otras abreviaciones
					$numero =  substr($student->current_cohort, 2, 2); // Cambia este valor para probar otras abreviaciones

					switch ($abreviacion) {
						case "AL":
							$estado = "Alabama ". $numero;
							break;
						case "AK":
							$estado = "Alaska ". $numero;
							break;
						case "AZ":
							$estado = "Arizona ". $numero;
							break;
						case "AR":
							$estado = "Arkansas ". $numero;
							break;
						case "CA":
							$estado = "California ". $numero;
							break;
						case "CO":
							$estado = "Colorado ". $numero;
							break;
						case "CT":
							$estado = "Connecticut ". $numero;
							break;
						case "DE":
							$estado = "Delaware ". $numero;
							break;
						case "FL":
							$estado = "Florida ". $numero;
							break;
						case "GA":
							$estado = "Georgia ". $numero;
							break;
						case "HI":
							$estado = "Hawái ". $numero;
							break;
						case "ID":
							$estado = "Idaho ". $numero;
							break;
						case "IL":
							$estado = "Illinois ". $numero;
							break;
						case "IN":
							$estado = "Indiana ". $numero;
							break;
						case "IA":
							$estado = "Iowa ". $numero;
							break;
						case "KS":
							$estado = "Kansas ". $numero;
							break;
						case "KY":
							$estado = "Kentucky ". $numero;
							break;
						case "LA":
							$estado = "Luisiana ". $numero;
							break;
						case "ME":
							$estado = "Maine ". $numero;
							break;
						case "MD":
							$estado = "Maryland ". $numero;
							break;
						case "MA":
							$estado = "Massachusetts ". $numero;
							break;
						case "MI":
							$estado = "Michigan ". $numero;
							break;
						case "MN":
							$estado = "Minnesota ". $numero;
							break;
						case "MS":
							$estado = "Misisipi ". $numero;
							break;
						case "MO":
							$estado = "Misuri ". $numero;
							break;
						case "MT":
							$estado = "Montana ". $numero;
							break;
						case "NE":
							$estado = "Nebraska ". $numero;
							break;
						case "NV":
							$estado = "Nevada ". $numero;
							break;
						case "NH":
							$estado = "Nueva Hampshire ". $numero;
							break;
						case "NJ":
							$estado = "Nueva Jersey ". $numero;
							break;
						case "NM":
							$estado = "Nuevo México ". $numero;
							break;
						case "NY":
							$estado = "Nueva York ". $numero;
							break;
						case "NC":
							$estado = "Carolina del Norte ". $numero;
							break;
						case "ND":
							$estado = "Dakota del Norte ". $numero;
							break;
						case "OH":
							$estado = "Ohio ". $numero;
							break;
						case "OK":
							$estado = "Oklahoma ". $numero;
							break;
						case "OR":
							$estado = "Oregón ". $numero;
							break;
						case "PA":
							$estado = "Pennsylvania ". $numero;
							break;
						case "RI":
							$estado = "Rhode Island ". $numero;
							break;
						case "SC":
							$estado = "Carolina del Sur ". $numero;
							break;
						case "SD":
							$estado = "Dakota del Sur ". $numero;
							break;
						case "TN":
							$estado = "Tennessee ". $numero;
							break;
						case "TX":
							$estado = "Texas ". $numero;
							break;
						case "UT":
							$estado = "Utah ". $numero;
							break;
						case "VT":
							$estado = "Vermont ". $numero;
							break;
						case "VA":
							$estado = "Virginia ". $numero;
							break;
						case "WA":
							$estado = "Washington ". $numero;
							break;
						case "WV":
							$estado = "West Virginia ". $numero;
							break;
						case "WI":
							$estado = "Wisconsin ". $numero;
							break;
						case "WY":
							$estado = "Wyoming ". $numero;
							break;
						default:
							$estado = "Abreviación no encontrada " . $abreviacion;
					}

                    $cohortCreate = $DB->insert_record('cohort', (object)[
                        'contextid' => 1,
                        'name' => $estado,
                        'shortname' => substr($student->current_cohort, 0, 4),
                        'idnumber' => $student->current_cohort,
                        'description' => '',
                        'descriptionformat' => 1,
                        'enabled' => 1,
                        'visible' => 1,
                        'component' => '',
                        'timecreated' => time(),
                        'timemodified' => time(),
                        'theme' => '',
                        'cohortmonday' => 0,
                        'cohorttuesday' => 0,
                        'cohortwednesday' => 0,
                        'cohortthursday' => 0,
                        'cohortfriday' => 0,
                        'cohorthours' => 0,
                        'cohortminutes' => 0,
                        'cohorttutormonday' => 0,
                        'cohorttutortuesday' => 0,
                        'cohorttutorwednesday' => 0,
                        'cohorttutorthursday' => 0,
                        'cohorttutorfriday' => 0,
                        'cohorttutorhours' => 0,
                        'cohorttutorminutes' => 0,
                        'cohortmainteacher' => 0,
                        'cohortguideteacher' => 0,
                        'startdate' => 0,
                        'enddate' => 0,
                    ], true);

                    // Verifica si la creación del cohorte fue exitosa
                    if (!$cohortCreate) {
                        error_log('Error creando cohorte para el estudiante: ' . print_r($student, true));
                        continue; // Salta al siguiente estudiante
                    }

                    $asignedCohort = $DB->insert_record('cohort_members', (object)[
                        'cohortid' => $cohortCreate, // Usa el ID correcto
                        'userid' => $userCreate, // Usa el ID correcto
                        'timeadded' => time(),
                    ], true);
                } else {
                    $asignedCohort = $DB->insert_record('cohort_members', (object)[
                        'cohortid' => $existingCohort->id, // Usa el ID correcto
                        'userid' => $userCreate, // Usa el ID correcto
                        'timeadded' => time(),
                    ], true);
                }
            }
        }
    }
}


if (isset($_POST['updateHistory'])) {

	
$sql = "SELECT * FROM {moodle_studentsv3}";
$datosStudent = $DB->get_records_sql($sql);

foreach ($datosStudent as $student) {
	$existingUser = $DB->get_record('user', ['username' => $student->student_email]);
    if($existingUser){
		$cohortHistoryFound = $DB->get_record('user', ['id' => $existingUser->id]);
		if($cohortHistoryFound){
			$asignedCohort = $DB->update_record('history_cohort2',
			[
				'id'=> $cohortHistoryFound->id,
				'idUser' => $existingUser->id, // Usa el ID correcto
				'oneCohort' => $student->first_cohort,
				'twoCohort' => $student->second_cohort,
				'threeCohort' => $student->third_cohort,
				'fouthCohort' => $student->fourth_cohort,
				'fifthCohort' => "$student->fifth_cohort",
				'sixthCohort' => $student->sixth_cohort,
			]);
		}
	}
	
}
	
}


// if (isset($_POST['deleteUser'])) {

	
// 	$sql = "SELECT * FROM {moodle_studentsv3}";
// 	$datosStudent = $DB->get_records_sql($sql);
	
// 	foreach ($datosStudent as $student) {
// 		// Correct the query to match the email, not the id
// 		$sql = "SELECT * FROM {user} WHERE email = :email"; // Use email instead of id
// 		$params = ['email' => $student->student_email]; // Pass the email as parameter
// 		$existingUser = $DB->get_records_sql($sql, $params);
		
// 		if ($existingUser) {
	
// 			// Assuming we are interested in the first matching user (if multiple exist)
// 			$user = reset($existingUser); // Get the first element of the array
// 			$userId = $user->id; // Get the user's ID
	
// 			// Now, use the correct user ID in the delete operations
// 			$DB->delete_records('cohort_members', [
// 				'userid' => $userId, // Use the user's ID here
// 			]);
// 			$DB->delete_records('user', [
// 				'id' => $userId, // Use the user's ID here
// 			]);
			
// 			$DB->delete_records('history_cohort2', [
// 				'idUser' => $userId, // Use the user's ID here
// 			]);
// 		} else {
// 		}
// 	}
		
// 	}


?>

<form action="" name="createUser" method="POST">
	<button type="submit" name="createUser" class="btn btn-primary">Crear Usuarios</button>
</form>
<button id="openModal" class="btn btn-primary">Upload CSV</button>

<form enctype="multipart/form-data" action="" method="POST" class="mform"></form>
<div id="uploadModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="uploadModalLabel">Upload CSV File</h5>
				<button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form enctype="multipart/form-data" action="" method="POST" class="mform">
					<fieldset class="clearfix">
						<div class="fcontainer">
							<div class="fitem fitem_ftextarea">
								<div class="fitemtitle"><label for="csv_file">Choose CSV file to upload:</label></div>
								<div class="felement ftextarea">
									<input type="file" name="csv_file" id="csv_file" class="form-control" required>
								</div>
							</div>
							<div class="fitem fitem_actionbuttons mt-2">
								<div class="felement fgroup">
									<input type="submit" value="Upload CSV" class="btn btn-primary">
								</div>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>






<hr>

<h2>Existing Entries in moodle_studentsv3</h2>

<table id="studentsTable">
	<thead>
		<tr>
			<th>User ID</th>
			<th>Platform</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Payment Status</th>
			<th>WA Number</th>
			<th>Student Email</th>
			<th>Payer Email Verified</th>
			<th>Last Day of Access</th>
			<th>Current Cohort</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$students = $DB->get_records('moodle_studentsv3');
		if ($students) {
			foreach ($students as $student) {
				echo '<tr>';
				echo '<td>' . $student->user_id . '</td>';
				echo '<td>' . $student->platform . '</td>';
				echo '<td>' . $student->student_first_name . '</td>';
				echo '<td>' . $student->student_last_name . '</td>';
				echo '<td>' . $student->payment_status . '</td>';
				echo '<td>' . $student->wa_number . '</td>';
				echo '<td>' . $student->student_email . '</td>';
				echo '<td>' . $student->payer_email_verified . '</td>';
				echo '<td>' . $student->last_day_of_access . '</td>';
				echo '<td>' . $student->current_cohort . '</td>';
				echo '</tr>';
			}
		}
		?>
	</tbody>
</table>

<form action="" method="POST">
	<input type="hidden" name="delete_all" value="1">
	<input type="submit" value="Delete All Entries" class="btn btn-danger">
</form>

<script type="text/javascript">
	let $jq = jQuery.noConflict();

	$jq(document).ready(function() {
		$jq('#openModal').on('click', function() {
			$jq('#uploadModal').modal('show');
		});
		$jq('#closeModal').on('click', function() {
			$jq('#uploadModal').modal('hide');
		});
		$jq('#studentsTable').DataTable({
			columnDefs: [{
				"defaultContent": "-",
				"targets": "_all"
			}],
			"paging": true,
			"buttons": [
			'copy', 'excel', 'pdf', 'print', 'searchBuilder'
			],
			"order": [],
			"dom": 'Blfrtip',
			"fixedHeader": true,
			"colReorder": true,
			"rowReorder": true,
			"responsive": true,
			"searchBuilder": true,
			"searchPanes": true,
			"select": true
		});
	});
</script>



<?php
echo $OUTPUT->footer();
