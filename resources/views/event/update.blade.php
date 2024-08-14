@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Eventos - Editar</title>
@endsection

@section('subcontent')
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

                    <!-- Tipos de Entradas -->
                    <div class="mt-3">
                        <x-base.form-label>Tipos de Entradas</x-base.form-label>
                        <div id="ticket-types-container">
                            @foreach($event->ticketTypes as $index => $ticket)
                                <div class="flex items-center mt-2" id="ticket_type_{{ $index }}_wrapper">
                                    <input
                                        type="text"
                                        name="ticketTypes[{{ $index }}][name]"
                                        placeholder="Tipo de Entrada"
                                        class="form-control w-1/3 mr-2"
                                        value="{{ old('ticketTypes.' . $index . '.type', $ticket->name) }}"
                                    />
                                    <input
                                        type="number"
                                        name="ticketTypes[{{ $index }}][capacity]"
                                        placeholder="Capacidad"
                                        class="form-control w-1/3 mr-2"
                                        value="{{ old('ticketTypes.' . $index . '.capacity', $ticket->capacity) }}"
                                    />
                                    <input
                                        type="number"
                                        name="ticketTypes[{{ $index }}][price]"
                                        placeholder="Precio"
                                        class="form-control w-1/3 mr-2"
                                        value="{{ old('ticketTypes.' . $index . '.price', $ticket->price) }}"
                                    />
                                    <input
                                        type="text"
                                        name="ticketTypes[{{ $index }}][features]"
                                        placeholder="Características"
                                        class="form-control w-1/3 mr-2"
                                        value="{{ old('ticketTypes.' . $index . '.features', $ticket->features) }}"
                                    />
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
            const ticketId = `ticket_type_${ticketIndex}`;
            const ticketHtml = `
                <div class="flex items-center mt-2" id="${ticketId}_wrapper">
                    <input
                        type="text"
                        name="ticketTypes[${ticketIndex}][name]"
                        placeholder="Tipo de Entrada"
                        class="form-control w-1/3 mr-2"
                    />
                    <input
                        type="number"
                        name="ticketTypes[${ticketIndex}][capacity]"
                        placeholder="Capacidad"
                        class="form-control w-1/3 mr-2"
                    />
                    <input
                        type="number"
                        step="0.01"
                        name="ticketTypes[${ticketIndex}][price]"
                        placeholder="Precio"
                        class="form-control w-1/4 mr-2"
                    />
                    <input
                        type="text"
                        name="ticketTypes[${ticketIndex}][features]"
                        placeholder="Características"
                        class="form-control w-1/4 mr-2"
                    />
                    <x-base.button
                        type="button"
                        variant="outline-danger"
                        onclick="removeTicketType('${ticketId}')"
                    >
                        Eliminar
                    </x-base.button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', ticketHtml);
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
    </script>
@endsection
