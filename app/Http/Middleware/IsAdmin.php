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
        // Verificar si el usuario está autenticado y es admin
        if (! auth()->check() || auth()->user()->role !== 'admin') {
            // Redirigir a dashboard o login según esté autenticado
            return redirect()->route(auth()->check() ? 'dashboard' : 'login');
        }

        return $next($request);
    }
}
