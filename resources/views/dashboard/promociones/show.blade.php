@extends('dashboard.layout.app_dashboard')

@section('title', 'Ver Promoción')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header" style="background-color: #0D5C75;">
                <h4 class="card-title text-white">Ver promoción</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre"><strong>Nombre de la Promoción</strong></label>
                            <p id="nombre">{{ $promocion->nombrePromocion }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="descuento"><strong>Descuento (%)</strong></label>
                            <p id="descuento">{{ $promocion->descuento }}%</p>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="descripcion"><strong>Descripción</strong></label>
                            <p id="descripcion">{{ $promocion->descripcion }}</p>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="servicio"><strong>Nombre del Servicio</strong></label>
                            <p id="servicio">{{ $promocion->servicio->nomServicio }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_expiracion"><strong>Fecha de Expiración</strong></label>
                            <p id="fecha_expiracion">{{ $promocion->fecha_expiracion }}</p>
                        </div>
                    </div>
                </div>
                <br>
                <div class="d-flex justify-content-center">
                    <a href="{{ route('promociones') }}" class="btn btn-secondary mb-3 w-25">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection