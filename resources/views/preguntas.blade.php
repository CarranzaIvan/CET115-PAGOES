@extends('layout.app')
@section('title', 'Preguntas Frecuentes')

@section('custom_css')
    <link rel="stylesheet" href="{{ asset('css/bienvenida.css') }}">
@endsection

@section('content')

    <div class="container text-center">
        <!-- Encabezado de Servicios -->
        <h1 class="font-weight-bold colorEstandarTexto mb-4">¿Cómo podemos ayudarte?</h1>
        <div class="input-group mb-3 input-group-lg">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
            </div>
            <input id="searchInput" placeholder="Ingresa la duda que tienes..." type="text" class="form-control" aria-label="search" aria-describedby="basic-addon1">
        </div>
        <h2 class="font-weight-bold mb-4">Preguntas Destacadas</h2>
        <hr class="mb-4" style="border-top: 2px solid #000;">
    </div>

    <div class="container text-center">
        <div class="row">
            <!-- Columna 1 -->
            <div class="col-md-6">
                @foreach($preguntas as $index => $pregunta)
                    @if($index % 2 == 0) <!-- Columna izquierda -->
                        <div class="mb-4 question-item">
                            <h4 class="text-black font-weight-black mb-1">{{ $pregunta->pregunta }}</h4>
                            <h5 class="text-black font-weight-light mb-4">{{ $pregunta->respuesta }}</h5>
                        </div>
                        <hr>
                    @endif
                @endforeach
            </div>
        
            <!-- Columna 2 -->
            <div class="col-md-6">
                @foreach($preguntas as $index => $pregunta)
                    @if($index % 2 != 0) <!-- Columna derecha -->
                        <div class="mb-4 question-item">
                            <h4 class="text-black font-weight-black mb-1">{{ $pregunta->pregunta }}</h4>
                            <h5 class="text-black font-weight-light mb-4">{{ $pregunta->respuesta }}</h5>
                        </div>
                        <hr>
                    @endif
                @endforeach
            </div>
        </div>
	<div class="text-right">
                <a href="{{ route('verChatbot') }}" class="btn btn-primary">
                    <i class="bi bi-telegram"></i> Más consultas
                </a>
            </div>        
    </div>
@endsection

@push('custom_js')
    <script src="{{ asset('js/preguntas.js') }}"></script>
@endpush
