@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Asistentes del Evento</title>
@endsection

@section('subcontent')
<div class="container">
    <h2 class="mb-4">Asignar Asistentes para el Evento: <b>{{ $event->name }}</b></h2>

    <form method="POST" action="{{ route('eventAssistant.singleAssign.upload', $event->id) }}">
        @csrf

        <div class="form-group">
            <label for="user-select">Seleccionar Asistente</label>
                <x-base.tom-select
                class="w-full {{ $errors->has('user-select') ? 'border-red-500' : '' }}"
                id="user-select"
                name="user-select"
            >
                <option value="">Seleccione un Asistente</option>
                @foreach($assistants as $assistant)
                    <option value="{{ $assistant->id }}">{{ $assistant->name }} {{ $assistant->lastname }} ({{ $assistant->email }})</option>
                @endforeach
            </x-base.tom-select>
        </div>

        <x-base.button
            class="btn btn-primary mt-3"
            type="button"
            variant="primary"
            onclick="addAssistant()"
        >
            Añadir Asistente
        </x-base.button>

        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">

            <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            Asistente
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Tipo de ticket
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Acciones
                        </x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>

                <tbody id="assigned-assistants-table">
                    <!-- Las filas de la tabla se añadirán aquí dinámicamente -->
                </tbody>
            </x-base.table>
        </div>

        <x-base.button
        class="w-24"
        type="submit"
        variant="primary"
    >
        Agregar Asistentes
    </x-base.button>
    </form>
</div>

<script>
    function addAssistant() {
        const userSelect = document.getElementById('user-select');
        const selectedUserId = userSelect.value;
        const selectedUserText = userSelect.options[userSelect.selectedIndex].text;

        if (selectedUserId === '') {
            alert('Debe seleccionar un asistente.');
            return;
        }

        // Verificar si ya se ha añadido este usuario
        const existingRow = document.querySelector(`#assigned-assistants-table tr[data-user-id="${selectedUserId}"]`);
        if (existingRow) {
            alert('Este asistente ya ha sido añadido.');
            return;
        }

        // Crear nueva fila en la tabla
        const row = document.createElement('tr');
        row.setAttribute('data-user-id', selectedUserId);

        // Columna del nombre del asistente
        const nameCell = document.createElement('td');
        nameCell.textContent = selectedUserText;
        row.appendChild(nameCell);

        // Columna del select de tipo de ticket
        const ticketCell = document.createElement('td');
        const ticketSelect = document.createElement('select');
        ticketSelect.name = `ticketTypes[${selectedUserId}]`;
        ticketSelect.className = 'form-control';

        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'Sin Ticket';
        ticketSelect.appendChild(defaultOption);

        @foreach($ticketTypes as $key => $ticketType)
            let option{{$key}} = document.createElement('option');
            option{{$key}}.value = '{{ $ticketType->id }}';
            option{{$key}}.textContent = '{{ $ticketType->name }}';
            ticketSelect.appendChild(option{{$key}});
        @endforeach

        ticketCell.appendChild(ticketSelect);
        row.appendChild(ticketCell);

        // Columna de acciones (Eliminar)
        const actionCell = document.createElement('td');
        const deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.className = 'btn btn-danger';
        deleteButton.textContent = 'Eliminar';
        deleteButton.onclick = function() {
            row.remove();
        };
        actionCell.appendChild(deleteButton);
        row.appendChild(actionCell);

        // Añadir la fila a la tabla
        document.getElementById('assigned-assistants-table').appendChild(row);

        // Resetear el select de usuarios
        userSelect.value = '';
    }
</script>
@endsection
