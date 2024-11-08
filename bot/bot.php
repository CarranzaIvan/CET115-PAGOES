<?php

$token = '7595311454:AAEDtJtrJUEu6NxK3gtxSRzbWau9YKgMnHo';
$apiURL = "https://api.telegram.org/bot$token/";

// Datos de conexión a la base de datos
define('SERVIDOR', 'shinygo_db');
define('USUARIO', 'shinygo_user');
define('PASSWORD', 'admin123');
define('BD', 'ShinyGo');

$servidor = "mysql:dbname=" . BD . ";host=" . SERVIDOR;

try {
    $pdo = new PDO($servidor, USUARIO, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    echo "Connection successful!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
    echo "Connection failed!";
}

$sql = "SELECT s.nomServicio, s.descripcion, s.precio, s.imagen, p.descuento 
        FROM servicios s
        LEFT JOIN promociones p ON s.id = p.servicio_id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);


$horarios = [
    "08:00 - 09:00",
    "09:00 - 10:00",
    "10:00 - 11:00",
    "11:00 - 12:00",
    "13:00 - 14:00",
    "14:00 - 15:00",
    "15:00 - 16:00",
    "16:00 - 17:00"
];


// Obtener el contenido de la solicitud
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
    exit;
}

// Verificar si es un mensaje o una consulta de devolución de llamada
if (isset($update['message'])) {
    // Obtener el ID del chat y el mensaje enviado
    $chatId = $update['message']['chat']['id'];
    $message = $update['message']['text'];

    if (!$message) {
        sendMessage($chatId, "Sorry, I did not understand your message.");
        exit;
    }

    if ($message == '/start') {
        $keyboard = [
            'inline_keyboard' => [
                [['text' => 'Consultar Servicios', 'callback_data' => 'Consultar servicios']],
                [['text' => 'Consultar Disponibilidad', 'callback_data' => 'Consultar disponibilidad']]
            ]
        ];
        sendMessageWithKeyboard($chatId, "Bienvenido al bot de consultas de Shine&Go\n\nSelecciona una opcion:", $keyboard);
    }
    // Verificar si el mensaje es un comando para consultar un servicio
    foreach ($servicios as $servicio) {
        if ($message == '/' . str_replace(' ', '_', $servicio['nomServicio'])) {
            $message = "📛 Nombre: " . $servicio['nomServicio'] . "\n";
            $message .= "📝 Descripción: " . $servicio['descripcion'] . "\n";
            $message .= "💲 Precio: $" . $servicio['precio'] . "\n";
            if($servicio['descuento'] != null) {
                $message .= "🔥 Descuento: " . $servicio['descuento'] . "%\n";
                $message .= "💲 Precio con descuento: $" . number_format(($servicio['precio'] - ($servicio['precio'] * $servicio['descuento'] / 100)), 2) . "\n";
            }
            // Enviar la imagen del servicio
            $pathPhoto = __DIR__ . '/../storage/app/public/' . $servicio['imagen'];
            sendPhoto($chatId, $message, $pathPhoto);
        }
    }

    for($i = 1; $i <= 7; $i++) {
        $fecha = date('Y_m_d', strtotime("+$i day"));
        $fecha2 = date('Y-m-d', strtotime("+$i day"));
        if ($message == "/$fecha") {
            $citas = obtenerCitas($pdo, $fecha2);
            $message = "Citas disponibles para el día $fecha2:\n\n";
            foreach ($horarios as $horario) {
                $ocupado = false;
                foreach ($citas as $cita) {
                    if ($cita['hora_cita'] == $horario) {
                        $ocupado = true;
                        break;
                    }
                }
                if (!$ocupado) {
                    $message .= "✅ $horario\n";
                } else {
                    $message .= "❌ $horario\n";
                }
            }
            sendMessage($chatId, $message);
        }
    }
    
} elseif (isset($update['callback_query'])) {
    // Obtener el ID del chat y los datos de devolución de llamada
    $chatId = $update['callback_query']['message']['chat']['id'];
    $callbackData = $update['callback_query']['data'];

    if ($callbackData == 'Consultar servicios') {
        $message = "Estos son nuestros servicios disponibles:\n\n";
        foreach ($servicios as $servicio) {
            $message .= "✅ " . $servicio['nomServicio'] . "\t\t$" . $servicio['precio'] . "\n";
            $message .= "ℹ️ Más información: /" . str_replace(' ', '_', $servicio['nomServicio']) . "\n\n";
        }

        sendMessage($chatId, $message);
    } elseif ($callbackData == 'Consultar disponibilidad') {
        $message = "Puedes ver las disponibilidades para esta semana: \n\n";
        $daysOfWeek = [];
        for ($i = 1; $i <= 7; $i++) {
            $daysOfWeek[] = "📅 /" . date('Y_m_d', strtotime("+$i day"));
        }
        $message .= implode("\n\n", $daysOfWeek);
        sendMessage($chatId, $message);
    }
}

// Enviar un mensaje con un teclado personalizado
function sendMessageWithKeyboard($chatId, $message, $keyboard) {
    global $apiURL;
    $url = $apiURL . "sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message) . "&reply_markup=" . json_encode($keyboard);
    file_get_contents($url);
}

// Enviar un mensaje simple
function sendMessage($chatId, $message) {
    global $apiURL;
    $url = $apiURL . "sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message);
    file_get_contents($url);
}

// Enviar una foto
function sendPhoto($chatId, $caption, $pathPhoto) {
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

function obtenerCitas($pdo, $fecha) {
    $sql = "SELECT fecha_cita, hora_cita FROM citas WHERE fecha_cita = :fecha";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
