@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Usuarios - crear</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Crear Usuario</h2>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="intro-y box p-5">
                <div class="intro-y col-span-12 lg:col-span-6">
                    <x-base.form-label for="crud-form-1">Nombre Completo</x-base.form-label>

                    <div class="grid-cols-2 gap-2 sm:grid">
                        <x-base.form-input
                            class="w-full"
                            id="crud-form-1"
                            type="text"
                            placeholder="Nombres"
                        />
                        <x-base.form-input
                            class="w-full"
                            id="crud-form-1"
                            type="text"
                            placeholder="Apellidos"
                        />
                    </div>
                </div>
                <div class="mt-3">
                    <x-base.form-label for="crud-form-3">Correo Electronico</x-base.form-label>

                    <x-base.form-input
                        class="w-full"
                        id="crud-form-1"
                        type="email"
                        placeholder="Email"
                    />
                </div>

                <div class="intro-y col-span-12 lg:col-span-6 mt-3">
                    <x-base.form-label for="crud-form-1">Contraseña</x-base.form-label>

                    <div class="grid-cols-2 gap-2 sm:grid">
                        <x-base.form-input
                            class="w-full"
                            id="crud-form-1"
                            type="password"
                            placeholder="Contraseña"
                        />
                        <x-base.form-input
                            class="w-full"
                            id="crud-form-1"
                            type="password"
                            placeholder="Confirmar Contraseña"
                        />
                    </div>
                </div>
                <div class="mt-3">
                    <x-base.form-label for="crud-form-2">Role</x-base.form-label>
                    <x-base.tom-select
                        class="w-full"
                        id="crud-form-2"
                    >
                    <option ></option>
                    @foreach ($roles as $rol)
                        <option value="{{$rol->id}}">{{$rol->name}}</option>
                    @endforeach
                    </x-base.tom-select>
                </div>
                <div class="mt-3">
                    <label>Active Status</label>
                    <x-base.form-switch class="mt-2">
                        <x-base.form-switch.input type="checkbox" />
                    </x-base.form-switch>
                </div>
                <div class="mt-5 text-right">
                    <x-base.button
                        class="mr-1 w-24"
                        type="button"
                        variant="outline-secondary"
                    >
                        Cancelar
                    </x-base.button>
                    <x-base.button
                        class="w-24"
                        type="button"
                        variant="primary"
                    >
                        Guardar
                    </x-base.button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
    </div>
@endsection
