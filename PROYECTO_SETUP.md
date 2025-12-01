# 🎯 Plataforma de E-Commerce Agrícola - Guía de Uso

## ✅ Estado del Proyecto
- ✅ Base de datos: 12 tablas configuradas
- ✅ Autenticación: Sistema dual (Admin/Cliente)
- ✅ Rutas: Protegidas con middleware
- ✅ Panel Admin: Interfaz profesional con Tailwind CSS
- ✅ Dashboard Cliente: Página por defecto de Laravel

## 🚀 Iniciar el Servidor

```bash
cd c:\xampp\htdocs\Renan
php artisan serve --host=127.0.0.1 --port=8000
```

Accede a: **http://127.0.0.1:8000**

## 👤 Credenciales de Prueba

### Administrador
- **Email**: admin@example.com
- **Contraseña**: AdminPass123!
- **Acceso**: Panel profesional en `/admin/dashboard`

### Cliente
- **Email**: cliente@example.com
- **Contraseña**: ClientPass123!
- **Acceso**: Dashboard cliente en `/dashboard`

## 🔐 Sistema de Autenticación

### Campo de Autenticación
El sistema usa **correo_electronico** (no email) como campo de login

### Roles
- **admin**: Acceso a panel administrativo
- **cliente**: Acceso a dashboard de cliente

### Flujo de Login
1. Usuario ingresa credenciales
2. Sistema valida contra `correo_electronico`
3. Redirección automática según rol:
   - Admin → `/admin/dashboard`
   - Cliente → `/dashboard`

## 📁 Estructura Clave

```
app/
├── Models/           # Modelos Eloquent
├── Http/
│   ├── Controllers/  # Controladores API
│   └── Middleware/
│       └── IsAdmin.php    # Middleware de autorización admin
└── Livewire/
    └── Forms/LoginForm.php # Formulario de login

resources/
├── views/
│   ├── livewire/
│   │   ├── pages/auth/login.blade.php
│   │   └── pages/admin/dashboard.php
│   └── layouts/admin.blade.php

routes/
└── web.php          # Rutas protegidas con middleware
```

## 🛠 Configuración

### Cache Driver
- **Actual**: file (desarrollo)
- **Producción**: redis o database

### Base de Datos
- **Motor**: PostgreSQL
- **Base**: insumos_agricolas
- **Tablas**: 12 principales

### Proveedor de Autenticación
- **Tipo**: Custom (CustomUserProvider)
- **Campo**: correo_electronico

## 🔧 Comandos Útiles

```bash
# Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Ver rutas
php artisan route:list

# Ejecutar migraciones
php artisan migrate

# Crear admin desde CLI
php artisan tinker
```

## ⚠️ Errores Corregidos

✅ **Error 1**: Método login() con return en void function
- **Solución**: Removidos los `return` del método void

✅ **Error 2**: Rutas admin sin prefijo en nombres
- **Solución**: Agregado `.name('admin.')` en Route::group()

✅ **Error 3**: Usuarios malformados en BD
- **Solución**: Limpiados y creados correctamente

## 📋 Próximas Mejoras (Opcional)

- [ ] Crear componentes Volt para productos
- [ ] Implementar carrito de compras
- [ ] Sistema de pagos
- [ ] Notificaciones en tiempo real
- [ ] Reportes de ventas
- [ ] API REST completa

## 📞 Soporte

Para problemas, ejecutar:
```bash
php artisan tinker
# Verificar usuario admin
DB::table('users')->where('correo_electronico', 'admin@example.com')->first()
```

---
**Proyecto Finalizado**: 30 de noviembre de 2025
