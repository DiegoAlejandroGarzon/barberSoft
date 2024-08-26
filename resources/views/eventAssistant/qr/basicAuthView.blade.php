@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Información Básica del Evento</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Información Básica del Evento</h2>
    <div class="mt-5">
        <div class="box p-5">
            <p><strong>Nombre del Evento:</strong> {{ $eventAssistant->event->name }}</p>
            <p><strong>Descripción:</strong> {{ $eventAssistant->event->description }}</p>
            <p><strong>Fecha del Evento:</strong> {{ $eventAssistant->event->event_date }}</p>
            <p><strong>Hora de Inicio:</strong> {{ $eventAssistant->event->start_time }}</p>
            <p><strong>Hora de Finalización:</strong> {{ $eventAssistant->event->end_time }}</p>
            <p><strong>Ciudad:</strong> {{ $eventAssistant->event->city->name ?? 'N/A' }}</p>
            <p><strong>Código QR:</strong></p>
            <div class="mt-2">
                {!! $eventAssistant->qrCode !!}
            </div>
        </div>
    </div>
@endsection
