@extends('layout.app')
@section('title', 'Bienvenido')

@section('custom_css')
    <link rel="stylesheet" href="{{ asset('css/bienvenida.css') }}">
@endsection

@section('content')

    <!-- Sección de Imagen de cabecera con botón -->
    <div class="container-fluid header-section">
        <img src="{{ asset('images/fondo.png') }}" alt="Carwash Image" class="header-image">
        
    </div>

    <!-- Sección de Beneficios -->
    <div class="container text-center mt-5">
        <h1 class="font-weight-bold colorEstandarTexto">Nuestros Beneficios</h1>
        <h5 class="text-black font-weight-light">En Shine&Go nos enfocamos en brindarte un servicio de carwash a domicilio que se adapte a tu estilo de vida, ofreciéndote comodidad, calidad, rapidez y flexibilidad.</h5>
    </div>

    <!-- Tarjetas de Beneficios -->
    <div class="container mt-4">
        <div class="row text-center">
            <div class="col-md-3 beneficio-item">
                <div class="card shadow-sm rounded-4 p-3">
                    <img src="{{ asset('images/comodidad.jpg') }}" alt="Comodidad" class="img-fluid">
                    <h4 class="mt-3">Comodidad</h4>
                    <p class="font-weight-normal">Nosotros vamos donde tú estés</p>
                </div>
            </div>
            <div class="col-md-3 beneficio-item">
                <div class="card shadow-sm rounded-4 p-3">
                    <img src="{{ asset('images/calidad.jpg') }}" alt="Calidad" class="img-fluid">
                    <h4 class="mt-3">Calidad</h4>
                    <p class="font-weight-normal">Usamos productos premium y técnicas profesionales</p>
                </div>
            </div>
            <div class="col-md-3 beneficio-item">
                <div class="card shadow-sm rounded-4 p-3">
                    <img src="{{ asset('images/rapidez.png') }}" alt="Rapidez" class="img-fluid">
                    <h4 class="mt-3">Rapidez</h4>
                    <p class="font-weight-normal">Usamos productos premium y técnicas profesionales</p>
                </div>
            </div>
            <div class="col-md-3 beneficio-item">
                <div class="card shadow-sm rounded-4 p-3">
                    <img src="{{ asset('images/flexibilidad.jpg') }}" alt="Flexibilidad" class="img-fluid">
                    <h4 class="mt-3">Flexibilidad</h4>
                    <p class="font-weight-normal">Agenda el horario que más te convenga</p>
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
