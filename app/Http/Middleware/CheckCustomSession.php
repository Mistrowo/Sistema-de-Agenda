<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckCustomSession
{
    /**
     * Handle an incoming request.
     
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $usuario = $request->session()->get('usuario','ROL');
        
    
        if (!$usuario) {
            Log::info('Usuario no autenticado, redirigiendo al inicio de sesión.', ['url' => $request->url()]);
           
            return redirect()->route('inicio');
        }
    
        return $next($request);
    }
    
}

