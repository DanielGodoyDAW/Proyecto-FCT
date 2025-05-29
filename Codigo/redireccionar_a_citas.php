<?php
$seccion = $_GET['seccion'] ?? '';
header("Location: citas.php?seccionActiva=" . urlencode($seccion));
exit;
?>