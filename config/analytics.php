<?php

return [

    /*
     * La URL de tu servidor Matomo (sin la barra al final).
     */
    'url' => env('MATOMO_URL', "https://pagoeslinepm.matomo.cloud/"),

    /*
     * El ID del sitio en Matomo que deseas rastrear.
     */
    'site_id' => env('MATOMO_SITE_ID', '1'),

    /*
     * El token de acceso para la API de Matomo.
     * Puedes encontrar este token en la configuración de tu usuario en Matomo.
     */
    'token' => env('MATOMO_API_TOKEN', 'YOUR_MATOMO_TOKEN'),
];
