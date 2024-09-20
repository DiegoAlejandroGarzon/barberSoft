@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Pagar Ticket</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Informacion del Pago</h2>
    <div class="mt-5 flex justify-center">
        <a class="text-info box p-3" href="{{ route('eventAssistant.sendEmailInfoPago', ['id' => $eventAssistant->id]) }}" target="_blank">
            <x-base.lucide icon="send" /> Enviar Correo
        </a>
    </div>

    @php
        // Obtener los parámetros guardados en registration_parameters
        $selectedFields = json_decode($eventAssistant->event->registration_parameters, true) ?? [];
        $additionalParameters = json_decode($eventAssistant->event->additionalParameters, true) ?? [];
    @endphp
    <div class="mt-5">
        <div class="box p-5">
            <h3 class="text-lg font-medium">Información del Asistente</h3>

            @foreach($selectedFields as $field)
                <p class=""><strong>{{ ucfirst(str_replace('_', ' ', $field)) }} </strong>: {{ $eventAssistant->user->$field }}</p>
            @endforeach

            @foreach($additionalParameters as $parameter)

            @php
                $userParameter = $eventAssistant->eventParameters->where('event_id', $eventAssistant->event_id)->where('additional_parameter_id', $parameter['id'])->first();
            @endphp
                <p class=""><strong>{{ ucfirst(str_replace('_', ' ', $parameter['name'])) }}</strong>: {{ $userParameter ? $userParameter->value : '-' }}</p>
            @endforeach
            <h3 class="text-lg font-medium mt-5">Información del Evento</h3>
            <p><strong>Nombre del Evento:</strong> {{ $eventAssistant->event->name }}</p>
            <p><strong>Descripción:</strong> {{ $eventAssistant->event->description }}</p>
            <p><strong>Fecha del Evento:</strong> {{ $eventAssistant->event->event_date }}</p>
            <p><strong>Hora de Inicio:</strong> {{ $eventAssistant->event->start_time }}</p>
            <p><strong>Hora de Finalización:</strong> {{ $eventAssistant->event->end_time }}</p>
            <p><strong>Ciudad:</strong> {{ $eventAssistant->event->city->name ?? 'N/A' }}</p>
            <p><strong>Capacidad:</strong> {{ $eventAssistant->event->capacity }}</p>
            <br>
            <h3 class="text-lg font-medium mt-5">Características del Ticket</h3>
            <ul>
                <strong>Nombre:</strong> {{ $eventAssistant->ticketType?->name ?? "SIN REGISTRO"  }} <br>
                <strong>Caracteristicas:</strong>
                @foreach ($eventAssistant?->ticketType?->features as $feature)
                        {{ $feature->name }},
                @endforeach
                <br>
                <strong>Precio:</strong> {{ $eventAssistant->ticketType?->price }}
            </ul>
            <br>
        </div>
    </div>

    @if (!$eventAssistant->is_paid)
    @if($eventAssistant->totalPayments() > 0)
    <div class="mt-5">
        <div class="box p-5">
            Actualmente se tiene registrado un abono Total de {{$eventAssistant->totalPayments()}}

            @foreach($eventAssistant->payments as $payment)
            <div class="mb-4 box p-1">
                Pago por un valor de  <strong>{{$payment->amount}}</strong> por <strong>{{$payment->payer_name}}</strong>
                <a class="ml-1 underline" target="_blank" href="{{ route('payments.generatePDF', ['id' => $payment->id]) }}">Generar PDF</a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    <div class="mt-5">
        <div class="box p-5">
            <h3 class="text-lg font-medium">Realizar Pago</h3>
            <form action="{{ route('eventAssistant.payment.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Nombre del Pagador -->
                <div class="mt-3">
                    <label for="payer_name" class="form-label">Nombre del Pagador</label>
                    <input type="text" id="payer_name" name="payer_name" class="form-control" required>
                </div>

                <!-- Tipo de Documento del Pagador -->
                <div class="mt-3">
                    <label for="payer_document_type" class="form-label">Tipo de Documento</label>
                    <select id="payer_document_type" name="payer_document_type" class="form-control" required>
                        <option value="" disabled selected>Seleccione el tipo de documento</option>
                        <option value="CC">Cédula de Ciudadanía</option>
                        <option value="TI">Tarjeta de Identidad</option>
                        <option value="PP">Pasaporte</option>
                    </select>
                </div>

                <!-- Número de Documento del Pagador -->
                <div class="mt-3">
                    <label for="payer_document_number" class="form-label">Número de Documento</label>
                    <input type="text" id="payer_document_number" name="payer_document_number" class="form-control" required>
                </div>

                <!-- Cantidad a Pagar -->
                <div class="mt-3">
                    <label for="amount" class="form-label">Cantidad a Pagar</label>
                    <input type="number" id="amount" name="amount" class="form-control" value="{{ $eventAssistant->ticketType?->price - $eventAssistant->totalPayments() }}" required>
                </div>

                <!-- Forma de Pago -->
                <div class="mt-3">
                    <label for="payment_method" class="form-label">Forma de Pago</label>
                    <select id="payment_method" name="payment_method" class="form-control" required onchange="togglePaymentProof()">
                        <option value="" disabled selected>Seleccione la forma de pago</option>
                        <option value="transferencia">Transferencia</option>
                        <option value="efectivo">Efectivo</option>
                        <option value="PayPal">Paypal</option>
                    </select>
                </div>

                <!-- Imagen de la Transferencia -->
                <div class="mt-3" id="transfer_proof" style="display: none;">
                    <label for="payment_proof" class="form-label">Comprobante de Transferencia</label>
                    <input type="file" id="payment_proof" name="payment_proof" class="form-control">
                </div>

                <!-- Botón para enviar -->
                <div class="mt-5">
                    <button data-tw-merge type="submit" class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed bg-primary border-primary text-white dark:border-primary mb-2 mr-1 w-24 mb-2 mr-1 w-24">Realizar Pago</button>
                </div>

                <!-- ID del asistente -->
                <input type="hidden" name="event_assistant_id" value="{{ $eventAssistant->id }}">
            </form>
        </div>
    </div>
    @else

    <div class="mt-5">
        <div class="box p-5">
            Actualmente el ticket ya está registrado como pagado

            @foreach($eventAssistant->payments as $payment)
            @if ($payment->payment_proof)
            <div class="mb-4">
                <img class="w-100 h-100" src="{{ asset('storage/' . $payment->payment_proof) }}" alt="Comprobante pago">
            </div>
            @endif
            @endforeach
            </div>
    </div>
    @endif
@endsection


<script>
    function togglePaymentProof() {
        var paymentMethod = document.getElementById('payment_method').value;
        var transferProof = document.getElementById('transfer_proof');
        if (paymentMethod === 'transferencia') {
            transferProof.style.display = 'block';
        } else {
            transferProof.style.display = 'none';
        }
    }
</script>
