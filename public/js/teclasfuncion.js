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
