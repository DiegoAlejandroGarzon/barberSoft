@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Perfil - cambio contraseña</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Cambiar Contraseña</h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <!-- END: Profile Menu -->
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            <!-- BEGIN: Change Password -->
            <div class="intro-y box lg:mt-5">
                {{-- <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
                    <h2 class="mr-auto text-base font-medium">Change Password</h2>
                </div> --}}
                <div class="p-5">
                    <form method="POST" action="{{ route('profile.changePasswordUpdate') }}">
                        @csrf
                        @method('PATCH')

                        <div>
                            <x-base.form-label for="old_password">
                                Contraseña Anterior
                            </x-base.form-label>
                            <x-base.form-input
                                id="old_password"
                                name="old_password"
                                type="password"
                                placeholder=""
                                class="{{ $errors->has('old_password') ? 'border-red-500' : '' }}"
                            />
                            @error('old_password')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <x-base.form-label for="new_password">
                                Nueva contraseña
                            </x-base.form-label>
                            <x-base.form-input
                                id="new_password"
                                name="new_password"
                                type="password"
                                placeholder=""
                                class="{{ $errors->has('new_password') ? 'border-red-500' : '' }}"
                            />
                            @error('new_password')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <x-base.form-label for="new_password_confirmation">
                                Confirmar nueva contraseña
                            </x-base.form-label>
                            <x-base.form-input
                                id="new_password_confirmation"
                                name="new_password_confirmation"
                                type="password"
                                placeholder=""
                                class="{{ $errors->has('new_password_confirmation') ? 'border-red-500' : '' }}"
                            />
                            @error('new_password_confirmation')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <x-base.button
                            class="mt-4"
                            type="submit"
                            variant="primary"
                        >
                            Cambiar Contraseña
                        </x-base.button>
                    </form>
                </div>
            </div>
            <!-- END: Change Password -->
        </div>
    </div>
@endsection
