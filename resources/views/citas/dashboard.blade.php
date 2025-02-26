@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>DashBoard</title>
    <link rel="stylesheet" href="{{ url('css/blade.css') }}">
@endsection

@section('subcontent')
<style>
    .horarioActual {
        background-color: #bfffc7; /* Amarillo tenue */
    }
</style>
<div class="container-fluid">
    <h1 class="text-center">Horario de Citas para el {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}</h1>

    <div class="row justify-content-center mt-4">
        <form method="GET" action="{{ route('cites.dashboard') }}" class="mb-4">
            <div class="input-group">
                <input type="date" name="date" class="form-control" value="{{ $fecha }}" required>
                <button type="submit" class="btn btn-primary">Ver Citas</button>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <x-base.table> class="table table-bordered w-100">
                    <thead>
                        <tr>
                            <th>Horario</th>
                            <th>Citas</th>
                        </tr>
                    </thead>
                    @php
                        $currentHour = \Carbon\Carbon::now()->format('H'); // Hora actual en formato de 24 horas
                    @endphp
                    <tbody>
                        @foreach($horarios as $hora => $citas)
                        @php
                            $horaSinMinutos = \Carbon\Carbon::parse($hora)->format('H');
                        @endphp
                        <tr class="box @if($horaSinMinutos == $currentHour) horarioActual @endif">
                            <td class="align-middle text-center">
                                <strong>{{ $hora }}</strong>
                            </td>
                            <td>
                                @if($citas)
                                    @foreach($citas as $cita)
                                    <div class="box m-2">
                                        <div class="card-body m-1">
                                            <h5 class="card-title">{{ $cita->cliente->nombres }} {{ $cita->cliente->apellidos }}</h5>
                                            <p class="card-text">
                                                <strong>Empleado:</strong> {{ $cita->empleado->user->name }}<br>
                                                <strong>Servicio:</strong> {{ $cita->servicios->pluck('nombre')->join(', ') }}<br>
                                            </p>
                                            <button class="btn btn-sm btn-primary" onclick="changeStatus({{ $cita->id }})">
                                                Cambiar Estado
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <span class="text-muted">Sin citas</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </x-base.table>
            </div>
        </div>
    </div>
</div>

<script>
    function changeStatus(citaId) {
        // Aquí puedes implementar el código para realizar la acción de cambiar estado
        // Ejemplo: Usar una llamada AJAX para actualizar el estado en el servidor
        fetch(`/citas/${citaId}/cambiar-estado`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Estado cambiado exitosamente');
                location.reload();
            } else {
                alert('Error al cambiar el estado');
            }
        });
    }
</script>
@endsection
