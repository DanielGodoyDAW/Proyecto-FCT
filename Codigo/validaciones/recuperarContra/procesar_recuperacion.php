<?php
require_once './conexion/conexion.php';
require_once './enviarMail.php'; // archivo con la funcion enviarCorreoRecuperacion

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Verificar si el correo existe en la base de datos
    $sql = "SELECT * FROM pacientes WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generar un token unico
        $token = bin2hex(random_bytes(32)); //para mayor seguridad, incluimos en la bd un token aleatorio de 32 bytes
        $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Guardar el token en la base de datos
        $sql = "UPDATE pacientes SET token_recuperacion = ?, token_expira = ? WHERE email = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sss", $token, $expira, $email);
        $stmt->execute();

        // Llamar a la función para enviar el correo
        $resultadoCorreo = enviarCorreoRecuperacion($email, $token);

        if ($resultadoCorreo === true) {
            echo "<script>
                alert('Se ha enviado un enlace de recuperación a tu correo.');
                window.location.href = '/Codigo/index.php'; // Redirige al usuario a la página principal
            </script>";
        } else {
            echo "<script>
                alert('Hubo un error al enviar el correo: $resultadoCorreo');
                window.location.href = '/Codigo/validaciones/recuperarContra/recuperar_contrasena.php'; // Redirige al formulario de recuperación
            </script>";
        }
    } else {
        echo "<script>
            alert('El correo electrónico no está registrado.');
            window.location.href = '/Codigo/validaciones/recuperarContra/recuperar_contrasena.php'; // Redirige al formulario de recuperación
        </script>";
    }
}
?>