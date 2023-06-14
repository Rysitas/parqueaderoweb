<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pagar') }}
        </h2>
    </x-slot>
    <div class="container mx-auto mt-10">
        <div class="max-w-md mx-auto bg-white p-5 rounded-md shadow-sm">
            <form action="{{ route('pagos.store') }}" method="POST">
                @csrf
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="mb-4">
                    <label for="placa" class="block text-gray-700 font-bold mb-2">{{ __('Placa del vehículo') }}</label>
                    <input id="placa" type="text" class="form-control form-control-lg @error('placa') is-invalid @enderror" name="placa" value="{{ old('placa') }}"  autocomplete="placa" autofocus maxlength="6" oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase();">
                    @error('placa')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="codigo_barras" class="block text-gray-700 font-bold mb-2">{{ __('Código de barras') }}</label>
                    <input type="text" name="codigo_barras" id="codigo_barras" class="form-control form-control-lg @error('codigo_barras') is-invalid @enderror" value="{{ old('codigo_barras') }}" placeholder="Escanee el código de barras">
                    @error('codigo_barras')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">{{ __('Pagar') }}</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary rounded-full" id="cancelar-btn">
                        {{ __('Cancelar') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/barcode.js') }}"></script>
