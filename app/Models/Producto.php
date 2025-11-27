<?php
 // app/Models/Producto.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'descripcion', 'precio', 'imagen_url', 'cantidad_disponible', 'categoria'
    ];

    // Relación con el carrito de compras
    public function carritoCompras()
    {
        return $this->hasMany(CarritoCompra::class);
    }

    // Relación con los detalles de los pedidos
    public function detallesPedido()
    {
        return $this->hasMany(DetallePedido::class);
    }
}
