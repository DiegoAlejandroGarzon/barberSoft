@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Departamento - Actualizar</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Actualizar Departamento</h2>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="intro-y box p-5">
            <form method="POST" action="{{ route('department.update', ['id' => $department->id])}}">
                @csrf              

                <!-- Nombre del Departamento -->
                <div class="intro-y col-span-12 lg:col-span-6">
                <x-base.form-label for="name">Nombre del Departamento</x-base.form-label>
                    <div class="grid-cols-2 gap-2 sm:grid">                        
                        <!-- Codigo Dane -->                    
                            <x-base.form-input
                                class="w-full {{ $errors->has('code_dane') ? 'border-red-500' : '' }}"
                                id="code_dane"
                                name="code_dane"
                                type="text"
                                placeholder="code_dane"
                                value="{{ old('code_dane',$department->code_dane) }}"                               
                            />
                            @error('code_dane')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror        
                        <!-- Nombre del departamento -->  
                            <x-base.form-input
                                class="w-full {{ $errors->has('name') ? 'border-red-500' : '' }}"
                                id="name"
                                name="name"
                                type="text"
                                placeholder="name"
                                value="{{ old('name',$department->name) }}"
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