@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Silletería</title>
@endsection

@section('subcontent')
    <div class="container">
        <h2 class="intro-y mt-10 text-lg font-medium">Asientos para el evento: {{ $event->name }}</h2>

        <!-- Botón para cargar nuevos registros de silletería a través de Excel -->
        <div class="mb-4">
            <x-base.button href="{{ route('seats.uploadForm', ['idEvent' => $event->id]) }}" class="mr-2 shadow-md" variant="primary">Cargar Silletería desde Excel</x-base.button>
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

        <!-- Contenedor de la cuadrícula de asientos -->
        <div id="seatsGrid" class="grid grid-cols-10 gap-2 mb-8"></div> <!-- grid-cols-10 ajusta la cantidad de columnas -->

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
            document.getElementById('ticketTypeSelect').addEventListener('change', function () {
                const ticketTypeId = this.value;

                if (ticketTypeId) {
                    // Hacer la solicitud AJAX para obtener los asientos
                    fetch(`/get-seats-by-ticket-type/${ticketTypeId}`)
                        .then(response => response.json())
                        .then(data => {
                            const seatsGrid = document.getElementById('seatsGrid');
                            seatsGrid.innerHTML = ''; // Limpiar la cuadrícula

                            data.forEach(function (seat) {
                                const seatBox = document.createElement('div');
                                seatBox.className = `seat ${seat.is_assigned ? 'assigned' : 'available'}`;
                                const userName = (seat.event_assistant?.name || '') + ' ' + (seat.event_assistant?.lastname || '');
                                seatBox.title = userName;
                                seatBox.innerHTML = `<span >${seat.row}-${seat.column}</span>`;
                                seatBox.onclick = () => openAssignModal(seat.id, ticketTypeId);
                                seatBox.onclick = () => {
                                if (seat.is_assigned) {
                                    // Confirmar si se quiere liberar el asiento asignado
                                    if (confirm('¿Desea liberar este asiento?')) {
                                        fetch(`/seats/unassign/${seat.id}`, {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                            }
                                        })
                                        .then(response => {
                                            if (response.ok) {
                                                // Recargar la página si el asiento se liberó exitosamente
                                                window.location.reload();
                                            } else {
                                                alert('No se pudo liberar el asiento. Inténtelo nuevamente.');
                                            }
                                        })
                                        .catch(error => console.error('Error:', error));
                                    }
                                } else {
                                    seatBox.setAttribute('data-tw-toggle', 'modal');
                                    seatBox.setAttribute('data-tw-target', '#assignSeatModal');
                                    // Abrir el modal para asignar el asiento si está disponible
                                    openAssignModal(seat.id, ticketTypeId);
                                }
                            };

                                seatsGrid.appendChild(seatBox);
                            });
                        });
                } else {
                    document.getElementById('seatsGrid').innerHTML = '';
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
                        assistantSelect.innerHTML += `<option value="${assistant.id}">${assistant.name} ${assistant.lastname || ''}</option>`;
                    });
                });
        }
    </script>

    <style>
        /* Estilos para la cuadrícula de asientos */
        #seatsGrid {
            display: grid;
            gap: 10px;
        }

        .seat {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
        }

        .seat.available {
            background-color: #4CAF50; /* Verde para disponible */
            color: white;
        }

        .seat.assigned {
            background-color: #FF5733; /* Rojo para asignado */
            color: white;
        }
    </style>
@endsection
