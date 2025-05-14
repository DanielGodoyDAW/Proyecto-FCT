document.addEventListener("DOMContentLoaded", () => {
    const rutaActual = window.location.pathname; // Obtiene la ruta actual
    const enlacesNavegacion = document.querySelectorAll(".navegacion"); // Selecciona todos los enlaces del menú

    enlacesNavegacion.forEach(link => { // Recorre cada enlace
        if (link.getAttribute("href") === rutaActual) { // Si el enlace coincide con la ruta actual
            link.classList.add("active"); // Añade la clase activa al enlace
        }
    });
});