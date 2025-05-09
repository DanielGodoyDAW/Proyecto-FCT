<?php require_once __DIR__ . '/../../../conexion/conexion.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$idPaciente = $_SESSION['idPaciente'] ?? null;
if (!$idPaciente) {
    echo "<p>No hay paciente cargado.</p>";
    return;
}

// Obtener idHistorial
$stmt = $conexion->prepare("SELECT idHistorial FROM Pacientes WHERE idPacientes = ?");
$stmt->bind_param("i", $idPaciente);
$stmt->execute();
$result = $stmt->get_result();
$idHistorial = $result->fetch_assoc()['idHistorial'] ?? null;

// Comprobar si hay informes
$ultimoInforme = null;
if ($idHistorial) {
    $stmt = $conexion->prepare("SELECT * FROM Informe WHERE idHistorial = ? ORDER BY fecha DESC LIMIT 1");
    $stmt->bind_param("i", $idHistorial);
    $stmt->execute();
    $result = $stmt->get_result();
    $ultimoInforme = $result->fetch_assoc();
}
?>

<div>
    <h2>Historial</h2>
    <?php require_once '../Codigo/validaciones/historialClinico/editarHistorial/editarHistorial.php'; ?>
</div>
<div>
    <h2>Informe</h2>
    <?php require_once '../Codigo/validaciones/historialClinico/editarHistorial/editarInforme.php'; ?>
</div>
<div class="acciones-historial">
    <button class="btnH" onclick="location.href='/Codigo/admin.php'">⬅ Volver</button>
    <button class="btnH" onclick="mostrarHistorial('ver')">👁 Ver Historial</button>
</div>