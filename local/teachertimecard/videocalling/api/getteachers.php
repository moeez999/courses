<?php
// File: local/restrictionusers/api.php

require_once('../../../config.php');

global $DB, $PAGE;

require_login();

$PAGE->set_context(context_system::instance());
$PAGE->set_title("API Restriction Users");
$PAGE->set_heading("API Restriction Users");
$PAGE->set_url(new moodle_url('/local/restrictionusers/api.php'));

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // Obtén y valida el parámetro como entero (Moodle).
    $idplanificaction = required_param('idplanificaction', PARAM_INT);

    try {
        // Usa la API de Moodle y el nombre real de la tabla según tu install.xml:
        // NOTE: En tu install.xml la tabla se llama "assignamentteachearforclass".
        $records = $DB->get_records(
            'assignamentteachearforclass',
            ['idplanificaction' => $idplanificaction],
            'id ASC'
        );

        // $DB->get_records() devuelve un array indexado por id. Conviértelo a lista.
        echo json_encode(array_values($records));

    } catch (dml_exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al procesar: ' . $e->getMessage()]);
    }

} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
