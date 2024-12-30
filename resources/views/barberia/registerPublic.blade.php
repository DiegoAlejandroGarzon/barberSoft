@extends('../themes/base')

@section('head')
    <title>BarBerSoft</title>
@endsection

@section('content')

@if($barberia->color_one !== null)
<style>
    body {
        overflow-x: hidden; /* Evita el desbordamiento horizontal */
    }
    .bg-color-one {
        --tw-bg-opacity: 1;
        background-color: {{$barberia->color_one}};
    }
    .bg-color-two {
        --tw-bg-opacity: 1;
        background-color: {{$barberia->color_two}};
    }
    .before\:bg-color-two\/20::before{
        --tw-bg-opacity: 1;
        background-color: {{$barberia->color_two}};
    }
    .after\:bg-color-one::after {
        --tw-bg-opacity: 1;
        background-color: {{$barberia->color_one}};
    }
    @media (max-width: 1280px) {
        .lg\:overflow-hidden {
            overflow: hidden;
            background-color: {{$barberia->color_one}}; /* Aplica bg-color-one a pantallas mayores de 640px */
        }
    }
</style>
<div @class([
    'p-3 sm:px-8 relative h-screen lg:overflow-hidden bg-primary xl:bg-white dark:bg-darkmode-800 xl:dark:bg-darkmode-600',
    'before:hidden before:xl:block before:content-[\'\'] before:w-[57%] before:-mt-[28%] before:-mb-[16%] before:-ml-[13%] before:absolute before:inset-y-0 before:left-0 before:transform before:rotate-[-4.5deg] before:bg-color-two/20 before:rounded-[100%] before:dark:bg-darkmode-400',
    'after:hidden after:xl:block after:content-[\'\'] after:w-[57%] after:-mt-[20%] after:-mb-[13%] after:-ml-[13%] after:absolute after:inset-y-0 after:left-0 after:transform before:rotate-[-4.5deg] after:bg-color-one after:rounded-[100%] after:dark:bg-darkmode-700',
])>
@else
<div @class([
    'p-3 sm:px-8 relative h-screen lg:overflow-hidden bg-primary xl:bg-white dark:bg-darkmode-800 xl:dark:bg-darkmode-600',
    'before:hidden before:xl:block before:content-[\'\'] before:w-[57%] before:-mt-[28%] before:-mb-[16%] before:-ml-[13%] before:absolute before:inset-y-0 before:left-0 before:transform before:rotate-[-4.5deg] before:bg-primary/20 before:rounded-[100%] before:dark:bg-darkmode-400',
    'after:hidden after:xl:block after:content-[\'\'] after:w-[57%] after:-mt-[20%] after:-mb-[13%] after:-ml-[13%] after:absolute after:inset-y-0 after:left-0 after:transform before:rotate-[-4.5deg] after:bg-primary after:rounded-[100%] after:dark:bg-darkmode-700',
])>
@endif
        <div class="container relative z-10 sm:px-10">
            <div class="block grid-cols-2 gap-4 xl:grid">
                <!-- BEGIN: Event Info -->
                <div class="hidden min-h-screen flex-col xl:flex">
                    {{-- <span class="ml-3 text-lg text-white"> tuBoleta </span> --}}
                    <div class="my-auto">
                        @if ($barberia->logo)
                        <img src="{{ asset('storage/' . $barberia->logo) }}" alt="Logo de {{ $barberia->nombre }}" class="object-cover" style="width: 50%; height: auto;" >
                        @else
                        <img class="-intro-x -mt-16 w-1/2" src="{{ Vite::asset('resources/images/illustration.svg') }}" alt="" />
                        @endif
                        <div class="-intro-x mt-10 text-4xl font-medium leading-tight text-white">
                            BarberSoft
                        </div>
                        <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">
                            Registrar Citas y llevar su gestión
                        </div>
                    </div>
                </div>
                <!-- END: Event Info -->

                <!-- BEGIN: Registration Form -->
                <div class="my-10 flex h-screen py-5 xl:my-0 xl:h-auto xl:py-0">
                    <div class="mx-auto my-auto w-full rounded-md bg-white px-5 py-8 shadow-md dark:bg-darkmode-600 sm:w-3/4 sm:px-8 lg:w-2/4 xl:ml-20 xl:w-auto xl:bg-transparent xl:p-0 xl:shadow-none">
                        <h2 class="intro-x text-center text-2xl font-bold xl:text-left xl:text-3xl">
                            Agenda tu cita de: {{ $barberia->nombre }}
                        </h2>
                        <div class="block xl:hidden">
                            @if ($barberia->logo)
                            <img class="" src="{{ asset('storage/' . $barberia->logo) }}" alt="Imagen del evento" />
                            @else
                            <img class="-intro-x -mt-16 w-1/2" src="{{ Vite::asset('resources/images/illustration.svg') }}" alt="" />
                            @endif
                        </div>
                        <p class="intro-x mt-2 text-center text-slate-400 xl:hidden">
                            {{ $barberia->description }}
                        </p>
                        @if (session('success'))
                            <div class="intro-x mt-4 alert alert-success text-green-500">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="intro-x mt-4 alert alert-danger text-red-500">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="intro-y box p-5">
                            <form method="POST" action="{{ route('citas.store') }}">
                                @csrf

                                <!-- Cliente -->
                                <div class="mt-3">
                                    <x-base.form-label for="tipo_documento">Tipo de Documento</x-base.form-label>
                                    <x-base.tom-select
                                        class="w-full"
                                        id="tipo_documento"
                                        name="tipo_documento"
                                        onchange="detectarCambioInputs()"
                                    >
                                        <option value="CC" {{ old('tipo_documento') == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                        <option value="TI" {{ old('tipo_documento') == 'TI' ? 'selected' : '' }}>Tarjeta de Identidad</option>
                                    </x-base.tom-select>

                                    <x-base.form-label for="numero_documento" class="mt-3">Número de Documento</x-base.form-label>
                                    <x-base.form-input
                                        id="numero_documento"
                                        name="numero_documento"
                                        type="text"
                                        value="{{ old('numero_documento') }}"
                                        oninput="detectarCambioInputs()"
                                    />

                                    <div id="cliente-info" class="mt-5">
                                        <x-base.form-label for="nombres">Nombres</x-base.form-label>
                                        <x-base.form-input id="nombres" name="nombres" type="text" />

                                        <x-base.form-label for="apellidos" class="mt-3">Apellidos</x-base.form-label>
                                        <x-base.form-input id="apellidos" name="apellidos" type="text" />

                                        <x-base.form-label for="telefono" class="mt-3">Teléfono</x-base.form-label>
                                        <x-base.form-input id="telefono" name="telefono" type="text" />

                                        <x-base.form-label for="correo" class="mt-3">Correo</x-base.form-label>
                                        <x-base.form-input id="correo" name="correo" type="email" />
                                    </div>
                                </div>

                                <!-- Barbero -->
                                <div class="mt-3">
                                    <x-base.form-label for="empleado_id">Barbero</x-base.form-label>
                                    <x-base.tom-select
                                        class="w-full"
                                        id="empleado_id"
                                        name="empleado_id"
                                        onchange="cargarServiciosRelacionados()"
                                    >
                                        <option></option>
                                        @foreach ($empleados as $barbero)
                                            <option value="{{ $barbero->id }}" {{ old('empleado_id') == $barbero->id ? 'selected' : '' }}>{{ $barbero->user->name }}</option>
                                        @endforeach
                                    </x-base.tom-select>
                                </div>

                                <!-- Servicios -->
                                <div class="mt-3">
                                    <x-base.form-label for="servicios">Servicios</x-base.form-label>
                                    <x-base.tom-select
                                        class="w-full"
                                        id="servicios"
                                        name="servicios[]"
                                        multiple
                                    ></x-base.tom-select>
                                </div>

                                <!-- Fecha y Hora -->
                                <div class="mt-3">
                                    <x-base.form-label for="fecha_hora">Fecha y Hora</x-base.form-label>
                                    <x-base.form-input
                                        id="fecha_hora"
                                        name="fecha_hora"
                                        type="datetime-local"
                                        value="{{ old('fecha_hora') }}"
                                        step="1800"
                                        oninput="roundToHalfHour(this)"
                                    />
                                    @error('fecha_hora')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Botones -->
                                <div class="mt-5 text-right">
                                    <x-base.button
                                        class="mr-1 w-24"
                                        type="button"
                                        variant="outline-secondary"
                                        onclick="window.location='{{ url()->previous() }}'"
                                    >
                                        Cancelar
                                    </x-base.button>
                                    <x-base.button
                                        class="w-24"
                                        type="submit"
                                        variant="primary"
                                    >
                                        Guardar
                                    </x-base.button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END: Registration Form -->
            </div>
        </div>
    </div>
    <script>

        let timeoutId;

        function detectarCambioInputs() {
            clearTimeout(timeoutId);

            const tipoDocumento = document.getElementById('tipo_documento').value;
            const numeroDocumento = document.getElementById('numero_documento').value;

            if (tipoDocumento && numeroDocumento) {
                timeoutId = setTimeout(() => {
                    buscarCliente(tipoDocumento, numeroDocumento);
                }, 500); // Esperar 500ms antes de buscar
            }
        }

        function buscarCliente(tipoDocumento, numeroDocumento) {
            fetch(`/clientes/buscar?tipo_documento=${tipoDocumento}&numero_documento=${numeroDocumento}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('nombres').value = data.cliente.nombres;
                        document.getElementById('apellidos').value = data.cliente.apellidos;
                        document.getElementById('telefono').value = data.cliente.telefono;
                        document.getElementById('correo').value = data.cliente.correo;
                    } else {
                        document.getElementById('nombres').value = '';
                        document.getElementById('apellidos').value = '';
                        document.getElementById('telefono').value = '';
                        document.getElementById('correo').value = '';
                    }
                });
        }

        function cargarServiciosRelacionados() {
            const barberoId = document.getElementById('empleado_id').value;
            const serviciosSelect = document.querySelector('#servicios').tomselect;

            fetch(`/empleados/${barberoId}/servicios`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Limpia todas las opciones actuales
                        serviciosSelect.clearOptions();

                        // Agrega nuevas opciones dinámicamente
                        data.servicios.forEach(servicio => {
                            serviciosSelect.addOption({
                                value: servicio.id,
                                text: servicio.nombre
                            });
                        });

                        // Refresca la lista de opciones para que se muestren correctamente en la interfaz
                        serviciosSelect.refreshOptions(false);
                    } else {
                        alert('No se pudieron cargar los servicios relacionados');
                    }
                })
                .catch(error => {
                    console.error('Error al cargar servicios relacionados:', error);
                });
        }

        function roundToHalfHour(input) {
            const date = new Date(input.value);

            // Obtener los minutos actuales
            let minutes = date.getMinutes();

            // Redondear a la media hora más cercana
            minutes = Math.round(minutes / 60) * 60;
            date.setMinutes(minutes);

            // Ajustar la fecha a la hora local (sin cambio a UTC)
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Mes con 2 dígitos
            const day = String(date.getDate()).padStart(2, '0'); // Día con 2 dígitos
            const hour = String(date.getHours()).padStart(2, '0'); // Hora con 2 dígitos
            const minute = String(date.getMinutes()).padStart(2, '0'); // Minutos con 2 dígitos

            // Crear el formato correcto para datetime-local
            const formattedDate = `${year}-${month}-${day}T${hour}:${minute}`;

            // Establecer el valor redondeado en el input
            input.value = formattedDate;
        }
    </script>
@endsection
