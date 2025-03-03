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
                            AgendaPlus
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
                            Cita agendada de: {{ $empresa->nombre }}
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
                        <br>
                        <div class="intro-y box p-5">
                            <h3 class="text-xl font-semibold text-center mb-4">Detalles de la Cita</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                @php
                                    $fecha = \Carbon\Carbon::parse($cita->fecha_hora)->format('d/m/Y');
                                    $hora = \Carbon\Carbon::parse($cita->fecha_hora)->format('h:i A');
                                @endphp

                                <div class="p-4 border rounded-lg shadow-md">
                                    <h4 class="font-bold text-lg">Detalles de la Cita</h4>
                                    <p><strong>Dirección:</strong> {{ $empresa->ubicacion }}</p>
                                    <p><strong>Fecha:</strong> {{ $fecha }}</p>
                                    <p><strong>Hora:</strong> {{ $hora }}</p>
                                    <p><strong>Estado:</strong> {{ $cita->estado }}</p>

                                    <h4 class="mt-3 font-bold text-lg">Servicios</h4>
                                    <ul class="">
                                        @forelse ($cita->servicios as $servicio)
                                            <li>{{ $servicio->nombre }} - ${{ number_format($servicio->precio, 0, '', '.') }}</li>
                                        @empty
                                            <li>No hay servicios asignados</li>
                                        @endforelse
                                    </ul>
                                </div>

                                <!-- Información del Cliente -->
                                <div class="p-4 border rounded-lg shadow-md">
                                    <h4 class="font-bold text-lg">Datos del Cliente</h4>
                                    <p><strong>Nombre:</strong> {{ $cliente->nombres }} {{ $cliente->apellidos }}</p>
                                    <p><strong>Email:</strong> {{ $cliente->correo }}</p>
                                    <p><strong>Teléfono:</strong> {{ $cliente->telefono }}</p>
                                </div>

                                <!-- Información del empleado -->
                                <div class="p-4 border rounded-lg shadow-md">
                                    <h4 class="font-bold text-lg mb-2">Datos del Empleado</h4>
                                        <!-- Imagen del empleado -->
                                    @if ($empleado->foto)
                                        <img src="{{ asset('storage/' . $empleado->foto) }}" alt="Foto de {{ $empleado->user->name }}" class="w-24 h-24 object-cover rounded-full mx-auto mb-3 shadow-md">
                                    @else
                                        <img src="{{ asset('images/default-avatar.png') }}" alt="Foto por defecto" class="w-24 h-24 object-cover rounded-full mx-auto mb-3 shadow-md">
                                    @endif
                                    <p><strong>Nombre:</strong> {{ $empleado->user->name }} {{ $empleado->user->lastname }}</p>
                                </div>

                                <!-- Código QR -->
                                <div class="p-4 border rounded-lg shadow-md text-center">
                                    <h4 class="font-bold text-lg">Escanea para acceder</h4>
                                    <div class="flex justify-center">
                                        {!! $qrCode !!}
                                    </div>
                                    <p class="mt-2 text-sm text-gray-600">Escanea este código QR para abrir esta página en otro dispositivo.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Registration Form -->
            </div>
        </div>
    </div>
@endsection
