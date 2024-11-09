@extends('layout.app')
@section('title', 'Ir al chatbot')

@section('custom_css')
    <link rel="stylesheet" href="{{ asset('css/bienvenida.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}">

@endsection

@section('content')
    <div class="container-fluid d-flex align-items-center justify-content-between mt-5">
        <div class="text-right">
            <h1 class="font-weight-bold colorEstandarTexto">Descubre nuestro Bot de Telegram</h1>
            <p class="informacion-chatbot">Descubre la forma más rápida y fácil de resolver tus dudas sobre nuestro servicio
                de carwash a domicilio con nuestro Bot de Consultas en Telegram. Diseñado para responder automáticamente las
                preguntas más comunes, este bot está disponible las 24 horas, los 7 días de la semana, para brindarte la
                información que necesitas en cuestión de segundos.</p>
            <a href="https://t.me/shinego_bot" class="btn btn-telegram">Ir al Chatbot</a>
            <!-- Cambia la URL al enlace de tu chatbot -->
        </div>
        <img src="{{ asset('images/telegram.png') }}" alt="Logo de Telegram" class="logo-telegram">
        <!-- Cambia la ruta por la de tu logo -->
    </div>

    @if (session('success'))
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

    @if ($errors->any())
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
