<header>
    <a href="/Codigo/index.php">
        <img class="logo" src="/Codigo/imagenes/logo_provisional.png" alt="icono">
    </a>
    <h1>Clinica de Podología Carmen Godoy</h1>
    <link rel="stylesheet" href="/Codigo/estilos/style.css">

    <?php
    $_SESSION['pacientes'] = "Carmen Godoy"; // Simulando que el usuario ha iniciado sesión
    $_SESSION['sexo'] = "F"; // Simulando que el usuario es mujer
    
    if (isset($_SESSION['pacientes']) && isset($_SESSION['sexo'])) {
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
            <?php if (isset($_SESSION['pacientes'])) {
                echo "<li><a class='btnA' href='/Codigo/citas.php'>Citas</a></li>";
            } else { 
            echo "<li><a class='btnA' href='/Codigo/validaciones/registro.php'>Registro</a></li>";
            } ?>
            <?php if (isset($_SESSION['pacientes'])) {
                echo  "<li><a class='btnA' href='/Codigo/validaciones/cerrar_sesion.php'>Cerrar Sesion</a></li>";
            } ?>
        </ul>
    </nav>
</header>