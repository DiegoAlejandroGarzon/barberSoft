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

                <!-- Botón para guardar los parámetros -->
                <x-base.button class="w-full mt-5" type="submit" variant="primary">
                    Guardar Parámetros
                </x-base.button>
            </form>
        </div>
    </div>
@endsection
