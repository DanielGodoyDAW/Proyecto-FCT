<?php
session_start();
require_once __DIR__ . '/../../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idAdmin = $_SESSION['idAdmin'] ?? null; // para sacar su id

    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $duracion = isset($_POST['duracion']) && !empty($_POST['duracion']) ? $_POST['duracion'] : null;
    

    // Manejar la imagen opcionalmente
    $rutaImagen = null;
    if (isset($_FILES['imagen']['name']) && !empty($_FILES['imagen']['name'])) {
        $directorio = dirname(__DIR__, 2) . '/imagenes/servicios'; // Ruta absoluta a la carpeta de imágenes
        $rutaImagen = '/imagenes/servicios/' . basename($_FILES['imagen']['name']); // Ruta relativa para guardar en la base de datos
        $rutaImagenCompleta = $directorio . '/' . basename($_FILES['imagen']['name']); // Ruta completa para mover el archivo

        // Crear la carpeta si no existe
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true); // Crea la carpeta con permisos de escritura
        }

        // Mover la imagen al servidor
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagenCompleta)) {
            echo "<script>
                alert('Error al mover la imagen. Verifica los permisos de la carpeta: $directorio');
                window.history.back();
            </script>";
            exit();
        }
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO promociones (titulo, descripcion, duracion, imagen, idAdmin) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('ssiss', $titulo, $descripcion, $duracion, $rutaImagen, $idAdmin);

    if ($stmt->execute()) {
        echo "<script>
            alert('Promoción agregada correctamente.');
            window.location.href = '../../admin.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al agregar la promoción: " . $stmt->error . "');
            window.history.back();
        </script>";
    }

    exit();
}
?>
