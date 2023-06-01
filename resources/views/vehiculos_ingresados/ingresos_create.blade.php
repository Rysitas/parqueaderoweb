<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ingreso de Vehículo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('vehiculos_ingresados.store') }}">
                        @csrf
                        @if (session('error'))
                            <div class="alert alert-success" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="form-group row">
                            <label for="placa" class="col-md-4 col-form-label text-md-right">{{ __('Placa') }}</label>

                            <div class="col-md-6">
                                <input id="placa" type="text" class="form-control form-control-lg @error('placa') is-invalid @enderror" name="placa" value="{{ old('placa') }}" required autocomplete="placa" autofocus maxlength="6" oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase(); actualizarTipoVehiculo(); validarPlaca();">

                                @error('placa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        </br>
                        <div class="form-group row">
                            <label for="tipo_vehiculo" class="col-md-4 col-form-label text-md-left">{{ __('Tipo de Vehículo') }}</label>

                            <div class="col-md-6">
                                <select id="tipo_vehiculo" class="form-control @error('tipo_vehiculo') is-invalid @enderror" name="tipo_vehiculo" required>
                                    <option value="">Seleccione el tipo de vehículo</option>
                                    @foreach($tarifas as $tarifa)
                                        <option class="option-black" value="{{ $tarifa->tipo_vehiculo }}" @if(old('tipo_vehiculo') == $tarifa->tipo_vehiculo) selected  @endif>{{ $tarifa->tipo_vehiculo }}</option>
                                    @endforeach
                                </select>

                                @error('tipo_vehiculo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        </br>

                        @if(count($servicios) > 0)
                            @foreach($servicios as $servicio)
                                <div class="form-group row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-6">
                                        <label>
                                            <input type="checkbox" name="servicios[]" value="{{ $servicio->id }}" style="vertical-align: middle;"> {{ $servicio->nombre }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        </br>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="guardar-btn">
                                    {{ __('Ingresar') }}
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary" id="cancelar-btn">
                                    {{ __('Cancelar') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
<script src="{{ secure_asset('js/datosIngreso.js') }}"></script>
<link href="{{ secure_asset('css/crearIngreso.css') }}" rel="stylesheet">

