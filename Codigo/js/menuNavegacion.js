document.addEventListener("DOMContentLoaded", () => {
    const rutaActual = window.location.pathname; // Obtiene la ruta actual
    const enlacesNavegacion = document.querySelectorAll(".navegacion"); // Selecciona todos los enlaces del menú

    enlacesNavegacion.forEach(link => {
        if (link.getAttribute("href") === rutaActual) {
            link.classList.add("active");
        }
    });
});