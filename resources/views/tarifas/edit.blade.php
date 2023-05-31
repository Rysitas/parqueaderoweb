<x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Tarifa') }}
            </h2>
        </x-slot>
                 <div class="container">
                        <form method="POST" action="{{ route('tarifas.update', $tarifa->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label for="tipo_vehiculo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de Vehículo') }}</label>

                                <div class="col-md-6">
                                    <input id="tipo_vehiculo" type="text" class="form-control @error('tipo_vehiculo') is-invalid @enderror" name="tipo_vehiculo" value="{{ old('tipo_vehiculo', $tarifa->tipo_vehiculo) }}" required autocomplete="tipo_vehiculo" autofocus>

                                    @error('tipo_vehiculo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            </br>
                            <div class="form-group row">
                                <label for="precio_hora" class="col-md-4 col-form-label text-md-right">{{ __('Precio por Hora') }}</label>

                                <div class="col-md-6">
                                    <input id="precio_hora" type="number" step="0.01" class="form-control @error('precio_hora') is-invalid @enderror" name="precio_hora" value="{{ old('precio_hora', $tarifa->precio_hora) }}" required autocomplete="precio_hora" autofocus>

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
                                    <input id="precio_media_hora" type="number" step="0.01" class="form-control @error('precio_media_hora') is-invalid @enderror" name="precio_media_hora" value="{{ old('precio_media_hora', $tarifa->precio_media_hora) }}" required autocomplete="precio_media_hora" autofocus>

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
                                    <input id="precio_fraccion_hora" type="number" step="0.01" class="form-control @error('precio_fraccion_hora') is-invalid @enderror" name="precio_fraccion_hora" value="{{ old('precio_fraccion_hora', $tarifa->precio_fraccion_hora) }}" required autocomplete="precio_fraccion_hora" autofocus>

                                    @error('precio_fraccion_hora')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            </br>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-600 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo disabled:opacity-25 transition ease-in-out duration-150">
                                        {{ __('Actualizar tarfia') }}
                                    </button>
                                    <a href="{{ route('tarifas.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                        {{ __('Cancelar') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
</x-app-layout>
