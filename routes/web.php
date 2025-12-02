<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'welcome');

// Dashboard y Profile accesibles solo para usuarios con rol 'cliente'
// /dashboard redirige según rol: admin -> admin.dashboard, cliente -> cliente.dashboard
Route::get('dashboard', function () {
    $user = auth()->user();
    if (!$user) {
        return redirect()->route('login');
    }

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'cliente') {
        return redirect()->route('cliente.dashboard');
    }

    // Usuario autenticado sin rol esperado: mostrar la vista genérica
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Perfil: solo accesible para usuarios con rol 'cliente'
Route::view('profile', 'profile')
    ->middleware(['auth', 'role:cliente'])
    ->name('profile');

// Admin Routes - Protegidas con middleware 'auth' y 'admin'
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', function () {
        return view('layouts.admin', ['slot' => view('components.admin.dashboard')]);
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
