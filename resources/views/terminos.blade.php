@extends('layout.app')
@section('title', 'Terminos y Condiciones')

@section('custom_css')
    <link rel="stylesheet" href="{{ asset('css/bienvenida.css') }}">
@endsection

@section('content')

    <div class="container text-center">
        <!-- Encabezado de Servicios -->
        <h1 class="font-weight-bold colorEstandarTexto mb-4">Terminos y condiciones</h1>
    </div>

    <div class="container">
        <h3 class="text-black font-weight-black mb-1">
            Información general
        </h3>
        <h4 class="text-black font-weight-light mb-4">Actualiza, verifica y descarta los servicios vigentes en Shine & Go.
            Este sitio web es operado por Shine&Go. 
            En todo el sitio, los términos "nosotros",
            "nos" y "nuestro" se refieren a Shine&Go.
            Al acceder y utilizar nuestro sitio web y
            nuestros servicios, aceptas los siguientes
            términos y condiciones. Si no estás de acuerdo
            con todos los términos, te recomendamos no
            utilizar nuestros servicios.
        </h4>
    </div>
    <div class="container">
        <h3 class="text-black font-weight-black mb-1">
            Terminos del servicio
        </h3>
        <h4 class="text-black font-weight-light mb-4">
            <ul>
                <li>
                    El servicio de carwash a domicilio de Shine&Go se proporciona en las áreas especificadas en nuestro sitio web.
                </li>
                <li>
                    Nos reservamos el derecho de rechazar cualquier servicio si consideramos que las condiciones no son seguras o adecuadas para realizar el trabajo (e.g., clima adverso o ubicación no accesible).
                </li>
                <li>
                    Shine&Go no se hace responsable de daños preexistentes en los vehículos que atendemos. Recomendamos que informes cualquier daño existente antes de que comience el servicio.
                </li>
            </ul>
        </h4>
    </div>


@endsection
