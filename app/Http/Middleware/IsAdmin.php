<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar que el usuario esté autenticado
        // Si la solicitud espera JSON (AJAX / API), responder con 401/403 apropiado
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('login');
        }

        // Verificar que el usuario tenga rol de admin
        $user = auth()->user();
        if (!$user || $user->role !== 'admin') {
            // Si la solicitud es AJAX/API devolver 403 JSON
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden. Admin only.'], 403);
            }

            // Para peticiones web normales, retornar 403 en vez de redirigir al dashboard de cliente.
            abort(403, 'Acceso denegado. Se requiere rol de administrador.');
        }

        return $next($request);
    }
}
