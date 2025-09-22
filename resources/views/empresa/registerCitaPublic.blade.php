@extends('../themes/base')

@section('head')
    <title>AgendaPlus</title>
@endsection

@section('content')

@if($empresa->color_one !== null)
<style>
    body {
        overflow-x: hidden; /* Evita el desbordamiento horizontal */
    }
    .bg-color-one {
        --tw-bg-opacity: 1;
        background-color: {{$empresa->color_one}};
    }
    .bg-color-two {
        --tw-bg-opacity: 1;
        background-color: {{$empresa->color_two}};
    }
    .before\:bg-color-two\/20::before{
        --tw-bg-opacity: 1;
        background-color: {{$empresa->color_two}};
    }
    .after\:bg-color-one::after {
        --tw-bg-opacity: 1;
        background-color: {{$empresa->color_one}};
    }
    @media (max-width: 1280px) {
        .lg\:overflow-hidden {
            overflow: hidden;
            background-color: {{$empresa->color_one}}; /* Aplica bg-color-one a pantallas mayores de 640px */
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
                        @if ($empresa->logo)
                        <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo de {{ $empresa->nombre }}" class="object-cover" style="width: 50%; height: auto;" >
                        @else
                        <img class="-intro-x -mt-16 w-1/2" src="{{ Vite::asset('resources/images/illustration.svg') }}" alt="" />
                        @endif
                        <div class="-intro-x mt-10 text-4xl font-medium leading-tight text-white">
                            {{ $empresa->nombre }}
                        </div>
                        <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">
                            {{ $empresa->ubicacion }}
                        </div>
                    </div>
                </div>
                <!-- END: Event Info -->

                <!-- BEGIN: Registration Form -->
                <div class="my-10 flex h-screen py-5 xl:my-0 xl:h-auto xl:py-0">
                    <div class="mx-auto my-auto w-full rounded-md bg-white px-5 py-8 shadow-md dark:bg-darkmode-600 sm:w-3/4 sm:px-8 lg:w-2/4 xl:ml-20 xl:w-auto xl:bg-transparent xl:p-0 xl:shadow-none">
                        <h2 class="intro-x text-center text-2xl font-bold xl:text-left xl:text-3xl">
                            Agenda tu cita de: {{ $empresa->nombre }}
                        </h2>
                        <div class="block xl:hidden">
                            @if ($empresa->logo)
                            <img class="" src="{{ asset('storage/' . $empresa->logo) }}" alt="Imagen del evento" />
                            @else
                            <img class="-intro-x -mt-16 w-1/2" src="{{ Vite::asset('resources/images/illustration.svg') }}" alt="" />
                            @endif
                        </div>
                        <p class="intro-x mt-2 text-center text-slate-400 xl:hidden">
                            {{ $empresa->description }}
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

                                <!-- Paso 1: Servicios -->
                                <div id="step-1" class="step">
                                    <h3 class="text-xl font-bold mb-4">Selecciona tus servicios</h3>
                                    <div class="grid grid-cols-2 gap-4">
                                        @foreach ($servicios as $servicio)
                                            <div class="p-4 border rounded-lg cursor-pointer hover:bg-slate-100"
                                                onclick="toggleService({{ $servicio->id }}, this)">
                                                <h4 class="font-semibold">{{ $servicio->nombre }}</h4>
                                                <p class="text-sm text-gray-500">${{ $servicio->precio }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="servicios" id="servicios-seleccionados">

                                    <x-base.button
                                        type="button"
                                        class="mb-2 mr-1 w-24 mt-2 bg-color-one"
                                        variant="primary"
                                        rounded
                                        onclick="nextStep(2)"
                                    >
                                        Siguiente
                                    </x-base.button>
                                </div>

                                <!-- Paso 2: Empleado -->
                                <div id="step-2" class="step hidden">
                                    <h3 class="text-xl font-bold mb-4">Selecciona un empleado</h3>
                                    <select name="empleado_id" class="w-full border p-2 rounded">
                                        <option></option>
                                        @foreach ($empleados as $empleado)
                                            <option value="{{ $empleado->id }}">{{ $empleado->user->name }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <button type="button" onclick="prevStep(1)" class="btn btn-secondary mt-4">Atrás</button>
                                    <button type="button" onclick="nextStep(3)" class="btn btn-primary mt-4">Siguiente</button> --}}
                                    <x-base.button
                                        type="button"
                                        class="mb-2 mr-1 w-24 mt-2 bg-color-one"
                                        variant="primary"
                                        rounded
                                        onclick="nextStep(1)"
                                    >
                                        Atrás
                                    </x-base.button>
                                    <x-base.button
                                        type="button"
                                        class="mb-2 mr-1 w-24 mt-2 bg-color-one"
                                        variant="primary"
                                        rounded
                                        onclick="nextStep(3)"
                                    >
                                        Siguiente
                                    </x-base.button>
                                </div>

                                <!-- Paso 3: Fecha y hora -->
                                <div id="step-3" class="step hidden">
                                    <h3 class="text-xl font-bold mb-4">Selecciona fecha y hora</h3>

                                    <input type="date" id="fecha" name="fecha" class="w-full border p-2 rounded mb-3" required
                                        onchange="cargarHorariosDisponibles()">

                                    <select id="hora" name="hora" class="w-full border p-2 rounded" required>
                                        <option value="">Selecciona una hora</option>
                                    </select>

                                    {{-- <button type="button" onclick="prevStep(2)" class="btn btn-secondary mt-4">Atrás</button>
                                    <button type="button" onclick="nextStep(4)" class="btn btn-primary mt-4">Siguiente</button> --}}
                                    <x-base.button
                                        type="button"
                                        class="mb-2 mr-1 w-24 mt-2 bg-color-one"
                                        variant="primary"
                                        rounded
                                        onclick="nextStep(2)"
                                    >
                                        Atrás
                                    </x-base.button>
                                    <x-base.button
                                        type="button"
                                        class="mb-2 mr-1 w-24 mt-2 bg-color-one"
                                        variant="primary"
                                        rounded
                                        onclick="nextStep(4)"
                                    >
                                        Siguiente
                                    </x-base.button>
                                </div>

                                <!-- Paso 4: Datos del cliente -->
                                <div id="step-4" class="step hidden">
                                    <h3 class="text-xl font-bold mb-4">Tus datos</h3>
                                    <input type="text" name="nombres" placeholder="Nombre completo"
                                        class="w-full border p-2 rounded mb-3" required>
                                    <input type="tel" name="telefono" placeholder="Número de celular"
                                        class="w-full border p-2 rounded mb-3" required>

                                    {{-- <button type="button" onclick="prevStep(3)" class="btn btn-secondary mt-4">Atrás</button>
                                    <button type="submit" class="btn btn-success mt-4">Confirmar cita</button> --}}
                                    <x-base.button
                                        type="button"
                                        class="mb-2 mr-1 w-24 mt-2 bg-color-one"
                                        variant="primary"
                                        rounded
                                        onclick="nextStep(3)"
                                    >
                                        Atrás
                                    </x-base.button>
                                    <x-base.button
                                        type="submit"
                                        class="mb-2 mr-1 mt-2 bg-color-one"
                                        variant="primary"
                                        rounded
                                    >
                                        Confirmar cita
                                    </x-base.button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        function nextStep(step) {
            // ocultar todos
            document.querySelectorAll('.step').forEach(s => {
                s.classList.add('hidden');
                s.querySelectorAll('[required]').forEach(input => input.removeAttribute('required'));
            });

            // mostrar actual
            const currentStep = document.getElementById(`step-${step}`);
            currentStep.classList.remove('hidden');
            currentStep.querySelectorAll('input, select, textarea').forEach(input => {
                if (input.hasAttribute('data-required')) {
                    input.setAttribute('required', 'required');
                }
            });
        }

        let selectedServices = [];
        function toggleService(id, element) {
            if (selectedServices.includes(id)) {
                // Quitar de la lista
                selectedServices = selectedServices.filter(s => s !== id);
                element.classList.remove('bg-green-200', 'border-green-500');
            } else {
                // Agregar a la lista
                selectedServices.push(id);
                element.classList.add('bg-green-200', 'border-green-500');
            }

            // Actualizar hidden input
            document.getElementById('servicios-seleccionados').value = selectedServices.join(',');
        }

        function nextStep(step) {
            document.querySelectorAll('.step').forEach(s => s.classList.add('hidden'));
            document.getElementById('step-' + step).classList.remove('hidden');
        }

        function prevStep(step) {
            nextStep(step);
        }
    </script>
    <script>
    function cargarHorariosDisponibles() {
        let fecha = document.getElementById('fecha').value;
        let empleadoId = document.querySelector('[name="empleado_id"]').value;
        let horaSelect = document.getElementById('hora');

        if (!fecha || !empleadoId) return;

        fetch(`/empleados/${empleadoId}/horarios?fecha=${fecha}`)
            .then(res => res.json())
            .then(data => {
                horaSelect.innerHTML = '<option value="">Selecciona una hora</option>';
                data.forEach(h => {
                    let option = document.createElement('option');
                    option.value = h;
                    option.textContent = h;
                    horaSelect.appendChild(option);
                });
            })
            .catch(err => console.error('Error cargando horarios:', err));
    }
    </script>
    {{-- <script>
        // Mostrar campos extra solo si no existe el contacto en DB
        document.getElementById('contacto').addEventListener('blur', function () {
            let valor = this.value.trim();
            if (valor) {
                fetch(`/validar-cliente?contacto=${valor}`)
                    .then(res => res.json())
                    .then(data => {
                        if (!data.existe) {
                            document.getElementById('extra-info').classList.remove('hidden');
                        } else {
                            document.getElementById('extra-info').classList.add('hidden');
                        }
                    });
            }
        });
    </script>
    <script>

        let timeoutId;

        function cargarServiciosRelacionados() {
            const empleadoId = document.getElementById('empleado_id').value;
            const serviciosSelect = document.querySelector('#servicios').tomselect;

            // **Reiniciar completamente el select de servicios**
            serviciosSelect.clear(); // Limpia la selección actual
            serviciosSelect.clearOptions(); // Elimina todas las opciones disponibles

            if (!empleadoId) return; // Si no hay empleado seleccionado, no hacer nada

            fetch(`/empleados/${empleadoId}/servicios`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        data.servicios.forEach(servicio => {
                            serviciosSelect.addOption({
                                value: servicio.id,
                                text: servicio.nombre
                            });
                        });

                        // **Refrescar opciones y permitir selección**
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
    </script> --}}
@endsection
