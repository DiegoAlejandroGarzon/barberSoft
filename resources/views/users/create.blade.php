@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Usuarios - Crear</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Crear Usuario</h2>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="intro-y box p-5">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="intro-y col-span-12 lg:col-span-6">
                    <x-base.form-label for="name">Nombre Completo</x-base.form-label>

                    <div class="grid-cols-2 gap-2 sm:grid">
                        <x-base.form-input
                            class="w-full @error('name') border-red-500 @enderror"
                            id="name"
                            name="name"
                            type="text"
                            placeholder="Nombres"
                            value="{{ old('name') }}"
                        />
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror

                        <x-base.form-input
                            class="w-full @error('last_name') border-red-500 @enderror"
                            id="last_name"
                            name="last_name"
                            type="text"
                            placeholder="Apellidos"
                            value="{{ old('last_name') }}"
                        />
                        @error('last_name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mt-3">
                    <x-base.form-label for="email">Correo Electrónico</x-base.form-label>

                    <x-base.form-input
                        class="w-full @error('email') border-red-500 @enderror"
                        id="email"
                        name="email"
                        type="email"
                        placeholder="Email"
                        value="{{ old('email') }}"
                    />
                    @error('email')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="intro-y col-span-12 lg:col-span-6 mt-3">
                    <x-base.form-label for="password">Contraseña</x-base.form-label>

                    <div class="grid-cols-2 gap-2 sm:grid">
                        <x-base.form-input
                            class="w-full @error('password') border-red-500 @enderror"
                            id="password"
                            name="password"
                            type="password"
                            placeholder="Contraseña"
                        />
                        @error('password')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror

                        <x-base.form-input
                            class="w-full @error('password_confirmation') border-red-500 @enderror"
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            placeholder="Confirmar Contraseña"
                        />
                        @error('password_confirmation')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mt-3">
                    <x-base.form-label for="role_id">Role</x-base.form-label>
                    <x-base.tom-select
                        class="w-full"
                        id="role_id"
                        name="role_id"
                    >
                    <option></option>
                    @foreach ($roles as $rol)
                        <option value="{{$rol->id}}" {{ old('role_id') == $rol->id ? 'selected' : '' }}>{{ $rol->name }}</option>
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
                        Guardar
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
    </script>
@endsection
