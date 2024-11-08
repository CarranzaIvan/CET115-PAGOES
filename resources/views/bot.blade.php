<?php
$token = '7595311454:AAEDtJtrJUEu6NxK3gtxSRzbWau9YKgMnHo';
$apiURL = "https://api.telegram.org/bot$token/";

// Obtener el contenido de la solicitud
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
    exit;
}


// Obtener el ID del chat y el mensaje enviado
$chatId = $update['message']['chat']['id'];
$message = $update['message']['text'];

// Procesar el mensaje y enviar una respuesta
$responseMessage = "You said: " . $message;
sendMessage($chatId, $responseMessage);

function sendMessage($chatId, $message) {
    global $apiURL;
    $url = $apiURL . "sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message);
    file_get_contents($url);
}

?>
