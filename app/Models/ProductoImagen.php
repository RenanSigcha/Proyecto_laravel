<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoImagen extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'imagen_url',
        'orden',
    ];

    protected $casts = [
        'orden' => 'integer',
    ];

    // Relación con el producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
