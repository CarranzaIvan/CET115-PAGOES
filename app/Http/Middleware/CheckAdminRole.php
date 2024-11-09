<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckAdminRole
{

    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $usuario = Auth::user();
            Log::info('Middleware ejecutado', ['user' => $usuario]);
    
            if ($usuario->id_rol === 1) {
                return $next($request);
            } else {
                return redirect()->route('inicio')->with('error', 'Acceso denegado.');
            }
        }
    
        Log::info('Usuario no autenticado');
        return redirect()->route('login');
    }
    
}
