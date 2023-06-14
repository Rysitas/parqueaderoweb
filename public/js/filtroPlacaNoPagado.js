console.log("El archivo filtroNoPagado.js se ha cargado correctamente -- se usa para el filtro de los no pagos");

$(document).ready(function() {
    // Variable para almacenar el temporizador
    var timer;

    // Escuchar el evento 'keyup' del campo de búsqueda
    $('#placa-filtro').on('keyup', function() {
        // Cancelar el temporizador anterior si existe
        clearTimeout(timer);

        // Iniciar un nuevo temporizador de 500 milisegundos
        timer = setTimeout(function() {
            // Obtener el valor del campo de búsqueda
            var busqueda = $('#placa-filtro').val().trim();

            // Realizar una petición AJAX al controlador para obtener los resultados de la búsqueda
            $.ajax({
                url: "/vehiculos_no_pagados/filtroPlacaNoPagado?placa=" + encodeURIComponent(busqueda),
                dataType: 'html',
                success: function(response) {
                    // Actualizar la tabla de vehículos con los resultados de la búsqueda
                    $('tbody').html(response);
                },
                error: function() {
                    alert('Ocurrió un error al realizar la búsqueda.');
                }
            });
        }, 500);
    });
});
