@forelse($vehiculosNoPagados as $vehiculo)
    <tr>
        <td>{{ $vehiculo->placa }}</td>
        <td>{{ $vehiculo->tipo }}</td>
        <td>{{ date('m/d/Y - h:i:s A', strtotime($vehiculo->entrada)) }}</td>
        <td>
            @if ($vehiculo->pagado == 'no')
                <span class="badge badge-danger text-white">No pagado</span>
            @else
                {{ $vehiculo->pagado }}
            @endif
        </td>
        <td>
            @if ($vehiculo->num_servicios > 0)
                {{ $vehiculo->servicios_solicitados }}
            @else
                Sin servicios solicitados
            @endif
        </td>
        <td>
            @if ($vehiculo->pagado == 'no')
                <form action="{{ route('pagos.recibo', $vehiculo->placa) }}" method="post" id="imprimir-pago-{{ $vehiculo->placa }}" style="display: inline-block;">
                    @csrf
                    <button type="submit" data-id="{{ $vehiculo->placa }}" class="imprimir-pago" onclick="return confirm('¿Está seguro que desea pagar por el vehículo con la placa {{ $vehiculo->placa }}?')">
                        <i class="fa fa-usd text-blue-500 bg-transparent rounded-full text-2xl" style="margin-right: 10px;"></i>
                    </button>
                </form>
            @endif
            <a href="{{ route('vehiculos_no_pagados.show', $vehiculo->id) }}" style="display: inline-block;">
                <i class="fa fa-eye text-blue-500 bg-transparent rounded-full text-2xl"></i>
            </a>
        </td>               
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center">No hay vehículos no pagados.</td>
    </tr>
@endforelse

@if (session()->has('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<script>
    $(document).ready(function() {
        $('form').submit(function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var id = $(this).find('.imprimir-pago').data('id');
            var nuevaVentana = window.open(url, '_blank', 'toolbar=0,location=0,menubar=0');

            nuevaVentana.onload = function() {
                nuevaVentana.print();
    
                window.location.reload(); // Actualizar la página después de imprimir
                
            };
        });
    });
</script>
