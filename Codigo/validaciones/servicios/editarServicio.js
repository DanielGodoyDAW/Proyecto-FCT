function editarPromocion(idPromocion) {
    let width = 700;
    let height = 550;
    let left = (window.screen.width / 2) - (width / 2);
    let top = (window.screen.height / 2) - (height / 2);

    window.open(
        `/Codigo/validaciones/servicios/editar_servicios.php?idPromocion=${idPromocion}`,
        "Editar Servicio",
        `width=${width},height=${height},left=${left},top=${top},scrollbars=yes,resizable=yes`
    );
}
function eliminarPromocion(idPromocion) {
    if (confirm("¿Estás seguro de que deseas eliminar este servicio?")) {
        window.location.href = `/Codigo/validaciones/servicios/eliminar_servicios.php?idPromocion=${idPromocion}`;
    }
}