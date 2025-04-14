<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Codigo/estilos/stylePromo.css">
    <title>Promociones</title>
</head>

<body>
    <?php require_once '../Codigo/plantillas/header.php'; ?>
    <main class="container promociones">
        <div class="promociones-lista">
            <h2>Promociones</h2>
            <?php
            $mostrarEditar = false;
            $mostrarImagen = true;
            require_once '../Codigo/validaciones/promociones/promociones_lista.php';
            ?>
        </div>

    </main>
    <?php require_once '../Codigo/plantillas/footer.php'; ?>
</body>

</html>