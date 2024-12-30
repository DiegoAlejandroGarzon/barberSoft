@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Lista de Citas</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Lista de Citas</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <a href="{{ route('citas.create') }}">
                <x-base.button
                    class="mr-2 shadow-md"
                    variant="primary"
                >
                    Crear Nueva Cita
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
                <form method="GET" action="{{ route('citas.index') }}" class="relative w-56 text-slate-500">
                    <x-base.form-input name="search" value="{{ request('search') }}" class="!box w-56 pr-10" type="text" placeholder="Buscar..." />
                    <button type="submit" class="absolute inset-y-0 right-0 my-auto mr-3 h-4 w-4">
                        <x-base.lucide icon="Search" />
                    </button>
                </form>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="whitespace-nowrap border-b-0">ID</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Cliente</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">empleado</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Fecha y Hora</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Estado</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">Acciones</x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach ($citas as $cita)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td class="text-center">{{ $cita->id }}</x-base.table.td>
                            <x-base.table.td class="text-center">{{ $cita->cliente->nombres }}</x-base.table.td>
                            <x-base.table.td class="text-center">{{ $cita->empleado->user->name }}</x-base.table.td>
                            <x-base.table.td class="text-center">{{ $cita->fecha_hora }}</x-base.table.td>
                            <x-base.table.td class="text-center">{{ $cita->estado }}</x-base.table.td>
                            <x-base.table.td class="flex items-center justify-center">
                                <a class="mr-3 flex items-center" href="{{ route('citas.edit', $cita->id) }}">
                                    Editar
                                </a>
                                <a class="flex items-center text-danger" href="{{ route('citas.delete', $cita->id) }}">
                                    <x-base.lucide class="mr-1 h-4 w-4" icon="Trash" /> Borrar
                                </a>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @endforeach
                    {{-- {{ $citas->links() }} --}}
                </x-base.table.tbody>
            </x-base.table>
        </div>
        <!-- END: Data List -->
    </div>
@endsection
