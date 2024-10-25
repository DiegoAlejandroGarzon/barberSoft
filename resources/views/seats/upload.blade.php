@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Cargar Silletería desde Excel</title>
@endsection

@section('subcontent')
    <div class="container">
        <h1>Cargar Silletería desde Excel</h1>

        <form action="{{ route('seats.upload', ['idEvent' => $idEvent]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <select id="ticketTypeId" name="ticketTypeId" class="form-select">
                <option value="">Selecciona un tipo de ticket</option>
                @foreach($ticketTypes as $ticketType)
                    <option value="{{ $ticketType->id }}">{{ $ticketType->name }}</option>
                @endforeach
            </select>
            <div class="mb-4">
                <label for="excelFile" class="form-label">Archivo Excel:</label>
                <input type="file" name="excelFile" id="excelFile" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Cargar</button>
            <a href="{{ route('seats.index', ['idEvent' => $idEvent]) }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
