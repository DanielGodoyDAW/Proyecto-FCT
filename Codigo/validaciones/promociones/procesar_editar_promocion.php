<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPromocion = $_POST['idPromocion'] ?? null;
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $duracion = $_POST['duracion'] ?? null;
    

    if (!$idPromocion) {
        die('Error: ID de promoción no proporcionado.');
    }

    $rutaImagen = null;

    if (isset($_FILES['imagen']['name']) && !empty($_FILES['imagen']['name'])) {
        $sql = "SELECT imagen FROM promociones WHERE idPromocion = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('i', $idPromocion);
        $stmt->execute();
        $result = $stmt->get_result();
        $promocion = $result->fetch_assoc();

        $nombreImagen = basename($_FILES['imagen']['name']);
        $tipoImagen = $_FILES['imagen']['type'];
        $tamanoImagen = $_FILES['imagen']['size'];
        $rutaTemporal = $_FILES['imagen']['tmp_name'];
        $directorioRelativo = '/imagenes/promociones/';
        $directorioAbsoluto = __DIR__ . '/../../imagenes/promociones/';
        $rutaImagen = $directorioRelativo . $nombreImagen;

        if (!is_dir($directorioAbsoluto)) {
            mkdir($directorioAbsoluto, 0777, true);
        }

        if ($tipoImagen !== 'image/jpeg' && $tipoImagen !== 'image/png') {
            die('<script>alert("Error: Solo se permiten imágenes JPEG y PNG."); window.history.back();</script>');
        }

        if ($tamanoImagen > 2000000) {
            die('<script>alert("Error: La imagen es demasiado grande. El tamaño máximo permitido es 2MB."); window.history.back();</script>');
        }

        if (!move_uploaded_file($rutaTemporal, $directorioAbsoluto . $nombreImagen)) {
            die('<script>alert("Error: No se pudo mover la imagen a la carpeta de destino."); window.history.back();</script>');
        }

        if (!empty($promocion['imagen'])) {
            $rutaAnterior = __DIR__ . '/../../' . $promocion['imagen'];
            if (file_exists($rutaAnterior)) {
                unlink($rutaAnterior); // Eliminar la imagen anterior
            }
        }
    }

    $query = "UPDATE promociones SET titulo = ?, descripcion = ?, duracion = ?";
    if ($rutaImagen) {
        $query .= ", imagen = ?";
    }
    $query .= " WHERE idPromocion = ?";

    $stmt = $conexion->prepare($query);

    if ($rutaImagen) {
        $stmt->bind_param('ssisi', $titulo, $descripcion, $duracion, $rutaImagen, $idPromocion);
    } else {
        $stmt->bind_param('ssii', $titulo, $descripcion, $duracion, $idPromocion);
    }

    if ($stmt->execute()) {
        echo '<script>
            alert("Promoción actualizada correctamente.");
            window.close();
            window.opener.location.reload();
        </script>';
    } else {
        echo '<script>alert("Error al actualizar la promoción.");</script>';
    }
}
?>
