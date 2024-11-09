<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOTP; // Vamos a crear el Mailable SendOTP en el siguiente paso.
use Illuminate\Support\Facades\Session; // Asegúrate de importar la clase Session
use Illuminate\Support\Facades\Log;


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

        // Verificar credenciales sin autenticar al usuario
        $usuario = Usuario::where('correo', $credentials['correo'])->first();

        if ($usuario && Hash::check($credentials['password'], $usuario->contraseña)) {
            // Generar y enviar el OTP
            $this->generateAndSendOTP($usuario);

            // Guardar en sesión el ID del usuario que requiere verificación OTP
            session(['otp:user:id' => $usuario->id_usuario]);
            session()->save();
            Log::info('ID del usuario guardado en sesión para OTP:', ['otp:user:id' => session('otp:user:id')]);

            // Redirigir a la página de verificación OTP
            return redirect()->route('verify-otp-form');
        } else {
            return back()->withErrors(['error' => 'Correo o contraseña incorrectos.']);
        }
    }

    public function generateAndSendOTP($usuario)
    {
        // Generar un código OTP de 6 dígitos
        $otp = rand(100000, 999999);

        // Guardar el OTP y la fecha de expiración en el usuario
        $usuario->otp = $otp;
        $usuario->otp_expires_at = Carbon::now()->addMinutes(5); // Expira en 5 minutos
        $usuario->save();

        // Enviar el OTP al correo electrónico del usuario
        Mail::to($usuario->correo)->send(new SendOTP($otp));
    }

    public function showVerifyOTPForm()
    {
        return view('auth.verify-otp');
    }

    public function verifyOTP(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);
    
        // Obtener el usuario que está en sesión para verificación OTP
        $usuarioId = session('otp:user:id');
        Log::info('Usuario en sesión:', ['otp:user:id' => $usuarioId]);
    
        $usuario = Usuario::find($usuarioId);
        // Verificar el id usuario despues de iniciar sesion y si solo entras ala url te dara este error ya que no a obtenido el id del usuario
        if (!$usuario) {
            return redirect()->route('login.form')->withErrors(['error' => 'Usuario no encontrado.']);
        }
    
        // Asegurarse de que otp_expires_at sea un objeto Carbon
        if (!($usuario->otp_expires_at instanceof Carbon)) {
            $usuario->otp_expires_at = Carbon::parse($usuario->otp_expires_at);
        }
        // Verificar si el OTP ya fue usado o ha expirado
        if (is_null($usuario->otp) || !$usuario->otp_expires_at->isFuture()) {
            return redirect()->route('login.form')->withErrors(['error' => 'El código OTP ya fue usado o ha expirado.']);
        }
        // Registrar para depuración
        Log::info('OTP esperado:', ['otp' => $usuario->otp]);
        Log::info('OTP ingresado:', ['otp' => $request->otp]);
        Log::info('Fecha de expiración:', ['otp_expires_at' => $usuario->otp_expires_at]);
    
        // Verificar que el OTP sea correcto y no haya expirado
        if ((string) $usuario->otp === (string) $request->otp && $usuario->otp_expires_at->isFuture()) {
            // Limpiar el OTP y la expiración
            $usuario->otp = null;
            $usuario->otp_expires_at = null;
            $usuario->save();
    
            // Iniciar sesión en la aplicación usando el objeto de usuario después de verificar el OTP
            Auth::login($usuario);
            session()->forget('otp:user:id');
    
            // Redirigir basado en el id_rol
            if ($usuario->id_rol == 1) {
                return redirect()->route('dashboard')->with('success', 'Bienvenido al panel de administración.');
            } elseif ($usuario->id_rol == 2) {
                return redirect()->route('inicio')->with('success', 'Inicio de sesión exitoso.');
            }
        } else {
            return redirect()->route('verify-otp-form')->withErrors(['error' => 'Código OTP incorrecto o expirado.']);
        }
    }
    
}
