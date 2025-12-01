<?php

// app/Http/Controllers/ProductoController.php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Mostrar todos los productos (públicos)
    public function index()
    {
        try {
            $productos = Producto::all();
            return response()->json([
                'success' => true,
                'data' => $productos,
                'count' => count($productos)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener productos'
            ], 500);
        }
    }

    // Mostrar un producto por ID (público)
    public function show($id)
    {
        try {
            $producto = Producto::find($id);
            if (!$producto) {
                return response()->json([
                    'success' => false,
                    'error' => 'Producto no encontrado'
                ], 404);
            }
            return response()->json([
                'success' => true,
                'data' => $producto
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener producto'
            ], 500);
        }
    }

    // Crear un nuevo producto (solo admin)
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['success' => false, 'error' => 'No autorizado'], 403);
        }

        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'precio' => 'required|numeric|min:0',
                'cantidad_disponible' => 'required|integer|min:0',
            ]);

            $producto = Producto::create($validated);
            return response()->json([
                'success' => true,
                'data' => $producto,
                'message' => 'Producto creado'
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error'], 500);
        }
    }

    // Actualizar un producto
    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['success' => false, 'error' => 'No autorizado'], 403);
        }

        try {
            $producto = Producto::find($id);
            if (!$producto) {
                return response()->json(['success' => false, 'error' => 'No encontrado'], 404);
            }

            $producto->update($request->all());
            return response()->json(['success' => true, 'data' => $producto]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error'], 500);
        }
    }

    // Eliminar un producto
    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['success' => false, 'error' => 'No autorizado'], 403);
        }

        try {
            $producto = Producto::find($id);
            if (!$producto) {
                return response()->json(['success' => false, 'error' => 'No encontrado'], 404);
            }

            $producto->delete();
            return response()->json(['success' => true, 'message' => 'Eliminado']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error'], 500);
        }
    }
}
