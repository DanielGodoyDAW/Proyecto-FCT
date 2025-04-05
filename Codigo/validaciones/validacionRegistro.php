<?php
require_once __DIR__ . '/../conexion/conexion.php'; // Asegúrate de incluir la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errores = [];

    // Validar DNI
    if (empty($_POST['dni'])) {
        $errores[] = "El DNI es obligatorio.";
    } else {
        // Consulta a la base de datos para verificar si el DNI ya está registrado
        $dni = mysqli_real_escape_string($conexion, $_POST['dni']);
        $sql = "SELECT * FROM pacientes WHERE dni = '$dni'";
        $resultado = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($resultado) > 0) {
            $errores[] = "El DNI ya está registrado.";
        }
    }

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

    // Validar email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido.";
    }

    // Validar teléfono
    if (!preg_match('/^\+\d{2} \d{3} \d{3} \d{3}$/', $_POST['telefono'])) {
        $errores[] = "El teléfono debe tener el formato +99 999 999 999.";
    }

    // Validar fecha de nacimiento
    if (empty($_POST['fecha_nacimiento'])) {
        $errores[] = "La fecha de nacimiento es obligatoria.";
    } else {
        $fecha_nacimiento = DateTime::createFromFormat('Y-m-d', $_POST['fecha_nacimiento']);
        $fecha_actual = new DateTime();

        if (!$fecha_nacimiento) {
            $errores[] = "El formato de la fecha de nacimiento no es válido.";
        } elseif ($fecha_nacimiento > $fecha_actual) {
            $errores[] = "La fecha de nacimiento no puede ser posterior a la fecha actual.";
        }
    }

    // Validar sexo
    if (!in_array($_POST['sexo'], ['Hombre', 'Mujer', 'Otro'])) {
        $errores[] = "El sexo seleccionado no es válido.";
    }

    // Validar contraseña
    if (empty($_POST['pass']) || strlen($_POST['pass']) < 8) {
        $errores[] = "La contraseña debe tener al menos 8 caracteres.";
    } elseif ($_POST['pass'] !== $_POST['confirmar_pass']) {
        $errores[] = "Las contraseñas no coinciden.";
    }

    // Mostrar errores o procesar datos
    if (!empty($errores)) {
        foreach ($errores as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
        exit(); // Detener la ejecución si hay errores
    } else {
        // Encriptar la contraseña
        $password_encriptada = password_hash($_POST['pass'], PASSWORD_DEFAULT);

        // Insertar en la base de datos
        $sql = "INSERT INTO pacientes (nombre, apellido1, apellido2, dni, email, telefono, fecha_nacimiento, sexo, password) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param(
            "sssssssss",
            $_POST['nombre'],
            $_POST['apellido1'],
            $_POST['apellido2'],
            $_POST['dni'],
            $_POST['email'],
            $_POST['telefono'],
            $_POST['fecha_nacimiento'],
            $_POST['sexo'],
            $password_encriptada
        );

        if ($stmt->execute()) {
            // Redirigir al usuario después del registro exitoso
            header('Location: /Codigo/citas.php');
            exit();
        } else {
            echo "<p style='color: red;'>Error al registrar al usuario. Por favor, inténtalo de nuevo.</p>";
        }
    }
}
?>
