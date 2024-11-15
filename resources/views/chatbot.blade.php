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
        <p class="informacion-chatbot">Descubre la forma más rápida y sencilla de realizar pagos de servicios esenciales 
            con nuestro Bot de PagoMovilES en Telegram. Diseñado para guiarte paso a paso en el proceso de pago, este bot 
            está disponible las 24 horas, los 7 días de la semana, permitiéndote pagar tus facturas de electricidad, agua y 
            teléfono, etc de manera segura y sin complicaciones, ¡todo en cuestión de segundos!.</p>
        <a href="https://t.me/pagomoviles_bot" class="btn btn-telegram">Ir al Chatbot</a>
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