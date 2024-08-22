@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>QR del Asistente</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Código QR del Asistente</h2>
    <div class="mt-5 flex justify-center">
        @if($asistente->qrCode)
            <div>
                <h3 class="text-center">{{ $asistente->user->name }}</h3>
                <div class="mt-5">
                    {!! $asistente->qrCode !!}
                </div>
            </div>
        @else
            <p class="text-center">Este asistente no tiene un código QR asociado.</p>
        @endif
    </div>
    <div class="mt-5 flex justify-center">
        <a href="{{ route('eventAssistant.index', ['idEvent' => $asistente->event_id]) }}">
            <x-base.button class="mr-2 shadow-md" variant="secondary">
                Volver a la lista
            </x-base.button>
        </a>
    </div>
@endsection
