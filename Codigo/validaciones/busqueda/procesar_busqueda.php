<link rel="stylesheet" href="/Codigo/estilos/style.css">
<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if (isset($_POST['paciente'])) {
    $idPaciente = intval($_POST['paciente']);

    //consulta para mostrar todos los datos del paciente que coincide con el idPacientes
    $stmt = $conexion->prepare("SELECT * FROM Pacientes WHERE idPacientes = ?");
    $stmt->bind_param("i", $idPaciente);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo "<h3>Ficha del Paciente</h3>";
        echo "<ul>";
        foreach ($row as $campo => $valor) {
            if (!in_array($campo, ['pass', 'token_recuperacion', 'token_expira', 'es_temporal'])) { // Excluir estos campos
                echo "<li><strong>" . ucfirst($campo) . ":</strong> " . htmlspecialchars($valor) . "</li>";
            }
        }
        echo "</ul>";
        echo '
        <div class="acciones-historial">
        <button class="redirigir-historial" data-subseccion="crear" data-id="' . $idPaciente . '">➕ Crear Historial</button>
        <button class="redirigir-historial" data-subseccion="editar" data-id="' . $idPaciente . '">✏️ Editar Historial</button>
        <button class="redirigir-historial" data-subseccion="ver" data-id="' . $idPaciente . '">👁 Ver Historial</button>
        </div>';
    } else {
        echo "<p>No se encontró el paciente.</p>";
    }
}

?>
