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
        $notificaciones = Notificacion::where('user_id', auth()->id())->get();
        return response()->json($notificaciones);
    }

    // Marcar una notificación como leída
    public function markAsRead($id)
    {
        $notificacion = Notificacion::find($id);
        if (!$notificacion || $notificacion->user_id !== auth()->id()) {
            return response()->json(['error' => 'Notificación no encontrada'], 404);
        }

        $notificacion->update(['leido' => true]);
        return response()->json(['message' => 'Notificación marcada como leída']);
    }
}
