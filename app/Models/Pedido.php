<?php

 // app/Models/Pedido.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'total_a_pagar', 'estado', 'direccion_envio', 'cedula_identidad', 'numero_celular'
    ];

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
}
