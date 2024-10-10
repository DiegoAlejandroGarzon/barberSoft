@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Eventos</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Lista de Eventos</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <a href="{{ route('event.create') }}">
                <x-base.button
                    class="mr-2 shadow-md"
                    variant="primary"
                >
                    Crear nuevo Evento
                </x-base.button>
            </a>
            <x-base.menu>
                <x-base.menu.button
                    class="!box px-2"
                    as="x-base.button"
                >
                    <span class="flex h-5 w-5 items-center justify-center">
                        <x-base.lucide
                            class="h-4 w-4"
                            icon="Plus"
                        />
                    </span>
                </x-base.menu.button>
                <x-base.menu.items class="w-40">
                    <x-base.menu.item>
                        <x-base.lucide
                            class="mr-2 h-4 w-4"
                            icon="Printer"
                        /> Imprimir
                    </x-base.menu.item>
                    <x-base.menu.item>
                        <x-base.lucide
                            class="mr-2 h-4 w-4"
                            icon="FileText"
                        /> Exportar a Excel
                    </x-base.menu.item>
                    <x-base.menu.item>
                        <x-base.lucide
                            class="mr-2 h-4 w-4"
                            icon="FileText"
                        /> Exportar a PDF
                    </x-base.menu.item>
                </x-base.menu.items>
            </x-base.menu>

            <div class="mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto md:ml-0">
                <form action="{{ route('event.index') }}" method="GET">
                    <div class="relative w-56 text-slate-500">
                        <x-base.form-input
                            name="search"
                            class="!box w-56 pr-10"
                            type="text"
                            placeholder="Buscar..."
                            value="{{ request('search') }}"
                        />
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
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Acciones
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            Imagen
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            Nombre
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Descripción
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Fecha Evento
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Status
                        </x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach ($eventos as $evento)
                        <x-base.table.tr class="intro-x">

                            <x-base.table.td @class([
                                'box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
                                'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
                            ])>
                                <div class="flex items-center justify-center">

                                    <x-base.tippy content="Editar" class="mr-1">
                                        <a class="mr-3 flex items-center" href="{{ route('event.edit', ['id' => $evento->id]) }}">
                                            <x-base.lucide
                                                class="mx-auto block"
                                                icon="edit"
                                            />
                                        </a>
                                    </x-base.tippy>

                                    @if($evento->registration_parameters == "null" || $evento->registration_parameters == null|| $evento->registration_parameters == "[]")
                                    <x-base.tippy content="Registro Parametros (Sin Parametros)" class="mr-1">
                                            <a class="mr-3 flex items-center" href="{{ route('events.setRegistrationParameters',  $evento->id) }}">
                                                <x-base.alert class="flex items-center" variant="soft-pending">
                                                <x-base.lucide
                                                    class="mx-auto block"
                                                    icon="Book"
                                                />
                                                </x-base.alert>
                                            </a>
                                    </x-base.tippy>
                                    @else
                                    <x-base.tippy content="Registro Parametros" class="mr-1">
                                        <a class="mr-3 flex items-center" href="{{ route('events.setRegistrationParameters',  $evento->id) }}">
                                            <x-base.lucide
                                                class="mx-auto block"
                                                icon="Book"
                                            />
                                        </a>
                                    </x-base.tippy>
                                    @endif

                                    <x-base.tippy content="Generar codigos cortesía" class="mr-1">
                                        <a class="mr-3 flex items-center" href="{{ route('coupons.index',  $evento->id) }}">
                                            <x-base.lucide
                                                class="mx-auto block"
                                                icon="Tag"
                                            />
                                        </a>
                                    </x-base.tippy>
                                    @if ($evento->public_link)
                                        <x-base.tippy content="Ver enlace" class="mr-2">
                                            <a class="mr-3" href="{{ route('event.register', $evento->public_link) }}" target="_blank">
                                                <x-base.lucide
                                                    class="mx-auto block"
                                                    icon="ExternalLink"
                                                />
                                            </a>
                                        </x-base.tippy>
                                    @else
                                    <x-base.tippy content="Generar Enlace Público" class="mr-2">
                                        <form action="{{ route('event.generatePublicLink', $evento->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary ">
                                                <x-base.lucide
                                                class="mx-auto block"
                                                icon="Link"
                                            />
                                            </button>
                                        </form>
                                    </x-base.tippy>
                                    @endif

                                    <x-base.tippy content="Lista Asistentes" class="mr-1">
                                        <a class="mr-3 flex items-center" href="{{ route('eventAssistant.index', ['idEvent' => $evento->id]) }}">
                                            <x-base.lucide
                                                class="mx-auto block"
                                                icon="Users"
                                            />
                                        </a>
                                    </x-base.tippy>

                                    {{-- <x-base.tippy content="Mensaje Celular" class="mr-1">
                                        <a class="mr-3 flex items-center" href="{{ route('eventAssistant.sendMsg', ['idEvent' => $evento->id]) }}">
                                            <x-base.lucide
                                                class="mx-auto block"
                                                icon="MessageSquare"
                                            />
                                        </a>
                                    </x-base.tippy> --}}

                                </div>
                            </x-base.table.td>
                            <x-base.table.td
                                class="box w-40 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                <div class="flex">
                                    <div class="image-fit zoom-in h-10 w-10">
                                        @if($evento->header_image_path)
                                            <div class="image-fit zoom-in h-10 w-10">
                                                <x-base.tippy
                                                    class="rounded-full shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
                                                    src="{{ asset('storage/' . $evento->header_image_path) }}"
                                                    alt="{{ $evento->name }}"
                                                    as="img"
                                                    content="Evento Creado el {{ $evento->created_at }}"
                                                />
                                            </div>
                                        @else
                                            <!-- Imagen predeterminada si no hay imagen -->
                                            <div class="image-fit zoom-in h-10 w-10">
                                                <x-base.tippy
                                                    class="rounded-full shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
                                                    src="{{ asset('path/to/default/image.jpg') }}"
                                                    alt="Default Image"
                                                    as="img"
                                                    content="No image available"
                                                />
                                            </div>
                                        @endif
                                </div>
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $evento->name }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                                onclick="showDescriptionModal('{{ $evento->description }}')"
                                style="cursor: pointer;"
                            >
                                {{ Str::limit($evento->description, 30) }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $evento->event_date }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="
                                    box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600
                                    {{ $evento->status == 1 ? 'bg-gray-400 text-white' : '' }}
                                    {{ $evento->status == 2 ? 'bg-green-500 text-white' : '' }}
                                    {{ $evento->status == 3 ? 'bg-yellow-400 text-black' : '' }}
                                    {{ $evento->status == 4 ? 'bg-red-500 text-white' : '' }}
                                "
                            >
                                {{ array_search($evento->status, config('statusEvento')) }}
                            </x-base.table.td>
                        </x-base.table.tr>
                    @endforeach
                </x-base.table.tbody>
            </x-base.table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
            {{-- {{ $eventos->appends(['search' => request('search')])->links() }} <!-- Enlaces de paginación --> --}}

            {{ $eventos->withQueryString()->links() }}
        </div>
        <!-- Modal -->
        <div id="descriptionModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
            <div class="bg-white p-5 rounded-lg shadow-lg w-1/2">
                <h2 class="text-xl font-bold mb-4">Descripción Completa</h2>
                <p id="descriptionContent" class="mb-4"></p>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="closeModal()">Cerrar</button>
            </div>
        </div>
        <!-- END: Pagination -->
    </div>
    <script>
        function showDescriptionModal(description) {
            document.getElementById('descriptionContent').textContent = description;
            document.getElementById('descriptionModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('descriptionModal').classList.add('hidden');
        }
    </script>
@endsection
