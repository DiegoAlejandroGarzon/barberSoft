@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Eventos</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Lista de Cupones del evento: <b>{{$event->name}}</b></h2>

    <div class="box">
        <div class="flex flex-col sm:flex-row justify-between m-4" style="margin:1rem">
            <!-- Seleccionar tipo de ticket -->
            <div class="sm:w-1/3 mb-2 sm:mb-0" style="width: 33.333333%; margin:1rem">
                <label for="ticketType" class="block text-sm font-medium text-gray-700">Seleccionar Ticket</label>
                <select id="ticketType" name="ticketType" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    @foreach($tickets as $ticket)
                        <option value="{{ $ticket->id }}">
                            {{ $ticket->name }}
                            ({{ $consumedCouponsByTicket[$ticket->id] ?? 0 }} -
                            {{ $couponsByTicket[$ticket->id] ?? 0 }} /
                            {{$ticket->capacity}})
                            {{ ($couponsByTicket[$ticket->id] ?? 0) >= $ticket->capacity }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="sm:w-1/3 mb-2 sm:mb-0" style="width: 33.333333%; margin:1rem">
                <label for="numberOfCoupons" class="block text-sm font-medium text-gray-700">N° de cupones</label>
                <input type="number" id="numberOfCoupons" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
            </div>
            <!-- Botón para generar nuevos códigos -->
            <div class="sm:w-1/4" style="width: 33.333333%; margin:1rem">

                <x-base.button
                    id="generateCouponsButton"
                    class="mr-2 shadow-md"
                    variant="primary"
                >
                Generar nuevos códigos
                </x-base.button>

                <!-- Modal de Carga -->
                <div id="loadingModal" style="display: none">
                    <div class="">
                        <h4>Generating Coupons...</h4>
                        <p id="progressText">Generated: 0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box mt-3">

        <div class="grid-cols-2 gap-2 sm:grid">
            <div class="m-3">
                <a id="generatePdfMassive" class="ml-3" href="javascript:void(0)">
                    <x-base.button class="mr-2 shadow-md" variant="primary">
                        Generar PDF Masivo Cupones Disponibles
                    </x-base.button>
                </a>
            </div>

        <x-base.preview>
            <!-- BEGIN: Modal Toggle -->
            <div class="text-center">
                <x-base.button
                    id="viewGeneratedZips" data-tw-toggle="modal" data-tw-target="#basic-modal-preview" as="a" variant="primary" class="mt-4">
                    Ver Archivos ZIP Generados
                </x-base.button>
            </div>
            <!-- END: Modal Toggle -->
            <!-- BEGIN: Modal Content -->
            <x-base.dialog id="basic-modal-preview">
                <x-base.dialog.panel class="p-10 text-center" size="xl">
                    <h2>Archivos ZIP generados</h2>
                    <table id="zipTable" class="table-auto w-full text-left mt-4">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Archivo ZIP</th>
                            </tr>
                        </thead>
                        <tbody id="zipList"></tbody>
                    </table>
                </x-base.dialog.panel>
            </x-base.dialog>
            <!-- END: Modal Content -->
        </x-base.preview>

            <div class="m-3">
                <a class="ml-3" href="{{ route('coupons.excel', ['idEvent' => $idEvent]) }}">
                    <x-base.button class="mr-2 shadow-md" variant="primary">
                        Generar EXCEL Cupones Totales
                    </x-base.button>
                </a>
            </div>
        </div>
    </div>

    <!-- BEGIN: Data List -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
            <x-base.table.thead>
                <x-base.table.tr>
                    <x-base.table.th class="whitespace-nowrap border-b-0">N</x-base.table.th>
                    <x-base.table.th class="whitespace-nowrap border-b-0">Código</x-base.table.th>
                    <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Ticket</x-base.table.th>
                    <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Status</x-base.table.th>
                    <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Fecha Creación</x-base.table.th>
                    <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Acciones</x-base.table.th>
                </x-base.table.tr>
            </x-base.table.thead>
            <x-base.table.tbody id="couponsTableBody">
                @foreach ($coupons as $key => $coupon)
                    <x-base.table.tr class="intro-x">
                        <x-base.table.td class="box w-40 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">{{ ($coupons->currentPage() - 1) * $coupons->perPage() + $key + 1 }}</x-base.table.td>
                        <x-base.table.td class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">{{ $coupon->numeric_code }}</x-base.table.td>
                        <x-base.table.td class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">{{ $coupon->ticketType?->name }}</x-base.table.td>
                        <x-base.table.td class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600 {{ $coupon->is_consumed ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
                            {{ $coupon->is_consumed ? "No Disponible" : "Disponible" }}
                        </x-base.table.td>
                        <x-base.table.td class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">{{ $coupon->created_at->format('d/m/Y') }}</x-base.table.td>
                        <x-base.table.td class="box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            <div class="flex items-center justify-center">
                                <x-base.tippy content="Generar PDF" class="mr-1">
                                    <a class="text-info" href="{{ route('coupon.pdf', ['id' => $coupon->id]) }}" target="_blank">
                                        <x-base.lucide icon="FileText" />
                                    </a>
                                </x-base.tippy>
                                @if (!$coupon->is_consumed) <!-- Solo mostrar el botón si el cupón no ha sido consumido -->
                                <x-base.tippy content="Eliminar Cupón" class="ml-1">
                                    <form action="{{ route('coupon.delete', ['id' => $coupon->id]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este cupón?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-danger">
                                            <x-base.lucide icon="Trash" />
                                        </button>
                                    </form>
                                </x-base.tippy>
                            @endif
                            </div>
                        </x-base.table.td>
                    </x-base.table.tr>
                @endforeach
            </x-base.table.tbody>
        </x-base.table>
    </div>
    <!-- END: Data List -->

    <!-- BEGIN: Pagination -->
    <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
        {{ $coupons->withQueryString()->links() }}
    </div>
    <!-- END: Pagination -->

    <script>
        document.getElementById('generateCouponsButton').addEventListener('click', function () {
            const eventId = {{$idEvent}};
            const numberOfCoupons = document.getElementById('numberOfCoupons').value;
            const ticketTypeId = document.getElementById('ticketType').value;

            // Verificar si hay un job en progreso
            fetch(`/check-job-status/${eventId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'error') {
                        alert(data.message);
                        return;
                    }

                    // Si no hay jobs en progreso, iniciar generación
                    const modal = document.getElementById('loadingModal');
                    modal.style.display = 'block'; // Mostrar modal

                    fetch("{{ route('generateCoupons') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            event_id: eventId,
                            number_of_coupons: numberOfCoupons,
                            ticket_type_id: ticketTypeId,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert('Se inició la generación de cupones. Comprueba el progreso...');
                        checkJobProgress(); // Llamar función para monitorear progreso
                    })
                    .catch(error => console.error('Error:', error));
                });
        });


        function checkJobProgress() {
            fetch('{{ route('job-progress', ['eventId' => $idEvent]) }}')
            .then(response => response.json())
            .then(data => {

                if (data.status === 'sinRegistros') {
                    document.getElementById('loadingModal').style.display = 'none';
                } else {
                    document.getElementById('loadingModal').style.display = 'block';
                    document.getElementById('progressText').innerText = `Generated: ${data.progress}`;
                    setTimeout(checkJobProgress, 2000); // Revisar cada 5 segundos
                }
            });
        }
        checkJobProgress();
    </script>
    {{-- <script>
        document.getElementById('generatePdfMassive').addEventListener('click', function () {
            const idEvent = {{$idEvent}};

            // Obtener cupones disponibles
            fetch(`/api/coupons/count-available/${idEvent}`)
                .then(response => response.json())
                .then(data => {
                    const totalCoupons = data.total;
                    const batchSize = 500; // Tamaño del lote
                    let processedCoupons = 0;

                    if (totalCoupons === 0) {
                        alert('No hay cupones disponibles para generar.');
                        return;
                    }

                    // Llamadas por lote
                    for (let i = 0; i < totalCoupons; i += batchSize) {
                        generatePDFBatch(idEvent, i, batchSize);
                    }
                });
        });

        function generatePDFBatch(idEvent, offset, limit) {
            fetch(`/generate-massive-pdf/${idEvent}?offset=${offset}&limit=${limit}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/zip' // Acepta un archivo ZIP
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.blob(); // Obtener el contenido como Blob
                } else {
                    throw new Error('Error en la generación del PDF');
                }
            })
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `cupones_evento_${idEvent}_${new Date().toISOString()}.zip`; // Nombre del archivo
                document.body.appendChild(a);
                a.click(); // Simular clic para descargar
                a.remove(); // Eliminar el elemento
                window.URL.revokeObjectURL(url); // Liberar memoria
            })
            .catch(error => console.error('Error:', error));
        }
    </script> --}}
    <script>
        document.getElementById('generatePdfMassive').addEventListener('click', function () {
            const idEvent = {{$idEvent}};

            fetch(`/check-job-status/${idEvent}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'error') {
                    alert(data.message);
                    return;
                }

                // Si no hay jobs en progreso, iniciar generación
                const modal = document.getElementById('loadingModal');
                modal.style.display = 'block'; // Mostrar modal


                // Iniciar el Job para generar PDFs
                fetch(`/generate-pdf-job/${idEvent}`)
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                    })
                    // .then(response => response.json())
                    .then(data => {
                        alert('Se inició la generación de zips.');
                        checkJobProgress(); // Llamar función para monitorear progreso
                    })
                    .catch(error => console.error('Error:', error));
            });
        });

        document.getElementById('viewGeneratedZips').addEventListener('click', function () {
            const idEvent = {{$idEvent}};

            // Obtener los archivos ZIP generados
            fetch(`/generated-zips/${idEvent}`)
                .then(response => response.json())
                .then(data => {
                    const zipList = document.getElementById('zipList');
                    zipList.innerHTML = ''; // Limpiar la tabla antes de rellenarla

                    data.zips.forEach(function (zip, index) {
                        const row = document.createElement('tr');

                        // Columna de índice
                        const indexCell = document.createElement('td');
                        indexCell.classList.add('px-4', 'py-2');
                        indexCell.textContent = index + 1;

                        // Columna del enlace
                        const linkCell = document.createElement('td');
                        linkCell.classList.add('px-4', 'py-2');

                        const link = document.createElement('a');
                        link.href = `/storage/${zip}`;
                        link.textContent = zip; // Nombre del archivo
                        link.classList.add('text-blue-500', 'underline'); // Color azul y subrayado

                        linkCell.appendChild(link);
                        row.appendChild(indexCell);
                        row.appendChild(linkCell);
                        zipList.appendChild(row);
                    });

                    document.getElementById('zipModal').classList.remove('hidden');
                });
        });


        function checkJobStatus() {
            const idEvent = {{$idEvent}};
            fetch(`/check-job-status/${idEvent}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status != "ok") {
                        alert('Un proceso está en ejecución para este evento.');
                    } else {
                        // alert('No hay jobs en ejecución.');
                    }
                });
        }
        checkJobStatus();
    </script>

@endsection
