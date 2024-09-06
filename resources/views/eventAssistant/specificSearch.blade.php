@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Asistentes del Evento</title>
@endsection

@section('subcontent')
<div class="container">
    <h2 class="mb-4">Busqueda del Asistente para el Evento: <b>{{ $event->name }}</b></h2>

    <div class="intro-x mt-8">
        <form method="GET" action="{{ route('eventAssistant.specificSearch.upload', $event->id) }}">
            @csrf
            @php
                // Obtener los parámetros guardados en registration_parameters
                $selectedFields = json_decode($event->registration_parameters, true) ?? [];
            @endphp

            @if(in_array('name', $selectedFields))
                <x-base.form-label for="name">Nombre</x-base.form-label>
                <x-base.form-input id="name" class="intro-x block min-w-full px-4 py-3 xl:min-w-[350px]" type="text" name="name" placeholder="Nombre" value="{{ old('name') }}"  />
            @endif

            @if(in_array('lastname', $selectedFields))
                <x-base.form-label for="lastname">Nombre</x-base.form-label>
                <x-base.form-input id="lastname" class="intro-x block min-w-full px-4 py-3 xl:min-w-[350px]" type="text" name="lastname" placeholder="Apellidos" value="{{ old('lastname') }}"  />
            @endif

            @if(in_array('email', $selectedFields))
                <x-base.form-label for="email">Email</x-base.form-label>
                <x-base.form-input id="email" class="intro-x mt-4 block min-w-full px-4 py-3 xl:min-w-[350px]" type="email" name="email" placeholder="Correo Electrónico" value="{{ old('email') }}"  />
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
                    />
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
                </div>
            @endforeach

            <div class="intro-x mt-5 text-center xl:mt-8 xl:text-left">
                <x-base.button class="w-full px-4 py-3 align-top xl:mr-3 xl:w-32" type="submit" variant="primary">
                    Buscar
                </x-base.button>
            </div>
        </form>
        @if(isset($users) && $users->isNotEmpty())
            <div class="mt-8">
                <h3>Resultados de la búsqueda:</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        @foreach($selectedFields as $field)
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ ucfirst(str_replace('_', ' ', $field)) }}</th>
                        @endforeach
                        @foreach ($additionalParameters as $parameter)
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ ucfirst(str_replace('_', ' ', $parameter['name'])) }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                {{-- Mostrar valores de los campos seleccionados --}}
                                @foreach($selectedFields as $field)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->$field }}</td>
                                @endforeach

                                {{-- Mostrar valores de los parámetros adicionales --}}
                                @foreach ($additionalParameters as $parameter)
                                    @php
                                        // Obtener el valor del parámetro adicional para el usuario actual
                                        $userParameter = $user->eventParameters->where('event_id', $event->id)->where('additional_parameter_id', $parameter['id'])->first();
                                    @endphp
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $userParameter ? $userParameter->value : '-' }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No se encontraron resultados para la búsqueda.</p>
        @endif
    </div>
</div>
@endsection
