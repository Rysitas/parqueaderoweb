<!DOCTYPE html>
<html>
<head>
    <title>Ticket de ingreso</title>
    <style>
@media print {
    /* Estilos específicos para la impresión */
    /* Asegúrate de que el contenido se ajuste correctamente en el papel */
    body {
        width: 100%;
        margin: 0;
        padding: 0;
    }
}
@media print {
    body {
        transform: scale(1);
        transform-origin: top left;
    }
}


    </style>
</head>
<body>
    <div class="ticket">
        <h1 style="text-align: center">{{ $nombreEmpresa }}</h1>
        <p><strong>N.I.T:</strong> {{ $nit }}</p>
        <p><strong>Placa:</strong> {{ $placa }}</p>
        <p><strong>Tipo:</strong> {{ $tipo }}</p>
        <p><strong>Entrada:</strong> {{ $entrada }}</p>
        <p class="barcode">
            {!! $codigo_barras !!}
        
        </p>
        <div class="descripcion">
            <p>{{ $descripcion }}</p>
        </div>
    </div>
</body>
</html>
