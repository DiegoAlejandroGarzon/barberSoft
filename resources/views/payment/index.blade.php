@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Asistentes del Evento</title>
@endsection

@section('subcontent')
    @if(session('error'))
        <x-base.alert class="mb-2 flex items-center" variant="danger">
            <x-base.lucide class="mr-2 h-6 w-6" icon="AlertCircle" />
            {{ session('error') }}
        </x-base.alert>
    @endif
    <h2 class="intro-y mt-10 text-lg font-medium">RECAUDOS</h2>
    <div class="">

        <!-- BEGIN: DashBoard -->
    <div class="mt-5">
        <div class="box p-5">
            <h3 class="text-lg font-medium">Información del Pagos y cupones</h3>
            <p><strong>recaudoTotal:</strong> {{number_format($recaudoTotal, 0, '', '.')}} </p>
            <p><strong>asistentes que han pagado:</strong> {{$asistentesPagos}} </p>
            <p><strong>asistentes sin entrada:</strong> {{$asistentesSinEntrada}} </p>
            <p><strong>cupones redimidos:</strong> {{$cuponesRedimidos}} </p>
            <p><strong>cupones No redimidos:</strong> {{$cuponesNoRedimidos}} </p>
            <br>
        </div>
    </div>
        <!-- END: Data List -->
        <!-- BEGIN: Botones Generales -->
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <x-base.menu>
                <x-base.menu.button class="!box" as="x-base.button">
                    <span class="flex items-center justify-center">
                        <x-base.lucide class="h-4 w-4" icon="Plus" />Reporte Pagos
                    </span>
                </x-base.menu.button>
                <x-base.menu.items class="w-40">
                    <x-base.menu.item>
                        <a class="mr-3" target="_blank" href="{{ route('payment.exportExcel', [
                            'idEvent' => $idEvent,
                            'search' => request()->input('search'),
                            'additionalParameters' => request()->input('additionalParameters', [])
                            ]) }}">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="FileText" /> Pagos Realizados (EXCEL)
                        </a>
                        <a class="mr-3" target="_blank" href="{{ route('paymentStatus.exportExcel', [
                            'idEvent' => $idEvent,
                            'search' => request()->input('search'),
                            'additionalParameters' => request()->input('additionalParameters', [])
                            ]) }}">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="FileText" /> Status Pago (EXCEL)
                        </a>
                    </x-base.menu.item>
                </x-base.menu.items>
            </x-base.menu>

            <div class="mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto md:ml-0">
                <form method="GET" action="{{ route('payments.index', ['idEvent' => $idEvent]) }}">
                    <div class="relative w-56 text-slate-500">
                        <input type="text" name="search" class="!box w-56 pr-10" value="{{ request()->input('search') }}" placeholder="Buscar..." />

                        <button type="submit" class="absolute inset-y-0 right-0 my-auto mr-3 h-4 w-4">
                            <x-base.lucide icon="Search" />
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        @php
            // Obtener los parámetros guardados en registration_parameters
            $selectedFields = json_decode($event->registration_parameters, true) ?? [];
        @endphp
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <div class="overflow-x-auto">
                <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                    <x-base.table.thead>
                        <x-base.table.tr>
                            <!-- Carga dinámica de columnas -->
                            @foreach(['name', 'email', 'document_number'] as $field)
                                @if(in_array($field, $selectedFields))
                                    <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                                        {{ config("traductorColumnasUsers.$field", ucfirst(str_replace('_', ' ', $field))) }}
                                    </x-base.table.th>
                                @endif
                            @endforeach

                            <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Tipo de Boleta</x-base.table.th>
                            <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Estatus de pago</x-base.table.th>
                            <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Entrada</x-base.table.th>
                            <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Consumos</x-base.table.th>
                            <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Acciones</x-base.table.th>
                        </x-base.table.tr>
                    </x-base.table.thead>
                    <x-base.table.tbody>
                        @foreach ($asistentes as $asistente)
                            <x-base.table.tr class="intro-x">
                                <!-- Carga dinámica de contenido de las filas -->
                                @foreach(['name', 'email', 'document_number'] as $field)
                                    @if(in_array($field, $selectedFields))
                                        <x-base.table.td class="box text-center">
                                            {{ $asistente->user->$field }}
                                        </x-base.table.td>
                                    @endif
                                @endforeach
                                <!-- Columna de acciones -->
                                <x-base.table.td class="box text-center">{{ $asistente->ticketType?->name ?? "SIN REGISTRO"  }}</x-base.table.td>
                                <x-base.table.td class="box text-center">
                                    @if ($asistente->is_paid)
                                    @php
                                        // Buscar los pagos para el asistente del evento
                                        $payments = \App\Models\Payment::where('event_assistant_id', $asistente->id)->get();

                                        // Si no existen pagos, buscar un cupón consumido
                                        $coupon = $payments->isEmpty() ? \App\Models\Coupon::where('event_assistant_id', $asistente->id)
                                                                    ->where('is_consumed', true)
                                                                    ->first() : null;

                                        // Formatear los montos sin decimales y separarlos por guiones
                                        $formattedPayments = $payments->map(function($payment) {
                                            return number_format($payment->amount, 0, '', '.'); // Eliminar los decimales .00
                                        })->implode(' - ');
                                    @endphp

                                    @if ($payments->isNotEmpty())
                                        <!-- Mostrar el monto pagado si existen pagos -->
                                        <div role="alert" class="alert rounded-md bg-success text-slate-900 dark:border-success">
                                            Pagado - Monto: {{ $formattedPayments }}
                                        </div>
                                    @elseif ($coupon)
                                        <!-- Mostrar el código del cupón si existe uno consumido -->
                                        <div role="alert" class="alert rounded-md bg-success text-slate-900 dark:border-success">
                                            Pagado con Cupón - Código: {{ $coupon->numeric_code }}
                                        </div>
                                    @else
                                        <!-- Si no hay pagos ni cupón, solo mostrar pagado sin detalles -->
                                        <div role="alert" class="alert rounded-md bg-success text-slate-900 dark:border-success">
                                            Pagado (sin registro pago o cupón)
                                        </div>
                                    @endif

                                    @else
                                        <!-- Lógica para cuando no ha sido pagado -->
                                        @if ($asistente->totalPayments() == 0)
                                            <div role="alert" class="alert relative border rounded-md bg-danger border-danger text-white dark:border-danger mb-2 p-1">
                                                No Pagado
                                            </div>
                                        @else

                                        @php
                                            // Buscar los pagos para el asistente del evento
                                            $payments = \App\Models\Payment::where('event_assistant_id', $asistente->id)->get();

                                            // Formatear los montos sin decimales y separarlos por guiones
                                            $formattedPayments = $payments->map(function($payment) {
                                                return number_format($payment->amount, 0, '', '.'); // Eliminar los decimales .00
                                            })->implode(' - ');
                                        @endphp
                                            <div role="alert" class="alert rounded-md bg-warning text-slate-900 dark:border-warning p-1">
                                                Pendiente - Monto: {{ $formattedPayments }}
                                            </div>
                                        @endif
                                    @endif
                                </x-base.table.td>

                                <x-base.table.td class="box text-center">
                                    @if ($asistente->has_entered)
                                        <div role="alert" class="alert rounded-md bg-success text-slate-900 dark:border-success p-1">
                                            Entrada
                                        </div>
                                    @else
                                        <div role="alert" class="alert rounded-md bg-warning text-slate-900 dark:border-warning p-1">
                                            No Entrada
                                        </div>
                                    @endif
                                </x-base.table.td>

                                <x-base.table.td class="box text-center">
                                    @if ($asistente->featureConsumptions->isEmpty())
                                        SIN CONSUMOS
                                    @else
                                        {{ $asistente->featureConsumptions->pluck('ticketFeature.name')->implode(', ') }}
                                    @endif
                                </x-base.table.td>

                                <x-base.table.td class="box w-56">
                                    <div class="flex items-center justify-center">
                                        <x-base.tippy content="Gestion de Pagos" class="mr-1">
                                            <a class="text-warning" href="{{ route('eventAssistant.payment', ['id' => $asistente->id]) }}" target="_blank">
                                                <x-base.lucide icon="credit-card" />
                                            </a>
                                        </x-base.tippy>
                                    </div>
                                </x-base.table.td>
                            </x-base.table.tr>
                        @endforeach
                    </x-base.table.tbody>
                </x-base.table>
            </div>
        </div>
        <!-- END: Data List -->

    <!-- BEGIN: Delete Confirmation Modal -->
    <x-base.dialog id="delete-confirmation-modal">
        <x-base.dialog.panel>
            <div class="p-5 text-center">
                <x-base.lucide
                    class="mx-auto mt-3 h-16 w-16 text-danger"
                    icon="XCircle"
                />
                <div class="mt-5 text-3xl">¿Está seguro?</div>
                <div class="mt-2 text-slate-500">
                    ¿Realmente desea eliminar estos registros? <br />
                    Este proceso no se puede deshacer.
                </div>
            </div>
            <div class="px-5 pb-8 text-center">
                <x-base.button
                    class="mr-1 w-24"
                    data-tw-dismiss="modal"
                    type="button"
                    variant="outline-secondary"
                >
                    Cancel
                </x-base.button>

                <!-- Formulario de eliminación -->
                <form id="delete-form" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <x-base.button
                        class="w-24"
                        type="submit"
                        variant="danger"
                    >
                        Delete
                    </x-base.button>
                </form>
            </div>
        </x-base.dialog.panel>
    </x-base.dialog>


    <script>
        function setDeleteAction(element) {
            // Obtener el ID desde el atributo data-id
            const id = element.getAttribute('data-id');
            // Establecer la acción del formulario con la ruta dinámica
            const form = document.getElementById('delete-form');
            form.action = `/assistants/delete/${id}`;
        }
        document.getElementById('generateCouponsButton').addEventListener('click', function () {
            const eventId = {{$idEvent}}; // ID del evento (modificar dinámicamente si es necesario)
            const numberOfCoupons = document.getElementById('ticketType').value;; // Número de cupones que quieres generar
            const ticketTypeId = document.getElementById('ticketType').value; // Obtener el ticket seleccionado

            fetch("{{ route('generateCoupons') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    event_id: eventId,
                    number_of_coupons: numberOfCoupons,
                    ticket_type_id: ticketTypeId // Enviar el ID del ticket
                })
            })
            .then(response => response.json())
            .then(data => {
                // Aquí puedes recargar los cupones y actualizar la tabla
                loadCoupons(eventId);
            })
            .catch(error => console.error('Error:', error));
        });

        // Función para cargar los cupones y actualizar la tabla
        function loadCoupons(eventId) {
            fetch(`/get-coupons/${eventId}`)
                .then(response => response.json())
                .then(coupons => {
                    let tableBody = document.getElementById('couponsTableBody');
                    tableBody.innerHTML = ''; // Limpiar la tabla

                    coupons.forEach((coupon, index) => {
                        let row = `
                            <tr>
                                <td class="px-4 py-2">${index + 1}</td>
                                <td class="px-4 py-2">${coupon.numeric_code}</td>
                                <td class="px-4 py-2">${coupon.ticket_type.name}</td>
                                <td class="px-4 py-2">${coupon.is_consumed ? 'Sí' : 'No'}</td>
                            </tr>
                        `;
                        tableBody.insertAdjacentHTML('beforeend', row);
                    });
                });
        }
        loadCoupons({{$idEvent}});
    </script>

    <!-- END: Delete Confirmation Modal -->

        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
            {{ $asistentes->links() }}
        </div>
        <!-- END: Pagination -->
    </div>
@endsection
