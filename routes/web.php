<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Admin Routes - Protegidas con middleware 'auth' y 'admin'
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Render the Volt PHP view directly to avoid Livewire component discovery issues
    Route::get('dashboard', function () {
        return view('livewire.pages.admin.dashboard');
    })->name('dashboard');
    Volt::route('productos', 'pages.admin.productos')->name('productos');
    Volt::route('pedidos', 'pages.admin.pedidos')->name('pedidos');
    Volt::route('reportes', 'pages.admin.reportes')->name('reportes');
    // Usuarios - listado para administradores
    Route::get('usuarios', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('usuarios');
    // Actualizar rol de un usuario (formulario desde admin)
    Route::post('usuarios/{user}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('usuarios.role.update');
});

// Cliente Routes - Protegidas con middleware 'auth' y 'role:cliente'
Route::middleware(['auth', 'role:cliente'])->prefix('cliente')->name('cliente.')->group(function () {
    // Dashboard del cliente
    Route::get('dashboard', [\App\Http\Controllers\Cliente\DashboardController::class, 'index'])->name('dashboard');
    // Aquí puede agregar más rutas para el cliente (pedidos, perfil, carrito, etc.)
});

require __DIR__.'/auth.php';
