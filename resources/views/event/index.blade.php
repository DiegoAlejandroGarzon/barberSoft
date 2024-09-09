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
            <div class="text-center">
                <a data-tw-merge data-tw-toggle="modal" data-tw-target="#basic-slide-over-preview" href="#" class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed bg-primary border-primary text-white dark:border-primary">Escaner QR</a>
            </div>
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
                            Fecha Creación
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Status
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Acciones
                        </x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach ($eventos as $evento)
                        <x-base.table.tr class="intro-x">
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
                                                    content="Subido el {{ $evento->created_at }}"
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
                            >
                                {{ $evento->description }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ $evento->created_at->format('Y-m-d') }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                            >
                                {{ array_search($evento->status, config('statusEvento')) }}
                            </x-base.table.td>
                            <x-base.table.td @class([
                                'box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
                                'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
                            ])>
                                <div class="flex items-center justify-center">
                                    <a class="mr-3 flex items-center" href="{{ route('eventAssistant.index', ['idEvent' => $evento->id]) }}">
                                        <x-base.lucide
                                            class="mr-1 h-4 w-4"
                                            icon="file-text"
                                        />
                                        Asistentes
                                    </a>

                                    <a class="mr-3 flex items-center" href="{{ route('events.setRegistrationParameters',  $evento->id) }}">
                                        <x-base.lucide
                                            class="mr-1 h-4 w-4"
                                            variant="primary"
                                        />
                                        Registro Parametros
                                    </a>
                                    @if ($evento->public_link)
                                        <a href="{{ route('event.register', $evento->public_link) }}" target="_blank">Ver enlace</a>
                                    @else
                                        <form action="{{ route('event.generatePublicLink', $evento->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Generar Enlace Público</button>
                                        </form>
                                    @endif
                                    <a class="mr-3 flex items-center" href="{{ route('event.edit', ['id' => $evento->id]) }}">
                                        <x-base.lucide
                                            class="mr-1 h-4 w-4"
                                            icon="edit"
                                        />
                                        Editar
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
            {{-- {{ $eventos->appends(['search' => request('search')])->links() }} <!-- Enlaces de paginación --> --}}

            {{ $eventos->withQueryString()->links() }}
        </div>
        <!-- END: Pagination -->
    </div>
    <!-- Incluir la biblioteca de html5-qrcode -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>


    <!-- BEGIN: Slide Over QR -->
    <div data-tw-backdrop="" aria-hidden="true" tabindex="-1" id="basic-slide-over-preview" class="modal group bg-black/60 transition-[visibility,opacity] w-screen h-screen fixed left-0 top-0 [&amp;:not(.show)]:duration-[0s,0.2s] [&amp;:not(.show)]:delay-[0.2s,0s] [&amp;:not(.show)]:invisible [&amp;:not(.show)]:opacity-0 [&amp;.show]:visible [&amp;.show]:opacity-100 [&amp;.show]:duration-[0s,0.4s]">
        <div data-tw-merge class="w-[90%] ml-auto h-screen flex flex-col bg-white relative shadow-md transition-[margin-right] duration-[0.6s] -mr-[100%] group-[.show]:mr-0 dark:bg-darkmode-600 sm:w-[460px]">
            <div data-tw-merge class="flex items-center px-5 py-3 border-b border-slate-200/60 dark:border-darkmode-400 p-5">
                <h2 class="mr-auto text-base font-medium">
                    Escaner de Codigo QR
                </h2>
            </div>
            <div data-tw-merge class="p-5 overflow-y-auto flex-1">
                <div id="qr-reader" style="width: 300px;" class="border "></div>
                <div id="qr-reader-results" class="border "></div>
            </div>

        </div>
    </div>
    <!-- END: Slide Over QR -->
    <!-- Contenedor para el lector de QR -->
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Manejar el resultado escaneado aquí
            document.getElementById('qr-reader-results').innerText = `Codigo QR Detectado: ${decodedText}`;
        }

        function onScanError(errorMessage) {
            // Manejar el error de escaneo
            console.error(`Error al escanear codigo QR: ${errorMessage}`);
        }

        // Inicializa el lector de QR
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 10, qrbox: 250 }
        );

        // Comienza a escanear
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    </script>
@endsection
