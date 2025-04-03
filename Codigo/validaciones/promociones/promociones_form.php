<h2>Agregar Promoción</h2>
<form action="validaciones/promociones_admin.php" method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <td><label for="titulo">Título:</label></td>
            <td><input type="text" id="titulo" name="titulo" required></td>
        </tr>
        <tr>
            <td><label for="descripcion">Descripción:</label></td>
            <td><textarea id="descripcion" name="descripcion" required></textarea></td>
        </tr>
        <tr>
            <td><label for="imagen">Imagen:</label></td>
            <td><input type="file" id="imagen" name="imagen" accept="image/*" required></td>
        </tr>
    </table>
    <button type="submit">Agregar Promoción</button>
</form>