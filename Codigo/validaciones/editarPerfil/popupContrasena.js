function mostrarCambioPass() {
    const perfil = document.getElementById("perfil");
    const cambiarPass = document.getElementById("cambiarPass");

    perfil.style.display = "none";
    cambiarPass.style.display = "block";
}

function mostrarEdit(){
    const perfil = document.getElementById("perfil");
    const cambiarPass = document.getElementById("cambiarPass");

    perfil.style.display = "block";
    cambiarPass.style.display = "none";
}

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
