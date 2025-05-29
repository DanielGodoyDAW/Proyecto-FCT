<link rel="stylesheet" href="./estilos/stylePromo.css">
<link rel="stylesheet" href="./estilos/style.css">
<script src="./validaciones/servicios/editarServicio.js"></script>
<form action="./procesar_servicios.php" method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <td><label for="titulo">Título:</label></td>
            <td><input type="text" id="titulo" name="titulo" required></td>
        </tr>
        <tr>
            <td><label for="descripcion">Descripción:</label></td>
            <td><textarea id="descripcion" name="descripcion"></textarea></td>
        </tr>
        <tr>
            <td><label for="duracion">Duracion:</label></td>
            <td><input type="text" name="duracion" id="duracion"></td>
        </tr>
        <tr>
            <td><label for="imagen">Imagen:</label></td>
            <td>
                < class="input-archivo">
                    <label for="imagen">Seleccionar archivo</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" required>
            .
            </td>
        </tr>
    </table>
    <button type="submit">Agregar Servicio</button>
</form>