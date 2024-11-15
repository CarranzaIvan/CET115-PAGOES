<?php
require '../vendor/autoload.php';

$token = '8137876917:AAFyuuoH2P6OTWKOi8HmPkL-xTNYlgfHEuQ';
$apiURL = "https://api.telegram.org/bot$token/";

$client = new \GuzzleHttp\Client();

// Datos de conexión a la base de datos
define('SERVIDOR', 'pagomoviles_db');
define('USUARIO', 'pagomoviles_user');
define('PASSWORD', 'admin123');
define('BD', 'pagomovil_es');

$servidor = "mysql:dbname=" . BD . ";host=" . SERVIDOR;

try {
    $pdo = new PDO($servidor, USUARIO, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    echo "Connection successful!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
    echo "Connection failed!";
}

// Obtener las actualizaciones del bot
$update = file_get_contents("php://input");
$updateArray = json_decode($update, true);

if (isset($updateArray["message"])) {
    $chatId = $updateArray["message"]["chat"]["id"];
    $message = $updateArray["message"]["text"];

    // Responder al mensaje recibido
    if ($message == "/start") {
        $message = "¡Bienvenido al bot de PagoMovilES! ¿En qué puedo ayudarte? \n - Realizar pago /pagar \n - Ayuda /ayuda";
        sendMessage($chatId, $message);
    } else if ($message == "/pagar") {
        $message = "Por favor digita tu correo electrónico para continuar";
        sendMessage($chatId, $message);
    } else if (filter_var($message, FILTER_VALIDATE_EMAIL)) {
        //guardar correo en la base de datos
        $email = $message;
        //verificar si el correo esta asociado a un usuario
        $query = "SELECT * FROM usuarios WHERE correo = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            // Verificar si el correo ya existe en la base de datos
            $query = "SELECT * FROM variables WHERE id = :chatId";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':chatId', $chatId);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                // Si el correo ya existe, actualizarlo
                $query = "UPDATE variables SET correo = :email , servicio = 'n/a', monto = 0 WHERE id = :chatId";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':chatId', $chatId);
                if ($stmt->execute()) {
                    $message = "Selecciona el servicio que deseas pagar \n - Luz /luz \n - Agua /agua \n - Teléfono /telefono \n - Internet /internet";
                    sendMessage($chatId, $message);
                } else {
                    $message = "Hubo un error al actualizar tu correo. Por favor, intenta nuevamente.";
                    sendMessage($chatId, $message);
                }
            } else {
                $servicio = "n/a";
                $monto = 0;
                // Si el correo no existe, insertarlo
                $query = "INSERT INTO variables (id, correo, servicio, monto) VALUES (:chatId, :email, :servicio, :monto)";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':chatId', $chatId);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':servicio', $servicio);
                $stmt->bindParam(':monto', $monto);
                if ($stmt->execute()) {
                    $message = "Selecciona el servicio que deseas pagar \n - Luz /luz \n - Agua /agua \n - Teléfono /telefono \n - Internet /internet";
                    sendMessage($chatId, $message);
                } else {
                    $message = "Hubo un error al registrar tu correo. Por favor, intenta nuevamente.";
                    sendMessage($chatId, $message);
                }
            }
        } else {

            $message = "El correo no esta asociado a ningun usuario.";
            sendMessage($chatId, $message);
        }
    } else if ($message == "/luz" || $message == "/agua" || $message == "/telefono" || $message == "/internet") {
        //guardar servicio en la base de datos
        $servicio = ltrim($message, '/');
        // Verificar si el servicio ya existe en la base de datos
        $query = "SELECT * FROM variables WHERE id = :chatId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':chatId', $chatId);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            // Si el servicio ya existe, actualizarlo
            $query = "UPDATE variables SET servicio = :servicio WHERE id = :chatId";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':servicio', $servicio);
            $stmt->bindParam(':chatId', $chatId);
            if ($stmt->execute()) {
                $message = "Por favor digita el monto a pagar";
                sendMessage($chatId, $message);
            } else {
                $message = "Hubo un error al actualizar tu servicio. Por favor, intenta nuevamente.";
                sendMessage($chatId, $message);
            }
        } else {
            $message = "No has proporcionado un correo electrónico.";
            sendMessage($chatId, $message);
        }
    } else if (is_numeric($message)) {
        //guardar monto en la base de datos
        $monto = $message;
        //verificar si el monto es mayor a 0
        if ($monto > 0) {
            // Verificar si el monto ya existe en la base de datos
            $query = "SELECT * FROM variables WHERE id = :chatId";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':chatId', $chatId);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                // Si el monto ya existe, actualizarlo
                $query = "UPDATE variables SET monto = :monto WHERE id = :chatId";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':monto', $monto);
                $stmt->bindParam(':chatId', $chatId);
                if ($stmt->execute()) {
                    $query = "SELECT * FROM variables WHERE id = :chatId";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':chatId', $chatId);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    $message = "Por favor confirma tu pago \n Correo: " . $row['correo'] . "\n Servicio: " . $row['servicio'] . "\n Monto: " . $row['monto'] . "\n ¿Deseas confirmar tu pago? \n /confirmar \n /cancelar";
                    sendMessage($chatId, $message);
                } else {
                    $message = "Hubo un error al actualizar tu monto. Por favor, intenta nuevamente.";
                    sendMessage($chatId, $message);
                }
            } else {
                $message = "No has proporcionado un correo electrónico.";
                sendMessage($chatId, $message);
            }
        } else {
            $message = "Por favor digita un monto mayor a 0.";
            sendMessage($chatId, $message);
        }
    } else if ($message == "/confirmar") {
        // Verificar si el pago ya existe en la base de datos
        $query = "SELECT * FROM variables WHERE id = :chatId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':chatId', $chatId);
        $stmt->execute();
        $valores = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT nombre_completo FROM usuarios WHERE correo = :correo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':correo', $valores['correo']);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        $response = $client->request('POST', 'https://api.opennode.com/v1/charges', [
            'body' => '{
            "amount": ' . $valores['monto'] . ',
            "currency": "USD",
            "description": "Pago de ' . $valores['servicio'] . '",
            "callback_url": "https://bot.pagoes.line.pm/bot.php",
            "customer_name": "' . $usuario['nombre_completo'] . '",
            "customer_email": "' . $valores['correo'] . '",
            "order_id": "' . $chatId . '+' . time() . '",
            "notify_receiver": true
            }',
            'headers' => [
                'Content-Type' => 'application/json',
                'accept' => 'application/json',
                'Authorization' => '73123932-1bf0-415e-b03a-b01a39b62cf9'
            ],
        ]);
        $response = json_decode($response->getBody(), true);


        //extrer el lightning_invoice
        $lightning_invoice = $response['data']['lightning_invoice']['payreq'];

        //convertir a mayusculas
        $lightning_invoice = strtoupper($lightning_invoice);

        $urlQr = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($lightning_invoice);

        //descargar la imagen
        $pathQr = __DIR__ . '/../storage/app/public/' . $chatId . '.png';
        file_put_contents($pathQr, file_get_contents($urlQr));

        $detalles = "Los detalles de tu pago son: \n Correo: " . $valores['correo'] . "\n Servicio: " . $valores['servicio'] . "\n Monto: " . $valores['monto'] . "\n\n Escanea el código QR para realizar tu pago.";
        //enviar la imagen
        sendPhoto($chatId, $detalles, $pathQr);
        
    } else if ($message == "/cancelar") {
        $query = "DELETE FROM variables WHERE id = :chatId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':chatId', $chatId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $message = "Tu pago ha sido cancelado, hemos eliminado tus datos.";
            sendMessage($chatId, $message);
        } else {
            $message = "No hay registro de pago para cancelar.";
            sendMessage($chatId, $message);
        }
    } else if ($message == "/ayuda") {
        $message = "¡Bienvenido al bot de PagoMovilES! \n Para realizar un pago debes de seguir las siguientes instrucciones: \n\n 1. Digita /pagar \n 2. Ingresa tu correo electrónico \n 3. Selecciona el servicio a pagar \n 4. Ingresa el monto a pagar \n 5. Confirma tu pago";
        sendMessage($chatId, $message);
    } else {
        $message = "Respuesta no válida. Por favor, intenta nuevamente.";
        sendMessage($chatId, $message);
    }
}

// Enviar un mensaje con un teclado personalizado
function sendMessageWithKeyboard($chatId, $message, $keyboard)
{
    global $apiURL;
    $url = $apiURL . "sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message) . "&reply_markup=" . json_encode($keyboard);
    file_get_contents($url);
}

// Enviar un mensaje simple
function sendMessage($chatId, $message)
{
    global $apiURL;
    $url = $apiURL . "sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message);
    file_get_contents($url);
}

// Enviar una foto desde un archivo local
function sendPhoto($chatId, $caption, $pathPhoto)
{
    global $apiURL;
    $url = $apiURL . "sendPhoto";

    $post_fields = [
        'chat_id' => $chatId,
        'caption' => $caption,
        'photo' => new CURLFile(realpath($pathPhoto))
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    $output = curl_exec($ch);
    curl_close($ch);

    return $output;
}

//enviar foto desde una url
function sendPhotoFromUrl($chatId, $caption, $urlPhoto)
{
    global $apiURL;
    $url = $apiURL . "sendPhoto?chat_id=" . $chatId . "&caption=" . urlencode($caption) . "&photo=" . $urlPhoto;
    file_get_contents($url);
}
