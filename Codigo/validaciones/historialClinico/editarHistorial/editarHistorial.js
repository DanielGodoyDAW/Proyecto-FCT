// Cuando se cargue editarHistorial.php, redirige automáticamente si no hay ?idPaciente
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search); // Obtenemos los parámetros de la URL
    if (!urlParams.has('idPaciente')) { // Si no hay idPaciente en la URL
        const pacienteId = localStorage.getItem('pacienteSeleccionado'); // ID del paciente
        if (pacienteId) { // Si hay ID de paciente en localStorage
            window.location.href = "?idPaciente=" + pacienteId; // Redirige a la página con el ID del paciente
        }
    }
});
