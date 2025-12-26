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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Validación base (misma estructura que en create)
    if (
        !isset($data['startTimeEvent']) ||
        !isset($data['finishTimeEvent']) ||
        !isset($data['cohorts']) ||
        !isset($data['teachers']) ||
        !isset($data['color'])
    ) {
        http_response_code(400);
        echo json_encode(['error' => 'Parámetros incompletos']);
        exit;
    }

    // Parseo de fechas (ISO Z → timestamp UTC)
    try {
        $startDate = new DateTime($data['startTimeEvent'], new DateTimeZone('UTC'));
        $finishDate = new DateTime($data['finishTimeEvent'], new DateTimeZone('UTC'));
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(['error' => 'Formato de fecha inválido']);
        exit;
    }

    if ($startDate > $finishDate) {
        http_response_code(400);
        echo json_encode(['error' => 'La fecha de inicio no puede ser mayor que la de fin']);
        exit;
    }

    // Campos comunes
    $record = new stdClass();
    $record->startdate = $startDate->getTimestamp();
    $record->finishdate = $finishDate->getTimestamp();
    $record->recurrent = !empty($data['repeat']['active']) ? 1 : 0;
    $record->color = $data['color'];

    // Transacción para consistencia
    $transaction = $DB->start_delegated_transaction();

    try {
        $isEdit = !empty($data['edit']);
        $planificationId = null;

        if ($isEdit) {
            // Requiere id
            if (empty($data['id'])) {
                throw new moodle_exception('Falta el ID para editar');
            }

            $planificationId = (int)$data['id'];

            // Actualizar planification
            $record->id = $planificationId;
            $DB->update_record('planificationclass', $record);

            // Sincronizar cohorts: borro todos los de esa planificación y re-inserto los recibidos
            $DB->delete_records('assignamentcohortforclass', ['idplanificaction' => $planificationId]);
            if (is_array($data['cohorts'])) {
                foreach ($data['cohorts'] as $cohortId) {
                    $assign = new stdClass();
                    $assign->idplanificaction = $planificationId;
                    $assign->idcohort = $cohortId;
                    $DB->insert_record('assignamentcohortforclass', $assign);
                }
            }

            // Sincronizar teachers: borro todos y re-inserto los recibidos
            $DB->delete_records('assignamentteachearforclass', ['idplanificaction' => $planificationId]);
            if (is_array($data['teachers'])) {
                foreach ($data['teachers'] as $teacherId) {
                    $assign = new stdClass();
                    $assign->idplanificaction = $planificationId;
                    $assign->iduserteacher = $teacherId;
                    $DB->insert_record('assignamentteachearforclass', $assign);
                }
            }

            // Opciones de repetición
            $DB->delete_records('optionsrepeat', ['idplanificaction' => $planificationId]);
            if (!empty($data['repeat']['active'])) {
                $repeat = new stdClass();
                $repeat->idplanificaction = $planificationId;

                // Mapear días de la semana
                $days = [
                    'monday' => 'mon',
                    'tuesday' => 'tue',
                    'wednesday' => 'wed',
                    'thursday' => 'thu',
                    'friday' => 'fri',
                    'saturday' => 'sat',
                    'sunday' => 'sun'
                ];

                foreach ($days as $dbField => $jsonKey) {
                    $repeat->$dbField = !empty($data['repeat']['weekDays'][$jsonKey]) ? 1 : 0;
                }

                // Campos base/opcionales
                $repeat->never = 0;
                $repeat->repeaton = null;
                $repeat->repeatafter = null;
                $repeat->repeatevery = isset($data['repeat']['repeatEvery']) ? (int)$data['repeat']['repeatEvery'] : null;
                $repeat->type = isset($data['repeat']['type']) ? $data['repeat']['type'] : null;

                $end = $data['repeat']['end'] ?? null;
                if ($end === 'Never') {
                    $repeat->never = 1;
                } elseif ($end === 'date' && !empty($data['repeat']['repeatOn'])) {
                    try {
                        $onDate = new DateTime($data['repeat']['repeatOn'], new DateTimeZone('UTC'));
                        $repeat->repeaton = $onDate->getTimestamp();
                    } catch (Exception $e) {
                        // ignora fecha inválida y deja null
                    }
                } elseif (is_numeric($end) && strlen((string)$end) <= 2) {
                    $repeat->repeatafter = (int)$end;
                }

                $DB->insert_record('optionsrepeat', $repeat);
            }

            $transaction->allow_commit();
            echo json_encode(['status' => 'success', 'mode' => 'edit', 'planificationId' => $planificationId]);
            exit;

        } else {
            // CREATE (comportamiento original)
            $planificationId = $DB->insert_record('planificationclass', $record);

            // Cohorts
            if (is_array($data['cohorts'])) {
                foreach ($data['cohorts'] as $cohortId) {
                    $assign = new stdClass();
                    $assign->idplanificaction = $planificationId;
                    $assign->idcohort = $cohortId;
                    $DB->insert_record('assignamentcohortforclass', $assign);
                }
            }

            // Teachers
            if (is_array($data['teachers'])) {
                foreach ($data['teachers'] as $teacherId) {
                    $assign = new stdClass();
                    $assign->idplanificaction = $planificationId;
                    $assign->iduserteacher = $teacherId;
                    $DB->insert_record('assignamentteachearforclass', $assign);
                }
            }

            // Repeat options
            if (!empty($data['repeat']['active'])) {
                $repeat = new stdClass();
                $repeat->idplanificaction = $planificationId;

                $days = [
                    'monday' => 'mon',
                    'tuesday' => 'tue',
                    'wednesday' => 'wed',
                    'thursday' => 'thu',
                    'friday' => 'fri',
                    'saturday' => 'sat',
                    'sunday' => 'sun'
                ];
                foreach ($days as $dbField => $jsonKey) {
                    $repeat->$dbField = !empty($data['repeat']['weekDays'][$jsonKey]) ? 1 : 0;
                }

                $repeat->never = 0;
                $repeat->repeaton = null;
                $repeat->repeatafter = null;
                $repeat->repeatevery = isset($data['repeat']['repeatEvery']) ? (int)$data['repeat']['repeatEvery'] : null;
                $repeat->type = isset($data['repeat']['type']) ? $data['repeat']['type'] : null;

                $end = $data['repeat']['end'] ?? null;
                if ($end === 'Never') {
                    $repeat->never = 1;
                } elseif ($end === 'date' && !empty($data['repeat']['repeatOn'])) {
                    try {
                        $onDate = new DateTime($data['repeat']['repeatOn'], new DateTimeZone('UTC'));
                        $repeat->repeaton = $onDate->getTimestamp();
                    } catch (Exception $e) {
                        // ignora fecha inválida
                    }
                } elseif (is_numeric($end) && strlen((string)$end) <= 2) {
                    $repeat->repeatafter = (int)$end;
                }

                $DB->insert_record('optionsrepeat', $repeat);
            }

            $transaction->allow_commit();
            echo json_encode(['status' => 'success', 'mode' => 'create', 'planificationId' => $planificationId]);
            exit;
        }

    } catch (Exception $e) {
        $transaction->rollback($e);
        http_response_code(500);
        echo json_encode([
            'error' => 'Error al procesar: ' . $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ]);
        exit;
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {

    try {
        $sql = "SELECT 
            p.id, p.startdate, p.finishdate, p.recurrent, p.color,
            o.idplanificaction, o.monday, o.tuesday, o.wednesday, o.thursday,
            o.friday, o.saturday, o.sunday, o.never, o.repeaton, o.type, o.repeatafter, o.repeatevery
        FROM {planificationclass} p
        LEFT JOIN {optionsrepeat} o
            ON p.id = o.idplanificaction";
        $data = $DB->get_records_sql($sql);

        echo json_encode($data);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al procesar: ' . $e->getMessage()]);
    }

} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
