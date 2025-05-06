<?php
function cargarEnv($ruta)
{
    if (!file_exists($ruta)) {
        error_log("⚠️ Archivo de entorno no encontrado: $ruta");
        return;
    }

    $lineas = file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lineas as $linea) {
        $linea = trim($linea);

        // Saltar comentarios o líneas vacías
        if ($linea === '' || str_starts_with($linea, '#')) {
            continue;
        }

        // Separar clave y valor
        if (strpos($linea, '=') !== false) {
            list($clave, $valor) = explode('=', $linea, 2);

            $clave = trim($clave);
            $valor = trim($valor, " \t\n\r\0\x0B\"'"); // quita comillas si hay

            $_ENV[$clave] = $valor;
        }
    }
}
