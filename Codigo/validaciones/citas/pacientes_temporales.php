<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if (!isset($_SESSION['idAdmin'])) {
    header("Location: /Codigo/index.php");
    exit;
}

echo '<h2>Pacientes Temporales</h2>';

$query = "SELECT idPacientes, nombre, apellido1, apellido2, telefono, email, dni FROM Pacientes WHERE dni LIKE 'TEMP%'";
$resultado = $conexion->query($query);

if ($resultado->num_rows > 0) {
    echo '<table border="1" cellpadding="5">';
    echo '<tr><th>Nombre</th><th>Teléfono</th><th>Email</th><th>DNI</th><th>Acciones</th></tr>';

    while ($row = $resultado->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['nombre'] . ' ' . $row['apellido1'] . ' ' . $row['apellido2']) . '</td>';
        echo '<td>' . htmlspecialchars($row['telefono']) . '</td>';
        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
        echo '<td>' . htmlspecialchars($row['dni']) . '</td>';
        echo '<td>
            <form method="POST" action="/Codigo/validaciones/citas/eliminar_paciente_temporal.php" onsubmit="return confirm(\'¿Estás seguro de eliminar este paciente temporal?\');">
                <input type="hidden" name="id" value="' . $row['idPacientes'] . '">
                <button type="submit">Eliminar</button>
            </form>
        </td>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo '<p>No hay pacientes temporales registrados.</p>';
}
?>
