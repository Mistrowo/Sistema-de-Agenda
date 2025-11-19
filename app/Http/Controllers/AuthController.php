<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login1(Request $request)
    {
        $credentials = [
            'email' => $request->input('EMAIL'),
            'password' => $request->input('CONTRASENA')
        ];
    
        Log::info('Intento de inicio de sesión', ['EMAIL' => $credentials['email']]);
    
        if (Auth::attempt($credentials)) {
            Log::info('Usuario en sesión', ['user' => Auth::user()]);
            Log::info('Redirigiendo al dashboard');
    
            $usuario = Auth::user();
    
            session([
                'usuario' => $usuario,
                'fecha' => Carbon::now()->toDateString()
            ]);

            $request->session()->put('usuario', $usuario);
    
            if ($usuario->ROL == 1) {
                return redirect()->route('calendario');
            } if ($usuario->ROL == 2) {
                return redirect()->route('calendario4');
            } if ($usuario->ROL == 3){
                return redirect()->route('calendario3');
            }
    
        } else {
            Log::warning('Falló el inicio de sesión', ['EMAIL' => $credentials['email']]);
    
            // Aquí es donde puedes llamar a tu middleware
            $request->session()->put('failed_login', true);
            
            return back()->withErrors([
                'password' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
                'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            ]);
        }
    }
    
    
    

    public function logout()
{
    Log::info('Cierre de sesión del usuario', ['user' => Auth::user()]);
    
    Auth::logout();

     request()->session()->invalidate();
     request()->session()->regenerateToken();

    return redirect('/'); 
}

}


