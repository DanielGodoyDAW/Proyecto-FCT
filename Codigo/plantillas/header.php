<?php
if (session_status() === PHP_SESSION_NONE) { //para corregir problemas de session_start()
    session_start();
}
require_once __DIR__ . '/../conexion/conexion.php';
require_once __DIR__ . '/../utilidades.php';
?>

<header>
    <a href="./index.php">
        <img class="logo" src="./imagenes/logo_sin_fondo.png" alt="icono">
    </a>
    <h1>Clínica de Podología Carmen Godoy</h1>
    <link rel="stylesheet" href="estilos/styleColores.css">
    <link rel="stylesheet" href="estilos/style.css">
    <script src="<?= ruta_relativa('js/menuNavegacion.js') ?>"></script>

    <?php
    // Verificar si el usuario ha iniciado sesión
    if (isset($_SESSION['idAdmin'])) {
        // Si el usuario es administrador
        $idAdmin = $_SESSION['idAdmin'];
        $query = "SELECT nombre, apellido1, apellido2 FROM Admin WHERE idAdmin = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $idAdmin);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Si se encuentra el administrador, mostrar sus datos
            $admin = $result->fetch_assoc();
            echo '<p class="bienvenida">Bienvenida Administradora: ' . htmlspecialchars($admin['nombre']) . ' ' . htmlspecialchars($admin['apellido1']) . ' ' . htmlspecialchars($admin['apellido2']) . '</p>';
        }
    } else if (isset($_SESSION['idPacientes'])) {
        // Si el usuario es un paciente
        if (isset($_SESSION['nombre'], $_SESSION['apellido1'])) {
            $apellido2 = $_SESSION['apellido2'] ?? ''; // Manejar el caso donde apellido2 no está definido
            // Asignar 'O' (Otro) si el sexo es NULL o no está definido
            $sexo = $_SESSION['sexo'] ?? 'O';

            if ($sexo === 'H') {
                echo '<p class="bienvenida">Bienvenido ' . htmlspecialchars($_SESSION['nombre']) . ' ' . htmlspecialchars($_SESSION['apellido1']) . ' ' . htmlspecialchars($apellido2) . '</p>';
            } else if ($sexo === 'M') {
                echo '<p class="bienvenida">Bienvenida ' . htmlspecialchars($_SESSION['nombre']) . ' ' . htmlspecialchars($_SESSION['apellido1']) . ' ' . htmlspecialchars($apellido2) . '</p>';
            } else {
                echo '<p class="bienvenida">Bienvenid@ ' . htmlspecialchars($_SESSION['nombre']) . ' ' . htmlspecialchars($_SESSION['apellido1']) . ' ' . htmlspecialchars($apellido2) . '</p>';
            }
        } else {
            // Si no hay sesión iniciada
            echo '<p class="bienvenida">Bienvenido invitado</p>';
        }
    }
    ?>

    <nav>
        <ul>
            <!-- Opcion siempre visible cuando no estas logueado -->
            <?php if (!isset($_SESSION['idPacientes']) && !isset($_SESSION['idAdmin'])) {
                echo "<li><a class='btnA navegacion' href='./index.php'>Inicio<img src='./iconos/home.svg'></a></li>";
            } ?>
            <?php if (isset($_SESSION['idPacientes']) || isset($_SESSION['idAdmin'])) {
                // Opcion visible solo si el usuario es paciente o admin
                echo "<li><a class='btnA navegacion' href='./citas.php'>Citas<img src='./iconos/citas.svg'></a></li>";
            } else {
                // Opcion visible para invitados
                echo "<li><a class='btnA navegacion' href='./registro.php'>Registro<img src='./iconos/registro.svg'></a></li>";
            } ?>
            <!-- solo si es admin -->
            <?php if (isset($_SESSION['idAdmin'])) {
                echo "<li><a class='btnA navegacion' href='./admin.php'>Administrar<img src='./iconos/admin.svg'></a></li>";
            } ?>
            <!-- si es paciente o admin -->
            <?php if (isset($_SESSION['idPacientes']) || isset($_SESSION['idAdmin'])) {
                echo "<li><a class='btnA navegacion' href='./servicios.php'>Servicios<img src='./iconos/servicios.svg'></a></li>";
            } ?>
            <?php if (isset($_SESSION['idPacientes']) || isset($_SESSION['idAdmin'])) {
                echo "<li><a class='btnA navegacion' href='./editar_perfil.php'>Editar Perfil<img src='./iconos/perfil.svg'></a></li>";
            } ?>
            <?php if (isset($_SESSION['idPacientes']) || isset($_SESSION['idAdmin'])) {
                echo "<li><a class='btnA navegacion' href='./conexion/cerrar_sesion.php'>Cerrar Sesion<img src='./iconos/logout.svg'></a></li>";
            } ?>
        </ul>
    </nav>
    <br>
    <br>
</header>