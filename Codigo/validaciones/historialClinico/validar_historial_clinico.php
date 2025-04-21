<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['paciente'])) {
    $descripcion = $_POST['descripcion'];
    $archivo = $_FILES['archivo'];

    // Validar que la descripción no esté vacía
    if (empty($descripcion)) {
        echo "La descripción es obligatoria.";
        exit;
    }

    // Validar que se haya subido un archivo
    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        echo "Error al subir el archivo.";
        exit;
    }

    // Validar el tipo de archivo
    $tipoArchivo = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $tiposPermitidos = ['jpg', 'jpeg', 'png', 'pdf'];

    if (!in_array($tipoArchivo, $tiposPermitidos)) {
        echo "Tipo de archivo no permitido.";
        exit;
    }

    //si no exite el directorio, lo crea
    $directorioDestino = "/Codigo/validaciones/historialClinico/historiales/";
    if (!is_dir($directorioDestino)) {
        if (!mkdir($directorioDestino, 0777, true)) {
            echo "Error al crear el directorio de destino.";
            exit;
        }
    }
    $nombreArchivo = $_FILES['archivo']['name'];
    $tamanoArchivo = $_FILES['archivo']['size'];
    $tipoArchivo = $_FILES['archivo']['type'];
    $rutaTemporal = $_FILES['archivo']['tmp_name'];
    $directorioRelativo = '/Codigo/validaciones/historialClinico/historiales/';
    $rutaDestino = $directorioDestino . basename($nombreArchivo);

    // Validar el tamaño del archivo 
    $tamanoMaximo = 2 * 1024 * 1024; // 2MB
    if ($archivo['size'] > $tamanoMaximo) {
        echo "El archivo es demasiado grande. El tamaño máximo permitido es de 2MB.";
        exit;
    }

    // Guardar el archivo en el servidor 
    if (!move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
        echo "Error al mover el archivo.";
        exit;
    }

    //! pendiente de añadir campo en la bd para guardar la ruta del archivo

    // Guardar la información en la base de datos
    $sql = "INSERT INTO historial (descripcion) VALUES ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $descripcion);
    if ($stmt->execute()) {
        echo "Historial clínico creado exitosamente.";
    } else {
        echo "Error al crear el historial clínico: " . $conexion->error;
    }
}
