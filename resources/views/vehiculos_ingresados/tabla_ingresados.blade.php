@forelse($registros as $registro)
    <tr>
        <td>{{ $registro->placa }}</td>
        <td>{{ $registro->tipo }}</td>
        <td>{{ date('m/d/Y - h:i:s A', strtotime($registro->entrada)) }}</td>
        <td>
            @if ($registro->pagado == 'no')
                <span class="badge badge-danger text-white">No pagado</span>
            @else
                <span class="badge badge-success text-white">Pagado</span>
            @endif
        </td>
        <td>
            <a href="{{ route('vehiculos_ingresados.imprimir', $registro->id) }}" class="btn btn-link imprimir-ticket" data-id="{{ $registro->id }}">
                <i class="fa fa-file-pdf-o text-blue-500 bg-transparent rounded-full text-2xl"></i>
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center">No hay registros disponibles.</td>
    </tr>
@endforelse

<script>
    $(document).ready(function() {
        $('.imprimir-ticket').click(function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var id = $(this).data('id');
            var nuevaVentana = window.open(url, '_blank', 'toolbar=0,location=0,menubar=0');

            nuevaVentana.onload = function () {
                nuevaVentana.print();
        }
        });
    });
</script>

