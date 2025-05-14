//funcion para motrar el formulario de cambiar contraseña
function mostrarCambioPass() {
    const perfil = document.getElementById("perfil"); // Sección de perfil
    const cambiarPass = document.getElementById("cambiarPass"); // Sección de cambiar contraseña

    perfil.style.display = "none"; // Oculta la sección de perfil
    cambiarPass.style.display = "block"; // Muestra la sección de cambiar contraseña
}

//funcion para mostrar el formulario de editar perfil
function mostrarEdit(){ 
    const perfil = document.getElementById("perfil"); // Sección de perfil
    const cambiarPass = document.getElementById("cambiarPass"); // Sección de cambiar contraseña

    perfil.style.display = "block"; // Muestra la sección de perfil
    cambiarPass.style.display = "none"; // Oculta la sección de cambiar contraseña
}

//funcion para mostrar la contraseña en los 3 campos de contraseña
document.getElementById('mostrarContrasena').addEventListener('change', function() {
    const passwordFields = [
        document.getElementById('passwordActual'), // Campo de contraseña actual
        document.getElementById('nuevaContrasena'), // Campo de nueva contraseña
        document.getElementById('confirmarContrasena') // Campo de confirmar contraseña
    ];
    passwordFields.forEach(field => { // Recorre cada campo de contraseña
        field.type = this.checked ? 'text' : 'password'; // Cambia el tipo de campo a texto o password según el checkbox
    });
});
