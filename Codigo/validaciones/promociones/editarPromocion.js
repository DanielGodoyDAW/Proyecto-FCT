function editarPromocion(idPromocion) {
    let width = 600;
    let height = 400;
    let left = (window.screen.width / 2) - (width / 2);
    let top = (window.screen.height / 2) - (height / 2);

    window.open(
        `/Codigo/validaciones/promociones/editar_promocion.php?idPromocion=${idPromocion}`,
        "Editar Promoción",
        `width=${width},height=${height},left=${left},top=${top},scrollbars=yes,resizable=yes`
    );
}
function eliminarPromocion(idPromocion) {
    if (confirm("¿Estás seguro de que deseas eliminar esta promoción?")) {
        fetch(`/Codigo/validaciones/promociones/eliminar_promocion.php?idPromocion=${idPromocion}`, {
            method: 'GET'
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload(); // Recarga la página para actualizar la lista
        })
        .catch(error => {
            console.error("Error al eliminar la promoción:", error);
        });
    }
}