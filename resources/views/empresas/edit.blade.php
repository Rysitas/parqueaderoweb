<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar empresa') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('empresas.update', $empresa->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de la empresa') }}</label>

                                <div class="col-md-6">
                                    <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre', $empresa->nombre) }}" required autocomplete="nombre" autofocus>

                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            </br>
                            <div class="form-group row">
                                <label for="nit" class="col-md-4 col-form-label text-md-right">{{ __('NIT') }}</label>

                                <div class="col-md-6">
                                    <input id="nit" type="text" class="form-control @error('nit') is-invalid @enderror" name="nit" value="{{ old('nit', $empresa->nit) }}" required autocomplete="nit">

                                    @error('nit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            </br>
                            <div class="form-group row">
                                <label for="horario_atencion" class="col-md-4 col-form-label text-md-right">{{ __('Horario de atención') }}</label>

                                <div class="col-md-6">
                                    <textarea id="horario_atencion" class="form-control @error('horario_atencion') is-invalid @enderror" name="horario_atencion" required autocomplete="horario_atencion">{{ old('horario_atencion', $empresa->horario_atencion) }}</textarea>

                                    @error('horario_atencion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            </br>
                            <div class="form-group row">
                                <label for="gerente" class="col-md-4 col-form-label text-md-right">{{ __('Gerente') }}</label>

                                <div class="col-md-6">
                                    <input id="gerente" type="text" class="form-control @error('gerente') is-invalid @enderror" name="gerente" value="{{ old('gerente', $empresa->gerente) }}" required autocomplete="gerente">

                                    @error('gerente')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            </br>
                            <div class="form-group row">
                                <label for="ciudad" class="col-md-4 col-form-label text-md-right">{{ __('Ciudad') }}</label>

                                <div class="col-md-6">
                                    <input id="ciudad" type="text" class="form-control @error('ciudad') is-invalid @enderror" name="ciudad" value="{{ old('ciudad', $empresa->ciudad) }}" required autocomplete="ciudad">

                                    @error('ciudad')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            </br>
                            <div class="form-group row">
                                <label for="direccion" class="col-md-4 col-form-label text-md-right">{{ __('Dirección') }}</label>

                                <div class="col-md-6">
                                    <textarea id="direccion" class="form-control @error('direccion') is-invalid @enderror" name="direccion" required autocomplete="direccion">{{ old('direccion', $empresa->direccion) }}</textarea>

                                    @error('direccion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            </br>
                            <div class="form-group row">
                                <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripción') }}</label>

                                <div class="col-md-6">
                                    <textarea id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" required autocomplete="descripcion">{{ old('descripcion', $empresa->descripcion) }}</textarea>

                                    @error('descripcion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            </br>
                            <div class="form-group row">
                                <label for="iva" class="col-md-4 col-form-label text-md-right">{{ __('Responsable del IVA') }}</label>

                                <div class="col-md-6">
                                    <select id="iva" class="form-control @error('iva') is-invalid @enderror" name="iva">
                                        <option value="Si" @if($empresa->iva == 'Si') selected @endif>Responsable del IVA</option>
                                        <option value="No" @if($empresa->iva == 'No') selected @endif>No responsable del IVA</option>
                                    </select>

                                    @error('iva')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            </br>
                            <div class="form-group row">
                                <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Logo') }}</label>
                                <div class="col-md-6">
                                    @if ($empresa->logo)
                                        <img src="{{ asset($empresa->logo) }}" alt="Logo actual" style="max-width: 100px;">
                                    @else
                                        <p>No se ha cargado ningún logo para la empresa</p>
                                    @endif
                                    <br>
                                    <input id="logo" type="file" class="form-control-file @error('logo') is-invalid @enderror" name="logo" accept="image/*">
                                    @error('logo')
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
                                        {{ __('Actualizar empresa') }}
                                    </button>
                                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
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
