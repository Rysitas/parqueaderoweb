console.log("El archivo teclasfuncion.js se ha cargado correctamente -- Este sirve para entrar con F9 Y F10 a los pagos y creaciones de ingresos");

document.addEventListener('keydown', function(event) {
    if (event.code === 'F9') {
        event.preventDefault();
        let url = new URL("ingresos/create", window.location.origin);
        window.location.href = url.pathname;
    } else if (event.code === 'F10') {
        event.preventDefault();
        let url = new URL("pagos/create", window.location.origin);
        window.location.href = url.pathname;
    }
});
