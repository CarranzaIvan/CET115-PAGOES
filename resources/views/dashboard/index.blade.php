@extends('dashboard.layout.app_dashboard')

@section('title', 'Administrador')

@section('content')

<div class="container-fluid">
    <h3 class="text-primary font-w600">Bienvenido, Administrador</h3>
    <p class="mb-4">Aquí puedes gestionar las principales funciones del sistema y ver estadísticas clave.</p>

    <!-- Estadísticas Resumidas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card text-center bg-light mb-4">
                <div class="card-body">
                    <h5 class="card-title">Usuarios Registrados</h5>
                    <p class="card-text display-4">{{ \App\Models\Usuario::count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card text-center bg-light mb-4">
                <div class="card-body">
                    <h5 class="card-title">Citas Reservadas</h5>
                    <p class="card-text display-4">{{ \App\Models\Citas\Cita::count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card text-center bg-light mb-4">
                <div class="card-body">
                    <h5 class="card-title">Servicios Activos</h5>
                    <p class="card-text display-4">{{ \App\Models\Servicio::count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card text-center bg-light mb-4">
                <div class="card-body">
                    <h5 class="card-title">Promociones Disponibles</h5>
                    <p class="card-text display-4">{{ \App\Models\Promocion::count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Citas Recientes y Accesos Rápidos -->
    <div class="row">
        <!-- Citas Recientes -->
        <div class="col-lg-8 col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Citas Recientes</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Servicio</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Citas\Cita::orderBy('fecha_cita', 'desc')->limit(5)->get() as $cita)
                            <tr>
                                <td>{{ $cita->usuario->nombre_completo }}</td>
                                <td>{{ $cita->servicio->nomServicio }}</td>
                                <td>{{ \Carbon\Carbon::parse($cita->fecha_cita)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge {{ $cita->estado == 'completada' ? 'bg-success' : ($cita->estado == 'pendiente' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ ucfirst($cita->estado) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Accesos Rápidos -->
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Accesos Rápidos</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('registrar_cita') }}" class="btn btn-warning btn-block mb-2">Ir al calendario</a>
                    <a href="{{ route('dashboard.citas.index') }}" class="btn btn-primary btn-block mb-2">Gestionar Citas</a>
                    <a href="{{ route('promociones') }}" class="btn btn-success btn-block mb-2">Gestionar Promociones</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection