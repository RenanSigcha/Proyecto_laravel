<?php  
// routes/api.php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CarritoCompraController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\NotificacionController;

// Rutas para usuarios (autenticación)
Route::post('/register', [UserController::class, 'register']);  // Registro de usuario
Route::post('/login', [UserController::class, 'login']);  // Login de usuario

Route::middleware('auth:sanctum')->get('/me', [UserController::class, 'me']);  // Obtener datos del usuario autenticado

// Rutas para productos (CRUD)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/productos', [ProductoController::class, 'index']);  // Ver todos los productos
    Route::get('/productos/{id}', [ProductoController::class, 'show']);  // Ver un producto específico
    Route::post('/productos', [ProductoController::class, 'store']);  // Crear un producto (solo admin)
    Route::put('/productos/{id}', [ProductoController::class, 'update']);  // Actualizar un producto (solo admin)
    Route::delete('/productos/{id}', [ProductoController::class, 'destroy']);  // Eliminar un producto (solo admin)
});

// Rutas para el carrito de compras (CRUD)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/carrito-compras', [CarritoCompraController::class, 'index']);  // Ver el carrito del usuario
    Route::post('/carrito-compras', [CarritoCompraController::class, 'store']);  // Agregar producto al carrito
    Route::delete('/carrito-compras/{id}', [CarritoCompraController::class, 'destroy']);  // Eliminar producto del carrito
});

// Rutas para pedidos (CRUD)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/pedidos', [PedidoController::class, 'store']);  // Crear un nuevo pedido
    Route::get('/pedidos', [PedidoController::class, 'index']);  // Ver los pedidos del usuario
});

// Rutas para notificaciones (CRUD)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/notificaciones', [NotificacionController::class, 'index']);  // Ver las notificaciones del usuario
    Route::put('/notificaciones/{id}/read', [NotificacionController::class, 'markAsRead']);  // Marcar una notificación como leída
});
