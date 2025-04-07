<?php
// require_once './conexion/conexion.php'; // Conexión a la base de datos
$sql = "SELECT * FROM promociones";
$result = $conexion->query($sql);

while ($row = $result->fetch_assoc()):
?>
    <li>
        <img src="/Codigo/imagenes/promociones/<?php echo $row['imagen']; ?>" alt="Imagen de promoción" width="100">
        <strong><?php echo $row['titulo']; ?></strong>
        <p><?php echo $row['descripcion']; ?></p>
        <a href="validaciones/editar_promocion.php?id=<?php echo $row['id']; ?>">Editar</a>
        <a href="validaciones/eliminar_promocion.php?id=<?php echo $row['id']; ?>">Eliminar</a>
    </li>
<?php endwhile; ?>