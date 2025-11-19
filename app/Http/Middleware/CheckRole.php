<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$role): Response
    {
       

    $usuario = $request->session()->get('usuario');


    if ($usuario->ROL != $role) // Si el usuario no tiene el rol requerido, redirigir a una página de error o donde prefieras
        return redirect(route('inicio'));

    return $next($request);
}



    }

