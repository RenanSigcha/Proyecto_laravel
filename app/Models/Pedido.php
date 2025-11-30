<?php

 // app/Models/Pedido.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subtotal',
        'impuestos',
        'descuento',
        'total_a_pagar',
        'estado',
        'direccion_envio',
        'cedula_identidad',
        'numero_celular',
        'metodo_pago',
        'payment_status',
        'payment_reference',
        'tracking_number',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'impuestos' => 'decimal:2',
        'descuento' => 'decimal:2',
        'total_a_pagar' => 'decimal:2',
    ];

    // Estados posibles del pedido
    const ESTADO_EN_ESPERA = 'en espera';
    const ESTADO_ENVIADO = 'enviado';
    const ESTADO_ENTREGADO = 'entregado';
    const ESTADO_CANCELADO = 'cancelado';

    // Estados de pago
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_COMPLETED = 'completed';
    const PAYMENT_FAILED = 'failed';

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con los detalles del pedido
    public function detallesPedido()
    {
        return $this->hasMany(DetallePedido::class);
    }

    // Scope para pedidos pendientes de pago
    public function scopePendientePago($query)
    {
        return $query->whereNull('payment_status')
                     ->orWhere('payment_status', self::PAYMENT_PENDING);
    }

    // Scope para pedidos pagados
    public function scopePagado($query)
    {
        return $query->where('payment_status', self::PAYMENT_COMPLETED);
    }

    // Scope para pedidos de usuario específico
    public function scopePorUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Scope para filtrar por estado
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    // Calcular total a partir de subtotal, impuestos y descuento
    public function calcularTotal()
    {
        return $this->subtotal + $this->impuestos - $this->descuento;
    }

    // Marcar como pagado
    public function marcarComoPagado($paymentReference = null)
    {
        $this->update([
            'payment_status' => self::PAYMENT_COMPLETED,
            'payment_reference' => $paymentReference,
        ]);
    }

    // Actualizar estado de envío
    public function actualizarEstado($nuevoEstado)
    {
        $this->update(['estado' => $nuevoEstado]);
    }
}
