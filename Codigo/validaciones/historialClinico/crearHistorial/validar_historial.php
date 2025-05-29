<?php
require_once __DIR__ . '/../../../conexion/conexion.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPaciente = $_POST['idPaciente'] ?? null;
    if (!$idPaciente) {
        echo "<script>alert('ID de paciente no proporcionado.'); window.history.back();</script>";
        exit;
    }

    $stmt = $conexion->prepare("SELECT idHistorial FROM Pacientes WHERE idPacientes = ?");
    $stmt->bind_param("i", $idPaciente);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();

    if (!$fila) {
        echo "<script>alert('Paciente no encontrado.'); window.history.back();</script>";
        exit;
    }

    $idHistorial = $fila['idHistorial'];

    // Validación mínima de datos
    $nombresCampos = [
        'fichaComentarioInicial',
        'antec_podologicos',
        'antec_quirurgicos',
        'antecedentes',
        'alergias',
        'farmacologia',
        'desarrolloPSi',
        'fecha'
    ];

    $camposFinales = [];
    $tipos = '';
    $valores = [];

    // para cada campo, si existe en $_POST y no está vacío, lo añadimos a la consulta
    foreach ($nombresCampos as $nombreCampo) {
        $valorCampo = $_POST[$nombreCampo] ?? null;
        if (!is_null($valorCampo) && $valorCampo !== '') {
            $camposFinales[] = "$nombreCampo = ?";
            $tipos .= 's';
            $valores[] = $valorCampo;
        }
    }

    
    $patologias = $_POST['patologias'] ?? []; // Asegurarse de que es un array
    $patologias = array_filter(array_map('trim', $patologias)); // Eliminar espacios en blanco y valores vacíos
    //si hay patologías, las unimos en una cadena separada por comas
    if (!empty($patologias)) {
        $patologias_string = implode(', ', $patologias);
    } else { // si no hay patologías, dejamos la cadena vacía
        $patologias_string = '';
    }
    $camposFinales[] = "patologias = ?";
    $tipos .= 's';
    $valores[] = $patologias_string;

    if (empty($camposFinales)) {
        echo "<script>alert('No se recibió ningún campo para actualizar.'); window.history.back();</script>";
        exit;
    }

    $camposSQL = implode(', ', $camposFinales);
    $tipos .= 'i';
    $valores[] = $idHistorial;

    $sql = "UPDATE Historial SET $camposSQL WHERE idHistorial = ?";
    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        echo "<script>alert('Error al preparar la consulta: " . addslashes($conexion->error) . "'); window.history.back();</script>";
        exit;
    }

    $stmt->bind_param($tipos, ...$valores);

    if ($stmt->execute()) {
        echo "<script>
            alert('Historial actualizado correctamente.');
            window.location.href = './admin.php?pagina=verHistorial&idPaciente=$idPaciente';
        </script>";
        exit;
    } else {
        echo "<script>alert('Error al actualizar historial: " . addslashes($stmt->error) . "'); window.history.back();</script>";
        exit;
    }
}
