<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();

        // Destruir la sesión completamente para mayor seguridad
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirigir al usuario a la página de inicio o login
        return redirect()->route('login.form')->with('success', 'Sesión cerrada correctamente.');
    }
}
