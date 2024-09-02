@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Establecer Parámetros de Inscripción</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Establecer Parámetros de Inscripción para el Evento</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <x-base.alert class="mb-2 flex items-center" variant="danger">
            <x-base.lucide class="mr-2 h-6 w-6" icon="AlertCircle" />
            {{ session('error') }}
        </x-base.alert>
    @endif

    <div class="mt-5">
        <div class="box p-5">
            <h3 class="text-lg font-medium">Evento: {{ $event->name }}</h3>
            <p><strong>Descripción:</strong> {{ $event->description }}</p>

            <form action="{{ route('events.storeRegistrationParameters', $event->id) }}" method="POST">
                @csrf

                <h4 class="text-lg font-medium mt-5">Seleccionar Parámetros de Inscripción</h4>

                <!-- Listado de campos de la tabla users -->
                <div class="mt-3">
                    @php
                        $userColumns = [
                            'name' => 'Nombre',
                            'lastname' => 'Apellido',
                            'email' => 'Correo Electrónico',
                            'type_document' => 'Tipo de Documento',
                            'document_number' => 'Número de Documento',
                            'phone' => 'Teléfono',
                            'city_id' => 'Ciudad',
                            'birth_date' => 'Fecha de Nacimiento'
                        ];

                        // Decodificar los parámetros guardados en registration_parameters
                        $selectedFields = json_decode($event->registration_parameters, true) ?? [];
                    @endphp

                    <!-- Renderizado de checkboxes para seleccionar los campos -->
                    @foreach($userColumns as $column => $label)
                        <div class="flex items-center mt-3">
                            <input type="checkbox" id="{{ $column }}" name="fields[]" value="{{ $column }}" class="mr-2"
                                   @if(in_array($column, $selectedFields)) checked @endif>
                            <label for="{{ $column }}" class="cursor-pointer">{{ $label }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- Contenedor para los parámetros adicionales -->
                <h4 class="text-lg font-medium mt-5">Agregar Parámetros Adicionales</h4>
                <div id="additional-parameters-container" class="mt-3">
                    <!-- Precargar campos existentes si hay parámetros adicionales -->
                    @foreach($additional_parameters as $index => $parameter)
                        <div class="flex items-center mt-3" id="additional-param-{{ $index }}">
                            <!-- Input para el nombre del campo -->
                            <input type="text" name="additional_parameters[{{ $index }}][name]" value="{{ $parameter->name }}" placeholder="Nombre del campo" class="mr-2 form-input">

                            <!-- Select para el tipo de campo -->
                            <select name="additional_parameters[{{ $index }}][type]" class="mr-2 form-select">
                                <option value="text" @if($parameter->type == 'text') selected @endif>Texto</option>
                                <option value="number" @if($parameter->type == 'number') selected @endif>Numérico</option>
                                <option value="date" @if($parameter->type == 'date') selected @endif>Fecha</option>
                            </select>

                            <!-- Botón para eliminar el parámetro -->
                            <button type="button" class="text-red-500" onclick="removeAdditionalParameter('{{ $index }}', '{{ $parameter->id }}')">
                                Eliminar
                            </button>
                        </div>
                    @endforeach
                </div>

                <!-- Botón para agregar nuevos parámetros -->
                <x-base.button type="button" class="w-full mt-3" variant="secondary" onclick="addAdditionalParameter()">
                    Agregar Parámetro Adicional
                </x-base.button>

                <!-- Botón para guardar los parámetros -->
                <x-base.button class="w-full mt-5" type="submit" variant="primary">
                    Guardar Parámetros
                </x-base.button>
            </form>
        </div>
    </div>
    <script>
        function removeAdditionalParameter(index, parameterId) {
            // Remover el div del DOM
            document.getElementById('additional-param-' + index).remove();

            // Agregar el ID del parámetro a eliminar a un campo oculto
            let idsToDelete = document.getElementById('parameters-to-delete').value;
            idsToDelete = idsToDelete ? idsToDelete + ',' + parameterId : parameterId;
            document.getElementById('parameters-to-delete').value = idsToDelete;
        }

        function addAdditionalParameter() {
            const container = document.getElementById('additional-parameters-container');

            // Crear un nuevo div para los inputs
            const newParameterDiv = document.createElement('div');
            newParameterDiv.classList.add('flex', 'items-center', 'mt-3');

            // Generar un índice único para cada grupo de parámetros adicionales
            const parameterIndex = document.querySelectorAll('#additional-parameters-container > div').length;

            // Input para el nombre del campo
            const inputName = document.createElement('input');
            inputName.type = 'text';
            inputName.name = `additional_parameters[${parameterIndex}][name]`; // Asegurar que se agrupe correctamente
            inputName.placeholder = 'Nombre del campo';
            inputName.classList.add('mr-2', 'form-input');

            // Select para el tipo de campo
            const selectType = document.createElement('select');
            selectType.name = `additional_parameters[${parameterIndex}][type]`; // Asegurar que se agrupe correctamente
            selectType.classList.add('mr-2', 'form-select');
            selectType.innerHTML = `
                <option value="text">Texto</option>
                <option value="number">Numérico</option>
                <option value="date">Fecha</option>
            `;

            // Botón para eliminar el campo adicional
            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('ml-2', 'text-red-500');
            deleteButton.textContent = 'Eliminar';
            deleteButton.onclick = function() {
                container.removeChild(newParameterDiv); // Eliminar el div correspondiente
            };

            // Agregar los elementos al nuevo div
            newParameterDiv.appendChild(inputName);
            newParameterDiv.appendChild(selectType);
            newParameterDiv.appendChild(deleteButton);

            // Añadir el div al contenedor
            container.appendChild(newParameterDiv);
        }
    </script>
@endsection
