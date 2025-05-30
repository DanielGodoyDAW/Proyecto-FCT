<?php
function ruta_absoluta($rutaRelativa) {
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $scriptDir = dirname($scriptName);
    return $scriptDir . '/' . ltrim($rutaRelativa, '/');
}