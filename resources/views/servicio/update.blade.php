@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Servicio - Editar</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Editar Servicio</h2>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="intro-y box p-5">
            <form method="POST" action="{{ route('servicio.update', ['id' => $servicio->id]) }}" >
                @csrf
                @method('PUT')

                <!-- Nombre del Servicio -->
                <div class="intro-y col-span-12 lg:col-span-6">

                    <x-base.form-label for="nombre">Nombre del Servicio</x-base.form-label>
                    <x-base.form-input
                        class="w-full mb-3 {{ $errors->has('nombre') ? 'border-red-500' : '' }}"
                        id="nombre"
                        name="nombre"
                        type="text"
                        placeholder="Nombre del servicio"
                        value="{{ old('nombre', $servicio->nombre) }}"
                    />
                    @error('nombre')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror

                    <x-base.form-label for="precio">Precio del Servicio</x-base.form-label>
                    <x-base.form-input
                        class="w-full mb-3 {{ $errors->has('precio') ? 'border-red-500' : '' }}"
                        id="precio"
                        name="precio"
                        type="text"
                        placeholder="Precio"
                        value="{{ old('precio', $servicio->precio) }}"
                    />
                    @error('precio')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <x-base.form-label for="descripcion">Descripción del servicio</x-base.form-label>
                <x-base.form-input
                    class="w-full mb-2 {{ $errors->has('descripcion') ? 'border-red-500' : '' }}"
                    id="descripcion"
                    name="descripcion"
                    type="text"
                    placeholder="Descripción del servicio"
                    value="{{ old('descripcion', $servicio->descripcion) }}"
                />
                @error('descripcion')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror

                <!-- Barberia -->
                <div class="mt-3">
                    <x-base.form-label for="barberia_id">Barberia</x-base.form-label>
                    <x-base.tom-select
                        class="w-full {{ $errors->has('barberia_id') ? 'border-red-500' : '' }}"
                        id="barberia_id"
                        name="barberia_id"
                    >
                        <option></option>
                        @foreach ($barberias as $barberia)
                            <option value="{{ $barberia->id }}" {{ old('barberia_id', $servicio->barberia_id) == $barberia->id ? 'selected' : '' }}>
                                {{ $barberia->nombre }}
                            </option>
                        @endforeach
                    </x-base.tom-select>
                    @error('barberia_id')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
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
