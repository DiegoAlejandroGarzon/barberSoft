@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Eventos - Crear</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Crear Evento</h2>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="intro-y box p-5">
                <form method="POST" action="{{ route('event.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Nombre del Evento -->
                    <div class="mt-3">
                        <x-base.form-label for="name">Nombre del Evento</x-base.form-label>
                        <x-base.form-input
                            class="w-full {{ $errors->has('name') ? 'border-red-500' : '' }}"
                            id="name"
                            name="name"
                            type="text"
                            placeholder="Nombre del Evento"
                            value="{{ old('name') }}"
                        />
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Descripción del Evento -->
                    <div class="mt-3">
                        <x-base.form-label for="description">Descripción del Evento</x-base.form-label>
                        <textarea
                            class="w-full form-control {{ $errors->has('description') ? 'border-red-500' : '' }}"
                            id="description"
                            name="description"
                            placeholder="Descripción del Evento"
                            rows="5"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Imagen del Encabezado -->
                    <div class="mt-3">
                        <x-base.form-label for="header_image_path">Imagen del Encabezado</x-base.form-label>
                        <input
                            class="w-full form-control {{ $errors->has('header_image_path') ? 'border-red-500' : '' }}"
                            id="header_image_path"
                            name="header_image_path"
                            type="file"
                            accept="image/*"
                        />
                        @error('header_image_path')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <x-base.form-label>Campos Adicionales</x-base.form-label>
                        <div id="dynamic-fields-container"></div>
                        <x-base.button
                            class="mt-3"
                            type="button"
                            variant="outline-secondary"
                            onclick="addDynamicField()"
                        >
                            Añadir Campo
                        </x-base.button>

                        @error('additionalFields')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror

                        @foreach ($errors->get('additionalFields.*') as $fieldIndex => $errorMessages)
                            @foreach ($errorMessages as $errorMessage)
                                <div class="text-red-500 text-sm mt-1">
                                    {{ "Campo adicional " . ($loop->parent->index + 1) . ": " . $errorMessage }}
                                </div>
                            @endforeach
                        @endforeach
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
        let fieldIndex = 0;

        function addDynamicField() {
            const container = document.getElementById('dynamic-fields-container');
            const fieldId = `additional_field_${fieldIndex}`;
            const fieldHtml = `
                <div class="flex items-center mt-2" id="${fieldId}_wrapper">
                    <input
                        type="text"
                        name="additionalFields[${fieldIndex}][label]"
                        placeholder="Etiqueta"
                        class="form-control w-1/3 mr-2"
                    />
                    <input
                        type="text"
                        name="additionalFields[${fieldIndex}][value]"
                        placeholder="Valor"
                        class="form-control w-1/3 mr-2"
                    />
                    <x-base.button
                        type="button"
                        variant="outline-danger"
                        onclick="removeDynamicField('${fieldId}')"
                    >
                        Eliminar
                    </x-base.button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', fieldHtml);
            fieldIndex++;
        }

        function removeDynamicField(fieldId) {
            document.getElementById(`${fieldId}_wrapper`).remove();
        }
    </script>
@endsection
