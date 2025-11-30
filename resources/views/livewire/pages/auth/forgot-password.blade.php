<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $correo_electronico = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'correo_electronico' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            ['correo_electronico' => $this->correo_electronico]
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('correo_electronico', __($status));

            return;
        }

        $this->reset('correo_electronico');

        session()->flash('status', __($status));
    }
}; ?>

<div>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink">
        <!-- Correo Electrónico -->
        <div>
            <x-input-label for="correo_electronico" :value="__('Correo Electrónico')" />
            <x-text-input wire:model="correo_electronico" id="correo_electronico" class="block mt-1 w-full" type="email" name="correo_electronico" required autofocus />
            <x-input-error :messages="$errors->get('correo_electronico')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</div>
