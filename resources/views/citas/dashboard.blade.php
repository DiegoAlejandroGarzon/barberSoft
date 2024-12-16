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
<div class="container">
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
                <table class="table table-bordered">
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
                                                <strong>Barbero:</strong> {{ $cita->barbero->user->name }}<br>
                                                <strong>Servicio:</strong> {{ $cita->servicios->pluck('nombre')->join(', ') }}<br>
                                                {{-- <strong>Hora:</strong> {{ \Carbon\Carbon::parse($cita->fecha_hora)->format('H:i') }} --}}
                                            </p>
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
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
