<?php
require_once __DIR__ . '/../../../conexion/conexion.php';

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

    //patologías como string separado por comas
    $patologias = $_POST['patologias'] ?? [];
    $patologias_string = implode(', ', $patologias);

    // Procesar checkboxes
    $onicopatias = isset($_POST['onicopatias']) ? 1 : 0;
    $queratopatias = isset($_POST['queratopatias']) ? 1 : 0;
    $dermatopatias = isset($_POST['dermatopatias']) ? 1 : 0;
    $prominenciasOseas = isset($_POST['prominenciasOseas']) ? 1 : 0;
    $altDigitales = isset($_POST['altDigitales']) ? 1 : 0;

    // Procesar archivo (si se sube uno)
    $archivoRuta = null;
    $archivoRuta = null;
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = basename($_FILES['archivo']['name']);

        //si no existe la carpeta, la crea
        $carpetaArchivos = __DIR__ . '/../archivos/';
        if (!file_exists($carpetaArchivos)) {
            mkdir($carpetaArchivos, 0755, true);
        }

        $rutaDestino = $carpetaArchivos . $nombreArchivo;
        move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaDestino);

        $archivoRuta = '/Codigo/validaciones/historialClinico/archivos/' . $nombreArchivo;
    }

    // ya que tengo un trigger que crea un historial automaticamente al crear el paciente
    //hay que hacer un update en vez de un insert

    $campos = [
        'motivo',
        'antec_podologicos',
        'antec_quirurgicos',
        'patologias' => $patologias_string,
        'antecedentes',
        'alergias',
        'farmacologia',
        'desarrolloPSi',
        'observaciones',
        'dx',
        'tratamiento',
        'receta',
        'fecha',
        'seguimiento'
    ];

    $chekbox = [
        'onicopatias' => $onicopatias,
        'queratopatias' => $queratopatias,
        'dermatopatias' => $dermatopatias,
        'prominenciasOseas' => $prominenciasOseas,
        'altDigitales' => $altDigitales
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
    
    // checkboxes: se actualizan siempre
    foreach ($chekbox as $campo => $valor) {
        $camposFinales[] = "$campo = ?";
        $tipos .= 'i';
        $valores[] = $valor;
    }
    
    // archivo si se subió
    if ($archivoRuta) {
        $camposFinales[] = "archivo = ?";
        $tipos .= 's';
        $valores[] = $archivoRuta;
    }
    
    // añadir WHERE y bind idHistorial
    $camposSQL = implode(', ', $camposFinales);
    $tipos .= 'i';
    $valores[] = $idHistorial;
    
    $sql = "UPDATE Historial SET $camposSQL WHERE idHistorial = ?";
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        die("Error al preparar: " . $conexion->error);
    }
    
    $stmt->bind_param($tipos, ...$valores);
    
    if ($stmt->execute()) {
        header("Location: /Codigo/validaciones/historialClinico/listarHistorial/verHistorial.php?idPaciente=" . urlencode($idPaciente));
        exit;
    } else {
        echo "Error al actualizar historial: " . $stmt->error;
    }
}
