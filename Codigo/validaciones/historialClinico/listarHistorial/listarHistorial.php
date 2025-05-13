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
    <?php require_once __DIR__ . '/verHistorial.php'; ?>
</div>
<div>
    <h2>Informe</h2>
    <form method="GET" action="/Codigo/admin.php#ver">
        <input type="hidden" name="seccion" value="historial">
        <input type="hidden" name="sub" value="ver">
        <label for="idInforme">Selecciona un informe:</label>
        <select name="idInforme" id="idInforme" onchange="this.form.submit()">
            <option value="">Ver último informe</option>
            <?php
            $stmt = $conexion->prepare("SELECT idInforme, fecha FROM Informe WHERE idHistorial = ? ORDER BY fecha DESC");
            $stmt->bind_param("i", $idHistorial);
            $stmt->execute();
            $res = $stmt->get_result();

            while ($row = $res->fetch_assoc()) {
                $fecha = (new DateTime($row['fecha']))->format('d/m/Y');
                $selected = isset($_GET['idInforme']) && $_GET['idInforme'] == $row['idInforme'] ? 'selected' : '';
                echo "<option value='{$row['idInforme']}' $selected>Informe del $fecha</option>";
            }
            ?>
        </select>
    </form>
    <?php require_once __DIR__ . '/verInforme.php'; ?>
</div>
<?php
echo '<div style="text-align:right; margin-top:10px;">';
if (isset($_GET['idInforme'])) { ?>
    <button class="btnH" onclick="window.location.href='admin.php?seccion=historial&sub=editar&idInforme=<?= $_GET['idInforme'] ?>#editar'">✏️ Editar Historial o Informe</button>
<?php } else { ?>
    <button class="btnH" onclick="mostrarHistorial('editar')">✏️ Editar Historial o Informe</button>
<?php }
echo "<button class='btnH' onclick=\"location.href='/Codigo/admin.php'\">⬅ Volver</button>";
echo '</div>';
