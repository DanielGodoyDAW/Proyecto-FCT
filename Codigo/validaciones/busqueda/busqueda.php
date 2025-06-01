<?php
require_once __DIR__ . '/../../conexion/conexion.php';
require_once __DIR__ . '/../../utilidades.php';

$contenidoResultado = '';

if (isset($_SESSION['idPaciente'])) {
    $_POST['paciente'] = $_SESSION['idPaciente'];

    // Captura la salida del include en un buffer
    ob_start();
    include __DIR__ . '/procesar_busqueda.php';
    $contenidoResultado = ob_get_clean();
}
?>

<!-- Buscador dinámico nuevo -->
<div class="buscador-dinamico">
    <input type="text" id="busquedaPaciente" placeholder="Buscar paciente por nombre, apellido o teléfono..." autocomplete="off">
    <button id="resetBusqueda" type="button">Resetear</button>
    <div id="sugerencias"></div>
</div>
<div id="resultadoBusqueda">
    <h2>Resultado de la Búsqueda</h2>
    <?php echo $contenidoResultado; ?>
</div>

<!-- jQuery y Ajax para el buscador dinámico -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Espera a que el DOM esté completamente cargado
    $(document).ready(function() {

        // Cuando se escribe en el campo de búsqueda
        $("#busquedaPaciente").keyup(function() {
            let query = $(this).val(); // Captura el valor escrito

            // Si el texto tiene más de 1 carácter, lanza búsqueda AJAX
            if (query.length > 1) {
                $.ajax({
                    url: "<?= ruta_relativa('validaciones/busqueda/buscar_paciente.php') ?>", // Script que busca pacientes en la base de datos
                    method: 'POST',
                    data: {
                        consulta: query // Envía el texto escrito al servidor
                    },
                    success: function(data) {
                        $("#sugerencias").fadeIn(); // Muestra el contenedor de sugerencias
                        $("#sugerencias").html(data); // Inserta los resultados devueltos
                    }
                });
            } else {
                // Si el input tiene 1 carácter o menos, oculta sugerencias
                $("#sugerencias").fadeOut();
            }
        });

        // Cuando se hace clic en el botón "Resetear"
        $("#resetBusqueda").click(function() {
            $("#busquedaPaciente").val(''); // Limpia el campo de texto
            $("#sugerencias").fadeOut(); // Oculta las sugerencias
            $("#resultadoBusqueda").html('<h2>Resultado de la Búsqueda</h2>'); // Restaura el contenido inicial
        });

        // Cuando el usuario hace clic en una sugerencia
        $(document).on('click', '.sugerencia-item', function() {
            const pacienteSeleccionado = $(this).data('id'); // ID del paciente
            $("#busquedaPaciente").val($(this).text());
            $("#sugerencias").fadeOut();

            // Primero actualiza la sesión en el servidor
            $.ajax({
                url: "<?= ruta_relativa('validaciones/busqueda/guardar_id_paciente.php') ?>",
                method: 'POST',
                data: {
                    id: pacienteSeleccionado
                },
                success: function(response) {
                    if (response.trim() === 'ok') {
                        // Luego recarga la página con la sesión ya actualizada
                        location.reload();
                    } else {
                        console.error('Error al guardar ID en sesión');
                    }
                },
                error: function() {
                    console.error('Error AJAX al guardar ID en sesión');
                }
            });
        });
    });

    // Al hacer clic en un enlace o botón con la clase .redirigir-historial
    $(document).on('click', '.redirigir-historial', function() {
        const sub = $(this).data('subseccion'); // Captura el valor de la subsección a mostrar

        // Oculta todas las secciones principales y desactiva sus botones
        $('.contenido-admin').removeClass('activo');
        $('.menu-admin a').removeClass('activo');

        // Muestra la sección principal del historial
        $('#historial').addClass('activo');
        $('.menu-admin a[data-seccion="historial"]').addClass('activo');

        // Oculta todas las subsecciones del historial
        $('#historial .subcontenido').removeClass('activo');
        $('.submenu-historial a').removeClass('activo');

        // Activa solo la subsección correspondiente
        $('#' + sub).addClass('activo');
        $('.submenu-historial a[data-seccion="' + sub + '"]').addClass('activo');

        // Hace scroll hacia la sección de historial
        $('html, body').animate({
            scrollTop: $('#historial').offset().top
        }, 300);
    });
</script>



<style>
    .buscador-dinamico {
        position: relative;
        width: 300px;
        margin: 20px auto;
    }

    #busquedaPaciente {
        width: 100%;
        padding: 10px;
        font-size: 16px;
    }

    #sugerencias {
        background: white;
        border: 1px solid #ccc;
        border-top: none;
        max-height: 200px;
        overflow-y: auto;
        width: 100%;
        position: absolute;
        z-index: 1000;
    }

    .sugerencia-item {
        padding: 10px;
        cursor: pointer;
    }

    .sugerencia-item:hover {
        background-color: #f0f0f0;
    }

    #resetBusqueda {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        background-color: #08A3A9;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    #resetBusqueda:hover {
        background-color: #0f2788;
    }
</style>