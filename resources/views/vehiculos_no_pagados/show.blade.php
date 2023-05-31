<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle de vehículo no pagado') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-2xl font-bold">{{ $vehiculoNoPagado->placa }}</div>
                        <a href="{{ route('vehiculos_no_pagados.index') }}" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-md">
                            <i class="fa  fa-arrow-left bg-transparent rounded-full"></i>
                            Volver
                        </a>
                    </div>
                    <hr class="my-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-500"><strong>Fecha de entrada:</strong> {{ date('m/d/Y - h:i:s A', strtotime($vehiculoNoPagado->entrada)) }}</p>
                            <p class="text-gray-500"><strong>Tiempo transcurrido:</strong> {{ $tiempo_transcurrido }}</p>
                            <p class="text-gray-500"><strong>Tipo de vehiculo:</strong> {{ $vehiculoNoPagado->tipo }}</p>

                        </div>
                        <div>
                            <p class="text-gray-500"><strong>Estimado del servicio actual:</strong> {{ $valor_servicio_parqueadero }}</p>
                            @if ($valor_servicio > 0)
                                <p class="text-gray-500"><strong>Valor del servicio solicitado:</strong> {{ $valor_servicio }}</p>
                            @endif
                            @if ($iva == 'Si')
                                <p class="text-gray-500"><strong>Valor del IVA con el estimado actual:</strong> {{ $valor_iva }}</p>
                            @endif
                            <p class="text-gray-500"><strong>Estimado a pagar:</strong> {{ $valor_pagar }}</p>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="text-gray-500">
                        <p><strong>Servicios solicitados:</strong></p>
                        @if ($num_servicios > 0)
                            <ul class="list-disc list-inside">
                                @foreach ($servicios_nombres as $servicio)
                                    <li>{{ $servicio }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>Sin servicios solicitados</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>    
</x-app-layout>
