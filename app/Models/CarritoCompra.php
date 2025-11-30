<?php

// app/Models/CarritoCompra.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarritoCompra extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'producto_id',
        'session_id',
        'cantidad',
        'precio_unitario',
        'precio_total',
        'subtotal',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'precio_unitario' => 'decimal:2',
        'precio_total' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relación con el producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Calcular subtotal basado en cantidad y precio unitario
    public function calcularSubtotal()
    {
        return $this->cantidad * $this->precio_unitario;
    }

    // Scope para carrito de usuario específico
    public function scopePorUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Scope para carrito de sesión (invitados)
    public function scopePorSesion($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }
}
