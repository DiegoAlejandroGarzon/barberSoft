@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>empresa - Crear</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Crear empresa</h2>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="intro-y box p-5">
                <form method="POST" action="{{ route('empresa.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Nombre de la empresa -->
                    <div class="intro-y col-span-12 lg:col-span-6">
                        <x-base.form-label for="nombre">Nombre de la empresa</x-base.form-label>
                        <x-base.form-input
                            class="w-full {{ $errors->has('nombre') ? 'border-red-500' : '' }}"
                            id="nombre"
                            name="nombre"
                            type="text"
                            placeholder="Nombre de la empresa"
                            value="{{ old('nombre') }}"
                        />
                        @error('nombre')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Etiqueta de sus empleados -->
                    <div class="intro-y col-span-12 lg:col-span-6 mt-4">
                        <x-base.form-label for="nombre">Etiqueta de sus empleados</x-base.form-label>
                        <x-base.form-input
                            class="w-full {{ $errors->has('etiqueta_empleado') ? 'border-red-500' : '' }}"
                            id="etiqueta_empleado"
                            name="etiqueta_empleado"
                            type="text"
                            placeholder="Etiqueta de sus empleados"
                            value="{{ old('etiqueta_empleado') }}"
                        />
                        @error('etiqueta_empleado')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ubicación de la empresa -->
                    <div class="intro-y col-span-12 lg:col-span-6 mt-4">
                        <x-base.form-label for="ubicacion">Ubicación</x-base.form-label>
                        <x-base.form-input
                            class="w-full {{ $errors->has('ubicacion') ? 'border-red-500' : '' }}"
                            id="ubicacion"
                            name="ubicacion"
                            type="text"
                            placeholder="Ubicación"
                            value="{{ old('ubicacion') }}"
                        />
                        @error('ubicacion')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contacto de la empresa -->
                    <div class="intro-y col-span-12 lg:col-span-6 mt-4">
                        <x-base.form-label for="contacto">Contacto</x-base.form-label>
                        <x-base.form-input
                            class="w-full {{ $errors->has('contacto') ? 'border-red-500' : '' }}"
                            id="contacto"
                            name="contacto"
                            type="text"
                            placeholder="Número de contacto"
                            value="{{ old('contacto') }}"
                        />
                        @error('contacto')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Estado de la empresa -->
                    <div class="intro-y col-span-12 lg:col-span-6 mt-4">
                        <x-base.form-label for="status">Estado</x-base.form-label>
                        <select
                            id="status"
                            name="status"
                            class="w-full {{ $errors->has('status') ? 'border-red-500' : '' }}"
                        >
                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('status')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Logo de la empresa -->
                    <div class="intro-y col-span-12 lg:col-span-6 mt-4">
                        <x-base.form-label for="logo">Logo de la empresa</x-base.form-label>
                        <x-base.form-input
                            class="w-full {{ $errors->has('logo') ? 'border-red-500' : '' }}"
                            id="logo"
                            name="logo"
                            type="file"
                        />
                        @error('logo')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-3 box">
                        <x-base.form-label class="m-2">Colores Representativos</x-base.form-label>
                        <div class="grid-cols-2 gap-2 sm:grid">
                            <!-- color_one -->
                            <div class="m-2">
                                <x-base.form-label for="color_one">Color Primario</x-base.form-label>
                                <x-base.form-input
                                    class="w-full {{ $errors->has('color_one') ? 'border-red-500' : '' }}"
                                    id="color_one"
                                    name="color_one"
                                    type="color"
                                    placeholder="Color principal"
                                    value="{{ old('color_one', $empresa->color_one ?? '#FFFFFF') }}"
                                />
                                @error('color_one')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- two -->
                            <div class="m-2">
                                <x-base.form-label for="color_two">Color Secundario</x-base.form-label>
                                <x-base.form-input
                                    class="w-full {{ $errors->has('color_two') ? 'border-red-500' : '' }}"
                                    id="color_two"
                                    name="color_two"
                                    type="color"
                                    placeholder="Color Secundario"
                                    value="{{ old('color_one', $empresa->color_two ?? '#FFFFFF') }}"
                                />
                                @error('color_two')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Botón para crear -->
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
@endsection
