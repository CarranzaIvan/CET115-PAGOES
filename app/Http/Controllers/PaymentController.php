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
    public function payPalPayment(Request $request)
    {
        // Lógica para manejar el pago con PayPal
        try {
            // Actualizar el estado de la cita
            $this->actualizarCita($request->cita_id);
            return response()->json(['success' => true]);
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

    // Método para manejar el callback de pagos de criptomonedas
    public function cryptoPaymentCallback(Request $request)
    {
        try {
            $chargeId = $request->input('charge_id');
            $apiKey = env('COINBASE_API');

            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', "https://api.commerce.coinbase.com/charges/{$chargeId}", [
                'headers' => [
                    'X-CC-Api-Key' => $apiKey,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $chargeData = json_decode($response->getBody(), true);

            if ($chargeData['data']['timeline'][0]['status'] === 'COMPLETED') {
                $cita_id = $request->input('cita_id');
                $this->actualizarCita($cita_id);
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => 'Payment not completed']);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
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
}
