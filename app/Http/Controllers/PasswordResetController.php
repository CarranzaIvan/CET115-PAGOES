<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Usuario; // Usa tu modelo de usuarios
use App\Models\PasswordResetToken;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    // Muestra el formulario para solicitar el reset
    public function showRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Procesa la solicitud de reset
    public function sendResetLink(Request $request)
    {
        $request->validate(['correo' => 'required|email']);

        $usuario = Usuario::where('correo', $request->correo)->first();

        if (!$usuario) {
            return back()->withErrors(['correo' => 'No encontramos un usuario con ese correo.']);
        }

        $token = Str::random(60);
        PasswordResetToken::updateOrCreate(
            ['email' => $usuario->correo], // Usa 'email' como clave de búsqueda
            ['token' => $token, 'created_at' => Carbon::now()]
        );


        Mail::send('emails.password_reset', ['token' => $token], function ($message) use ($usuario) {
            $message->to($usuario->correo);
            $message->subject('Recuperación de Contraseña');
        });

        return back()->with('status', 'Enlace de recuperación enviado a su correo.');
    }

    // Muestra el formulario para resetear la contraseña
    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    // Procesa el cambio de contraseña
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'correo' => 'required|email',
            'contraseña' => 'required|confirmed|min:6',
        ]);

        $passwordReset = PasswordResetToken::where('token', $request->token)
            ->where('email', $request->correo)
            ->first();

        if (!$passwordReset || Carbon::parse($passwordReset->created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors(['correo' => 'El token es inválido o ha expirado.']);
        }

        $usuario = Usuario::where('correo', $request->correo)->first();
        if ($usuario) {
            $usuario->contraseña = Hash::make($request->contraseña);
            $usuario->save();

            // Elimina el token de restablecimiento para evitar reutilización
            $passwordReset->delete();

            return redirect()->route('login.form')->with('status', 'Contraseña actualizada.');
        }

        return back()->withErrors(['correo' => 'No se encontró un usuario con ese correo.']);
    }
}
