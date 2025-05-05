<?php
require_once __DIR__ . '/../../conexion/conexion.php';
?>

<!-- Buscador dinámico nuevo -->
<div class="buscador-dinamico">
    <input type="text" id="busquedaPaciente" placeholder="Buscar paciente por nombre, apellido o teléfono..." autocomplete="off">
    <button id="resetBusqueda" type="button">Resetear</button>
    <div id="sugerencias"></div>
</div>
<div id="resultadoBusqueda">
    <h2>Resultado de la Búsqueda</h2>
</div>

<!-- jQuery y Ajax para el buscador dinámico -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#busquedaPaciente").keyup(function() {
            let query = $(this).val();
            if (query.length > 1) {
                $.ajax({
                    url: '/Codigo/validaciones/busqueda/buscar_paciente.php',
                    method: 'POST',
                    data: {
                        consulta: query
                    },
                    success: function(data) {
                        $("#sugerencias").fadeIn();
                        $("#sugerencias").html(data);
                    }
                });
            } else {
                $("#sugerencias").fadeOut();
            }
        });

        $("#resetBusqueda").click(function() {
            $("#busquedaPaciente").val(''); // Vacía el input
            $("#sugerencias").fadeOut(); // Oculta las sugerencias
            $("#resultadoBusqueda").html('<h2>Resultado de la Búsqueda</h2>');
        });

        // Cuando hace click en una sugerencia
        $(document).on('click', '.sugerencia-item', function() {
            const pacienteSeleccionado = $(this).data('id'); // Usamos el data-id que pongamos en PHP
            $("#busquedaPaciente").val($(this).text());
            $("#sugerencias").fadeOut();

            // Nueva petición para mostrar los datos del paciente
            $.ajax({
                url: '/Codigo/validaciones/busqueda/procesar_busqueda.php',
                method: 'POST',
                data: {
                    paciente: pacienteSeleccionado
                },
                success: function(data) {
                    $("#resultadoBusqueda").html(data);
                }
            });
        });
    });

    $(document).on('click', '.redirigir-historial', function() {
        const sub = $(this).data('subseccion');

        // Cambiar vista principal
        $('.contenido-admin').removeClass('activo');
        $('.menu-admin a').removeClass('activo');
        $('#historial').addClass('activo');
        $('.menu-admin a[data-seccion="historial"]').addClass('activo');

        // Cambiar submenú historial
        $('#historial .subcontenido').removeClass('activo');
        $('.submenu-historial a').removeClass('activo');
        $('#' + sub).addClass('activo');
        $('.submenu-historial a[data-seccion="' + sub + '"]').addClass('activo');

        // Scroll automático opcional
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