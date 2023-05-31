<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Facturas') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                @if (Auth::check() && Auth::user()->tipo == 1)
                <a href="{{ route('facturas.create') }}" class="btn btn-primary bg-transparent text-blue-500 hover:text-blue-700">
                    <i class="fa fa-plus-square mr-2 text-blue-500"></i>
                    Agregar factura
                </a>
                @endif
                <a onclick="window.history.back()" class="btn btn-link text-gray-500 hover:text-gray-700" id="back-to-top">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </div>

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                #
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipo de documento
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipo de resolución
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Número
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Prefijo 
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Número inicial
                            </th>                      
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Número final
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha de vencimiento
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Activa
                            </th>
                            @if (Auth::check() && Auth::user()->tipo == 1)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($facturas as $factura)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $factura->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $factura->tipo_documento }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $factura->tipo_resolucion }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $factura->numero_resolucion }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $factura->prefijo_facturacion }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $factura->numero_factura_inicial }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $factura->numero_factura_final }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ date('Y-m-d', strtotime($factura->fecha_vencimiento)) }}
                                </td>
                              
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($factura->activa)
                                        <form action="{{ route('facturas.activar', $factura->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-200 text-green-800 hover:bg-green-300">
                                                <span class="mr-2">Activo</span>
                                                <i class="fa fa-check-circle fa-lg"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('facturas.activar', $factura->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-800 hover:bg-gray-300">
                                                <span class="mr-2">Inactivo</span>
                                                <i class="fa fa-circle fa-lg"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                                @if (Auth::check() && Auth::user()->tipo == 1)
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('facturas.edit', $factura->id) }}" class="text-blue-600 hover:text-blue-900 mr-1">
                                        <i class="fa fa-pencil fa-lg"></i></a>
                                    <form action="{{ route('facturas.destroy', $factura) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-red-500" onclick="return confirm('{{ __('¿Está seguro que desea eliminar esta resolucion de factura?') }}')"><i class="fa fa-trash fa-lg"></i></button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No hay registros.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>