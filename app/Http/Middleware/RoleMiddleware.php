<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage: middleware('role:admin') or middleware('role:cliente|admin')
     */
    public function handle(Request $request, Closure $next, string $roles = null): Response
    {
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('login');
        }

        $user = auth()->user();

        if (!$roles) {
            return $next($request);
        }

        $allowed = explode('|', $roles);

        if (!in_array($user->role, $allowed, true)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden. Role not allowed.'], 403);
            }

            abort(403, 'Acceso denegado. Rol no permitido.');
        }

        return $next($request);
    }
}
