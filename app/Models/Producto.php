<?php
 // app/Models/Producto.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'descripcion', 'precio', 'imagen_url', 'cantidad_disponible', 'categoria',
        'sku', 'slug', 'marca', 'activo', 'peso'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'precio' => 'decimal:2',
        'peso' => 'decimal:2',
    ];

    // Relación con las imágenes del producto
    public function imagenes()
    {
        return $this->hasMany(ProductoImagen::class);
    }

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

    // Scope para productos activos
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    // Scope para filtrar por categoría
    public function scopeCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    // Scope para filtrar por marca
    public function scopeMarca($query, $marca)
    {
        return $query->where('marca', $marca);
    }

    // Scope para filtrar por rango de precio
    public function scopePrecioEntre($query, $min, $max)
    {
        return $query->whereBetween('precio', [$min, $max]);
    }
}
