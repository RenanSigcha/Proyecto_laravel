# 📚 Documentación REST API - Sistema de Gestión Agrícola

## 🔐 Autenticación

Todos los endpoints protegidos requieren un token Bearer de Sanctum en el header `Authorization`.

### Estructura de Respuesta Exitosa
```json
{
  "success": true,
  "data": { /* datos específicos */ },
  "message": "Descripción del éxito (opcional)",
  "count": 10  // Solo en listados
}
```

### Estructura de Respuesta de Error
```json
{
  "success": false,
  "error": "Descripción del error"
}
```

---

## 🔓 Autenticación Pública

### Registro de Usuario
```
POST /api/register
Content-Type: application/json

{
  "name": "Juan Pérez",
  "correo_electronico": "juan@example.com",
  "password": "Password123!",
  "password_confirmation": "Password123!"
}
```

**Respuesta 201:**
```json
{
  "success": true,
  "data": {
    "id": 18,
    "name": "Juan Pérez",
    "correo_electronico": "juan@example.com",
    "role": "cliente",
    "created_at": "2025-11-27T10:30:00Z"
  },
  "token": "1|abc123XYZ..."
}
```

### Login
```
POST /api/login
Content-Type: application/json

{
  "correo_electronico": "cliente@example.com",
  "password": "ClientPass123!"
}
```

**Respuesta 200:**
```json
{
  "success": true,
  "data": {
    "id": 17,
    "name": "Cliente Ejemplo",
    "correo_electronico": "cliente@example.com",
    "role": "cliente"
  },
  "token": "2|xyz789ABC...",
  "message": "Login exitoso"
}
```

---

## 📦 Productos (Solo lectura para clientes, CRUD para admin)

### Listar Todos los Productos
```
GET /api/productos
Content-Type: application/json
```

**Respuesta 200:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nombre": "Semilla Maíz Híbrido",
      "descripcion": "Semilla de alta germinación",
      "precio": 45.99,
      "cantidad_disponible": 500,
      "categoria": "Semillas",
      "created_at": "2025-11-26T08:00:00Z"
    },
    {
      "id": 2,
      "nombre": "Fertilizante NPK 15-15-15",
      "descripcion": "Fertilizante balanceado",
      "precio": 28.50,
      "cantidad_disponible": 1000,
      "categoria": "Fertilizantes",
      "created_at": "2025-11-26T09:15:00Z"
    }
  ],
  "count": 2
}
```

### Obtener Producto por ID
```
GET /api/productos/{id}
Content-Type: application/json
```

**Ejemplo:** `GET /api/productos/1`

**Respuesta 200:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "nombre": "Semilla Maíz Híbrido",
    "descripcion": "Semilla de alta germinación",
    "precio": 45.99,
    "cantidad_disponible": 500,
    "categoria": "Semillas",
    "created_at": "2025-11-26T08:00:00Z"
  }
}
```

### Crear Producto (⚠️ Solo Admin)
```
POST /api/productos
Authorization: Bearer {token}
Content-Type: application/json

{
  "nombre": "Nuevo Producto",
  "descripcion": "Descripción del producto",
  "precio": 50.00,
  "cantidad_disponible": 100,
  "categoria": "Semillas"
}
```

**Respuesta 201 (Admin):**
```json
{
  "success": true,
  "data": {
    "id": 3,
    "nombre": "Nuevo Producto",
    "descripcion": "Descripción del producto",
    "precio": 50.00,
    "cantidad_disponible": 100,
    "categoria": "Semillas"
  },
  "message": "Producto creado exitosamente"
}
```

**Respuesta 403 (Cliente intenta crear):**
```json
{
  "success": false,
  "error": "No tiene permisos para esta acción"
}
```

### Actualizar Producto (⚠️ Solo Admin)
```
PUT /api/productos/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "nombre": "Producto Actualizado",
  "precio": 55.00,
  "cantidad_disponible": 150
}
```

**Respuesta 200:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "nombre": "Producto Actualizado",
    "precio": 55.00,
    "cantidad_disponible": 150
  },
  "message": "Producto actualizado"
}
```

### Eliminar Producto (⚠️ Solo Admin)
```
DELETE /api/productos/{id}
Authorization: Bearer {token}
Content-Type: application/json
```

**Respuesta 200:**
```json
{
  "success": true,
  "data": { "id": 1 },
  "message": "Producto eliminado"
}
```

---

## 🛒 Carrito de Compras

### Ver Carrito del Usuario
```
GET /api/carrito-compras
Authorization: Bearer {token}
Content-Type: application/json
```

**Respuesta 200:**
```json
{
  "success": true,
  "data": [
    {
      "id": 5,
      "user_id": 17,
      "producto_id": 1,
      "cantidad": 2,
      "precio_total": 91.98,
      "producto": {
        "id": 1,
        "nombre": "Semilla Maíz Híbrido",
        "precio": 45.99
      }
    },
    {
      "id": 6,
      "user_id": 17,
      "producto_id": 2,
      "cantidad": 1,
      "precio_total": 28.50,
      "producto": {
        "id": 2,
        "nombre": "Fertilizante NPK 15-15-15",
        "precio": 28.50
      }
    }
  ],
  "total": 120.48,
  "count": 2
}
```

### Agregar Producto al Carrito
```
POST /api/carrito-compras
Authorization: Bearer {token}
Content-Type: application/json

{
  "producto_id": 1,
  "cantidad": 2
}
```

**Respuesta 201:**
```json
{
  "success": true,
  "data": {
    "id": 5,
    "user_id": 17,
    "producto_id": 1,
    "cantidad": 2,
    "precio_total": 91.98
  },
  "total": 120.48,
  "count": 3,
  "message": "Producto agregado al carrito"
}
```

**Respuesta 400 (Stock insuficiente):**
```json
{
  "success": false,
  "error": "Stock insuficiente"
}
```

### Eliminar Producto del Carrito
```
DELETE /api/carrito-compras/{id}
Authorization: Bearer {token}
Content-Type: application/json
```

**Respuesta 200:**
```json
{
  "success": true,
  "data": { "id": 5 },
  "total": 28.50,
  "count": 1,
  "message": "Producto removido del carrito"
}
```

---

## 📋 Pedidos

### Listar Pedidos del Usuario
```
GET /api/pedidos
Authorization: Bearer {token}
Content-Type: application/json
```

**Respuesta 200:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "user_id": 17,
      "total_a_pagar": 120.48,
      "estado": "en espera",
      "payment_status": "pendiente",
      "direccion_envio": "Calle 123, Apartado 4",
      "detalles": [
        {
          "id": 1,
          "pedido_id": 1,
          "producto_id": 1,
          "cantidad": 2,
          "precio_total": 91.98,
          "producto": {
            "id": 1,
            "nombre": "Semilla Maíz Híbrido",
            "precio": 45.99
          }
        }
      ],
      "created_at": "2025-11-27T10:30:00Z"
    }
  ],
  "count": 1
}
```

### Crear Pedido desde Carrito
```
POST /api/pedidos
Authorization: Bearer {token}
Content-Type: application/json
```

**Respuesta 201:**
```json
{
  "success": true,
  "data": {
    "id": 2,
    "user_id": 17,
    "total_a_pagar": 120.48,
    "estado": "en espera",
    "payment_status": "pendiente",
    "direccion_envio": "Calle 123, Apartado 4",
    "detalles": [
      {
        "id": 2,
        "pedido_id": 2,
        "producto_id": 1,
        "cantidad": 2,
        "precio_total": 91.98
      }
    ]
  },
  "message": "Pedido creado"
}
```

**Respuesta 400 (Carrito vacío):**
```json
{
  "success": false,
  "error": "El carrito está vacío"
}
```

---

## 🔔 Notificaciones

### Listar Notificaciones del Usuario
```
GET /api/notificaciones
Authorization: Bearer {token}
Content-Type: application/json
```

**Respuesta 200:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "user_id": 17,
      "titulo": "Pedido Confirmado",
      "mensaje": "Tu pedido #1 ha sido confirmado",
      "leido": false,
      "created_at": "2025-11-27T10:31:00Z"
    },
    {
      "id": 2,
      "user_id": 17,
      "titulo": "Enviado",
      "mensaje": "Tu pedido #1 ha sido enviado",
      "leido": true,
      "created_at": "2025-11-27T11:45:00Z"
    }
  ],
  "count": 2,
  "no_leidas": 1
}
```

### Marcar Notificación como Leída
```
PUT /api/notificaciones/{id}/mark-as-read
Authorization: Bearer {token}
Content-Type: application/json
```

**Respuesta 200:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "user_id": 17,
    "titulo": "Pedido Confirmado",
    "mensaje": "Tu pedido #1 ha sido confirmado",
    "leido": true,
    "created_at": "2025-11-27T10:31:00Z"
  },
  "message": "Notificación marcada como leída"
}
```

---

## 👤 Perfil de Usuario

### Obtener Datos del Usuario Actual
```
GET /api/me
Authorization: Bearer {token}
Content-Type: application/json
```

**Respuesta 200:**
```json
{
  "success": true,
  "data": {
    "id": 17,
    "name": "Cliente Ejemplo",
    "correo_electronico": "cliente@example.com",
    "role": "cliente",
    "created_at": "2025-11-27T08:00:00Z"
  }
}
```

---

## 🔐 Códigos de Estado HTTP

| Código | Significado |
|--------|-------------|
| **200** | OK - Solicitud exitosa |
| **201** | Created - Recurso creado |
| **400** | Bad Request - Datos inválidos |
| **401** | Unauthorized - Token inválido o expirado |
| **403** | Forbidden - No tiene permisos |
| **404** | Not Found - Recurso no encontrado |
| **500** | Server Error - Error interno del servidor |

---

## 🧪 Ejemplo Completo: Flujo de Compra

### 1. Login
```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "correo_electronico": "cliente@example.com",
    "password": "ClientPass123!"
  }'
```

Guardar el `token` de la respuesta.

### 2. Agregar Producto al Carrito
```bash
curl -X POST http://127.0.0.1:8000/api/carrito-compras \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "producto_id": 1,
    "cantidad": 2
  }'
```

### 3. Ver Carrito
```bash
curl -X GET http://127.0.0.1:8000/api/carrito-compras \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json"
```

### 4. Crear Pedido
```bash
curl -X POST http://127.0.0.1:8000/api/pedidos \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json"
```

### 5. Ver Pedidos
```bash
curl -X GET http://127.0.0.1:8000/api/pedidos \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json"
```

### 6. Ver Notificaciones
```bash
curl -X GET http://127.0.0.1:8000/api/notificaciones \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json"
```

---

## 📝 Notas Importantes

- **Autenticación**: Todos los endpoints con prefijo `/api/` excepto `/register` y `/login` requieren token Bearer
- **Admin-only**: Los endpoints `POST`, `PUT`, `DELETE` de productos solo están disponibles para usuarios con `role: 'admin'`
- **Validación**: Los datos se validan automáticamente; si hay errores, se devuelve respuesta con `success: false`
- **Transacciones**: Las operaciones de pedidos usan transacciones para garantizar consistencia
- **Timestamps**: Todos los timestamps están en formato ISO 8601 UTC

---

## 👥 Usuarios de Prueba

| Email | Contraseña | Rol | Acciones |
|-------|-----------|-----|----------|
| admin@example.com | AdminPass123! | admin | CRUD productos, ver todos los pedidos |
| cliente@example.com | ClientPass123! | cliente | Ver productos, crear pedidos, ver sus pedidos |

---

## 🚀 Inicio Rápido

```bash
# 1. Clonar repositorio y configurar
cd c:\xampp\htdocs\Renan

# 2. Instalar dependencias
composer install
npm install

# 3. Ejecutar migraciones
php artisan migrate

# 4. Iniciar servidor
php artisan serve --host=127.0.0.1 --port=8000

# 5. La API está lista en:
# http://127.0.0.1:8000/api
```

---

*Última actualización: 27 de Noviembre, 2025*
