@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Departamento - Crear</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Crear Ciudad</h2>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="intro-y box p-5">
            <form method="POST" action="{{ route('city.store') }}">
                @csrf              

                <!-- Nombre del Departamento -->
                <div class="intro-y col-span-12 lg:col-span-6">
                <x-base.form-label for="name">Nombre de la Ciudad</x-base.form-label>
                    <div class="grid-cols-2 gap-2 sm:grid">
                        <!-- Codigo Dane -->                    
                            <x-base.form-input
                                class="w-full {{ $errors->has('code_dane') ? 'border-red-500' : '' }}"
                                id="code_dane"
                                name="code_dane"
                                type="text"
                                placeholder="code_dane"
                                value="{{ old('code_dane') }}"
                            />
                            @error('name')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror        
                        <!-- Nombre del departamento -->  
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
                <!-- Nombre Provincia -->
                <div class="intro-y col-span-12 lg:col-span-6">
                <x-base.form-label for="name">Provincia</x-base.form-label>
                    <div class="grid-cols-2 gap-2 sm:grid">
                        <!-- Codigo Dane -->                    
                            <x-base.form-input
                                class="w-full {{ $errors->has('provincia') ? 'border-red-500' : '' }}"
                                id="provincia"
                                name="provincia"
                                type="text"
                                placeholder="provincia"
                                value="{{ old('provincia') }}"
                            />
                            @error('provincia')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror 
                    </div>
                    <!-- Departamento -->
                    <div class="mt-3">       
                        <!-- Nombre del departamento -->  
                        <x-base.form-label for="department_id">Departamento</x-base.form-label>
                    <x-base.tom-select
                        class="w-full {{ $errors->has('department_id') ? 'border-red-500' : '' }}"
                        id="department_id"
                        name="department_id"
                        onchange="filterCities()"
                    >
                        <option></option>
                        @foreach ($departments as $department)
                            <option value="{{$department->id}}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->code_dane }} - {{ $department->name }}</option>
                        @endforeach
                    </x-base.tom-select>
                    @error('department_id')
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