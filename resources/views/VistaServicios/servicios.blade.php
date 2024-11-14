@extends('layout.app')

@section('title', 'Servicios')

<!-- Aquí se carga el CSS personalizado para esta vista -->
@section('custom_css')
    <link rel="stylesheet" href="{{ asset('css/styleServicio.css') }}">
@endsection

@section('content')
<div aria-live="polite" aria-atomic="true" style="position: relative;">
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <!-- Aquí se generarán los toasts -->
    </div>
</div>

<div class="container text-center">
    <!--ENCABEZADO DE SERVICIOS-->
    <h1 class="font-weight-bold colorEstandarTexto">Selecciona tus servicios...</h1>
    <h5 class="text-black font-weight-light">Agregar a tu carrito los servicios que consideres que son cruciales a tus
        tendencias y aptos para tu cartera.</h5>

    <div class="d-flex justify-content-end mb-4">
        <button class="btn btnVerCarrito">
            <i class="bi bi-cart"></i> Ver carrito  <span id="contadorCarrito" class="badge text-dark">0</span>
        </button>
    </div>
    <!--Listado de servicios-->
    <div class="row">
        @foreach ($servicios as $servicio)
            <x-servicio-card titulo="{{ $servicio->nomServicio }}" precio="{{ $servicio->precio }}"
                descripcion="{{ $servicio->descripcion }}" id_servicio="{{ $servicio->id }}"
                imagen="{{ $servicio->imagen ?? 'images/default.png' }}" />
        @endforeach
    </div>
</div>
@endsection

@push('custom_js')
    <script src="{{ asset('js/carrito.js') }}"></script>
    
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Include Bootstrap JS (para los toasts) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
@endpush
