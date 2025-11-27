<?php
// app/Http/Controllers/PedidoController.php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\CarritoCompra;
use App\Models\DetallePedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    // Crear un pedido
    public function store()
    {
        $carrito = CarritoCompra::where('user_id', auth()->id())->get();
        if ($carrito->isEmpty()) {
            return response()->json(['error' => 'El carrito está vacío'], 400);
        }

        $total_a_pagar = $carrito->sum('precio_total');
        
        // Crear el pedido
        $pedido = Pedido::create([
            'user_id' => auth()->id(),
            'total_a_pagar' => $total_a_pagar,
            'estado' => 'en espera',
            'direccion_envio' => auth()->user()->direccion_envio,
        ]);

        // Crear los detalles del pedido
        foreach ($carrito as $item) {
            DetallePedido::create([
                'pedido_id' => $pedido->id,
                'producto_id' => $item->producto_id,
                'cantidad' => $item->cantidad,
                'precio_total' => $item->precio_total,
            ]);
        }

        // Vaciar el carrito después de realizar el pedido
        $carrito->each->delete();

        return response()->json($pedido, 201);
    }

    // Mostrar los pedidos del usuario
    public function index()
    {
        $pedidos = Pedido::where('user_id', auth()->id())->get();
        return response()->json($pedidos);
    }
}

