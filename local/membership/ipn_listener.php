<?php
@ini_set('display_errors', 1);
@ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('NO_MOODLE_COOKIES', true); // No carga completa de Moodle
require_once(__DIR__ . '/../../config.php'); // ✅ RUTA CORRECTA A config.php

// Log de prueba
file_put_contents(__DIR__ . '/ipn_debug.txt', "✅ IPN Listener iniciado: " . date('c') . "\n", FILE_APPEND);

// Leer datos brutos enviados por PayPal
$rawPostData = file_get_contents("php://input");
file_put_contents(__DIR__ . '/ipn_debug.txt', "📦 POST recibido:\n$rawPostData\n", FILE_APPEND);

// Respuesta básica a PayPal
echo "OK";
http_response_code(200);
exit;
