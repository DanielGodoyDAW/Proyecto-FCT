<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if (isset($_POST['consulta'])) {
    $busqueda = $_POST['consulta'] . '%';

    $stmt = $conexion->prepare("SELECT idPacientes, nombre, apellido1, telefono FROM Pacientes WHERE LOWER(CONCAT(nombre, ' ', apellido1)) LIKE ? OR telefono LIKE ?");
    $stmt->bind_param("ss", $busqueda, $busqueda);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="sugerencia-item" data-id="' . $row['idPacientes'] . '">' . htmlspecialchars($row['nombre']) . ' ' . htmlspecialchars($row['apellido1']) . ' - ' . htmlspecialchars($row['telefono']) . '</div>';
        }
    } else {
        echo '<div class="sugerencia-item">No encontrado</div>';
    }
}
?>
