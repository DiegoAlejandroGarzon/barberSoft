@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Lista de empleados</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Lista de empleados</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <a href="{{ route('empleado.create') }}">
                <x-base.button
                    class="mr-2 shadow-md"
                    variant="primary"
                >
                    Crear nuevo empleado
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
                        <x-base.table.th class="whitespace-nowrap border-b-0">ID</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Foto</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Nombre</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Email</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Servicios</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Acciones</x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach ($empleados as $empleado)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td>{{ $empleado->id }}</x-base.table.td>
                            <x-base.table.td class="text-center">
                                @if ($empleado->foto)
                                    <img src="{{ asset('storage/' . $empleado->foto) }}" alt="Foto de {{ $empleado->user->name }}" class="w-12 h-12 object-cover">
                                @else
                                    <span>No disponible</span>
                                @endif
                            </x-base.table.td>
                            <x-base.table.td class="text-center">{{ $empleado->user->name }} {{ $empleado->user->lastname }}</x-base.table.td>
                            <x-base.table.td class="text-center">{{ $empleado->user->email }}</x-base.table.td>
                            <x-base.table.td class="text-center">{{ $empleado->servicios->pluck('nombre')->implode(', ') }}</x-base.table.td>
                            <x-base.table.td class="text-center">
                                <div class="flex items-center justify-center">
                                    <x-base.tippy content="Editar">
                                        <a href="{{ route('empleado.edit', ['id' => $empleado->id]) }}">
                                            <x-base.lucide icon="CheckSquare" />
                                        </a>
                                    </x-base.tippy>
                                    <x-base.tippy content="Eliminar">
                                        <a class="text-danger"
                                           data-tw-toggle="modal"
                                           data-tw-target="#delete-confirmation-modal"
                                           data-id="{{ $empleado->id }}"
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

        <!-- Delete Confirmation Dialog -->
        <x-base.dialog id="delete-confirmation-modal">
            <x-base.dialog.panel>
                <div class="p-5 text-center">
                    <x-base.lucide
                        class="mx-auto mt-3 h-16 w-16 text-danger"
                        icon="XCircle"
                    />
                    <div class="mt-5 text-3xl">¿Está seguro?</div>
                    <div class="mt-2 text-slate-500">
                        ¿Realmente desea eliminar este empleado? <br />
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
                        Cancelar
                    </x-base.button>
                    <form id="delete-form" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <x-base.button
                            class="w-24"
                            type="submit"
                            variant="danger"
                        >
                            Eliminar
                        </x-base.button>
                    </form>
                </div>
            </x-base.dialog.panel>
        </x-base.dialog>
    </div>
    <script>
        function setDeleteAction(element) {
            const id = element.getAttribute('data-id');
            const form = document.getElementById('delete-form');
            form.action = `/empleado/delete/${id}`;
        }
    </script>
@endsection
