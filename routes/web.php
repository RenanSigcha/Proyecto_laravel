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
    Volt::route('dashboard', 'pages.admin.dashboard')
        ->name('dashboard');
    
    Volt::route('productos', 'pages.admin.productos')
        ->name('productos');
    
    Volt::route('pedidos', 'pages.admin.pedidos')
        ->name('pedidos');
    
    Volt::route('reportes', 'pages.admin.reportes')
        ->name('reportes');
});

require __DIR__.'/auth.php';
