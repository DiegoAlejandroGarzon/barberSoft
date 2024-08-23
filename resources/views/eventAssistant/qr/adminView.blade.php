@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Detalles del Asistente y del Evento</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Detalles del Asistente y del Evento</h2>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="mt-5">
        <div class="box p-5">
            <h3 class="text-lg font-medium">Información del Asistente</h3>
            <p><strong>Nombre:</strong> {{ $eventAssistant->user->name }} {{ $eventAssistant->user->lastname }}</p>
            <p><strong>Correo:</strong> {{ $eventAssistant->user->email }}</p>
            <p><strong>Teléfono:</strong> {{ $eventAssistant->user->phone }}</p>
            <p><strong>Tipo de Documento:</strong> {{ $eventAssistant->user->type_document }}</p>
            <p><strong>Número de Documento:</strong> {{ $eventAssistant->user->document_number }}</p>
            <p><strong>Ciudad:</strong> {{ $eventAssistant->user->city->name ?? 'N/A' }}</p>
            <p><strong>Tipo de Ticket:</strong> {{ $eventAssistant->ticketType->name ?? 'N/A' }}</p>
            <p><strong>Fecha de Registro:</strong> {{ $eventAssistant->created_at->format('d/m/Y') }}</p>
            <p><strong>GUID:</strong> {{ $eventAssistant->guid }}</p>
            <p><strong>Código QR:</strong></p>
            <div class="mt-2">
                {!! $eventAssistant->qr_code !!}
            </div>

            <h3 class="text-lg font-medium mt-5">Información del Evento</h3>
            <p><strong>Nombre del Evento:</strong> {{ $eventAssistant->event->name }}</p>
            <p><strong>Descripción:</strong> {{ $eventAssistant->event->description }}</p>
            <p><strong>Fecha del Evento:</strong> {{ $eventAssistant->event->event_date }}</p>
            <p><strong>Hora de Inicio:</strong> {{ $eventAssistant->event->start_time }}</p>
            <p><strong>Hora de Finalización:</strong> {{ $eventAssistant->event->end_time }}</p>
            <p><strong>Ciudad:</strong> {{ $eventAssistant->event->city->name ?? 'N/A' }}</p>
            <p><strong>Capacidad:</strong> {{ $eventAssistant->event->capacity }}</p>

            <br>
            <!-- Botón para Registrar Ingreso -->

            @if(!$eventAssistant->has_entered)
            <form action="{{ route('eventAssistant.registerEntry', $eventAssistant->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <x-base.button
                class="w-24"
                type="submit"
                variant="primary"
                >
                Registrar Ingreso
                </x-base.button>
            </form>
            @else

            <div class="mt-2 flex items-center">
                <x-base.alert
                class="mb-2 flex items-center"
                variant="warning"
            >
                <x-base.lucide
                    class="mr-2 h-6 w-6"
                    icon="AlertCircle"
                />
                Status:
                YA HA REGISTRADO EL INGRESO
            </x-base.alert>
            </div>
            @endif
        </div>
        </div>
    </div>
@endsection
