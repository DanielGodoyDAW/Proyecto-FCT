<header>
    <a href="/Codigo/index.php">
        <img class="logo" src="/Codigo/imagenes/logo_provisional.png" alt="icono">
    </a>
    <h1>Clínica de Podología Carmen Godoy</h1>
    <link rel="stylesheet" href="/Codigo/estilos/style.css">
    <script src="/Codigo/js/menuNavegacion.js"></script>

    <?php
    session_start();
    require_once __DIR__ . '/../conexion/conexion.php';

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
            echo '<p class="bienvenida">Bienvenido Administrador: ' . htmlspecialchars($admin['nombre']) . ' ' . htmlspecialchars($admin['apellido1']) . ' ' . htmlspecialchars($admin['apellido2']) . '</p>';
        }
    } else if (isset($_SESSION['idPacientes'])) {
        // Si el usuario es un paciente
        if (isset($_SESSION['nombre'], $_SESSION['apellido1'], $_SESSION['apellido2'])) {
            if ($_SESSION['sexo'] === 'H') {
                echo '<p class="bienvenida">Bienvenido ' . htmlspecialchars($_SESSION['nombre']) . ' ' . htmlspecialchars($_SESSION['apellido1']) . ' ' . htmlspecialchars($_SESSION['apellido2']) . '</p>';
            } else if ($_SESSION['sexo'] === 'M') {
                echo '<p class="bienvenida">Bienvenida ' . htmlspecialchars($_SESSION['nombre']) . ' ' . htmlspecialchars($_SESSION['apellido1']) . ' ' . htmlspecialchars($_SESSION['apellido2']) . '</p>';
            } else {
                echo '<p class="bienvenida">Bienvenid@ ' . htmlspecialchars($_SESSION['nombre']) . ' ' . htmlspecialchars($_SESSION['apellido1']) . ' ' . htmlspecialchars($_SESSION['apellido2']) . '</p>';
            }
        } else {
            // Si no hay sesión iniciada
            echo '<p class="bienvenida">Bienvenido invitado</p>';
        }
    }
    ?>

    <nav>
        <ul>
            <!-- Opcion siempre visible -->
            <li><a class="btnA navegacion" href="/Codigo/index.php">Inicio</a></li>
            <?php if (isset($_SESSION['idPacientes']) || isset($_SESSION['idAdmin'])) {
                // Opcion visible solo si el usuario es paciente o admin
                echo "<li><a class='btnA navegacion' href='/Codigo/citas.php'>Citas</a></li>";
            } else {
                // Opcion visible para invitados
                echo "<li><a class='btnA navegacion' href='/Codigo/registro.php'>Registro</a></li>";
            } ?>
            <!-- solo si es admin -->
            <?php if (isset($_SESSION['idAdmin'])) {
                echo "<li><a class='btnA navegacion' href='/Codigo/admin.php'>Administrar</a></li>";
            } ?>
            <!-- si es paciente o admin -->
            <?php if (isset($_SESSION['idPacientes']) || isset($_SESSION['idAdmin'])) {
                echo "<li><a class='btnA navegacion' href='/Codigo/promociones.php'>Promociones</a></li>";
            } ?>
            <?php if (isset($_SESSION['idPacientes']) || isset($_SESSION['idAdmin'])) {
                echo "<li><a class='btnA navegacion' href='/Codigo/editar_perfil.php'>Editar Perfil</a></li>";
            } ?>
            <?php if (isset($_SESSION['idPacientes']) || isset($_SESSION['idAdmin'])) {
                echo "<li><a class='btnA navegacion' href='/Codigo/conexion/cerrar_sesion.php'>Cerrar Sesion</a></li>";
            } ?>
        </ul>
    </nav>
    <br>
    <br>
    <!-- <?php var_dump($_SESSION); ?> Para depurar la sesión actual -->
</header>