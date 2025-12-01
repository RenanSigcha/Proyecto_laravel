<?php
// app/Http/Controllers/PedidoController.php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\CarritoCompra;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    // Crear un pedido desde el carrito
    public function store(Request $request)
    {
        try {
            $carrito = CarritoCompra::where('user_id', auth()->id())->get();
            if ($carrito->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'error' => 'El carrito está vacío'
                ], 400);
            }

            DB::beginTransaction();

            $total_a_pagar = $carrito->sum('precio_total');
            
            $pedido = Pedido::create([
                'user_id' => auth()->id(),
                'total_a_pagar' => $total_a_pagar,
                'estado' => 'en espera',
                'payment_status' => 'pendiente',
                'direccion_envio' => auth()->user()->direccion_envio,
            ]);

            foreach ($carrito as $item) {
                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $item->producto_id,
                    'cantidad' => $item->cantidad,
                    'precio_total' => $item->precio_total,
                ]);
            }

            $carrito->each->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $pedido->load('detalles'),
                'message' => 'Pedido creado'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => 'Error'], 500);
        }
    }

    // Mostrar los pedidos del usuario
    public function index()
    {
        try {
            $pedidos = Pedido::where('user_id', auth()->id())
                ->with('detalles.producto')
                ->orderBy('created_at', 'desc')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $pedidos,
                'count' => count($pedidos)
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error'], 500);
        }
    }
}

