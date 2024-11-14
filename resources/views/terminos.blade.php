@extends('layout.app')
@section('title', 'Terminos y Condiciones')

@section('custom_css')
    <link rel="stylesheet" href="{{ asset('css/terminos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bienvenida.css') }}">

@endsection

@section('content')

    <div class="container text-center">
        <!-- Encabezado de Servicios -->
        <h1 class="font-weight-bold colorEstandarTexto mb-4">Terminos y condiciones</h1>
    </div>

    <div class="container text-wrap">
        <h3 class="text-black font-weight-black mb-1">
            Información General
        </h3>
        <h4 class="text-black font-weight-light mb-4">
            <strong class="text-black">Pago Móvil ES </strong>es una plataforma diseñada para facilitar pagos electrónicos en El Salvador, permitiendo a los comerciantes aceptar pagos mediante criptomonedas, tarjetas de crédito y débito de forma accesible y segura. Este sitio web y la aplicación móvil son operados por Pago Móvil ES.
        </h4>
        <h4 class="text-black font-weight-light mb-4">
            A lo largo del sitio, los términos "nosotros", "nuestro" y "Pago Móvil ES" se refieren a la plataforma y sus servicios. Al acceder y utilizar nuestro sitio web y nuestras aplicaciones, aceptas estar sujeto a los términos y condiciones aquí descritos. Si no estás de acuerdo con todos los términos, te recomendamos no utilizar nuestros servicios.
        </h4>
        <h4 class="text-black font-weight-light mb-4">
            Pago Móvil ES se compromete a ofrecer una experiencia de usuario segura y confiable. Nuestro equipo trabaja constantemente en la actualización y mejora de nuestras funciones para cumplir con los estándares de seguridad y accesibilidad que nuestros clientes necesitan. La plataforma cuenta con encriptación avanzada y autenticación de doble factor para proteger todas las transacciones y datos personales.
        </h4>
        <h4 class="text-black font-weight-light mb-4">
            Además, en Pago Móvil ES proporcionamos soporte al cliente 24/7 para atender cualquier duda o incidencia que puedas experimentar durante el uso de nuestros servicios. Puedes contactarnos a través de nuestros canales de atención directa en la aplicación, el sitio web o nuestras redes sociales.
        </h4>
        <h4 class="text-black font-weight-light mb-4">
            Nos reservamos el derecho de realizar cambios en la plataforma, en los servicios ofrecidos, y en estos términos de uso. Cualquier modificación será notificada oportunamente y se verá reflejada en nuestro sitio web y en la aplicación. Tu uso continuado de Pago Móvil ES después de cualquier cambio constituye la aceptación de los términos actualizados.
        </h4>
    </div>
    
    <div class="container">
        <h3 class="text-black font-weight-black mb-1">
            Términos y Condiciones de Pago Móvil ES
        </h3>
        <h4 class="text-black font-weight-light mb-4 text-wrap">
            <ol style="font-weight: bold;">
                <li>
                    <h4 class="h4">Aceptación de los Términos</h4>
                    <p class="lead">
                        Al acceder y utilizar los servicios de Pago Móvil ES, usted acepta estar sujeto a estos Términos y Condiciones, y a las políticas de privacidad aplicables. Si no está de acuerdo con estos términos, no debe utilizar los servicios de Pago Móvil ES.
                    </p>
                </li>
                <li>
                    <h4 class="h4">Descripción del Servicio</h4>
                    <p class="lead">
                        Pago Móvil ES es una plataforma de pagos móviles diseñada para pequeñas y medianas empresas (PyMES) y comerciantes independientes en El Salvador, que permite la aceptación de pagos electrónicos mediante criptomonedas, tarjetas de crédito y débito, sin la necesidad de infraestructura bancaria compleja.
                    </p>
                </li>
                <li>
                    <h4 class="h4">Cuentas de Usuario</h4>
                    <p class="lead">
                        Para utilizar Pago Móvil ES, debe crear una cuenta en la plataforma. Usted es responsable de la exactitud de los datos proporcionados y de mantener la confidencialidad de su información de acceso. Pago Móvil ES se reserva el derecho de suspender o cerrar su cuenta en caso de incumplimiento de estos términos, fraude o uso indebido de la plataforma.
                    </p>
                </li>
                <li>
                    <h4 class="h4">Comisiones y Tarifas</h4>
                    <p class="lead">
                        Pago Móvil ES cobra una comisión por cada transacción procesada en la plataforma. La tasa exacta será visible en el momento de la transacción y podrá ajustarse según las políticas de Pago Móvil ES. Las tarifas pueden incluir costos adicionales para servicios de criptomonedas o integraciones avanzadas, y están sujetas a cambios con notificación previa.
                    </p>
                </li>
                <li>
                    <h4 class="h4">Uso Permitido</h4>
                    <p class="lead">
                        Pago Móvil ES solo podrá ser utilizado para transacciones comerciales legales en El Salvador. El uso de la plataforma para actividades ilícitas resultará en la cancelación inmediata de su cuenta. Usted acepta no utilizar la plataforma para actividades de lavado de dinero, fraude o cualquier otra actividad ilegal o no autorizada.
                    </p>
                </li>
                <li>
                    <h4 class="h4">Responsabilidades y Limitaciones</h4>
                    <p class="lead">
                        Pago Móvil ES no se hace responsable por pérdidas directas o indirectas derivadas del uso de la plataforma, incluidas pérdidas financieras por interrupciones en el servicio, problemas técnicos o fraude de terceros. La plataforma se compromete a implementar medidas de seguridad avanzadas; sin embargo, el usuario es responsable de mantener la seguridad de sus dispositivos y credenciales de acceso.
                    </p>
                </li>
                <li>
                    <h4 class="h4">Soporte Técnico y Mantenimiento</h4>
                    <p class="lead">
                        Pago Móvil ES ofrece soporte técnico 24/7, disponible a través de nuestros canales de atención en la aplicación y sitio web. La plataforma puede estar sujeta a mantenimientos programados, que serán notificados previamente. No nos hacemos responsables de interrupciones causadas por eventos fuera de nuestro control.
                    </p>
                </li>
                <li>
                    <h4 class="h4">Modificaciones de los Términos</h4>
                    <p class="lead">
                        Pago Móvil ES se reserva el derecho de modificar estos Términos y Condiciones en cualquier momento. Los cambios serán notificados a través de la plataforma, y su uso continuado de la plataforma implica la aceptación de los mismos.
                    </p>
                </li>
                <li>
                    <h4 class="h4">Jurisdicción y Ley Aplicable</h4>
                    <p class="lead">
                        Estos términos se rigen por las leyes de El Salvador. Cualquier disputa será sometida a la jurisdicción de los tribunales locales.
                    </p>
                </li>
            </ol>
        </h4>
    </div>
    

@endsection
