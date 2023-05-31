<x-app-layout> 
    <x-slot name="header"> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight"> 
            {{ __('Editar factura') }} 
        </h2> 
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('facturas.index') }}" class="btn btn-primary bg-transparent text-blue-500 hover:text-blue-700">
                    <i class="fa fa-arrow-left mr-2 text-blue-500"></i>
                    Volver
                </a>
            </div>
    
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
    
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('facturas.update', $factura->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="tipo_documento" class="block text-gray-700 font-bold mb-2">Tipo de documento:</label>
                        <select name="tipo_documento" id="tipo_documento" class="form-select rounded-md shadow-sm mt-1 block w-full" required autofocus>
                            <option value="">Seleccione un tipo de documento</option>
                            <option value="Factura de Venta POS"{{ $factura->tipo_documento == 'Factura de Venta POS' ? ' selected' : '' }}>Factura de Venta POS</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="tipo_resolucion" class="block text-gray-700 font-bold mb-2">Tipo de resolución:</label>
                        <select name="tipo_resolucion" id="tipo_resolucion" class="form-select rounded-md shadow-sm mt-1 block w-full" required>
                            <option value="">Seleccione un tipo de resolución</option>
                            @foreach ($tipos_resolucion as $tipo_resolucion)
                                <option value="{{ $tipo_resolucion }}"{{ $factura->tipo_resolucion == $tipo_resolucion ? ' selected' : '' }}>{{ $tipo_resolucion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="numero_resolucion" class="block text-gray-700 font-bold mb-2">Número de resolución:</label>
                        <input type="text" name="numero_resolucion" id="numero_resolucion" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ $factura->numero_resolucion }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="prefijo_facturacion" class="block text-gray-700 font-bold mb-2">Prefijo de facturación:</label>
                        <input type="text" name="prefijo_facturacion" id="prefijo_facturacion" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ $factura->prefijo_facturacion }}">
                    </div>
                    <div class="mb-4">
                        <label for="fecha_autorizacion" class="block text-gray-700 font-bold mb-2">Fecha de autorización:</label>
                        <input type="date" name="fecha_autorizacion" id="fecha_autorizacion" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ $factura->fecha_autorizacion }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="numero_factura_inicial" class="block text-gray-700 font-bold mb-2">Número de factura inicial:</label>
                        <input type="number" name="numero_factura_inicial" id="numero_factura_inicial" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ $factura->numero_factura_inicial }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="numero_factura_actual" class="block text-gray-700 font-bold mb-2">Número de factura actual:</label>
                        <input type="number" name="numero_factura_actual" id="numero_factura_actual" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ $factura->numero_factura_actual }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="numero_factura_final" class="block text-gray-700 font-bold mb-2">Número de factura final:</label>
                        <input type="number" name="numero_factura_final" id="numero_factura_final" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ $factura->numero_factura_final }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="fecha_inicio" class="block text-gray-700 font-bold mb-2">Fecha de inicio:</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ $factura->fecha_inicio }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="fecha_vencimiento" class="block text-gray-700 font-bold mb-2">Fecha de vencimiento:</label>
                        <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ $factura->fecha_vencimiento }}" required>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="ml-3 inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-600 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                            Actualizar factura
                          </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>