<?php
// Archivo con funciones útiles para gestionar rutas absolutas y relativas del proyecto.

function ruta_absoluta($rutaRelativa) {
    $scriptName = $_SERVER['SCRIPT_NAME']; // Obtiene la ruta del script actual.
    $scriptDir = dirname($scriptName);     // Obtiene el directorio del script actual.
    return $scriptDir . '/' . ltrim($rutaRelativa, '/'); // Devuelve ruta absoluta.
}

function ruta_relativa($rutaRelativa) {
    return '/Proyecto-FCT/Codigo/' . ltrim($rutaRelativa, '/'); // Devuelve ruta relativa al proyecto.
}

// Formatea una fecha al estilo 
function formatearFecha($fecha) {
    $formatter = new \IntlDateFormatter(
        'es_ES',
        \IntlDateFormatter::LONG,
        \IntlDateFormatter::NONE,
        'Europe/Madrid',
        \IntlDateFormatter::GREGORIAN,
        "d 'de' MMMM 'de' yyyy"
    );
    return $formatter->format(new DateTime($fecha));
}

// Genera el enlace de WhatsApp a partir de un número completo
function formatearWhatsApp($telefonoCompleto) {
    preg_match('/^(\+\d+)\s*(.*)$/', $telefonoCompleto, $matches);
    $extension = $matches[1] ?? '+34';
    $telefono = $matches[2] ?? '';
    return 'https://wa.me/' . $extension . $telefono;
}
?>