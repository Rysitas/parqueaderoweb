<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vehículos Ingresados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="card">
                    <div class="card-body">
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
                                    <th scope="col">Placa</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Fecha y Hora</th>
                                    <th scope="col">Pagado</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-ingresados">
                                @include('vehiculos_ingresados.tabla_ingresados', ['registros' => $registros])
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $registros->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</x-app-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/filtroPlaca.js') }}"></script>