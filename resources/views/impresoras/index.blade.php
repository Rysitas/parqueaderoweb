<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Impresoras') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('impresoras.create') }}" class="btn btn-primary bg-transparent text-blue-500 hover:text-blue-700">
                    <i class="fa fa-print mr-2 text-blue-500"></i>
                    <i class="fa fa-plus text-blue-500" aria-hidden="true"></i>
                    Agregar impresora
                </a>
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
                                Nombre
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tamaño
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Activo
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($impresoras as $impresora)
                            <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $impresora->id }}
                                    </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $impresora->nombre }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $impresora->tamaño }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($impresora->activo)
                                        <form action="{{ route('impresoras.activar', $impresora->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-200 text-green-800 hover:bg-green-300">
                                                <span class="mr-2">Activa</span>
                                                <i class="fa fa-check-circle fa-lg"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('impresoras.activar', $impresora->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-800 hover:bg-gray-300">
                                                <span class="mr-2">Inactiva</span>
                                                <i class="fa fa-circle fa-lg"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('impresoras.edit', $impresora->id) }}" class="btn btn-link text-blue-500">
                                        <i class="fa fa-pencil fa-lg"></i></a>
                                    <form action="{{ route('impresoras.destroy', $impresora->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-red-500" onclick="return confirm('{{ __('¿Está seguro que desea eliminar esta impresora?') }}')"><i class="fa fa-trash fa-lg"></i></button>
                                    </button>                    
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>