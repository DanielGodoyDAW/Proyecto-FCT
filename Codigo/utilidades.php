<?php
function ruta_absoluta($rutaRelativa) {
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $scriptDir = dirname($scriptName);
    return $scriptDir . '/' . ltrim($rutaRelativa, '/');
}

function ruta_relativa($rutaRelativa) {
    return '/Proyecto-FCT/Codigo/' . ltrim($rutaRelativa, '/');
}

?>