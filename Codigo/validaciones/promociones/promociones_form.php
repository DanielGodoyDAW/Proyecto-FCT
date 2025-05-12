<link rel="stylesheet" href="/Codigo/estilos/stylePromo.css">
<link rel="stylesheet" href="/Codigo/estilos/style.css">
<script src="/Codigo/validaciones/promociones/editarPromocion.js"></script>
<form action="/Codigo/validaciones/promociones/procesar_promociones.php" method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <td><label for="titulo">Título:</label></td>
            <td><input type="text" id="titulo" name="titulo" required></td>
        </tr>
        <tr>
            <td><label for="descripcion">Descripción:</label></td>
            <td><textarea id="descripcion" name="descripcion" ></textarea></td>
        </tr>
        <tr>
            <td><label for="duracion">Duracion:</label></td>
            <td><input type="text" name="duracion" id="duracion"></td>
        </tr>
        <tr>
            <td><label for="imagen">Imagen:</label></td>
            <td>
                <div class="subida-Archivo">
                    <label for="imagen">Seleccionar archivo</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" required>
                </div>
            </td>
        </tr>
    </table>
    <button type="submit">Agregar Servicio</button>
</form>