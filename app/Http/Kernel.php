<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Las capas de middleware global de la aplicación.
     */
    protected $middleware = [
        // Otros middlewares globales aquí...
    ];

    /**
     * Las capas de middleware para grupos de rutas.
     */
    protected $middlewareGroups = [
        'web' => [
            // Middlewares de las rutas web...
	    \App\Http\Middleware\VerifyCsrfToken::class,
        ],

        'api' => [
            // Middlewares de las rutas API...
        ],
    ];

    /**
     * Las capas de middleware de las rutas individuales.
     */
    // app/Http/Kernel.php

    protected $routeMiddleware = [
        // Otros middlewares...
        
        'admin' => \App\Http\Middleware\CheckAdminRole::class,
    ];
}
