<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errores = [];

    // Validar nombre
    if (!preg_match('/^[A-Z][A-Za-z]{2,9}$/', $_POST['nombre'])) {
        $errores[] = "El nombre debe tener entre 3 y 10 caracteres, comenzando con mayúscula.";
    }

    // Validar primer apellido
    if (!preg_match('/^[A-Za-z]{4,8}$/', $_POST['apellido1'])) {
        $errores[] = "El primer apellido debe tener entre 4 y 8 caracteres.";
    }

    // Validar segundo apellido (opcional)
    if (!empty($_POST['apellido2']) && !preg_match('/^[A-Za-z]{4,8}$/', $_POST['apellido2'])) {
        $errores[] = "El segundo apellido debe tener entre 4 y 8 caracteres.";
    }

    // Validar DNI
    if (empty($_POST['dni'])) {
        $errores[] = "El DNI es obligatorio.";
    }

    // Validar email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido.";
    }

    // Validar teléfono
    if (!preg_match('/^\+\d{2} \d{3}-\d{3}-\d{3}$/', $_POST['telefono'])) {
        $errores[] = "El teléfono debe tener el formato +99 999-999-999.";
    }

    // Validar fecha de nacimiento
    if (empty($_POST['fecha_nacimiento'])) {
        $errores[] = "La fecha de nacimiento es obligatoria.";
    }

    // Validar sexo
    if (!in_array($_POST['sexo'], ['Hombre', 'Mujer', 'Otro'])) {
        $errores[] = "El sexo seleccionado no es válido.";
    }

    // Mostrar errores o procesar datos
    if (!empty($errores)) {
        foreach ($errores as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    } else {
        echo "<p style='color: green;'>Formulario enviado correctamente.</p>";
        //! Aqui procesaremos los datos, como guardarlos en la base de datos
        header('Location: ../citas.php');
        exit();
    }
}
?>