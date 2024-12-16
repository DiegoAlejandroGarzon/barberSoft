@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Citas - Crear</title>
    <link rel="stylesheet" href="{{ url('css/blade.css') }}">
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Crear Cita</h2>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-12">
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
                        <x-base.form-label for="barbero_id">Barbero</x-base.form-label>
                        <x-base.tom-select
                            class="w-full"
                            id="barbero_id"
                            name="barbero_id"
                            onchange="cargarServiciosRelacionados()"
                        >
                            <option></option>
                            @foreach ($barberos as $barbero)
                                <option value="{{ $barbero->id }}" {{ old('barbero_id') == $barbero->id ? 'selected' : '' }}>{{ $barbero->user->name }}</option>
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
            const barberoId = document.getElementById('barbero_id').value;
            const serviciosSelect = document.querySelector('#servicios').tomselect;

            fetch(`/barberos/${barberoId}/servicios`)
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
