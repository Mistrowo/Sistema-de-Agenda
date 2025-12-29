<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('inicio');
        }

        $user = Auth::user();
        $userRole = $user->ROL;

        // Verificar si tiene el rol permitido
        if (!in_array($userRole, array_map('intval', $roles))) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permiso para acceder a esta página.'
                ], 403);
            }
            abort(403, 'No tienes permiso para acceder a esta página.');
        }

        // Bloquear métodos de escritura para roles 2 y 3
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE']) && in_array($userRole, [2, 3])) {
            
            // Si es una petición AJAX, retornar JSON
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permisos para modificar. Solo puedes visualizar esta información.',
                    'title' => 'Acción no permitida'
                ], 403);
            }
            
            // Si es una petición normal, guardar mensaje en sesión y redirigir
            return redirect()->back()->with('error_permission', 'No tienes permisos para modificar. Solo puedes visualizar esta información.');
        }

        return $next($request);
    }
}