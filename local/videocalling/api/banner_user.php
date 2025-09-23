<?php
// File: local/restrictionusers/api.php

/**
 * Local plugin "restrictionusers" - Simple API handler
 *
 * @package    local_restrictionusers
 * @copyright  2025 Deiker
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');

global $DB, $USER, $PAGE;

require_login();

$PAGE->set_context(context_system::instance());
$PAGE->set_title("API Restriction Users");
$PAGE->set_heading("API Restriction Users");
$PAGE->set_url(new moodle_url('/local/restrictionusers/api.php'));

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['userId']) || !isset($data['nivel_ingles']) || !isset($data['conversacion'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Parámetros incompletos']);
        exit;
    }

    $record = new stdClass();
    $record->user_id = $USER->id;  // Usuario logueado en Moodle
    $record->user_banner = $data['userId'];  // Valor recibido desde el frontend

    try {
        $DB->insert_record('restrictionusers', $record);
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $records = $DB->get_records('restrictionusers', ['user_id' => $USER->id]);
        $result = [];

        foreach ($records as $r) {
            $result[] = [
                'user_banner' => $r->user_banner
            ];
        }

        echo json_encode($result);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al obtener los datos: ' . $e->getMessage()]);
    }

} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
