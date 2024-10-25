@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Silletería</title>
@endsection

@section('subcontent')
    <div class="container">

        <h2 class="intro-y mt-10 text-lg font-medium">Asientos para el evento: {{ $event->name }}</b></h2>

        <!-- Botón para cargar nuevos registros de silletería a través de Excel -->
        <div class="mb-4">
            {{-- <a href="{{ route('seats.uploadForm', ['idEvent' => $event->id]) }}" class="btn btn-primary mr-2 shadow-md"></a> --}}

            <x-base.button href="{{ route('seats.uploadForm', ['idEvent' => $event->id]) }}" class="mr-2 shadow-md" variant="primary">Cargar Silletería desde Excel </x-base.button>
        </div>

        <!-- Select para elegir el tipo de ticket -->
        <div class="mb-4">
            <label for="ticketTypeSelect" class="block mb-2">Selecciona un tipo de Boleta al que deseas asignar sillas:</label>
            <select id="ticketTypeSelect" class="form-select">
                <option value="">Selecciona un tipo de ticket</option>
                @foreach($ticketTypes as $ticketType)
                    <option value="{{ $ticketType->id }}">{{ $ticketType->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Tabla donde se mostrarán los asientos -->
        <x-base.preview>
            <div class="overflow-x-auto">
                <x-base.table striped>
                    <x-base.table.thead>
                        <x-base.table.tr>
                            <x-base.table.th class="whitespace-nowrap">Fila</x-base.table.th>
                            <x-base.table.th class="whitespace-nowrap">Columna</x-base.table.th>
                            <x-base.table.th class="whitespace-nowrap">Estado</x-base.table.th>
                            <x-base.table.th class="whitespace-nowrap">Acciones</x-base.table.th>
                        </x-base.table.tr>
                    </x-base.table.thead>
                    <x-base.table.tbody>
                        <!-- Aquí se cargarán los asientos dinámicamente -->
                    </x-base.table.tbody>
                </x-base.table>
            </div>
        </x-base.preview>
    </div>

    <!-- Modal para Asignar Asiento -->
    <x-base.dialog id="assignSeatModal">
        <x-base.dialog.panel class="p-10 text-center" size="xl">
            <form id="assignSeatForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="assignSeatModalLabel">Asignar Asiento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="seat_id" id="seatId">
                    <label for="eventAssistantSelect">Selecciona un asistente:</label>
                    <select id="eventAssistantSelect" name="event_assistant_id" class="form-select" required>
                        <!-- Aquí se llenarán los asistentes de forma dinámica -->
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </x-base.dialog.panel>
    </x-base.dialog>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tbodyElement = document.querySelector('table tbody');
            if (tbodyElement) {
                tbodyElement.id = 'seatsTableBody';
            }

            document.getElementById('ticketTypeSelect').addEventListener('change', function () {
                const ticketTypeId = this.value;

                if (ticketTypeId) {
                    // Hacer la solicitud AJAX para obtener los asientos
                    fetch(`/get-seats-by-ticket-type/${ticketTypeId}`)
                        .then(response => response.json())
                        .then(data => {
                            const seatsTableBody = document.getElementById('seatsTableBody');
                            seatsTableBody.innerHTML = ''; // Limpiar la tabla

                            data.forEach(function (seat) {
                                const row = `
                                    <x-base.table.tr>
                                        <x-base.table.td>${seat.row}</x-base.table.td>
                                        <x-base.table.td>${seat.column}</x-base.table.td>
                                        <x-base.table.td>${seat.is_assigned ? 'Asignado a ' + (seat.event_assistant?.name || '') + ' ' + (seat.event_assistant?.lastname || '') : 'Disponible'}</x-base.table.td>
                                        <x-base.table.td>
                                            ${seat.is_assigned
                                                ? `<form action="/seats/unassign/${seat.id}" method="POST">@csrf<button type="submit" class="btn btn-danger">Liberar</button></form>`
                                                : `<button type="button" class="btn btn-primary" data-tw-toggle="modal" data-tw-target="#assignSeatModal" onclick="openAssignModal(${seat.id}, ${ticketTypeId})">Asignar</button>`
                                            }
                                        </x-base.table.td>
                                    </x-base.table.tr>
                                `;
                                seatsTableBody.insertAdjacentHTML('beforeend', row);
                            });
                        });
                } else {
                    document.getElementById('seatsTableBody').innerHTML = '';
                }
            });
        });

        function openAssignModal(seatId, ticketTypeId) {
            const seatIdInput = document.getElementById('seatId');
            const assistantSelect = document.getElementById('eventAssistantSelect');

            document.getElementById('assignSeatForm').action = `/seats/assign/${seatId}`;

            seatIdInput.value = seatId;
            assistantSelect.innerHTML = '<option value="">Cargando asistentes...</option>';

            fetch(`/get-event-assistants/${ticketTypeId}`)
                .then(response => response.json())
                .then(assistants => {
                    assistantSelect.innerHTML = '<option value="">Selecciona un asistente</option>';
                    assistants.forEach(assistant => {
                        assistantSelect.innerHTML += `<option value="${assistant.id}">${assistant.id} - ${assistant.name} ${assistant.lastname}</option>`;
                    });
                });
        }
    </script>
@endsection
