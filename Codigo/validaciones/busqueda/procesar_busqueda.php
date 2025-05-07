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
        echo '<div class="acciones-historial">';
        echo '<a class="btnH" href="/Codigo/validaciones/historialClinico/crearHistorial/formulario_crear_historial.php?idPaciente=' . $idPaciente . '" class="boton">➕ Crear Historial</a>';
        echo '<a class="btnH" href="/Codigo/validaciones/historialClinico/editarHistorial/editarHistorial.php?idPaciente=' . $idPaciente . '" class="boton">✏️ Editar Historial</a>';
        echo '<a class="btnH" href="/Codigo/validaciones/historialClinico/listarHistorial/verHistorial.php?idPaciente=' . $idPaciente . '" class="boton">👁 Ver Historial</a>';
        echo '</div>';
    } else {
        echo "<p>No se encontró el paciente.</p>";
    }
}

?>

