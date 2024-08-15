@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Eventos - Asignar Asistentes de Forma Masiva</title>
@endsection

@section('subcontent')
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-4">Asignar Asistentes de Forma Masiva para el Evento: {{ $event->name }}</h1>

    {{-- Mensajes de éxito y error --}}
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Validación de errores --}}
    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario de subida de archivo --}}
    <form action="{{ route('eventAssistant.massAssign.upload', $event->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        <div class="form-group mb-4">
            <label for="file" class="block text-gray-700 font-medium mb-2">Subir Archivo de Excel:</label>
            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" required>

            @error('file')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end">
            <x-base.button
            class="w-24"
            type="submit"
            variant="primary"
        >
        Subir y Asignar
        </x-base.button>
        </div>
    </form>

    @if(session('importedUsers'))
        <div class="mt-4">
            <h2>Usuarios Importados</h2>
            <ul>
                @foreach(session('importedUsers') as $user)
                    <li>{{ $user['user']->email }} - {{ $user['ticket_type'] }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('messages'))
        <div class="mt-4">
            <h2>Novedades</h2>
            <ul>
                @foreach(session('messages') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
