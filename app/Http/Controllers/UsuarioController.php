<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public function showRegisterForm()
    {
        return view('usuario.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_completo' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:usuarios',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            // Retorna un JSON con los errores para manejarlos en el frontend con SweetAlert
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Usuario::create([
            'id_rol' => 2, // Ajusta según tu lógica
            'nombre_completo' => $request->nombre_completo,
            'correo' => $request->correo,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'contraseña' => Hash::make($request->password),
        ]);

        return response()->json(['success' => true, 'message' => 'Usuario registrado exitosamente. Por favor, inicia sesión.'], 200);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('correo', 'password');

        if (Auth::attempt(['correo' => $credentials['correo'], 'password' => $credentials['password']])) {
            $usuario = Auth::user();

            if ($usuario->id_rol === 1) {
                return redirect()->route('dashboard')->with('success', 'Bienvenido administrador.');
            } else {
                return redirect()->route('inicio')->with('success', 'Bienvenido a la página principal.');
            }
        } else {
            return back()->withErrors(['error' => 'Correo o contraseña incorrectos.']);
        }
    }
}
