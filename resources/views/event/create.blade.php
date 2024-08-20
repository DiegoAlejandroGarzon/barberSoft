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

                    <!-- Capacidad total -->
                    <div class="mt-3">
                        <x-base.form-label for="capacity">Capacidad Total</x-base.form-label>
                        <x-base.form-input
                            class="w-full {{ $errors->has('capacity') ? 'border-red-500' : '' }}"
                            id="capacity"
                            name="capacity"
                            type="number"
                            placeholder="Capacidad total del evento"
                            value="{{ old('capacity') }}"
                        />
                        @error('capacity')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Departamento -->
                    <div class="mt-3">
                        <x-base.form-label for="department_id">Departamento</x-base.form-label>
                        <x-base.tom-select
                            class="w-full {{ $errors->has('department_id') ? 'border-red-500' : '' }}"
                            id="department_id"
                            name="department_id"
                            onchange="filterCities()"
                        >
                            <option></option>
                            @foreach ($departments as $department)
                                <option value="{{$department->id}}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->code_dane }} - {{ $department->name }}</option>
                            @endforeach
                        </x-base.tom-select>
                        @error('department_id')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ciudad -->
                    <div class="mt-3">
                        <x-base.form-label for="city_id">Ciudad</x-base.form-label>
                        <x-base.tom-select
                            class="w-full {{ $errors->has('city_id') ? 'border-red-500' : '' }}"
                            id="city_id"
                            name="city_id"
                        >
                            <option></option>
                        </x-base.tom-select>
                        @error('city_id')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Fecha del Evento -->
                    <div class="mt-3">
                        <x-base.form-label for="event_date">Fecha del Evento</x-base.form-label>
                        <x-base.form-input
                            class="w-full {{ $errors->has('event_date') ? 'border-red-500' : '' }}"
                            id="event_date"
                            name="event_date"
                            type="date"
                            value="{{ old('event_date') }}"
                        />
                        @error('event_date')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Hora de Inicio -->
                    <div class="mt-3">
                        <x-base.form-label for="start_time">Hora de Inicio</x-base.form-label>
                        <x-base.form-input
                            class="w-full {{ $errors->has('start_time') ? 'border-red-500' : '' }}"
                            id="start_time"
                            name="start_time"
                            type="time"
                            value="{{ old('start_time') }}"
                        />
                        @error('start_time')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Hora de Fin -->
                    <div class="mt-3">
                        <x-base.form-label for="end_time">Hora de Fin</x-base.form-label>
                        <x-base.form-input
                            class="w-full {{ $errors->has('end_time') ? 'border-red-500' : '' }}"
                            id="end_time"
                            name="end_time"
                            type="time"
                            value="{{ old('end_time') }}"
                        />
                        @error('end_time')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tipos de entradas -->
                    <div class="mt-3">
                        <x-base.form-label>Tipos de Entradas</x-base.form-label>
                        <div id="ticket-types-container"></div>
                        <x-base.button
                            class="mt-3"
                            type="button"
                            variant="outline-secondary"
                            onclick="addTicketType()"
                        >
                            Añadir Tipo de Entrada
                        </x-base.button>

                        @foreach ($errors->get('ticketTypes.*') as $index => $errorMessages)
                            @foreach ($errorMessages as $errorMessage)
                                <div class="text-red-500 text-sm mt-1">
                                    {{ "Tipo de entrada " . (intval($index) + 1) . ": " . $errorMessage }}

                                </div>
                            @endforeach
                        @endforeach
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

                    <!-- Campos Adicionales -->
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

        let ticketTypeIndex = 0;
        function addTicketType() {
            const container = document.getElementById('ticket-types-container');
            const ticketTypeId = `ticket_type_${ticketTypeIndex}`;
            const fieldHtml = `
                <div class="flex items-center mt-2" id="${ticketTypeId}_wrapper">
                    <x-base.form-input
                        class="w-full"
                        id="${ticketTypeId}_name"
                        name="ticketTypes[${ticketTypeIndex}][name]"
                        type="text"
                        placeholder="Nombre del Tipo de Entrada"
                    />
                    <x-base.form-input
                        id="${ticketTypeId}_capacity"
                        type="number"
                        name="ticketTypes[${ticketTypeIndex}][capacity]"
                        placeholder="Capacidad"
                        class="form-control w-full"
                    />
                    <x-base.form-input
                        id="${ticketTypeId}_price"
                        type="number"
                        step="0.01"
                        name="ticketTypes[${ticketTypeIndex}][price]"
                        placeholder="Precio"
                        class="form-control w-full"
                    />
                    <select
                        id="${ticketTypeId}_features"
                        name="ticketTypes[${ticketTypeIndex}][features][]"
                        multiple="multiple"
                        class="tom-select w-full mt-2"
                    >
                        @foreach($features as $feature)
                            <option value="{{ $feature->id }}">{{ $feature->name }}</option>
                        @endforeach
                    </select>
                    <x-base.button
                        type="button"
                        variant="outline-danger"
                        onclick="removeTicketType('${ticketTypeId}')"
                        class="mt-3"
                    >
                        Eliminar
                    </x-base.button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', fieldHtml);

            // Inicializar Tom Select en el nuevo elemento select
            new TomSelect(`#${ticketTypeId}_features`, {
                plugins: ['remove_button'],
                maxItems: null,
            });

            ticketTypeIndex++;
        }


        function removeTicketType(ticketTypeId) {
            document.getElementById(`${ticketTypeId}_wrapper`).remove();
        }

        function updateCityOptions(cities) {
            var citySelect = document.querySelector('#city_id').tomselect;

            // Verifica si 'cities' es un array
            if (!Array.isArray(cities)) {
                console.error('Expected an array of cities but got:', cities);
                return;
            }

            // Limpia todas las opciones actuales
            citySelect.clearOptions();

            // Agrega nuevas opciones dinámicamente
            cities.forEach(city => {
                citySelect.addOption({value: city.id, text: city.name});
            });

            // Refresca la lista de opciones para que se muestren correctamente en la interfaz
            citySelect.refreshOptions(false);
        }

        function filterCities() {
            var departmentId = document.getElementById('department_id').value;
            var citySelect = document.getElementById('city_id');

            // Limpia el select de ciudades
            citySelect.innerHTML = '<option></option>';

            if (departmentId) {
                fetch('/cities/' + departmentId)
                    .then(response => response.json())
                    .then(data => {
                        // Verifica si 'data.cities' existe y es un array
                        if (Array.isArray(data.cities)) {
                            updateCityOptions(data.cities);
                        } else {
                            console.error('Invalid data format:', data);
                        }
                    })
                    .catch(error => console.error('Error fetching cities:', error));
            }
        }
    </script>
@endsection
