@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Citas - Editar</title>
    <link rel="stylesheet" href="{{ url('css/blade.css') }}">
@endsection

@section('subcontent')
    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Editar Cita</h2>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="intro-y box p-5">
                <form method="POST" action="{{ route('citas.update', $cita->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Cliente -->
                    <div class="mt-3">
                        <x-base.form-label for="tipo_documento">Tipo de Documento</x-base.form-label>
                        <x-base.tom-select
                            class="w-full"
                            id="tipo_documento"
                            name="tipo_documento"
                            onchange="detectarCambioInputs()"
                        >
                            <option value="CC" {{ old('tipo_documento', $cita->tipo_documento) == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                            <option value="TI" {{ old('tipo_documento', $cita->tipo_documento) == 'TI' ? 'selected' : '' }}>Tarjeta de Identidad</option>
                        </x-base.tom-select>

                        <x-base.form-label for="numero_documento" class="mt-3">Número de Documento</x-base.form-label>
                        <x-base.form-input
                            id="numero_documento"
                            name="numero_documento"
                            type="text"
                            value="{{ old('numero_documento', $cita->cliente->numero_documento) }}"
                            oninput="detectarCambioInputs()"
                        />

                        <div id="cliente-info" class="mt-5">
                            <x-base.form-label for="nombres">Nombres</x-base.form-label>
                            <x-base.form-input id="nombres" name="nombres" type="text" value="{{ old('nombres', $cita->cliente->nombres) }}" />

                            <x-base.form-label for="apellidos" class="mt-3">Apellidos</x-base.form-label>
                            <x-base.form-input id="apellidos" name="apellidos" type="text" value="{{ old('apellidos', $cita->cliente->apellidos) }}" />

                            <x-base.form-label for="telefono" class="mt-3">Teléfono</x-base.form-label>
                            <x-base.form-input id="telefono" name="telefono" type="text" value="{{ old('telefono', $cita->cliente->telefono) }}" />

                            <x-base.form-label for="correo" class="mt-3">Correo</x-base.form-label>
                            <x-base.form-input id="correo" name="correo" type="email" value="{{ old('correo', $cita->cliente->correo) }}" />
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
                                <option value="{{ $barbero->id }}" {{ old('empleado_id', $cita->empleado_id) == $barbero->id ? 'selected' : '' }}>
                                    {{ $barbero->user->name }}
                                </option>
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
                        >
                            @foreach ($servicios as $servicio)
                                <option value="{{ $servicio->id }}"
                                    {{ in_array($servicio->id, old('servicios', $cita->servicios->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $servicio->nombre }}
                                </option>
                            @endforeach
                        </x-base.tom-select>
                    </div>

                    <!-- Fecha y Hora -->
                    <div class="mt-3">
                        <x-base.form-label for="fecha_hora">Fecha y Hora</x-base.form-label>
                        <x-base.form-input
                            id="fecha_hora"
                            name="fecha_hora"
                            type="datetime-local"
                            value="{{ old('fecha_hora', $cita->fecha_hora) }}"
                        />
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
                            Actualizar
                        </x-base.button>
                    </div>
                </form>
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
                }, 500);
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
                        serviciosSelect.clearOptions();
                        data.servicios.forEach(servicio => {
                            serviciosSelect.addOption({
                                value: servicio.id,
                                text: servicio.nombre
                            });
                        });
                        serviciosSelect.refreshOptions(false);
                    }
                });
        }
    </script>
@endsection
