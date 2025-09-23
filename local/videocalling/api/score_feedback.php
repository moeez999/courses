<?php
// File: local/api/score_feedback.php

/**
 * Local plugin "score_feedback" - Simple API handler
 *
 * @package    local_score_feedback
 * @copyright  2025 Deiker
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');

global $DB, $USER, $PAGE;

require_login();

$PAGE->set_context(context_system::instance());
$PAGE->set_title("API Restriction Users");
$PAGE->set_heading("API Restriction Users");
$PAGE->set_url(new moodle_url('/local/api/score_feedback.php'));

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = required_param('userId', PARAM_INT);

    $record = $DB->get_record('videocalling_user_score', ['user_id' => $userId]);

    if ($record) {
        $score_total   = (int)$record->score_total;
        $num_feedbacks = (int)$record->num_feedbacks;
        $promedio = $num_feedbacks > 0 ? round($score_total / $num_feedbacks, 2) : 0;
    } else {
        $score_total = 0;
        $num_feedbacks = 0;
        $promedio = 0;
    }

    echo json_encode([
        'status' => 'ok',
        'userId' => $userId,
        'score_total' => $score_total,
        'num_feedbacks' => $num_feedbacks,
        'score_promedio' => $promedio
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Espera JSON: { userId: number, score: number }
    $data = json_decode(file_get_contents('php://input'), true);

    if (!is_array($data) || !isset($data['userId']) || !isset($data['score'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Payload inválido. Se requiere { userId, score }']);
        exit;
    }

    $userId = (int)$data['userId'];
    $score  = (int)$data['score'];
    $now    = time();

    // Verifica si el usuario ya tiene una entrada
    $record = $DB->get_record('videocalling_user_score', ['user_id' => $userId]);

    if ($record) {
        // Actualiza el score acumulado
        $record->score_total   = (int)$record->score_total + $score;
        $record->num_feedbacks = (int)$record->num_feedbacks + 1;
        $record->updated_at    = date('Y-m-d H:i:s', $now);
        $DB->update_record('videocalling_user_score', $record);
    } else {
        // Crea una nueva entrada
        $newrecord = new stdClass();
        $newrecord->user_id       = $userId;
        $newrecord->score_total   = $score;
        $newrecord->num_feedbacks = 1;
        $newrecord->updated_at    = date('Y-m-d H:i:s', $now);
        $DB->insert_record('videocalling_user_score', $newrecord);
    }

    // Devuelve el estado actual tras actualizar
    $updated = $DB->get_record('videocalling_user_score', ['user_id' => $userId]);
    $score_total   = (int)$updated->score_total;
    $num_feedbacks = (int)$updated->num_feedbacks;
    $promedio = $num_feedbacks > 0 ? round($score_total / $num_feedbacks, 2) : 0;

    echo json_encode([
        'status' => 'ok',
        'userId' => $userId,
        'score_total' => $score_total,
        'num_feedbacks' => $num_feedbacks,
        'score_promedio' => $promedio
    ]);
    exit;
}

// Método no permitido
http_response_code(405);
echo json_encode(['error' => 'Método no permitido']);
