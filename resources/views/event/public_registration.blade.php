@extends('../themes/base')

@section('head')
    <title>PROYECTO EVENTOS</title>
@endsection

@section('content')

@if($event->color_one !== null)
<style>
    body {
        overflow-x: hidden; /* Evita el desbordamiento horizontal */
    }
    .bg-color-one {
        --tw-bg-opacity: 1;
        background-color: {{$event->color_one}};
    }
    .bg-color-two {
        --tw-bg-opacity: 1;
        background-color: {{$event->color_two}};
    }
    .before\:bg-color-two\/20::before{
        --tw-bg-opacity: 1;
        background-color: {{$event->color_two}};
    }
    .after\:bg-color-one::after {
        --tw-bg-opacity: 1;
        background-color: {{$event->color_one}};
    }
    @media (max-width: 1280px) {
        .lg\:overflow-hidden {
            overflow: hidden;
            background-color: {{$event->color_one}}; /* Aplica bg-color-one a pantallas mayores de 640px */
        }
    }
</style>
<div @class([
    'p-3 sm:px-8 relative h-screen lg:overflow-hidden bg-primary xl:bg-white dark:bg-darkmode-800 xl:dark:bg-darkmode-600',
    'before:hidden before:xl:block before:content-[\'\'] before:w-[57%] before:-mt-[28%] before:-mb-[16%] before:-ml-[13%] before:absolute before:inset-y-0 before:left-0 before:transform before:rotate-[-4.5deg] before:bg-color-two/20 before:rounded-[100%] before:dark:bg-darkmode-400',
    'after:hidden after:xl:block after:content-[\'\'] after:w-[57%] after:-mt-[20%] after:-mb-[13%] after:-ml-[13%] after:absolute after:inset-y-0 after:left-0 after:transform before:rotate-[-4.5deg] after:bg-color-one after:rounded-[100%] after:dark:bg-darkmode-700',
])>
@else
<div @class([
    'p-3 sm:px-8 relative h-screen lg:overflow-hidden bg-primary xl:bg-white dark:bg-darkmode-800 xl:dark:bg-darkmode-600',
    'before:hidden before:xl:block before:content-[\'\'] before:w-[57%] before:-mt-[28%] before:-mb-[16%] before:-ml-[13%] before:absolute before:inset-y-0 before:left-0 before:transform before:rotate-[-4.5deg] before:bg-primary/20 before:rounded-[100%] before:dark:bg-darkmode-400',
    'after:hidden after:xl:block after:content-[\'\'] after:w-[57%] after:-mt-[20%] after:-mb-[13%] after:-ml-[13%] after:absolute after:inset-y-0 after:left-0 after:transform before:rotate-[-4.5deg] after:bg-primary after:rounded-[100%] after:dark:bg-darkmode-700',
])>
@endif
        <div class="container relative z-10 sm:px-10">
            <div class="block grid-cols-2 gap-4 xl:grid">
                <!-- BEGIN: Event Info -->
                <div class="hidden min-h-screen flex-col xl:flex">
                    <span class="ml-3 text-lg text-white"> tuBoleta </span>
                    <div class="my-auto">
                        @if ($event->header_image_path)
                        <img class="-intro-x -mt-16 w-1/2" src="{{ asset('storage/' . $event->header_image_path) }}" alt="Imagen del evento" />
                        @else
                        <img class="-intro-x -mt-16 w-1/2" src="{{ Vite::asset('resources/images/illustration.svg') }}" alt="" />
                        @endif
                        <div class="-intro-x mt-10 text-4xl font-medium leading-tight text-white">
                            PROYECTO EVENTOS
                        </div>
                        <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">
                            Registrar eventos y llevar su gestión
                        </div>
                    </div>
                </div>
                <!-- END: Event Info -->

                <!-- BEGIN: Registration Form -->
                <div class="my-10 flex h-screen py-5 xl:my-0 xl:h-auto xl:py-0">
                    <div class="mx-auto my-auto w-full rounded-md bg-white px-5 py-8 shadow-md dark:bg-darkmode-600 sm:w-3/4 sm:px-8 lg:w-2/4 xl:ml-20 xl:w-auto xl:bg-transparent xl:p-0 xl:shadow-none">
                        <h2 class="intro-x text-center text-2xl font-bold xl:text-left xl:text-3xl">
                            Inscripción para el evento: {{ $event->name }}
                        </h2>
                        <div class="block xl:hidden">
                            @if ($event->header_image_path)
                            <img class="" src="{{ asset('storage/' . $event->header_image_path) }}" alt="Imagen del evento" />
                            @else
                            <img class="-intro-x -mt-16 w-1/2" src="{{ Vite::asset('resources/images/illustration.svg') }}" alt="" />
                            @endif
                        </div>
                        <p class="intro-x mt-2 text-center text-slate-400 xl:hidden">
                            {{ $event->description }}
                        </p>
                        @if (session('success'))
                            <div class="intro-x mt-4 alert alert-success text-green-500">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="intro-x mt-4 alert alert-danger text-red-500">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if (session('qrCode'))
                            <p><strong>Recuerda Guardar el codigo QR para poder acceder al evento:</strong></p>
                            <p><strong>Código QR:</strong></p>
                            <div class="mt-2">
                                {{ session('qrCode') }}
                            </div>
                        @endif
                        <div class="intro-x mt-8">
                            <form action="{{ route('event.register.submit', $event->public_link) }}" method="POST">
                                @csrf
                                @php
                                    // Obtener los parámetros guardados en registration_parameters
                                    $selectedFields = json_decode($event->registration_parameters, true) ?? [];
                                @endphp

                                <!-- Checkbox para mostrar el input de código de cortesía -->
                                <div class="mt-3">
                                    <x-base.form-label for="courtesy_code_checkbox">¿Tienes un Cupon de cortesía?</x-base.form-label>
                                    <input
                                        type="checkbox"
                                        id="courtesy_code_checkbox"
                                        onclick="toggleCourtesyCodeInput()"
                                    />
                                </div>

                                <!-- Input para ingresar el código de cortesía (oculto por defecto) -->
                                <div class="mt-3" id="courtesy_code_container" style="display: none;">
                                    <x-base.form-label for="courtesy_code">Cupon de cortesía</x-base.form-label>
                                    <x-base.form-input
                                        id="courtesy_code"
                                        class="w-full"
                                        type="text"
                                        maxlength="6"
                                        name="courtesy_code"
                                        placeholder="Ingresa el código de cortesía"
                                        oninput="checkCourtesyCode()"
                                    />
                                    <div id="courtesy_code_message" class="text-red-500 text-sm mt-1"></div>
                                </div>

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
                                            <option value="{{$ticket->id}}" {{ old('id_ticket') == $ticket->id ? 'selected' : '' }}>{{ $ticket->name }} - ${{ number_format($ticket->price, 0, '', '.') }}</option>
                                        @endforeach
                                    </x-base.tom-select>
                                    @error('id_ticket')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Renderizar campos dinámicamente -->
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
                                    <x-base.form-label for="lastname">Apellidos</x-base.form-label>
                                    <x-base.form-input id="lastname" class="intro-x block min-w-full px-4 py-3 xl:min-w-[350px]" type="text" name="lastname" placeholder="Apellidos" value="{{ old('lastname') }}" required />
                                    @error('lastname')
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
                                        @error('birth_date')
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

                                @if(in_array('email', $selectedFields))
                                    <x-base.form-label for="email">Email</x-base.form-label>
                                    <x-base.form-input id="email" class="intro-x mt-4 block min-w-full px-4 py-3 xl:min-w-[350px]" type="email" name="email" placeholder="Correo Electrónico" value="{{ old('email') }}" required />
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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

                                <div class="intro-x mt-5 text-center xl:mt-8 xl:text-left">
                                    <x-base.button class="w-full px-4 py-3 align-top xl:mr-3 xl:w-32" type="submit" variant="primary">
                                        Registrarse
                                    </x-base.button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END: Registration Form -->
            </div>
        </div>
    </div>
    <script>
        @if(in_array('city_id', $selectedFields))
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
            @if(old('city_id'))
            citySelect.setValue({{ old('city_id') }});
            @endif
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
        filterCities();
        @endif

        function toggleCourtesyCodeInput() {
            var checkbox = document.getElementById('courtesy_code_checkbox');
            var container = document.getElementById('courtesy_code_container');
            if (checkbox.checked) {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }

        function checkCourtesyCode() {
            var code = document.getElementById('courtesy_code').value;

            // Solo realiza la petición si el código tiene 6 dígitos
            if (code.length === 6) {
                fetch(`/check-courtesy-code/{{$event->id}}/${code}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    var messageElement = document.getElementById('courtesy_code_message');
                    var selectTicket = document.querySelector('#id_ticket').tomselect;
                    if (data.exists) {
                        messageElement.textContent = '¡Código válido!';
                        messageElement.classList.remove('text-red-500');
                        messageElement.classList.add('text-green-500');
                        // Cambiar el valor del select
                        selectTicket.setValue(data.ticket_type.id);
                        selectTicket.refreshOptions(false);
                        // Bloquea el select
                        selectTicket.disable();
                    } else {
                        // Código no válido: muestra mensaje de error
                        messageElement.textContent = 'Código no válido.';
                        messageElement.classList.remove('text-green-500');
                        messageElement.classList.add('text-red-500');
                        // Habilita el select si estaba deshabilitado
                        selectTicket.enable();
                    }
                })
                .catch(error => {
                    console.error('Error al verificar el código:', error);
                });
            }
        }
    </script>
@endsection
