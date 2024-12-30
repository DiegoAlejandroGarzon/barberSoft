@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Lista de Barberías</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Lista de Barberías</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <a href="{{ route('barberia.create') }}">
                <x-base.button
                    class="mr-2 shadow-md"
                    variant="primary"
                >
                    Crear nueva barbería
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
                <div class="relative w-56 text-slate-500">
                    <x-base.form-input
                        class="!box w-56 pr-10"
                        type="text"
                        placeholder="Buscar..."
                    />
                    <x-base.lucide
                        class="absolute inset-y-0 right-0 my-auto mr-3 h-4 w-4"
                        icon="Search"
                    />
                </div>
            </div>
        </div>

        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            ID
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Logo
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Nombre
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Ubicación
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Acciones
                        </x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach ($empresas as $barberia)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                {{ $barberia->id }}
                            </x-base.table.td>
                            <x-base.table.td class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600 text-center">
                                @if ($barberia->logo)
                                    <img src="{{ asset('storage/' . $barberia->logo) }}" alt="Logo de {{ $barberia->nombre }}" class="w-12 h-12 object-cover">
                                @else
                                    <span>No disponible</span>
                                @endif
                            </x-base.table.td>
                            <x-base.table.td class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                {{ $barberia->nombre }}
                            </x-base.table.td>
                            <x-base.table.td class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                {{ $barberia->ubicacion ?? 'No disponible' }}
                            </x-base.table.td>
                            <x-base.table.td @class([
                                'box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
                                'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before-h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
                            ])>
                                <div class="flex items-center justify-center">

                                    <x-base.tippy content="Formulario Citas publico" class="mr-2">
                                        <a href="{{ route('barberia.registerPublic', $barberia->guid) }}" target="_blank">
                                            <x-base.lucide
                                                class="mx-auto block"
                                                icon="ExternalLink"
                                            />
                                        </a>
                                    </x-base.tippy>
                                    <x-base.tippy content="Editar" class="mr-1">
                                        <a class="" href="{{ route('barberia.edit', ['id' => $barberia->id]) }}">
                                            <x-base.lucide icon="CheckSquare" />
                                        </a>
                                    </x-base.tippy>
                                    <x-base.tippy content="Borrar" class="mr-1">
                                        <a class="text-danger"
                                        data-tw-toggle="modal"
                                        data-tw-target="#delete-confirmation-modal"
                                        data-id="{{ $barberia->id }}"
                                        onclick="setDeleteAction(this)">
                                        <x-base.lucide icon="Trash" />
                                        </a>
                                    </x-base.tippy>

                                </div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @endforeach
                </x-base.table.tbody>
            </x-base.table>
        </div>
        <!-- END: Data List -->

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
    </div>
    <script>

        function setDeleteAction(element) {
            // Obtener el ID desde el atributo data-id
            const id = element.getAttribute('data-id');
            // Establecer la acción del formulario con la ruta dinámica
            const form = document.getElementById('delete-form');
            form.action = `/barberia/delete/${id}`;
        }
    </script>
@endsection
