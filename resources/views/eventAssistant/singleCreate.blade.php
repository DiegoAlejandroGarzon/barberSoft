@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Asistentes del Evento</title>
@endsection

@section('subcontent')
<div class="container">
    <h2 class="mb-4">Crear Asistente para el Evento: <b>{{ $event->name }}</b></h2>

    <div class="intro-x mt-8">
        <form method="POST" action="{{ route('eventAssistant.singleCreate.upload', $event->id) }}">
            @csrf
            @php
                // Obtener los parámetros guardados en registration_parameters
                $selectedFields = json_decode($event->registration_parameters, true) ?? [];
            @endphp

            <!-- Renderizar campos dinámicamente -->

            <div class="mt-3">
                <x-base.form-label for="id_ticket">Ticket</x-base.form-label>
                <x-base.tom-select
                    class="w-full {{ $errors->has('id_ticket') ? 'border-red-500' : '' }}"
                    id="id_ticket"
                    name="id_ticket"
                    onchange="filterCities()"
                >
                    <option></option>
                    @foreach ($ticketTypes as $ticket)
                        <option value="{{$ticket->id}}" {{ old('id_ticket') == $ticket->id ? 'selected' : '' }}>{{ $ticket->name }}</option>
                    @endforeach
                </x-base.tom-select>
                @error('id_ticket')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            @if(in_array('name', $selectedFields))
                <x-base.form-label for="name">Nombre</x-base.form-label>
                <x-base.form-input id="name" class="intro-x block min-w-full px-4 py-3 xl:min-w-[350px]" type="text" name="name" placeholder="Nombre" value="{{ old('name') }}" required />
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            @endif

            @if(in_array('lastname', $selectedFields))
                <x-base.form-label for="lastname">Nombre</x-base.form-label>
                <x-base.form-input id="lastname" class="intro-x block min-w-full px-4 py-3 xl:min-w-[350px]" type="text" name="lastname" placeholder="Apellidos" value="{{ old('lastname') }}" required />
                @error('lastname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            @endif

            @if(in_array('email', $selectedFields))
                <x-base.form-label for="email">Email</x-base.form-label>
                <x-base.form-input id="email" class="intro-x mt-4 block min-w-full px-4 py-3 xl:min-w-[350px]" type="email" name="email" placeholder="Correo Electrónico" value="{{ old('email') }}" required />
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            @endif

            @if(in_array('type_document', $selectedFields))
                <!-- Type Document -->
                <div class="mt-3">
                    <x-base.form-label for="type_document">Tipo de Documento</x-base.form-label>
                    <x-base.tom-select
                        class="w-full {{ $errors->has('type_document') ? 'border-red-500' : '' }}"
                        id="type_document"
                        name="type_document"
                    >
                        <option value=""></option>
                        <option value="CC" {{ old('type_document') == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                        <option value="TI" {{ old('type_document') == 'TI' ? 'selected' : '' }}>Tarjeta de Identidad</option>
                        <option value="CE" {{ old('type_document') == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
                        <option value="PAS" {{ old('type_document') == 'PAS' ? 'selected' : '' }}>Pasaporte</option>
                    </x-base.tom-select>
                    @error('type_document')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            @if(in_array('document_number', $selectedFields))
                <!-- Document Number -->
                <div class="mt-3">
                    <x-base.form-label for="document_number">Número de Documento</x-base.form-label>
                    <x-base.form-input
                        class="w-full {{ $errors->has('document_number') ? 'border-red-500' : '' }}"
                        id="document_number"
                        name="document_number"
                        type="text"
                        placeholder="Número de Documento"
                        value="{{ old('document_number') }}"
                    />
                    @error('document_number')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            @if(in_array('phone', $selectedFields))
                <div class="mt-3">
                    <x-base.form-label for="phone">Teléfono</x-base.form-label>
                    <x-base.form-input
                        class="w-full {{ $errors->has('phone') ? 'border-red-500' : '' }}"
                        id="phone"
                        name="phone"
                        type="text"
                        placeholder="Teléfono"
                        value="{{ old('phone') }}"
                    />
                    @error('phone')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            @if(in_array('city_id', $selectedFields))
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
            @endif

            @if(in_array('birth_date', $selectedFields))
                <!-- Fecha Cumpleaños -->
                <div class="mt-3">
                    <x-base.form-label for="birth_date">Fecha Nacimiento</x-base.form-label>
                    <x-base.form-input
                        class="w-full {{ $errors->has('birth_date') ? 'border-red-500' : '' }}"
                        id="birth_date"
                        name="birth_date"
                        type="date"
                        value="{{ old('birth_date') }}"
                        onchange="checkAge()"
                    />
                    @error('birth_date')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Botón Asignar Acudiente -->
                <div class="mt-3" id="guardian-section" style="display:none;">
                    <button type="button" onclick="showGuardianSelect()" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Asignar Acudiente
                    </button>
                </div>

                <!-- Select Acudiente -->

                <div class="mt-3" id="guardian-select-section" style="display:none;">
                    <x-base.form-label for="guardian_id">Acudientes disponibles</x-base.form-label>
                    <x-base.tom-select
                        class="w-full {{ $errors->has('guardian_id') ? 'border-red-500' : '' }}"
                        id="guardian_id"
                        name="guardian_id"
                        onchange="filterCities()"
                    >
                        <option></option>
                        @foreach ($guardians as $guardian)
                            <option value="{{$guardian->user->id}}" {{ old('guardian_id') == $guardian->user->id ? 'selected' : '' }}>{{ $guardian->user->name }} - {{ $guardian->user->document_number }}</option>
                        @endforeach
                    </x-base.tom-select>
                    @error('guardian_id')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <!-- Renderizar campos adicionales dinámicamente -->
            @foreach ($additionalParameters as $parameter)
                @php
                    $type = $parameter['type'] ?? 'text'; // Tipo de input por defecto es 'text'
                    $name = $parameter['name'] ?? ''; // Nombre del input
                    $label = $parameter['label'] ?? ''; // Etiqueta del input
                    $options = $parameter['options'] ?? []; // Opciones en caso de ser select
                @endphp

                <div class="mt-3">
                    @if ($type == 'select')
                        <x-base.form-label for="{{ $name }}">{{ $label }}</x-base.form-label>
                        <x-base.tom-select
                            class="w-full {{ $errors->has($name) ? 'border-red-500' : '' }}"
                            id="{{ $name }}"
                            name="{{ $name }}"
                        >
                            <option value=""></option>
                            @foreach ($options as $key => $value)
                                <option value="{{ $key }}" {{ old($name) == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </x-base.tom-select>
                    @else
                        <x-base.form-label for="{{ $name }}">{{ $name }}</x-base.form-label>
                        <x-base.form-input
                            class="w-full {{ $errors->has($name) ? 'border-red-500' : '' }}"
                            id="{{ $name }}"
                            name="{{ $name }}"
                            type="{{ $type }}"
                            placeholder="{{ $label }}"
                            value="{{ old($name) }}"
                        />
                    @endif

                    @error($name)
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach

            <!-- Botón de Registro -->
            <div class="intro-x mt-5 text-center xl:mt-8 xl:text-left">
                <x-base.button class="w-full px-4 py-3 align-top xl:mr-3 xl:w-32" type="submit" variant="primary">
                    Registrarse
                </x-base.button>
            </div>
        </form>
    </div>
</div>

<script>
    // Función para calcular la edad y mostrar el botón si es menor de edad
    function checkAge() {
        const birthDate = document.getElementById('birth_date').value;
        if (birthDate) {
            const today = new Date();
            const birth = new Date(birthDate);
            let age = today.getFullYear() - birth.getFullYear(); // Cambiado a 'let'
            const monthDiff = today.getMonth() - birth.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
                age--;
            }

            if (age < 18) {
                document.getElementById('guardian-section').style.display = 'block';
            } else {
                document.getElementById('guardian-section').style.display = 'none';
                document.getElementById('guardian-select-section').style.display = 'none';
            }
        }
    }

    // Función para mostrar el select de acudiente con una alerta
    function showGuardianSelect() {
        alert("Recuerda que para asignar un acudiente, solo van a poder ser asignados los que ya están creados en el evento y tengan un tipo de documento.");
        document.getElementById('guardian-select-section').style.display = 'block';

        // Realizar petición para obtener los asistentes
        fetch('/event-assistants?event_id={{ $event->id }}') // Ruta al controlador para obtener los asistentes
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('guardian_id');
                select.innerHTML = ''; // Limpiar select
                data.forEach(assistant => {
                    if (assistant.document_number !== null) {
                        const option = document.createElement('option');
                        option.value = assistant.id;
                        option.text = assistant.name + ' ' + assistant.lastname;
                        select.appendChild(option);
                    }
                });
            });
    }
</script>
@endsection