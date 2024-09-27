<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Pago</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .payment-details {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .payment-details strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Detalles del Pago</h2>

    <div class="payment-details">
        <p><strong>Pagador:</strong> {{ $payment->payer_name }}</p>
        <p><strong>Tipo de Documento:</strong> {{ $payment->payer_document_type }}</p>
        <p><strong>Número de Documento:</strong> {{ $payment->payer_document_number }}</p>
        <p><strong>Cantidad Pagada:</strong> {{ $payment->amount }}</p>
        <p><strong>Forma de Pago:</strong> {{ $payment->payment_method }}</p>
    </div>

    @php
        // Obtener los parámetros guardados en registration_parameters
        $selectedFields = json_decode($payment->eventAssistant->event->registration_parameters, true) ?? [];
        $additionalParameters = json_decode($payment->eventAssistant->event->additionalParameters, true) ?? [];
    @endphp
    <div class="mt-5">
        <div class="box p-5" align="center">
            <h1 class="text-lg font-medium">Información del Asistente</h1>

            @foreach($selectedFields as $field)
                <p class=""><strong>{{ ucfirst(str_replace('_', ' ', $field)) }} </strong>: {{ $payment->eventAssistant->user->$field }}</p>
            @endforeach

            @foreach($additionalParameters as $parameter)

            @php
                $userParameter = $payment->eventAssistant->eventParameters->where('event_id', $payment->eventAssistant->event_id)->where('additional_parameter_id', $parameter['id'])->first();
            @endphp
                <p class=""><strong>{{ ucfirst(str_replace('_', ' ', $parameter['name'])) }}</strong>: {{ $userParameter ? $userParameter->value : '-' }}</p>
            @endforeach
            <br>
            <h1 class="text-lg font-medium mt-5">Información del Evento</h1>
            <p><strong>Nombre del Evento:</strong> {{ $payment->eventAssistant->event->name }}</p>
            <p><strong>Descripción:</strong> {{ $payment->eventAssistant->event->description }}</p>
            <p><strong>Fecha del Evento:</strong> {{ $payment->eventAssistant->event->event_date }}</p>
            <p><strong>Hora de Inicio:</strong> {{ $payment->eventAssistant->event->start_time }}</p>
            <p><strong>Hora de Finalización:</strong> {{ $payment->eventAssistant->event->end_time }}</p>
            <p><strong>Ciudad:</strong> {{ $payment->eventAssistant->event->city->name ?? 'N/A' }}</p>
            <p><strong>Capacidad:</strong> {{ $payment->eventAssistant->event->capacity }}</p>
            <br>
            <h3 class="text-lg font-medium mt-5">Características del Ticket</h3>
            <ul>
                <strong>Nombre:</strong> {{ $payment->eventAssistant->ticketType?->name ?? "SIN REGISTRO"  }} <br>
                <strong>Caracteristicas:</strong>
                @foreach ($payment->eventAssistant?->ticketType?->features as $feature)
                        {{ $feature->name }},
                @endforeach
                <br>
                <strong>Precio:</strong> ${{ $payment->eventAssistant->ticketType?->formattedPrice() }}
            </ul>
            <br>
            @if ($payment->payment_proof)
                <div class="mb-4">
                    <h1>Comrpobante pago</h1>
                    <img class="w-100 h-100" src="{{ public_path('storage/' . $payment->payment_proof) }}" alt="Comprobante pago">
                </div>
            @endif
        </div>
    </div>
</body>
</html>
