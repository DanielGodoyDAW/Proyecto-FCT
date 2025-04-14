<?php

require_once __DIR__ . '/../conexion/conexion.php';

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
    if (!preg_match('/^[A-ZÁÉÍÓÚÑ][A-Za-zÁÉÍÓÚáéíóúñ\s]{2,29}$/', $_POST['nombre'])) {
        $errores[] = "El nombre debe tener entre 3 y 30 caracteres, comenzando con mayúscula.";
    }

    // Validar primer apellido
    if (!preg_match('/^[A-ZÁÉÍÓÚÑ][A-Za-zÁÉÍÓÚáéíóúñ\s]{2,29}$/', $_POST['apellido1'])) {
        $errores[] = "El primer apellido debe tener entre 3 y 30 caracteres, comenzando con mayúscula.";
    }

    // Validar segundo apellido (opcional)
    if (!empty($_POST['apellido2']) && !preg_match('/^[A-ZÁÉÍÓÚÑ][A-Za-zÁÉÍÓÚáéíóúñ\s]{2,29}$/', $_POST['apellido2'])) {
        $errores[] = "El segundo apellido debe tener entre 3 y 30 caracteres, comenzando con mayúscula.";
    }

    // Validar email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido.";
    }

    // Validar teléfono
    if (!preg_match('/^\+\d{2} \d{3} \d{3} \d{3}$/', $_POST['telefono'])) {
        $errores[] = "El teléfono debe tener el formato 999 999 999.";
    }

    if (empty($_POST['extension']) || !preg_match('/^\+\d{1,3}$/', $_POST['extension'])) {
        $errores[] = "Por favor, selecciona una extensión válida.";
    }

    $extension = $_POST['extension'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $telefonoCompleto = $extension . ' ' . $telefono;

    // Validar fecha de nacimiento
    if (empty($_POST['fecha_nacimiento'])) {
        $errores[] = "La fecha de nacimiento es obligatoria.";
    } else {
        try {
            $fecha_nacimiento = new DateTime($_POST['fecha_nacimiento']);
            $fecha_actual = new DateTime();
            $fecha_minima = (new DateTime())->modify('-13 years'); // Fecha minima para mayores de 13 años

            if ($fecha_nacimiento >= $fecha_actual) {
                $errores[] = "La fecha de nacimiento no puede ser la actual, ni una fecha futura.";
            } elseif ($fecha_nacimiento > $fecha_minima) {
                $errores[] = "Debes tener al menos 13 años para registrarte.";
            }
        } catch (Exception $e) {
            $errores[] = "La fecha de nacimiento no tiene un formato válido.";
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
        // Convierte los errores en un string para mostrarlos en un alert
        $erroresString = implode("\\n", $errores);

        // Redirige al formulario de registro con un alert
        echo "<script>
            alert('$erroresString');
            window.location.href = '/Codigo/registro.php';
        </script>";
        exit();
    } else {
        // Encriptar la contraseña
        $password_encriptada = password_hash($_POST['pass'], PASSWORD_DEFAULT);

        // Insertar en la base de datos
        $sql = "INSERT INTO pacientes (nombre, apellido1, apellido2, email, telefono, fechaNacim, sexo, dni, pass) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param(
            "sssssssss",
            $_POST['nombre'],
            $_POST['apellido1'],
            $_POST['apellido2'],
            $_POST['email'],
            $telefonoCompleto,
            $_POST['fecha_nacimiento'],
            $_POST['sexo'],
            $_POST['dni'],
            $password_encriptada
        );

        if ($stmt->execute()) {
            // Redirigir al usuario después del registro exitoso
            header('Location: /Codigo/index.php');
            exit();
        } else {
            echo "<script>
                alert('Error al registrar al usuario. Por favor, inténtalo de nuevo.');
                window.location.href = '/Codigo/registro.php';
            </script>";
        }
    }
}
