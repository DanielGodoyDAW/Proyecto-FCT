<header>
    <a href="/Codigo/index.php">
        <img class="logo" src="/Codigo/imagenes/logo_provisional.png" alt="icono">
    </a>
    <h1>Clinica de Podología Carmen Godoy</h1>
    <link rel="stylesheet" href="/Codigo/estilos/style.css">

    <?php
    // session_start();
    // require_once './validaciones/conexion.php'; 
    
    //aqui poner la conexion a la base de datos y la consulta para ver si el usuario ha iniciado sesion o no
    $adminName = "Carmen Godoy"; // Este usuario siempre sera el admin
    $_SESSION['admin'] = $adminName;
    //$_SESSION['pacientes'] = "Daniel Godoy"; // Simulando que el usuario ha iniciado sesión
    //$_SESSION['sexo'] = "M"; // Simulando que el usuario es hombre
    if (isset($_SESSION['admin']) && $_SESSION['admin'] === $adminName) {
        echo '<p class="bienvenida">Bienvenida ' . $adminName . '</p>';
    } else if (isset($_SESSION['pacientes']) && isset($_SESSION['sexo'])) {
        if ($_SESSION['sexo'] === 'M') {
            echo '<p class="bienvenida">Bienvenido ' . $_SESSION['pacientes'] . '</p>';
        } else if ($_SESSION['sexo'] === 'F') {
            echo '<p class="bienvenida">Bienvenida ' . $_SESSION['pacientes'] . '</p>';
        } else {
            echo '<p class="bienvenida">Bienvenid@ ' . $_SESSION['pacientes'] . '</p>';
        }
    } else {
        echo '<p class="bienvenida">Bienvenido invitado</p>';
    }
    ?>

    <nav>
        <ul>
            <li><a class="btnA" href="/Codigo/index.php">Inicio</a></li>
            <?php if (isset($_SESSION['pacientes']) || isset($_SESSION['admin'])) {
                echo "<li><a class='btnA' href='/Codigo/citas.php'>Citas</a></li>";
            } else {
                echo "<li><a class='btnA' href='/Codigo/validaciones/registro.php'>Registro</a></li>";
            } ?>
            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === $adminName) {
                echo "<li><a class='btnA' href='/Codigo/admin.php'>Administrar</a></li>";
            } ?>
            <?php if (isset($_SESSION['pacientes']) || isset($_SESSION['admin'])) {
                echo "<li><a class='btnA' href='/Codigo/promociones.php'>Promociones</a></li>";
            } ?>
            <?php if (isset($_SESSION['pacientes']) || isset($_SESSION['admin'])) {
                echo  "<li><a class='btnA' href='/Codigo/validaciones/cerrar_sesion.php'>Cerrar Sesion</a></li>";
            } ?>
        </ul>
    </nav>
</header>