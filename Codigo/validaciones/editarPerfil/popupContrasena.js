// Función para mostrar el formulario de cambiar contraseña
function mostrarCambioPass() {
    const seccionPerfil = document.getElementById("perfil"); // Sección de perfil
    const seccionCambioPass = document.getElementById("cambiarPass"); // Sección de cambiar contraseña

    seccionPerfil.style.display = "none"; // Oculta la sección de perfil
    seccionCambioPass.style.display = "block"; // Muestra la sección de cambiar contraseña
}

// Función para mostrar el formulario de editar perfil
function mostrarEdit() {
    const seccionPerfil = document.getElementById("perfil"); // Sección de perfil
    const seccionCambioPass = document.getElementById("cambiarPass"); // Sección de cambiar contraseña

    seccionPerfil.style.display = "block"; // Muestra la sección de perfil
    seccionCambioPass.style.display = "none"; // Oculta la sección de cambiar contraseña
}

// Espera a que el DOM esté completamente cargado antes de ejecutar
document.addEventListener('DOMContentLoaded', function () {

    // Obtiene el checkbox que permite mostrar u ocultar las contraseñas
    const checkboxMostrarContrasena = document.getElementById('mostrarContrasena');

    // Verifica que el checkbox exista antes de continuar
    if (checkboxMostrarContrasena) {
        checkboxMostrarContrasena.addEventListener('change', function () {

            // Obtiene los campos de contraseña del formulario
            const camposContrasena = [
                document.getElementById('passwordActual'),       // Campo de contraseña actual
                document.getElementById('nuevaContrasena'),      // Campo de nueva contraseña
                document.getElementById('confirmarContrasena')   // Campo de confirmar contraseña
            ];

            // Recorre cada campo de contraseña y cambia el tipo según si el checkbox está marcado o no
            camposContrasena.forEach(campo => {
                if (campo) {
                    campo.type = checkboxMostrarContrasena.checked ? 'text' : 'password';
                }
            });
        });
    }
});
