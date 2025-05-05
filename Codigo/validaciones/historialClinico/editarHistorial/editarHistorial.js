// Cuando se cargue editarHistorial.php, redirige automáticamente si no hay ?idPaciente
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    if (!urlParams.has('idPaciente')) {
        const pacienteId = localStorage.getItem('pacienteSeleccionado');
        if (pacienteId) {
            window.location.href = "?idPaciente=" + pacienteId;
        }
    }
});
