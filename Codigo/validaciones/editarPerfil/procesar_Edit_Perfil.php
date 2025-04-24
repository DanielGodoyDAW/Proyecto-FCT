<?php
session_start();
require_once __DIR__ . '/../../conexion/conexion.php';

if (isset($_SESSION['idPacientes'])) {
    $idUsuario = $_SESSION['idPacientes'];
} elseif (isset($_SESSION['idAdmin'])) {
    $idUsuario = $_SESSION['idAdmin'];
}

// Obtén los datos enviados desde el formulario
$email = $_POST['email'] ?? null;
$telefono = $_POST['telefono'] ?? null;
$extension = $_POST['extension'] ?? null; 
$sexo = $_POST['sexo'] ?? null;
$passwordActual = $_POST['passwordActual'] ?? null;
$nuevaContrasena = $_POST['nuevaContrasena'] ?? null;
$confirmarContrasena = $_POST['confirmarContrasena'] ?? null;

// Unificamos el teléfono con la extensión
$telefonoCompleto = $extension . ' ' . $telefono;

$fromPopup = isset($_POST['fromPopup']) ? true : false;

if ($fromPopup) {
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

        $hashedPassword = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
        $query = "UPDATE Pacientes SET pass = ? WHERE idPacientes = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('si', $hashedPassword, $idUsuario);

        if (!$stmt->execute()) {
            echo '<script>
                alert("Error: No se pudo actualizar la contraseña.");
                window.location.href = "/Codigo/editar_perfil.php";
            </script>';
            exit;
        }

        echo '<script>
            alert("Contraseña actualizada correctamente.");
            window.location.href = "/Codigo/editar_perfil.php";
        </script>';
        exit;
    }
    // Si no hay datos de contraseña, no hacemos nada
    exit;
}

// --- Solo si NO es popup, actualizamos perfil ---
$query = "UPDATE Pacientes SET email = ?, telefono = ?, sexo = ? WHERE idPacientes = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('sssi', $email, $telefonoCompleto, $sexo, $idUsuario);

if ($stmt->execute()) {
    $_SESSION['sexo'] = $sexo;

    echo '<script>
        alert("Perfil actualizado correctamente.");
        window.location.href = "/Codigo/editar_perfil.php";
    </script>';
    exit;
} else {
    echo '<script>
        alert("Error: No se pudo actualizar el perfil.");
        window.location.href = "/Codigo/editar_perfil.php";
    </script>';
    exit;
}
?>