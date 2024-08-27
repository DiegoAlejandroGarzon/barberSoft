@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Asistentes del Evento</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Lista de Asistentes</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <script>
            const chartData = @json($data);
        </script>

        <div class="intro-y box mt-5 p-5 col-span-12 items-center">
            <div class="mt-3">
                <x-chart-assistants height="h-[213px]" />
            </div>
            <div class="mx-auto mt-8 w-52 sm:w-auto">
                <div class="flex items-center">
                    <div class="mr-3 h-2 w-2 rounded-full bg-primary"></div>
                    <span class="truncate">Entradas registradas</span>
                    <span class="ml-auto font-medium">{{ $data['soldTickets'] }} ({{ round(($data['soldTickets'] / $data['capacity']) * 100, 2) }}%)</span>
                </div>
                <div class="mt-4 flex items-center">
                    <div class="mr-3 h-2 w-2 rounded-full bg-pending"></div>
                    <span class="truncate">Entradas Disponibles</span>
                    <span class="ml-auto font-medium">{{ $data['availableTickets'] }} ({{ round(($data['availableTickets'] / $data['capacity']) * 100, 2) }}%)</span>
                </div>
            </div>
        </div>

        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <a href="{{ route('eventAssistant.massAssign', ['idEvent' => $idEvent]) }}">
                <x-base.button class="mr-2 shadow-md" variant="primary">
                    Asignar Asistentes Masivamente
                </x-base.button>
            </a>
            <a href="{{ route('eventAssistant.singleAssignForm', ['idEvent' => $idEvent]) }}">
                <x-base.button class="mr-2 shadow-md" variant="secondary">
                    Asignar Asistente Manualmente
                </x-base.button>
            </a>
            <x-base.menu>
                <x-base.menu.button class="!box px-2" as="x-base.button">
                    <span class="flex h-5 w-5 items-center justify-center">
                        <x-base.lucide class="h-4 w-4" icon="Plus" />
                    </span>
                </x-base.menu.button>
                <x-base.menu.items class="w-40">
                    <x-base.menu.item>
                        <x-base.lucide class="mr-2 h-4 w-4" icon="Printer" /> Imprimir
                    </x-base.menu.item>
                    <x-base.menu.item>
                        <x-base.lucide class="mr-2 h-4 w-4" icon="FileText" /> Exportar a Excel
                    </x-base.menu.item>
                    <x-base.menu.item>
                        <x-base.lucide class="mr-2 h-4 w-4" icon="FileText" /> Exportar a PDF
                    </x-base.menu.item>
                </x-base.menu.items>
            </x-base.menu>
            <div class="mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto md:ml-0">
                <form method="GET" action="{{ route('eventAssistant.index', ['idEvent' => $idEvent]) }}">
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
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="whitespace-nowrap border-b-0">Nombre</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Correo</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Teléfono</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Tipo de ticket</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Entrada</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Acciones</x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach ($asistentes as $asistente)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td class="box">{{ $asistente->user->name }}</x-base.table.td>
                            <x-base.table.td class="box text-center">{{ $asistente->user->email }}</x-base.table.td>
                            <x-base.table.td class="box text-center">{{ $asistente->user->phone }}</x-base.table.td>
                            <x-base.table.td class="box text-center">{{ $asistente->ticketType?->name }}</x-base.table.td>
                            <x-base.table.td class="box text-center">
                                @if ($asistente->has_entered)
                                    <div role="alert" class="alert bg-success text-slate-900 dark:border-success">
                                        Entrada
                                    </div>
                                @else
                                    <div role="alert" class="alert bg-warning text-slate-900 dark:border-warning">
                                        No entrada
                                    </div>
                                @endif
                            </x-base.table.td>
                            <x-base.table.td class="box w-56">
                                <div class="flex items-center justify-center">
                                    <a class="mr-3" href="{{ route('eventAssistant.edit', ['id' => $asistente->id]) }}">
                                        <x-base.lucide icon="CheckSquare" /> Editar
                                    </a>
                                    <a class="text-danger" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal" href="#">
                                        <x-base.lucide icon="Trash" /> Borrar
                                    </a>
                                    <!-- New QR Button -->
                                    <a class="text-info" href="{{ route('eventAssistant.qr', ['id' => $asistente->id]) }}">
                                        <x-base.lucide icon="QrCode" /> Ver QR
                                    </a>
                                    <a class="text-info" href="{{ route('eventAssistant.pdf', ['id' => $asistente->id]) }}" target="_blank">
                                        <x-base.lucide icon="FileText" /> Generar PDF
                                    </a>
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
            {{ $asistentes->links() }}
        </div>
        <!-- END: Pagination -->
    </div>
@endsection
