<?php

// app/Http/Controllers/CarritoCompraController.php

namespace App\Http\Controllers;

use App\Models\CarritoCompra;
use App\Models\Producto;
use Illuminate\Http\Request;

class CarritoCompraController extends Controller
{
    // Ver el carrito del usuario autenticado
    public function index()
    {
        try {
            $carrito = CarritoCompra::where('user_id', auth()->id())->with('producto')->get();
            $total = $carrito->sum('precio_total');
            
            return response()->json([
                'success' => true,
                'data' => $carrito,
                'total' => $total,
                'count' => count($carrito)
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error'], 500);
        }
    }

    // Agregar un producto al carrito
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'producto_id' => 'required|exists:productos,id',
                'cantidad' => 'required|integer|min:1',
            ]);

            $producto = Producto::find($validated['producto_id']);
            if (!$producto) {
                return response()->json(['success' => false, 'error' => 'No encontrado'], 404);
            }

            if ($producto->cantidad_disponible < $validated['cantidad']) {
                return response()->json([
                    'success' => false,
                    'error' => 'Stock insuficiente'
                ], 400);
            }

            $precio_total = $producto->precio * $validated['cantidad'];

            $carrito = CarritoCompra::create([
                'user_id' => auth()->id(),
                'producto_id' => $validated['producto_id'],
                'cantidad' => $validated['cantidad'],
                'precio_total' => $precio_total,
            ]);

            return response()->json([
                'success' => true,
                'data' => $carrito,
                'message' => 'Agregado al carrito'
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error'], 500);
        }
    }

    // Eliminar un producto del carrito
    public function destroy($id)
    {
        try {
            $carrito = CarritoCompra::find($id);
            if (!$carrito) {
                return response()->json(['success' => false, 'error' => 'No encontrado'], 404);
            }

            if ($carrito->user_id !== auth()->id()) {
                return response()->json(['success' => false, 'error' => 'No autorizado'], 403);
            }

            $carrito->delete();
            return response()->json(['success' => true, 'message' => 'Eliminado']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error'], 500);
        }
    }
}
