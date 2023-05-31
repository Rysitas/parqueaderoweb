<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Configuraciones') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-3 gap-4">
                @if (Auth::check() && Auth::user()->tipo == 1)
                <a href="{{ route('empresas.create') }}" class="btn btn-primary bg-transparent text-blue-500 hover:text-blue-700 px-4 py-2">
                    <i class="fa fa-building mr-2 text-blue-500"></i>
                    Empresas
                </a>   
                <a href="{{ route('admin.index') }}" class="btn btn-primary bg-transparent text-blue-500 hover:text-blue-700 px-4 py-2">
                    <i class="fa fa-user mr-2 text-blue-500"></i>
                    Administradores
                </a>         
                @endif     
                <a href="{{ route('impresoras.index') }}" class="btn btn-primary bg-transparent text-blue-500 hover:text-blue-700 px-4 py-2">
                    <i class="fa fa-print mr-2 text-blue-500"></i>
                    Impresoras
                </a>
                <a href="{{ route('facturas.index') }}" class="btn btn-primary bg-transparent text-blue-500 hover:text-blue-700 px-4 py-2">
                    <i class="fa fa-ticket mr-2 text-blue-500"></i>
                    Facturas
                </a>
            </div>
        </div>
    </div>
</x-app-layout>