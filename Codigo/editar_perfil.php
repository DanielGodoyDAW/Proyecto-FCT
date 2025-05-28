<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/styleColores.css">
    <link rel="stylesheet" href="estilos/styleEditPerfil.css">
    <title>Editar Perfil</title>
</head>

<body>
    <?php require_once './plantillas/header.php'; ?>
    <main class="contenedor">
        <?php require_once './validaciones/editarPerfil/form_Edit_Perfil.php'; ?>
    </main>
    <?php require_once './plantillas/footer.php'; ?>
</body>

</html>