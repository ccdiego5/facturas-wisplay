<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @if(isset($user))
                Editar Usuario
            @else
                Crear Usuario
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto">

            {{-- Errores de validación --}}
            @if($errors->any())
                <div class="alert alert-error mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li class="text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulario --}}
            @if(isset($user))
                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @method('PUT')
            @else
                <form method="POST" action="{{ route('users.store') }}">
            @endif
                @csrf

                <!-- Nombre -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Nombre</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        class="input input-bordered w-full"
                        value="{{ old('name', $user->name ?? '') }}"
                        required
                    />
                </div>

                <!-- Email -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input
                        type="email"
                        name="email"
                        class="input input-bordered w-full"
                        value="{{ old('email', $user->email ?? '') }}"
                        required
                    />
                </div>

                <!-- Password -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Contraseña</span>
                    </label>
                    <input
                        type="password"
                        name="password"
                        class="input input-bordered w-full"
                    />
                    @if(isset($user))
                        <small class="text-gray-500">
                            Deja vacío para no cambiar la contraseña.
                        </small>
                    @endif
                </div>

                <!-- Confirmar Password -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Confirmar Contraseña</span>
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="input input-bordered w-full"
                    />
                </div>

                <!-- Google Sheet Link -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Google Sheet Link</span>
                    </label>
                    @php
                        $urlSheet = '';
                        if(isset($user) && $user->googleSheetLinks()->exists()) {
                            $urlSheet = $user->googleSheetLinks->first()->url_sheet;
                        }
                    @endphp
                    <input
                        type="url"
                        name="url_sheet"
                        class="input input-bordered w-full"
                        value="{{ old('url_sheet', $urlSheet) }}"
                    />
                </div>

                <!-- Botones -->
                <button type="submit" class="btn btn-primary">
                    @if(isset($user))
                        Actualizar
                    @else
                        Guardar
                    @endif
                </button>
                <a href="{{ route('dashboard') }}" class="btn ml-2">Cancelar</a>
            </form>
        </div>
    </div>
</x-app-layout>
