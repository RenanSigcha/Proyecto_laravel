<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

echo "=== TEST DE AUTENTICACIÓN ===\n\n";

// 1. Verificar admin existe
$admin = User::where('correo_electronico', 'admin@example.com')->first();
echo "1️⃣ Admin existe: " . ($admin ? "✅ SÍ" : "❌ NO") . "\n";

if ($admin) {
    echo "   - Email: {$admin->correo_electronico}\n";
    echo "   - Role: {$admin->role}\n";
    echo "   - Has password: " . (strlen($admin->password) > 0 ? "✅" : "❌") . "\n";
}

// 2. Verificar cliente existe
$cliente = User::where('correo_electronico', 'cliente@example.com')->first();
echo "\n2️⃣ Cliente existe: " . ($cliente ? "✅ SÍ" : "❌ NO") . "\n";

if ($cliente) {
    echo "   - Email: {$cliente->correo_electronico}\n";
    echo "   - Role: {$cliente->role}\n";
}

// 3. Test de contraseña
if ($admin) {
    $testPass = Hash::check('AdminPass123!', $admin->password);
    echo "\n3️⃣ Contraseña admin válida: " . ($testPass ? "✅ SÍ" : "❌ NO") . "\n";
}

echo "\n=== ✅ TEST COMPLETADO ===\n";
