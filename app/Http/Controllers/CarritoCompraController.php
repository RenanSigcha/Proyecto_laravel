<?php

// app/Http/Controllers/CarritoCompraController.php

namespace App\Http\Controllers;

use App\Models\CarritoCompra;
use App\Models\Producto;
use Illuminate\Http\Request;

class CarritoCompraController extends Controller
{
    // Ver el carrito del usuario
    public function index()
    {
        $carrito = CarritoCompra::where('user_id', auth()->id())->get();
        return response()->json($carrito);
    }

    // Agregar un producto al carrito
    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = Producto::find($request->producto_id);
        $precio_total = $producto->precio * $request->cantidad;

        $carrito = CarritoCompra::create([
            'user_id' => auth()->id(),
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'precio_total' => $precio_total,
        ]);

        return response()->json($carrito, 201);
    }

    // Eliminar un producto del carrito
    public function destroy($id)
    {
        $carrito = CarritoCompra::find($id);
        if (!$carrito || $carrito->user_id !== auth()->id()) {
            return response()->json(['error' => 'Producto no encontrado en el carrito'], 404);
        }

        $carrito->delete();
        return response()->json(['message' => 'Producto eliminado del carrito'], 204);
    }
}
