<?php
session_start();
require_once __DIR__ . '/../../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idAdmin = $_SESSION['idAdmin'] ?? null; // para sacar su id

    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $fechaInicio = isset($_POST['fechaInicio']) && !empty($_POST['fechaInicio']) ? $_POST['fechaInicio'] : null;
    $fechaFin = isset($_POST['fechaFin']) && !empty($_POST['fechaFin']) ? $_POST['fechaFin'] : null;
    $descuento = isset($_POST['descuento']) && !empty($_POST['descuento']) ? $_POST['descuento'] : null;

    // Manejar la imagen opcionalmente
    $rutaImagen = null;
    if (isset($_FILES['imagen']['name']) && !empty($_FILES['imagen']['name'])) {
        $directorio = dirname(__DIR__, 2) . '/imagenes/promociones'; // Ruta absoluta a la carpeta de imágenes
        $rutaImagen = '/imagenes/promociones/' . basename($_FILES['imagen']['name']); // Ruta relativa para guardar en la base de datos
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
    $sql = "INSERT INTO promociones (descripcion, fechaInicio, fechaFin, descuento, titulo, imagen, idAdmin) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('ssssssi', $descripcion, $fechaInicio, $fechaFin, $descuento, $titulo, $rutaImagen, $idAdmin);

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
