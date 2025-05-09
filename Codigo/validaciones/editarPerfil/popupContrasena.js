//funcion para motrar el formulario de cambiar contraseña
function mostrarCambioPass() {
    const perfil = document.getElementById("perfil");
    const cambiarPass = document.getElementById("cambiarPass");

    perfil.style.display = "none";
    cambiarPass.style.display = "block";
}

//funcion para mostrar el formulario de editar perfil
function mostrarEdit(){
    const perfil = document.getElementById("perfil");
    const cambiarPass = document.getElementById("cambiarPass");

    perfil.style.display = "block";
    cambiarPass.style.display = "none";
}

//funcion para mostrar la contraseña en los 3 campos de contraseña
document.getElementById('mostrarContrasena').addEventListener('change', function() {
    const passwordFields = [
        document.getElementById('passwordActual'),
        document.getElementById('nuevaContrasena'),
        document.getElementById('confirmarContrasena')
    ];
    passwordFields.forEach(field => {
        field.type = this.checked ? 'text' : 'password';
    });
});
