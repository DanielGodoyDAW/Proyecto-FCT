<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if (!isset($_SESSION['idAdmin'])) {
    header("Location: /Codigo/index.php");
    exit;
}

$query = "SELECT idPacientes, nombre, apellido1, apellido2, telefono, email, dni FROM Pacientes WHERE dni LIKE 'TEMP%'";
$resultado = $conexion->query($query);

if ($resultado->num_rows > 0) {
    echo '<table class="pacientes-temporales">';
    echo '<thead>';
    echo '<tr><th>Nombre</th><th>Teléfono</th><th>Email</th><th>DNI</th><th>Acciones</th></tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = $resultado->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['nombre'] . ' ' . $row['apellido1'] . ' ' . $row['apellido2']) . '</td>';
        echo '<td>' . htmlspecialchars($row['telefono']) . '</td>';
        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
        echo '<td>' . htmlspecialchars($row['dni']) . '</td>';
        echo '<td>
            <form method="POST" action="/Codigo/validaciones/citas/eliminar_paciente_temporal.php" onsubmit="return confirm(\'¿Estás seguro de eliminar este paciente temporal?\');" style="display:inline;">
                <input type="hidden" name="id" value="' . $row['idPacientes'] . '">
                <button type="submit" class="btnCancelar">Eliminar</button>
            </form>
        </td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p>No hay pacientes temporales registrados.</p>';
}
?>
