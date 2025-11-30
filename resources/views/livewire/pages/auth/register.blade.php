<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $nombre = '';
    public string $apellido = '';
    public string $correo_electronico = '';
    public string $telefono = '';
    public string $direccion_envio = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'correo_electronico' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,correo_electronico'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'direccion_envio' => ['nullable', 'string'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register">
        <!-- Nombre -->
        <div>
            <x-input-label for="nombre" :value="__('Nombre')" />
            <x-text-input wire:model="nombre" id="nombre" class="block mt-1 w-full" type="text" name="nombre" required autofocus autocomplete="given-name" />
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Apellido -->
        <div class="mt-4">
            <x-input-label for="apellido" :value="__('Apellido')" />
            <x-text-input wire:model="apellido" id="apellido" class="block mt-1 w-full" type="text" name="apellido" required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('apellido')" class="mt-2" />
        </div>

        <!-- Correo Electrónico -->
        <div class="mt-4">
            <x-input-label for="correo_electronico" :value="__('Correo Electrónico')" />
            <x-text-input wire:model="correo_electronico" id="correo_electronico" class="block mt-1 w-full" type="email" name="correo_electronico" required autocomplete="email" />
            <x-input-error :messages="$errors->get('correo_electronico')" class="mt-2" />
        </div>

        <!-- Teléfono -->
        <div class="mt-4">
            <x-input-label for="telefono" :value="__('Teléfono')" />
            <x-text-input wire:model="telefono" id="telefono" class="block mt-1 w-full" type="tel" name="telefono" autocomplete="tel" />
            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
        </div>

        <!-- Dirección de Envío -->
        <div class="mt-4">
            <x-input-label for="direccion_envio" :value="__('Dirección de Envío')" />
            <x-text-input wire:model="direccion_envio" id="direccion_envio" class="block mt-1 w-full" type="text" name="direccion_envio" autocomplete="street-address" />
            <x-input-error :messages="$errors->get('direccion_envio')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
