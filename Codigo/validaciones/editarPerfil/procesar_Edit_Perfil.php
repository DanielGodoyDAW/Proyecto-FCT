<?php
session_start();
require_once __DIR__ . '/../../conexion/conexion.php';

if (isset($_SESSION['idPacientes'])) {
    $idUsuario = $_SESSION['idPacientes'];
} elseif (isset($_SESSION['idAdmin'])) {
    $idUsuario = $_SESSION['idAdmin'];
}

// Datos del formulario
$email = $_POST['email'] ?? null;
$telefono = $_POST['telefono'] ?? null;
$extension = $_POST['extension'] ?? null; 
$sexo = $_POST['sexo'] ?? null;
$passwordActual = $_POST['passwordActual'] ?? null;
$nuevaContrasena = $_POST['nuevaContrasena'] ?? null;
$confirmarContrasena = $_POST['confirmarContrasena'] ?? null;
$fromPopup = isset($_POST['fromPopup']) ? true : false;

$telefonoCompleto = $extension . ' ' . $telefono;

// Cambio de contraseña
if (!empty($passwordActual) || !empty($nuevaContrasena) || !empty($confirmarContrasena)) {
    if ($nuevaContrasena !== $confirmarContrasena) {
        echo '<script>
            alert("Error: Las contraseñas no coinciden.");
            window.close();
        </script>';
        exit;
    }

    $query = "SELECT pass FROM Pacientes WHERE idPacientes = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo '<script>
            alert("Error: Usuario no encontrado.");
            window.close();
        </script>';
        exit;
    }

    $usuario = $result->fetch_assoc();
    if (!password_verify($passwordActual, $usuario['pass'])) {
        echo '<script>
            alert("Error: La contraseña actual es incorrecta.");
            window.close();
        </script>';
        exit;
    }

    // Guardamos la nueva contraseña
    $hashedPassword = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
    $query = "UPDATE Pacientes SET pass = ? WHERE idPacientes = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('si', $hashedPassword, $idUsuario);

    if (!$stmt->execute()) {
        echo '<script>
            alert("Error: No se pudo actualizar la contraseña.");
            window.close();
        </script>';
        exit;
    }
}

// Actualización del resto del perfil
$query = "UPDATE Pacientes SET email = ?, telefono = ?, sexo = ? WHERE idPacientes = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('sssi', $email, $telefonoCompleto, $sexo, $idUsuario);

if ($stmt->execute()) {
    $_SESSION['sexo'] = $sexo;

    if ($fromPopup) {
        echo '<script>
            alert("Perfil actualizado correctamente.");
            if (window.opener) {
                window.opener.location.reload();
            }
            window.close();
        </script>';
    } else {
        echo '<script>
            alert("Perfil actualizado correctamente.");
            window.location.href = "/Codigo/editar_perfil.php";
        </script>';
    }
} else {
    echo '<script>
        alert("Error: No se pudo actualizar el perfil.");
        window.close();
    </script>';
}
?>
