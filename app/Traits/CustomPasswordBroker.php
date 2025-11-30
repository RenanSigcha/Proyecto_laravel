<?php

namespace App\Traits;

use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Contracts\Auth\CanResetPassword;

class CustomPasswordBroker extends PasswordBroker
{
    /**
     * Get the user for the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\CanResetPassword|null
     */
    public function getUser(array $credentials)
    {
        $credentials = array_except($credentials, ['password', 'password_confirmation', 'token']);

        $user = $this->users->retrieveByCredentials($credentials);

        return $user;
    }
}
