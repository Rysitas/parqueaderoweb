<x-app-layout>
    <x-slot name="header">
        <h1>Detalle del tiquete</h1>
    </x-slot>

    <table class="table table-bordered">
        <tbody>
            <tr>
                <td><strong>Placa:</strong></td>
                <td>{{ $tiquete->placa }}</td>
            </tr>
            <tr>
                <td><strong>Tipo de vehículo:</strong></td>
                <td>{{ $tiquete->tipo_vehiculo }}</td>
            </tr>
            <tr>
                <td><strong>Hora de entrada:</strong></td>
                <td>{{ $hora_entrada }}</td>
            </tr>
            <tr>
                <td><strong>Hora de salida:</strong></td>
                <td>{{ $hora_salida }}</td>
            </tr>
            <tr>
                <td><strong>Valor de tiempo:</strong></td>
                <td>
                  Valor de hora: {{ $valor_hora }} <br>
                  Valor de media: {{ $valor_media }} <br>
                  Valor de fracción: {{ $valor_fraccion }}
                </td>
              </tr>              
            <tr>
                <td><strong>Horas transcurridas:</strong></td>
                <td>{{ $horas_transcurridas }}</td>
            </tr>
            <tr>
                <td><strong>Valor del servicio: </strong></td>
                <td>{{ $tiquete->valor_iva }}</td>
            </tr>
            <tr>
                <td><strong>Valor a pagar (IVA):</strong></td>
                <td>{{ $tiquete->valor_pagar }}</td>
            </tr>
        </tbody>
    </table>
    <div class="text-center">
        <a href="{{ back()->getTargetUrl() }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver
        </a>
    </div>
</x-app-layout>

<style>
    table {
        width: 100%;
        max-width: 600px;
        margin: 20px auto;
        border-collapse: collapse;
    }

    td {
        padding: 10px;
        border: 1px solid #ddd;
    }

    td:first-child {
        font-weight: bold;
        background-color: #f2f2f2;
    }

    .btn-primary {
        margin-top: 20px;
    }
</style>
