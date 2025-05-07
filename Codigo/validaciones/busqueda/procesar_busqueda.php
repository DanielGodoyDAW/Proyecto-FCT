<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['paciente'])) {
    $idPaciente = intval($_POST['paciente']);
    $_SESSION['idPaciente'] = $idPaciente;

    $stmt = $conexion->prepare("SELECT * FROM Pacientes WHERE idPacientes = ?");
    $stmt->bind_param("i", $idPaciente);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo "<h3>Ficha del Paciente</h3><ul>";
        foreach ($row as $campo => $valor) {
            if (!in_array($campo, ['pass', 'token_recuperacion', 'token_expira', 'es_temporal'])) {
                echo "<li><strong>" . ucfirst($campo) . ":</strong> " . htmlspecialchars($valor) . "</li>";
            }
        }
        echo "</ul>";
        echo '<div class="acciones-historial">';
        echo '<button class="btnH" onclick="mostrarHistorial(\'editar\')">✏️ Editar Historial</button>';
        echo '<button class="btnH" onclick="mostrarHistorial(\'ver\')">👁 Ver Historial</button>';
        echo '</div>';
    } else {
        echo "<p>No se encontró el paciente.</p>";
    }
}
?>
