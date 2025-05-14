<?php
if (session_status() === PHP_SESSION_NONE) { //para corregir problemas de session_start()
    session_start();
}
require_once __DIR__ . '/../conexion/conexion.php';
?>

<header>
    <a href="/Codigo/index.php">
        <img class="logo" src="/Codigo/imagenes/logo.png" alt="icono">
    </a>
    <h1>Clínica de Podología Carmen Godoy</h1>
    <link rel="stylesheet" href="/Codigo/estilos/style.css">
    <script src="/Codigo/js/menuNavegacion.js"></script>

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
                echo "<li><a class='btnA navegacion' href='/Codigo/index.php'>Inicio<img src='/Codigo/iconos/home.svg'></a></li>";
            } ?>
            <?php if (isset($_SESSION['idPacientes']) || isset($_SESSION['idAdmin'])) {
                // Opcion visible solo si el usuario es paciente o admin
                echo "<li><a class='btnA navegacion' href='/Codigo/citas.php'>Citas<img src='/Codigo/iconos/citas.svg'></a></li>";
            } else {
                // Opcion visible para invitados
                echo "<li><a class='btnA navegacion' href='/Codigo/registro.php'>Registro<img src='/Codigo/iconos/registro.svg'></a></li>";
            } ?>
            <!-- solo si es admin -->
            <?php if (isset($_SESSION['idAdmin'])) {
                echo "<li><a class='btnA navegacion' href='/Codigo/admin.php'>Administrar<img src='/Codigo/iconos/admin.svg'></a></li>";
            } ?>
            <!-- si es paciente o admin -->
            <?php if (isset($_SESSION['idPacientes']) || isset($_SESSION['idAdmin'])) {
                echo "<li><a class='btnA navegacion' href='/Codigo/servicios.php'>Servicios<img src='/Codigo/iconos/servicios.svg'></a></li>";
            } ?>
            <?php if (isset($_SESSION['idPacientes']) || isset($_SESSION['idAdmin'])) {
                echo "<li><a class='btnA navegacion' href='/Codigo/editar_perfil.php'>Editar Perfil<img src='/Codigo/iconos/perfil.svg'></a></li>";
            } ?>
            <?php if (isset($_SESSION['idPacientes']) || isset($_SESSION['idAdmin'])) {
                echo "<li><a class='btnA navegacion' href='/Codigo/conexion/cerrar_sesion.php'>Cerrar Sesion<img src='/Codigo/iconos/logout.svg'></a></li>";
            } ?>
        </ul>
    </nav>
    <br>
    <br>
</header>