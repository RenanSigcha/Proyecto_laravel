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
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Verificar que el usuario tenga rol de admin
        $user = auth()->user();
        if (!$user || $user->role !== 'admin') {
            // Si es un cliente autenticado, redirigir a su dashboard
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
