function nuevaVentana() {
    let width = 800;
    let height = 600;
    let left = (window.screen.width / 2) - (width / 2);
    let top = (window.screen.height / 2) - (height / 2);

    window.open(
        "/Codigo/validaciones/recuperarContra/recuperar_contrasena.html",
        "popup",
        `width=${width},height=${height},left=${left},top=${top},scrollbars=yes,resizable=yes`
    );
}