<?php
// app/Http/Controllers/NotificacionController.php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    // Mostrar las notificaciones del usuario
    public function index()
    {
        try {
            $notificaciones = Notificacion::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
            
            $no_leidas = $notificaciones->where('leido', false)->count();
            
            return response()->json([
                'success' => true,
                'data' => $notificaciones,
                'count' => count($notificaciones),
                'no_leidas' => $no_leidas
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error'], 500);
        }
    }

    // Marcar una notificación como leída
    public function markAsRead($id)
    {
        try {
            $notificacion = Notificacion::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
            
            $notificacion->update(['leido' => true]);
            
            return response()->json([
                'success' => true,
                'data' => $notificacion,
                'message' => 'Notificación marcada como leída'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Notificación no encontrada'
            ], 404);
        }
    }
}
