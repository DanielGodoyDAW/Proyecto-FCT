<?php
require_once __DIR__ . '/../../../conexion/conexion.php';

$idPaciente = $_GET['idPaciente'] ?? null;

$sql = "SELECT 
            H.*,
            P.nombre,
            P.apellido1,
            P.apellido2,
            P.telefono,
            P.dni,
            P.fechaNacim
        FROM Historial H
        JOIN Pacientes P ON H.idHistorial = P.idPacientes
        WHERE H.idHistorial = ?
        ORDER BY H.fecha DESC";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $idPaciente);
$stmt->execute();
$result = $stmt->get_result();

while ($fila = $result->fetch_assoc()) {

    $nombreCompleto = $fila['nombre'] . ' ' . $fila['apellido1'];
    if (!empty($fila['apellido2'])) {
        $nombreCompleto .= ' ' . $fila['apellido2'];
    }

    echo "<h3>Consulta del " . htmlspecialchars($fila['fecha']) . "</h3>";
    echo "<h4>Paciente: " . htmlspecialchars($nombreCompleto) . "</h4>";
    echo "<h4>Teléfono: " . htmlspecialchars($fila['telefono']) . "</h4>";
    echo "<h4>DNI: " . htmlspecialchars($fila['dni']) . "</h4>";
    echo "<h4>Fecha de nacimiento: " . htmlspecialchars($fila['fechaNacim']) . "</h4>";
    echo "<h4>Descripción: " . nl2br(htmlspecialchars($fila['descripcion'])) . "</h4>";
    echo "<h4>Motivo: " . nl2br(htmlspecialchars($fila['motivo'])) . "</h4>";
    echo "<h4>Antecedentes podológicos: " . nl2br(htmlspecialchars($fila['antec_podologicos'])) . "</h4>";
    echo "<h4>Antecedentes quirúrgicos: " . nl2br(htmlspecialchars($fila['antec_quirurgicos'])) . "</h4>";
    echo "<h4>Antecedentes familiares: " . htmlspecialchars($fila['antecedentes']) . "</h4>";
    echo "<h4>Alergias: " . htmlspecialchars($fila['alergias']) . "</h4>";
    echo "<h4>Farmacología: " . htmlspecialchars($fila['farmacologia']) . "</h4>";
    echo "<h4>Desarrollo psicomotriz: " . htmlspecialchars($fila['desarrolloPSi']) . "</h4>";
    echo "<h4>Observaciones: " . nl2br(htmlspecialchars($fila['observaciones'])) . "</h4>";

    echo "<h4>Patologías detectadas:</h4><ul>";
    if ($fila['onicopatias']) echo "<li>Onicopatías</li>";
    if ($fila['queratopatias']) echo "<li>Queratopatías</li>";
    if ($fila['dermatopatias']) echo "<li>Dermatopatías</li>";
    if ($fila['prominenciasOseas']) echo "<li>Prominencias óseas</li>";
    if ($fila['altDigitales']) echo "<li>Alteraciones digitales</li>";
    echo "</ul>";

    echo "<h4>Receta: " . nl2br(htmlspecialchars($fila['receta'])) . "</h4>";
    echo "<h4>Seguimiento: " . nl2br(htmlspecialchars($fila['seguimiento'])) . "</h4>";

    if (!empty($fila['archivo'])) {
        echo "<h4>Archivo adjunto:</h4>";
        echo '<img src="/ruta/archivos/' . htmlspecialchars($fila['archivo']) . '" width="150">';
    }

    echo "<hr>";
}

?>
