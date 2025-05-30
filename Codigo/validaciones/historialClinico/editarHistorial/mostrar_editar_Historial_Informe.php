<?php
require_once __DIR__ . '/../../../conexion/conexion.php';
require_once __DIR__ . '/../../../utilidades.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$idPaciente = $_SESSION['idPaciente'] ?? null;
if (!$idPaciente) {
    echo "<p>No hay paciente cargado.</p>";
    return;
}

// Obtener datos del paciente
$stmt = $conexion->prepare("SELECT * FROM Pacientes WHERE idPacientes = ?");
$stmt->bind_param("i", $idPaciente);
$stmt->execute();
$result = $stmt->get_result();
$paciente = $result->fetch_assoc();

// Obtener idHistorial
$stmt = $conexion->prepare("SELECT idHistorial FROM Pacientes WHERE idPacientes = ?");
$stmt->bind_param("i", $idPaciente);
$stmt->execute();
$result = $stmt->get_result();
$idHistorial = $result->fetch_assoc()['idHistorial'] ?? null;

// Obtener informe actual (por ID o último)
$ultimoInforme = null;
if ($idHistorial) {
    if (isset($_GET['idInforme'])) {
        $stmt = $conexion->prepare("SELECT * FROM Informe WHERE idInforme = ?");
        $stmt->bind_param("i", $_GET['idInforme']);
    } else {
        $stmt = $conexion->prepare("SELECT * FROM Informe WHERE idHistorial = ? ORDER BY fecha DESC LIMIT 1");
        $stmt->bind_param("i", $idHistorial);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $ultimoInforme = $result->fetch_assoc();
}
?>

<div class="container-edicion">
    <div class="div-edicion historial">
        <h2>Edición de DNI</h2>
        <form action="<?php echo ruta_relativa('validaciones/editarPerfil/procesar_Edit_Perfil.php'); ?>" method="POST">
            <input type="hidden" name="desde_admin" value="1">
            <input type="hidden" name="idPaciente" value="<?= $idPaciente ?>">
            <table>
                <tr>
                    <td><label for="dni">DNI del paciente:</label></td>
                    <td><input type="text" name="dni" value="<?= htmlspecialchars($paciente['dni']) ?>" pattern="[0-9]{8}[A-Z]" maxlength="9" required></td>
                    <td><button type="submit">Guardar DNI</button></td>
                </tr>
            </table>
        </form>

        <h2>Historial</h2>
        <?php require_once __DIR__ . '/editarHistorial.php'; ?>
    </div>

    <div class="div-edicion informe">
        <h2>Informe</h2>
        <?php require_once __DIR__ . '/editarInforme.php'; ?>
    </div>

    <div class="acciones-historial">
        <button class="btnH" onclick="location.href='<?php echo ruta_relativa('admin.php'); ?>'">⬅ Volver</button>
        <button class="btnH" onclick="mostrarHistorial('ver')">👁 Ver Historial e Informe</button>
    </div>
</div>
