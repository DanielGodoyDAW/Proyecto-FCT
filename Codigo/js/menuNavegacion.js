// Espera a que el DOM esté completamente cargado
document.addEventListener("DOMContentLoaded", () => {
    // Obtiene solo el nombre del archivo actual (por ejemplo, admin.php)
    const rutaActual = window.location.pathname.split("/").pop();

    // Selecciona todos los enlaces del menú que tengan la clase "navegacion"
    const enlacesNavegacion = document.querySelectorAll(".navegacion");

    // Recorre cada enlace y compara su href con la ruta actual
    enlacesNavegacion.forEach(link => {
        // Obtiene solo el nombre del archivo desde el href del enlace
        const rutaLink = link.getAttribute("href").split("/").pop();

        // Si el archivo coincide con la ruta actual, añade la clase "active"
        if (rutaLink === rutaActual) {
            link.classList.add("active");
        }
    });
});
