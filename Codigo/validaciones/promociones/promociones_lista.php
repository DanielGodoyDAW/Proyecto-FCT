<?php
require_once __DIR__ . '/../../conexion/conexion.php';

$mostrarEditar = $mostrarEditar ?? false;

echo '<link rel="stylesheet" href="/Codigo/estilos/stylePromo.css">';

$sql = "SELECT * FROM promociones";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    echo '<table id="promociones-table">';
    echo '<tr><th>Título</th><th>Descripción</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Descuento</th>';
    if ($mostrarEditar) {
        echo '<th>Acciones</th>';
    }
    echo '</tr>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['titulo']) . '</td>';
        echo '<td>' . htmlspecialchars($row['descripcion']) . '</td>';
        echo '<td>' . htmlspecialchars($row['fechaInicio']) . '</td>';
        echo '<td>' . htmlspecialchars($row['fechaFin']) . '</td>';
        echo '<td>' . htmlspecialchars($row['descuento']) . '%</td>';
        if ($mostrarEditar) {
            echo '<td>';
            echo '<button class="btnA" onclick="editarPromocion(' . $row['idPromocion'] . ')">Editar</button>';
            echo '<form method="POST" action="/Codigo/validaciones/promociones/eliminar_promocion.php" style="display:inline;">';
            echo ' ';
            echo '<input type="hidden" name="idPromocion" value="' . $row['idPromocion'] . '">';
            echo '<button type="submit" class="btnB" onclick="return confirm(\'¿Estás seguro de que deseas eliminar esta promoción?\');">Eliminar</button>';
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
