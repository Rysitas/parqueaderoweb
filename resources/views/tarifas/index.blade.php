<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tarifas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="row mb-3">
                        
                        <div class="col-md-6">
                            @if (Auth::check() && Auth::user()->tipo == 1)
                            <a href="{{ route('tarifas.create') }}" class="btn btn-primary bg-transparent text-blue-500 hover:text-blue-700">
                                <i class="fa fa-car mr-2" style="color: blue;"></i>
                                <i class="fa fa-plus" style="color: blue;"></i>
                            </a>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('tarifas.index') }}" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" placeholder="{{ __('Buscar por tipo de vehículo') }}" value="{{ $search }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">{{ __('Buscar') }}</button>
                                    </div>
                                </div>
                            </form>
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
               
                                <th scope="col">{{ __('Tipo de vehículo') }}</th>
                                <th scope="col">{{ __('Precio por hora') }}</th>
                                <th scope="col">{{ __('Precio por media hora') }}</th>
                                <th scope="col">{{ __('Precio por fracción de hora') }}</th>
                                @if (Auth::check() && Auth::user()->tipo == 1)
                                <th scope="col">{{ __('Acciones') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tarifas as $tarifa)
                                <tr>
                    
                                    <td>{{ $tarifa->tipo_vehiculo }}</td>
                                    <td>{{ $tarifa->precio_hora }}</td>
                                    <td>{{ $tarifa->precio_media_hora }}</td>
                                    <td>{{ $tarifa->precio_fraccion_hora }}</td>
                                    @if (Auth::check() && Auth::user()->tipo == 1)
                                    <td>
                                        <div class="btn-group" role="group" aria-label="{{ __('Acciones') }}">
                                            <a href="{{ route('tarifas.edit', $tarifa) }}" class="btn btn-link text-blue-500">
                                                <i class="fa fa-pencil fa-lg"></i></a>
                                            <form action="{{ route('tarifas.destroy', $tarifa->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-red-500" onclick="return confirm('{{ __('¿Está seguro que desea eliminar esta tarifa?') }}')"><i class="fa fa-trash fa-lg"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">{{ __('No se encontraron tarifas') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $tarifas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
