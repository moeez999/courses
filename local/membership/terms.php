<?php
// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Content-Type: text/html; charset=utf-8");

// Load and display external content
$url = 'https://latingles.com/landing/latingles-terms-and-conditions/';
$html = file_get_contents($url);

if ($html === false) {
    echo "<h2>Error: No se pudo cargar el contenido de los términos.</h2>";
    exit;
}

// Optionally, clean up or adjust links inside the HTML (optional)

// Output it
echo $html;
