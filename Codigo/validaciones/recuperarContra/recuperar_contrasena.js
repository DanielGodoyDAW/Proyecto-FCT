// Función para mostrar el formulario de recuperación de contraseña
function mostrarRecuperar() {
    const login = document.getElementById("login"); // Formulario de inicio de sesión
    const recuperar = document.getElementById("recuperar"); // Formulario de recuperación de contraseña

    login.style.display = "none"; // Oculta el formulario de inicio de sesión
    recuperar.style.display = "flex"; // Muestra el formulario de recuperación de contraseña (usa flex para mantener el layout)
}

// Función para mostrar el formulario de inicio de sesión
function mostrarInicio() {
    const login = document.getElementById("login"); // Formulario de inicio de sesión
    const recuperar = document.getElementById("recuperar"); // Formulario de recuperación de contraseña

    recuperar.style.display = "none"; // Oculta el formulario de recuperación de contraseña
    login.style.display = "flex"; // Muestra el formulario de inicio de sesión (usa flex para mantener el layout)

    void login.offsetWidth; // Fuerza el reflujo visual para corregir posibles fallos de renderizado al volver
    login.style.display = "flex"; // Se repite por seguridad tras el reflow
}
