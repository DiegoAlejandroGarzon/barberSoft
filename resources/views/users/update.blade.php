@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
<title>Usuarios - Actualizar</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Actualizar Usuario</h2>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="intro-y box p-5">
            <form method="POST" action="{{ route('users.update', ['id' => $user->id]) }}">
                @csrf
                <div class="intro-y col-span-12 lg:col-span-6">
                    <x-base.form-label for="name">Nombre Completo</x-base.form-label>

                    <div class="grid-cols-2 gap-2 sm:grid">
                        <x-base.form-input
                            class="w-full {{ $errors->has('name') ? 'border-red-500' : '' }}"
                            id="name"
                            name="name"
                            type="text"
                            placeholder="Nombres"
                            value="{{$user->name}}"
                        />
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror

                        <x-base.form-input
                            class="w-full {{ $errors->has('lastname') ? 'border-red-500' : '' }}"
                            id="lastname"
                            name="lastname"
                            type="text"
                            placeholder="Apellidos"
                            value="{{$user->lastname}}"
                        />
                        @error('lastname')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mt-3">
                    <x-base.form-label for="email">Correo Electrónico</x-base.form-label>

                    <x-base.form-input
                        class="w-full {{ $errors->has('email') ? 'border-red-500' : '' }}"
                        id="email"
                        name="email"
                        type="email"
                        placeholder="Email"
                        value="{{$user->email}}"
                    />
                    @error('email')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3">
                    <x-base.form-label for="role_id">Role</x-base.form-label>
                    <x-base.tom-select
                        class="w-full {{ $errors->has('role_id') ? 'border-red-500' : '' }}"
                        id="role_id"
                        name="role_id"
                    >
                    <option></option>
                    @foreach ($roles as $rol)
                        <option value="{{$rol->id}}" {{ $user->roles[0]->id == $rol->id ? 'selected' : '' }}>{{ $rol->name }}</option>
                    @endforeach
                    </x-base.tom-select>
                    @error('role_id')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>Status</label>
                    <x-base.form-switch class="mt-2">
                        <x-base.form-switch.input type="checkbox" name="status_toggle" id="status-toggle" value="1" />
                        <input type="hidden" name="status" id="status-hidden" value="0">
                    </x-base.form-switch>
                </div>

                </div>
                <div class="mt-5 text-right">
                    <x-base.button
                        class="mr-1 w-24"
                        type="button"
                        variant="outline-secondary"
                        onclick="window.location='{{ url()->previous() }}'"
                    >
                        Cancelar
                    </x-base.button>
                    <x-base.button
                        class="w-24"
                        type="submit"
                        variant="primary"
                    >
                        Actualizar
                    </x-base.button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('status-toggle').addEventListener('change', function() {
            document.getElementById('status-hidden').value = this.checked ? '1' : '0';
        });
        document.addEventListener('DOMContentLoaded', function() {
        // Obtén el valor del estado desde un atributo de datos o directamente desde una variable de JavaScript
        var statusValue = @json($user->status); // Se convierte el valor a una cadena de JavaScript

        var checkbox = document.getElementById('status-toggle');
        var hiddenInput = document.getElementById('status-hidden');

        // Establece el estado del checkbox
        checkbox.checked = statusValue == '1';

        // Actualiza el valor del input oculto
        checkbox.addEventListener('change', function() {
            hiddenInput.value = this.checked ? '1' : '0';
        });
    });
    </script>
@endsection
