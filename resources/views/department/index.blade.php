@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Departamento</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Lista de Departamentos</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <a href="{{ route('department.create') }}">
                <x-base.button
                    class="mr-2 shadow-md"
                    variant="primary"
                >
                    Crear nuevo departamento
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
                        /> Exportar a
                        Excel
                    </x-base.menu.item>
                    <x-base.menu.item>
                        <x-base.lucide
                            class="mr-2 h-4 w-4"
                            icon="FileText"
                        /> Exportar a
                        PDF
                    </x-base.menu.item>
                </x-base.menu.items>
            </x-base.menu>
            {{-- <div class="mx-auto hidden text-slate-500 md:block">
                Showing {1} to {10} of {150} entries
            </div> --}}
            <div class="mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto md:ml-0">
                <div class="relative w-56 text-slate-500">
                    <form method="GET" action="{{ route('department.index') }}" class="relative w-56 text-slate-500">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="!box w-56 pr-10"
                            placeholder="Buscar..."
                        />
                        <button type="submit" class="absolute inset-y-0 right-0 my-auto mr-3">
                            <x-base.lucide class="h-4 w-4" icon="Search" />
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            N
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                           Codigo Dane
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                           Departamento
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Acciones
                        </x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach ($departments as $index => $department)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td>
                                {{ $departments->firstItem() + $loop->index }} <!-- Ajustar numeración en paginación -->
                            </x-base.table.td>
                            <x-base.table.td>
                                {{ $department->code_dane }}
                            </x-base.table.td>
                            <x-base.table.td>
                                {{ $department->name }}
                            </x-base.table.td>
                            <x-base.table.td>
                                <div class="flex items-center justify-center">
                                    <a class="mr-3 flex items-center" href="{{ route('department.edit', ['id' => $department->id]) }}">
                                        Editar
                                    </a>
                                    <a class="flex items-center text-danger cursor-pointer" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="Trash" /> Borrar
                                    </a>
                                </div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @endforeach
                    <!-- Agregar la paginación -->
                    <div class="mt-4">
                        {{ $departments->links() }}
                    </div>
                </x-base.table.tbody>
            </x-base.table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        {{-- <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
            <x-base.pagination class="w-full sm:mr-auto sm:w-auto">
                <x-base.pagination.link>
                    <x-base.lucide
                        class="h-4 w-4"
                        icon="ChevronsLeft"
                    />
                </x-base.pagination.link>
                <x-base.pagination.link>
                    <x-base.lucide
                        class="h-4 w-4"
                        icon="ChevronLeft"
                    />
                </x-base.pagination.link>
                <x-base.pagination.link>...</x-base.pagination.link>
                <x-base.pagination.link>1</x-base.pagination.link>
                <x-base.pagination.link active>2</x-base.pagination.link>
                <x-base.pagination.link>3</x-base.pagination.link>
                <x-base.pagination.link>...</x-base.pagination.link>
                <x-base.pagination.link>
                    <x-base.lucide
                        class="h-4 w-4"
                        icon="ChevronRight"
                    />
                </x-base.pagination.link>
                <x-base.pagination.link>
                    <x-base.lucide
                        class="h-4 w-4"
                        icon="ChevronsRight"
                    />
                </x-base.pagination.link>
            </x-base.pagination>
            <x-base.form-select class="!box mt-3 w-20 sm:mt-0">
                <option>10</option>
                <option>25</option>
                <option>35</option>
                <option>50</option>
            </x-base.form-select>
        </div> --}}
        <!-- END: Pagination -->
    </div>
    <!-- BEGIN: Delete Confirmation Modal -->
    <x-base.dialog id="delete-confirmation-modal">
        <x-base.dialog.panel>
            <div class="p-5 text-center">
                <x-base.lucide
                    class="mx-auto mt-3 h-16 w-16 text-danger"
                    icon="XCircle"
                />
                <div class="mt-5 text-3xl">¿Estas Seguro?</div>
                <div class="mt-2 text-slate-500">
                    ¿Está seguro de que desea eliminar este registro? <br/>
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

                <a
                    href="{{ route('department.delete', ['id' => $department->id]) }}"
                    {{-- class="w-24 bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 text-center" --}}
                >
                <x-base.button
                    class="w-24"
                    type="button"
                    variant="danger"
                    href="{{ route('department.delete', ['id' => $department->id]) }}"
                >
                    Borrar
                </x-base.button>
                </a>
            </div>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Delete Confirmation Modal -->
@endsection
