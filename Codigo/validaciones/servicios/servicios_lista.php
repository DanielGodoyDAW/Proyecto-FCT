<?php
require_once __DIR__ . '/../../conexion/conexion.php';

$mostrarEditar = $mostrarEditar ?? false; // para mostrar editar si eres admin
$mostrarImagen = $mostrarImagen ?? false; // para mostrar las imágenes en promociones

echo '<link rel="stylesheet" href="./estilos/stylePromo.css">';

$sql = "SELECT * FROM promociones";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    // Tabla clásica para escritorio
    echo '<div class="tabla-escritorio">';
    echo '<table id="promociones-table" class="solo-escritorio">';
    echo '<tr>
            <th>Título</th>
            <th>Descripción</th>
            <th>Duración</th>';
    if ($mostrarImagen) {
        echo '<th>Imagen</th>';
    }
    if ($mostrarEditar) {
        echo '<th>Acciones</th>';
    }
    echo '</tr>';
    
    // Recorremos los resultados
    $result->data_seek(0); // Reinicia el puntero para reutilizar en ambas vistas
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['titulo']) . '</td>';
        echo '<td>' . htmlspecialchars($row['descripcion']) . '</td>';
        echo '<td>' . htmlspecialchars($row['duracion']) . ' min</td>';
        if ($mostrarImagen) {
            if (!empty($row['imagen'])) {
                echo '<td><img src=".' . htmlspecialchars($row['imagen']) . '" alt="Imagen del servicio" style="max-width: 100px; max-height: 100px;"></td>';
            } else {
                echo '<td>Sin imagen</td>';
            }
        }
        if ($mostrarEditar) {
            echo '<td>';
            echo '<button class="btnE" id="btn-color-V" onclick="editarPromocion(' . $row['idPromocion'] . ')">Editar</button>';
            echo '<form action="/Codigo/validaciones/servicios/eliminar_promocion.php" method="POST" style="display:inline;">';
            echo '<input type="hidden" name="idPromocion" value="' . $row['idPromocion'] . '">';
            echo '<button type="submit" class="btnE" id="btn-color-R" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este servicio?\');">Eliminar</button>';
            echo '</form>';
            echo '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
    echo '</div>';

    // Fichas compactas para móvil
    $result->data_seek(0); // Reinicia el puntero
    echo '<div class="fichas-movil">';
    while ($row = $result->fetch_assoc()) {
        echo '<div class="ficha">';
        echo '<p><strong>Título:</strong> ' . htmlspecialchars($row['titulo']) . '</p>';
        echo '<p><strong>Descripción:</strong> ' . htmlspecialchars($row['descripcion']) . '</p>';
        echo '<p><strong>Duración:</strong> ' . htmlspecialchars($row['duracion']) . ' min</p>';
        if ($mostrarEditar) {
            echo '<div class="acciones-botones">';
            echo '<button class="btnE" id="btn-color-V" onclick="editarPromocion(' . $row['idPromocion'] . ')">Editar</button>';
            echo '<form action="/Codigo/validaciones/servicios/eliminar_promocion.php" method="POST">';
            echo '<input type="hidden" name="idPromocion" value="' . $row['idPromocion'] . '">';
            echo '<button type="submit" class="btnE" id="btn-color-R" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este servicio?\');">Eliminar</button>';
            echo '</form>';
            echo '</div>';
        }
        echo '</div>';
    }
    echo '</div>';
} else {
    echo 'No hay servicios disponibles.';
}
?>
