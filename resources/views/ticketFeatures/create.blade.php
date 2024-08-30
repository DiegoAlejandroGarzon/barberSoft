@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
@endsection

@section('subcontent')
<div class="intro-y mt-8 flex items-center">
    <h2 class="mr-auto text-lg font-medium">Crear Ticker</h2>
</div>
<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="intro-y col-span-12 lg:col-span-12">
        <div class="intro-y box p-5">
        <form method="POST" action="{{ route('ticketFeatures.store') }}">
            @csrf
            <!-- Nombre del Ticket -->
            <div class="intro-y col-span-12 lg:col-span-6">
            <x-base.form-label for="name">Ticket</x-base.form-label>
                <div class="grid-cols-2 gap-2 sm:grid">
                    <!-- ticket name -->
                        <x-base.form-input
                            class="w-full {{ $errors->has('name') ? 'border-red-500' : '' }}"
                            id="name"
                            name="name"
                            type="text"
                            placeholder="name"
                            value="{{ old('name') }}"
                        />
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                </div>
            </div>
            <!-- Botón para crear -->
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

@endsection

@section('subscript')
@endsection
