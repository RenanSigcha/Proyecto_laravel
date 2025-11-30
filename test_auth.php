<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

$email = 'tester+authtest@example.com';
$passwordPlain = 'Secret123!';

// Crear usuario de prueba si no existe
$user = User::where('correo_electronico', $email)->first();
if (! $user) {
    $user = User::create([
        'nombre' => 'Tester',
        'apellido' => 'Auth',
        'correo_electronico' => $email,
        'telefono' => null,
        'direccion_envio' => null,
        'password' => Hash::make($passwordPlain),
        'role' => 'cliente',
    ]);
    echo "Usuario de prueba creado: ID={$user->id}, correo={$user->correo_electronico}\n";
} else {
    echo "Usuario de prueba ya existe: ID={$user->id}, correo={$user->correo_electronico}\n";
}

// Intentar autenticar con Auth::attempt
$credentials = ['correo_electronico' => $email, 'password' => $passwordPlain];
$attempt = Auth::attempt($credentials, false);

if ($attempt) {
    echo "Auth::attempt() → OK: el usuario fue autenticado exitosamente en este proceso.\n";
    // Mostrar el usuario autenticado en el proceso actual
    $current = Auth::user();
    echo "Usuario actual en proceso: ID={$current->id}, correo={$current->correo_electronico}\n";
    // Logout para limpiar
    Auth::logout();
} else {
    echo "Auth::attempt() → FAIL: credenciales rechazadas.\n";
}

// Información adicional
echo "-- Información adicional --\n";
echo "Credenciales probadas: {$email} / {$passwordPlain}\n";
echo "Asume provider 'custom' configurado en config/auth.php y CustomUserProvider disponible.\n";
