<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tiquetes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="card">
                    <div class="card-header">Tiquetes</div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Placa</th>
                                        <th>Tipo de vehículo</th>
                                        <th>Hora de entrada</th>
                                        <th>Hora de salida</th>
                                        <th>Horas transcurridas</th>
                                        <th>Valor a total (IVA)</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $tiqueteData)
                                        <tr>
                                            <td>{{ $tiqueteData['tiquete']->placa }}</td>
                                            <td>{{ $tiqueteData['tiquete']->tipo_vehiculo }}</td>
                                            <td>{{ $tiqueteData['hora_entrada'] }}</td>
                                            <td>{{ $tiqueteData['hora_salida'] }}</td>
                                            <td>{{ $tiqueteData['horas_transcurridas'] }}</td>
                                            <td>{{ $tiqueteData['tiquete']->valor_pagar }}</td>
                                            <td>
                                                <a href="{{ route('pagos.show', $tiqueteData['tiquete']->id) }}" class="btn btn-link">
                                                <i class="fa fa-eye text-blue-500 bg-transparent rounded-full text-2xl"></i>          
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No hay registros.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                             {{ $tiquetes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
