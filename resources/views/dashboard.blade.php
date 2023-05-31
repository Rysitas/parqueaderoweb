<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if ($empresa)
            <!-- Mostrar logo y nombre de la empresa -->
            {{ $empresa->nombre }}
            @else
            <!-- Mostrar mensaje de que la empresa no existe -->
            {{ __('Parqueadero') }}
            @endif          
        </h2>
    </x-slot>

    <div class="py-12 flex flex-col">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex flex-col sm:flex-row">
                    <div class="sm:flex-1 mr-5">
                        @include('empresas.index')
                    </div>
                    <div class="w-full sm:w-1/3">
                        @if ($empresa)
                        <ul class="list-group mt-4">
                            <li class="list-group-item">
                                <a href="{{ route('vehiculos_ingresados.create') }}" class="bg-white border-yellow-400 border-2 text-black px-4 py-2  flex items-center w-48 h-10">
                                    <i class="fa fa-car mr-2"></i>
                                    <i class="fa fa-plus"></i>
                                    <span class="text-base font-medium ml-2 text-sm">Nuevo ingreso</span>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="{{ route('pagos.create') }}" class="bg-white border-green-400 border-2 text-black px-4 py-2  flex items-center w-48 h-10">
                                    <i class="fa  fa-usd "></i>
                                    <span class="text-base font-medium ml-2 text-sm">Pagar</span>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="{{ route('configuraciones.index') }}" class="bg-white border-blue-400 border-2 text-black px-4 py-2  flex items-center w-48 h-10">
                                    <i class="fa fa-cogs"></i>
                                    <span class="text-base font-medium ml-2 text-sm"> Configuración</span>                                 
                                </a>
                            </li>                          
                        </ul>
                        <div class="mt-4 text-center">
                            <span class="text-base font-medium mr-2">Para Ingresar vehículo </span>
                            <span class="text-yellow-500 font-medium">F9</span><br>
                            <span class="text-base font-medium mx-2">Para pagos </span>
                            <span class="text-green-500 font-medium">F10</span>
                        </div>
                        @else
                        <div class="mt-4 text-left">
                            <span class="text-gray-500 font-medium">La empresa no existe.</span>
                        </div>
                        @endif
                    </div>                                                  
                </div>                            
            </div>
        </div>
    </div>
</x-app-layout>
