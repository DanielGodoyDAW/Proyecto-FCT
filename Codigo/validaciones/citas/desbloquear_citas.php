<?php
require_once __DIR__ . '/../../conexion/conexion.php';

$horariosManana = [
    "09:00:00", "09:30:00", "10:00:00", "10:30:00",
    "11:00:00", "11:30:00", "12:00:00", "12:30:00"
];

$horariosTarde = [
    "16:00:00", "16:30:00", "17:00:00",
    "17:30:00", "18:00:00", "18:30:00", "19:00:00"
];

$fechaSeleccionada = $_POST['fecha'] ?? null;
$diaSemana = date('N', strtotime($fechaSeleccionada));

// Procesar desbloqueo si se envió formulario 
if (isset($_POST['desbloquear']) && isset($_POST['desbloquear_citas'])) {
    foreach ($_POST['desbloquear_citas'] as $hora) {
        $stmt = $conexion->prepare("DELETE FROM Citas WHERE fecha = ? AND hora = ? AND bloqueada = 1 AND idPacientes IS NULL");
        $stmt->bind_param("ss", $fechaSeleccionada, $hora);
        $stmt->execute();
    }

    echo '<script>window.location.href = "/Codigo/citas.php?seccionActiva=bloquearDEsbloCitas";</script>';
    exit;
}

// Obtener citas aún bloqueadas
$query = $conexion->prepare("SELECT hora FROM Citas WHERE fecha = ? AND bloqueada = 1 AND idPacientes IS NULL");
$query->bind_param("s", $fechaSeleccionada);
$query->execute();
$result = $query->get_result();

$bloqueadas = [];
while ($row = $result->fetch_assoc()) {
    $bloqueadas[] = $row['hora'];
}
?>

<link rel="stylesheet" href="/Codigo/estilos/styleColores.css">
<link rel="stylesheet" href="/Codigo/estilos/styleAdmin.css">
<h3>Desbloquear Agenda</h3>
<div class="desbloquear-container">
    <form method="POST">
        <input type="hidden" name="fecha" value="<?php echo htmlspecialchars($fechaSeleccionada); ?>">

        <?php if ($diaSemana >= 1 && $diaSemana <= 4) { ?>
            <h4>Mañana</h4>
            <?php foreach ($horariosManana as $hora) { ?>
                <?php if (in_array($hora, $bloqueadas)) { ?>
                    <label>
                        <input type="checkbox" name="desbloquear_citas[]" value="<?php echo $hora; ?>">
                        <?php echo date("H:i", strtotime($hora)) . " - " . date("H:i", strtotime($hora) + 1800); ?> (Bloqueada)
                    </label><br>
                <?php } ?>
            <?php } ?>

            <h4>Tarde</h4>
            <?php foreach ($horariosTarde as $hora) { ?>
                <?php if ($hora === "19:00:00") continue; ?>
                <?php if (in_array($hora, $bloqueadas)) { ?>
                    <label>
                        <input type="checkbox" name="desbloquear_citas[]" value="<?php echo $hora; ?>">
                        <?php
                        if ($hora === "18:30:00") {
                            echo date("H:i", strtotime($hora)) . " - " . date("H:i", strtotime("19:00:00"));
                        } else {
                            echo date("H:i", strtotime($hora)) . " - " . date("H:i", strtotime($hora) + 1800);
                        }
                        ?>
                        (Bloqueada)
                    </label><br>
                <?php } ?>
            <?php } ?>
        <?php } elseif ($diaSemana == 5) { ?>
            <h4>Mañana</h4>
            <?php foreach ($horariosManana as $hora) { ?>
                <?php if (in_array($hora, $bloqueadas)) { ?>
                    <label>
                        <input type="checkbox" name="desbloquear_citas[]" value="<?php echo $hora; ?>">
                        <?php echo date("H:i", strtotime($hora)) . " - " . date("H:i", strtotime($hora) + 1800); ?> (Bloqueada)
                    </label><br>
                <?php } ?>
            <?php } ?>
        <?php } ?>

        <br>
        <button type="submit" name="desbloquear">Desbloquear seleccionadas</button>
    </form>
</div>
