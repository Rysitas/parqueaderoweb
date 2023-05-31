<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tarifas') }}
        </h2>
    </x-slot>
    
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">{{ __('Crear Tarifa') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('tarifas.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="tipo_vehiculo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de vehículo') }}</label>

                                <div class="col-md-6">
                                    <input id="tipo_vehiculo" type="text" class="form-control @error('tipo_vehiculo') is-invalid @enderror" name="tipo_vehiculo" value="{{ old('tipo_vehiculo') }}" required autocomplete="tipo_vehiculo" autofocus>

                                    @error('tipo_vehiculo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            </br>
                            <div class="form-group row">
                                <label for="precio_hora" class="col-md-4 col-form-label text-md-right">{{ __('Precio por hora') }}</label>

                                <div class="col-md-6">
                                    <input id="precio_hora" type="number" class="form-control @error('precio_hora') is-invalid @enderror" name="precio_hora" value="{{ old('precio_hora') }}" required autocomplete="precio_hora">

                                    @error('precio_hora')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            </br>
                            <div class="form-group row">
                                <label for="precio_media_hora" class="col-md-4 col-form-label text-md-right">{{ __('Precio por Media Hora') }}</label>
                                <div class="col-md-6">
                                    <input id="precio_media_hora" type="number" step="0.01" class="form-control @error('precio_media_hora') is-invalid @enderror" name="precio_media_hora" value="{{ old('precio_media_hora')}}" required autocomplete="precio_media_hora" autofocus>
                                    @error('precio_media_hora')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            </br>
                            <div class="form-group row">
                                <label for="precio_fraccion_hora" class="col-md-4 col-form-label text-md-right">{{ __('Precio por Fracción de Hora') }}</label>
                                <div class="col-md-6">
                                    <input id="precio_fraccion_hora" type="number" step="0.01" class="form-control @error('precio_fraccion_hora') is-invalid @enderror" name="precio_fraccion_hora" value="{{ old('precio_fraccion_hora')}}" required autocomplete="precio_fraccion_hora" autofocus>

                                    @error('precio_fraccion_hora')
                                        <span class="invalid-feedback" role="alert">

                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            </br>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white border-transparent py-2 px-4 rounded mr-2">
                                        {{ __('Crear') }}
                                    </button>
                                    <a href="{{ route('tarifas.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 border-transparent py-2 px-4 rounded">
                                        {{ __('Cancelar') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

