<?php

 // app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nombre', 'apellido', 'correo_electronico', 'telefono', 'direccion_envio', 'password', 'role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relación con los pedidos
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    // Relación con el carrito de compras
    public function carritoCompras()
    {
        return $this->hasMany(CarritoCompra::class);
    }

    // Relación con las notificaciones
    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class);
    }
}
