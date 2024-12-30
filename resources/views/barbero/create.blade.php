@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Usuarios - Crear</title>
    <link rel="stylesheet" href="{{url('css/blade.css')}}">
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Crear Barbero</h2>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="intro-y box p-5">
            <form method="POST" action="{{ route('barbero.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Nombre Completo -->
                <div class="intro-y col-span-12 lg:col-span-6">
                    <x-base.form-label for="name">Nombre Completo</x-base.form-label>
                    <div class="grid-cols-2 gap-2 sm:grid">
                        <x-base.form-input
                            class="w-full {{ $errors->has('name') ? 'border-red-500' : '' }}"
                            id="name"
                            name="name"
                            type="text"
                            placeholder="Nombres"
                            value="{{ old('name') }}"
                        />
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror

                        <x-base.form-input
                            class="w-full {{ $errors->has('lastname') ? 'border-red-500' : '' }}"
                            id="lastname"
                            name="lastname"
                            type="text"
                            placeholder="Apellidos"
                            value="{{ old('lastname') }}"
                        />
                        @error('lastname')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <!-- Type Document -->
                <div class="row row_documento_id">
                <div class="col mt-3 col_document_type">
                    <x-base.form-label for="type_document">Tipo de Documento</x-base.form-label>
                    <x-base.tom-select
                        class="w-full {{ $errors->has('type_document') ? 'border-red-500' : '' }}"
                        id="type_document"
                        name="type_document"
                    >
                        <option value=""></option>
                        <option value="CC" {{ old('type_document') == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                        <option value="TI" {{ old('type_document') == 'TI' ? 'selected' : '' }}>Tarjeta de Identidad</option>
                        <option value="CE" {{ old('type_document') == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
                        <option value="PAS" {{ old('type_document') == 'PAS' ? 'selected' : '' }}>Pasaporte</option>
                    </x-base.tom-select>
                    @error('type_document')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Document Number -->
                <div class="col mt-3 col_document_id">
                    <x-base.form-label for="document_number">Número de Documento</x-base.form-label>
                    <x-base.form-input
                        class="w-full {{ $errors->has('document_number') ? 'border-red-500' : '' }}"
                        id="document_number"
                        name="document_number"
                        type="text"
                        placeholder="Número de Documento"
                        value="{{ old('document_number') }}"
                    />
                    @error('document_number')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                </div>


                <div class="row row_phone_cumpleaños">

                     <!-- Fecha Cumpleaños -->
                    <div class="col mt-3 col_cumpleaños">
                        <x-base.form-label for="birth_date">Fecha Nacimiento</x-base.form-label>
                        <x-base.form-input
                            class="w-full {{ $errors->has('birth_date') ? 'border-red-500' : '' }}"
                            id="birth_date"
                            name="birth_date"
                            type="date"
                            value="{{ old('birth_date') }}"
                        />
                        @error('birth_date')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="col mt-3 col_phone">
                        <x-base.form-label for="phone">Teléfono</x-base.form-label>
                        <x-base.form-input
                            class="w-full {{ $errors->has('phone') ? 'border-red-500' : '' }}"
                            id="phone"
                            name="phone"
                            type="text"
                            placeholder="Teléfono"
                            value="{{ old('phone') }}"
                        />
                        @error('phone')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                 <!-- Correo Electrónico -->
                 <div class="mt-3">
                    <x-base.form-label for="email">Correo Electrónico</x-base.form-label>
                    <x-base.form-input
                        class="w-full {{ $errors->has('email') ? 'border-red-500' : '' }}"
                        id="email"
                        name="email"
                        type="email"
                        placeholder="Email"
                        value="{{ old('email') }}"
                    />
                    @error('email')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3">
                    <x-base.form-label for="servicios">Servicios</x-base.form-label>
                    <x-base.tom-select
                        class="w-full"
                        id="servicios"
                        multiple
                    >
                    @foreach ($servicios as $servicio)
                    <option value="{{$servicio->id}}" >{{$servicio->nombre}}</option>
                    @endforeach
                    </x-base.tom-select>
                </div>
                @if (Auth::user()->hasRole('super-admin'))
                <!-- Barberia -->
                <div class="mt-3">
                    <x-base.form-label for="empresa_id">Barberia</x-base.form-label>
                    <x-base.tom-select
                        class="w-full {{ $errors->has('empresa_id') ? 'border-red-500' : '' }}"
                        id="empresa_id"
                        name="empresa_id"
                    >
                        <option></option>
                        @foreach ($empresas as $barberia)
                            <option value="{{$barberia->id}}" {{ old('empresa_id') == $barberia->id ? 'selected' : '' }}>{{ $barberia->nombre }}</option>
                        @endforeach
                    </x-base.tom-select>
                    @error('empresa_id')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                @endif
                <!-- foto de la Barbero -->
                <div class="intro-y col-span-12 lg:col-span-6 mt-4">
                    <x-base.form-label for="foto">Foto del Barbero</x-base.form-label>
                    <x-base.form-input
                        class="w-full {{ $errors->has('foto') ? 'border-red-500' : '' }}"
                        id="foto"
                        name="foto"
                        type="file"
                    />
                    @error('foto')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
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
