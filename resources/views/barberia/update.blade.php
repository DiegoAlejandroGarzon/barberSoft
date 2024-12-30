@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Barbería - Editar</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Editar Barbería: {{ $barberia->nombre }}</h2>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="intro-y box p-5">
                <form method="POST" action="{{ route('barberia.update', ['id' => $barberia->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nombre de la Barbería -->
                    <div class="intro-y col-span-12 lg:col-span-6">
                        <x-base.form-label for="nombre">Nombre de la Barbería</x-base.form-label>
                        <x-base.form-input
                            class="w-full {{ $errors->has('nombre') ? 'border-red-500' : '' }}"
                            id="nombre"
                            name="nombre"
                            type="text"
                            placeholder="Nombre de la barbería"
                            value="{{ old('nombre', $barberia->nombre) }}"
                        />
                        @error('nombre')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ubicación de la Barbería -->
                    <div class="intro-y col-span-12 lg:col-span-6 mt-4">
                        <x-base.form-label for="ubicacion">Ubicación</x-base.form-label>
                        <x-base.form-input
                            class="w-full {{ $errors->has('ubicacion') ? 'border-red-500' : '' }}"
                            id="ubicacion"
                            name="ubicacion"
                            type="text"
                            placeholder="Ubicación"
                            value="{{ old('ubicacion', $barberia->ubicacion) }}"
                        />
                        @error('ubicacion')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contacto de la Barbería -->
                    <div class="intro-y col-span-12 lg:col-span-6 mt-4">
                        <x-base.form-label for="contacto">Contacto</x-base.form-label>
                        <x-base.form-input
                            class="w-full {{ $errors->has('contacto') ? 'border-red-500' : '' }}"
                            id="contacto"
                            name="contacto"
                            type="text"
                            placeholder="Número de contacto"
                            value="{{ old('contacto', $barberia->contacto) }}"
                        />
                        @error('contacto')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Estado de la Barbería -->
                    <div class="intro-y col-span-12 lg:col-span-6 mt-4">
                        <x-base.form-label for="status">Estado</x-base.form-label>
                        <select
                            id="status"
                            name="status"
                            class="w-full {{ $errors->has('status') ? 'border-red-500' : '' }}"
                        >
                            <option value="1" {{ old('status', $barberia->status) == 1 ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('status', $barberia->status) == 0 ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('status')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Logo de la Barbería -->
                    <div class="intro-y col-span-12 lg:col-span-6 mt-4">
                        <x-base.form-label for="logo">Logo de la Barbería</x-base.form-label>
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

                    @if($barberia->logo)
                        <div class="intro-y col-span-12 mt-4">
                            <label class="font-medium">Logo Actual</label>
                            <div>
                                <img src="{{ asset('storage/' . $barberia->logo) }}" alt="Logo Actual" class="w-32 h-32 object-cover mt-2">
                            </div>
                        </div>
                    @endif

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
                                    value="{{ old('color_one', $barberia->color_one ?? '#FFFFFF') }}"
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
                                    value="{{ old('color_one', $barberia->color_two ?? '#FFFFFF') }}"
                                />
                                @error('color_two')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Botón para actualizar -->
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
@endsection
