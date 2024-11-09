<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Api;

class BotController extends Controller
{
    protected $telegram;

    public function __construct()
    {
        $this->telegram = new Api('7595311454:AAEDtJtrJUEu6NxK3gtxSRzbWau9YKgMnHo');
    }

    public function handleWebhook(Request $request)
    {
        $update = $this->telegram->getWebhookUpdates();

        $chatId = $update->getMessage()->getChat()->getId();
        $text = $update->getMessage()->getText();

        // Aquí puedes manejar diferentes comandos o mensajes
        if ($text == '/start') {
            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => '¡Bienvenido a nuestro bot de Telegram!'
            ]);
        } else {
            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'No entiendo ese comando.'
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}
