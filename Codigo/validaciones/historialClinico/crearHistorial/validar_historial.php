<?php
require_once __DIR__ . '/../../../conexion/conexion.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPaciente = $_POST['idPaciente'] ?? null;
    if (!$idPaciente) {
        die("ID de paciente no proporcionado.");
    }

    // Obtener idHistorial desde la tabla Pacientes
    $stmt = $conexion->prepare("SELECT idHistorial FROM Pacientes WHERE idPacientes = ?");
    $stmt->bind_param("i", $idPaciente);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();

    if (!$fila) {
        die("Paciente no encontrado.");
    }

    $idHistorial = $fila['idHistorial'];

    // Patologías: convertir array en string separado por comas
    $patologias = $_POST['patologias'] ?? [];
    $patologias_string = implode(', ', $patologias);

    // Campos a actualizar (solo los que vienen del formulario)
    $campos = [
        'fichaComentarioInicial',
        'antec_podologicos',
        'antec_quirurgicos',
        'patologias' => $patologias_string,
        'antecedentes',
        'alergias',
        'farmacologia',
        'desarrolloPSi',
        'fecha'
    ];

    $camposFinales = [];
    $tipos = '';
    $valores = [];

    foreach ($campos as $campo => $valor) {
        $nombreCampo = is_string($campo) ? $campo : $valor;
        $valorCampo = is_string($campo) ? $valor : ($_POST[$valor] ?? null);
        if (!is_null($valorCampo) && $valorCampo !== '') {
            $camposFinales[] = "$nombreCampo = ?";
            $tipos .= 's';
            $valores[] = $valorCampo;
        }
    }

    // Construir la consulta
    if (empty($camposFinales)) {
        die("No se recibió ningún campo para actualizar.");
    }

    $camposSQL = implode(', ', $camposFinales);
    $tipos .= 'i'; // para el idHistorial
    $valores[] = $idHistorial;

    $sql = "UPDATE Historial SET $camposSQL WHERE idHistorial = ?";
    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        die("Error al preparar la consulta: " . $conexion->error);
    }

    $stmt->bind_param($tipos, ...$valores);

    if ($stmt->execute()) {
        echo "<script>
                alert('Historial actualizado correctamente.');
                window.location.href = '/Codigo/admin.php?pagina=verHistorial&idPaciente=$idPaciente';
            </script>";
        exit;
    } else {
        echo "Error al actualizar historial: " . $stmt->error;
    }
}
