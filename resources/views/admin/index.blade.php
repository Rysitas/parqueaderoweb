<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de administradores') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <a onclick="window.history.back()" class="btn btn-link text-gray-500 hover:text-gray-700" id="back-to-top">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </div>

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Tipo de usuario</th>
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr class="{{ $loop->iteration % 2 ? 'bg-gray-100' : '' }}">
                                <td class="border px-4 py-2">{{ $admin->id }}</td>
                                <td class="border px-4 py-2">{{ $admin->name }}</td>
                                <td class="border px-4 py-2">{{ $admin->email }}</td>
                                <td class="border px-4 py-2">{{ $admin->tipo == 1 ? 'Administrador' : 'Usuario' }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('admin.edit', $admin->id) }}" class="text-blue-600 hover:text-blue-900"><i class="fa fa-pencil fa-lg"></i></a>
                                    <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900"><i class="fa fa-trash fa-lg"></i></button>
                                    </form>
                                </td>                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>