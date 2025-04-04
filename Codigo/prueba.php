<?php
require_once './conexion/conexion.php';
$query = "SELECT 1";
$result = $con->query($query);
if ($result) {
    echo "Conexión exitosa.";
} else {
    echo "Error en la conexión.";
}
?>