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
?>