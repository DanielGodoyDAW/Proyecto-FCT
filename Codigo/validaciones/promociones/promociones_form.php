<div class="seccion promociones">
    <h2>Agregar Promoción</h2>
    <form action="validaciones/promociones_admin.php" method="POST" enctype="multipart/form-data">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>

        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*" required>

        <button type="submit">Agregar Promoción</button>
    </form>
</div>