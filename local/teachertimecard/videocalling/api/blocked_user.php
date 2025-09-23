<?php
// File: local/restrictionusers/api.php

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

    if (!isset($data['userId']) || !isset($data['permanent'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Parámetros incompletos']);
        exit;
    }

    $record = new stdClass();
    $record->user_id = (string)$data['userId']; // ID del usuario baneado (string por estructura de tabla)
    $record->startdate = date('Y-m-d H:i:s');

    if ($data['permanent'] === true) {
        $record->finishdate = null;
    } else {
        $finish = new DateTime();
        $finish->modify('+1 day');
        $record->finishdate = $finish->format('Y-m-d H:i:s');
    }
    $recordVerify = $DB->get_record('bannerusers', ['user_id' => $data['userId']]);
    if($recordVerify){
        echo json_encode(['status' => 'exist']);
        exit;

    }
    try {
        $DB->insert_record('bannerusers', $record);
        echo json_encode(['status' => 'success']);
        exit;

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al guardar el ban: ' . $e->getMessage()]);
        exit;

    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $record = $DB->get_record('bannerusers', ['user_id' => (string)$USER->id]);

        if (!$record) {
            echo json_encode(['status' => false]);
            exit;
        }

        if ($record->finishdate === null) {
            echo json_encode(['status' => true]);
            exit;
        }

        $now = new DateTime();
        $finish = new DateTime($record->finishdate);

        if ($now > $finish) {
            $DB->delete_records('bannerusers', ['id' => $record->id]);
            echo json_encode(['status' => false]);
        } else {
            echo json_encode(['status' => true]);
        }

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al consultar la base de datos: ' . $e->getMessage()]);
    }

} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
