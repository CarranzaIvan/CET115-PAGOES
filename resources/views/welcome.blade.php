@extends('layout.app')
@section('title', 'Bienvenido')

@section('custom_css')
    <link rel="stylesheet" href="{{ asset('css/bienvenida.css') }}">
@endsection

@section('content')

    <!-- Sección de Imagen de cabecera con botón -->
    <div class="container-fluid header-section">
        <img style="width: 1010px; height: 350px;" src="{{ asset('images/fondo.png') }}" alt="Carwash Image" class="header-image">
        
    </div>

    <!-- Sección de Beneficios -->
    <div class="container text-center mt-5">
        <h1 class="font-weight-bold colorEstandarTexto">Nuestros Beneficios</h1>
        <h5 class="text-black font-weight-light">Pago Móvil ES permite a los comerciantes en El Salvador aceptar pagos electrónicos de manera rápida, segura y accesible, mejorando la experiencia del cliente y ampliando las opciones de pago.</h5>
    </div>

    <!-- Tarjetas de Beneficios -->
    <div class="container mt-4 md-3">
        <div class="row text-center">
            <div class="col-md-3 d-flex align-items-stretch beneficio-item">
                <div class="card shadow-sm rounded-4 p-3 w-100">
                    <img src="{{ asset('images/comodidad.jpg') }}" alt="Comodidad" class="img-fluid">
                    <h4 class="mt-3">Comodidad</h4>
                    <p class="font-weight-normal">Centraliza y facilita el proceso de pago electrónico en una sola plataforma.</p>
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-stretch beneficio-item">
                <div class="card shadow-sm rounded-4 p-3 w-100">
                    <img src="{{ asset('images/calidad.jpg') }}" alt="Calidad" class="img-fluid">
                    <h4 class="mt-3">Calidad</h4>
                    <p class="font-weight-normal">Ofrece altos estándares de seguridad y soporte 24/7 para una experiencia confiable y satisfactoria.</p>
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-stretch beneficio-item">
                <div class="card shadow-sm rounded-4 p-3 w-100">
                    <img src="{{ asset('images/rapidez.jpg') }}" alt="Rapidez" class="img-fluid">
                    <h4 class="mt-3">Rapidez</h4>
                    <p class="font-weight-normal">Permite realizar transacciones instantáneas y seguras dando respuestas a tiempos promediosc.</p>
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-stretch beneficio-item">
                <div class="card shadow-sm rounded-4 p-3 w-100">
                    <img src="{{ asset('images/flexibilidad.jpg') }}" alt="Flexibilidad" class="img-fluid">
                    <h4 class="mt-3">Flexibilidad</h4>
                    <p class="font-weight-normal">Acepta diversos métodos de pago, incluyendo criptomonedas y tarjetas de crédito y débito.</p>
                </div>
            </div>
        </div>
    </div>


@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000
        });
    });
</script>
@endif

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ $errors->first() }}",
            showConfirmButton: true,
        });
    });
</script>
@endif

@endsection
