@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Eventos - Editar</title>
@endsection

@section('subcontent')
    @if(session('error'))
        <div class="alert alert-danger mb-4">
            {{ session('error') }}
        </div>
    @endif
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Editar Evento</h2>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="intro-y box p-5">
                <form method="POST" action="{{ route('event.update', ['id' => $event->id]) }}" enctype="multipart/form-data">
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
                            value="{{ old('name', $event->name) }}"
                        />
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Aforo Total -->
                    <div class="mt-3">
                        <x-base.form-label for="capacity">Aforo Total</x-base.form-label>
                        <x-base.form-input
                            class="w-full {{ $errors->has('capacity') ? 'border-red-500' : '' }}"
                            id="capacity"
                            name="capacity"
                            type="number"
                            placeholder="Capacidad total del evento"
                            value="{{ old('capacity', $event->capacity) }}"
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
                                <option value="{{$department->id}}"
                                    {{ old('department_id', optional($event->city)->department ? $event->city->department->id : null) == $department->id ? 'selected' : '' }}>
                                    {{ $department->code_dane }} - {{ $department->name }}</option>

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
                        @if($event->city)
                            <option value="{{ $event->city->id }}">{{ $event->city->name }}</option>
                        @else
                            <option></option>
                        @endif
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
                            value="{{ old('event_date', $event->event_date) }}"
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
                            value="{{ old('start_time', $event->start_time) }}"
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
                            value="{{ old('end_time', $event->end_time) }}"
                        />
                        @error('end_time')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Tipos de Entradas -->
                    <div class="mt-3">
                        <x-base.form-label>Tipos de Entradas</x-base.form-label>
                        <div id="ticket-types-container">
                            @foreach($event->ticketTypes as $index => $ticket)
                                <div class="flex items-center mt-2" id="ticket_type_{{ $index }}_wrapper">
                                    <!-- Campo oculto para enviar el ID -->
                                    <input type="hidden" name="ticketTypes[{{ $index }}][id]" value="{{ $ticket->id }}">
                                    <x-base.form-input
                                        type="text"
                                        name="ticketTypes[{{ $index }}][name]"
                                        placeholder="Tipo de Entrada"
                                        class="form-control w-1/3 mr-2"
                                        value="{{ old('ticketTypes.' . $index . '.type', $ticket->name) }}"
                                    />
                                    <x-base.form-input
                                        type="number"
                                        name="ticketTypes[{{ $index }}][capacity]"
                                        placeholder="Capacidad"
                                        class="form-control w-1/3 mr-2"
                                        value="{{ old('ticketTypes.' . $index . '.capacity', $ticket->capacity) }}"
                                    />
                                    <x-base.form-input
                                        type="number"
                                        name="ticketTypes[{{ $index }}][price]"
                                        placeholder="Precio"
                                        class="form-control w-1/3 mr-2"
                                        value="{{ old('ticketTypes.' . $index . '.price', $ticket->price) }}"
                                    />
                                    <x-base.tom-select
                                    type="text"
                                    name="ticketTypes[{{ $index }}][features]"
                                    placeholder="Características"
                                    class="form-control w-1/3 mr-2"
                                    value="{{ old('ticketTypes.' . $index . '.features', $ticket->features) }}"
                                        multiple
                                    >

                                        @foreach($features as $key => $feature)
                                        <option value="{{ $feature['id'] }}" {{ in_array($feature['id'], old('features', $event->ticketTypes[$index]->features->pluck('id')->toArray())) ? 'selected' : '' }} >
                                            {{ $feature['name'] }}
                                        </option>
                                        @endforeach
                                    </x-base.tom-select>

                                    <x-base.button
                                        type="button"
                                        variant="outline-danger"
                                        onclick="removeTicketType('ticket_type_{{ $index }}')"
                                    >
                                        Eliminar
                                    </x-base.button>
                                </div>
                            @endforeach
                        </div>
                        <x-base.button
                            class="mt-3"
                            type="button"
                            variant="outline-secondary"
                            onclick="addTicketType()"
                        >
                            Añadir Tipo de Entrada
                        </x-base.button>

                        @error('ticketTypes')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror

                        @foreach ($errors->get('ticketTypes.*') as $fieldIndex => $errorMessages)
                            @foreach ($errorMessages as $errorMessage)
                                <div class="text-red-500 text-sm mt-1">
                                    {{ "Ticket " . ($loop->parent->index + 1) . ": " . $errorMessage }}
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
                        >{{ old('description', $event->description) }}</textarea>
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
                        @if($event->header_image_path)
                            <div class="mt-3">
                                <img src="{{ asset('storage/' . $event->header_image_path) }}" alt="Imagen del Evento" class="w-32 h-32">
                            </div>
                        @endif
                    </div>

                    <!-- Campos Adicionales -->
                    <div class="mt-3">
                        <x-base.form-label>Campos Adicionales</x-base.form-label>
                        <div id="dynamic-fields-container">
                            @if (!is_null($event->additionalFields) && is_array(json_decode($event->additionalFields, true)))
                            @foreach(json_decode($event->additionalFields, true) as $index => $field)
                                <div class="flex items-center mt-2" id="additional_field_{{ $index }}_wrapper">
                                    <input
                                        type="text"
                                        name="additionalFields[{{ $index }}][label]"
                                        placeholder="Etiqueta"
                                        class="form-control w-1/3 mr-2"
                                        value="{{ $field['label'] }}"
                                    />
                                    <input
                                        type="text"
                                        name="additionalFields[{{ $index }}][value]"
                                        placeholder="Valor"
                                        class="form-control w-1/3 mr-2"
                                        value="{{ $field['value'] }}"
                                    />
                                    <x-base.button
                                        type="button"
                                        variant="outline-danger"
                                        onclick="removeDynamicField('additional_field_{{ $index }}')"
                                    >
                                        Eliminar
                                    </x-base.button>
                                </div>
                            @endforeach
                            @endif
                        </div>
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
                            Actualizar
                        </x-base.button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let ticketIndex = {{ $event->ticketTypes->count() }};
        @if (!is_null($event->additionalFields) && is_array(json_decode($event->additionalFields, true)))
        let fieldIndex = {{ count(json_decode($event->additionalFields, true)) }};
        @endif

        function addTicketType() {
            const container = document.getElementById('ticket-types-container');
            const ticketTypeId = `ticket_type_${ticketIndex}`;
            const fieldHtml = `
                <div class="flex items-center mt-2" id="${ticketTypeId}_wrapper">
                    <x-base.form-input
                        class="w-full"
                        id="${ticketTypeId}_name"
                        name="ticketTypes[${ticketIndex}][name]"
                        type="text"
                        placeholder="Nombre del Tipo de Entrada"
                    />
                    <x-base.form-input
                        id="${ticketTypeId}_capacity"
                        type="number"
                        name="ticketTypes[${ticketIndex}][capacity]"
                        placeholder="Capacidad"
                        class="form-control w-full"
                    />
                    <x-base.form-input
                        id="${ticketTypeId}_price"
                        type="number"
                        step="0.01"
                        name="ticketTypes[${ticketIndex}][price]"
                        placeholder="Precio"
                        class="form-control w-full"
                    />
                    <select
                        id="${ticketTypeId}_features"
                        name="ticketTypes[${ticketIndex}][features][]"
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

            ticketIndex++;
        }

        function removeTicketType(ticketId) {
            document.getElementById(`${ticketId}_wrapper`).remove();
        }

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
