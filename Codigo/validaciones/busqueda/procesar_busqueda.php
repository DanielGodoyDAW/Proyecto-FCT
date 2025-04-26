<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if (isset($_POST['paciente'])) {
    $idPaciente = intval($_POST['paciente']);

    $stmt = $conexion->prepare("SELECT * FROM Pacientes WHERE idPacientes = ?");
    $stmt->bind_param("i", $idPaciente);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo "<h3>Ficha del Paciente</h3>";
        echo "<ul>";
        foreach ($row as $campo => $valor) {
            if (!in_array($campo, ['pass', 'token_recuperacion', 'token_expira'])) {
                echo "<li><strong>" . ucfirst($campo) . ":</strong> " . htmlspecialchars($valor) . "</li>";
            }
        }
        echo "</ul>";
    } else {
        echo "<p>No se encontró el paciente.</p>";
    }
}
?>
