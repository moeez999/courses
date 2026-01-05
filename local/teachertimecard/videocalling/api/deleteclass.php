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

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!is_array($data) || !isset($data['idplanificaction']) || !is_numeric($data['idplanificaction'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Parámetro "idplanificaction" inválido']);
        exit;
    }

    try {
        $id = (int)$data['idplanificaction'];

        // Primero eliminar de assignamentcohortforclass
        $DB->delete_records('assignamentcohortforclass', ['idplanificaction' => $id]);
        $DB->delete_records('assignamentteachearforclass', ['idplanificaction' => $id]);
        $DB->delete_records('optionsrepeat', ['idplanificaction' => $id]);

        // Luego eliminar de planificationclass
        $DB->delete_records('planificationclass', ['id' => $id]);

        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al procesar: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
