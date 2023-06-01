<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vehículos No Pagos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-3 d-flex justify-content-end align-items-center">
                        <span class="filter-text me-3">Filtrar por placa:</span>
                        <div class="col-sm-4">
                            <input type="text" name="placa-filtro" id="placa-filtro" class="form-control" placeholder="Escribe la placa...">
                        </div>
                    </div>
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Placa</th>
                                <th>Tipo</th>
                                <th>Hora de entrada</th>
                                <th>Estado del pago</th>
                                <th>Solicitudes de servicios</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-no-pagados" name="tabla-no-pagados">
                            @include('vehiculos_no_pagados.tabla_no_pagos', ['vehiculosNoPagados' => $vehiculosNoPagados])
                        </tbody>
                    </table>
                </div>
                <div class="p-6 d-flex justify-content-center">
                     {{ $vehiculosNoPagados->links() }}
                </div>
            </div>
        </div>
    </div>
    

</x-app-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ secure_asset('js/filtroPlacaNoPagado.js') }}"></script>