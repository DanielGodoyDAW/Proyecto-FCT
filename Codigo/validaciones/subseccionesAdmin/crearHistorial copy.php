<script src="/Codigo/validaciones/historialClinico/crearHistorial/submenuCrearHistorial.js"></script>
<div id="CreacionHistorial" class="fila">

    <nav class="submenu">
        <ul>
            <li><a href="#" data-seccion="submenu-historial" class="activo">Crear Historial</a></li>
            <li><a href="#" data-seccion="submenu-lista">Listar Historiales</a></li>
            <li><a href="#" data-seccion="submenu-editar">Buscar Historial</a></li>
        </ul>
    </nav>

    <main class="contenido-submenu">
        <!-- crear historial -->
        <div id="submenu-historial" class="contenido-submenu-seccion activo">
            <h2>Crear Historial Clinico</h2>
            <?php require_once '../Codigo/validaciones/historialClinico/crearHistorial/historial_clinico_form.php'; ?>
        </div>
        <!-- listar historiales -->
        <div id="submenu-lista" class="contenido-submenu-seccion">
            <h2>Listar Historiales Clinicos</h2>
            <?php  ?>
        </div>
        <!--editar historial-->
        <div id="submenu-editar" class="contenido-submenu-seccion">
            <h2>Editar Historial Clinico</h2>
            <?php  ?>
        </div>

    </main>
    