@extends('dashboard.layout.app_dashboard')

@section('title', 'Ver Cita')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header" style="background-color: #0D5C75;">
                <h4 class="card-title text-white">Ver Cita</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usuario"><strong>Usuario</strong></label>
                            <p id="usuario">{{ $cita->usuario->name ?? 'Usuario no disponible' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="servicio"><strong>Nombre del Servicio</strong></label>
                            <p id="servicio">{{ $cita->servicio->nomServicio ?? 'Servicio no disponible' }}</p>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_cita"><strong>Fecha de la Cita</strong></label>
                            <p id="fecha_cita">{{ $cita->fecha_cita }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hora_cita"><strong>Hora de la Cita</strong></label>
                            <p id="hora_cita">{{ $cita->hora_cita }}</p>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="estado"><strong>Estado de la Cita</strong></label>
                            <p id="estado">{{ $cita->estado }}</p>
                        </div>
                    </div>
                </div>
                <br>
                <div class="d-flex justify-content-center">
                    <a href="{{ route('dashboard.citas.index') }}" class="btn btn-secondary mb-3 w-25">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
