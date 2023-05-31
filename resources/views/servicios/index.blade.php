<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Servicios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                @if (Auth::check() && Auth::user()->tipo == 1)
                                <a href="{{ route('servicios.create') }}" class="btn btn-primary bg-transparent text-blue-500 hover:text-blue-700">
                                    <i class="fa fa-cogs mr-2"></i>{{ __('Crear Servicio') }}
                                </a>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <form action="{{ route('servicios.index') }}" method="get">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" placeholder="{{ __('Buscar por nombre de servicio') }}" value="{{ $search }}">
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
                  
                                    <th scope="col">{{ __('Nombre') }}</th>
                                    <th scope="col">{{ __('Precio') }}</th>
                                    @if (Auth::check() && Auth::user()->tipo == 1)
                                    <th scope="col">{{ __('Acciones') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($servicios as $servicio)
                                    <tr>
                           
                                        <td>{{ $servicio->nombre }}</td>
                                        <td>{{ $servicio->precio }}</td>
                                        @if (Auth::check() && Auth::user()->tipo == 1)
                                        <td>
                                            <a href="{{ route('servicios.edit', $servicio) }}" class="btn btn-link text-blue-500">
                                                <i class="fa fa-pencil fa-lg"></i></a>
                                            </a>
                                            <form style="display: inline-block;" method="POST" action="{{ route('servicios.destroy', $servicio) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-red-500" onclick="return confirm('{{ __('¿Está seguro que desea eliminar est servicio?') }}')"><i class="fa fa-trash fa-lg"></i></button>
                                                </button>
                                            </form>
                                        </td>
                                        @endif
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No hay servicios.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
