<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Citas\Cita;
use App\Models\Usuario;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOTP;

class PaymentController extends Controller
{

    public function stripePayment(Request $request)
    {
        Stripe::setApiKey('sk_test_51QBjVvP7vtejcYNuwyT2TCtIKYowS2TJS9ZLWGx39j0AvQNp3OpTHR35LLisAxF1jiq2dk8TMV7WsLzlaKW4ae2b00T0M88Mnq');
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->total_a_pagar * 100, // Convertir a centavos
                'currency' => 'usd',
                'payment_method' => $request->payment_method_id,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('payment.return'), // Add return URL
            ]);

            if ($paymentIntent->status == 'requires_action' && $paymentIntent->next_action->type == 'use_stripe_sdk') {
                return response()->json([
                    'requires_action' => true,
                    'payment_intent_client_secret' => $paymentIntent->client_secret
                ]);
            } else if ($paymentIntent->status == 'succeeded') {
                // Actualizar el saldo del usuario
                $this->actualizarSaldo($request->user_id, $request->total_a_pagar);
                // Añadir mensaje de éxito a la sesión
                session()->flash('success', '¡Tu saldo ha sido actualizado con éxito!');
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => 'Invalid PaymentIntent status']);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function stripePaymentService(Request $request){
        Stripe::setApiKey('sk_test_51QBjVvP7vtejcYNuwyT2TCtIKYowS2TJS9ZLWGx39j0AvQNp3OpTHR35LLisAxF1jiq2dk8TMV7WsLzlaKW4ae2b00T0M88Mnq');
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->total_a_pagar * 100, // Convertir a centavos
                'currency' => 'usd',
                'payment_method' => $request->payment_method_id,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('payment.return'), // Add return URL
            ]);

            if ($paymentIntent->status == 'requires_action' && $paymentIntent->next_action->type == 'use_stripe_sdk') {
                return response()->json([
                    'requires_action' => true,
                    'payment_intent_client_secret' => $paymentIntent->client_secret
                ]);
            } else if ($paymentIntent->status == 'succeeded') {
                session()->flash('success', '¡El pago de ' . $request->servicio . ' ha sido realizado con éxito!');
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => 'Invalid PaymentIntent status']);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    

    //Pago con OpenNode
    public function openNodePayment(Request $request)
    {
        $id_usuario = $request->id_usuario;
        $monto = $request->monto;

        $this->actualizarSaldo($id_usuario, $monto);
        session()->flash('success', '¡Tu saldo ha sido actualizado con éxito!');
        return response()->json(['success' => true]);

    }

    public function paymentReturn()
    {
        return view('services');
    }

    private function actualizarSaldo($id_user, $monto)
    {
        $usuario = Usuario::find($id_user);
        $wallet = Wallet::where('id_usuario', $usuario->id_usuario)->first();
        $wallet->saldo += $monto;
        $wallet->save();
    }

    public function paymentWallet(Request $request)
    {
        $id_usuario = $request->id_usuario;
        $monto = $request->monto;
        $servicio = $request->servicio;

        $usuario = Usuario::find($id_usuario);
        $wallet = Wallet::where('id_usuario', $usuario->id_usuario)->first();
        $wallet->saldo -= $monto;
        $wallet->save();
        session()->flash('success', '¡El pago de '. $servicio .' ha sido realizado con éxito!');
        return response()->json(['success' => true]);
    }


    public function generateAndSendOTP(Request $request)
    {
        $request->id_usuario;
        $usuario = Usuario::find($request->id_usuario);
        
        // Generar un código OTP de 6 dígitos
        $otp = rand(100000, 999999);

        // Guardar el OTP y la fecha de expiración en el usuario
        $usuario->otp = $otp;
        $usuario->otp_expires_at = Carbon::now()->addMinutes(5); // Expira en 5 minutos
        $usuario->save();

        // Enviar el OTP al correo electrónico del usuario
        Mail::to($usuario->correo)->send(new SendOTP($otp));
        return response()->json(['success' => true, 'message' => 'El codigo otp ha sido enviado a tu correo.']);
    }

    public function verifyOTP(Request $request)
    {
        $otp = $request->codigo_otp;
        // Obtener el usuario que está en sesión para verificación OTP
        $usuarioId = request()->id_usuario;
    
        $usuario = Usuario::find($usuarioId);
    
        // Asegurarse de que otp_expires_at sea un objeto Carbon
        if (!($usuario->otp_expires_at instanceof Carbon)) {
            $usuario->otp_expires_at = Carbon::parse($usuario->otp_expires_at);
        }
    
        // Verificar que el OTP sea correcto y no haya expirado
        if ($usuario->otp == $otp && $usuario->otp_expires_at->isFuture()) {
            // Limpiar el OTP y la expiración
            $usuario->otp = null;
            $usuario->otp_expires_at = null;
            $usuario->save();
            return response()->json(['success' => true, 'message' => 'El codigo otp ha sido verificado con exito.']);
        } else {
            return response()->json(['error' => 'El código OTP es incorrecto o ha expirado.']);
        }
    }



}
