<?php
require_once __DIR__ . '/../../conexion/conexion.php';

$mostrarEditar = $mostrarEditar ?? false; //para mostar edirtar si eres admin
$mostrarImagen = $mostrarImagen ?? false; // para mostrar la imagenes en promociones

echo '<link rel="stylesheet" href="/Codigo/estilos/stylePromo.css">';

$sql = "SELECT * FROM promociones";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    echo '<table id="promociones-table">';
    echo '<tr>
            <th>Título</th>
            <th>Descripción</th>
            <th>Duracion</th>';
    if ($mostrarImagen) {
        echo '<th>Imagen</th>'; // Solo muestra la columna de imágenes si $mostrarImagen es true
    }
    if ($mostrarEditar) {
        echo '<th>Acciones</th>';
    }
    echo '</tr>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['titulo']) . '</td>';
        echo '<td>' . htmlspecialchars($row['descripcion']) . '</td>';
        echo '<td>' . htmlspecialchars($row['duracion']) . ' min'. '</td>';
        if ($mostrarImagen) {
            if (!empty($row['imagen'])) {
                echo '<td><img src="'. '/Codigo' . htmlspecialchars($row['imagen']) . '" alt="Imagen de la promoción" style="max-width: 100px; max-height: 100px;"></td>';
            } else {
                echo '<td>Sin imagen</td>';
            }
        }
        if ($mostrarEditar) {
            echo '<td>';
            echo '<button class="btnE" onclick="editarPromocion(' . $row['idPromocion'] . ')">Editar</button>';
            echo '<form action="/Codigo/validaciones/promociones/eliminar_promocion.php" method="POST" style="display:inline;">';
            echo ' ';
            echo '<input type="hidden" name="idPromocion" value="' . $row['idPromocion'] . '">';
            echo '<button type="submit" class="btnE" onclick="return confirm(\'¿Estás seguro de que deseas eliminar esta promoción?\');">Eliminar</button>';
            echo '</form>';
            echo '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo 'No hay promociones disponibles.';
}
?>
