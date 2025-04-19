<?php
ob_start();
require_once __DIR__ . '/../../conexion/conexion.php';

$horariosManana = [
    "09:00:00", "09:30:00", "10:00:00", "10:30:00",
    "11:00:00", "11:30:00", "12:00:00", "12:30:00"
];

$horariosTarde = [
    "15:00:00", "15:30:00", "16:00:00", "16:30:00",
    "17:00:00", "17:30:00", "18:00:00", "18:30:00"
];

// Capturamos fecha por POST
$fechaSeleccionada = $_POST['fecha'] ?? null;

if (!$fechaSeleccionada) {
    echo "No se ha seleccionado una fecha.";
    exit;
}

// Determinar el día de la semana (1 = lunes, 7 = domingo)
$diaSemana = date('N', strtotime($fechaSeleccionada));

//  BLOQUEAR citas
if (isset($_POST['bloquear']) && isset($_POST['bloquear_citas'])) {
    foreach ($_POST['bloquear_citas'] as $hora) {
        // Verificar si ya existe cita bloqueada
        $check = $conexion->prepare("SELECT * FROM Citas WHERE fecha = ? AND hora = ? AND bloqueada = 1");
        $check->bind_param("ss", $fechaSeleccionada, $hora);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows == 0) {
            $stmt = $conexion->prepare("INSERT INTO Citas (fecha, hora, estado, bloqueada, idAdmin) VALUES (?, ?, 'Bloqueada', 1, ?)");
            $stmt->bind_param("ssi", $fechaSeleccionada, $hora, $_SESSION['idAdmin']);
            $stmt->execute();
        }
    }
    
}

//  DESBLOQUEAR citas (eliminarlas)
if (isset($_POST['desbloquear']) && isset($_POST['desbloquear_citas'])) {
    foreach ($_POST['desbloquear_citas'] as $hora) {
        $stmt = $conexion->prepare("DELETE FROM Citas WHERE fecha = ? AND hora = ? AND bloqueada = 1 AND idPacientes IS NULL");
        $stmt->bind_param("ss", $fechaSeleccionada, $hora);
        $stmt->execute();
    }
}

// Obtener todas las citas bloqueadas de la fecha
$query = $conexion->prepare("SELECT hora FROM Citas WHERE fecha = ? AND bloqueada = 1 AND idPacientes IS NULL");
$query->bind_param("s", $fechaSeleccionada);
$query->execute();
$result = $query->get_result();

$bloqueadas = [];
while ($row = $result->fetch_assoc()) {
    $bloqueadas[] = $row['hora'];
}
?>
<link rel="stylesheet" href="/Codigo/estilos/styleAdmin.css">
<script src="/Codigo/validaciones/citas/recargarPagina.js"></script>
<h2>Gestión de citas para <?php echo $fechaSeleccionada; ?></h2>

<!-- Formulario para BLOQUEAR -->
<h3>Bloquear nuevas citas</h3>
<div class="bloquear-container">
    <form method="POST" onsubmit="recargarPagina()">
        <input type="hidden" name="fecha" value="<?php echo $fechaSeleccionada; ?>">

        <?php if ($diaSemana >= 1 && $diaSemana <= 4) { ?>
            <h4>Mañana</h4>
            <?php foreach ($horariosManana as $hora) { ?>
                <?php if (!in_array($hora, $bloqueadas)) { ?>
                    <label>
                        <input type="checkbox" name="bloquear_citas[]" value="<?php echo $hora; ?>">
                        <?php echo date("H:i", strtotime($hora)); ?> - <?php echo date("H:i", strtotime($hora) + 30 * 60); ?>
                    </label><br>
                <?php } ?>
            <?php } ?>

            <h4>Tarde</h4>
            <?php foreach ($horariosTarde as $hora) { ?>
                <?php if (!in_array($hora, $bloqueadas)) { ?>
                    <label>
                        <input type="checkbox" name="bloquear_citas[]" value="<?php echo $hora; ?>">
                        <?php echo date("H:i", strtotime($hora)); ?> - <?php echo date("H:i", strtotime($hora) + 30 * 60); ?>
                    </label><br>
                <?php } ?>
            <?php } ?>
        <?php } elseif ($diaSemana == 5) { ?>
            <h4>Mañana</h4>
            <?php foreach ($horariosManana as $hora) { ?>
                <?php if (!in_array($hora, $bloqueadas)) { ?>
                    <label>
                        <input type="checkbox" name="bloquear_citas[]" value="<?php echo $hora; ?>">
                        <?php echo date("H:i", strtotime($hora)); ?> - <?php echo date("H:i", strtotime($hora) + 30 * 60); ?>
                    </label><br>
                <?php } ?>
            <?php } ?>
        <?php } ?>

        <br>
        <button type="submit" name="bloquear">Bloquear seleccionadas</button>
    </form>
</div>
<hr>

<!-- Formulario para DESBLOQUEAR -->
<h3>Desbloquear citas existentes</h3>
<div class="desbloquear-container">
    <form method="POST" onsubmit="recargarPagina()">
        <input type="hidden" name="fecha" value="<?php echo $fechaSeleccionada; ?>">

        <?php if ($diaSemana >= 1 && $diaSemana <= 4) { ?>
            <h4>Mañana</h4>
            <?php foreach ($horariosManana as $hora) { ?>
                <?php if (in_array($hora, $bloqueadas)) { ?>
                    <label>
                        <input type="checkbox" name="desbloquear_citas[]" value="<?php echo $hora; ?>">
                        <?php echo date("H:i", strtotime($hora)); ?> - <?php echo date("H:i", strtotime($hora) + 30 * 60); ?> (Bloqueada)
                    </label><br>
                <?php } ?>
            <?php } ?>

            <h4>Tarde</h4>
            <?php foreach ($horariosTarde as $hora) { ?>
                <?php if (in_array($hora, $bloqueadas)) { ?>
                    <label>
                        <input type="checkbox" name="desbloquear_citas[]" value="<?php echo $hora; ?>">
                        <?php echo date("H:i", strtotime($hora)); ?> - <?php echo date("H:i", strtotime($hora) + 30 * 60); ?> (Bloqueada)
                    </label><br>
                <?php } ?>
            <?php } ?>
        <?php } elseif ($diaSemana == 5) { ?>
            <h4>Mañana</h4>
            <?php foreach ($horariosManana as $hora) { ?>
                <?php if (in_array($hora, $bloqueadas)) { ?>
                    <label>
                        <input type="checkbox" name="desbloquear_citas[]" value="<?php echo $hora; ?>">
                        <?php echo date("H:i", strtotime($hora)); ?> - <?php echo date("H:i", strtotime($hora) + 30 * 60); ?> (Bloqueada)
                    </label><br>
                <?php } ?>
            <?php } ?>
        <?php } ?>

        <br>
        <button type="submit" name="desbloquear">Desbloquear seleccionadas</button>
    </form>
</div>