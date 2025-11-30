<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class CustomUserProvider extends EloquentUserProvider
{
    /**
     * Create a new user provider.
     *
     * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
     * @param  string  $model
     * @return void
     */
    public function __construct(HasherContract $hasher, $model)
    {
        parent::__construct($hasher, $model);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials)) {
            return;
        }

        $query = $this->createModel()->newQuery();

        foreach ($credentials as $key => $value) {
            if (!str_contains($key, 'password')) {
                // Map 'correo_electronico' to database column
                if ($key === 'correo_electronico') {
                    $query->where('correo_electronico', $value);
                } else {
                    $query->where($key, $value);
                }
            }
        }

        return $query->first();
    }
}
