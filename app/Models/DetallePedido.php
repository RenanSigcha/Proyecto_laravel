<?php

// app/Models/DetallePedido.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;

    protected $table = 'detalles_pedido';

    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'precio_total',
        'subtotal',
        'producto_nombre',
        'producto_sku',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'precio_unitario' => 'decimal:2',
        'precio_total' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relación con el pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    // Relación con el producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Calcular subtotal
    public function calcularSubtotal()
    {
        return $this->cantidad * $this->precio_unitario;
    }

    // Scope para detalles de un pedido específico
    public function scopePorPedido($query, $pedidoId)
    {
        return $query->where('pedido_id', $pedidoId);
    }
}
