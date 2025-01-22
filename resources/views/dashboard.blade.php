<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensaje de éxito al crear/editar/eliminar --}}
            @if(session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Botón de crear --}}
                <a href="{{ route('users.create') }}" class="btn btn-primary mb-4">
                    Crear Usuario
                </a>

                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <!-- Encabezados -->
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Google Sheet Link</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <!-- Cuerpo -->
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>

                                    {{-- Verificar si existe al menos un registro en googleSheetLinks --}}
                    @if($user->googleSheetLinks->isNotEmpty())
                        <a href="{{ $user->googleSheetLinks->first()->url_sheet }}"
                           class="link link-primary"
                           target="_blank">
                           Ver Link
                        </a>
                    @else
                        <span class="text-gray-500">Sin Enlace</span>
                    @endif
                                    </td>
                                    <td>
                                        {{-- Editar --}}
                                        <a href="{{ route('users.edit', $user->id) }}"
                                           class="btn btn-sm btn-primary">
                                           Editar
                                        </a>

                                        {{-- Eliminar --}}
                                        <form action="{{ route('users.destroy', $user->id) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('¿Seguro que deseas eliminar?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-error">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- fin overflow-x-auto -->
            </div> <!-- fin bg-white -->
        </div>
    </div>
</x-app-layout>
