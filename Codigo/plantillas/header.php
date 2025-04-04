<header>
    <a href="/Codigo/index.php">
        <img class="logo" src="/Codigo/imagenes/logo_provisional.png" alt="icono">
    </a>
    <h1>Clinica de Podología Carmen Godoy</h1>
    <link rel="stylesheet" href="/Codigo/estilos/style.css">

    <?php
    session_start();
    require_once './conexion/conexion.php'; 

    // Verificar si el usuario ha iniciado sesión
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];

        // Consulta para verificar si el usuario es administrador
        $query = "SELECT nombre FROM Admin WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Si el usuario es administrador
            $admin = $result->fetch_assoc();
            echo '<p class="bienvenida">Bienvenida ' . htmlspecialchars($admin['nombre']) . '</p>';
            $_SESSION['admin'] = true; // Establecer la sesión como administrador
        } else if (isset($_SESSION['pacientes']) && isset($_SESSION['sexo'])) {
            // Si el usuario es un paciente
            if ($_SESSION['sexo'] === 'M') {
                echo '<p class="bienvenida">Bienvenido ' . htmlspecialchars($_SESSION['pacientes']) . '</p>';
            } else if ($_SESSION['sexo'] === 'F') {
                echo '<p class="bienvenida">Bienvenida ' . htmlspecialchars($_SESSION['pacientes']) . '</p>';
            } else {
                echo '<p class="bienvenida">Bienvenid@ ' . htmlspecialchars($_SESSION['pacientes']) . '</p>';
            }
        }
    } else {
        // Si no hay sesión iniciada
        echo '<p class="bienvenida">Bienvenido invitado</p>';
    }
    ?>

    <nav>
        <ul>
            <li><a class="btnA" href="/Codigo/index.php">Inicio</a></li>
            <?php if (isset($_SESSION['idPacientes']) || isset($_SESSION['admin'])) {
                echo "<li><a class='btnA' href='/Codigo/citas.php'>Citas</a></li>";
            } else {
                echo "<li><a class='btnA' href='/Codigo/validaciones/registro.php'>Registro</a></li>";
            } ?>
            <?php if (isset($_SESSION['admin'])) {
                echo "<li><a class='btnA' href='/Codigo/admin.php'>Administrar</a></li>";
            } ?>
            <?php if (isset($_SESSION['idPacientes']) || isset($_SESSION['admin'])) {
                echo "<li><a class='btnA' href='/Codigo/promociones.php'>Promociones</a></li>";
            } ?>
            <?php if (isset($_SESSION['idPacientes']) || isset($_SESSION['admin'])) {
                echo "<li><a class='btnA' href='/Codigo/editar_perfil.php'>Editar Perfil</a></li>";
            } ?>
            <?php if (isset($_SESSION['idPacientes']) || isset($_SESSION['admin'])) {
                echo "<li><a class='btnA' href='/Codigo/validaciones/cerrar_sesion.php'>Cerrar Sesion</a></li>";
            } ?>
        </ul>
    </nav>
</header>