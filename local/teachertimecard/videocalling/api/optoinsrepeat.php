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

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($_GET['idplanificaction'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Parámetros incompletos']);
        exit;
    }else{
        $idplanificaction = $_GET['idplanificaction'];
    }
    try {
        
        $sql = "SELECT *
                FROM {optionsrepeat} a
                where a.idplanificaction = :idplanificaction
                ";
        $params = ['idplanificaction' => $idplanificaction];
        $data = $DB->get_records_sql($sql, $params);

        // Guardar planificación y obtener ID
        
        echo json_encode($data);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al procesar: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
