#!/usr/bin/env php
<?php

/**
 * Script de prueba de API REST
 * Verifica que todos los endpoints funcionen correctamente
 */

$baseUrl = 'http://127.0.0.1:8000/api';
$token = null;
$adminToken = null;

// Colores para consola
$green = "\033[92m";
$red = "\033[91m";
$yellow = "\033[93m";
$reset = "\033[0m";
$blue = "\033[94m";

function testEndpoint($method, $endpoint, $data = null, $token = null) {
    global $baseUrl;
    
    $url = $baseUrl . $endpoint;
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    
    $headers = ['Content-Type: application/json'];
    if ($token) {
        $headers[] = "Authorization: Bearer $token";
    }
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    list($headerPart, $bodyPart) = explode("\r\n\r\n", $response, 2);
    
    return [
        'code' => $httpCode,
        'body' => json_decode($bodyPart, true)
    ];
}

function printTest($name, $passed, $details = '') {
    global $green, $red, $yellow, $reset;
    
    $status = $passed ? "{$green}✓ PASSED{$reset}" : "{$red}✗ FAILED{$reset}";
    echo "  $status - $name\n";
    if ($details) {
        echo "    {$yellow}$details{$reset}\n";
    }
}

echo "\n{$blue}═══════════════════════════════════════════════════════════════{$reset}\n";
echo "{$blue}    PRUEBA DE API REST - Sistema de Gestión Agrícola{$reset}\n";
echo "{$blue}═══════════════════════════════════════════════════════════════{$reset}\n\n";

// ========== PRUEBAS DE AUTENTICACIÓN ==========
echo "{$yellow}1. PRUEBAS DE AUTENTICACIÓN{$reset}\n";

// Test 1: Login Cliente
$loginResponse = testEndpoint('POST', '/login', [
    'correo_electronico' => 'cliente@example.com',
    'password' => 'ClientPass123!'
]);

$clienteLoginPassed = $loginResponse['code'] == 200 && !empty($loginResponse['body']['token']);
printTest("Login Cliente", $clienteLoginPassed);

if ($clienteLoginPassed) {
    $token = $loginResponse['body']['token'];
    echo "    {$blue}Token obtenido: " . substr($token, 0, 20) . "...{$reset}\n";
}

// Test 2: Login Admin
$adminLoginResponse = testEndpoint('POST', '/login', [
    'correo_electronico' => 'admin@example.com',
    'password' => 'AdminPass123!'
]);

$adminLoginPassed = $adminLoginResponse['code'] == 200 && !empty($adminLoginResponse['body']['token']);
printTest("Login Admin", $adminLoginPassed);

if ($adminLoginPassed) {
    $adminToken = $adminLoginResponse['body']['token'];
    echo "    {$blue}Token obtenido: " . substr($adminToken, 0, 20) . "...{$reset}\n";
}

// Test 3: Obtener datos del usuario
if ($token) {
    $meResponse = testEndpoint('GET', '/me', null, $token);
    $mePassed = $meResponse['code'] == 200 && $meResponse['body']['success'];
    printTest("Obtener datos del usuario (cliente)", $mePassed, 
        "Role: " . ($meResponse['body']['data']['role'] ?? 'N/A'));
}

// ========== PRUEBAS DE PRODUCTOS ==========
echo "\n{$yellow}2. PRUEBAS DE PRODUCTOS{$reset}\n";

// Test 4: Listar productos
if ($token) {
    $productosResponse = testEndpoint('GET', '/productos', null, $token);
    $productosPassed = $productosResponse['code'] == 200 && $productosResponse['body']['success'];
    printTest("Listar productos (cliente)", $productosPassed,
        "Productos encontrados: " . ($productosResponse['body']['count'] ?? 0));
}

// Test 5: Crear producto como admin
if ($adminToken) {
    $createProductResponse = testEndpoint('POST', '/productos', [
        'nombre' => 'Producto Test ' . time(),
        'descripcion' => 'Producto creado por test',
        'precio' => 99.99,
        'cantidad_disponible' => 50,
        'categoria' => 'Test'
    ], $adminToken);
    
    $createPassed = $createProductResponse['code'] == 201 && $createProductResponse['body']['success'];
    printTest("Crear producto como admin", $createPassed);
}

// Test 6: Intentar crear producto como cliente (debe fallar)
if ($token) {
    $createAsClientResponse = testEndpoint('POST', '/productos', [
        'nombre' => 'Producto Test',
        'descripcion' => 'Debe fallar',
        'precio' => 50,
        'cantidad_disponible' => 100,
        'categoria' => 'Test'
    ], $token);
    
    $createAsClientFailed = $createAsClientResponse['code'] == 403;
    printTest("Rechazar crear producto como cliente", $createAsClientFailed,
        "Código esperado: 403, Recibido: " . $createAsClientResponse['code']);
}

// ========== PRUEBAS DE CARRITO ==========
echo "\n{$yellow}3. PRUEBAS DE CARRITO{$reset}\n";

// Test 7: Ver carrito vacío
if ($token) {
    $carritoResponse = testEndpoint('GET', '/carrito-compras', null, $token);
    $carritoVacioPassed = $carritoResponse['code'] == 200 && $carritoResponse['body']['success'];
    printTest("Ver carrito del usuario", $carritoVacioPassed,
        "Items: " . ($carritoResponse['body']['count'] ?? 0));
}

// Test 8: Agregar producto al carrito
if ($token) {
    $addToCartResponse = testEndpoint('POST', '/carrito-compras', [
        'producto_id' => 1,
        'cantidad' => 2
    ], $token);
    
    $addToCartPassed = in_array($addToCartResponse['code'], [201, 200]) && $addToCartResponse['body']['success'];
    printTest("Agregar producto al carrito", $addToCartPassed,
        "Total: $" . ($addToCartResponse['body']['total'] ?? 0));
}

// ========== PRUEBAS DE PEDIDOS ==========
echo "\n{$yellow}4. PRUEBAS DE PEDIDOS{$reset}\n";

// Test 9: Ver pedidos del usuario
if ($token) {
    $pedidosResponse = testEndpoint('GET', '/pedidos', null, $token);
    $pedidosPassed = $pedidosResponse['code'] == 200 && $pedidosResponse['body']['success'];
    printTest("Listar pedidos del usuario", $pedidosPassed,
        "Pedidos: " . ($pedidosResponse['body']['count'] ?? 0));
}

// ========== PRUEBAS DE NOTIFICACIONES ==========
echo "\n{$yellow}5. PRUEBAS DE NOTIFICACIONES{$reset}\n";

// Test 10: Ver notificaciones
if ($token) {
    $notificacionesResponse = testEndpoint('GET', '/notificaciones', null, $token);
    $notificacionesPassed = $notificacionesResponse['code'] == 200 && $notificacionesResponse['body']['success'];
    printTest("Listar notificaciones del usuario", $notificacionesPassed,
        "Notificaciones: " . ($notificacionesResponse['body']['count'] ?? 0) . 
        " (No leídas: " . ($notificacionesResponse['body']['no_leidas'] ?? 0) . ")");
}

// ========== RESUMEN ==========
echo "\n{$blue}═══════════════════════════════════════════════════════════════{$reset}\n";
echo "{$green}✓ PRUEBA DE API COMPLETADA{$reset}\n";
echo "{$blue}═══════════════════════════════════════════════════════════════{$reset}\n";
echo "\n{$yellow}Endpoint Base:{$reset} $baseUrl\n";
echo "{$yellow}Documentación:{$reset} Ver API.md en la raíz del proyecto\n\n";
