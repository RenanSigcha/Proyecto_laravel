<?php
// routes/web.php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CarritoCompraController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\UserController;

// Página principal con todos los productos
Route::get('/', [ProductoController::class, 'index']);  // Ver todos los productos

// Rutas para el carrito y los pedidos, protegidas por autenticación
Route::middleware('auth')->group(function () {
    Route::get('/carrito', [CarritoCompraController::class, 'index']);  // Ver carrito de compras
    Route::get('/pedido', [PedidoController::class, 'index']);  // Ver mis pedidos
});

// Formulario de registro
Route::get('/register', function () {
    return view('auth.register');
});  

// Formulario de login
Route::get('/login', function () {
    return view('auth.login');
});  

// Procesar el registro de usuario
Route::post('/register', [UserController::class, 'register']);  

// Procesar el login de usuario
Route::post('/login', [UserController::class, 'login']);  

// Cerrar sesión
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
});  
