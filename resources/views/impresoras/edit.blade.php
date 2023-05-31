<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Editar impresora') }}
      </h2>
    </x-slot>
  
    <div class="py-6">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <form action="{{ route('impresoras.update', $impresora->id) }}" method="POST" class="space-y-8 divide-y divide-gray-200">
            @csrf
            @method('PUT')
            <div class="space-y-8 divide-y divide-gray-200">
              <div class="py-6 px-4 sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                  <div class="col-span-6 sm:col-span-3">
                    <label for="nombre" class="block text-sm font-medium text-gray-700">
                      Nombre
                    </label>
                    <div class="mt-1">
                      <input type="text" name="nombre" id="nombre" autocomplete="nombre" value="{{ $impresora->nombre }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                    @error('nombre')
                      <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                  </div>
  
                  <div class="col-span-6 sm:col-span-3">
                    <label for="tamaño" class="block text-sm font-medium text-gray-700">
                      Tamaño
                    </label>
                    <div class="mt-1">
                      <select name="tamaño" id="tamaño" autocomplete="tamaño" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="40" {{ $impresora->tamaño == 40 ? 'selected' : '' }}>40 mm</option>
                        <option value="50" {{ $impresora->tamaño == 50 ? 'selected' : '' }}>50 mm</option>
                        <option value="80" {{ $impresora->tamaño == 80 ? 'selected' : '' }}>80 mm</option>
                      </select>
                    </div>
                    @error('tamaño')
                      <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
  
            <div class="py-3 px-4 sm:px-6 flex justify-between">
              <button onclick="window.history.back()" type="button" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                Cancelar
              </button>
              <button type="submit" class="ml-3 inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-600 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                Guardar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </x-app-layout>