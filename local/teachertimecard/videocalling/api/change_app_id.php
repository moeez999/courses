<?php

/**
 * Local plugin "videocalling" - Selección de APP-ID
 *
 * @package    local_videocalling
 * @copyright  2024 Deiker, Venezuela
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 o posterior
 */

global $CFG, $DB, $PAGE, $USER, $OUTPUT;

require_once('../../config.php');
require_once($CFG->dirroot . '/local/videocalling/lib.php');

require_login();

$PAGE->set_context(context_system::instance());
$PAGE->set_title('Cambiar APP-ID');
$PAGE->set_url(new moodle_url('/local/videocalling/selected.php'));
$PAGE->requires->css(new moodle_url('/local/videocalling/css/selected.css?v=' . time()), true);
$PAGE->requires->js(new moodle_url('https://code.jquery.com/jquery-3.6.0.min.js'), true);
$PAGE->requires->js(new moodle_url('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'), true);
$PAGE->requires->js(new moodle_url('https://cdn.jsdelivr.net/npm/sweetalert2@11'), true);

$nodeApiUrl = 'http://161.97.86.173:3000/appid/change'; // Endpoint API Node

// ========================
// Verificar permisos
// ========================
if (!is_siteadmin($USER->id) && !has_capability('moodle/role:assign', context_system::instance())) {
    redirect(new moodle_url('/local/videocalling'), 'No tienes permisos de administrador del sitio.', null, \core\output\notification::NOTIFY_ERROR);
}

// ========================
// POST: Cambiar APP-ID
// ========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_appid'])) {
    $selected_appid = required_param('selected_appid', PARAM_INT);

    // Buscar el APP-ID seleccionado
    $record = $DB->get_record('selectedappid', ['id' => $selected_appid], '*', MUST_EXIST);

    // 1. Desmarcar todos los registros
    $DB->execute("UPDATE {selectedappid} SET selected = 0");

    // 2. Marcar el seleccionado
    $DB->execute("UPDATE {selectedappid} SET selected = 1 WHERE id = ?", [$selected_appid]);

    // 3. Llamar a la API Node para cambiar el APP-ID
    $payload = json_encode(['newAppId' => $record->appid]);
    $ch = curl_init($nodeApiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode == 200) {
        redirect(new moodle_url('/local/videocalling/selected.php'), 'APP-ID cambiado correctamente.', null, \core\output\notification::NOTIFY_SUCCESS);
    } else {
        redirect(new moodle_url('/local/videocalling/selected.php'), 'Error al cambiar APP-ID en la API Node.', null, \core\output\notification::NOTIFY_ERROR);
    }
}

// ========================
// Obtener todos los APP-ID
// ========================
$appids = $DB->get_records('selectedappid', null, 'id ASC');

echo $OUTPUT->header();
?>

<div class="container mt-4">
    <h2 class="table-title">Seleccionar APP-ID</h2>
    <table class="table table-striped table-bordered">
        <thead class="thead-blue">
            <tr>
                <th>#</th>
                <th>APP-ID</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $index = 1;
        foreach ($appids as $app): ?>
            <tr>
                <td><?php echo $index++; ?></td>
                <td><?php echo s($app->appid); ?></td>
                <td>
                    <?php if ($app->selected): ?>
                        <span class="badge badge-success">Seleccionado</span>
                    <?php else: ?>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="selected_appid" value="<?php echo $app->id; ?>">
                            <button type="submit" class="btn btn-primary btn-sm">Seleccionar</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php echo $OUTPUT->footer(); ?>
