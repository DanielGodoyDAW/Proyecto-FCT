<link rel="stylesheet" href="/Codigo/estilos/stylePromo.css">
<link rel="stylesheet" href="/Codigo/estilos/style.css">
<script src="/Codigo/validaciones/promociones/editarPromocion.js"></script>
<h2>Agregar Promoción</h2>
<form action="/Codigo/validaciones/promociones/procesar_promociones.php" method="POST" enctype="multipart/form-data">
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
            <td><label for="fechaInicio">Fecha de Inicio:</label></td>
            <td><input type="date" name="fechaInicio" id="fechaInicio"></td>
        </tr>
        <tr>
            <td><label for="fechaFin">Fecha de Fin:</label></td>
            <td><input type="date" name="fechaFin" id="fechaFin"></td>
        </tr>
        <tr>
            <td><label for="descuento">Descuento:</label></td>
            <td><input type="number" name="descuento" id="descuento"></td>
        </tr>
        <tr>
            <td><label for="imagen">Imagen:</label></td>
            <td>
                <div class="custom-file-upload">
                    <label for="imagen">Seleccionar archivo</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" required>
                </div>
            </td>
        </tr>
    </table>
    <button type="submit">Agregar Promoción</button>
</form>